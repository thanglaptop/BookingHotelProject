<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Hotel;
use App\Models\Room;

class DisplayContentController
{
    public function displayContent()
    {
        $cities =  City::has('hotels')->withCount('hotels')->get();
        $room = Room::all();
        return view('index', ['cities' => $cities, 'room' => $room]);
    }

    public function showHotelOfCity($id)
    {
        $city = City::findOrFail($id);
        $hotels = Hotel::all()->where('ct_id', $id);
        $room = Room::all();
        // $today = date('Y-m-d');
        // $nextday = date('Y-m-d', strtotime('+1 day'));
        return view('listhotel', ['city'=>$city, 'hotels' => $hotels, 'room' => $room]);
    }

    public function showDetailHotel($id){
        $hotel = Hotel::findOrFail($id);
        return view('detailhotel', ['hotel' => $hotel]);
    }
}
