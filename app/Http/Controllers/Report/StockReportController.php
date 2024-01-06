<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\ponno_purchase_entry;
use App\Models\ponno_sales_entry;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\stock;
use App\Models\ponno_setup;


class StockReportController extends Controller
{
    public function index()
    {
        $ponno_setup = ponno_setup::select('id','ponno_name')->get();
        return view('user.report.stock_report.index',compact('ponno_setup'));
    }

    public function search(Request $request)
    {
        if($request->entry_date && $request->ponno_setup_id == 0)
        {
            $entry_date =  Carbon::createFromFormat('d-m-Y', $request->entry_date)->format('Y-m-d');
            $stock = Stock::with('ponno_purchase_entry')
            ->join('ponno_purchase_entries', 'ponno_purchase_entries.id', '=', 'stocks.purchase_id')
            ->where('ponno_purchase_entries.entry_date', '<=', $entry_date)
            ->orderBy('ponno_purchase_entries.ponno_setup_id', 'ASC')
            ->orderBy('stocks.purchase_id', 'DESC')
            ->get();

            // $stock = stock::with('ponno_purchase_entry')->whereHas('ponno_purchase_entry',function($query) use($entry_date){
            //     $query->where('entry_date','<=',[$entry_date]);
            // })->orderBy('purchase_id','DESC')->get();

            $date = $request->entry_date;
            $viewContent = view('user.report.stock_report.date_table', compact('stock','date'))->render();
            return response()->json(['viewContent' => $viewContent]);
        }
        else if($request->ponno_setup_id == 0)
        {
            $stock = stock::orderBy('purchase_id','DESC')->get();
            $viewContent = view('user.report.stock_report.all_table', compact('stock'))->render();
            return response()->json(['viewContent' => $viewContent]);

        }
        else if($request->ponno_setup_id > 0)
        {
            $id = $request->ponno_setup_id;
            $stock = stock::with('ponno_purchase_entry')
            ->whereHas('ponno_purchase_entry',function($query) use($id){
                $query->whereIn('ponno_setup_id',[$id]);
                })->orderBy('purchase_id','DESC')->get();
                
            $viewContent = view('user.report.stock_report.all_table', compact('stock'))->render();
            return response()->json(['viewContent' => $viewContent]);
        }

        
    }
}
