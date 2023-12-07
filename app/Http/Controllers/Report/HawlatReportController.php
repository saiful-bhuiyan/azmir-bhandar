<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\hawlat_setup;
use App\Models\hawlat_entry;

class HawlatReportController extends Controller
{
    public function index()
    {
        $hawlat_setup = hawlat_setup::select('address')->groupBy('address')->get();;
        return view('user.report.hawlat_ledger.index',compact('hawlat_setup'));
    }

    public function search(Request $request)
    {
        if($request->hawlat_setup_id > 0)
        {
            if($request->date_from =="" && $request->date_to == "")
            {
                
                $hawlat_setup = hawlat_setup::where('id',$request->hawlat_setup_id)->first();
                $hawlat = hawlat_entry::where('hawlat_setup_id',$request->hawlat_setup_id)->get();

                $viewContent = view('user.report.hawlat_ledger.all_table', compact('hawlat_setup','hawlat'))->render();

                return response()->json(['viewContent' => $viewContent]);
                
            }
            else if($request->date_from !="" && $request->date_to != "")
            {
    
                $date_from = Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d');
                $date_to = Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');

                $hawlat_setup = hawlat_setup::where('id',$request->hawlat_setup_id)->first();
            
                $old_joma = hawlat_entry::where('type',1)->where('entry_date' ,"<", $date_from)
                            ->where('hawlat_setup_id',$request->hawlat_setup_id)->sum('taka');

                $old_khoroc = hawlat_entry::where('type',2)->where('entry_date' ,"<", $date_from)
                            ->where('hawlat_setup_id',$request->hawlat_setup_id)->sum('taka');
                
                $total_amount = 0;
                $total_amount += $old_joma;
                $total_amount -= $old_khoroc;

                $hawlat = hawlat_entry::whereBetween('entry_date',[$date_from, $date_to])->where('hawlat_setup_id',$request->hawlat_setup_id)->get();
                

                $viewContent = view('user.report.hawlat_ledger.date_table', compact('total_amount','hawlat_setup','hawlat','request'))->render();

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
