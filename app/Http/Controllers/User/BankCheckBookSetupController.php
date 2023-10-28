<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\bank_setup;
use App\Models\bank_check_book_setup;
use App\Models\check_book_page_setup;

class BankCheckBookSetupController extends Controller
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
            $data = bank_check_book_setup::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($row){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('bank_name',function($v){
                return $v->bank_setup->bank_name;
            })
            ->addColumn('account_name',function($v){
                return $v->bank_setup->account_name;
            })
            ->addColumn('account_no',function($v){
                return $v->bank_setup->account_no;
            })
            ->addColumn('shakha',function($v){
                return $v->bank_setup->shakha;
            })
            ->addColumn('total_page',function($v){
                return $v->total_page;
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
                    <input type="checkbox" class="checkbox" id="bankCheckBookSetupStatus" '.$check.' onclick="return bankCheckBookSetupStatusChange('.$v->id.')">
                    <div class="slider"></div>
                </label>';
            })

            ->rawColumns(['sl','bank_name','account_name','account_no','shakha','status'])
            ->make(true);
        }

        $bank_setup = bank_setup::select('shakha')->groupBy('shakha')->get();
        return view('user.setup_user.bank_check_book_setup',compact('bank_setup'));
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
                'account_no' => 'required',
                'page_from' => 'required|unique:bank_check_book_setups|regex:/^\d+(\.\d{1,2})?$/',
                'page_to' => 'required|unique:bank_check_book_setups|regex:/^\d+(\.\d{1,2})?$/',
                'total_page' => 'required|max:3|regex:/^\d+(\.\d{1,2})?$/|gt:0',
            ],
            [
                'account_no.required'=>'দয়া করে একাউন্ট নাম্বার সিলেক্ট করুন',
                'page_from.required'=>'দয়া করে ইনপুট করুন',
                'page_from.unique'=>'এই নাম্বার পুর্বে ব্যবহার করা হয়েছে',
                'page_from.regex'=>'সংখ্যা ইনপুট করুন',
                'page_to.required'=>'দয়া করে ইনপুট করুন',
                'page_to.unique'=>'এই নাম্বার পুর্বে ব্যবহার করা হয়েছে',
                'page_to.regex'=>'সংখ্যা ইনপুট করুন',
                'total_page.required'=>'মোট চেকের পাতা সঠিক নয়',
                'total_page.max'=>'৩টি সংখ্যার অধিক গ্রহনযোগ্য নয়',
                'total_page.regex'=>'সংখ্যা ইনপুট করুন',
                'total_page.gt'=>'কমপক্ষে ১টি পেজ থাকতে হবে',
            ]);

            $bank = bank_setup::where('account_no',$request->account_no)->first();

            $bank_setup_id = $bank->id;
    
            $data = array(
                'bank_setup_id'=>$bank_setup_id,
                'page_from'=>$request->page_from,
                'page_to'=>$request->page_to,
                'total_page'=>$request->total_page,
            );
    
            // Inserting all check pages

            $insert = bank_check_book_setup::create($data);

            for($page = $request->page_from ; $page <= $request->page_to ; $page++)
            {
                check_book_page_setup::create([
                    'check_id'=>$insert->id,
                    'page'=>$page,
                ]);
            }
            
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

    public function getBankNameByShakha(Request $request)
    {
        $bank_name = bank_setup::select('bank_name')->where('shakha',$request->shakha)->groupBy('bank_name')->get();

        $select = '<option value="">সিলেক্ট</option>';

        foreach($bank_name as $v)
        {
            $select .='<option value="'.$v->bank_name.'">'.$v->bank_name.'</option>';
        }

        return $select;
    }

    public function getAccNameByBankName(Request $request)
    {
        $account_name = bank_setup::select('account_name')->where('bank_name',$request->bank_name)->groupBy('account_name')->get();

        $select = '<option value="">সিলেক্ট</option>';

        foreach($account_name as $v)
        {
            $select .='<option value="'.$v->account_name.'">'.$v->account_name.'</option>';
        }

        return $select;
    }

    public function getAccNoByAccName(Request $request)
    {
        $account_no = bank_setup::select('account_no')->where('account_name',$request->account_name)->groupBy('account_no')->get();

        $select = '<option value="">সিলেক্ট</option>';

        foreach($account_no as $v)
        {
            $select .='<option value="'.$v->account_no.'">'.$v->account_no.'</option>';
        }

        return $select;
    }
}
