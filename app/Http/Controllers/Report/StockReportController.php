<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
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
        if($request->ponno_setup_id == 0)
        {
            $stock = stock::where('quantity','!=',0)->get();
            $viewContent = view('user.report.stock_report.all_table', compact('stock'))->render();
            return response()->json(['viewContent' => $viewContent]);

        }
        else if($request->ponno_setup_id > 0)
        {
            $id = $request->ponno_setup_id;
            $stock = stock::with('ponno_purchase_entry')
            ->whereHas('ponno_purchase_entry',function($query) use($id){
                $query->whereIn('ponno_setup_id',[$id]);
                })->where('quantity','!=',0)->get();
                
            $viewContent = view('user.report.stock_report.all_table', compact('stock'))->render();
            return response()->json(['viewContent' => $viewContent]);
        }
    }
}
