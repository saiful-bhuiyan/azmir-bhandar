<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\other_joma_khoroc_setup;
use App\Models\other_joma_khoroc_entry;

class OtherJomaKhorocReportController extends Controller
{
    public function index()
    {
        $other_joma_khoroc_setup = other_joma_khoroc_setup::get();
        return view('user.report.other_joma_khoroc_report.index',compact('other_joma_khoroc_setup'));
    }

    public function search(Request $request)
    {
        if($request->other_id > 0)
        {
            if($request->date_from =="" && $request->date_to == "")
            {
                
                $other_joma_khoroc_setup = other_joma_khoroc_setup::where('id',$request->other_id)->first();
                $other_joma_khoroc = other_joma_khoroc_entry::where('other_id',$request->other_id)->get();

                $viewContent = view('user.report.other_joma_khoroc_report.all_table', compact('other_joma_khoroc_setup','other_joma_khoroc'))->render();

                return response()->json(['viewContent' => $viewContent]);
                
            }
            else if($request->date_from !="" && $request->date_to != "")
            {
    
                $date_from = Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d');
                $date_to = Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');

                $other_joma_khoroc_setup = other_joma_khoroc_setup::where('id',$request->other_id)->first();
            
                $old_joma = other_joma_khoroc_entry::where('type',1)->where('entry_date' ,"<", $date_from)
                            ->where('other_id',$request->other_id)->sum('taka');

                $old_khoroc = other_joma_khoroc_entry::where('type',2)->where('entry_date' ,"<", $date_from)
                            ->where('other_id',$request->other_id)->sum('taka');
                
                $total_amount = 0;
                $total_amount += $old_joma;
                $total_amount -= $old_khoroc;

                $other_joma_khoroc = other_joma_khoroc_entry::whereBetween('entry_date',[$date_from, $date_to])->where('other_id',$request->other_id)->get();
                

                $viewContent = view('user.report.other_joma_khoroc_report.date_table', compact('total_amount','other_joma_khoroc_setup','other_joma_khoroc','request'))->render();

                return response()->json(['viewContent' => $viewContent]);
            }
            else
            {
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->back();
        }
    }
}
