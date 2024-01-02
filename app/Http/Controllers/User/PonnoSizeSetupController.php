<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\ponno_size_setup;
use Illuminate\Database\QueryException;


class PonnoSizeSetupController extends Controller
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
            $data = ponno_size_setup::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('ponno_size',function($v){
                return $v->ponno_size;
            })

            ->rawColumns(['sl','ponno_size'])
            ->make(true);
        }
        return view('user.setup_user.ponno_size_setup');
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
                'ponno_size' => 'required',
            ],
            [
                'ponno_size.required'=>'দয়া করে পন্যের সাইজ ইনপুট করুন',
            ]);
    
            $data = array(
                'ponno_size'=>$request->ponno_size,
            );
    
            $insert = ponno_size_setup::create($data);
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
        $data = ponno_size_setup::find($id);
        return view('user.setup_admin.ponno_size_setup',compact('data'));
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
                'ponno_size' => 'required',
            ],
            [
                'ponno_size.required'=>'দয়া করে পন্যের সাইজ ইনপুট করুন',
            ]);
    
            $data = array(
                'ponno_size'=>$request->ponno_size,
            );
    
            $update = ponno_size_setup::find($id)->update($data);
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
            ponno_size_setup::destroy($id);
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
            $data = ponno_size_setup::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('ponno_size',function($v){
                return $v->ponno_size;
            })
            ->addColumn('action',function($v){

                return '<div class="flex gap-x-2">
                    <a href="'.route('ponno_size_setup.edit', $v->id).'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ইডিট</a>

                    <form method="post" action="'.route('ponno_size_setup.destroy',$v->id).'" id="deleteForm">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                        <button onclick="return confirmation();" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        ডিলিট</button>
                    </form>
                  
                    </div>';
            })

            ->rawColumns(['sl','ponno_size','action'])
            ->make(true);
        }
        return view('user.setup_admin.ponno_size_setup');
    }
}
