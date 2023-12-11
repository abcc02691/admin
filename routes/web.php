<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

//登入頁
Route::get('/login',function(){
    return view('login');
});
Route::get('/login_index', [LoginController::class, 'index']);
//建立帳號
// Route::get('/create_account',function(){
//     return view('create_account');
// });
Route::get('/create_account', [LoginController::class, 'create_index']);
Route::post('/create_user', [LoginController::class, 'create']);
Route::post('/create_org', [LoginController::class, 'create_org']);
