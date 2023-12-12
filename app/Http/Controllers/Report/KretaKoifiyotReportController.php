<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\kreta_setup;
use App\Models\kreta_koifiyot_entry;

class KretaKoifiyotReportController extends Controller
{
    public function index()
    {
        $kreta_setup = kreta_setup::select('area')->groupBy('area')->get();;
        return view('user.report.kreta_koifiyot_report.index',compact('kreta_setup'));
    }

    public function search(Request $request)
    {
        if($request->kreta_setup_id > 0)
        {
            if($request->date_from =="" && $request->date_to == "")
            {
                
                $kreta_setup = kreta_setup::where('id',$request->kreta_setup_id)->first();
                $kreta_koifiyot = kreta_koifiyot_entry::where('kreta_setup_id',$request->kreta_setup_id)->get();

                $viewContent = view('user.report.kreta_koifiyot_report.all_table', compact('kreta_setup','kreta_koifiyot'))->render();

                return response()->json(['viewContent' => $viewContent]);
                
            }
            else if($request->date_from !="" && $request->date_to != "")
            {
    
                $date_from = Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d');
                $date_to = Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');

                $kreta_setup = kreta_setup::where('id',$request->kreta_setup_id)->first();
            
                $total_amount = kreta_koifiyot_entry::where('entry_date' ,"<", $date_from)
                            ->where('kreta_setup_id',$request->kreta_setup_id)->sum('taka');

                $kreta_koifiyot = kreta_koifiyot_entry::whereBetween('entry_date',[$date_from, $date_to])->where('kreta_setup_id',$request->kreta_setup_id)->get();
                

                $viewContent = view('user.report.kreta_koifiyot_report.date_table', compact('total_amount','kreta_setup','kreta_koifiyot','request'))->render();

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
