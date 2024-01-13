<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ponno_purchase_cost_entry;
use App\Models\ponno_purchase_entry;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PonnoPurchaseCostEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.entry_user.ponno_purchase_cost_entry');
    }

    public function cost_entry($id)
    {
        $purchase = ponno_purchase_entry::find($id);
        $cost_entry = ponno_purchase_cost_entry::where('purchase_id',$id)->get();

        return view('user.entry_user.purchase_cost_form',compact('purchase','cost_entry'));
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
                'purchase_id' => 'required',
                'cost_name' => 'required',
                'taka' => 'required|numeric',
            ],
            [
                'mohajon_setup_id.required'=>'দয়া করে মহাজনের সিলেক্ট করুন',
                'cost_name.required'=>'দয়া করে খরচের নাম সিলেক্ট করুন',
                'taka.required'=>'দয়া করে টাকা ইনপুট করুন',
                'taka.numeric'=>'সংখ্যা ইনপুট করুন',
            ]);

            $data = array(
                'purchase_id'=>$request->purchase_id,
                'cost_name'=>$request->cost_name,
                'taka'=>$request->taka,
                'entry_date'=> Carbon::now(),
            );

            $insert = ponno_purchase_cost_entry::create($data);

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
        $data = ponno_purchase_cost_entry::where('id',$id)->first();
        $purchase = ponno_purchase_entry::find($data->purchase_id);
        $cost_entry = ponno_purchase_cost_entry::where('purchase_id',$data->purchase_id)->get();
        return view('user.entry_admin.purchase_cost_form',compact('data','purchase','cost_entry'));
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
                'purchase_id' => 'required',
                'cost_name' => 'required',
                'taka' => 'required|numeric',
                'entry_date' => 'required',
            ],
            [
                'mohajon_setup_id.required'=>'দয়া করে মহাজনের সিলেক্ট করুন',
                'cost_name.required'=>'দয়া করে খরচের নাম সিলেক্ট করুন',
                'taka.required'=>'দয়া করে টাকা ইনপুট করুন',
                'taka.numeric'=>'সংখ্যা ইনপুট করুন',
                'entry_date.required'=>'দয়া তারিখ সিলেক্ট করুন',
            ]);

            $data = array(
                'purchase_id'=>$request->purchase_id,
                'cost_name'=>$request->cost_name,
                'taka'=>$request->taka,
                'entry_date'=> Carbon::createFromFormat('d-m-Y', $request->entry_date)->format('Y-m-d'),
            );

            $update = ponno_purchase_cost_entry::find($id)->update($data);
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
        $ponno_cost = ponno_purchase_cost_entry::find($id);
        $delete = ponno_purchase_cost_entry::destroy($id);
        if($delete)
        {
            Toastr::success(__('ডিলিট সফল হয়েছে'), __('সফল'));
        }
        else
        {
            Toastr::error(__('ডিলিট সফল হয়নি'), __('ব্যর্থ'));
        }
       $count = ponno_purchase_cost_entry::where('purchase_id',$ponno_cost->purchase_id)->count();
       if($count > 0)
       {
        return redirect()->back();
       }else{
        return redirect('ponno_purchase_cost_entry_admin');
       }

        
    }

    public function admin()
    {
        return view('user.entry_admin.ponno_purchase_cost_entry');
    }

    public function admin_cost_entry($id)
    {
        $purchase = ponno_purchase_entry::find($id);
        $cost_entry = ponno_purchase_cost_entry::where('purchase_id',$id)->get();

        return view('user.entry_admin.purchase_cost_form',compact('purchase','cost_entry'));
    }
}
