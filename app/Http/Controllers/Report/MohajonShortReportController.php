<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\arod_chotha_entry;
use App\Models\arod_chotha_info;
use App\Models\mohajon_payment_entry;
use App\Models\mohajon_return_entry;
use App\Models\mohajon_setup;
use App\Models\ponno_purchase_entry;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MohajonShortReportController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $i = 0;
            $count = 1;
            $record = array();
            $mohajon = mohajon_setup::get();

            foreach($mohajon as $m)
            {
                $mohajon_setup_id = $m->id;
                $mohajon_setup = mohajon_setup::find($mohajon_setup_id);
                $total_taka = 0;

                $purchase = ponno_purchase_entry::where('mohajon_setup_id', $m->mohajon_setup_id)->get();
                $purchaseAmountSum = 0;

                foreach ($purchase as $v)
                {
                    if ($v->purchase_type == 2)
                    {
                        $arod_chotha = arod_chotha_entry::where('purchase_id', $v->id)->sum('sales_qty');
                        $arod_chotha_info = arod_chotha_info::where('purchase_id', $v->id)->first();

                        if ($arod_chotha == $v->quantity && $arod_chotha_info)
                        {
                            $sales = arod_chotha_entry::where('purchase_id', $v->id)->get();

                            $total_sale = $sales->sum(function ($s) {
                                return $s->sales_weight * $s->sales_rate;
                            });

                            $total_mohajon_commission = $sales->sum(function ($s) use ($v) {
                                return $v->mohajon_commission * $s->sales_weight;
                            });

                            $total_cost = $total_mohajon_commission +
                            $arod_chotha_info->labour_cost +
                            $arod_chotha_info->truck_cost +
                            $arod_chotha_info->van_cost +
                            $arod_chotha_info->other_cost +
                            $arod_chotha_info->tohori_cost;

                            $purchaseAmountSum += ($total_sale - $total_cost);
                        }
                    }
                    else
                    {
                            $purchaseAmountSum += ($v->weight * $v->rate);
                    }
                }


                $payment = mohajon_payment_entry::where('mohajon_setup_id',$mohajon_setup_id)->sum('taka');
                $return = mohajon_return_entry::where('mohajon_setup_id',$mohajon_setup_id)->sum('taka');

                $total_taka += $mohajon_setup->old_amount;
                $total_taka += $purchaseAmountSum;
                $total_taka -= $payment;
                $total_taka += $return;

                /********* Adding Row to array ***********/

                $i++;
                $record[$i] = array(
                    'sl' => $count++,
                    'area' => $m->area,
                    'address' => $m->address,
                    'name'=> $m->name,
                    'mobile'=> $m->mobile,
                    'total_taka' => number_format($total_taka,2),
                );
            }
            $dataTable = DataTables::of($record);
            return $dataTable->toJson();
        
        }
        return view('user.report.mohajon_short_report.index');
    }
}
