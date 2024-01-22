<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\bank_setup;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\check_book_page_setup;
use App\Models\mohajon_payment_entry;
use App\Models\mohajon_setup;
use Carbon\Carbon;

class MohajonPaymentEntryController extends Controller
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
            $data = mohajon_payment_entry::whereDay('entry_date', now()->day)->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
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

            ->rawColumns(['sl','area','address','name','payment_by','bank_info','check_id','marfot','taka'])
            ->make(true);
        }

        $mohajon_setup = mohajon_setup::select('area')->groupBy('area')->get();
        return view('user.entry_user.mohajon_payment_entry',compact('mohajon_setup'));
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
                'description' => 'max:300',
            ],
            [
                'mohajon_setup_id.required'=>'দয়া করে মহাজনের সিলেক্ট করুন',
                'marfot.required'=>'দয়া করে মারফত ইনপুট করুন',
                'taka.required'=>'দয়া করে টাকা ইনপুট করুন',
                'taka.numeric'=>'সংখ্যা ইনপুট করুন',
                'payment_by.required'=>'দয়া করে পেমেন্ট মাধ্যম সিলেক্ট করুন',
                'description.max'=>'৩০০ এর অধিক অক্ষর গ্রহণযোগ্য নয়',
            ]);

            $data = array(
                'mohajon_setup_id'=>$request->mohajon_setup_id,
                'marfot'=>$request->marfot,
                'taka'=>$request->taka,
                'payment_by'=>$request->payment_by,
                'description'=>$request->description ? $request->description : '',
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

                if($request->check_id != null or $request->check_id != "")
                {
                    $data['check_id'] = $request->check_id;
                }
            }

            if($request->check_id != null or $request->check_id != "")
            {
                check_book_page_setup::where('id',$request->check_id)->delete();
            }

            $insert = mohajon_payment_entry::create($data);

            if($insert)
            {
                Toastr::success(__('এড কার্ট সফল হয়েছে'), __('সফল'));
            }
            else
            {
                Toastr::error(__('এড কার্ট সফল হয়নি'), __('ব্যর্থ'));
            }
    
            return redirect()->back()->withInput();
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
        $mohajon_setup = mohajon_setup::select('area')->groupBy('area')->get();
        $check_book = check_book_page_setup::all();
        $data = mohajon_payment_entry::find($id);
        if($data->check_id != null or $data->check_id != "")
        {
            $selected_check = check_book_page_setup::where('id',$data->check_book_page_setup->id)->withTrashed()->first();
        }
        else
        {
            $selected_check = [];
        }
       
        return view('user.entry_admin.mohajon_payment_entry',compact('data','mohajon_setup','bank_setup','check_book','selected_check'));
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
                'mohajon_setup_id' => 'required',
                'marfot' => 'required',
                'taka' => 'required|numeric',
                'payment_by' => 'required',
                'entry_date' => 'required',
                'description' => 'max:300',
            ],
            [
                'mohajon_setup_id.required'=>'দয়া করে মহাজনের নাম সিলেক্ট করুন',
                'marfot.required'=>'দয়া করে মারফত ইনপুট করুন',
                'taka.required'=>'দয়া করে টাকা ইনপুট করুন',
                'taka.numeric'=>'সংখ্যা ইনপুট করুন',
                'payment_by.required'=>'দয়া করে পেমেন্ট মাধ্যম সিলেক্ট করুন',
                'entry_date.required'=>'দয়া তারিখ সিলেক্ট করুন',
                'description.max'=>'৩০০ এর অধিক অক্ষর গ্রহণযোগ্য নয়',
            ]);

            $data = array(
                'mohajon_setup_id'=>$request->mohajon_setup_id,
                'marfot'=>$request->marfot,
                'taka'=>$request->taka,
                'payment_by'=>$request->payment_by,
                'description'=>$request->description ? $request->description : '',
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

                $data['bank_setup_id'] = $request->bank_setup_id;

                if($request->check_id != null or $request->check_id != "")
                {
                    $data['check_id'] = $request->check_id;
                }else{
                    $data['check_id'] = null;
                }
            }
            else if($request->payment_by == 1){
                $data['bank_setup_id'] = null;
                $data['check_id'] = null;
            }

            $check = mohajon_payment_entry::where('id',$id)->first();
            if($check->check_id != null or $check->check_id != ""){
                check_book_page_setup::where('id',$check->check_id)->onlyTrashed()->restore();
            }

            if($request->payment_by == 2)
            {
                if($request->check_id != null or $request->check_id != "" )
                {
                    check_book_page_setup::where('id',$request->check_id)->delete();
                }
            }

            $update = mohajon_payment_entry::find($id)->update($data);
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
        $check = mohajon_payment_entry::where('id',$id)->first();
        if($check->check_id != null or $check->check_id != ""){
            check_book_page_setup::where('id',$check->check_id)->onlyTrashed()->restore();
        }
        $delete = mohajon_payment_entry::destroy($id);
        if($delete)
        {
            Toastr::success(__('ডিলিট সফল হয়েছে'), __('সফল'));
        }
        else
        {
            Toastr::error(__('ডিলিট সফল হয়নি'), __('ব্যর্থ'));
        }
       

        return redirect('mohajon_payment_entry_admin');
    }

    public function admin(Request $request)
    {
        if ($request->ajax()) {
            $data = mohajon_payment_entry::orderBy('entry_date','DESC')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
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
            ->addColumn('entry_date',function($v){
                return Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y');
            })
            ->addColumn('action',function($v){

                return '<div class="flex gap-x-2">
                    <a href="'.route('mohajon_payment_entry.edit', $v->id).'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ইডিট</a>

                    <form method="post" action="'.route('mohajon_payment_entry.destroy',$v->id).'" id="deleteForm">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                        <button onclick="return confirmation();" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        ডিলিট</button>
                    </form>
                  
                    </div>';
            })

            ->rawColumns(['sl','area','address','name','payment_by','bank_info','check_id','marfot','taka','entry_date','action'])
            ->make(true);
        }

        $mohajon_setup = mohajon_setup::select('area')->groupBy('area')->get();
        $bank_setup = bank_setup::all();
        $check_book = check_book_page_setup::all();
        return view('user.entry_admin.mohajon_payment_entry',compact('mohajon_setup','bank_setup','check_book'));
    }

    
}
