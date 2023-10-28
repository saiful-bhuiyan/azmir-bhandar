<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\other_joma_khoroc_setup;

class OtherJomaKhorocSetupController extends Controller
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
            $data = other_joma_khoroc_setup::all();
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
                    <input type="checkbox" class="checkbox" id="otherJomaKhorocSetupStatus" '.$check.' onclick="return otherJomaKhorocSetupStatusChange('.$v->id.')">
                    <div class="slider"></div>
                </label>';
            })

            ->rawColumns(['sl','name','address','mobile','status'])
            ->make(true);
        }
        return view('user.setup_user.other_joma_khoroc_setup');
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
                'mobile' => 'required|unique:hawlat_setups|max:15|min:3',
            ],
            [
                'name.required'=>'দয়া করে খাতের নাম ইনপুট করুন',
                'name.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'address.required'=>'দয়া করে ঠিকানা ইনপুট করুন',
                'address.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'mobile.required'=>'দয়া করে মোবাইল নাম্বার ইনপুট করুন',
                'mobile.unique'=>'এই নাম্বার পুর্বে ব্যবহার করা হয়েছে',
                'mobile.min'=>'কমপক্ষে ৩টি সংখ্যা বাধ্যতামুলক',
                'mobile.max'=>'১৫টি সংখ্যার অধিক গ্রহনযোগ্য নয়',
            ]);
    
            $data = array(
                'name'=>$request->name,
                'address'=>$request->address,
                'mobile'=>$request->mobile,
            );
    
            $insert = other_joma_khoroc_setup::create($data);
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

    public function otherJomaKhorocSetupStatusChange($id)
    {
        $data = other_joma_khoroc_setup::find($id);

        if($data->status == 1)
        {
            other_joma_khoroc_setup::find($id)->update(['status'=>0]);
        }
        else
        {
            other_joma_khoroc_setup::find($id)->update(['status'=>1]);
        }

        return 1;
    }
}
