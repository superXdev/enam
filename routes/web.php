<?php

use Illuminate\Support\Facades\Route;
use App\Models\Account;
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
    return view('welcome');
});

Route::get('tes', function(Account $account){
	$acc = $account->find(2);

	$dec = $acc->showData('123', $acc);

	return dd($dec);
});