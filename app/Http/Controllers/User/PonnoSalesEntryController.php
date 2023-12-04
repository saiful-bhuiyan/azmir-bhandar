<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\kreta_setup;
use App\Models\mohajon_commission_setup;
use App\Models\kreta_commission_setup;
use App\Models\ponno_purchase_entry;
use App\Models\temp_ponno_sale;
use App\Models\ponno_sales_info;
use App\Models\ponno_sales_entry;
use App\Models\stock;
use Carbon\Carbon;

class PonnoSalesEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $sl;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = temp_ponno_sale::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($row){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('mohajon_address',function($v){
                return $v->ponno_purchase_entry->mohajon_setup->area.'/'.$v->ponno_purchase_entry->mohajon_setup->address;
            })
            ->addColumn('mohajon_name',function($v){
                return $v->ponno_purchase_entry->mohajon_setup->name;
            })
            ->addColumn('ponno_name',function($v){
                return $v->ponno_purchase_entry->ponno_setup->ponno_name;
            })
            ->addColumn('size',function($v){
                return $v->ponno_purchase_entry->ponno_size_setup->ponno_size;
            })
            ->addColumn('marka',function($v){
                return $v->ponno_purchase_entry->ponno_marka_setup->ponno_marka;
            })
            ->addColumn('purchase_qty',function($v){
                return $v->ponno_purchase_entry->quantity;
            })
            ->addColumn('sales_qty',function($v){
                return $v->sales_qty;
            })
            ->addColumn('sales_weight',function($v){
                return $v->sales_weight;
            })
            ->addColumn('total_taka',function($v){

                    $total = $v->sales_weight * $v->sales_rate;
                    $total +=$v->labour;
                    $total +=$v->other;
                    $total +=$v->kreta_commission;

                    return $total;
 
            })
            ->addColumn('action',function($row){
                return '<form action="'.route('ponno_sales_entry.destroy',$row->id).'" method="POST" id="DeleteForm">
                '.csrf_field().'
                '.method_field('DELETE').'
                 <button onclick="return confirmation();" type="submit" class="bg-red-500 hover:bg-red-700 text-white
                 font-bold py-2 px-4 rounded">ডিলিট</button>
                 <form/>';
            })
            
             ->rawColumns(['sl','mohajon_address','mohajon_name','ponno_name','size','marka','purchase_qty','sales_qty',
             'sales_weight','total_taka','action'])
             ->make(true);
         }

        $stock = stock::where('quantity' ,'>', 0)->get();
        $kreta_area = kreta_setup::select('area')->groupBy('area')->where('status',1)->get();
        return view('user.entry_user.ponno_sales_entry',compact('stock','kreta_area'));
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

            if($request->read_current_qty >= $request->sales_qty && $request->read_current_weight >= $request->sales_weight)
            {
                $data = array(
                    'purchase_id'=>$request->purchase_id,
                    'sales_qty'=>$request->sales_qty,
                    'sales_weight'=>$request->sales_weight,
                    'sales_rate'=>$request->sales_rate,
                    'labour'=>$request->labour ? $request->labour : 0,
                    'other'=>$request->other ? $request->other : 0,
                );

                $purchase = ponno_purchase_entry::where('id',$request->purchase_id)->first();

                $mohajon = mohajon_commission_setup::where('ponno_setup_id',$purchase->ponno_setup->id)->first();

                $kreta = kreta_commission_setup::where('ponno_setup_id',$purchase->ponno_setup->id)->first();

                $mohajon_commission = intval($mohajon->commission_amount * $request->sales_weight);
                $kreta_commission = intval($kreta->commission_amount * $request->sales_weight);

                $data['mohajon_commission'] = $mohajon_commission;
                $data['kreta_commission'] = $kreta_commission;


                $insert = temp_ponno_sale::create($data);

                if($insert)
                {
                    $stock = stock::where('purchase_id',$request->purchase_id)->first();
                    $update_qty = $stock->quantity - $request->sales_qty;
                    $update_weight = $stock->weight - $request->sales_weight;
                    $update_stock = array(
                        'quantity'=>$update_qty,
                        'weight'=>$update_weight,
                    );
                    stock::where('purchase_id',$request->purchase_id)->update($update_stock);

                    Toastr::success(__('এড কার্ট সফল হয়েছে'), __('সফল'));
                }
                else
                {
                    Toastr::error(__('এড কার্ট সফল হয়নি'), __('ব্যর্থ'));
                }
            }
            else
            {
                Toastr::error(__('সঠিক তথ্য ইনপুট করুন'), __('ব্যর্থ'));
            }
    
            return redirect()->back();
    }


    public function storePonnoSales(Request $request)
    {
        $validated = $request->validate(
        [
            'sales_type' => 'required',
            'marfot' => 'required',
        ],
        [
            'sales_type.required'=>'দয়া করে বিক্রির ধরণ সিলেক্ট করুন',
            'marfot.required'=>'দয়া করে মারফতের নাম ইনপুট করুন',
        ]);

        $data = array(
            'sales_type'=>$request->sales_type,
            'marfot'=>$request->marfot,
            'discount'=>$request->discount ? $request->discount : 0,
            'entry_date'=> Carbon::now(),
        );

        if($request->sales_type == 1)
        {
            $request->validate(
            [
                'cash_kreta_address' => 'required',
                'cash_kreta_name' => 'required',
                'cash_kreta_mobile' => 'required',
            ],
            [
                'cash_kreta_address.required'=>'দয়া করে ক্রেতার ঠিকানা ইনপুট করুন',
                'cash_kreta_name.required'=>'দয়া করে ক্রেতার নাম ইনপুট করুন',
                'cash_kreta_mobile.required'=>'দয়া করে ক্রেতার মোবাইল ইনপুট করুন',
            ]);
            
            $data['cash_kreta_address'] = $request->cash_kreta_address;
            $data['cash_kreta_name'] = $request->cash_kreta_name;
            $data['cash_kreta_mobile'] = $request->cash_kreta_name;
        }
        else
        {
            $request->validate(
            [
                'kreta_setup_id' => 'required',
            ],
            [
                'kreta_setup_id.required'=>'দয়া করে ক্রেতার নাম সিলেক্ট করুন',
            ]);

            $data['kreta_setup_id'] = $request->kreta_setup_id;

        }

        $insert = ponno_sales_info::create($data);
        if($insert)
        {
            $temp_sale = temp_ponno_sale::all();
            foreach($temp_sale as $t)
            {
                $sales_data = array(
                    'sales_invoice'=>$insert->id,
                    'purchase_id'=>$t->purchase_id,
                    'sales_qty'=>$t->sales_qty,
                    'sales_weight'=>$t->sales_weight,
                    'sales_rate'=>$t->sales_rate,
                    'labour'=>$t->labour,
                    'other'=>$t->other,
                    'mohajon_commission'=>$t->mohajon_commission,
                    'kreta_commission'=>$t->kreta_commission,
                );
                ponno_sales_entry::create($sales_data);
            }
            if($temp_sale)
            {
                temp_ponno_sale::truncate();
            }
            Toastr::success(__('বিক্রয় সফল হয়েছে'), __('সফল'));
        }
        else
        {
            Toastr::error(__('বিক্রয় সফল হয়নি'), __('ব্যর্থ'));
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
        $temp_sale = temp_ponno_sale::find($id)->first();

        $stock = stock::where('purchase_id',$temp_sale->purchase_id)->first();

        $update_qty = $stock->quantity + $temp_sale->sales_qty;
        $update_weight = $stock->weight + $temp_sale->sales_weight;

        $update_stock = array(
            'quantity'=>$update_qty,
            'weight'=>$update_weight,
        );

        $update = stock::where('purchase_id',$temp_sale->purchase_id)->update($update_stock);

        if($update)
        {
            temp_ponno_sale::find($id)->delete();

            Toastr::success(__('ডিলিট সফল হয়েছে'), __('সফল'));
        }
        else
        {
            Toastr::error(__('ডিলিট সফল হয়নি'), __('ব্যর্থ'));
        }

        return redirect()->back();
    }

    public function getPurchaseDetail(Request $request)
    {
        $ponno_purchase = ponno_purchase_entry::where('id',$request->purchase_id)->first();
        
        $data = array(
            'mohajon_area'=>$ponno_purchase->mohajon_setup->area,
            'mohajon_address'=>$ponno_purchase->mohajon_setup->address,
            'mohajon_name'=>$ponno_purchase->mohajon_setup->name,
            'ponno_name'=>$ponno_purchase->ponno_setup->ponno_name,
            'ponno_size'=>$ponno_purchase->ponno_size_setup->ponno_size,
            'ponno_marka'=>$ponno_purchase->ponno_marka_setup->ponno_marka,
            'gari_no'=>$ponno_purchase->gari_no,
            'purchase_qty'=>$ponno_purchase->quantity,
            'purchase_weight'=>$ponno_purchase->weight,
            'read_rate'=>$ponno_purchase->rate,
            'kreta_com_per_kg'=>$ponno_purchase->ponno_setup->kreta_commission_setup->commission_amount,
        );

        $stock = stock::where('purchase_id',$request->purchase_id)->first();

        $sales_qty = $stock->ponno_purchase_entry->quantity - $stock->quantity;
        $sales_weight = $stock->ponno_purchase_entry->weight - $stock->weight;
        $read_current_qty = $stock->quantity;
        $read_current_weight = $stock->weight;

        $data['read_sales_qty'] = $sales_qty;
        $data['read_sales_weight'] = $sales_weight;
        $data['read_current_qty'] = $read_current_qty;
        $data['read_current_weight'] = $read_current_weight;

        return json_encode($data);
    }

    public function getAmountByKreta(Request $request)
    {
        $temp_sale = temp_ponno_sale::all();

        $sale_amount = 0;

        foreach($temp_sale as $t)
        {
            $sale_amount += ($t->sales_weight * $t->sales_rate) + $t->kreta_commission + $t->labour + $t->other;
        }

        $amount = array(
            'old_amount'=>0,
            'current_amount'=>$sale_amount
        );

        return json_encode($amount);
    }

}
