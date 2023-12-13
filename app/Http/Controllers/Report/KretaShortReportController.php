<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\kreta_setup;
use App\Models\kreta_joma_entry;
use App\Models\kreta_koifiyot_entry;
use App\Models\ponno_sales_info;

class KretaShortReportController extends Controller
{
    public function index()
    {
        $i = 0;
        $record = array();
        $kreta = kreta_setup::get();
            
            foreach($kreta as $v)
            {
                $kreta_setup_id = $v->id;
                $total_taka = 0;

                $sales = ponno_sales_info::with('ponno_sales_entry')->whereHas('ponno_sales_entry',function($query) use($kreta_setup_id){
                    $query->whereHas('ponno_purchase_entry',function($query2) use($kreta_setup_id){
                        $query2->whereIn('kreta_setup_id',[$kreta_setup_id]);
                    });
                })->where('sales_type',2)->sum('total_taka');

                $joma = kreta_joma_entry::where('kreta_setup_id',$kreta_setup_id)->sum('taka');
                $koifiyot = kreta_koifiyot_entry::where('kreta_setup_id',$kreta_setup_id)->sum('taka');

                $total_taka += $v->old_amount;
                $total_taka += $sales;
                $total_taka -= $joma;
                $total_taka -= $koifiyot;

                /********* Adding Row to array ***********/

                $i++;
                $record[$i] = array(
                    'id' => $v->id,
                    'area' => $v->area,
                    'address' => $v->address,
                    'name'=> $v->name,
                    'mobile'=> $v->mobile,
                    'total_taka' => $total_taka,
                );
                
            }

            return view('user.report.kreta_short_report.index', compact('kreta'))->with('record', $record);

    }
}
