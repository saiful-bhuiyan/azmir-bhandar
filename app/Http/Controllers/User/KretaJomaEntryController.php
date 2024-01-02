<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\bank_setup;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\kreta_setup;
use App\Models\kreta_joma_entry;
use Carbon\Carbon;

class KretaJomaEntryController extends Controller
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
            $data = kreta_joma_entry::whereDay('entry_date', now()->day)->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('area',function($v){
                return $v->kreta_setup->area;
            })
            ->addColumn('address',function($v){
                return $v->kreta_setup->address;
            })
            ->addColumn('name',function($v){
                return $v->kreta_setup->name;
            })
            ->addColumn('payment_by',function($v){
                if($v->payment_by == 1)
                {
                    return 'Cash';
                }
                else
                {
                    return 'Bank';
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

        $kreta_setup = kreta_setup::select('area')->groupBy('area')->get();
        return view('user.entry_user.kreta_joma_entry',compact('kreta_setup'));
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
                'kreta_setup_id' => 'required',
                'marfot' => 'required',
                'taka' => 'required|numeric',
                'payment_by' => 'required',
            ],
            [
                'kreta_setup_id.required'=>'দয়া করে ক্রেতার তথ্য সিলেক্ট করুন',
                'marfot.required'=>'দয়া করে মারফত ইনপুট করুন',
                'taka.required'=>'দয়া করে টাকা ইনপুট করুন',
                'taka.numeric'=>'সংখ্যা ইনপুট করুন',
                'payment_by.required'=>'দয়া করে পেমেন্ট মাধ্যম সিলেক্ট করুন',
            ]);
            
            if($request->payment_by == 2)
            {
                $bank_validated = $request->validate(
                [
                    'bank_setup_id' => 'required',
                ],
                [
                    'bank_setup_id.required'=>'দয়া করে ব্যাংক তথ্য সিলেক্ট করুন',
                ]);
            }
    
            $data = array(
                'kreta_setup_id'=>$request->kreta_setup_id,
                'bank_setup_id'=>$request->bank_setup_id,
                'marfot'=>$request->marfot,
                'taka'=>$request->taka,
                'payment_by'=>$request->payment_by,
                'entry_date'=> Carbon::now(),
            );
    
            $insert = kreta_joma_entry::create($data);
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
        $bank_setup = bank_setup::get();
        $kreta_setup = kreta_setup::select('area')->groupBy('area')->get();
        $data = kreta_joma_entry::find($id);
        return view('user.entry_admin.kreta_joma_entry',compact('data','kreta_setup','bank_setup'));
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
                'kreta_setup_id' => 'required',
                'marfot' => 'required',
                'taka' => 'required|numeric',
                'payment_by' => 'required',
                'entry_date' => 'required',
            ],
            [
                'kreta_setup_id.required'=>'দয়া করে ক্রেতার তথ্য সিলেক্ট করুন',
                'marfot.required'=>'দয়া করে মারফত ইনপুট করুন',
                'taka.required'=>'দয়া করে টাকা ইনপুট করুন',
                'taka.numeric'=>'সংখ্যা ইনপুট করুন',
                'payment_by.required'=>'দয়া করে পেমেন্ট মাধ্যম সিলেক্ট করুন',
                'entry_date.required'=>'দয়া তারিখ সিলেক্ট করুন',

            ]);

            $data = array(
                'kreta_setup_id'=>$request->kreta_setup_id,
                'bank_setup_id'=>$request->bank_setup_id,
                'marfot'=>$request->marfot,
                'taka'=>$request->taka,
                'payment_by'=>$request->payment_by,
                'entry_date'=> Carbon::createFromFormat('d-m-Y', $request->entry_date)->format('Y-m-d'),
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
            }else if($request->payment_by == 1)
            {
                $data['bank_setup_id'] = null;
            }
    
            $update = kreta_joma_entry::find($id)->update($data);
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
        //
    }

    public function admin(Request $request)
    {
        if ($request->ajax()) {
            $data = kreta_joma_entry::orderBy('entry_date','DESC')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('area',function($v){
                return $v->kreta_setup->area;
            })
            ->addColumn('address',function($v){
                return $v->kreta_setup->address;
            })
            ->addColumn('name',function($v){
                return $v->kreta_setup->name;
            })
            ->addColumn('payment_by',function($v){
                if($v->payment_by == 1)
                {
                    return 'Cash';
                }
                else
                {
                    return 'Bank';
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
            ->addColumn('entry_date',function($v){
                return Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y');
            })
            ->addColumn('action',function($v){

                return '<div class="flex gap-x-2">
                    <a href="'.route('kreta_joma_entry.edit', $v->id).'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ইডিট</a>

                    <form method="post" action="'.route('kreta_joma_entry.destroy',$v->id).'" id="deleteForm">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                        <button onclick="return confirmation();" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        ডিলিট</button>
                    </form>
                  
                    </div>';
            })

            ->rawColumns(['sl','area','address','name','payment_by','bank_info','marfot','taka','entry_date','action'])
            ->make(true);
        }

        $bank_setup = bank_setup::get();
        $kreta_setup = kreta_setup::select('area')->groupBy('area')->get();
        return view('user.entry_admin.kreta_joma_entry',compact('kreta_setup','bank_setup'));
    }

    
}
