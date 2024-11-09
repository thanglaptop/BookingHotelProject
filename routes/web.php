<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerLoginController;
// Route::get('/', function () {
//     return view('login');
// })->name('loginpage');
Route::get('/', [OwnerLoginController::class, 'showCity'])->name('index'); 

Route::post('/check-owner', [OwnerLoginController::class, 'checkLogin'])->name('checklogin');
Route::post('/check-customer', [OwnerLoginController::class, 'checkKHLogin'])->name('checkKHlogin');

Route::get('/mainowner/owner{id}', [OwnerLoginController::class, 'showWelcome'])->name('mainowner');
Route::get('/maincustomer/customer{id}', [OwnerLoginController::class, 'showKHWelcome'])->name('maincustomer');

Route::get('/edithotel/hotel{id}', [OwnerLoginController::class, 'showEditHotel'])->name('edithotel');

Route::get('/managehotel/hotel{id}', [OwnerLoginController::class, 'showManageHotel'])->name('managehotel');

Route::get('/editroom/room{id}', [OwnerLoginController::class, 'showEditRoom'])->name('editroom');

Route::get('/listhotel/city{id}', [OwnerLoginController::class, 'showHotelOfCity'])->name('showlisthotel');

Route::get('/infohotel/hotel{id}', [OwnerLoginController::class, 'showInfoHotel'])->name('showinfohotel');
