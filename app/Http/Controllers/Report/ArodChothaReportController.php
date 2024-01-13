<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\arod_chotha_entry;
use App\Models\arod_chotha_info;
use App\Models\ponno_purchase_entry;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArodChothaReportController extends Controller
{
    public function index()
    {
        return view('user.report.arod_chotha_report.index');
    }

    public function search(Request $request)
    {
        if($request->date_from !="" && $request->date_to != "")
        {
            $date_from = Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d');
            $date_to = Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');

            $arod_chotha_info = arod_chotha_info::whereBetween('entry_date',[$date_from, $date_to])->get();

            $i = 0;
            $record = array();
            foreach($arod_chotha_info as $v)
            {
                $purchase = ponno_purchase_entry::find($v->purchase_id);
                $arod_chotha_qty = arod_chotha_entry::where('purchase_id',$v->purchase_id)->sum('sales_qty');

                if($purchase->quantity == $arod_chotha_qty)
                {
                    $sales = arod_chotha_entry::where('purchase_id', $v->purchase_id)->get(); 

                    $total_sale = 0;
                    $total_sale_qty = 0;
                    $total_mohajon_commission = 0;

                    foreach($sales as $s){
                        $total_sale += $s->sales_weight * $s->sales_rate;
                        $total_sale_qty += $s->sales_qty;
                        $total_mohajon_commission += $purchase->mohajon_commission * $s->sales_weight;

                    }

                    $total_cost = $total_mohajon_commission + $v->labour_cost + $v->truck_cost +
                            $v->van_cost + $v->other_cost + $v->tohori_cost;
                    $total_taka = $total_sale - $total_cost;

                    $i++;
                    $record[$i] = array(
                        'purchase_id' => $v->purchase_id,
                        'area' => $purchase->mohajon_setup->area,
                        'address' => $purchase->mohajon_setup->address,
                        'name' => $purchase->mohajon_setup->name,
                        'ponno_info' => $purchase->ponno_setup->ponno_name.'/'.$purchase->quantity,
                        'marfot' => $purchase->marfot,
                        'taka'=> $total_taka,
                        'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                    );
                }
            }
            usort($record, function($a, $b) { return $a['entry_date'] <=> $b['entry_date']; });
                    
            $viewContent = view('user.report.arod_chotha_report.date_table',compact('request'))->with('record', $record)->render();

            return response()->json(['viewContent' => $viewContent]);
        }
    }
}
