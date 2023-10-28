<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Redirect;
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
use App\Http\Controllers\User\BankEntryController;
use App\Http\Controllers\User\MohajonPaymentEntryController;
use App\Http\Controllers\User\MohajonReturnEntryController;
use App\Http\Controllers\User\AmanotEntryController;
use App\Http\Controllers\User\HawlatEntryController;
use App\Http\Controllers\User\OtherJomaKhorocEntryController;
use App\Http\Controllers\User\PonnoPurchaseEntryController;
use App\Http\Controllers\User\PonnoSalesEntryController;

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
    return view('auth.login');
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
        Session()->flush();

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








    /************* Common Ajax Route *************/
    Route::post('getkretaAddressByArea',[CommonAjaxController::class,'getkretaAddressByArea']);
    Route::post('getKretaNameByAddress',[CommonAjaxController::class,'getKretaNameByAddress']);

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

    Route::post('/admin/logout', [AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');

});
