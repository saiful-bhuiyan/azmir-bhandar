<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\bank_setup;
use App\Models\bank_check_book_setup;
use App\Models\check_book_page_setup;
use App\Models\mohajon_setup;
use App\Models\amanot_setup;
use App\Models\hawlat_setup;
use App\Models\kreta_joma_entry;
use App\Models\kreta_koifiyot_entry;
use App\Models\kreta_setup;
use App\Models\ponno_sales_info;

class CommonAjaxController extends Controller
{

    /***************** To get Bank Setup Info ****************/

    public function getBankSetupInfo(Request $request)
    {
        $bank_setup = bank_setup::all();

        $select = '<option value="">সিলেক্ট</option>';

        foreach($bank_setup as $v)
        {
            $select .='<option value="'.$v->id.'">'.$v->shakha.' / '.$v->bank_name.' /'.$v->account_name.' /'.$v->account_no.'</option>';
        }

        return $select;
    }

    /***************** To get check page from bank_check_book_setup ****************/

    public function getCheckByBankId(Request $request)
    {
        $bank_check = bank_check_book_setup::where('bank_setup_id',$request->bank_setup_id)->get();

        $select = '<option value="">সিলেক্ট</option>';

        foreach($bank_check as $bc)
        {
            $check_page = check_book_page_setup::where('check_id',$bc->id)->get();

            foreach($check_page as $v)
            {
                $select .='<option value="'.$v->id.'">'.$v->page.'</option>';
            }
        }

        return $select;
    }

    /******************** Get addres By area from Mohajon Setup **********************/

    public function getMohajonAddressByArea(Request $request)
    {
        $address = mohajon_setup::select('address')->where('area',$request->area)->groupBy('address')->orderBy('address')->get();

        $select = '<option value="">সিলেক্ট</option>';

        foreach($address as $v)
        {
            $select .='<option value="'.$v->address.'">'.$v->address.'</option>';
        }

        return $select;
    }

     /******************** Get Name By Address from Mohajon Setup **********************/

    public function getMohajonNameByAddress(Request $request)
    {
        $name = mohajon_setup::where('address',$request->address)->orderBy('name')->get();

        $select = '<option value="">সিলেক্ট</option>';

        foreach($name as $v)
        {
            $select .='<option value="'.$v->id.'">'.$v->name.'</option>';
        }

        return $select;
    }

    /******************** Get Name By Address from Amanot Setup **********************/

    public function getAmanotNameByAddress(Request $request)
    {
        $name = amanot_setup::where('address',$request->address)->orderBy('name')->get();

        $select = '<option value="">সিলেক্ট</option>';

        foreach($name as $v)
        {
            $select .='<option value="'.$v->id.'">'.$v->name.'</option>';
        }

        return $select;
    }

     /******************** Get Name By Address from Amanot Setup **********************/

     public function getHawlatNameByAddress(Request $request)
     {
         $name = hawlat_setup::where('address',$request->address)->orderBy('name')->get();
 
         $select = '<option value="">সিলেক্ট</option>';
 
         foreach($name as $v)
         {
             $select .='<option value="'.$v->id.'">'.$v->name.'</option>';
         }
 
         return $select;
     }

    /******************** Get Address By Area from Kreta Setup **********************/

    public function getkretaAddressByArea(Request $request)
    {
        $address = kreta_setup::select('address')->where('area',$request->area)->groupBy('address')->orderBy('address')->get();

        $select = '<option value="">সিলেক্ট</option>';

        foreach($address as $v)
        {
            $select .='<option value="'.$v->address.'">'.$v->address.'</option>';
        }

        return $select;
    }

    /******************** Get Name By Address from Kreta Setup **********************/

    public function getKretaNameByAddress(Request $request)
    {
        $name = kreta_setup::where('address',$request->address)->orderBy('name')->get();

        $select = '<option value="">সিলেক্ট</option>';

        foreach($name as $v)
        {
            $select .='<option value="'.$v->id.'">'.$v->name.'</option>';
        }

        return $select;
    }

    public function getKretaOldAmount(Request $request)
    {
        $kreta_setup_id = $request->kreta_setup_id;
        $kreta_setup = kreta_setup::find($kreta_setup_id);
        $total_taka = 0;

        $sales = ponno_sales_info::with('ponno_sales_entry')->whereHas('ponno_sales_entry',function($query) use($kreta_setup_id){
            $query->whereHas('ponno_purchase_entry',function($query2) use($kreta_setup_id){
                $query2->whereIn('kreta_setup_id',[$kreta_setup_id]);
            });
        })->where('sales_type',2)->sum('total_taka');

        $joma = kreta_joma_entry::where('kreta_setup_id',$kreta_setup_id)->sum('taka');
        $koifiyot = kreta_koifiyot_entry::where('kreta_setup_id',$kreta_setup_id)->sum('taka');

        $total_taka += $kreta_setup->old_amount;
        $total_taka += $sales;
        $total_taka -= $joma;
        $total_taka -= $koifiyot;

        return $total_taka;
    }
}
