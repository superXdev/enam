<?php

use Illuminate\Support\Facades\Route;
use App\Models\Account;
use App\Http\Controllers\{DashboardController, AccountController};



Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function(){
	Route::get('', [DashboardController::class, 'index'])->name('dashboard');
	Route::get('/logs', [DashboardController::class, 'logs'])->name('dashboard.logs');


	Route::post('/setkey', [DashboardController::class, 'store_secretkey'])->name('dashboard.key');
	
	Route::get('/account/add', [AccountController::class, 'create'])->name('dashboard.account.add');
	Route::post('/account/store', [AccountController::class, 'store'])->name('dashboard.account.store');
	Route::post('/account/{account}/delete', [AccountController::class, 'delete'])->name('dashboard.account.delete');
	Route::get('/account/{account}/edit', [AccountController::class, 'edit'])->name('dashboard.account.edit');
	Route::post('/account/{account}/update', [AccountController::class, 'update'])->name('dashboard.account.update');
	Route::post('/account/{account}/togglestatus', [AccountController::class, 'toggleStatus'])->name('dashboard.account.togglestatus');

	Route::get('/account/{service}', [AccountController::class, 'index'])->name('dashboard.account');
	Route::get('/account/{service}/{tag}', [DashboardController::class, 'tag'])->name('dashboard.account.tag');
});

Route::post('out', [DashboardController::class, 'out'])->name('logout.custom');

Route::get('tes', function(){
	$account = Account::find(1);
	dd(auth()->user()->can('delete', $account));
	dd(Cache::get('secretkey'));

});