<?php

use App\Http\Controllers\DisplayContentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CustomerController;

use App\Http\Middleware\CustomerMiddleware;
use App\Http\Middleware\OwnerMiddleware;

Route::get('/', [DisplayContentController::class, 'displayContent'])->name('index');
Route::get('/loginpage', function () {
    return view('login');
})->name('loginpage'); 

Route::get('/listhotel/city{id}', [DisplayContentController::class, 'showHotelOfCity'])->name('showlisthotel');

Route::get('/detailhotel{id}', [DisplayContentController::class, 'showDetailHotel'])->name('showdetailhotel');

Route::post('/loginowner', [OwnerController::class, 'checkOwnerLogin'])->name('ownerlogin');
Route::get('/logoutowner', [OwnerController::class, 'ownerLogout'])->name('ownerlogout');

Route::post('/logincustomer', [CustomerController::class, 'checkCustomerLogin'])->name('customerlogin');
Route::get('/logoutcustomer', [CustomerController::class, 'customerLogout'])->name('customerlogout');







// Route này sẽ yêu cầu người dùng đã đăng nhập trước khi truy cập
Route::middleware([OwnerMiddleware::class])->group(function () {
    Route::get('/mainowner', [OwnerController::class, 'showMainOwner'])->name('mainowner');
    Route::get('/managepaymentinfo', function(){
        return view('owner/mainownercontent/pminfo');
    })->name('paymentinfo');
    Route::get('/managehotel{id}', [OwnerController::class, 'showManageHotel'])->name('managehotel');
    Route::get('/edithotel{id}', [OwnerController::class, 'showEditHotel'])->name('edithotel');
    Route::get('/editroom{rid}/{hid}', [OwnerController::class, 'showEditRoom'])->name('editroom');
    Route::get('managepersonalinfo', function(){
        return view('owner/mainownercontent/personalinfo');
    })->name('personalinfo');
    Route::get('doanhthu', function(){
        return view('owner/mainownercontent/doanhthu');
    })->name('doanhthu');
    Route::get('danhgia', function(){
        return view('owner/mainownercontent/danhgia');
    })->name('danhgia');
});

Route::middleware([CustomerMiddleware::class])->group(function () {
    // Route::get('/giohang', [CartController::class, 'index'])->name('giohang');
    Route::get('/customerinfo', function(){
        return view("customer/customerinfo");
    })->name('customerinfo');
    

});

// Route::post('/check-customer', [OwnerLoginController::class, 'checkKHLogin'])->name('checkKHlogin');

// Route::get('/maincustomer/customer{id}', [OwnerLoginController::class, 'showKHWelcome'])->name('maincustomer');



// Route::get('/infohotel/hotel{id}', [OwnerLoginController::class, 'showInfoHotel'])->name('showinfohotel');



// Route::middleware('auth:owner')->group(function () {
//     Route::get('owner/main/{id}', [OwnerLoginController::class, 'showWelcome'])->name('mainowner');
//     Route::get('owner/edithotel/{id}', [OwnerLoginController::class, 'showEditHotel']);
//     Route::get('owner/managehotel/{hotelId}', [OwnerLoginController::class, 'showManageHotel']);
//     Route::get('owner/editroom/{Rid}', [OwnerLoginController::class, 'showEditRoom']);
// });

// Route::middleware('auth:customer')->group(function () {
//     Route::get('customer/main/{id}', [OwnerLoginController::class, 'showKHWelcome'])->name('maincustomer');
//     Route::get('customer/infohotel/{htId}', [OwnerLoginController::class, 'showInfoHotel']);
// });

// Route::get('/', [OwnerLoginController::class, 'showCity'])->name('index');  // Trang chính cho người chưa đăng nhập
// Route::get('listhotel/{ctId}', [OwnerLoginController::class, 'showHotelOfCity'])->name('showlisthotel');  // Cho cả customer và người chưa đăng nhập
