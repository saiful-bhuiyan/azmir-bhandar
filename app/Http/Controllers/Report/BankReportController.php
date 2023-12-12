<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\bank_setup;
use App\Models\bank_entry;
use App\Models\kreta_joma_entry;
use App\Models\mohajon_payment_entry;
use App\Models\amanot_entry;
use App\Models\hawlat_entry;
use App\Models\other_joma_khoroc_entry;

class BankReportController extends Controller
{
    public function index()
    {
        $bank_setup = bank_setup::get();
        return view('user.report.bank_ledger.index',compact('bank_setup'));
    }

    public function search(Request $request)
    {
        if($request->date_from =="" && $request->date_to == "")
        {
            
            $bank_setup = bank_setup::where('id',$request->bank_setup_id)->first();
            $bank_entry = bank_entry::where('bank_setup_id',$request->bank_setup_id)->get();

            $kreta_joma_entry = kreta_joma_entry::where('bank_setup_id',$request->bank_setup_id)->get();
            $mohajon_payment_entry = mohajon_payment_entry::where('bank_setup_id',$request->bank_setup_id)->get();
            $amanot_entry = amanot_entry::where('bank_setup_id',$request->bank_setup_id)->get();
            $hawlat_entry = hawlat_entry::where('bank_setup_id',$request->bank_setup_id)->get();
            $other_joma_khoroc_entry = other_joma_khoroc_entry::where('bank_setup_id',$request->bank_setup_id)->get();

            /********* Adding Row to array ***********/

            $i = 0;
            $record = array();

            foreach($bank_entry as $v)
            {
                $i++;

                $record[$i] = array(
                    'type' => $v->type,
                    'id' => $v->id,
                    'reference' => "ব্যাংক উত্তোলন/জমা",
                    'check_id' => ($v->check_id > 0 ? $v->check_book_page_setup->page : "-"),
                    'bank_name' => $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4),
                    'marfot' => $v->marfot,
                    'joma'=> ($v->type==1 ? $v->taka : '-'),
                    'uttolon'=> ($v->type==2 ? $v->taka : '-'),
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }

            foreach($kreta_joma_entry as $v)
            {
                $i++;

                $record[$i] = array(
                    'type' => 1,
                    'id'=>$v->id,
                    'reference' => "ক্রেতার জমা",
                    'check_id' => "-",
                    'bank_name'=> $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4),
                    'marfot'=>$v->marfot,
                    'joma'=>$v->taka,
                    'uttolon'=>'-',
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
           
            }

            foreach($mohajon_payment_entry as $v)
            {
                $i++;
                $record[$i] = array(
                    'type' => 2,
                    'id'=>$v->id,
                    'reference' => "মহাজন পেমেন্ট",
                    'check_id' => ($v->check_id > 0 ? $v->check_book_page_setup->page : "-"),
                    'bank_name'=> $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4),
                    'marfot'=>$v->marfot,
                    'joma'=>'-',
                    'uttolon'=>$v->taka,
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }

            foreach($amanot_entry as $v)
            {
                $i++;
                $record[$i] = array(
                    'type' => $v->type,
                    'id'=>$v->id,
                    'reference' => "আমানতী জমা/খরচ",
                    'check_id' => ($v->check_id > 0 ? $v->check_book_page_setup->page : "-"),
                    'bank_name'=> $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4),
                    'marfot'=>$v->marfot,
                    'joma'=>($v->type==1 ? $v->taka : '-'),
                    'uttolon'=>($v->type==2 ? $v->taka : '-'),
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }

            foreach($hawlat_entry as $v)
            {
                $i++;
                $record[$i] = array(
                    'type' => $v->type,
                    'id'=>$v->id,
                    'reference' => "হাওলাত জমা/খরচ",
                    'check_id' => ($v->check_id > 0 ? $v->check_book_page_setup->page : "-"),
                    'bank_name'=> $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4),
                    'marfot'=>$v->marfot,
                    'joma'=>($v->type==1 ? $v->taka : '-'),
                    'uttolon'=>($v->type==2 ? $v->taka : '-'),
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }

            foreach($other_joma_khoroc_entry as $v)
            {
                $i++;
                $record[$i] = array(
                    'type' => $v->type,
                    'id'=>$v->id,
                    'reference' => "অন্যান্য জমা/খরচ",
                    'check_id' => ($v->check_id > 0 ? $v->check_book_page_setup->page : "-"),
                    'bank_name'=> $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4),
                    'marfot'=>$v->marfot,
                    'joma'=>($v->type==1 ? $v->taka : '-'),
                    'uttolon'=>($v->type==2 ? $v->taka : '-'),
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }

            usort($record, function($a, $b) { return $a['entry_date'] <=> $b['entry_date']; });
                

            $viewContent = view('user.report.bank_ledger.all_table', compact('bank_setup'))->with('record', $record)->render();

            return response()->json(['viewContent' => $viewContent]);

        }
        else if($request->date_from !="" && $request->date_to != "")
        {
  
            $date_from = Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d');
            $date_to = Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');

            // Select Old Amount

            $old_bank_entry = bank_entry::where('entry_date' ,"<", $date_from)->where('bank_setup_id',$request->bank_setup_id)->get();

            $kreta_joma_entry = kreta_joma_entry::where('entry_date' ,"<", $date_from)->where('bank_setup_id',$request->bank_setup_id)->sum('taka');
            $old_mohajon_payment_entry = mohajon_payment_entry::where('entry_date' ,"<", $date_from)->where('bank_setup_id',$request->bank_setup_id)->sum('taka');

            $old_amanot_entry = amanot_entry::where('entry_date' ,"<", $date_from)->where('bank_setup_id',$request->bank_setup_id)->get();
            $old_hawlat_entry = hawlat_entry::where('entry_date' ,"<", $date_from)->where('bank_setup_id',$request->bank_setup_id)->get();
            $old_other_joma_khoroc_entry = other_joma_khoroc_entry::where('entry_date' ,"<", $date_from)->where('bank_setup_id',$request->bank_setup_id)->get();

            $old_amount = 0;
            foreach($old_bank_entry as $v)
            {
                if($v->type == 1)
                {
                    $old_amount += $v->taka;
                }
                else
                {
                    $old_amount -= $v->taka;
                }
            }
            foreach($old_amanot_entry as $v)
            {
                if($v->type == 1)
                {
                    $old_amount += $v->taka;
                }
                else
                {
                    $old_amount -= $v->taka;
                }
            }
            foreach($old_hawlat_entry as $v)
            {
                if($v->type == 1)
                {
                    $old_amount += $v->taka;
                }
                else
                {
                    $old_amount -= $v->taka;
                }
            }
            foreach($old_other_joma_khoroc_entry as $v)
            {
                if($v->type == 1)
                {
                    $old_amount += $v->taka;
                }
                else
                {
                    $old_amount -= $v->taka;
                }
            }
            
            $old_amount += $kreta_joma_entry;
            $old_amount -= $old_mohajon_payment_entry;

            // End Select

            $bank_setup = bank_setup::where('id',$request->bank_setup_id)->first();
            $bank_entry = bank_entry::whereBetween('entry_date',[$date_from, $date_to])->where('bank_setup_id',$request->bank_setup_id)->get();

            $kreta_joma_entry = kreta_joma_entry::whereBetween('entry_date',[$date_from, $date_to])->where('bank_setup_id',$request->bank_setup_id)->get();
            $mohajon_payment_entry = mohajon_payment_entry::whereBetween('entry_date',[$date_from, $date_to])->where('bank_setup_id',$request->bank_setup_id)->get();
            $amanot_entry = amanot_entry::whereBetween('entry_date',[$date_from, $date_to])->where('bank_setup_id',$request->bank_setup_id)->get();
            $hawlat_entry = hawlat_entry::whereBetween('entry_date',[$date_from, $date_to])->where('bank_setup_id',$request->bank_setup_id)->get();
            $other_joma_khoroc_entry = other_joma_khoroc_entry::whereBetween('entry_date',[$date_from, $date_to])->where('bank_setup_id',$request->bank_setup_id)->get();

            

            /********* Adding Row to array ***********/

            $i = 0;
            $record = array();

            foreach($bank_entry as $v)
            {
                $i++;

                $record[$i] = array(
                    'type' => $v->type,
                    'id' => $v->id,
                    'reference' => "ব্যাংক উত্তোলন/জমা",
                    'check_id' => ($v->check_id > 0 ? $v->check_book_page_setup->page : "-"),
                    'bank_name' => $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4),
                    'marfot' => $v->marfot,
                    'joma'=> ($v->type==1 ? $v->taka : '-'),
                    'uttolon'=> ($v->type==2 ? $v->taka : '-'),
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }

            foreach($kreta_joma_entry as $v)
            {
                $i++;

                $record[$i] = array(
                    'type' => 1,
                    'id'=>$v->id,
                    'reference' => "ক্রেতার জমা",
                    'check_id' => "-",
                    'bank_name'=> $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4),
                    'marfot'=>$v->marfot,
                    'joma'=>$v->taka,
                    'uttolon'=>'-',
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
           
            }

            foreach($mohajon_payment_entry as $v)
            {
                $i++;
                $record[$i] = array(
                    'type' => 2,
                    'id'=>$v->id,
                    'reference' => "মহাজন পেমেন্ট",
                    'check_id' => ($v->check_id > 0 ? $v->check_book_page_setup->page : "-"),
                    'bank_name'=> $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4),
                    'marfot'=>$v->marfot,
                    'joma'=>'-',
                    'uttolon'=>$v->taka,
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }

            foreach($amanot_entry as $v)
            {
                $i++;
                $record[$i] = array(
                    'type' => $v->type,
                    'id'=>$v->id,
                    'reference' => "আমানতী জমা/খরচ",
                    'check_id' => ($v->check_id > 0 ? $v->check_book_page_setup->page : "-"),
                    'bank_name'=> $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4),
                    'marfot'=>$v->marfot,
                    'joma'=>($v->type==1 ? $v->taka : '-'),
                    'uttolon'=>($v->type==2 ? $v->taka : '-'),
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }

            foreach($hawlat_entry as $v)
            {
                $i++;
                $record[$i] = array(
                    'type' => $v->type,
                    'id'=>$v->id,
                    'reference' => "হাওলাত জমা/খরচ",
                    'check_id' => ($v->check_id > 0 ? $v->check_book_page_setup->page : "-"),
                    'bank_name'=> $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4),
                    'marfot'=>$v->marfot,
                    'joma'=>($v->type==1 ? $v->taka : '-'),
                    'uttolon'=>($v->type==2 ? $v->taka : '-'),
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }

            foreach($other_joma_khoroc_entry as $v)
            {
                $i++;
                $record[$i] = array(
                    'type' => $v->type,
                    'id'=>$v->id,
                    'reference' => "অন্যান্য জমা/খরচ",
                    'check_id' => ($v->check_id > 0 ? $v->check_book_page_setup->page : "-"),
                    'bank_name'=> $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4),
                    'marfot'=>$v->marfot,
                    'joma'=>($v->type==1 ? $v->taka : '-'),
                    'uttolon'=>($v->type==2 ? $v->taka : '-'),
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }


            usort($record, function($a, $b) { return $a['entry_date'] <=> $b['entry_date']; });

            $viewContent = view('user.report.bank_ledger.date_table', compact('old_amount','bank_setup','request'))->with('record', $record)->render();

            return response()->json(['viewContent' => $viewContent]);

        }
        else
        {
            return redirect()->back();
        }

    }
}
