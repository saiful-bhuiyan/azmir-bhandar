<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;

class UserSetupController extends Controller
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
            $data = User::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('name',function($v){
                return $v->name;
            })
            ->addColumn('email',function($v){
                return $v->email;
            })
            ->addColumn('action',function($v){

                return '<div class="flex gap-x-2">
                    <a href="'.route('user_setup.edit', $v->id).'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ইডিট</a>

                    <form method="post" action="'.route('user_setup.destroy',$v->id).'" id="deleteForm">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                        <button onclick="return confirmation();" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        ডিলিট</button>
                    </form>
                  
                    </div>';
            })

            ->rawColumns(['sl','name','email','action'])
            ->make(true);
        }
        return view('admin.user_setup.index');
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
                'email' => 'required|unique:users|max:50',
                'password' => 'required|max:20|min:6',
            ],
            [
                'name.required'=>'দয়া করে নাম ইনপুট করুন',
                'name.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'email.required'=>'দয়া করে ইমেইল ইনপুট করুন',
                'email.max'=>'৫০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'email.unique'=>'এই ইমেইল পুর্বে ব্যবহার করা হয়েছে',
                'password.min'=>'কমপক্ষে ৬টি অক্ষর বাধ্যতামুলক',
                'password.max'=>'২০টি অক্ষর এর অধিক গ্রহনযোগ্য নয়',
                'password.required'=>'দয়া করে পাসওয়ার্ড ইনপুট করুন',
            ]);
    
            $data = array(
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            );

            $insert = User::create($data);
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
}
