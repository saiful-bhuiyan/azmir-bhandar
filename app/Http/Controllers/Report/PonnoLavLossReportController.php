<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ponno_setup;
use App\Models\mohajon_setup;
use App\Models\ponno_purchase_entry;

class PonnoLavLossReportController extends Controller
{
    public function index()
    {
        $ponno_setup = ponno_setup::get();
        $mohajon_setup = mohajon_setup::get();
        return view('user.report.ponno_lav_loss_report.index',compact('ponno_setup','mohajon_setup'));
    }

    public function search(Request $request)
    {
        $date_from = Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d');
        $date_to = Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');
        $ponno_setup_id = $request->ponno_setup_id;

        if($request->purchase_type == 1)
        {
            $purchase_type = [1];
        }
        else if($request->purchase_type == 2)
        {
            $purchase_type = [2];
        }else
        {
            $purchase_type = [1,2];
        }
        
        if($request->type == 1)
        {
            if($ponno_setup_id == 0)
            {
                $purchase = ponno_purchase_entry::whereBetween('entry_date', [$date_from, $date_to])
                ->whereIn('ponno_purchase_entries.id', function ($query) {
                    $query->select('purchase_id')
                        ->from('stocks')->where('quantity',0);
                })->whereIn('purchase_type',$purchase_type)->get();

                $title = "সকল পন্যের লাভ লস রিপোর্ট";
            }
            else if($ponno_setup_id > 0)
            {
                $purchase = ponno_purchase_entry::where('ponno_setup_id',$ponno_setup_id)
                ->whereBetween('entry_date', [$date_from, $date_to])
                ->whereIn('ponno_purchase_entries.id', function ($query) {
                    $query->select('purchase_id')
                        ->from('stocks')->where('quantity',0);
                })->get();

                $title = "পণ্য প্রতি লাভ লস রিপোর্ট";
            }

            $viewContent = view('user.report.ponno_lav_loss_report.all_ponno_table', compact('purchase','request','title'))->render();

            return response()->json(['viewContent' => $viewContent]);
        }
        else
        {
            if($request->mohajon_setup_id > 0)
            {
                $purchase = ponno_purchase_entry::where('mohajon_setup_id',$request->mohajon_setup_id)
                ->whereBetween('entry_date', [$date_from, $date_to])
                ->whereIn('ponno_purchase_entries.id', function ($query) {
                    $query->select('purchase_id')
                        ->from('stocks')->where('quantity',0);
                })->get();

                $mohajon_setup = mohajon_setup::where('id',$request->mohajon_setup_id)->first();

                $title = "মহাজন প্রতি লাভ লস রিপোর্ট";

                $viewContent = view('user.report.ponno_lav_loss_report.all_ponno_table', compact('purchase','request','title','mohajon_setup'))->render();

                return response()->json(['viewContent' => $viewContent]);
            }
        }
    }
}
