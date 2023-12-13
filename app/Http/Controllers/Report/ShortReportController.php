<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\bank_setup;
use App\Models\amanot_setup;
use App\Models\hawlat_setup;
use App\Models\other_joma_khoroc_setup;
use App\Models\bank_entry;
use App\Models\kreta_joma_entry;
use App\Models\mohajon_payment_entry;
use App\Models\amanot_entry;
use App\Models\hawlat_entry;
use App\Models\other_joma_khoroc_entry;

class ShortReportController extends Controller
{
    public function index()
    {
        return view('user.report.short_report.index');

    }

    public function search(Request $request)
    {
        if($request->report_id == 1)
        {
            $i = 0;
            $record = array();
            $bank = bank_setup::get();
            
            foreach($bank as $v)
            {
                $bank_setup_id = $v->id;
                $total_taka = 0;

                $bank_joma = bank_entry::where('bank_setup_id',$bank_setup_id)->where('type',1)->sum('taka');
                $bank_uttolon = bank_entry::where('bank_setup_id',$bank_setup_id)->where('type',2)->sum('taka');

                $kreta_joma = kreta_joma_entry::where('bank_setup_id',$bank_setup_id)->sum('taka');

                $mohajon_payment = mohajon_payment_entry::where('bank_setup_id',$bank_setup_id)->sum('taka');
                
                $amanot_joma = amanot_entry::where('bank_setup_id',$bank_setup_id)->where('type',1)->sum('taka');
                $amanot_uttolon = amanot_entry::where('bank_setup_id',$bank_setup_id)->where('type',2)->sum('taka');

                $hawlat_joma = hawlat_entry::where('bank_setup_id',$bank_setup_id)->where('type',1)->sum('taka');
                $hawlat_uttolon = hawlat_entry::where('bank_setup_id',$bank_setup_id)->where('type',2)->sum('taka');

                $other_joma = other_joma_khoroc_entry::where('bank_setup_id',$bank_setup_id)->where('type',1)->sum('taka');
                $other_uttolon = other_joma_khoroc_entry::where('bank_setup_id',$bank_setup_id)->where('type',2)->sum('taka');


                $total_taka += $bank_joma;
                $total_taka += $kreta_joma;
                $total_taka += $amanot_joma;
                $total_taka += $hawlat_joma;
                $total_taka += $other_joma;

                $total_taka -= $bank_uttolon;
                $total_taka -= $mohajon_payment;
                $total_taka -= $amanot_uttolon;
                $total_taka -= $hawlat_uttolon;
                $total_taka -= $other_uttolon;

                /********* Adding Row to array ***********/

                $i++;
                $record[$i] = array(
                    'id' => $v->id,
                    'bank_name' => $v->bank_name,
                    'account_name' => $v->account_name,
                    'account_no'=> $v->account_no,
                    'shakha'=> $v->shakha,
                    'total_taka' => $total_taka,
                );
                
            }

            $viewContent = view('user.report.short_report.bank_table')->with('record', $record)->render();

            return response()->json(['viewContent' => $viewContent]);
        }
        else if($request->report_id == 2)
        {
            $i = 0;
            $record = array();
            $amanot = amanot_setup::get();

            foreach($amanot as $v)
            {
                $amanot_setup_id = $v->id;
                $total_taka = 0;

                $amanot_joma = amanot_entry::where('amanot_setup_id',$amanot_setup_id)->where('type',1)->sum('taka');
                $amanot_uttolon = amanot_entry::where('amanot_setup_id',$amanot_setup_id)->where('type',2)->sum('taka');

                $total_taka += $amanot_joma;
                $total_taka -= $amanot_uttolon;

                /********* Adding Row to array ***********/

                $i++;
                $record[$i] = array(
                    'id' => $v->id,
                    'name' => $v->name,
                    'address'=> $v->address,
                    'mobile'=> $v->mobile,
                    'total_taka' => $total_taka,
                );
            }

            $viewContent = view('user.report.short_report.amanot_table')->with('record', $record)->render();

            return response()->json(['viewContent' => $viewContent]);
        }
        else if($request->report_id == 3)
        {
            $i = 0;
            $record = array();
            $hawlat = hawlat_setup::get();

            foreach($hawlat as $v)
            {
                $hawlat_setup_id = $v->id;
                $total_taka = 0;

                $hawlat_joma = hawlat_entry::where('hawlat_setup_id',$hawlat_setup_id)->where('type',1)->sum('taka');
                $hawlat_uttolon = hawlat_entry::where('hawlat_setup_id',$hawlat_setup_id)->where('type',2)->sum('taka');

                $total_taka += $hawlat_joma;
                $total_taka -= $hawlat_uttolon;

                /********* Adding Row to array ***********/

                $i++;
                $record[$i] = array(
                    'id' => $v->id,
                    'name' => $v->name,
                    'address'=> $v->address,
                    'mobile'=> $v->mobile,
                    'total_taka' => $total_taka,
                );
            }

            $viewContent = view('user.report.short_report.hawlat_table')->with('record', $record)->render();

            return response()->json(['viewContent' => $viewContent]);
        }
        else if($request->report_id == 4)
        {
            $i = 0;
            $record = array();
            $other = other_joma_khoroc_setup::get();

            foreach($other as $v)
            {
                $other_id = $v->id;
                $total_taka = 0;

                $other_joma = other_joma_khoroc_entry::where('other_id',$other_id)->where('type',1)->sum('taka');
                $other_uttolon = other_joma_khoroc_entry::where('other_id',$other_id)->where('type',2)->sum('taka');

                $total_taka += $other_joma;
                $total_taka -= $other_uttolon;

                /********* Adding Row to array ***********/

                $i++;
                $record[$i] = array(
                    'id' => $v->id,
                    'name' => $v->name,
                    'address'=> $v->address,
                    'mobile'=> $v->mobile,
                    'total_taka' => $total_taka,
                );
            }

            $viewContent = view('user.report.short_report.other_joma_khoroc_table')->with('record', $record)->render();

            return response()->json(['viewContent' => $viewContent]);
        }
    }
}
