<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\ponno_sales_entry;
use App\Models\ponno_sales_info;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyCommissionReportController extends Controller
{
    public function index()
    {
        return view('user.report.daily_commission_report.index');
    }

    public function search(Request $request)
    {
        $date_from = Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d');
        $date_to = Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');

        $i = 0;
        $record = array();
        if($request->commission_name == 1) 
        {
            

            $sales_date = ponno_sales_info::select('entry_date')->whereBetween('entry_date',[$date_from, $date_to])->groupBy('entry_date')->get();

            foreach($sales_date as $v)
            {
                $total = 0;
                $commission = 0;
                $date = $v->entry_date;
                $sales_info = ponno_sales_info::where('entry_date',$date)->get();
                foreach($sales_info as $s)
                {
                     $commission += ponno_sales_entry::where('sales_invoice',$s->id)->sum('kreta_commission');
                }
                $total += $commission;
                $i++;
                $record[$i] = array(
                    'sl' => $i,
                    'commission_total' => $total ? $total : 0,
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            }
            $viewContent = view('user.report.daily_commission_report.kreta_table',compact('request'))->with('record', $record)->render();

            return response()->json(['viewContent' => $viewContent]);
        }
        else if($request->commission_name == 2)
        {
            $sales_date = ponno_sales_info::select('entry_date')->whereBetween('entry_date',[$date_from, $date_to])->groupBy('entry_date')->get();

            foreach($sales_date as $v)
            {
                $total = 0;
                $commission = 0;
                $date = $v->entry_date;
                $sales_info = ponno_sales_info::where('entry_date',$date)->get();
                
                foreach($sales_info as $s)
                {
                    $sales_invo = $s->id;
                    $sales =  ponno_sales_entry::where('sales_invoice',$s->id)->get();
                    foreach($sales as $p){
                        $mohajon_commission_per_kg = $p->ponno_purchase_entry->ponno_setup->mohajon_commission_setup->commission_amount;
                        $commission += $mohajon_commission_per_kg * $p->sales_weight;
                    }
                     
                }
                $total += $commission;
                $i++;
                $record[$i] = array(
                    'sl' => $i,
                    'commission_total' => $total ? $total : 0,
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            }

            $viewContent = view('user.report.daily_commission_report.mohajon_table',compact('request'))->with('record', $record)->render();

            return response()->json(['viewContent' => $viewContent]);
        }
    }
}
