<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Admin_panel_settingsController;
use App\Http\Controllers\Admin\Finance_calendersController;
use App\Http\Controllers\Admin\BranchesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

define('P_C', 11);
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function (){
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    
    // بداية الضبط الجديد
    Route::get('/generalSettings', [Admin_panel_settingsController::class, 'index'])->name('admin_panel_settings.index');
    Route::get('/generalSettingsEdit', [Admin_panel_settingsController::class, 'edit'])->name('admin_panel_settings.edit');
    Route::post('/generalSettingsUpdate', [Admin_panel_settingsController::class, 'update'])->name('admin_panel_settings.update');
    
    // بداية السنوات المالية
    Route::get('/finance_calenders/delete/{id}', [Finance_calendersController::class, 'destroy'])->name('finance_calenders.delete');
    Route::post('/finance_calenders/show_year_monthes', [Finance_calendersController::class, 'show_year_monthes'])->name('finance_calenders.show_year_monthes');
    Route::get('/finance_calenders/do_open/{id}', [Finance_calendersController::class, 'do_open'])->name('finance_calenders.do_open');
    Route::resource('/finance_calenders', Finance_calendersController::class);

    // بداية الفروع
    Route::get('/branches', [BranchesController::class, 'index'])->name('branches.index');
    Route::get('/branchesCreate', [BranchesController::class, 'create'])->name('branches.create');


});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'guest:admin'], function (){
    
    Route::get('login', [LoginController::class, 'show_login_view'])->name('admin.showlogin');
    
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
    
    // Route::get('test', function () {
    //     return view('admin.test');
    // });

});

Route::fallback(function(){
    return redirect()->route('admin.showlogin');
});

