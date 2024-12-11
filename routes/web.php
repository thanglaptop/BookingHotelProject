<?php

use App\Http\Controllers\CreateDDPController;
use App\Http\Controllers\DisplayContentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ManageEmployeeController;
use App\Http\Controllers\ManageRoomController;
use App\Http\Controllers\ManageHotelController;
use App\Http\Controllers\ManagePaymentInfoController;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Middleware\EmployeeMiddleware;
use App\Http\Middleware\OwnerMiddleware;
use App\Models\Customer;
use App\Models\Employee;

Route::get('/', [DisplayContentController::class, 'displayContent'])->middleware('guest:owner')->name('index');
Route::get('/loginpage', function () {
    return view('login');
})->name('loginpage');
Route::post('/signup', [OwnerController::class, 'dangKy'])->name('signup');
Route::post('/forgetpw', [OwnerController::class, 'ForgetPassword'])->name('forgetpw');
Route::get('/listhotel/city{id}', [DisplayContentController::class, 'showHotelOfCity'])->middleware('guest:owner')->name('showlisthotel');

Route::get('/detailhotel{id}', [DisplayContentController::class, 'showDetailHotel'])->middleware('guest:owner')->name('showdetailhotel');

Route::post('/loginowner', [OwnerController::class, 'checkOwnerLogin'])->name('ownerlogin');
Route::get('/logoutowner', [OwnerController::class, 'ownerLogout'])->name('ownerlogout');
Route::get('/logoutemployee', [OwnerController::class, 'employeeLogout'])->name('employeelogout');
Route::post('/logincustomer', [CustomerController::class, 'checkCustomerLogin'])->name('customerlogin');
Route::get('/logoutcustomer', [CustomerController::class, 'customerLogout'])->name('customerlogout');

Route::get('listhotel', [DisplayContentController::class, 'searchPlace'])->name('searchplace');
Route::get('listhotelfilter', [DisplayContentController::class, 'searchWithFilter'])->name('searchwithfilter');
Route::get('/xemdanhgia{hid}', [DisplayContentController::class, 'showDanhGiaHotel'])->name('seedanhgia');


// Route này sẽ yêu cầu người dùng đã đăng nhập trước khi truy cập
Route::middleware([OwnerMiddleware::class])->group(function () {
    Route::get('/mainowner', [OwnerController::class, 'showMainOwner'])->name('mainowner');
    Route::get('/managepaymentinfo', function(){
        return view('owner/mainownercontent/pminfo');
    })->name('paymentinfo');
    Route::get('/manageemployee', function(){
        return view('owner/mainownercontent/managenv');
    })->name('managenv');
    Route::get('/owner/managehotel{id}/{tab}', [OwnerController::class, 'showManageHotel'])->name('owner.managehotel');
    Route::get('/edithotel{id}', [OwnerController::class, 'showEditHotel'])->name('edithotel');
    Route::get('/editroom{rid}/{hid}', [OwnerController::class, 'showEditRoom'])->name('editroom');
    Route::get('/managepersonalinfo', function(){
        return view('owner/mainownercontent/personalinfo');
    })->name('personalinfo');
    Route::get('/danhgia', [OwnerController::class, 'showDanhGiaForOwner'])->name('danhgia');
    Route::get('/doanhthu', [OwnerController::class, 'showDanhThuPage'])->name('doanhthu');
    Route::get('/owner/createddp{hid}', [OwnerController::class, 'showPageCreateDDP'])->name('owner.taoddp');
    Route::get('/editPM{pmid}', [OwnerController::class, 'showEditPM'])->name('editpm');
    Route::post('/addnewroom', [ManageRoomController::class, 'addRoom'])->name('addroom');
    Route::put('/updateroom{rid}', [ManageRoomController::class, 'updateRoom'])->name('updateroom');
    Route::post('/addnewhotel', [ManageHotelController::class, 'addHotel'])->name('addhotel');
    Route::put('/updatehotel{hid}', [ManageHotelController::class, 'updateHotel'])->name('updatehotel');
    Route::post('/addnewemployee', [ManageEmployeeController::class, 'addEmployee'])->name('addemployee');
    Route::get('/editnv{nvid}', [ManageEmployeeController::class, 'showEditEmployee'])->name('showeditnv');
    Route::put('/updateemployee', [ManageEmployeeController::class, 'updateEmployee'])->name('updatenv');
    Route::put('/updatepasswordemployee', [ManageEmployeeController::class, 'updateEmployeePassword'])->name('updatemknv');
    Route::get('/deleteemployee{eid}', [ManageEmployeeController::class, 'deleteEmployee'])->name('deleteemployee');

    Route::post('/owner/createdetailddp', [CreateDDPController::class, 'taoDDP'])->name('owner.taodetailddp');
    Route::get('owner/detailddp{ddpid}/{hid}', [CreateDDPController::class, 'showDetailDDP'])->name('owner.detailddp');
    Route::put('/owner/updateddp', [CreateDDPController::class, 'updateStatusDDP'])->name('owner.updateddp');
    Route::put('updatepassword', [OwnerController::class, 'changeOwnerPassWord'])->name('changepass');
    
    Route::get('/closehotel{hid}', [ManageHotelController::class, 'showCloseHotel'])->name('showclosehotel');
    Route::put('/updateclosehotel{hid}', [ManageHotelController::class, 'closeHotel'])->name('closehotel');
    Route::put('/updateopenhotel{hid}', [ManageHotelController::class, 'openHotel'])->name('openhotel');

    Route::get('/closeroom{rid}/{hid}', [ManageRoomController::class, 'showCloseRoom'])->name('showcloseroom');
    Route::put('/updatecloseroom{rid}', [ManageRoomController::class, 'closeRoom'])->name('closeroom');
    Route::put('/updateopenroom{rid}', [ManageRoomController::class, 'openRoom'])->name('openroom'); 

    Route::post('/addpaymentinfo', [ManagePaymentInfoController::class, 'addPaymentInfo'])->name('addpaymentinfo');
    Route::put('/updatepaymentinfo', [ManagePaymentInfoController::class, 'updatePaymentInfo'])->name('updatepaymentinfo');
    Route::get('/deletepaymentinfo{pmid}', [ManagePaymentInfoController::class, 'deletePaymentInfo'])->name('deletepaymentinfo');
});
 
Route::middleware([CustomerMiddleware::class])->group(function () {

    Route::get('/customerinfo', function(){
        return view("customer/customerinfo");
    })->name('customerinfo');

    Route::get('cart', function(){
        return view('customer/cart');
    })->name('cart');
    Route::get('/cart', [CustomerController::class, 'showCart'])->name('cart');
    Route::get('/checkout', [CustomerController::class, 'showCheckOut'])->name('checkout');
    Route::get('/checkoutbooknow', [CustomerController::class, 'showBookNow'])->name('booknow');
    Route::post('/createddp', [CreateDDPController::class, 'customerTaoDDP'])->name('customertaoddp');
    Route::post('/addtocart', [CustomerController::class, 'addToCart'])->name('addtocart');
    Route::post('/decreasetocart', [CustomerController::class, 'decreaseQuantityCart'])->name('decreasetocart');
    Route::post('/removefromcart', [CustomerController::class, 'removeFromCart'])->name('removefromcart');
    Route::get('/header', [CustomerController::class, 'refreshHeader'])->name('refreshheader');
    Route::get('/update-customer-info', [CustomerController::class, 'edit'])->name('updatecustomerinfo');
    Route::post('/updateinfo', [CustomerController::class, 'updateCustomerInfo'])->name('updateinfo');
    Route::put('/updatepassword', [CustomerController::class, 'updateCustomerPass'])->name('updatecustomerpass');





    // Route::middleware('auth:customer')->group(function () {
    // }

    Route::get('/dondatphong', [CustomerController::class, 'showDDP'])->name('showddp');
    Route::get('/cancelddp{ddpid}', [CustomerController::class, 'cancelDDP'])->name('cancelddp');
    Route::get('/danhgia{ddpid}', [CustomerController::class, 'showDanhGia'])->name('showdanhgia');
    Route::post('/createdanhgia', [CustomerController::class, 'createDanhGia'])->name('createdanhgia');
});

Route::middleware([EmployeeMiddleware::class])->group(function () {
    Route::get('/employee/managehotel{id}/{tab}', [OwnerController::class, 'showManageHotel'])->name('employee.managehotel');
    Route::get('/employee/createddp{hid}', [OwnerController::class, 'showPageCreateDDP'])->name('employee.taoddp');
    Route::post('/employee/createdetailddp', [CreateDDPController::class, 'taoDDP'])->name('employee.taodetailddp');
    Route::get('/employee/detailddp{ddpid}/{hid}', [CreateDDPController::class, 'showDetailDDP'])->name('employee.detailddp');
    Route::put('/employee/updateddp', [CreateDDPController::class, 'updateStatusDDP'])->name('employee.updateddp');
});
