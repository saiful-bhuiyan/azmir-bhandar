<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ponno_setup;
use App\Models\ponno_sales_info;
use App\Models\ponno_sales_entry;
use App\Models\ponno_purchase_entry;
use Brian2694\Toastr\Facades\Toastr;

class PonnoSaleReportController extends Controller
{
    public function ponno_sales_report()
    {
        $ponno_setup = ponno_setup::get();
        return view('user.report.ponno_sales_report.index',compact('ponno_setup'));
    }

    public function searchSalesReport(Request $request)
    {
        $date_from = Carbon::createFromFormat('d-m-Y', $request->date_from)->format('Y-m-d');
        $date_to = Carbon::createFromFormat('d-m-Y', $request->date_to)->format('Y-m-d');
        $sales_type = $request->sales_type; 
         $ponno_setup_id = $request->ponno_setup_id ;
         

        if($sales_type == 3)
        {
            if($request->ponno_setup_id > 0)
            {
                
                 $sales = ponno_sales_info::with('ponno_sales_entry')->whereHas('ponno_sales_entry',function($query) use($ponno_setup_id) {
                    $query->whereHas('ponno_purchase_entry', function($query2) use($ponno_setup_id){
                        $query2->whereIn('ponno_setup_id',[$ponno_setup_id]);
                    });
                 })->whereBetween('entry_date',[$date_from, $date_to])->get();

                 $viewContent = view('user.report.ponno_sales_report.all_table', compact('sales','sales_type'))->render();

                 return response()->json(['viewContent' => $viewContent]);
                 
            }
            else
            {
                $sales = ponno_sales_info::whereBetween('entry_date',[$date_from, $date_to])->get();

                $viewContent = view('user.report.ponno_sales_report.all_table', compact('sales','sales_type'))->render();

                return response()->json(['viewContent' => $viewContent]);
         
            }
            
        }
        else if($sales_type == 1 or 2)
        {
            if($request->ponno_setup_id > 0)
            {
                
                 $sales = ponno_sales_info::with('ponno_sales_entry')->whereHas('ponno_sales_entry',function($query) use($ponno_setup_id) {
                    $query->whereHas('ponno_purchase_entry', function($query2) use($ponno_setup_id){
                        $query2->whereIn('ponno_setup_id',[$ponno_setup_id]);
                    });
                 })->where('sales_type',$sales_type)->whereBetween('entry_date',[$date_from, $date_to])->get();

                 $viewContent = view('user.report.ponno_sales_report.all_table', compact('sales','sales_type'))->render();

                 return response()->json(['viewContent' => $viewContent]);
                 
            }
            else
            {
                $sales = ponno_sales_info::where('sales_type',$sales_type)->whereBetween('entry_date',[$date_from, $date_to])->get();

                $viewContent = view('user.report.ponno_sales_report.type_table', compact('sales','sales_type'))->render();

                return response()->json(['viewContent' => $viewContent]);
      
            }
            
            
        }
        else
        {
            $validate = $request->validate([
                'date_from' => 'required',
                'date_to' => 'required',
            ],
            [
                'date_from.required' => 'তারিখ সিলেক্ট করুন',
                'date_to.required' => 'তারিখ সিলেক্ট করুন',
            ]
            );
            Toastr::error(__('দয়া করে তারিখ সিলেক্ট করুন'), __('ব্যর্থ'));
            return redirect()->back();
        }

    }

    public function sales_memo($id)
    {
        $sales = ponno_sales_info::where('id',$id)->first();
        
        return view('user.report.ponno_sales_report.sales_memo',compact('sales'));
    }
}
