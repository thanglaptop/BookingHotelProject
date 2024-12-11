<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Danhgia;
use App\Models\Detail_Ddp;
use App\Models\Dondatphong;
use App\Models\Giohang;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\myHelper;
use Hamcrest\Type\IsNumeric;

class CustomerController
{

    use myHelper;
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
        $checkin = $req->input('checkin');
        $checkout = $req->input('checkout');
        $conlai = $req->input('conlai');
        $customerID = Auth::guard('customer')->user()->c_id;

        $cart = Giohang::where('C_ID', $customerID)->where('R_ID', $roomID)->where('g_checkin', $checkin)->where('g_checkout', $checkout)->first();

        //cập nhật nếu có
        if ($cart && $cart->g_soluong >= $conlai) {
            $cartCount = Giohang::where('C_ID', $customerID)->count();
            return response()->json([
                'message' => 'đã thêm hết số phòng còn lại',
                'cartCount' => $cartCount,
                'error' => true,
            ]);
        } else if ($cart && $cart->g_soluong < $conlai) {
            Giohang::where('C_ID', $customerID)->where('R_ID', $roomID)->where('g_checkin', $checkin)->where('g_checkout', $checkout)->increment('g_soluong');
            $cartCount = Giohang::where('C_ID', $customerID)->count();
            // Lấy lại bản ghi vừa được cập nhật
            $updatedCart = Giohang::where('C_ID', $customerID)
                ->where('R_ID', $roomID)
                ->where('g_checkin', $checkin)->where('g_checkout', $checkout)->first();
            $newquantiy = $updatedCart->g_soluong;
            // dd($newquantiy);
            return response()->json([
                'message' => 'Cập nhật số lượng phòng thành công',
                'cartCount' => $cartCount,  // Trả về số lượng giỏ hàng sau khi cập nhật
                'newquantity' => $newquantiy
            ]);
            //thêm nếu không có
        } else {
            Giohang::create(['C_ID' => $customerID, 'R_ID' => $roomID, 'g_checkin' => $checkin, 'g_checkout' => $checkout, 'g_soluong' => 1]);
            $cartCount = Giohang::where('C_ID', $customerID)->count();
            return response()->json([
                'message' => 'Thêm phòng vào giỏ hàng thành công',
                'cartCount' => $cartCount  // Trả về số lượng giỏ hàng sau khi thêm mới
            ]);
        }
    }

    public function decreaseQuantityCart(Request $req)
    {
        $roomID = $req->input('room_id');
        $customerID = Auth::guard('customer')->user()->c_id;
        $checkin = $req->input('checkin');
        $checkout = $req->input('checkout');
        $cart = Giohang::where('C_ID', $customerID)->where('R_ID', $roomID)->where('g_checkin', $checkin)->where('g_checkout', $checkout)->first();
        //cập nhật nếu có
        if ($cart) {
            if ($cart->g_soluong > 1) {
                // Giảm số lượng
                Giohang::where('C_ID', $customerID)->where('R_ID', $roomID)->where('g_checkin', $checkin)->where('g_checkout', $checkout)->decrement('g_soluong');
            }
            // Lấy lại bản ghi vừa được cập nhật
            $updatedCart = Giohang::where('C_ID', $customerID)
                ->where('R_ID', $roomID)
                ->where('g_checkin', $checkin)->where('g_checkout', $checkout)->first();
            $newquantiy = $updatedCart->g_soluong;
            // dd($newquantiy);
            return response()->json([
                'message' => 'Cập nhật số lượng phòng thành công',
                'newquantity' => $newquantiy
            ]);
            //thêm nếu không có
        }
    }

    public function removeFromCart(Request $req)
    {
        $roomID = $req->input('room_id');
        $customerID = Auth::guard('customer')->user()->c_id;
        $checkin = $req->input('checkin');
        $checkout = $req->input('checkout');
        $cart = Giohang::where('C_ID', $customerID)->where('R_ID', $roomID)->where('g_checkin', $checkin)->where('g_checkout', $checkout)->first();
        $cartCount = Giohang::where('C_ID', $customerID)->count();
        //cập nhật nếu có
        if ($cart) {
            Giohang::where('C_ID', $customerID)->where('R_ID', $roomID)->where('g_checkin', $checkin)->where('g_checkout', $checkout)->delete();

            // dd($newquantiy);
            return response()->json([
                'message' => 'Xóa phòng khỏi giỏ hàng thành công',
                'cartCount' => $cartCount,
            ]);
        }
    }

    public function showCart(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $listroom = $customer->hasManyRoomInGiohang;

        $listroomwithremain = collect();
        $listhotel = [];
        $processedKeys = []; // Mảng để theo dõi các cặp `hotel_id` và `keyday` đã xử lý
        $listcheckin = [];
        $listcheckout = [];

        for ($i = 0; $i < count($listroom); $i++) {
            $hotelId = $listroom[$i]['hotel']['h_id'];
            $hotel = $listroom[$i]['hotel'];
            $checkin = date('Y-m-d', strtotime($listroom[$i]->pivot->g_checkin));
            $checkout = date('Y-m-d', strtotime($listroom[$i]->pivot->g_checkout));
            $keyday = $checkin . ' to ' . $checkout;

            // Thêm khách sạn vào danh sách nếu chưa có
            if (!in_array($hotel, $listhotel)) {
                $listhotel[] = $listroom[$i]['hotel'];
            }

            // Thêm vào listroomwithremain nếu key chưa được xử lý
            $keyCombination = $hotelId . '_' . $keyday; // Tạo khóa duy nhất từ hotel_id và keyday
            if (!in_array($keyCombination, $processedKeys)) {
                $processedKeys[] = $keyCombination; // Đánh dấu đã xử lý
                $listcheckin[] = $checkin;
                $listcheckout[] = $checkout;
                $listroomwithremain = $listroomwithremain->merge(
                    $this->returnListRoomWithRemainQuantity($hotelId, $checkin, $checkout)
                );
            }
        }
        session(['previous_detailhotel' => $request->fullUrl()]);
        // Truyền dữ liệu qua view
        return view('customer/cart', [
            'listroom' => $listroom,
            'listhotel' => $listhotel,
            'listroomwithremain' => $listroomwithremain,
            'listcheckin' => $listcheckin,
            'listcheckout' => $listcheckout,
        ]);
    }


    public function showCheckOut(Request $request)
    {
        $listhotelincart = $request->input('listhotel');
        if (empty($listhotelincart)) {
            return redirect()->back()->with('error', 'bạn chưa chọn phòng để đặt');
        }
        $listhotelcheckout = [];
        foreach ($listhotelincart as $hotel) {
            $listhotelcheckout[] = explode(',', $hotel);
        }
        foreach ($listhotelcheckout as $checkout) {
            if ($checkout[1] <= $checkout[0]) {
                return back();
            }
        }
        $listhotel = [];
        for ($i = 0; $i < count($listhotelcheckout); $i++) {
            $listhotel[] = $listhotelcheckout[$i][2];
        }
        $listroom =  Auth::guard('customer')->user()->hasManyRoomInGiohang;
        $listroomcheckout = [];
        foreach ($listroom as $room) {
            if (in_array($room->h_id, $listhotel)) {
                $listroomcheckout[] = $room;
            }
        }
        $hotels = Hotel::all();
        return view('customer/checkout', ['listroom' => $listroomcheckout, 'listhotel' => $listhotelcheckout, 'hotels' => $hotels]);
    }

    public function showBookNow(Request $request){
        $hotel = Hotel::firstWhere('h_id', $request->input('hotel'));
        $room = Room::firstWhere('r_id', $request->input('room'));
        $checkin = $request->input('checkin');
        $checkout = $request->input('checkout');
        $booknow = true;
        return view('customer/checkout', ['hotel' => $hotel, 'room' => $room, 'checkin' => $checkin, 'checkout' => $checkout, 'booknow' => $booknow]);
    }

    public function showDDP(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $listddp = $customer->dondatphongs;

        $listhotel = [];
        foreach ($listddp as $ddp) {
            $hotel = Hotel::firstWhere('h_id', $ddp->h_id);
            if (!in_array($hotel, $listhotel)) {
                $listhotel[] = $hotel;
            }
        }
        // Lưu URL hiện tại vào session
        session(['previous_url' => $request->fullUrl()]);
        return view('customer/dondatphong', ['listddp' => $listddp, 'listhotel' => $listhotel]);
    }

    public function cancelDDP($ddpid)
    {
        Dondatphong::where('ddp_id', $ddpid)->update([
            'ddp_status' => 'canceled'
        ]);
        return redirect()->route('showddp')->with('success', 'Hủy đơn đặt phòng thành công');
    }

    public function showDanhGia($ddpid)
    {
        $ddp = Dondatphong::firstWhere('ddp_id', $ddpid);
        return view('customer/danhgia', ['ddp' => $ddp]);
    }

    public function createDanhGia(Request $request)
    {
        $listdetailid = $request->input('listdetailid');
        $listsao = $request->input('listsao');
        $listnhanxet = $request->input('listnhanxet');

        foreach ($listnhanxet as $nhanxet) {
            if (strlen($nhanxet) > 400) {
                return redirect()->back()->with('error', 'nhận xét không được vượt quá 400 ký tự!');
            }
        }
        $customerID = Auth::guard('customer')->user()->c_id;
        for ($i = 0; $i < count($listdetailid); $i++) {
            $nhanxet = !empty(trim($listnhanxet[$i])) ? trim($listnhanxet[$i]) : 'Khách hàng không để lại đánh giá';
            Danhgia::create([
                'dg_star' => $listsao[$i],
                'dg_nhanxet' => $nhanxet,
                'dg_ngaydg' => date('Y-m-d'),
                'c_id' => $customerID,
                'detail_id' => $listdetailid[$i], 
            ]);
        }
        $detail = Detail_Ddp::firstWhere('detail_id', $listdetailid[0]);
        $hotelId = $detail->dondatphong->hotel->h_id;
        Dondatphong::where('ddp_id', $detail->ddp_id)->update(['ddp_status' => 'rated']);
        return redirect()->route('seedanhgia', ['hid' => $hotelId])->with('success', 'Đánh giá thành công!');
    }

    public function edit()
    {
        $customer = Auth::guard('customer')->user(); // Lấy thông tin khách hàng đang đăng nhập
        return view('customer.updatecustomerinfo', compact('customer'));
    }

    public function updateCustomerInfo(Request $request){
        $name = trim($request->input('name'));
        $email = trim($request->input('email'));
        $phone = trim($request->input('phone'));
        $ngaysinh = $request->input('ngaysinh');
        $passwordconfirm = $request->input('password');

        if(strlen($name) < 3 || strlen($name) > 30){
            return back()->with('error', 'tên phải từ 3 - 50 ký tự');
        }
        if(!is_numeric($phone) || strlen($phone) < 10 || strlen($phone) >10){
            return back()->with('error', 'số điện thoại không hợp lệ');
        }
        $customer = Auth::guard('customer')->user();
        if(!Hash::check($passwordconfirm, $customer->c_pass)){
            return back()->with('error', 'mật khẩu xác nhận không chính xác');
        }
        $existEmail = Customer::where('c_email', '!=',$customer->c_email)->where('c_email', $email)->exists();
        if($existEmail){
            return back()->with('error', 'email đã tồn tại');
        }
        Customer::where('c_id', $customer->c_id)->update([
            'c_name' => $name,
            'c_email' => $email,
            'c_sdt' => $phone,
            'c_nsinh' => $ngaysinh
        ]);
        return back()->with('success', 'cập nhật thông tin thành công');
    }

    public function updateCustomerPass(Request $request){
        $oldpass = $request->input('oldpass');
        $newpass = $request->input('newpass');
        $retypepass = $request->input('newpass2');
        $customer = Auth::guard('customer')->user();
        if(!Hash::check($oldpass, $customer->c_pass)){
            return back()->with('error', 'mật khẩu cũ không chính xác');
        }
        if($retypepass != $newpass){
            return back()->with('error', 'mật khẩu nhập lại không chính xác');
        }

        Customer::where('c_id', $customer->c_id)->update([
            'c_pass' => Hash::make($retypepass)
        ]);
        return back()->with('success', 'cập nhật mật khẩu thành công');
    }
}