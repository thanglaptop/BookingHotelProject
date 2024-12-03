<?php

use App\Http\Controllers\CreateDDPController;
use App\Http\Controllers\DisplayContentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ManageEmployeeController;
use App\Http\Controllers\ManageRoomController;
use App\Http\Controllers\ManageHotelController;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Middleware\EmployeeMiddleware;
use App\Http\Middleware\OwnerMiddleware;
use App\Models\Customer;
use App\Models\Employee;

Route::get('/', [DisplayContentController::class, 'displayContent'])->name('index');
Route::get('/loginpage', function () {
    return view('login');
})->name('loginpage');
Route::post('/signup', [OwnerController::class, 'dangKy'])->name('signup');
Route::post('/forgetpw', [OwnerController::class, 'ForgetPassword'])->name('forgetpw');
Route::get('/listhotel/city{id}', [DisplayContentController::class, 'showHotelOfCity'])->name('showlisthotel');

Route::get('/detailhotel{id}', [DisplayContentController::class, 'showDetailHotel'])->name('showdetailhotel');

Route::post('/loginowner', [OwnerController::class, 'checkOwnerLogin'])->name('ownerlogin');
Route::get('/logoutowner', [OwnerController::class, 'ownerLogout'])->name('ownerlogout');
Route::get('/logoutemployee', [OwnerController::class, 'employeeLogout'])->name('employeelogout');
Route::post('/logincustomer', [CustomerController::class, 'checkCustomerLogin'])->name('customerlogin');
Route::get('/logoutcustomer', [CustomerController::class, 'customerLogout'])->name('customerlogout');







// Route này sẽ yêu cầu người dùng đã đăng nhập trước khi truy cập
Route::middleware([OwnerMiddleware::class])->group(function () {
    Route::get('/mainowner', [OwnerController::class, 'showMainOwner'])->name('mainowner');
    Route::get('/managepaymentinfo', function(){
        return view('owner/mainownercontent/pminfo');
    })->name('paymentinfo');
    Route::get('/manageemployee', function(){
        return view('owner/mainownercontent/managenv');
    })->name('managenv');
    Route::get('/owner/managehotel{id}/{daystart}/{dayend}', [OwnerController::class, 'showManageHotel'])->name('owner.managehotel');
    Route::get('/edithotel{id}', [OwnerController::class, 'showEditHotel'])->name('edithotel');
    Route::get('/owner/editroom{rid}/{hid}', [OwnerController::class, 'showEditRoom'])->name('owner.editroom');
    Route::get('/managepersonalinfo', function(){
        return view('owner/mainownercontent/personalinfo');
    })->name('personalinfo');
    Route::get('/doanhthu', function(){
        return view('owner/mainownercontent/doanhthu');
    })->name('doanhthu');
    Route::get('/danhgia', function(){
        return view('owner/mainownercontent/danhgia');
    })->name('danhgia');
    // Route::get('/owner/createddp{hid}', [OwnerController::class, 'showPageCreateDDP'])->name('owner.taoddp');


    Route::get('/owner/createddp{hid}', [OwnerController::class, 'showPageCreateDDP'])->name('owner.taoddp');


    Route::get('editPM{pmid}', [OwnerController::class, 'showEditPM'])->name('editpm');
    Route::post('/addnewroom', [ManageRoomController::class, 'addRoom'])->name('addroom');
    Route::put('/updateroom{rid}', [ManageRoomController::class, 'updateRoom'])->name('updateroom');
    Route::post('/addnewhotel', [ManageHotelController::class, 'addHotel'])->name('addhotel');
    Route::put('/updatehotel{hid}', [ManageHotelController::class, 'updateHotel'])->name('updatehotel');
    Route::post('/addnewemployee', [ManageEmployeeController::class, 'addEmployee'])->name('addemployee');
    Route::get('/editnv{nvid}', [ManageEmployeeController::class, 'showEditEmployee'])->name('showeditnv');
    Route::put('/updateemployee', [ManageEmployeeController::class, 'updateEmployee'])->name('updatenv');
    Route::put('/updatepasswordemployee', [ManageEmployeeController::class, 'updateEmployeePassword'])->name('updatemknv');
    Route::post('createddp', [CreateDDPController::class, 'taoDDP'])->name('taoddp');

    Route::get('owner/detailddp{ddpid}/{hid}', [CreateDDPController::class, 'showDetailDDP'])->name('owner.detailddp');

    Route::put('/updateddp', [CreateDDPController::class, 'updateStatusDDP'])->name('updateddp');
});

Route::middleware([CustomerMiddleware::class])->group(function () {

    Route::get('/customerinfo', function(){
        return view("customer/customerinfo");
    })->name('customerinfo');

    Route::get('cart', function(){
        return view('customer/cart');
    })->name('cart');
    Route::post('/addtocart', [CustomerController::class, 'addToCart'])->name('addtocart');
    Route::get('/header', [CustomerController::class, 'refreshHeader'])->name('refreshheader');
    Route::get('/update-customer-info', [CustomerController::class, 'edit'])->name('updatecustomerinfo');





    // Route::middleware('auth:customer')->group(function () {
    // }

});

Route::middleware([EmployeeMiddleware::class])->group(function () {
    Route::get('/employee/managehotel{id}/{daystart}/{dayend}', [OwnerController::class, 'showManageHotel'])->name('employee.managehotel');
    Route::get('/employee/editroom{rid}/{hid}', [OwnerController::class, 'showEditRoom'])->name('employee.editroom');
    Route::get('/employee/createddp{hid}', [OwnerController::class, 'showPageCreateDDP'])->name('employee.taoddp');

    Route::get('employee/detailddp{ddpid}/{hid}', [CreateDDPController::class, 'showDetailDDP'])->name('employee.detailddp');
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
