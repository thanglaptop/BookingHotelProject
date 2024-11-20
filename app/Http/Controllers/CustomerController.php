<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Giohang;
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

    public function addToCart(Request $req)
    {
        $roomID = $req->input('room_id');
        $customerID = Auth::guard('customer')->user()->c_id;

        $cart = Giohang::where('C_ID', $customerID)->where('R_ID', $roomID)->first();

        //cập nhật nếu có
        if ($cart) {
            Giohang::where('C_ID', $customerID)->where('R_ID', $roomID)->update(['g_soluong' => $cart->g_soluong += 1]);
            $cartCount = Giohang::where('C_ID', $customerID)->count();
            return response()->json([
                'message' => 'Cập nhật số lượng phòng thành công',
                'cartCount' => $cartCount  // Trả về số lượng giỏ hàng sau khi cập nhật
            ]);
            //thêm nếu không có
        } else {
            Giohang::create(['C_ID' => $customerID, 'R_ID' => $roomID, 'g_checkin' => date('Y-m-d'), 'g_checkout' => date('Y-m-d'), 'g_soluong' => 1]);
            $cartCount = Giohang::where('C_ID', $customerID)->count();
            return response()->json([
                'message' => 'Thêm phòng vào giỏ hàng thành công',
                'cartCount' => $cartCount  // Trả về số lượng giỏ hàng sau khi thêm mới
            ]);
        }
    }
}
