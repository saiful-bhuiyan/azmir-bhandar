<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\mohajon_commission_setup;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DataTables;
use App\Models\mohajon_setup;
use App\Models\ponno_setup;
use App\Models\ponno_size_setup;
use App\Models\ponno_marka_setup;
use App\Models\ponno_purchase_entry;
use App\Models\ponno_sales_entry;
use App\Models\stock;
use Carbon\Carbon;

class PonnoPurchaseEntryController extends Controller
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
            $data = ponno_purchase_entry::orderBy('entry_date','DESC')->get();;
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sl',function($v){
                return $this->sl = $this->sl +1;
            })
            ->addColumn('invoice',function($v){
                return $v->id;
            })
            ->addColumn('mohajon',function($v){
                return $v->mohajon_setup->area.'/'.$v->mohajon_setup->address.'/'.$v->mohajon_setup->name;
            })
            ->addColumn('purchase_type',function($v){
                if($v->purchase_type == 1)
                {
                    return 'নিজ খরিদ';
                }
                else
                {
                    return 'কমিশন';
                }
            })
            ->addColumn('ponno_name',function($v){
                return $v->ponno_setup->ponno_name;
            })
            ->addColumn('ponno_size',function($v){
                return $v->ponno_size_setup->ponno_size;
            })
            ->addColumn('ponno_marka',function($v){
                return $v->ponno_marka_setup->ponno_marka;
            })
            ->addColumn('gari_no',function($v){
                return $v->gari_no;
            })
            ->addColumn('quantity',function($v){
                return $v->quantity;
            })
            ->addColumn('weight',function($v){
                return $v->weight;
            })
            ->addColumn('rate',function($v){
                return $v->rate ? $v->rate : '-';
            })
            ->addColumn('total_cost',function($v){
                $total_cost = $v->labour_cost + $v->other_cost + $v->truck_cost + $v->van_cost + $v->tohori_cost;
                return $total_cost;
            })
            ->addColumn('total_taka',function($v){
                if($v->purchase_type == 1)
                {
                    $total = $v->weight * $v->rate;
                    $total +=$v->labour_cost;
                    $total +=$v->other_cost;
                    $total +=$v->truck_cost;
                    $total +=$v->van_cost;
                    $total +=$v->tohori_cost;

                    return $total;
                }
                else
                {
                    return '-';
                }
            })
            
             ->rawColumns(['sl','invoice','mohajon','purchase_type','ponno_name','ponno_size','ponno_marka','gari_no','quantity',
             'weight','rate','total_cost','total_taka'])
             ->make(true);
         }
 
         $mohajon_setup = mohajon_setup::where('status',1)->get();

        $ponno_setup = ponno_setup::all();

        $ponno_size_setup = ponno_size_setup::all();
        
        $ponno_marka_setup = ponno_marka_setup::all();

        return view('user.entry_user.ponno_purchase_entry',compact('mohajon_setup','ponno_setup','ponno_size_setup','ponno_marka_setup'));
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
                'purchase_type' => 'required',
                'mohajon_setup_id' => 'required',
                'ponno_setup_id' => 'required',
                'size_id' => 'required',
                'marka_id' => 'required',
                'quantity' => 'required|numeric',
                'weight' => 'required|numeric',
            ],
            [
                'purchase_type.required'=>'দয়া করে ধরণ সিলেক্ট করুন',
                'mohajon_setup_id.required'=>'দয়া করে মহাজনের সিলেক্ট করুন',
                'ponno_setup_id.required'=>'দয়া করে পন্যের নাম সিলেক্ট করুন',
                'size_id.required'=>'দয়া করে পন্যের সাইজ সিলেক্ট করুন',
                'marka_id.required'=>'দয়া করে পন্যের মার্কা সিলেক্ট করুন',
                'quantity.required'=>'দয়া করে সংখ্যা ইনপুট করুন',
                'quantity.numeric'=>'সংখ্যা ইনপুট করুন',
                'weight.required'=>'দয়া করে ওজন ইনপুট করুন',
                'weight.numeric'=>'সংখ্যা ইনপুট করুন',
            ]);

            $data = array(
                'purchase_type'=>$request->purchase_type,
                'mohajon_setup_id'=>$request->mohajon_setup_id,
                'ponno_setup_id'=>$request->ponno_setup_id,
                'size_id'=>$request->size_id,
                'marka_id'=>$request->marka_id,
                'gari_no'=>$request->gari_no,
                'quantity'=>$request->quantity,
                'weight'=>$request->weight,
                'labour_cost'=>$request->labour_cost ? $request->labour_cost : 0,
                'other_cost'=>$request->other_cost ? $request->other_cost : 0,
                'truck_cost'=>$request->truck_cost ? $request->truck_cost : 0,
                'van_cost'=>$request->van_cost ? $request->van_cost : 0,
                'tohori_cost'=>$request->tohori_cost ? $request->tohori_cost : 0,
                'entry_date'=> Carbon::now(),
            );
            
            if($request->purchase_type == 1)
            {
                $khorid_validate = $request->validate(
                [
                    'rate' => 'required|numeric',
                ],
                [
                    'rate.required'=>'দয়া করে দর ইনপুট করুন',
                ]);

                $data['rate'] = $request->rate;
            }
            else
            {
                $mohajon = mohajon_commission_setup::where('ponno_setup_id',$request->ponno_setup_id)->first();
                $mohajon_commission = intval($mohajon->commission_amount * $request->weight);
                $data['mohajon_commission'] = $mohajon_commission;
            }

            $insert = ponno_purchase_entry::create($data);

            if($insert)
            {
                
                $stock = array(
                    'purchase_id'=>$insert->id,
                    'quantity'=>$request->quantity,
                    'weight'=>$request->weight,
                );

                stock::create($stock);

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
        $mohajon_setup = mohajon_setup::where('status',1)->get();
        $ponno_setup = ponno_setup::all();
        $ponno_size_setup = ponno_size_setup::all();
        $ponno_marka_setup = ponno_marka_setup::all();
        $data = ponno_purchase_entry::find($id);
        return view('user.entry_admin.ponno_purchase_entry',compact('data','mohajon_setup','ponno_setup','ponno_size_setup','ponno_marka_setup'));
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
        $data = array(
            'labour_cost'=>$request->labour_cost ? $request->labour_cost : 0,
            'other_cost'=>$request->other_cost ? $request->other_cost : 0,
            'truck_cost'=>$request->truck_cost ? $request->truck_cost : 0,
            'van_cost'=>$request->van_cost ? $request->van_cost : 0,
            'tohori_cost'=>$request->tohori_cost ? $request->tohori_cost : 0,
            'mohajon_commission'=>$request->mohajon_commission ? $request->mohajon_commission : 0,
        );

        $update = ponno_purchase_entry::where('id',$id)->update($data);

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

    public function ponno_purchase_update(Request $request, $id)
    {
        $validated = $request->validate(
            [
                'purchase_type' => 'required',
                'mohajon_setup_id' => 'required',
                'ponno_setup_id' => 'required',
                'size_id' => 'required',
                'marka_id' => 'required',
                'quantity' => 'required|numeric',
                'weight' => 'required|numeric',
                'entry_date' => 'required',
            ],
            [
                'purchase_type.required'=>'দয়া করে ধরণ সিলেক্ট করুন',
                'mohajon_setup_id.required'=>'দয়া করে মহাজনের সিলেক্ট করুন',
                'ponno_setup_id.required'=>'দয়া করে পন্যের নাম সিলেক্ট করুন',
                'size_id.required'=>'দয়া করে পন্যের সাইজ সিলেক্ট করুন',
                'marka_id.required'=>'দয়া করে পন্যের মার্কা সিলেক্ট করুন',
                'quantity.required'=>'দয়া করে সংখ্যা ইনপুট করুন',
                'quantity.numeric'=>'সংখ্যা ইনপুট করুন',
                'weight.required'=>'দয়া করে ওজন ইনপুট করুন',
                'weight.numeric'=>'সংখ্যা ইনপুট করুন',
                'entry_date.required'=>'দয়া তারিখ সিলেক্ট করুন',
            ]);

            $data = array(
                'purchase_type'=>$request->purchase_type,
                'mohajon_setup_id'=>$request->mohajon_setup_id,
                'ponno_setup_id'=>$request->ponno_setup_id,
                'size_id'=>$request->size_id,
                'marka_id'=>$request->marka_id,
                'gari_no'=>$request->gari_no,
                'quantity'=>$request->quantity,
                'weight'=>$request->weight,
                'labour_cost'=>$request->labour_cost ? $request->labour_cost : 0,
                'other_cost'=>$request->other_cost ? $request->other_cost : 0,
                'truck_cost'=>$request->truck_cost ? $request->truck_cost : 0,
                'van_cost'=>$request->van_cost ? $request->van_cost : 0,
                'tohori_cost'=>$request->tohori_cost ? $request->tohori_cost : 0,
                'entry_date'=> Carbon::createFromFormat('d-m-Y', $request->entry_date)->format('Y-m-d'),
            );
            
            if($request->purchase_type == 1)
            {
                $khorid_validate = $request->validate(
                [
                    'rate' => 'required|numeric',
                ],
                [
                    'rate.required'=>'দয়া করে দর ইনপুট করুন',
                ]);

                $data['rate'] = $request->rate;
            }
            else
            {
                $mohajon = mohajon_commission_setup::where('ponno_setup_id',$request->ponno_setup_id)->first();
                $mohajon_commission = intval($mohajon->commission_amount * $request->weight);
                $data['mohajon_commission'] = $mohajon_commission;
            }

            $update = ponno_purchase_entry::find($id)->update($data);

            if($update)
            {
                $sales_qty = ponno_sales_entry::where('purchase_id',$id)->sum('sales_qty');
                $sales_weight = ponno_sales_entry::where('purchase_id',$id)->sum('sales_weight');
                if(!$sales_qty)
                {
                    $sales_qty = 0;
                }
                if(!$sales_weight)
                {
                    $sales_weight = 0;
                }

                $purchase = ponno_purchase_entry::find($id);

                if($purchase->purchase_type == 1){
                    $stock = array(
                        'purchase_id'=>$id,
                        'quantity'=>$request->quantity - $sales_qty,
                        'weight'=>$request->weight -  $sales_weight,
                    );
                }else if($purchase->purchase_type == 2){
                    $stock = array(
                        'purchase_id'=>$id,
                        'quantity'=>$request->quantity - $sales_qty,
                        'weight'=>0,
                    ); 
                }

                stock::where('purchase_id',$id)->update($stock);

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
        $purchase = ponno_purchase_entry::where('id',$id)->first();
        $stock = stock::where('purchase_id',$id)->first();
        if($purchase->quantity == $stock->quantity)
        {
            $delete = stock::where('purchase_id',$id)->delete();
            ponno_purchase_entry::find($id)->delete();
            if($delete)
            {
                Toastr::success(__('ডিলিট সফল হয়েছে'), __('সফল'));
            }
            else
            {
                Toastr::error(__('ডিলিট সফল হয়নি<br>দয়া করে স্টক চেক করুন'), __('ব্যর্থ'));
            }
        }
        else
        {
            Toastr::error(__('ডিলিট সফল হয়নি<br>দয়া করে স্টক চেক করুন'), __('ব্যর্থ'));
        }
        
        return redirect()->back();
    }

    public function admin(Request $request)
    {
        if ($request->ajax()) {
        $data = ponno_purchase_entry::orderBy('entry_date','DESC')->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('sl',function($v){
            return $this->sl = $this->sl +1;
        })
        ->addColumn('invoice',function($v){
            return $v->id;
        })
        ->addColumn('mohajon',function($v){
            return $v->mohajon_setup->area.'/'.$v->mohajon_setup->address.'/'.$v->mohajon_setup->name;
        })
        ->addColumn('purchase_type',function($v){
            if($v->purchase_type == 1)
            {
                return 'নিজ খরিদ';
            }
            else
            {
                return 'কমিশন';
            }
        })
        ->addColumn('ponno_name',function($v){
            return $v->ponno_setup->ponno_name;
        })
        ->addColumn('ponno_size',function($v){
            return $v->ponno_size_setup->ponno_size;
        })
        ->addColumn('ponno_marka',function($v){
            return $v->ponno_marka_setup->ponno_marka;
        })
        ->addColumn('gari_no',function($v){
            return $v->gari_no;
        })
        ->addColumn('quantity',function($v){
            return $v->quantity;
        })
        ->addColumn('weight',function($v){
            return $v->weight;
        })
        ->addColumn('rate',function($v){
            return $v->rate ? $v->rate : '-';
        })
        ->addColumn('total_cost',function($v){
            $total_cost = $v->labour_cost + $v->other_cost + $v->truck_cost + $v->van_cost + $v->tohori_cost;
            return $total_cost;
        })
        ->addColumn('total_taka',function($v){
            if($v->purchase_type == 1)
            {
                $total = $v->weight * $v->rate;
                $total +=$v->labour_cost;
                $total +=$v->other_cost;
                $total +=$v->truck_cost;
                $total +=$v->van_cost;
                $total +=$v->tohori_cost;

                return $total;
            }
            else
            {
                return '-';
            }
        })
        ->addColumn('entry_date',function($v){
            return Carbon::createFromFormat('Y-m-d', $v->entry_date)->format('d-m-Y');
        })
        ->addColumn('action',function($v){

            return '<div class="flex gap-x-2">
                <a href="'.route('ponno_purchase_entry.edit', $v->id).'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ইডিট</a>

                <form method="post" action="'.route('ponno_purchase_entry.destroy',$v->id).'" id="deleteForm">
                '.csrf_field().'
                '.method_field('DELETE').'
                    <button onclick="return confirmation();" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit">
                    ডিলিট</button>
                </form>
                
                </div>';
        })
        
            ->rawColumns(['sl','invoice','mohajon','purchase_type','ponno_name','ponno_size','ponno_marka','gari_no','quantity',
            'weight','rate','total_cost','total_taka','entry_date','action'])
            ->make(true);
        }
 
        $mohajon_setup = mohajon_setup::where('status',1)->get();

        $ponno_setup = ponno_setup::all();

        $ponno_size_setup = ponno_size_setup::all();
        
        $ponno_marka_setup = ponno_marka_setup::all();

        return view('user.entry_admin.ponno_purchase_entry',compact('mohajon_setup','ponno_setup','ponno_size_setup','ponno_marka_setup'));
     }
}
