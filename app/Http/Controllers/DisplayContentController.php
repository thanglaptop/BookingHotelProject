<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Danhgia;
use App\Models\Hotel;
use App\Models\Room;
use App\Traits\myHelper;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DisplayContentController
{
    use myHelper;
    public function displayContent(Request $request)
    {
        $cities =  City::has('hotels')->withCount('hotels')->get();
        $room = Room::all();

        return view('index', ['cities' => $cities, 'room' => $room]);
    }

    public function showHotelOfCity($id, Request $request)
    {
        $city = City::findOrFail($id);
        $hotels = Hotel::all()->where('ct_id', $id);
        $listhotelid = "";
        foreach ($hotels as $hotel) {
            $listhotelid .= $hotel->h_id . ","; // Ghép từng h_id và thêm dấu phẩy
        }
        // Loại bỏ dấu phẩy cuối cùng nếu cần
        $listhotelid = rtrim($listhotelid, ",");
        $room = Room::all();
        $forecast = $this->getWeatherForecast($city->ct_name, date('Y-m-d'), date('Y-m-d', strtotime('+1 day')));
        // Chỉ lưu URL nếu chưa tồn tại
        session(['previous_listhotel' => $request->fullUrl()]);
        return view('listhotel', ['city' => $city, 'hotels' => $hotels, 'room' => $room, 'forecast' => $forecast, 'listhotelid' => $listhotelid]);
    }

    public function showDetailHotel($id, Request $request)
    {
        $keyword = $request->input('search');
        $checkin = $request->input('checkin') ?? date('Y-m-d');
        $checkout = $request->input('checkout') ?? date('Y-m-d', strtotime('+1 day'));
        if ($checkout <= $checkin) {
            return back();
        }
        $slphong = $request->input('room') ?? 1;
        $adult = $request->input('adult') ?? 2;
        $kid = $request->input('kid') ?? 0;
        $hotel = Hotel::findOrFail($id);
        $listroom = $this->returnListRoomWithRemainQuantity($hotel->h_id, $checkin, $checkout);

        // Chỉ lưu URL nếu chưa tồn tại
        session(['previous_detailhotel' => $request->fullUrl()]);
        return view('detailhotel', [
            'hotel' => $hotel,
            'listroom' => $listroom,
            'keyword' => $keyword,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'slphong' => $slphong,
            'sladult' => $adult,
            'slkid' => $kid
        ]);
    }

    public function searchPlace(Request $request)
    {
        $keyword = $request->input('search');
        if (empty(trim($keyword))) {
            return redirect()->back()->with('error', 'không được bỏ trống ô tìm kiếm');
        }

        $checkin = $request->input('checkin') ?? date('Y-m-d');
        $checkout = $request->input('checkout') ?? date('Y-m-d', strtotime('+1 day'));
        $slphong = $request->input('room');
        $adult = $request->input('adult');
        $kid = $request->input('kid');

        if ($checkout <= $checkin) {
            return back();
        }
        $listhotelid = "";
        $listhotel = $this->returnListHotelResult($keyword, $checkin, $checkout, $slphong, $adult, $kid);
        if (!empty($listhotel)) {
            foreach ($listhotel as $hotel) {
                $listhotelid .= $hotel->h_id . ","; // Ghép từng h_id và thêm dấu phẩy
            }
            // Loại bỏ dấu phẩy cuối cùng nếu cần
            $listhotelid = rtrim($listhotelid, ",");
        }
        $cityname = $listhotel->first()->city->ct_name ?? null;
        if ($cityname != null) {
            $forecast = $this->getWeatherForecast($cityname, $checkin, $checkout);
        } else {
            $forecast = null;
        }
        session(['previous_url' => $request->fullUrl()]);
        return view('listhotel', [
            'hotels' => $listhotel,
            'keyword' => $keyword,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'slphong' => $slphong,
            'sladult' => $adult,
            'slkid' => $kid,
            'forecast' => $forecast,
            'listhotelid' => $listhotelid
        ]);
    }

    public function searchWithFilter(Request $request)
    {
        $keyword = $request->input('search');
        $listhotelma = $request->input('listhotelid');

        if (empty(trim($keyword))) {
            return redirect()->back()->with('error', 'không được bỏ trống ô tìm kiếm');
        }

        $checkin = $request->input('checkin');
        $checkout = $request->input('checkout');
        $slphong = $request->input('room');
        $adult = $request->input('adult');
        $kid = $request->input('kid');
        $priceFilter = $request->input('price');
        $rateFilter = $request->input('rate');

        if ($checkout <= $checkin) {
            return back();
        }

        $listhotel = $this->filterHotel($listhotelma, $priceFilter, $rateFilter);
        $cityname = $listhotel->first()->city->ct_name ?? null;
        if ($cityname != null) {
            $forecast = $this->getWeatherForecast($cityname, $checkin, $checkout);
        } else {
            $forecast = null;
        }
        session(['previous_url' => $request->fullUrl()]);
        // Trả về view với danh sách đã lọc
        return view('listhotel', [
            'hotels' => $listhotel,
            'keyword' => $keyword,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'slphong' => $slphong,
            'sladult' => $adult,
            'slkid' => $kid,
            'forecast' => $forecast,
            'priceFilter' => $priceFilter,
            'rateFilter' => $rateFilter,
            'listhotelid' => $listhotelma
        ]);
    }

    public function showDanhGiaHotel($hid)
    {
        $listdanhgia = Danhgia::whereHas('detail_ddp.dondatphong.hotel', function ($query) use ($hid) {
            $query->where('h_id', $hid);
        })->get();
        $hotel = Hotel::firstWhere('h_id', $hid);
        return view('xemdanhgia', ['hotel' => $hotel, 'listdanhgia' => $listdanhgia]);
    }

    public function dangKy(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string||min:3|max:30',
            'sdt' => 'required|string|regex:/^0[0-9]{9}$/',
            'email' => 'required|email',
            'birthday' => 'required|date',
            'username' => 'required|string|min:15|max:30',
            'password' => 'required|string|min:8|max:20',
        ]);


        // Kiểm tra xem username đã tồn tại hay chưa
        $existingCus = Customer::where('c_username', $validated['username'])->first();
        if ($existingCus) {
            return redirect()->back()
                ->with('error', 'Tên đăng nhập đã tồn tại trong hệ thống!');
        }

        $existingEmail = Customer::where('c_email', $validated['email'])->first();
        if ($existingEmail) {
            return redirect()->back()
                ->with('error', 'Email đã tồn tại trong hệ thống!');
        }

        // Lưu người dùng vào cơ sở dữ liệu
        $customer = Customer::create([
            'c_name' => $validated['fullname'],
            'c_sdt' => $validated['sdt'],
            'c_email' => $validated['email'],
            'c_nsinh' => $validated['birthday'],
            'c_username' => $validated['username'],
            'c_pass' => Hash::make($validated['password']),
        ]);

        Auth::guard('customer')->login($customer);
        return redirect()->route('index')->with('success', 'Đăng ký thành công!');
    }

    public function ForgetPassword(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
        ]);
        // Kiểm tra email có tồn tại không
        $customer = Customer::where('c_username', $request->username)->where('c_email', $request->email)->first();
        $owner = Owner::where('o_username', $request->username)->where('o_email', $request->email)->first();
        if ($customer) {
            $newPassword = Str::random(10);

            Customer::where('c_id', $customer->c_id)->update([
                'c_pass' => Hash::make($newPassword)
            ]);
            $name = $customer->c_name;
            // Gửi email
            Mail::send('tablogin/reset_password', ['name' => $name, 'newPassword' => $newPassword], function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Khôi phục mật khẩu khách hàng');
            });

            return back()->with('success', 'Mật khẩu mới đã được gửi đến email của bạn!');
        } else if ($owner) {
            $newPassword = Str::random(10);
            Owner::where('o_id', $owner->o_id)->update([
                'o_pass' => Hash::make($newPassword)
            ]);
            $name = $owner->o_name;
            // Gửi email
            Mail::send('tablogin/reset_password', ['name' => $name, 'newPassword' => $newPassword], function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Khôi phục mật khẩu chủ khách sạn');
            });

            return back()->with('success', 'Mật khẩu mới đã được gửi đến email của bạn!');
        }
        return back()->with('error', 'Tên đăng nhập hoặc email không tồn tại trong hệ thống');
    }
}
