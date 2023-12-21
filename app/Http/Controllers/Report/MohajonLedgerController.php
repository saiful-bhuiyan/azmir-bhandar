<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\mohajon_setup;
use App\Models\mohajon_payment_entry;
use App\Models\mohajon_return_entry;
use App\Models\ponno_purchase_entry;
use App\Models\arod_chotha_entry;
use App\Models\ponno_sales_entry;

class MohajonLedgerController extends Controller
{
    public function index()
    {
        $mohajon_setup = mohajon_setup::select('area')->groupBy('area')->get();
        return view('user.report.mohajon_ledger.index',compact('mohajon_setup'));
    }

    public function search(Request $request)
    {
        if($request->date_from =="" && $request->date_to == "")
        {
            $i = 0;
            $record = array();
            
            $mohajon_setup = mohajon_setup::where('id',$request->mohajon_setup_id)->first();
            $purchase = ponno_purchase_entry::where('mohajon_setup_id',$request->mohajon_setup_id)->get();

            foreach($purchase as $v)
            {
                if($v->purchase_type == 2)
                {
                    $arod_chotha = arod_chotha_entry::where('purchase_id',$v->id)->count();
                
                    if($arod_chotha > 0)
                    {
                        $sales = arod_chotha_entry::where('purchase_id', $v->id)->get(); 

                        $total_sale = 0;
                        $total_sale_qty = 0;
                        $total_mohajon_commission = $v->mohajon_commission;

                        foreach($sales as $s){
                            $total_sale += $s->sales_weight * $s->sales_rate;
                            $total_sale_qty += $s->sales_qty;
                        }

                        $total_cost = $total_mohajon_commission + $v->labour_cost + $v->truck_cost +
                                $v->van_cost + $v->other_cost +$v->tohori_cost;
                        $kacha_sales = $total_sale - $total_cost;

                        $i++;
                        $record[$i] = array(
                            'table' => 4,
                            'id' => $v->id,
                            'reference' => 'পন্য গ্রহণ',
                            'payment' => '-',
                            'marfot' => '-',
                            'joma'=> $kacha_sales,
                            'khoroc'=> '-',
                            'total_taka' => '-',
                            'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                        );
                        
                    }
                    else
                    {
                        $sales = ponno_sales_entry::where('purchase_id', $v->id)->get(); 

                        $total_sale = 0;
                        $total_sale_qty = 0;
                        $total_mohajon_commission = $v->mohajon_commission;

                        foreach($sales as $s){
                            $total_sale += $s->sales_weight * $s->sales_rate;
                            $total_sale_qty += $s->sales_qty;
                        }

                        $total_cost = $total_mohajon_commission + $v->labour_cost + $v->truck_cost +
                                $v->van_cost + $v->other_cost +$v->tohori_cost;
                        $kacha_sales = $total_sale - $total_cost;

                        $i++;
                        $record[$i] = array(
                            'table' => 1,
                            'id' => $v->id,
                            'reference' => 'পন্য গ্রহণ',
                            'payment' => '-',
                            'marfot' => '-',
                            'joma'=> $kacha_sales,
                            'khoroc'=> '-',
                            'total_taka' => '-',
                            'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                        );
                        
                    }
                }
                else
                {
                    $i++;
                    $record[$i] = array(
                        'table' => 1,
                        'id' => $v->id,
                        'reference' => 'পন্য গ্রহণ',
                        'payment' => '-',
                        'marfot' => '-',
                        'joma'=> ($v->weight * $v->rate) + $v->labour_cost + $v->truck_cost +
                        $v->van_cost + $v->other_cost +$v->tohori_cost,
                        'khoroc'=> '-',
                        'total_taka' => '-',
                        'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                    );
                }
                
            }

            $mohajon_payment = mohajon_payment_entry::where('mohajon_setup_id',$request->mohajon_setup_id)->get();
            $mohajon_return = mohajon_return_entry::where('mohajon_setup_id',$request->mohajon_setup_id)->get();

            /********* Adding Row to array ***********/

            foreach($mohajon_payment as $v)
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
                    'id'=>$v->id,
                    'reference' => 'মহাজন পেমেন্ট',
                    'payment'=> $payment,
                    'marfot'=>$v->marfot,
                    'joma'=>'-',
                    'khoroc'=>$v->taka,
                    'total_taka'=>'-',
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
           
            }

            foreach($mohajon_return as $v)
            {
                $i++;
                $payment = '';
                if($v->payment_by == 1){
                    $payment = 'ক্যাশ';
                }else if($v->payment_by == 2){
                    $payment = $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4);  
                }
                $record[$i] = array(
                    'table' => 3,
                    'id'=>$v->id,
                    'reference' => 'মহাজন ফেরত',
                    'payment'=> $payment,
                    'marfot'=>$v->marfot,
                    'joma'=>'-',
                    'khoroc'=>$v->taka,
                    'total_taka'=>'-',
                    'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                );
            
            }

            usort($record, function($a, $b) { return $a['entry_date'] <=> $b['entry_date']; });
                

            $viewContent = view('user.report.mohajon_ledger.all_table', compact('mohajon_setup'))->with('record', $record)->render();

            return response()->json(['viewContent' => $viewContent]);

        }
        else if($request->date_from !="" && $request->date_to != "")
        {
            $date_from = Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d');
            $date_to = Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');

            $mohajon_setup = mohajon_setup::where('id',$request->mohajon_setup_id)->first();

            $i = 0;
            $record = array();
            $old_amount = $mohajon_setup->old_amount;
            

            /*****************Getting Old Amount From Mohajon By Date ***************/

            $old_purchase = ponno_purchase_entry::where('entry_date','<',$date_from)->where('mohajon_setup_id',$request->mohajon_setup_id)->get();
            $old_mohajon_payment = mohajon_payment_entry::where('entry_date','<',$date_from)
            ->where('mohajon_setup_id',$request->mohajon_setup_id)->sum('taka');
            $old_mohajon_return = mohajon_return_entry::where('entry_date','<',$date_from)
            ->where('mohajon_setup_id',$request->mohajon_setup_id)->sum('taka');

            $old_amount -= $old_mohajon_payment;
            $old_amount -= $old_mohajon_return;

                foreach($old_purchase as $v)
                {
                    if($v->purchase_type == 2)
                    {
                        $arod_chotha = arod_chotha_entry::where('purchase_id',$v->id)->count();
                    
                        if($arod_chotha > 0)
                        {
                            $sales = arod_chotha_entry::where('purchase_id', $v->id)->get(); 

                            $total_sale = 0;
                            $total_sale_qty = 0;
                            $total_mohajon_commission = $v->mohajon_commission;

                            foreach($sales as $s){
                                $total_sale += $s->sales_weight * $s->sales_rate;
                                $total_sale_qty += $s->sales_qty;
                            }

                            $total_cost = $total_mohajon_commission + $v->labour_cost + $v->truck_cost +
                                    $v->van_cost + $v->other_cost +$v->tohori_cost;
                            $kacha_sales = $total_sale - $total_cost;

                            $old_amount += $kacha_sales;
                            
                        }
                        else
                        {
                            $sales = ponno_sales_entry::where('purchase_id', $v->id)->get(); 

                            $total_sale = 0;
                            $total_sale_qty = 0;
                            $total_mohajon_commission = $v->mohajon_commission;

                            foreach($sales as $s){
                                $total_sale += $s->sales_weight * $s->sales_rate;
                                $total_sale_qty += $s->sales_qty;
                            }

                            $total_cost = $total_mohajon_commission + $v->labour_cost + $v->truck_cost +
                                    $v->van_cost + $v->other_cost +$v->tohori_cost;
                            $kacha_sales = $total_sale - $total_cost;

                            $old_amount += $kacha_sales;
                        }
                    }
                    else
                    {
                        $old_amount += ($v->weight * $v->rate);
                        $old_amount +=  $v->labour_cost + $v->truck_cost + $v->van_cost + $v->other_cost + $v->tohori_cost;
                    }
                    
                }

                /************** End of Old Amount ****************/


            $purchase = ponno_purchase_entry::whereBetween('entry_date',[$date_from, $date_to])->where('mohajon_setup_id',$request->mohajon_setup_id)->get();

                foreach($purchase as $v)
                {
                    if($v->purchase_type == 2)
                    {
                        $arod_chotha = arod_chotha_entry::where('purchase_id',$v->id)->count();
                    
                        if($arod_chotha > 0)
                        {
                            $sales = arod_chotha_entry::where('purchase_id', $v->id)->get(); 

                            $total_sale = 0;
                            $total_sale_qty = 0;
                            $total_mohajon_commission = $v->mohajon_commission;

                            foreach($sales as $s){
                                $total_sale += $s->sales_weight * $s->sales_rate;
                                $total_sale_qty += $s->sales_qty;
                            }

                            $total_cost = $total_mohajon_commission + $v->labour_cost + $v->truck_cost +
                                    $v->van_cost + $v->other_cost +$v->tohori_cost;
                            $kacha_sales = $total_sale - $total_cost;
                            // table 4 = edited chotha

                            $i++;
                            $record[$i] = array(
                                'table' => 4,
                                'id' => $v->id,
                                'reference' => 'পন্য গ্রহণ',
                                'payment' => '-',
                                'marfot' => '-',
                                'joma'=> $kacha_sales,
                                'khoroc'=> '-',
                                'total_taka' => '-',
                                'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                            );
                            
                        }
                        else
                        {
                            $sales = ponno_sales_entry::where('purchase_id', $v->id)->get(); 

                            $total_sale = 0;
                            $total_sale_qty = 0;
                            $total_mohajon_commission = $v->_mohajon_commission;

                            foreach($sales as $s){
                                $total_sale += $s->sales_weight * $s->sales_rate;
                                $total_sale_qty += $s->sales_qty;
                            }

                            $total_cost = $total_mohajon_commission + $v->labour_cost + $v->truck_cost +
                                    $v->van_cost + $v->other_cost +$v->tohori_cost;
                            $kacha_sales = $total_sale - $total_cost;

                            $i++;
                            $record[$i] = array(
                                'table' => 1,
                                'id' => $v->id,
                                'reference' => 'পন্য গ্রহণ',
                                'payment' => '-',
                                'marfot' => '-',
                                'joma'=> $kacha_sales,
                                'khoroc'=> '-',
                                'total_taka' => '-',
                                'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                            );
                            
                        }
                    }
                    else
                    {
                        $i++;
                        $record[$i] = array(
                            'table' => 1,
                            'id' => $v->id,
                            'reference' => 'পন্য গ্রহণ / নিজ খরিদ',
                            'payment' => '-',
                            'marfot' => '-',
                            'joma'=> ($v->weight * $v->rate) + $v->labour_cost + $v->truck_cost +
                            $v->van_cost + $v->other_cost +$v->tohori_cost,
                            'khoroc'=> '-',
                            'total_taka' => '-',
                            'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                        );
                    }
                    
                }

                $mohajon_payment = mohajon_payment_entry::whereBetween('entry_date',[$date_from, $date_to])->where('mohajon_setup_id',$request->mohajon_setup_id)->get();
                $mohajon_return = mohajon_return_entry::whereBetween('entry_date',[$date_from, $date_to])->where('mohajon_setup_id',$request->mohajon_setup_id)->get();

                /********* Adding Row to array ***********/

                foreach($mohajon_payment as $v)
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
                        'id'=>$v->id,
                        'reference' => 'মহাজন পেমেন্ট',
                        'payment'=> $payment,
                        'marfot'=>$v->marfot,
                        'joma'=>'-',
                        'khoroc'=>$v->taka,
                        'total_taka'=>'-',
                        'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                    );
            
                }

                foreach($mohajon_return as $v)
                {
                    $i++;
                    $payment = '';
                    if($v->payment_by == 1){
                        $payment = 'ক্যাশ';
                    }else if($v->payment_by == 2){
                        $payment = $v->bank_setup->bank_name."/".substr($v->bank_setup->account_no, -4);  
                    }
                    $record[$i] = array(
                        'table' => 3,
                        'id'=>$v->id,
                        'reference' => 'মহাজন ফেরত',
                        'payment'=> $payment,
                        'marfot'=>$v->marfot,
                        'joma'=>'-',
                        'khoroc'=>$v->taka,
                        'total_taka'=>'-',
                        'entry_date'=>Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y'),
                    );
                
                }

                usort($record, function($a, $b) { return $a['entry_date'] <=> $b['entry_date']; });
                    

                $viewContent = view('user.report.mohajon_ledger.date_table', compact('mohajon_setup','request','old_amount'))->with('record', $record)->render();

                return response()->json(['viewContent' => $viewContent]);
            }
            else
            {
                return redirect()->back();
            }

    }
}
