<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserPrescriptionController;


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
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
    Route::get('login', [CustomAuthController::class, 'index'])->name('login');
    Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
    Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
    Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
    Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
    Route::get('prescription/view/{id}', 'QuotationController@viewQuotation')->name('view_prescription');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('user/list', 'UserPrescriptionController@getUserList')->name('user.list');
    Route::get('/pharmacy/create', 'UserPrescriptionController@index')->name('create_prescription');
    Route::post('/pharmacy/store', 'UserPrescriptionController@store')->name('store_prescription');
    Route::post('/accept-quotation', 'QuotationController@acceptQuotation');
    Route::get('prescription/list', 'UserPrescriptionController@getList')->name('time.list');
    Route::get('prescription/edit/{id}', 'UserPrescriptionController@editPrescription')->name('edit_prescription');
    Route::post('/quotation/store', 'QuotationController@store')->name('store_quotation');
});