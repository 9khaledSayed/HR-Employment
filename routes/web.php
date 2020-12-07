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
Auth::routes(['verify' => true]);

Route::redirect('/', 'login');

Route::get('language/{lang}', function ($lang) {
    Session::put('locale', $lang);
    return back();
})->name('change_language');

Route::get('/foo', function (){
   \Illuminate\Support\Facades\Artisan::call('migrate:fresh --seed');
   dd('done');
});

Route::namespace('Dashboard')
    ->prefix('dashboard')
    ->name('dashboard.')
    ->middleware('auth')
    ->middleware('verified')
    ->group(function(){
        Route::get('/', 'DashboardController@index')->name('index');
        Route::get('/abilities', 'AbilityController@index');
        Route::get('/violations/{violation}/additions', 'ViolationController@additions');
        Route::get('myProfile/account_info', 'ProfileController@accountInfo')->name('myProfile.account_info');
        Route::post('myProfile/update_account_info', 'ProfileController@updateAccountInfo')->name('myProfile.update_account_info');
        Route::get('myProfile/change_password', 'ProfileController@changePasswordForm')->name('myProfile.change_password');
        Route::post('myProfile/change_password', 'ProfileController@changePassword')->name('myProfile.changePassword');

        Route::resources([
        'employees' => 'EmployeeController',
        'violations' => 'ViolationController',
        'roles' => 'RoleController',
        'customers' => 'CustomerController',
        'employees_violations' => 'EmployeeViolationController',
        'reports' => 'ReportController',
        'conversations' => 'ConversationController',
        'messages' => 'MessageController',
    ]);
});
