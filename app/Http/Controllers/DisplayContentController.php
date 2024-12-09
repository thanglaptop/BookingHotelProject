<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Danhgia;
use App\Models\Hotel;
use App\Models\Room;
use App\Traits\myHelper;
use Illuminate\Http\Request;

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
        $room = Room::all();
        $forecast = $this->getWeatherForecast($city->ct_name, date('Y-m-d'), date('Y-m-d', strtotime('+1 day')));
        // Chỉ lưu URL nếu chưa tồn tại
            session(['previous_listhotel' => $request->fullUrl()]);
        return view('listhotel', ['city' => $city, 'hotels' => $hotels, 'room' => $room, 'forecast' => $forecast]);
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
        $listhotel = $this->returnListHotelResult($keyword, $checkin, $checkout, $slphong, $adult, $kid);
        $cityname = $listhotel->first()->city->ct_name;
        $forecast = $this->getWeatherForecast($cityname, $checkin, $checkout);
        session(['previous_url' => $request->fullUrl()]);
        return view('listhotel', [
            'hotels' => $listhotel,
            'keyword' => $keyword,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'slphong' => $slphong,
            'sladult' => $adult,
            'slkid' => $kid,
            'forecast' => $forecast
        ]);
    }

    public function searchWithFilter(Request $request)
    {
        $keyword = $request->input('search');
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

        $listhotel = $this->filterHotel($keyword, $checkin, $checkout, $slphong, $adult, $kid, $priceFilter, $rateFilter);
        $cityname = $listhotel->first()->city->ct_name;
        $forecast = $this->getWeatherForecast($cityname, $checkin, $checkout);
        session(['previous_url' => $request->fullUrl()]);
        // Trả về view với danh sách đã lọc
        return view('listhotel', [
            'hotels' => $listhotel,
            'keyword' => $keyword,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'slphong' => $slphong,
            'adult' => $adult,
            'kid' => $kid,
            'forecast' => $forecast,
            'priceFilter' => $priceFilter,
            'rateFilter' => $rateFilter,
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
}