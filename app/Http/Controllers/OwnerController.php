<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Customer;
use App\Models\Hotel;
use App\Models\Loaihinh;
use App\Models\Owner;
use App\Models\Paymnet_Info;
use App\Models\Room;
use App\Models\Tiennghi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use App\Traits\myHelper;


class OwnerController
{
    use myHelper;

    public function checkOwnerLogin(Request $req)
    {
        $logininfo = $req->only('txtOUsername', 'txtOPass');
        $owner = Owner::where('o_username',  $logininfo['txtOUsername'])->first();
        if ($owner && Hash::check($logininfo['txtOPass'], $owner->o_pass)) {
            
            // Đăng nhập thành công, chuyển hướng tới trang chủ
            Auth::guard('owner')->login($owner);
            return redirect()->route('mainowner');
        }
        return back()->withErrors(['message' => 'Đăng nhập thất bại!']);
    }

    public function ownerLogout()
    {
        Auth::guard('owner')->logout();
        session()->flush();  // Clear the session
        return redirect()->route('index');
    }

    public function showMainOwner()
    {
        $cities = City::all();
        $loaihinhs = Loaihinh::all();
        $tiennghihotel = Tiennghi::all()->where('tn_ofhotel', 1);
        $hotelpminfo = Paymnet_Info::all()->where('o_id', $this->ownerId());

        return view('owner/mainowner', [
            'tiennghihotel' => $tiennghihotel,
            'cities' => $cities,
            'loaihinhs' => $loaihinhs,
            'hotelpminfo' => $hotelpminfo
        ]);
    }

    public function showManageHotel($id)
    {
        //owner chỉ có thể truy cập ks của mình không truy cập ks của người khác thông qua url
        $hotel = Hotel::where('h_id', $id)->where('o_id', $this->ownerId())->firstOrFail();
        $listtiennghi = Tiennghi::all()->where('tn_ofhotel', 0);
        return view('owner/managehotel', ['hotel' => $hotel, 'listtiennghi' => $listtiennghi]);
    }

    

    public function showEditHotel($id)
    {
        //owner chỉ có thể truy cập ks của mình không truy cập ks của người khác thông qua url
        $hotel = Hotel::where('h_id', $id)->where('o_id', $this->ownerId())->firstOrFail();
        $cities = City::all();
        $loaihinhs = Loaihinh::all();
        $tiennghihotel = Tiennghi::all()->where('tn_ofhotel', 1);
        $hotelpminfo = Paymnet_Info::all()->where('o_id', $hotel->o_id);
        // Truyền dữ liệu owner sang view 'welcome'
        return view('owner/edithotel', [
            'hotel' => $hotel,
            'cities' => $cities,
            'loaihinhs' => $loaihinhs,
            'tiennghihotel' => $tiennghihotel,
            'hotelpminfo' => $hotelpminfo
        ]);
    }

    public function showEditRoom($rid, $hid)
    {
        //trả về phòng thuộc khách sạn thuộc owner đang đăng nhập
        $room = Room::where('r_id', $rid)->where('h_id', $this->hotelOfOwner($hid))->firstOrFail();
        $tiennghiroom = Tiennghi::all()->where('tn_ofhotel', 0);
        // Truyền dữ liệu owner sang view 'welcome'
        return view('owner/managehotelcontent/editroom', ['room' => $room, 'tiennghiroom' => $tiennghiroom]);
    }

    public function showPaymentInfo(){
        
    }


    // public function checkLogin(Request $request){
    //     $owner_username = $request->input('txtOUsername');
    //     $owner_pass = $request->input('txtOPass');
    //     $owner = Owner::where('o_username', $owner_username)->where('o_pass', $owner_pass)->first();
    //     if($owner){
    //         return redirect()->route('mainowner', ['id' => $owner->o_id]);
    //     } else return back()->withErrors(['message' => 'Người dùng không tồn tại trong hệ thống.']);
    // }

    // public function checkKHLogin(Request $request){
    //     $cus_username = $request->input('txtCUsername');
    //     $cus_pass = $request->input('txtCPass');
    //     $customer = Customer::where('c_username', $cus_username)->where('c_pass', $cus_pass)->first();
    //     if($customer){
    //         return redirect()->route('maincustomer', ['id' => $customer->c_id]);
    //     } else return back()->withErrors(['message' => 'Người dùng không tồn tại trong hệ thống.']);
    // }



    // public function showKHWelcome($cid)
    // {
    //     // Lấy thông tin owner dựa trên ID
    //     $customer = Customer::findOrFail($cid);
    //     $cities =  City::has('hotels')->withCount('hotels')->get();
    //     $room = Room::all();
    //     return view('index',['customer' => $customer,'cities'=> $cities, 'room' => $room]);
    // }









    // public function showInfoHotel($htId){
    //     $hotel = Hotel::findOrFail($htId);
    //     return view('customer/infohotel', ['hotel' => $hotel]);
    // }


}
