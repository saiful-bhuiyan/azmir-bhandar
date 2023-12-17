<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\ponno_sales_info;
use App\Models\bank_entry;
use App\Models\kreta_joma_entry;
use App\Models\mohajon_payment_entry;
use App\Models\mohajon_return_entry;
use App\Models\amanot_entry;
use App\Models\hawlat_entry;
use App\Models\other_joma_khoroc_entry;
use App\Models\ponno_purchase_entry;
use App\Models\ponno_sales_entry;
use App\Models\cash_transfer;

class CashReportController extends Controller
{
    public function index()
    {
        return view('user.report.cash_report.index');
    }

    public function search(Request $request)
    {
        $entry_date = Carbon::createFromFormat('d-m-Y', $request->entry_date)->format('Y-m-d');

        $search_date = $request->entry_date;

        /************* জমা ***************/

        $cash_transfer = cash_transfer::where('date',$entry_date)->first();
        if($cash_transfer){
            $old_cash_amount = $cash_transfer->amount;;
        }else{
            $old_cash_amount = 0;
        }

        $cash_sales = ponno_sales_info::where('entry_date',$entry_date)->where('sales_type',1)->sum('total_taka');
        $bank_uttolon = bank_entry::where('entry_date',$entry_date)->where('type',2)->sum('taka');
        $kreta_joma = kreta_joma_entry::where('entry_date',$entry_date)->sum('taka');
        $mohajon_return = mohajon_return_entry::where('entry_date',$entry_date)->sum('taka');
        $amanot_joma = amanot_entry::where('entry_date',$entry_date)->where('type',1)->sum('taka');
        $hawlat_joma = hawlat_entry::where('entry_date',$entry_date)->where('type',1)->sum('taka');
        $other_joma = other_joma_khoroc_entry::where('entry_date',$entry_date)->where('type',1)->sum('taka');

        /************* খরচ ***************/

        $mohajon_payment = mohajon_payment_entry::where('entry_date',$entry_date)->sum('taka');
        $bank_joma = bank_entry::where('entry_date',$entry_date)->where('type',1)->sum('taka');
        $amanot_khoroc = amanot_entry::where('entry_date',$entry_date)->where('type',2)->sum('taka');
        $hawlat_khoroc = hawlat_entry::where('entry_date',$entry_date)->where('type',2)->sum('taka');
        $other_khoroc = other_joma_khoroc_entry::where('entry_date',$entry_date)->where('type',2)->sum('taka');
        $labour_cost = ponno_purchase_entry::where('entry_date',$entry_date)->sum('labour_cost');
        $sales_costs = ponno_sales_info::where('entry_date',$entry_date)->get();

        $total_labour = 0;
        $total_other_cost = 0;
        $total_labour += $labour_cost;

        foreach($sales_costs as $v)
        {
            $total_labour += ponno_sales_entry::where('sales_invoice',$v->id)->sum('labour');
            $total_other_cost += ponno_sales_entry::where('sales_invoice',$v->id)->sum('other');
        }

        /********* Adding Row to array ***********/

        $count_joma = 1;
        $count_khoroc = 1;
        $i = 0;
        $j = 0;
        $joma = array();
        $khoroc = array();

        /************************************** জমা ************************************/

        /************* সাবেক ক্যাশ ***************/     
        
        $i++;

        $joma[$i] = array(
            'sl' => $count_joma++,
            'reference' => "সাবেক",
            'total_taka' => $old_cash_amount,
        );

        /************* পন্য বিক্রয় ***************/     
        
        $i++;

        $joma[$i] = array(
            'sl' => $count_joma++,
            'reference' => "নগদ বিক্রয়",
            'total_taka' => $cash_sales,
        );

        /************* ব্যাংক উত্তোলন ***************/     
        
        $i++;

        $joma[$i] = array(
            'sl' => $count_joma++,
            'reference' => "ব্যাংক উত্তোলন",
            'total_taka' => $bank_uttolon,
        );

        /************* ক্রেতা জমা ***************/     
        
        $i++;

        $joma[$i] = array(
            'sl' => $count_joma++,
            'reference' => "ক্রেতা জমা",
            'total_taka' => $kreta_joma,
        );

        /************* মহাজন ফেরত ***************/     
        
        $i++;

        $joma[$i] = array(
            'sl' => $count_joma++,
            'reference' => "মহাজন ফেরত",
            'total_taka' => $mohajon_return,
        );

        /************* আমানত জমা ***************/     
        
        $i++;

        $joma[$i] = array(
            'sl' => $count_joma++,
            'reference' => "আমানত জমা",
            'total_taka' => $amanot_joma,
        );

        /************* হাওলাত জমা ***************/     
        
        $i++;

        $joma[$i] = array(
            'sl' => $count_joma++,
            'reference' => "হাওলাত জমা",
            'total_taka' => $hawlat_joma,
        );

        /************* অন্যান্য জমা ***************/     
        
        $i++;

        $joma[$i] = array(
            'sl' => $count_joma++,
            'reference' => "অন্যান্য জমা",
            'total_taka' => $other_joma,
        );
        

        /************************************** খরচ ************************************/


        /************* ব্যাংক জমা ***************/     
        
        $j++;

        $khoroc[$j] = array(
            'sl' => $count_khoroc++,
            'reference' => "ব্যাংক জমা",
            'total_taka' => $bank_joma,
        );

        /************* মহাজন পেমেন্ট ***************/     
        
        $j++;

        $khoroc[$j] = array(
            'sl' => $count_khoroc++,
            'reference' => "মহাজন পেমেন্ট",
            'total_taka' => $mohajon_payment,
        );


        /************* আমানত খরচ ***************/     
        
        $j++;

        $khoroc[$j] = array(
            'sl' => $count_khoroc++,
            'reference' => "আমানত খরচ",
            'total_taka' => $amanot_khoroc,
        );

        /************* হাওলাত খরচ ***************/     
        
        $j++;

        $khoroc[$j] = array(
            'sl' => $count_khoroc++,
            'reference' => "হাওলাত খরচ",
            'total_taka' => $hawlat_khoroc,
        );

        /************* অন্যান্য খরচ ***************/     
        
        $j++;

        $khoroc[$j] = array(
            'sl' => $count_khoroc++,
            'reference' => "অন্যান্য খরচ",
            'total_taka' => $other_khoroc,
        );

        /************* লেবার খরচ ***************/     
        
        $j++;

        $khoroc[$j] = array(
            'sl' => $count_khoroc++,
            'reference' => "লেবার খরচ",
            'total_taka' => $total_labour,
        );

        /************* অন্যান্য বিক্রি খরচ ***************/     
        
        $j++;

        $khoroc[$j] = array(
            'sl' => $count_khoroc++,
            'reference' => "অন্যান্য লেবার খরচ",
            'total_taka' => $total_other_cost,
        );

        $viewContent = view('user.report.cash_report.short_table')->with('search_date',$search_date)->with('joma', $joma)->with('khoroc',$khoroc)->render();

        return response()->json(['viewContent' => $viewContent]);

        
    }

    public function searchByJoma($search_date)
    {
        $entry_date = Carbon::createFromFormat('d-m-Y', $search_date)->format('Y-m-d');

        $cash_sales = ponno_sales_info::where('entry_date',$entry_date)->where('sales_type',1)->get();
        $bank_uttolon = bank_entry::where('entry_date',$entry_date)->where('type',2)->get();
        $kreta_joma = kreta_joma_entry::where('entry_date',$entry_date)->get();
        $mohajon_return = mohajon_return_entry::where('entry_date',$entry_date)->get();
        $amanot_joma = amanot_entry::where('entry_date',$entry_date)->where('type',1)->get();
        $hawlat_joma = hawlat_entry::where('entry_date',$entry_date)->where('type',1)->get();
        $other_joma = other_joma_khoroc_entry::where('entry_date',$entry_date)->where('type',1)->get();

        return view('user.report.cash_report.all_joma',compact('cash_sales','bank_uttolon','kreta_joma','mohajon_return','amanot_joma','hawlat_joma','other_joma','search_date'));
    }

    public function searchByKhoroc($search_date)
    {
        $entry_date = Carbon::createFromFormat('d-m-Y', $search_date)->format('Y-m-d');

        $bank_joma = bank_entry::where('entry_date',$entry_date)->where('type',1)->get();
        $mohajon_payment = mohajon_payment_entry::where('entry_date',$entry_date)->get();
        $amanot_khoroc = amanot_entry::where('entry_date',$entry_date)->where('type',2)->get();
        $hawlat_khoroc = hawlat_entry::where('entry_date',$entry_date)->where('type',2)->get();
        $other_khoroc = other_joma_khoroc_entry::where('entry_date',$entry_date)->where('type',2)->get();
        $labour_cost = ponno_purchase_entry::where('entry_date',$entry_date)->sum('labour_cost');
        $sales_costs = ponno_sales_info::where('entry_date',$entry_date)->get();

        $total_labour = 0;
        $total_other_cost = 0;
        $total_labour += $labour_cost;

        foreach($sales_costs as $v)
        {
            $total_labour += ponno_sales_entry::where('sales_invoice',$v->id)->sum('labour');
            $total_other_cost += ponno_sales_entry::where('sales_invoice',$v->id)->sum('other');
        }

        return view('user.report.cash_report.all_khoroc',compact('bank_joma','mohajon_payment','amanot_khoroc','hawlat_khoroc','other_khoroc','search_date'));
    }

    public function cash_transfer(Request $request)
    {
        $today = date("Y-m-d");
        $ref_date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
        $check = cash_transfer::where('date',$today)->first();
        if($check)
        {
            Toastr::error(__('পুর্বে ক্যাশ ট্রান্সফার করা হয়েছে'), __('ব্যর্থ'));
            return redirect()->back();
        }
        else
        {
            $data = array(
                'date'=>$today,
                'reference_date'=>$ref_date,
                'amount'=>$request->amount,
            );
    
    
    
            $insert = cash_transfer::create($data);
    
            if($insert)
            {
                Toastr::success(__('ক্যাশ ট্রান্সফার সফল হয়েছে'), __('সফল'));
            }
            else
            {
                Toastr::error(__('ক্যাশ ট্রান্সফার সফল হয়নি'), __('ব্যর্থ'));
            }
    
            return redirect()->back();
        }
        
    }
    
}
