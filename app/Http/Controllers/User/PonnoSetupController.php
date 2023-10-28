<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\ponno_setup;

class PonnoSetupController extends Controller
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
            $data = ponno_setup::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($row){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('ponno_name',function($v){
                return $v->ponno_name;
            })

            ->rawColumns(['sl','ponno_name'])
            ->make(true);
        }
        return view('user.setup_user.ponno_setup');
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
            'ponno_name' => 'required|max:50',
        ],
        [
            'ponno_name.required'=>'দয়া করে পন্যের নাম ইনপুট করুন',
            'ponno_name.max'=>'৫০টি এর বেশি অক্ষর গ্রহনযোগ্য না',
        ]);

        $data = array(
            'ponno_name'=>$request->ponno_name,
        );

        $insert = ponno_setup::create($data);
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
