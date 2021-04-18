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
    return view('auth.login');
});
Auth::routes(['register' => false]);
Route::get('/home', 'HomeController@index')->name('home');


Route::middleware(['role:Administrator','auth'])->group(function () {
    // Route::get('/agency/types', 'Admin\PageController@agencytype');  
    Route::get('/staffs', 'Admin\PageController@staffs'); 
    Route::get('/agencies', 'Admin\PageController@agencies'); 
    Route::get('/dropdownlists', 'Admin\PageController@dropdownlists'); 
    Route::get('/testservices', 'Admin\PageController@testservices'); 
    Route::get('/packages', 'Admin\PageController@packages'); 
    Route::get('/addons', 'Admin\PageController@addons');
}); 

Route::middleware(['role:Customer Relations Officer','auth'])->group(function () {
    // Route::get('/agency/types', 'Admin\PageController@agencytype');  
    Route::get('/customers', 'Cro\PageController@customers'); 
    Route::get('/requests', 'Cro\PageController@requests'); 
    Route::get('/request/{id}', 'Cro\PageController@request'); 
    Route::get('/reports', 'Cro\PageController@reports');

}); 

Route::middleware(['role:Cashier','auth'])->group(function () {
    Route::get('/orseries', 'Finance\PageController@orseries');  
    Route::get('/orderofpayments', 'Finance\PageController@orderofpayments');  
    Route::get('/orderofpayment/{id}', 'Finance\PageController@orderofpayment');  ;  
    Route::get('/types', 'Finance\PageController@types');
});

Route::middleware(['role:Lab Analyst','auth'])->group(function () {
    Route::get('/samples', 'Lab\PageController@samples'); 
});



Route::prefix('request')->group(function () {

    Route::post('/user/password', 'Admin\UserController@password');
    Route::get('/regions', 'HomeController@regions');
    Route::get('/provinces/{id}', 'HomeController@provinces');
    Route::get('/municipalities/{id}', 'HomeController@municipalities');

    Route::prefix('admin')->group(function () {

        Route::post('/users', 'Admin\UserController@index'); 
        Route::post('/user/store', 'Admin\UserController@store');
        Route::put('/user/store', 'Admin\UserController@store');
        Route::put('/user/status', 'Admin\UserController@status');

        Route::get('/dd/list/{type}', 'Admin\DropdownlistController@list');
        Route::get('/dd/active/{type}', 'Admin\DropdownlistController@active');
        Route::post('/dd/lists', 'Admin\DropdownlistController@lists');
        Route::post('/dd/paginated', 'Admin\DropdownlistController@paginated');
        Route::post('/dd/status', 'Admin\DropdownlistController@status');
        Route::post('/dd/store', 'Admin\DropdownlistController@store');

        Route::get('/agency/list/{type}', 'Admin\AgencyController@list');
        Route::post('/agency/paginated', 'Admin\AgencyController@paginated');
        Route::post('/agency/store', 'Admin\AgencyController@store');

        Route::get('/sampletypes/{id}', 'Admin\TestserviceController@sampletypes');

        Route::post('/testservice/store', 'Admin\TestserviceController@store');
        Route::get('/testservice/list', 'Admin\TestserviceController@list');
        Route::get('/testservices/{id}', 'Admin\TestserviceController@paginated');
        Route::post('/testservices/search', 'Admin\TestserviceController@search');
        Route::get('/addons', 'Admin\TestserviceController@addons');

        Route::post('/package/store', 'Admin\PackageController@store');
        Route::get('/package/list', 'Admin\PackageController@list');
        Route::get('/packages/{id}', 'Admin\PackageController@index');
        Route::post('/packages/search', 'Admin\PackageController@search');

    });

    Route::prefix('cro')->group(function () {

        Route::get('/customer/list', 'Cro\CustomerController@lists');
        Route::post('/customer/search', 'Cro\CustomerController@search');
        Route::post('/customer/store', 'Cro\CustomerController@store');
        Route::put('/customer/store', 'Cro\CustomerController@store');
        Route::post('/customerbranch/search', 'Cro\CustomerController@searchbranch');
        Route::post('/customerbranch/store', 'Cro\CustomerController@storebranch');

        Route::get('/conforme/{id}', 'Cro\ConformeController@list');
        Route::post('/conforme/store', 'Cro\ConformeController@store');
        Route::put('/conforme/store', 'Cro\ConformeController@store');

        Route::get('/requests', 'Cro\RequestController@index'); 
        Route::post('/request/store', 'Cro\RequestController@store');
        Route::post('/request/update', 'Cro\RequestController@update');
        Route::put('/request/store', 'Cro\RequestController@store');
        Route::get('/request/{id}', 'Cro\RequestController@view'); 
        Route::post('/request/search', 'Cro\RequestController@search');

        Route::post('/samples', 'Cro\SampleController@samples');
        Route::get('/samples/{id}', 'Cro\SampleController@index');
        Route::post('/sample/store', 'Cro\SampleController@store');
        Route::post('/sample/destroy', 'Cro\SampleController@destroy');
        Route::get('/sampletesting', 'Cro\SampleController@index');

        Route::get('/analyses/{id}', 'Cro\AnalysisController@index');
        Route::get('/analyses/packages/{id}', 'Cro\AnalysisController@package');
        Route::post('/analysis/store', 'Cro\AnalysisController@store');
        Route::post('/analysis/destroy', 'Cro\AnalysisController@destroy');
        Route::get('/solo/{id}/{type}', 'Cro\AnalysisController@solo');
        Route::get('/packages/{id}/{type}', 'Cro\AnalysisController@packages');
        Route::get('/solo/{id}/{type}/{keyword}', 'Cro\AnalysisController@solosearch');

        Route::post('/sampletypes', 'Cro\TestserviceController@sampletype');
        Route::get('/sampletypes/{id}', 'Cro\TestserviceController@sampletypes');

        Route::post('/reports', 'Cro\ReportController@index');
        Route::get('/print', 'Cro\ReportController@print');
        Route::get('/printtest', 'Cro\ReportController@printtest');

        Route::get('/top', 'Cro\HomeController@top');
        Route::get('/services', 'Cro\HomeController@services');
        
    });

    Route::prefix('finance')->group(function () {

        Route::post('/orseries/list', 'Finance\ORSeriesController@index');
        Route::post('/orseries/store', 'Finance\ORSeriesController@store');
        Route::put('/orseries/store', 'Finance\ORSeriesController@store');
        Route::post('/orseries/status', 'Finance\ORSeriesController@status');

        Route::get('/orderofpayments', 'Finance\TransactionController@index'); 
        Route::post('/orderofpayments/list', 'Finance\TransactionController@list'); 

        Route::get('/transaction/{user}', 'Finance\TransactionController@customer'); 
        Route::get('/requests/{id}', 'Finance\TransactionController@request'); 
        Route::post('/payment', 'Finance\TransactionController@payment');
    });

    Route::prefix('lab')->group(function () {

        Route::post('/analyses/lists', 'Lab\AnalystController@search'); 
        Route::get('/analyses/lists/{sample}/{status}/{keyword}', 'Lab\AnalystController@search'); 
        Route::get('/analyses/{status}', 'Lab\AnalystController@urgent'); 
        Route::get('/analyses/waiting/{status}', 'Lab\AnalystController@chill'); 
        Route::post('/analysis/status', 'Lab\AnalystController@status'); 
        Route::get('/sampletypes', 'Cro\TestserviceController@lists');
        Route::get('/analysis/todolist/{time}', 'Lab\AnalystController@todolist');  
    });



});