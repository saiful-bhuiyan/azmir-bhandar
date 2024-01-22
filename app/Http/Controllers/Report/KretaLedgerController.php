<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\kreta_setup;
use App\Models\kreta_joma_entry;
use App\Models\kreta_koifiyot_entry;
use App\Models\ponno_sales_info;

class KretaLedgerController extends Controller
{
    public function index()
    {
        $kreta_setup = kreta_setup::select('area')->groupBy('area')->get();
        return view('user.report.kreta_ledger.index',compact('kreta_setup'));
    }

    public function search(Request $request)
    {
        if($request->date_from =="" && $request->date_to == "")
        {
            
            $kreta = kreta_setup::where('id',$request->kreta_setup_id)->first();
            $sales = ponno_sales_info::where('kreta_setup_id',$request->kreta_setup_id)->get();
            $joma = kreta_joma_entry::where('kreta_setup_id',$request->kreta_setup_id)->get();
            $koifiyot = kreta_koifiyot_entry::where('kreta_setup_id',$request->kreta_setup_id)->get();

            /********* Adding Row to array ***********/

            $i = 0;
            $record = array();

            foreach($sales as $v)
            {
                $i++;
                $record[$i] = array(
                    'table' => 1,
                    'id' => $v->id,
                    'payment' => 'বাকি',
                    'marfot' => $v->bikroy_marfot_setup->marfot_name,
                    'joma'=> '-',
                    'khoroc'=> $v->total_taka,
                    'total_taka' => '-',
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }

            foreach($joma as $v)
            {
                $i++;
                $payment = '';
                if($v->payment_by == 1){
                    $payment = 'ক্যাশ';
                }else if($v->payment_by == 2){
                    $payment = $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4);  
                }
                $record[$i] = array(
                    'table' => 2,
                    'id'=>$v->id."/ ক্রেতার জমা",
                    'payment'=> $payment,
                    'marfot'=>$v->marfot,
                    'joma'=>$v->taka,
                    'khoroc'=>'-',
                    'total_taka'=>'-',
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
           
            }

            foreach($koifiyot as $v)
            {
                $i++;
                $record[$i] = array(
                    'table' => 3,
                    'id'=>$v->id."/ কৈফিয়ত",
                    'payment'=> 'ক্যাশ',
                    'marfot'=>$v->marfot,
                    'joma'=>$v->taka,
                    'khoroc'=>'-',
                    'total_taka'=>'-',
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }

            usort($record, function($a, $b) { return $a['entry_date'] <=> $b['entry_date']; });
                

            $viewContent = view('user.report.kreta_ledger.all_table', compact('kreta'))->with('record', $record)->render();

            return response()->json(['viewContent' => $viewContent]);

            //return view('user.report.kreta_ledger.date_table',compact('total_due'))->with('record',$record);
        }
        else if($request->date_from !="" && $request->date_to != "")
        {
  
            $date_from = Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d');
            $date_to = Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');

            $old_sales = ponno_sales_info::where('entry_date' ,"<", $date_from)->where('kreta_setup_id',$request->kreta_setup_id)->sum('total_taka');
            $old_joma = kreta_joma_entry::where('entry_date' ,"<", $date_from)->where('kreta_setup_id',$request->kreta_setup_id)->sum('taka');
            $old_koifiyot = kreta_koifiyot_entry::where('entry_date' ,"<", $date_from)->where('kreta_setup_id',$request->kreta_setup_id)->sum('taka');
            
            $kreta = kreta_setup::where('id',$request->kreta_setup_id)->first();

            $total_due = $kreta->old_amount ? $kreta->old_amount : 0;
            $total_due += $old_sales;
            $total_due -= $old_joma;
            $total_due -= $old_koifiyot;
            
            $sales = ponno_sales_info::whereBetween('entry_date',[$date_from, $date_to])->where('kreta_setup_id',$request->kreta_setup_id)->get();
            $joma = kreta_joma_entry::whereBetween('entry_date',[$date_from, $date_to])->where('kreta_setup_id',$request->kreta_setup_id)->get();
            $koifiyot = kreta_koifiyot_entry::whereBetween('entry_date',[$date_from, $date_to])->where('kreta_setup_id',$request->kreta_setup_id)->get();

            /********* Adding Row to array ***********/

            $i = 0;
            $record = array();

            foreach($sales as $v)
            {
                $i++;
                $record[$i] = array(
                    'table' => 1,
                    'id' => $v->id,
                    'payment' => 'বাকি',
                    'marfot' => $v->bikroy_marfot_setup->marfot_name,
                    'joma'=> '-',
                    'khoroc'=> $v->total_taka,
                    'total_taka' => '-',
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }

            foreach($joma as $v)
            {
                $i++;
                $payment = '';
                if($v->payment_by == 1){
                    $payment = 'ক্যাশ';
                }else if($v->payment_by == 2){
                    $payment = $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4);  
                }
                $record[$i] = array(
                    'table' => 2,
                    'id'=>$v->id."/ ক্রেতার জমা",
                    'payment'=> $payment,
                    'marfot'=>$v->marfot,
                    'joma'=>$v->taka,
                    'khoroc'=>'-',
                    'total_taka'=>'-',
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
           
            }

            foreach($koifiyot as $v)
            {
                $i++;
                $record[$i] = array(
                    'table' => 3,
                    'id'=>$v->id."/ কৈফিয়ত",
                    'payment'=> 'ক্যাশ',
                    'marfot'=>$v->marfot,
                    'joma'=>$v->taka,
                    'khoroc'=>'-',
                    'total_taka'=>'-',
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }

            usort($record, function($a, $b) { return $a['entry_date'] <=> $b['entry_date']; });

            $viewContent = view('user.report.kreta_ledger.date_table', compact('total_due','kreta','request'))->with('record', $record)->render();

            return response()->json(['viewContent' => $viewContent]);

            //return view('user.report.kreta_ledger.date_table',compact('total_due'))->with('record',$record);
        }
        else
        {
            return redirect()->back();
        }

    }
    
    
}
