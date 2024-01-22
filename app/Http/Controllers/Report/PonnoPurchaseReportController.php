<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\mohajon_commission_setup;
use App\Models\ponno_purchase_cost_entry;
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
        $sales = ponno_sales_entry::where('purchase_id', $purchase->id)->orderBy('sales_rate','DESC')->get(); 
        $short_sales = ponno_sales_entry::selectRaw('SUM(sales_qty) as sales_qty, SUM(sales_weight) as sales_weight, sales_rate')
        ->where('purchase_id', $purchase->id)->groupBy('sales_rate')->orderBy('sales_rate', 'DESC')->get();
        
        $labour_cost = 0;
        $other_cost = 0;
        $truck_cost = 0;
        $van_cost = 0;
        $tohori_cost = 0;
        $ponno_cost = ponno_purchase_cost_entry::where('purchase_id',$id)->get();
        foreach($ponno_cost as $v)
        {
            if($v->cost_name == 1){
                 $labour_cost += $v->taka;
            }else if($v->cost_name == 2){
                $other_cost += $v->taka;
            }else if($v->cost_name == 3){
                $truck_cost += $v->taka;
            }else if($v->cost_name == 4){
                $van_cost += $v->taka;
            }else if($v->cost_name == 5){
                $tohori_cost += $v->taka;
            }
        }
        
        return view('user.report.ponno_purchase_report.purchase_memo',compact('purchase','sales','short_sales','labour_cost','other_cost','truck_cost','van_cost','tohori_cost'));
    }
    
}
