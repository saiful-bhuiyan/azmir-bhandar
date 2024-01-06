<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\mohajon_commission_setup;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ponno_purchase_entry;
use App\Models\ponno_sales_entry;

class PonnoPurchaseReportController extends Controller
{
    public function ponno_purchase_report()
    {
        return view('user.report.ponno_purchase_report.index');
    }

    public function searchPurchaseReport(Request $request)
    {
        $date_from = Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d');
        $date_to = Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');
        $purchase_type = $request->purchase_type;        

        if($purchase_type == 3)
        {
            $purchase = ponno_purchase_entry::whereBetween('entry_date',[$date_from, $date_to])->get();

            $viewContent = view('user.report.ponno_purchase_report.all_table', compact('purchase','purchase_type'))->render();

            return response()->json(['viewContent' => $viewContent]);
           
        }
        else if($purchase_type == 1 or 2)
        {
            $purchase = ponno_purchase_entry::where('purchase_type',$purchase_type)->whereBetween('entry_date',[$date_from, $date_to])->get();

            $viewContent = view('user.report.ponno_purchase_report.type_table', compact('purchase','purchase_type'))->render();

            return response()->json(['viewContent' => $viewContent]);  
        }
        else
        {
            return redirect()->back();
        }

    }

    public function purchase_memo($id)
    {
        $purchase = ponno_purchase_entry::where('id',$id)->first();
        $sales = ponno_sales_entry::where('purchase_id', $purchase->id)->get(); 
        
        return view('user.report.ponno_purchase_report.purchase_memo',compact('purchase','sales'));
    }
    
}
