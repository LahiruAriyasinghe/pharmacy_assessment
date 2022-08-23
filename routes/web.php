<?php

use Illuminate\Support\Facades\Route;

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
    return view('landing');
})->name('welcome');


Auth::routes();
Route::get('/dashboard', 'HomeController@index')->name('home');


Route::get('pharmacy/login', 'Auth\LoginController@showHospitalLoginForm')->name('login');
Route::get('pharmacy/register', 'Auth\LoginController@showHospitalRegisterForm')->name('pharmacy.register');


Route::resource('hospitals', 'HospitalController');
Route::resource('roles', 'RolesController');
Route::get('/resources/roles', 'RolesController@resourcesIndex')->name('resources.roles.index');

Route::resource('users', 'UserController');
Route::get('/users/email/check', 'UserController@checkUserEmail')->name('users.email.check');
Route::get('/users/username/check', 'UserController@checkUsername')->name('users.username.check');
Route::get('/resources/users', 'UserController@resourcesIndex')->name('resources.users.index');
Route::get('/resources/users/{user}', 'UserController@resourcesShow')->name('resources.users.show');
Route::put('/users/{user}/password/reset', 'UserController@reset')->name('users.password.reset');

Route::resource('other-services', 'OtherServicesController');
Route::get('/resources/other-services', 'OtherServicesController@resourcesIndex')->name('resources.other-services.index');

Route::resource('lab-reports/categories', 'LabReportCategoryController', ['as' => 'lab-reports']);
Route::get('/resources/lab-reports/categories', 'LabReportCategoryController@resourcesIndex')->name('resources.lab-reports.categories.index');

Route::resource('lab-reports/results', 'LabReportResultsController', ['as' => 'lab-reports']);
Route::get('lab-reports/results/{result}/print', 'LabReportResultsController@print')->name('lab-reports.results.print');
Route::get('/resources/results', 'LabReportResultsController@resourcesIndex')->name('resources.lab-reports.results.index');

Route::resource('lab-reports', 'LabReportsController');
Route::get('/resources/lab-reports', 'LabReportsController@resourcesIndex')->name('resources.lab-reports.index');

Route::get('/manage-lab-reports', 'ManageLabReportsController@index')->name('managelabreports');

Route::resource('specialties', 'SpecialtyController');
Route::get('/resources/specialties', 'SpecialtyController@resourcesIndex')->name('resources.specialties.index');

Route::resource('sessions', 'SessionController');
Route::get('/resources/sessions', 'SessionController@resourcesIndex')->name('resources.sessions.index');

// Reports Routes
Route::get('/reports/cashier', 'Reports\CashierReportsController@index')->name('reports.cashier.index');
Route::get('/reports/admin', 'Reports\AdminCashierReportController@index')->name('reports.admin.index');

Route::get('/resources/reports/cashier', 'Reports\CashierReportsController@resourcesIndex')->name('resources.reports.cashier.index');
Route::get('/resources/reports/admin', 'Reports\AdminCashierReportController@resourcesIndex')->name('resources.reports.admin.index');

Route::get('/reports/cashier/daily', 'Reports\CashReportController@daily')->name('reports.cashier.daily');
Route::post('/reports/admin/daily', 'Reports\AdminCashReportController@daily')->name('reports.admin.daily');

// Route::get('/reports/transaction', 'Reports\TransactionReportController@index')->name('reports.transaction');

// End Reports Routes

Route::resource('patients', 'PatientController');

Route::get('/invoices', 'InvoiceController@index')->name('invoice');
Route::post('/invoices/opd', 'Invoice\InvoiceOpdController@store')->name('invoices.opd.store');
Route::post('/invoices/channeling', 'Invoice\InvoiceChannelingController@store')->name('invoices.channeling.store');
Route::post('/invoices/lab', 'Invoice\InvoiceLabController@store')->name('invoices.lab.store');
Route::post('/invoices/product', 'Invoice\InvoicePharmacyController@store')->name('invoices.product.store');
Route::post('/invoices/other', 'Invoice\InvoiceOtherController@store')->name('invoices.other.store');
Route::get('/invoices/last-print', 'Invoice\InvoiceController@getLastInvoice')->name('invoices.last-print');

Route::get('/invoices-reverse', 'InvoiceReverseController@index')->name('invoice-reverse');
Route::post('/invoices-reverse', 'InvoiceReverseController@store')->name('invoice-reverse.store');

Route::get('doctors/{doctor}/sessions', 'SessionController@doctorSessions')->name('doctors.sessions');

// Pharmacy Feeding Routes
Route::resource('products', 'ProductController');
// Route::get('/resources/products', 'ProductController@resourcesIndex')->name('resources.product.index');

// Stock Feeding Routes
Route::resource('stocks', 'ProductStockController');
Route::get('/resources/product', 'ProductStockController@resourcesProductIndex')->name('resources.product.index');
Route::get('/resources/stocks', 'ProductStockController@resourcesStockIndex')->name('resources.stock.index');
Route::get('/resources/stock-exists', 'ProductStockController@checkStockExist')->name('resources.stock-exists');

// Units Feeding Routes
Route::resource('test-data/units', 'TestData\UnitController');
Route::get('/resources/test-data/units', 'TestData\UnitController@resourcesIndex')->name('resources.test-data.units.index');

// Test Data Result Category Feeding Routes
Route::resource('test-data/result-categories', 'TestData\ResultCategoryController', ['as' => 'test-data']);
Route::get('/resources/test-data/result-categories', 'TestData\ResultCategoryController@resourcesIndex')->name('resources.test-data.result-categories.index');

// Test Data Categories Feeding Routes
Route::resource('test-data/categories', 'TestData\CategoryController', ['as' => 'test-data']);
Route::get('/resources/test-data/categories', 'TestData\CategoryController@resourcesIndex')->name('resources.test-data.categories.index');

// Test Data Feeding Routes
Route::resource('test-datas', 'TestData\TestDataController');
Route::get('/resources/test-datas', 'TestData\TestDataController@resourcesIndex')->name('resources.test-datas.index');
