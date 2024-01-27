<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\arod_chotha_entry;
use App\Models\arod_chotha_info;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\mohajon_setup;
use App\Models\ponno_purchase_cost_entry;
use App\Models\ponno_purchase_entry;
use App\Models\ponno_sales_entry;
use Carbon\Carbon;

class ArodchothaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mohajon_setup = mohajon_setup::select('area')->groupBy('area')->get();

        $incomplete_chotha = ponno_purchase_entry::where('purchase_type', 2)
                ->whereNotIn('id', function ($query) {
                    $query->select('purchase_id')
                        ->from('arod_chotha_infos');
                })
                ->where('quantity', '!=', function ($query) {
                    $query->selectRaw('COALESCE(SUM(sales_qty), 0)')
                        ->from('arod_chotha_entries')
                        ->whereColumn('arod_chotha_entries.purchase_id', '=', 'ponno_purchase_entries.id');
                })
                ->where('quantity', '=', function ($query) {
                    $query->selectRaw('COALESCE(SUM(sales_qty), 0)')
                        ->from('ponno_sales_entries')
                        ->whereColumn('ponno_sales_entries.purchase_id', '=', 'ponno_purchase_entries.id');
                })
                ->get();
        return view('user.entry_user.arod_chotha',compact('mohajon_setup','incomplete_chotha'));
    }

    public function arod_chotha_entry($purchase_id)
    {
        $purchase = ponno_purchase_entry::where('id', $purchase_id)->first(); 

        $sales = ponno_sales_entry::where('purchase_id', $purchase->id)->orderBy('sales_rate','DESC')->get(); 

        $arod_chotha = arod_chotha_entry::where('purchase_id', $purchase->id)->orderBy('sales_rate','DESC')->get(); 
        $arod_chotha_info = arod_chotha_info::where('purchase_id', $purchase->id)->first(); 

        return view('user.entry_user.arod_chotha_entry',compact('purchase','sales','arod_chotha','arod_chotha_info'));
        
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'purchase_id' => 'required',
                'sales_qty' => 'required|numeric',
                'sales_weight' => 'required|numeric',
                'sales_rate' => 'required|numeric',
            ],
            [
                'purchase_id.required'=>'দয়া করে পন্য সিলেক্ট করুন',
                'sales_qty.required'=>'দয়া করে বিক্রি সংখ্যা ইনপুট করুন',
                'sales_weight.required'=>'দয়া করে পন্যের ওজন ইনপুট করুন',
                'sales_rate.required'=>'দয়া করে পন্যের দর ইনপুট করুন',
                'sales_qty.numeric'=>'সংখ্যা ইনপুট করুন',
                'sales_weight.numeric'=>'সংখ্যা ইনপুট করুন',
                'sales_rate.numeric'=>'সংখ্যা ইনপুট করুন',
            ]);

            $data = array(
                'purchase_id'=>$request->purchase_id,
                'sales_qty'=>$request->sales_qty,
                'sales_weight'=>$request->sales_weight,
                'sales_rate'=>$request->sales_rate,
            );

            $ponno = ponno_purchase_entry::where('id',$request->purchase_id)->first();

            $insert = arod_chotha_entry::create($data);
            if($insert)
            {
                Toastr::success(__('এড কার্ট সফল হয়েছে'), __('সফল'));
            }
    
            return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = array(
            'purchase_id'=>$id,
            'labour_cost'=>$request->labour_cost ? $request->labour_cost : 0,
            'other_cost'=>$request->other_cost ? $request->other_cost : 0,
            'truck_cost'=>$request->truck_cost ? $request->truck_cost : 0,
            'van_cost'=>$request->van_cost ? $request->van_cost : 0,
            'tohori_cost'=>$request->tohori_cost ? $request->tohori_cost : 0,
            'entry_date'=> Carbon::createFromFormat('d-m-Y', $request->entry_date)->format('Y-m-d'),
        );

        $mohajon_commission = $request->mohajon_commission ? $request->mohajon_commission : 0;

        $count = arod_chotha_info::where('purchase_id',$id)->count();

        if($count > 0)
        {
            $update = arod_chotha_info::where('purchase_id',$id)->update($data);

            if($update)
            {
                ponno_purchase_entry::where('id',$id)->update(['mohajon_commission' => $mohajon_commission]);
                Toastr::success(__('আপডেট সফল হয়েছে'), __('সফল'));
            }
            else
            {
                Toastr::error(__('আপডেট সফল হয়নি'), __('ব্যর্থ'));
            }
            return redirect()->back()->with('invoice',$id);;
        }else{
            $insert = arod_chotha_info::create($data);
            if($insert)
            {
                ponno_purchase_entry::where('id',$id)->update(['mohajon_commission' => $mohajon_commission]);
                Toastr::success(__('সেভ সফল হয়েছে'), __('সফল'));
            }
            else
            {
                Toastr::error(__('সেভ সফল হয়নি'), __('ব্যর্থ'));
            }
            return redirect()->back()->with('invoice',$id);;
        }
            
    }

    /******************** End of arod chotha info update ************************/
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = arod_chotha_entry::destroy($id);
        if($delete)
        {
            Toastr::success(__('ডিলিট সফল হয়েছে'), __('সফল'));
        }
        else
        {
            Toastr::error(__('ডিলিট সফল হয়নি'), __('ব্যর্থ'));
        }

        return redirect()->back();
    }

    public function getCommissionPurchaseMonth(Request $request)
    {
        $full_month = explode('-',$request->txtMonth);

        $year = $full_month[0];
        $month = $full_month[1];

        $data = ponno_purchase_entry::whereYear('entry_date', '=', $year)
                ->whereMonth('entry_date', '=', $month)
                ->get();

        $select = "<option value='' selected>সিলেক্ট</option>";

        foreach($data as $v)
        {
            $select .= "<option value='".$v->id."'>".$v->quantity." / ".$v->ponno_setup->ponno_name." / ".$v->ponno_size_setup->ponno_size." / ".$v->ponno_marka_setup->ponno_marka."</option>";
        }

        return $select;
    }

    public function getPurchaseIdByMohajonId(Request $request)
    {
        $date_from = Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d');
        $date_to = Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');

        $data = ponno_purchase_entry::where('mohajon_setup_id', $request->mohajon_setup_id)->where('purchase_type',2)
        ->whereBetween('entry_date',[$date_from, $date_to])->orderBy('entry_date','DESC')->get();

        $select = "<option value='' selected>সিলেক্ট</option>";

        $edited = "";

        foreach($data as $v)
        {
            $cotha_qty = arod_chotha_entry::where('purchase_id',$v->id)->sum('sales_qty');
            $sales_info = arod_chotha_info::where('purchase_id',$v->id)->first();
            if($cotha_qty == $v->quantity && $sales_info)
            {
                $edited = " - Edited";
            }else{
                $edited = "";
            }
            $select .= "<option value='".$v->id."'>ই -".$v->id." / ".$v->quantity." / ".$v->ponno_setup->ponno_name." / ".$v->ponno_size_setup->ponno_size." / ".$v->ponno_marka_setup->ponno_marka." ".$edited."</option>";
        }

        return $select;
    }

    public function loadArodChothaTable(Request $request)
    {
        $purchase = ponno_purchase_entry::where('id', $request->purchase_id)->first();
        
        $arod_chotha = arod_chotha_entry::where('purchase_id',$purchase->id)->count();
        $chotha_info = arod_chotha_info::where('purchase_id',$purchase->id)->count();


        if($arod_chotha > 0 && $chotha_info > 0)
        {
            $sales = arod_chotha_entry::where('purchase_id', $purchase->id)->orderBy('sales_rate','DESC')->get(); 
            $sales_info = arod_chotha_info::where('purchase_id', $purchase->id)->first(); 
            return view('user.entry_user.arod_cotha_info_edited',compact('purchase','sales','sales_info'));
        }
        else
        {
            $purchase = ponno_purchase_entry::where('id',$purchase->id)->first();
            $sales = ponno_sales_entry::where('purchase_id', $purchase->id)->orderBy('sales_rate','DESC')->get(); 
            $short_sales = ponno_sales_entry::selectRaw('SUM(sales_qty) as sales_qty, SUM(sales_weight) as sales_weight, sales_rate')
            ->where('purchase_id', $purchase->id)->groupBy('sales_rate')->orderBy('sales_rate', 'DESC')->get();
            
            $labour_cost = 0;
            $other_cost = 0;
            $truck_cost = 0;
            $van_cost = 0;
            $tohori_cost = 0;
            $ponno_cost = ponno_purchase_cost_entry::where('purchase_id',$purchase->id)->get();
            foreach($ponno_cost as $v)
            {
                if($v->cost_name == 1){
                     $labour_cost += $v->taka;
                }else if($v->cost_name == 2){
                    $other_cost += $v->taka;
                }else if($v->cost_name == 3){
                    $truck_cost += $v->taka;
                }else if($v->cost_name == 4){
                    $van_cost += $v->taka;
                }else if($v->cost_name == 5){
                    $tohori_cost += $v->taka;
                }
            }
            
            return view('user.entry_user.arod_cotha_info',compact('purchase','sales','short_sales','labour_cost','other_cost','truck_cost','van_cost','tohori_cost'));
        }

        
    }



    public function arod_chotha_memo($id)
    {
        $purchase = ponno_purchase_entry::where('id',$id)->first();

        $sales = arod_chotha_entry::where('purchase_id', $purchase->id)->orderBy('sales_rate','DESC')->get(); 

        $sales_info = arod_chotha_info::where('purchase_id', $purchase->id)->first(); 
        
        return view('user.entry_user.arod_chotha_memo',compact('purchase','sales','sales_info'));
    }
}
