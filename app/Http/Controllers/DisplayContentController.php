<?php

namespace App\Http\Controllers;
use App\Models\City;
use App\Models\Hotel;
use App\Models\Room;
class DisplayContentController
{
        public function displayContent(){
        $cities =  City::has('hotels')->withCount('hotels')->get();
        $room = Room::all();
        return view('index',['cities'=> $cities, 'room' => $room]);
    }

        public function showHotelOfCity($id){
        $hotels = Hotel::all()->where('ct_id', $id);
        $room = Room::all();
        return view('listhotel', ['hotels' => $hotels, 'room' => $room]);
    }
}
