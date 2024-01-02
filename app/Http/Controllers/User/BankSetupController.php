<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\bank_setup;
use Illuminate\Database\QueryException;

class BankSetupController extends Controller
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
            $data = bank_setup::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('bank_name',function($v){
                return $v->bank_name;
            })
            ->addColumn('account_name',function($v){
                return $v->account_name;
            })
            ->addColumn('account_no',function($v){
                return $v->account_no;
            })
            ->addColumn('shakha',function($v){
                return $v->shakha;
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
                    <input type="checkbox" class="checkbox" id="bankSetupStatus" '.$check.' onclick="return bankSetupStatusChange('.$v->id.')">
                    <div class="slider"></div>
                </label>';
            })

            ->rawColumns(['sl','bank_name','account_name','account_no','shakha','status'])
            ->make(true);
        }
        return view('user.setup_user.bank_setup');
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
                'bank_name' => 'required|max:50',
                'account_name' => 'required|max:50',
                'account_no' => 'required|unique:bank_setups|max:50|min:3',
                'shakha' => 'required|max:50',
            ],
            [
                'bank_name.required'=>'দয়া করে ব্যাংকের নাম ইনপুট করুন',
                'bank_name.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'account_name.required'=>'দয়া করে একাউন্টের নাম ইনপুট করুন',
                'account_name.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'account_no.required'=>'দয়া করে একাউন্ট নাম্বার ইনপুট করুন',
                'account_no.unique'=>'এই একাউন্ট নাম্বার পুর্বে ব্যবহার করা হয়েছে',
                'account_no.min'=>'কমপক্ষে ৩টি সংখ্যা বাধ্যতামুলক',
                'account_no.max'=>'৫০টি সংখ্যার অধিক গ্রহনযোগ্য নয়',
                'shakha.required'=>'দয়া করে শাখা ইনপুট করুন',
                'shakha.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
            ]);
    
            $data = array(
                'bank_name'=>$request->bank_name,
                'account_name'=>$request->account_name,
                'account_no'=>$request->account_no,
                'shakha'=>$request->shakha,
            );
    
            $insert = bank_setup::create($data);
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
        $data = bank_setup::find($id);
        return view('user.setup_admin.bank_setup',compact('data'));
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
                'bank_name' => 'required|max:50',
                'account_name' => 'required|max:50',
                'account_no' => 'required|max:50|min:3',
                'shakha' => 'required|max:50',
            ],
            [
                'bank_name.required'=>'দয়া করে ব্যাংকের নাম ইনপুট করুন',
                'bank_name.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'account_name.required'=>'দয়া করে একাউন্টের নাম ইনপুট করুন',
                'account_name.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'account_no.required'=>'দয়া করে একাউন্ট নাম্বার ইনপুট করুন',
                'account_no.min'=>'কমপক্ষে ৩টি সংখ্যা বাধ্যতামুলক',
                'account_no.max'=>'৫০টি সংখ্যার অধিক গ্রহনযোগ্য নয়',
                'shakha.required'=>'দয়া করে শাখা ইনপুট করুন',
                'shakha.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
            ]);
    
            $data = array(
                'bank_name'=>$request->bank_name,
                'account_name'=>$request->account_name,
                'account_no'=>$request->account_no,
                'shakha'=>$request->shakha,
            );

            $update = bank_setup::find($id)->update($data);
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
            bank_setup::destroy($id);
            Toastr::success(__('ডিলিট সফল হয়েছে'), __('সফল'));
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                Toastr::error(__('ডিলিট সফল হয়নি'), __('ব্যর্থ'));
            }
        }
        return redirect()->back();
    }

    public function bankSetupStatusChange($id)
    {
        $data = bank_setup::find($id);

        if($data->status == 1)
        {
            bank_setup::find($id)->update(['status'=>0]);
        }
        else
        {
            bank_setup::find($id)->update(['status'=>1]);
        }

        return 1;
    }

    public function admin(Request $request)
    {
         if ($request->ajax()) {
            $data = bank_setup::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('bank_name',function($v){
                return $v->bank_name;
            })
            ->addColumn('account_name',function($v){
                return $v->account_name;
            })
            ->addColumn('account_no',function($v){
                return $v->account_no;
            })
            ->addColumn('shakha',function($v){
                return $v->shakha;
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
                    <input type="checkbox" class="checkbox" id="bankSetupStatus" '.$check.' onclick="return bankSetupStatusChange('.$v->id.')">
                    <div class="slider"></div>
                </label>';
            })
            ->addColumn('action',function($v){

                return '<div class="flex gap-x-2">
                    <a href="'.route('bank_setup.edit', $v->id).'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ইডিট</a>

                    <form method="post" action="'.route('bank_setup.destroy',$v->id).'" id="deleteForm">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                        <button onclick="return confirmation();" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        ডিলিট</button>
                    </form>
                  
                    </div>';
            })

            ->rawColumns(['sl','bank_name','account_name','account_no','shakha','status','action'])
            ->make(true);
        }
        return view('user.setup_admin.bank_setup');
    }
}
