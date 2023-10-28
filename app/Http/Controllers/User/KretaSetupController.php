<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\kreta_setup;

class KretaSetupController extends Controller
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
            $data = kreta_setup::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($row){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('name',function($v){
                return $v->name;
            })
            ->addColumn('address',function($v){
                return $v->address;
            })
            ->addColumn('mobile',function($v){
                return $v->mobile;
            })
            ->addColumn('area',function($v){
                return $v->area;
            })
            ->addColumn('old_amount',function($v){
                return $v->old_amount;
            })
            ->addColumn('status',function($v){
                if($v->status == 1)
                {
                    $check = 'checked';
                }
                else
                {
                    $check = '';
                }

                return '<label class="switch">
                    <input type="checkbox" class="checkbox" id="kretaSetupStatus" '.$check.' onclick="return kretaSetupStatusChange('.$v->id.')">
                    <div class="slider"></div>
                </label>';
            })

            ->rawColumns(['sl','name','address','mobile','area','old_amount','status'])
            ->make(true);
        }
        return view('user.setup_user.kreta_setup');
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
                'name' => 'required|max:50',
                'address' => 'required|max:50',
                'mobile' => 'required|unique:kreta_setups|max:15|min:3',
                'area' => 'required|max:50',
                'old_amount' => 'required|max:20|regex:/^\d+(\.\d{1,2})?$/',
            ],
            [
                'name.required'=>'দয়া করে নাম ইনপুট করুন',
                'name.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'address.required'=>'দয়া করে ঠিকানা ইনপুট করুন',
                'address.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'mobile.required'=>'দয়া করে মোবাইল নাম্বার ইনপুট করুন',
                'mobile.unique'=>'এই নাম্বার পুর্বে ব্যবহার করা হয়েছে',
                'mobile.min'=>'কমপক্ষে ৩টি সংখ্যা বাধ্যতামুলক',
                'mobile.max'=>'১৫টি সংখ্যার অধিক গ্রহনযোগ্য নয়',
                'area.required'=>'দয়া করে এরিয়া ইনপুট করুন',
                'area.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'old_amount.required'=>'দয়া করে সাবেক দেনা ইনপুট করুন',
                'old_amount.max'=>'২০টি সংখ্যার অধিক গ্রহনযোগ্য নয়',
                'old_amount.regex'=>'দয়া করে সংখ্যা ইনপুট করুন',
            ]);
    
            $data = array(
                'name'=>$request->name,
                'address'=>$request->address,
                'mobile'=>$request->mobile,
                'area'=>$request->area,
                'old_amount'=>$request->old_amount,
            );
    
            $insert = kreta_setup::create($data);
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

    public function kretaSetupStatusChange($id)
    {
        $data = kreta_setup::find($id);

        if($data->status == 1)
        {
            kreta_setup::find($id)->update(['status'=>0]);
        }
        else
        {
            kreta_setup::find($id)->update(['status'=>1]);
        }

        return 1;
    }
}
