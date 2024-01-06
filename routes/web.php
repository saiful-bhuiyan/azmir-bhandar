<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UserSetupController;

use App\Http\Controllers\User\CommonAjaxController;
use App\Http\Controllers\User\MohajonSetupController;
use App\Http\Controllers\User\PonnoSetupController;
use App\Http\Controllers\User\PonnoSizeSetupController;
use App\Http\Controllers\User\PonnoMarkaSetupController;
use App\Http\Controllers\User\KretaSetupController;
use App\Http\Controllers\User\BikroyMarfotSetupController;
use App\Http\Controllers\User\BankSetupController;
use App\Http\Controllers\User\BankCheckBookSetupController;
use App\Http\Controllers\User\AmanotSetupController;
use App\Http\Controllers\User\HawlatSetupController;
use App\Http\Controllers\User\OtherJomaKhorocSetupController;
use App\Http\Controllers\User\MohajonCommissionSetupController;
use App\Http\Controllers\User\KretaCommissionSetupController;
use App\Http\Controllers\User\KretaJomaEntryController;
use App\Http\Controllers\User\KretaKoifiyotEntryController;
use App\Http\Controllers\User\BankEntryController;
use App\Http\Controllers\User\MohajonPaymentEntryController;
use App\Http\Controllers\User\MohajonReturnEntryController;
use App\Http\Controllers\User\AmanotEntryController;
use App\Http\Controllers\User\HawlatEntryController;
use App\Http\Controllers\User\OtherJomaKhorocEntryController;
use App\Http\Controllers\User\PonnoPurchaseEntryController;
use App\Http\Controllers\User\PonnoSalesEntryController;
use App\Http\Controllers\User\ArodchothaController;

/************* Report  ****************/

use App\Http\Controllers\Report\PonnoPurchaseReportController;
use App\Http\Controllers\Report\PonnoSaleReportController;
use App\Http\Controllers\Report\KretaLedgerController;
use App\Http\Controllers\Report\StockReportController;
use App\Http\Controllers\Report\AmanotReportController;
use App\Http\Controllers\Report\HawlatReportController;
use App\Http\Controllers\Report\OtherJomaKhorocReportController;
use App\Http\Controllers\Report\KretaKoifiyotReportController;
use App\Http\Controllers\Report\BankReportController;
use App\Http\Controllers\Report\CommissionReportController;
use App\Http\Controllers\Report\PonnoLavLossReportController;
use App\Http\Controllers\Report\MohajonLedgerController;
use App\Http\Controllers\Report\KretaShortReportController;
use App\Http\Controllers\Report\ShortReportController;
use App\Http\Controllers\Report\BikroyMarfotReportController;
use App\Http\Controllers\Report\CashReportController;
use App\Http\Controllers\Report\DailyCommissionReportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    
    return redirect('/dashboard');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth'],  function() {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::get('logout', function ()
    {
        auth()->logout();
       
        return Redirect::to('/');
    })->name('logout');

    /***************  Setup Controller ***********/

    Route::resource('mohajon_setup' ,MohajonSetupController::class);
    Route::get('mohajonSetupStatusChange/{id}', [MohajonSetupController::class,'mohajonSetupStatusChange']);

    Route::resource('ponno_setup' ,PonnoSetupController::class);

    Route::resource('ponno_size_setup' ,PonnoSizeSetupController::class);

    Route::resource('ponno_marka_setup' ,PonnoMarkaSetupController::class);

    Route::resource('kreta_setup' ,KretaSetupController::class);
    Route::get('kretaSetupStatusChange/{id}', [KretaSetupController::class,'kretaSetupStatusChange']);

    Route::resource('bikroy_marfot_setup' ,BikroyMarfotSetupController::class);

    Route::resource('bank_setup' ,BankSetupController::class);
    Route::get('bankSetupStatusChange/{id}', [BankSetupController::class,'bankSetupStatusChange']);

    Route::resource('bank_check_book_setup' ,BankCheckBookSetupController::class);
    Route::get('bankCheckBookSetupStatusChange/{id}', [BankCheckBookSetupController::class,'bankCheckBookSetupStatusChange']);
    Route::post('getBankNameByShakha',[BankCheckBookSetupController::class,'getBankNameByShakha']);
    Route::post('getAccNameByBankName',[BankCheckBookSetupController::class,'getAccNameByBankName']);
    Route::post('getAccNoByAccName',[BankCheckBookSetupController::class,'getAccNoByAccName']);

    Route::resource('amanot_setup' ,AmanotSetupController::class);
    Route::get('amanotSetupStatusChange/{id}', [AmanotSetupController::class,'amanotSetupStatusChange']);

    Route::resource('hawlat_setup' ,HawlatSetupController::class);
    Route::get('hawlatSetupStatusChange/{id}', [HawlatSetupController::class,'hawlatSetupStatusChange']);

    Route::resource('other_joma_khoroc_setup' ,OtherJomaKhorocSetupController::class);
    Route::get('otherJomaKhorocSetupStatusChange/{id}', [OtherJomaKhorocSetupController::class,'otherJomaKhorocSetupStatusChange']);

    Route::resource('mohajon_commission_setup' ,MohajonCommissionSetupController::class);

    Route::resource('kreta_commission_setup' ,KretaCommissionSetupController::class);
    


    // Entry

    Route::resource('kreta_joma_entry' ,KretaJomaEntryController::class);

    Route::resource('bank_entry' ,BankEntryController::class);

    Route::resource('mohajon_payment_entry' ,MohajonPaymentEntryController::class);

    Route::resource('mohajon_return_entry' ,MohajonReturnEntryController::class);

    Route::resource('amanot_entry' ,AmanotEntryController::class);

    Route::resource('hawlat_entry' ,HawlatEntryController::class);
    
    Route::resource('other_joma_khoroc_entry' ,OtherJomaKhorocEntryController::class);

    Route::resource('kreta_koifiyot_entry' ,KretaKoifiyotEntryController::class);

    Route::resource('ponno_purchase_entry' ,PonnoPurchaseEntryController::class);

    Route::resource('ponno_sales_entry' ,PonnoSalesEntryController::class);
    Route::post('getPurchaseDetail',[PonnoSalesEntryController::class,'getPurchaseDetail']);
    Route::get('getAmountByKreta',[PonnoSalesEntryController::class,'getAmountByKreta']);
    Route::post('storePonnoSales',[PonnoSalesEntryController::class,'storePonnoSales']);

    Route::resource('arod_chotha' ,ArodchothaController::class);
    Route::post('getPurchaseIdByMohajonId',[ArodchothaController::class,'getPurchaseIdByMohajonId']);
    Route::post('loadArodChothaTable',[ArodchothaController::class,'loadArodChothaTable']);
    Route::get('arod_chotha_entry/{purchase_id}',[ArodchothaController::class,'arod_chotha_entry']);
    Route::get('arod_chotha_memo/{id}',[ArodchothaController::class,'arod_chotha_memo'])->name('arod_chotha.memo');



    /************ Report Routes *******************/

    Route::get('ponno_purchase_report',[PonnoPurchaseReportController::class,'ponno_purchase_report']);
    Route::post('searchPurchaseReport',[PonnoPurchaseReportController::class,'searchPurchaseReport']);
    Route::get('purchase_memo/{id}',[PonnoPurchaseReportController::class,'purchase_memo'])->name('ponno_purchase_report.memo');


    Route::get('ponno_sales_report',[PonnoSaleReportController::class,'ponno_sales_report']);
    Route::post('searchSalesReport',[PonnoSaleReportController::class,'searchSalesReport']);
    Route::get('sales_memo/{id}',[PonnoSaleReportController::class,'sales_memo'])->name('ponno_sales_report.memo');

    Route::get('kreta_ledger',[KretaLedgerController::class,'index'])->name('kreta_ledger.index');
    Route::post('kreta_ledger_search',[KretaLedgerController::class,'search'])->name('kreta_ledger.search');

    Route::get('stock_report',[StockReportController::class,'index'])->name('stock_report.index');
    Route::post('stock_report_search',[StockReportController::class,'search'])->name('stock_report.search');

    Route::get('amanot_ledger',[AmanotReportController::class,'index'])->name('amanot_ledger.index');
    Route::post('amanot_ledger_search',[AmanotReportController::class,'search'])->name('amanot_ledger.search');

    Route::get('hawlat_ledger',[HawlatReportController::class,'index'])->name('hawlat_ledger.index');
    Route::post('hawlat_ledger_search',[HawlatReportController::class,'search'])->name('hawlat_ledger.search');

    Route::get('other_joma_khoroc_report',[OtherJomaKhorocReportController::class,'index'])->name('other_joma_khoroc_report.index');
    Route::post('other_joma_khoroc_report_search',[OtherJomaKhorocReportController::class,'search'])->name('other_joma_khoroc_report.search');

    Route::get('kreta_koifiyot_report',[KretaKoifiyotReportController::class,'index'])->name('kreta_koifiyot_report.index');
    Route::post('kreta_koifiyot_report_search',[KretaKoifiyotReportController::class,'search'])->name('kreta_koifiyot_report.search');

    Route::get('bank_ledger',[BankReportController::class,'index'])->name('bank_ledger.index');
    Route::post('bank_ledger_search',[BankReportController::class,'search'])->name('bank_ledger.search');

    Route::get('commission_report',[CommissionReportController::class,'index'])->name('commission_report.index');
    Route::post('commission_report_search',[CommissionReportController::class,'search'])->name('commission_report.search');

    Route::get('ponno_lav_loss_report',[PonnoLavLossReportController::class,'index'])->name('ponno_lav_loss_report.index');
    Route::post('ponno_lav_loss_report_search',[PonnoLavLossReportController::class,'search'])->name('ponno_lav_loss_report.search');

    Route::get('mohajon_ledger',[MohajonLedgerController::class,'index'])->name('mohajon_ledger.index');
    Route::post('mohajon_ledger_search',[MohajonLedgerController::class,'search'])->name('mohajon_ledger.search');

    Route::get('kreta_short_report',[KretaShortReportController::class,'index'])->name('kreta_short_report.index');

    Route::get('short_report',[ShortReportController::class,'index'])->name('short_report.index');
    Route::post('short_report_search',[ShortReportController::class,'search'])->name('short_report.search');

    Route::get('bikroy_marfot_report',[BikroyMarfotReportController::class,'index'])->name('bikroy_marfot_report.index');
    Route::post('bikroy_marfot_report_search',[BikroyMarfotReportController::class,'search'])->name('bikroy_marfot_report.search');

    Route::get('daily_commission_report',[DailyCommissionReportController::class,'index'])->name('daily_commission_report.index');
    Route::post('daily_commission_report_search',[DailyCommissionReportController::class,'search'])->name('daily_commission_report.search');

    Route::get('cash_report',[CashReportController::class,'index'])->name('cash_report.index');
    Route::post('cash_report_search',[CashReportController::class,'search'])->name('cash_report.search');
    Route::get('cash_joma_report/{entry_date}',[CashReportController::class,'searchByJoma'])->name('cash_report.all_joma');
    Route::get('cash_khoroc_report/{entry_date}',[CashReportController::class,'searchByKhoroc'])->name('cash_report.all_khoroc');
    Route::post('cash_report_transfer',[CashReportController::class,'cash_transfer'])->name('cash_report.transfer');




    /************* Common Ajax Route *************/
    Route::post('getkretaAddressByArea',[CommonAjaxController::class,'getkretaAddressByArea']);
    Route::post('getKretaNameByAddress',[CommonAjaxController::class,'getKretaNameByAddress']);
    Route::post('getKretaOldAmount',[CommonAjaxController::class,'getKretaOldAmount']);

    Route::post('getBankSetupInfo',[CommonAjaxController::class,'getBankSetupInfo']);
    Route::post('getCheckByBankId',[CommonAjaxController::class,'getCheckByBankId']);

    Route::post('getMohajonAddressByArea',[CommonAjaxController::class,'getMohajonAddressByArea']);
    Route::post('getMohajonNameByAddress',[CommonAjaxController::class,'getMohajonNameByAddress']);

    Route::post('getAmanotNameByAddress',[CommonAjaxController::class,'getAmanotNameByAddress']);

    Route::post('getHawlatNameByAddress',[CommonAjaxController::class,'getHawlatNameByAddress']);




});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('admin.login')->middleware('guest:admin');

Route::post('/admin/login/store', [AuthenticatedSessionController::class, 'store'])->name('admin.login.store');

Route::group(['middleware' => 'admin'], function() {

    Route::get('/admin', [HomeController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/logout', [AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');

    /*************** Admin Panel Routes *******************/

    Route::resource('user_setup' ,UserSetupController::class);


    Route::get('mohajon_setup_admin',[MohajonSetupController::class,'admin'])->name('mohajon_setup.admin');
    Route::get('ponno_setup_admin',[PonnoSetupController::class,'admin'])->name('ponno_setup.admin');
    Route::get('ponno_size_setup_admin',[PonnoSizeSetupController::class,'admin'])->name('ponno_size_setup.admin');
    Route::get('ponno_marka_setup_admin',[PonnoMarkaSetupController::class,'admin'])->name('ponno_marka_setup.admin');
    Route::get('kreta_setup_admin',[KretaSetupController::class,'admin'])->name('kreta_setup.admin');
    Route::get('bikroy_marfot_setup_admin',[BikroyMarfotSetupController::class,'admin'])->name('bikroy_marfot_setup.admin');
    Route::get('bank_setup_admin',[BankSetupController::class,'admin'])->name('bank_setup.admin');
    Route::get('bank_check_book_setup_admin',[BankCheckBookSetupController::class,'admin'])->name('bank_check_book_setup.admin');
    Route::get('amanot_setup_admin',[AmanotSetupController::class,'admin'])->name('amanot_setup.admin');
    Route::get('hawlat_setup_admin',[HawlatSetupController::class,'admin'])->name('hawlat_setup.admin');
    Route::get('other_joma_khoroc_setup_admin',[OtherJomaKhorocSetupController::class,'admin'])->name('other_joma_khoroc_setup.admin');
    Route::get('mohajon_commission_setup_admin',[MohajonCommissionSetupController::class,'admin'])->name('mohajon_commission_setup.admin');
    Route::get('kreta_commission_setup_admin',[KretaCommissionSetupController::class,'admin'])->name('kreta_commission_setup.admin');


    Route::get('ponno_purchase_entry_admin',[PonnoPurchaseEntryController::class,'admin'])->name('ponno_purchase_entry.admin');
    Route::post('ponno_purchase_update/{id}',[PonnoPurchaseEntryController::class,'ponno_purchase_update'])->name('ponno_purchase_entry.ponno_purchase_update');

    Route::get('ponno_sales_entry_admin',[PonnoSalesEntryController::class,'admin'])->name('ponno_sales_entry.admin');
    Route::get('ponno_sales_entry_update_admin/{id}',[PonnoSalesEntryController::class,'update_sales']);
    Route::get('ponno_sales_entry_delete/{id}',[PonnoSalesEntryController::class,'entry_delete']);
    Route::post('ponno_sales_entry_info_update/{id}',[PonnoSalesEntryController::class,'info_update'])->name('ponno_sales_entry.info_update');

    Route::get('kreta_joma_entry_admin',[KretaJomaEntryController::class,'admin'])->name('kreta_joma_entry.admin');

    Route::get('bank_entry_admin',[BankEntryController::class,'admin'])->name('bank_entry.admin');


    Route::get('amanot_entry_admin',[AmanotEntryController::class,'admin'])->name('amanot_entry.admin');

    Route::get('hawlat_entry_admin',[HawlatEntryController::class,'admin'])->name('hawlat_entry.admin');

    Route::get('other_joma_khoroc_entry_admin',[OtherJomaKhorocEntryController::class,'admin'])->name('other_joma_khoroc_entry.admin');

    Route::get('mohajon_payment_entry_admin',[MohajonPaymentEntryController::class,'admin'])->name('mohajon_payment_entry.admin');

    Route::get('mohajon_return_entry_admin',[MohajonReturnEntryController::class,'admin'])->name('mohajon_return_entry.admin');









});
