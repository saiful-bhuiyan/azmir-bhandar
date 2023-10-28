<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\mohajon_setup;
use App\Models\ponno_setup;
use App\Models\ponno_size_setup;
use App\Models\ponno_marka_setup;
use App\Models\ponno_purchase_entry;
use App\Models\stock;

class PonnoPurchaseEntryController extends Controller
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
            $data = ponno_purchase_entry::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($row){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('mohajon',function($v){
                return $v->mohajon_setup->area.'/'.$v->mohajon_setup->address.'/'.$v->mohajon_setup->name;
            })
            ->addColumn('purchase_type',function($v){
                if($v->purchase_type == 1)
                {
                    return 'নিজ খরিদ';
                }
                else
                {
                    return 'কমিশন';
                }
            })
            ->addColumn('ponno_name',function($v){
                return $v->ponno_setup->ponno_name;
            })
            ->addColumn('ponno_size',function($v){
                return $v->ponno_size_setup->ponno_size;
            })
            ->addColumn('ponno_marka',function($v){
                return $v->ponno_marka_setup->ponno_marka;
            })
            ->addColumn('gari_no',function($v){
                return $v->gari_no;
            })
            ->addColumn('quantity',function($v){
                return $v->quantity;
            })
            ->addColumn('weight',function($v){
                return $v->weight;
            })
            ->addColumn('rate',function($v){
                return $v->rate ? $v->rate : '-';
            })
            ->addColumn('labour_cost',function($v){
                return $v->labour_cost;
            })
            ->addColumn('other_cost',function($v){
                return $v->other_cost;
            })
            ->addColumn('truck_cost',function($v){
                return $v->truck_cost;
            })
            ->addColumn('total_taka',function($v){
                if($v->purchase_type == 1)
                {
                    $total = $v->weight * $v->rate;
                    $total +=$v->labour_cost;
                    $total +=$v->other_cost;
                    $total +=$v->truck_cost;

                    return $total;
                }
                else
                {
                    return '-';
                }
            })
            ->addColumn('action',function($row){
                return '<form action="'.route('ponno_purchase_entry.destroy',$row->id).'" method="POST" id="DeleteForm">
                '.csrf_field().'
                '.method_field('DELETE').'
                 <button onclick="return confirmation();" type="submit" class="bg-red-500 hover:bg-red-700 text-white
                 font-bold py-2 px-4 rounded">ডিলিট</button>
                 <form/>';
            })
            
             ->rawColumns(['sl','mohajon','purchase_type','ponno_name','ponno_size','ponno_marka','gari_no','quantity',
             'weight','rate','labour_cost','other_cost','truck_cost','total_taka','action'])
             ->make(true);
         }
 
         $mohajon_setup = mohajon_setup::where('status',1)->get();

        $ponno_setup = ponno_setup::all();

        $ponno_size_setup = ponno_size_setup::all();
        
        $ponno_marka_setup = ponno_marka_setup::all();

        return view('user.entry_user.ponno_purchase_entry',compact('mohajon_setup','ponno_setup','ponno_size_setup','ponno_marka_setup'));
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
                'purchase_type' => 'required',
                'mohajon_setup_id' => 'required',
                'ponno_setup_id' => 'required',
                'size_id' => 'required',
                'marka_id' => 'required',
                'quantity' => 'required|numeric',
                'weight' => 'required|numeric',
            ],
            [
                'purchase_type.required'=>'দয়া করে ধরণ সিলেক্ট করুন',
                'mohajon_setup_id.required'=>'দয়া করে মহাজনের সিলেক্ট করুন',
                'ponno_setup_id.required'=>'দয়া করে পন্যের নাম সিলেক্ট করুন',
                'size_id.required'=>'দয়া করে পন্যের সাইজ সিলেক্ট করুন',
                'marka_id.required'=>'দয়া করে পন্যের মার্কা সিলেক্ট করুন',
                'quantity.required'=>'দয়া করে সংখ্যা ইনপুট করুন',
                'quantity.numeric'=>'সংখ্যা ইনপুট করুন',
                'weight.required'=>'দয়া করে ওজন ইনপুট করুন',
                'weight.numeric'=>'সংখ্যা ইনপুট করুন',
            ]);

            $data = array(
                'purchase_type'=>$request->purchase_type,
                'mohajon_setup_id'=>$request->mohajon_setup_id,
                'ponno_setup_id'=>$request->ponno_setup_id,
                'size_id'=>$request->size_id,
                'marka_id'=>$request->marka_id,
                'gari_no'=>$request->gari_no,
                'quantity'=>$request->quantity,
                'weight'=>$request->weight,
                'labour_cost'=>$request->labour_cost ? $request->labour_cost : 0,
                'other_cost'=>$request->other_cost ? $request->other_cost : 0,
                'truck_cost'=>$request->truck_cost ? $request->truck_cost : 0,
            );
            
            if($request->purchase_type == 1)
            {
                $khorid_validate = $request->validate(
                [
                    'rate' => 'required|numeric',
                ],
                [
                    'rate.required'=>'দয়া করে দর ইনপুট করুন',
                ]);

                $data['rate'] = $request->rate;
            }

            $insert = ponno_purchase_entry::create($data);

            if($insert)
            {
                
                $stock = array(
                    'purchase_id'=>$insert->id,
                    'quantity'=>$request->quantity,
                    'weight'=>$request->weight,
                );

                stock::create($stock);

                Toastr::success(__('এড কার্ট সফল হয়েছে'), __('সফল'));
            }
            else
            {
                Toastr::error(__('এড কার্ট সফল হয়নি'), __('ব্যর্থ'));
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
}
