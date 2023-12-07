<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\amanot_setup;
use App\Models\amanot_entry;


class AmanotReportController extends Controller
{
    public function index()
    {
        $amanot_setup = amanot_setup::select('address')->groupBy('address')->get();;
        return view('user.report.amanot_ledger.index',compact('amanot_setup'));
    }

    public function search(Request $request)
    {
        if($request->amanot_setup_id > 0)
        {
            if($request->date_from =="" && $request->date_to == "")
            {
                
                $amanot_setup = amanot_setup::where('id',$request->amanot_setup_id)->first();
                $amanot = amanot_entry::where('amanot_setup_id',$request->amanot_setup_id)->get();

                $viewContent = view('user.report.amanot_ledger.all_table', compact('amanot_setup','amanot'))->render();

                return response()->json(['viewContent' => $viewContent]);
                
            }
            else if($request->date_from !="" && $request->date_to != "")
            {
    
                $date_from = Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d');
                $date_to = Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');

                $amanot_setup = amanot_setup::where('id',$request->amanot_setup_id)->first();
            
                $old_joma = amanot_entry::where('type',1)->where('entry_date' ,"<", $date_from)
                            ->where('amanot_setup_id',$request->amanot_setup_id)->sum('taka');

                $old_khoroc = amanot_entry::where('type',2)->where('entry_date' ,"<", $date_from)
                            ->where('amanot_setup_id',$request->amanot_setup_id)->sum('taka');
                
                $total_amount = 0;
                $total_amount += $old_joma;
                $total_amount -= $old_khoroc;

                $amanot = amanot_entry::whereBetween('entry_date',[$date_from, $date_to])->where('amanot_setup_id',$request->amanot_setup_id)->get();
                

                $viewContent = view('user.report.amanot_ledger.date_table', compact('total_amount','amanot_setup','amanot','request'))->render();

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
