<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\other_joma_khoroc_setup;
use Illuminate\Database\QueryException;

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
                'mobile' => 'required|max:15',
            ],
            [
                'name.required'=>'দয়া করে খাতের নাম ইনপুট করুন',
                'name.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'address.required'=>'দয়া করে ঠিকানা ইনপুট করুন',
                'address.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'mobile.required'=>'দয়া করে মোবাইল নাম্বার ইনপুট করুন',
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
        $data = other_joma_khoroc_setup::find($id);
        return view('user.setup_admin.other_joma_khoroc_setup',compact('data'));
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
                'name' => 'required|max:50',
                'address' => 'required|max:50',
                'mobile' => 'required|max:15|min:3',
            ],
            [
                'name.required'=>'দয়া করে খাতের নাম ইনপুট করুন',
                'name.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'address.required'=>'দয়া করে ঠিকানা ইনপুট করুন',
                'address.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'mobile.required'=>'দয়া করে মোবাইল নাম্বার ইনপুট করুন',
                'mobile.min'=>'কমপক্ষে ৩টি সংখ্যা বাধ্যতামুলক',
                'mobile.max'=>'১৫টি সংখ্যার অধিক গ্রহনযোগ্য নয়',
            ]);
    
            $data = array(
                'name'=>$request->name,
                'address'=>$request->address,
                'mobile'=>$request->mobile,
            );

            $update = other_joma_khoroc_setup::find($id)->update($data);
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
        try {
            other_joma_khoroc_setup::destroy($id);
            Toastr::success(__('ডিলিট সফল হয়েছে'), __('সফল'));
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                Toastr::error(__('ডিলিট সফল হয়নি'), __('ব্যর্থ'));
            }
        }
        return redirect()->back();
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

    public function admin(Request $request)
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
            ->addColumn('action',function($v){

                return '<div class="flex gap-x-2">
                    <a href="'.route('other_joma_khoroc_setup.edit', $v->id).'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ইডিট</a>

                    <form method="post" action="'.route('other_joma_khoroc_setup.destroy',$v->id).'" id="deleteForm">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                        <button onclick="return confirmation();" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        ডিলিট</button>
                    </form>
                  
                    </div>';
            })

            ->rawColumns(['sl','name','address','mobile','status','action'])
            ->make(true);
        }
        return view('user.setup_admin.other_joma_khoroc_setup');
    }
}
