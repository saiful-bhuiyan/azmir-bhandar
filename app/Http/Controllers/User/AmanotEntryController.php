<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\check_book_page_setup;
use App\Models\amanot_entry;
use App\Models\amanot_setup;
use App\Models\bank_setup;
use Carbon\Carbon;

class AmanotEntryController extends Controller
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
            $data = amanot_entry::whereDay('entry_date', now()->day)->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('type',function($v){
                if($v->type == 1)
                {
                    return 'জমা';
                }
                else
                {
                    return 'খরচ';
                }
            })
            ->addColumn('address',function($v){
                return $v->amanot_setup->address;
            })
            ->addColumn('name',function($v){
                return $v->amanot_setup->name;
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

            ->rawColumns(['sl','type','address','name','payment_by','bank_info','check_id','marfot','taka'])
            ->make(true);
        }

        $amanot_setup = amanot_setup::select('address')->groupBy('address')->get();
        return view('user.entry_user.amanot_entry',compact('amanot_setup'));
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
                'amanot_setup_id' => 'required',
                'marfot' => 'required',
                'taka' => 'required|numeric',
                'payment_by' => 'required',
            ],
            [
                'type.required'=>'দয়া করে ধরণ সিলেক্ট করুন',
                'amanot_setup_id.required'=>'দয়া করে আমানতের নাম সিলেক্ট করুন',
                'marfot.required'=>'দয়া করে মারফত ইনপুট করুন',
                'taka.required'=>'দয়া করে টাকা ইনপুট করুন',
                'taka.numeric'=>'সংখ্যা ইনপুট করুন',
                'payment_by.required'=>'দয়া করে পেমেন্ট মাধ্যম সিলেক্ট করুন',
            ]);

            $data = array(
                'type'=>$request->type,
                'amanot_setup_id'=>$request->amanot_setup_id,
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

                if($request->check_id != null or $request->check_id != "")
                {
                    $data['check_id'] = $request->check_id;
                }
            }

            if($request->check_id != null or $request->check_id != "")
            {
                check_book_page_setup::where('id',$request->check_id)->delete();
            }

            $insert = amanot_entry::create($data);

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
        $amanot_setup = amanot_setup::select('address')->groupBy('address')->get();
        $check_book = check_book_page_setup::all();
        $data = amanot_entry::find($id);
        if($data->check_id != null or $data->check_id != "")
        {
            $selected_check = check_book_page_setup::where('id',$data->check_book_page_setup->id)->withTrashed()->first();
        }
        else
        {
            $selected_check = [];
        }
       
        return view('user.entry_admin.amanot_entry',compact('data','amanot_setup','bank_setup','check_book','selected_check'));
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
                'type' => 'required',
                'amanot_setup_id' => 'required',
                'marfot' => 'required',
                'taka' => 'required|numeric',
                'payment_by' => 'required',
                'entry_date' => 'required',
            ],
            [
                'type.required'=>'দয়া করে ধরণ সিলেক্ট করুন',
                'amanot_setup_id.required'=>'দয়া করে আমানতের নাম সিলেক্ট করুন',
                'marfot.required'=>'দয়া করে মারফত ইনপুট করুন',
                'taka.required'=>'দয়া করে টাকা ইনপুট করুন',
                'taka.numeric'=>'সংখ্যা ইনপুট করুন',
                'payment_by.required'=>'দয়া করে পেমেন্ট মাধ্যম সিলেক্ট করুন',
                'entry_date.required'=>'দয়া তারিখ সিলেক্ট করুন',
            ]);

            $data = array(
                'type'=>$request->type,
                'amanot_setup_id'=>$request->amanot_setup_id,
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

            $check = amanot_entry::where('id',$id)->first();
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

            $update = amanot_entry::find($id)->update($data);
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
        $check = amanot_entry::where('id',$id)->first();
        if($check->check_id != null or $check->check_id != ""){
            check_book_page_setup::where('id',$check->check_id)->onlyTrashed()->restore();
        }
        $delete = amanot_entry::destroy($id);
        if($delete)
        {
            Toastr::success(__('ডিলিট সফল হয়েছে'), __('সফল'));
        }
        else
        {
            Toastr::error(__('ডিলিট সফল হয়নি'), __('ব্যর্থ'));
        }
       

        return redirect('amanot_entry_admin');
    }

    // Admin Panel

    public function admin(Request $request)
    {
        if ($request->ajax()) {
            $data = amanot_entry::orderBy('entry_date','DESC')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('type',function($v){
                if($v->type == 1)
                {
                    return 'জমা';
                }
                else
                {
                    return 'খরচ';
                }
            })
            ->addColumn('address',function($v){
                return $v->amanot_setup->address;
            })
            ->addColumn('name',function($v){
                return $v->amanot_setup->name;
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
                    <a href="'.route('amanot_entry.edit', $v->id).'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ইডিট</a>

                    <form method="post" action="'.route('amanot_entry.destroy',$v->id).'" id="deleteForm">
                    '.csrf_field().'
                    '.method_field('DELETE').'
                        <button onclick="return confirmation();" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        ডিলিট</button>
                    </form>
                  
                    </div>';
            })

            ->rawColumns(['sl','type','address','name','payment_by','bank_info','check_id','marfot','taka','entry_date','action'])
            ->make(true);
        }

        $amanot_setup = amanot_setup::select('address')->groupBy('address')->get();
        $bank_setup = bank_setup::all();
        $check_book = check_book_page_setup::all();
        return view('user.entry_admin.amanot_entry',compact('amanot_setup','bank_setup','check_book'));
    }
}
