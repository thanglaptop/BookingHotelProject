<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Customer;
use App\Models\Hotel;
use App\Models\Loaihinh;
use App\Models\Owner;
use App\Models\Paymnet_Info;
use App\Models\Room;
use App\Models\Room_Img;
use App\Models\Tiennghi;
use Illuminate\Http\Request;

class OwnerLoginController extends Controller
{
    public function showCity(){
        $cities =  City::has('hotels')->withCount('hotels')->get();
        return view('index',['cities'=> $cities]);
    }
    public function checkLogin(Request $request){
        $owner_username = $request->input('txtOUsername');
        $owner_pass = $request->input('txtOPass');
        $owner = Owner::where('o_username', $owner_username)->where('o_pass', $owner_pass)->first();
        if($owner){
            return redirect()->route('mainowner', ['id' => $owner->o_id]);
        } else return back()->withErrors(['message' => 'Người dùng không tồn tại trong hệ thống.']);
    }

    public function checkKHLogin(Request $request){
        $cus_username = $request->input('txtCUsername');
        $cus_pass = $request->input('txtCPass');
        $customer = Customer::where('c_username', $cus_username)->where('c_pass', $cus_pass)->first();
        if($customer){
            return redirect()->route('maincustomer', ['id' => $customer->c_id]);
        } else return back()->withErrors(['message' => 'Người dùng không tồn tại trong hệ thống.']);
    }

    public function showWelcome($id)
    {
        // Lấy thông tin owner dựa trên ID
        $owner = Owner::findOrFail($id);
        $cities = City::all();
        $loaihinhs = Loaihinh::all();
        $tiennghihotel = Tiennghi::all()->where('tn_ofhotel', 1);
        $hotelpminfo = Paymnet_Info::all()->where('o_id', $id);
        // Truyền dữ liệu owner sang view 'welcome'
        return view('owner/mainowner', ['owner' => $owner, 'tiennghihotel' => $tiennghihotel,'cities' => $cities, 
        'loaihinhs' => $loaihinhs, 'hotelpminfo' => $hotelpminfo]);
    }

    public function showKHWelcome($id)
    {
        // Lấy thông tin owner dựa trên ID
        $customer = Customer::findOrFail($id);
        $cityHasHotels = City::has('hotels')->withCount('hotels')->get();
        $loaihinhs = Loaihinh::all();
        // Truyền dữ liệu owner sang view 'welcome'
        return view('customer/maincustomer', ['customer' => $customer,'cityHasHotels' => $cityHasHotels, 
        'loaihinhs' => $loaihinhs]);
    }

    public function showEditHotel($id)
    {
        // Lấy thông tin owner dựa trên ID
        $hotel = Hotel::findOrFail($id);
        $cities = City::all();
        $loaihinhs = Loaihinh::all();
        $tiennghihotel = Tiennghi::all()->where('tn_ofhotel', 1);
        $hotelpminfo = Paymnet_Info::all()->where('o_id', $hotel->o_id);
        // Truyền dữ liệu owner sang view 'welcome'
        return view('owner/edithotel', ['hotel' => $hotel, 'cities' => $cities, 'loaihinhs' => $loaihinhs,
                                        'tiennghihotel' => $tiennghihotel, 'hotelpminfo' => $hotelpminfo]);
    }

    public function showManageHotel($hotelId){
        $hotel = Hotel::findOrFail($hotelId);
        $listtiennghi = Tiennghi::all()->where('tn_ofhotel', 0);
        return view('owner/managehotel', ['hotel' => $hotel, 'listtiennghi' => $listtiennghi]);
    }

    public function showEditRoom($Rid)
    {
        // Lấy thông tin owner dựa trên ID
        $room = Room::findOrFail($Rid);
        $tiennghiroom = Tiennghi::all()->where('tn_ofhotel', 0);
        // Truyền dữ liệu owner sang view 'welcome'
        return view('owner/managehotelcontent/editroom', ['room' => $room, 'tiennghiroom' => $tiennghiroom]);
    }

    public function showHotelOfCity($ctId){
        $hotels = Hotel::all()->where('ct_id', $ctId);
        return view('customer/listhotel', ['hotels' => $hotels]);
    }

    public function showInfoHotel($htId){
        $hotel = Hotel::findOrFail($htId);
        return view('customer/infohotel', ['hotel' => $hotel]);
    }
}
