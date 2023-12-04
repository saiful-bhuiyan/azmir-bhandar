<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\mohajon_return_entry;
use App\Models\mohajon_setup;
use Carbon\Carbon;

class MohajonReturnEntryController extends Controller
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
            $data = mohajon_return_entry::whereDay('entry_date', now()->day)->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($row){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('area',function($v){
                return $v->mohajon_setup->area;
            })
            ->addColumn('address',function($v){
                return $v->mohajon_setup->address;
            })
            ->addColumn('name',function($v){
                return $v->mohajon_setup->name;
            })
            ->addColumn('payment_by',function($v){
                if($v->payment_by == 1)
                {
                    return 'ক্যাশ';
                }
                else
                {
                    return 'ব্যাংক';
                }
            })
            ->addColumn('bank_info',function($v){
                if($v->bank_setup_id == "" or null)
                {
                    return '-';
                }
                else
                {
                    return $v->bank_setup->bank_name .'/'.$v->bank_setup->account_name;
                }
            })
            ->addColumn('marfot',function($v){
                return $v->marfot;
            })
            ->addColumn('taka',function($v){
                return $v->taka;
            })

            ->rawColumns(['sl','area','address','name','payment_by','bank_info','marfot','taka'])
            ->make(true);
        }

        $mohajon_setup = mohajon_setup::select('area')->groupBy('area')->get();
        return view('user.entry_user.mohajon_return_entry',compact('mohajon_setup'));
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
                'mohajon_setup_id' => 'required',
                'marfot' => 'required',
                'taka' => 'required|numeric',
                'payment_by' => 'required',
            ],
            [
                'mohajon_setup_id.required'=>'দয়া করে মহাজনের তথ্য সিলেক্ট করুন',
                'marfot.required'=>'দয়া করে মারফত ইনপুট করুন',
                'taka.required'=>'দয়া করে টাকা ইনপুট করুন',
                'taka.numeric'=>'সংখ্যা ইনপুট করুন',
                'payment_by.required'=>'দয়া করে পেমেন্ট মাধ্যম সিলেক্ট করুন',
            ]);

            $data = array(
                'mohajon_setup_id'=>$request->mohajon_setup_id,
                'marfot'=>$request->marfot,
                'taka'=>$request->taka,
                'payment_by'=>$request->payment_by,
                'entry_date'=> Carbon::now(),
            );
            
            if($request->payment_by == 2)
            {
                $bank_validated = $request->validate(
                [
                    'bank_setup_id' => 'required',
                ],
                [
                    'bank_setup_id.required'=>'দয়া করে ব্যাংক তথ্য সিলেক্ট করুন',
                ]);

                $data['bank_setup_id'] = $request->bank_setup_id;
            }

            $insert = mohajon_return_entry::create($data);

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
