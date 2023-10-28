<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\bank_setup;
use App\Models\check_book_page_setup;
use App\Models\bank_entry;

class BankEntryController extends Controller
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
            $data = bank_entry::whereDay('updated_at', now()->day)->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($row){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('type',function($v){
                if($v->type == 1)
                {
                    return 'জমা';
                }
                else
                {
                    return 'উত্তোলন';
                }
                
            })
            ->addColumn('bank_setup_id',function($v){
                return $v->bank_setup->bank_name.'/'.$v->bank_setup->account_name;
            })
            ->addColumn('check_id',function($v){
                if($v->check_id == null or "")
                {
                    return '-';
                }
                else
                {
                    return $v->check_book_page_setup->page;
                }
            })
            ->addColumn('marfot',function($v){
                return $v->marfot;
            })
            ->addColumn('taka',function($v){
                return $v->taka;
            })

            ->rawColumns(['sl','type','bank_setup_id','check_id','marfot','taka'])
            ->make(true);
        }

        $bank_setup = bank_setup::all();
        return view('user.entry_user.bank_entry',compact('bank_setup'));
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
                'type' => 'required',
                'bank_setup_id' => 'required',
                'marfot' => 'required',
                'taka' => 'required|numeric',
            ],
            [
                'type.required'=>'দয়া ব্যাংক জমা/উত্তোলন সিলেক্ট করুন',
                'bank_setup_id.required'=>'দয়া করে ব্যাংক তথ্য সিলেক্ট করুন',
                'marfot.required'=>'দয়া করে মারফত ইনপুট করুন',
                'taka.required'=>'দয়া করে টাকা ইনপুট করুন',
                'taka.numeric'=>'সংখ্যা ইনপুট করুন',
            ]);

            
            
            if($request->type == 2)
            {
                $data = array(
                    'type'=>$request->type,
                    'bank_setup_id'=>$request->bank_setup_id,
                    'check_id'=>$request->check_id,
                    'marfot'=>$request->marfot,
                    'taka'=>$request->taka,
                );
            }
            else
            {
                $data = array(
                    'type'=>$request->type,
                    'bank_setup_id'=>$request->bank_setup_id,
                    'marfot'=>$request->marfot,
                    'taka'=>$request->taka,
                );
            }
    
            if($request->type == 2)
            {
                if($request->check_id != "")
                {
                    check_book_page_setup::where('id',$request->check_id)->delete();
                }
                
            }
    
            $insert = bank_entry::create($data);
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
