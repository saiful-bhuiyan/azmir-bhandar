<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\ponno_marka_setup;
use Illuminate\Database\QueryException;

class PonnoMarkaSetupController extends Controller
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
            $data = ponno_marka_setup::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('ponno_marka',function($v){
                return $v->ponno_marka;
            })

            ->rawColumns(['sl','ponno_marka'])
            ->make(true);
        }
        return view('user.setup_user.ponno_marka_setup');
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
                'ponno_marka' => 'required|max:50',
            ],
            [
                'ponno_marka.required'=>'দয়া করে পন্যের মার্কা ইনপুট করুন',
                'ponno_marka.max'=>'৫০টি এর বেশি অক্ষর গ্রহনযোগ্য না',
            ]);
    
            $data = array(
                'ponno_marka'=>$request->ponno_marka,
            );
    
            $insert = ponno_marka_setup::create($data);
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
        $data = ponno_marka_setup::find($id);
        return view('user.setup_admin.ponno_marka_setup',compact('data'));
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
                'ponno_marka' => 'required|max:50',
            ],
            [
                'ponno_marka.required'=>'দয়া করে পন্যের মার্কা ইনপুট করুন',
                'ponno_marka.max'=>'৫০টি এর বেশি অক্ষর গ্রহনযোগ্য না',
            ]);
    
            $data = array(
                'ponno_marka'=>$request->ponno_marka,
            );

        $update = ponno_marka_setup::find($id)->update($data);
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
            ponno_marka_setup::destroy($id);
            Toastr::success(__('ডিলিট সফল হয়েছে'), __('সফল'));
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                Toastr::error(__('ডিলিট সফল হয়নি'), __('ব্যর্থ'));
            }
        }
        return redirect()->back();
    }

    public function admin(Request $request)
    {
         if ($request->ajax()) {
            $data = ponno_marka_setup::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('ponno_marka',function($v){
                return $v->ponno_marka;
            })
            ->addColumn('action',function($v){

                return '<div class="flex gap-x-2">
                    <a href="'.route('ponno_marka_setup.edit', $v->id).'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ইডিট</a>

                    <form method="post" action="'.route('ponno_marka_setup.destroy',$v->id).'" id="deleteForm">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                        <button onclick="return confirmation();" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        ডিলিট</button>
                    </form>
                  
                    </div>';
            })

            ->rawColumns(['sl','ponno_marka','action'])
            ->make(true);
        }
        return view('user.setup_admin.ponno_marka_setup');
    }
}
