<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\kreta_commission_setup;
use App\Models\ponno_setup;

class KretaCommissionSetupController extends Controller
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
            $data = kreta_commission_setup::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('ponno_name',function($v){
                return $v->ponno_setup->ponno_name;
            })
            ->addColumn('commission_amount',function($v){
                return number_format($v->commission_amount, 2);
            })
            
            ->rawColumns(['sl','ponno_name','commission_amount'])
            ->make(true);
        }

        $ponno_setup = ponno_setup::whereNotIn('id',function($query) {
            $query->select('ponno_setup_id')->from('kreta_commission_setups');
        })->get();

        return view('user.setup_user.kreta_commission_setup',compact('ponno_setup'));
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
                'ponno_setup_id' => 'required|unique:kreta_commission_setups',
                'commission_amount' => 'required|max:4|numeric',
            ],
            [
                'ponno_setup_id.required'=>'দয়া করে পন্যের নাম সিলেক্ট করুন',
                'ponno_setup_id.unique'=>'এই পন্যের নাম পুর্বে ব্যবহার করা হয়েছে',
                'commission_amount.required'=>'দয়া করে ক্রেতা কমিশন ইনপুট করুন',
                'commission_amount.max'=>'৪টি সংখ্যার অধিক গ্রহনযোগ্য নয়',
                'commission_amount.numeric'=>'দয়া করে সংখ্যা ইনপুট করুন',
            ]);
    
            $data = array(
                'ponno_setup_id'=>$request->ponno_setup_id,
                'commission_amount'=>$request->commission_amount,
            );
    
            $insert = kreta_commission_setup::create($data);
            if($insert)
            {
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
        $data = kreta_commission_setup::find($id);
        return view('user.setup_admin.kreta_commission_setup',compact('data'));
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
        $validated = $request->validate(
            [
                'ponno_setup_id' => 'required',
                'commission_amount' => 'required|max:4|numeric',
            ],
            [
                'ponno_setup_id.required'=>'দয়া করে পন্যের নাম সিলেক্ট করুন',
                'commission_amount.required'=>'দয়া করে ক্রেতা কমিশন ইনপুট করুন',
                'commission_amount.max'=>'৪টি সংখ্যার অধিক গ্রহনযোগ্য নয়',
                'commission_amount.numeric'=>'দয়া করে সংখ্যা ইনপুট করুন',
            ]);
    
            $data = array(
                'ponno_setup_id'=>$request->ponno_setup_id,
                'commission_amount'=>$request->commission_amount,
            );

            $update = kreta_commission_setup::find($id)->update($data);
            if($update)
            {
                Toastr::success(__('আপডেট সফল হয়েছে'), __('সফল'));
            }
            else
            {
                Toastr::error(__('আপডেট সফল হয়নি'), __('ব্যর্থ'));
            }
    
            return redirect()->back();
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

    public function admin(Request $request)
    {
         if ($request->ajax()) {
            $data = kreta_commission_setup::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('ponno_name',function($v){
                return $v->ponno_setup->ponno_name;
            })
            ->addColumn('commission_amount',function($v){
                return number_format($v->commission_amount, 2);
            })
            ->addColumn('action',function($v){

                return '<a href="'.route('kreta_commission_setup.edit', $v->id).'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold my-1 py-1 px-4 rounded">
                ইডিট</a>';
            })
            
            ->rawColumns(['sl','ponno_name','commission_amount','action'])
            ->make(true);
        }
        return view('user.setup_admin.kreta_commission_setup');
    }
}
