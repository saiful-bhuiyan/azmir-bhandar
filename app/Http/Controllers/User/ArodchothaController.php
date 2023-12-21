<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\arod_chotha_entry;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\mohajon_setup;
use App\Models\kreta_setup;
use App\Models\mohajon_commission_setup;
use App\Models\kreta_commission_setup;
use App\Models\ponno_purchase_entry;
use App\Models\temp_ponno_sale;
use App\Models\ponno_sales_info;
use App\Models\ponno_sales_entry;
use App\Models\stock;
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
        return view('user.entry_user.arod_chotha',compact('mohajon_setup'));
    }

    public function arod_chotha_entry($purchase_id)
    {
        $purchase = ponno_purchase_entry::where('id', $purchase_id)->first(); 

        $sales = ponno_sales_entry::where('purchase_id', $purchase->id)->get(); 

        $arod_chotha = arod_chotha_entry::where('purchase_id', $purchase->id)->get(); 

        return view('user.entry_user.arod_chotha_entry',compact('purchase','sales','arod_chotha'));
        
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

            $ponno = ponno_purchase_entry::where('purchase_id',$request->purchase_id)->first();

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

        $data = ponno_purchase_entry::where('mohajon_setup_id', $request->mohajon_setup_id)->where('purchase_type',2)->orderBy('entry_date','DESC')
                ->whereIn('ponno_purchase_entries.id', function ($query) {
                    $query->select('purchase_id')
                        ->from('stocks')->where('quantity',0);
                })->get();

        $select = "<option value='' selected>সিলেক্ট</option>";

        $edited = "";

        foreach($data as $v)
        {
            $cotha = arod_chotha_entry::where('purchase_id',$v->id)->first();
            if($cotha)
            {
                $edited = " - Edited";
            }
            $select .= "<option value='".$v->id."'>".$v->quantity." / ".$v->ponno_setup->ponno_name." / ".$v->ponno_size_setup->ponno_size." / ".$v->ponno_marka_setup->ponno_marka." ".$edited."</option>";
        }

        return $select;
    }

    public function loadArodChothaTable(Request $request)
    {
        $purchase = ponno_purchase_entry::where('id', $request->purchase_id)
                ->whereIn('ponno_purchase_entries.id', function ($query) {
                    $query->select('purchase_id')
                        ->from('stocks')->where('quantity',0);
                })->first();

       

        $arod_chotha = arod_chotha_entry::where('purchase_id',$purchase->id)->count();

        if($arod_chotha > 0)
        {
            $sales = arod_chotha_entry::where('purchase_id', $purchase->id)->get(); 
            return view('user.entry_user.arod_cotha_info_edited',compact('purchase','sales'));
        }
        else
        {
            $sales = ponno_sales_entry::where('purchase_id', $purchase->id)->get(); 
            return view('user.entry_user.arod_cotha_info',compact('purchase','sales'));
        }

        
    }



    public function arod_chotha_memo($id)
    {
        $purchase = ponno_purchase_entry::where('id',$id)->first();

        $sales = arod_chotha_entry::where('purchase_id', $purchase->id)->get(); 
        
        return view('user.entry_user.arod_chotha_memo',compact('purchase','sales'));
    }
}
