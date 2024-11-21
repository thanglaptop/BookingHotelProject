<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController
{
    public function checkCustomerLogin(Request $req)
    {
        $logininfo = $req->only('txtCUsername', 'txtCPass');
        $customer = Customer::where('c_username',  $logininfo['txtCUsername'])->first();
        if ($customer && Hash::check($logininfo['txtCPass'], $customer->c_pass)) {

            // Đăng nhập thành công, chuyển hướng tới trang chủ
            Auth::guard('customer')->login($customer);
            return redirect()->route('index');
        }
        return back()->withErrors(['message' => 'Đăng nhập thất bại!']);
    }

    public function customerLogout()
    {
        Auth::guard('customer')->logout();
        session()->flush();  // Clear the session
        return redirect()->route('index');
    }

//Hàm lấy thông tin khách hàng
    public function edit()
    {
        $customer = Auth::guard('customer')->user(); // Lấy thông tin khách hàng đang đăng nhập
        return view('customer.updatecustomerinfo', compact('customer'));
    }
}
