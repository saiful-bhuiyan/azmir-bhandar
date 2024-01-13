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
use App\Models\kreta_koifiyot_entry;
use App\Models\ponno_purchase_cost_entry;

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

        $kreta_joma_cash = kreta_joma_entry::where('entry_date',$entry_date)->where('payment_by',1)->sum('taka');
        $kreta_joma_bank = kreta_joma_entry::where('entry_date',$entry_date)->where('payment_by',2)->sum('taka');

        $mohajon_return_cash = mohajon_return_entry::where('entry_date',$entry_date)->where('payment_by',1)->sum('taka');
        $mohajon_return_bank = mohajon_return_entry::where('entry_date',$entry_date)->where('payment_by',2)->sum('taka');

        $amanot_joma_cash = amanot_entry::where('entry_date',$entry_date)->where('type',1)->where('payment_by',1)->sum('taka');
        $amanot_joma_bank= amanot_entry::where('entry_date',$entry_date)->where('type',1)->where('payment_by',2)->sum('taka');

        $hawlat_joma_cash = hawlat_entry::where('entry_date',$entry_date)->where('type',1)->where('payment_by',1)->sum('taka');
        $hawlat_joma_bank = hawlat_entry::where('entry_date',$entry_date)->where('type',1)->where('payment_by',2)->sum('taka');

        $other_joma_cash = other_joma_khoroc_entry::where('entry_date',$entry_date)->where('type',1)->where('payment_by',1)->sum('taka');
        $other_joma_bank = other_joma_khoroc_entry::where('entry_date',$entry_date)->where('type',1)->where('payment_by',2)->sum('taka');

        /************* খরচ ***************/

        $mohajon_payment_cash = mohajon_payment_entry::where('entry_date',$entry_date)->where('payment_by',1)->sum('taka');
        $mohajon_payment_bank = mohajon_payment_entry::where('entry_date',$entry_date)->where('payment_by',2)->sum('taka');

        $bank_joma = bank_entry::where('entry_date',$entry_date)->where('type',1)->sum('taka');

        $amanot_khoroc_cash = amanot_entry::where('entry_date',$entry_date)->where('type',2)->where('payment_by',1)->sum('taka');
        $amanot_khoroc_bank = amanot_entry::where('entry_date',$entry_date)->where('type',2)->where('payment_by',2)->sum('taka');

        $hawlat_khoroc_cash = hawlat_entry::where('entry_date',$entry_date)->where('type',2)->where('payment_by',1)->sum('taka');
        $hawlat_khoroc_bank = hawlat_entry::where('entry_date',$entry_date)->where('type',2)->where('payment_by',2)->sum('taka');

        $other_khoroc_cash = other_joma_khoroc_entry::where('entry_date',$entry_date)->where('type',2)->where('payment_by',1)->sum('taka');
        $other_khoroc_bank = other_joma_khoroc_entry::where('entry_date',$entry_date)->where('type',2)->where('payment_by',2)->sum('taka');

        $labour_cost = ponno_purchase_entry::where('cost_date',$entry_date)->sum('labour_cost');
        $other_cost = ponno_purchase_entry::where('cost_date',$entry_date)->sum('other_cost');
        $truck_cost = ponno_purchase_entry::where('cost_date',$entry_date)->sum('truck_cost');
        $van_cost = ponno_purchase_entry::where('cost_date',$entry_date)->sum('van_cost');
        $tohori_cost = ponno_purchase_entry::where('cost_date',$entry_date)->sum('tohori_cost');
        
        $sales_costs = ponno_sales_info::where('entry_date',$entry_date)->get();

        $ponno_cost = ponno_purchase_cost_entry::where('entry_date',$entry_date)->sum('taka');

        $total_labour = 0;
        $total_other_cost = 0;
        $total_other_cost += $other_cost + $truck_cost + $van_cost + $tohori_cost + $labour_cost + $ponno_cost;
        foreach($sales_costs as $v)
        {
            $total_labour += ponno_sales_entry::where('sales_invoice',$v->id)->sum('labour');
            $total_labour += ponno_sales_entry::where('sales_invoice',$v->id)->sum('other');
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
        if($cash_transfer){
            $ref_date = date('d-m-Y', strtotime($cash_transfer->reference_date));
        }else{
            $ref_date = "";
        }
        
        $joma[$i] = array(
            'sl' => $count_joma++,
            'reference' => "সাবেক (".$ref_date.")",
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
            'total_taka' => $bank_uttolon + $amanot_khoroc_bank + $hawlat_khoroc_bank + $other_khoroc_bank + $mohajon_payment_bank,
        );

        /************* ক্রেতা জমা ***************/     
        
        $i++;

        $joma[$i] = array(
            'sl' => $count_joma++,
            'reference' => "ক্রেতা জমা",
            'total_taka' => $kreta_joma_cash + $kreta_joma_bank,
        );

        /************* মহাজন ফেরত ***************/     
        
        $i++;

        $joma[$i] = array(
            'sl' => $count_joma++,
            'reference' => "মহাজন ফেরত",
            'total_taka' => $mohajon_return_cash + $mohajon_return_bank,
        );

        /************* আমানত জমা ***************/     
        
        $i++;

        $joma[$i] = array(
            'sl' => $count_joma++,
            'reference' => "আমানত জমা",
            'total_taka' => $amanot_joma_cash + $amanot_joma_bank,
        );

        /************* হাওলাত জমা ***************/     
        
        $i++;

        $joma[$i] = array(
            'sl' => $count_joma++,
            'reference' => "হাওলাত জমা",
            'total_taka' => $hawlat_joma_cash + $hawlat_joma_bank,
        );

        /************* অন্যান্য জমা ***************/     
        
        $i++;

        $joma[$i] = array(
            'sl' => $count_joma++,
            'reference' => "অন্যান্য জমা",
            'total_taka' => $other_joma_cash + $other_joma_bank,
        );
        

        /************************************** খরচ ************************************/


        /************* ব্যাংক জমা ***************/     
        
        $j++;

        $khoroc[$j] = array(
            'sl' => $count_khoroc++,
            'reference' => "ব্যাংক জমা",
            'total_taka' => $bank_joma + $kreta_joma_bank + $amanot_joma_bank + $hawlat_joma_bank + $other_joma_bank + $mohajon_return_bank ,
        );

        /************* মহাজন পেমেন্ট ***************/     
        
        $j++;

        $khoroc[$j] = array(
            'sl' => $count_khoroc++,
            'reference' => "মহাজন পেমেন্ট",
            'total_taka' => $mohajon_payment_cash + $mohajon_payment_bank,
        );


        /************* আমানত খরচ ***************/     
        
        $j++;

        $khoroc[$j] = array(
            'sl' => $count_khoroc++,
            'reference' => "আমানত খরচ",
            'total_taka' => $amanot_khoroc_cash + $amanot_khoroc_bank,
        );

        /************* হাওলাত খরচ ***************/     
        
        $j++;

        $khoroc[$j] = array(
            'sl' => $count_khoroc++,
            'reference' => "হাওলাত খরচ",
            'total_taka' => $hawlat_khoroc_cash + $hawlat_khoroc_bank,
        );

        /************* অন্যান্য খরচ ***************/     
        
        $j++;

        $khoroc[$j] = array(
            'sl' => $count_khoroc++,
            'reference' => "অন্যান্য খরচ",
            'total_taka' => $other_khoroc_cash + $other_khoroc_bank,
        );

        /************* লেবার খরচ ***************/     
        
        $j++;

        $khoroc[$j] = array(
            'sl' => $count_khoroc++,
            'reference' => "বিক্রয় লেবার খরচ",
            'total_taka' => $total_labour,
        );

        /************* পন্য গ্রহণ খরচ ***************/     
        
        $j++;

        $khoroc[$j] = array(
            'sl' => $count_khoroc++,
            'reference' => "পন্য গ্রহণ খরচ",
            'total_taka' => $total_other_cost,
        );

        $viewContent = view('user.report.cash_report.short_table')->with('search_date',$search_date)->with('joma', $joma)->with('khoroc',$khoroc)->render();

        return response()->json(['viewContent' => $viewContent]);

        
    }

    public function searchByJoma($search_date)
    {
        $entry_date = Carbon::createFromFormat('d-m-Y', $search_date)->format('Y-m-d');

        $cash_transfer = cash_transfer::where('date',$entry_date)->first();
        
        $cash_sales = ponno_sales_info::where('entry_date',$entry_date)->where('sales_type',1)->get();
        $bank_uttolon = bank_entry::where('entry_date',$entry_date)->where('type',2)->get();
        $kreta_joma = kreta_joma_entry::where('entry_date',$entry_date)->get();
        $mohajon_payment = mohajon_payment_entry::where('entry_date',$entry_date)->get();
        $mohajon_return = mohajon_return_entry::where('entry_date',$entry_date)->get();
        $amanot = amanot_entry::where('entry_date',$entry_date)->get();
        $hawlat = hawlat_entry::where('entry_date',$entry_date)->get();
        $other = other_joma_khoroc_entry::where('entry_date',$entry_date)->get();

        return view('user.report.cash_report.all_joma',compact('cash_sales','bank_uttolon','kreta_joma','mohajon_return','amanot','hawlat','other','cash_transfer','mohajon_payment','search_date'));
    }

    public function searchByKhoroc($search_date)
    {
        $entry_date = Carbon::createFromFormat('d-m-Y', $search_date)->format('Y-m-d');

        $bank_joma = bank_entry::where('entry_date',$entry_date)->where('type',1)->get();
        $kreta_joma = kreta_joma_entry::where('entry_date',$entry_date)->get();
        $mohajon_payment = mohajon_payment_entry::where('entry_date',$entry_date)->get();
        $mohajon_return = mohajon_return_entry::where('entry_date',$entry_date)->get();
        $amanot = amanot_entry::where('entry_date',$entry_date)->get();
        $hawlat = hawlat_entry::where('entry_date',$entry_date)->get();
        $other = other_joma_khoroc_entry::where('entry_date',$entry_date)->get();
        $sales_costs = ponno_sales_info::where('entry_date',$entry_date)->get();

        
        $labour_cost = ponno_purchase_entry::where('cost_date',$entry_date)->sum('labour_cost');
        $other_cost = ponno_purchase_entry::where('cost_date',$entry_date)->sum('other_cost');
        $truck_cost = ponno_purchase_entry::where('cost_date',$entry_date)->sum('truck_cost');
        $van_cost = ponno_purchase_entry::where('cost_date',$entry_date)->sum('van_cost');
        $tohori_cost = ponno_purchase_entry::where('cost_date',$entry_date)->sum('tohori_cost');

        $ponno_cost = ponno_purchase_cost_entry::where('entry_date',$entry_date)->sum('taka');

        $total_labour = 0;
        $total_purchase_cost = $labour_cost + $other_cost + $truck_cost + $van_cost + $tohori_cost + $ponno_cost;

        foreach($sales_costs as $v)
        {
            $total_labour += ponno_sales_entry::where('sales_invoice',$v->id)->sum('labour');
            $total_labour += ponno_sales_entry::where('sales_invoice',$v->id)->sum('other');
        }

        return view('user.report.cash_report.all_khoroc',compact('bank_joma','kreta_joma','mohajon_payment','mohajon_return','amanot','hawlat','other','total_labour','total_purchase_cost','search_date'));
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
