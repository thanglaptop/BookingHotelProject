<?php

namespace App\Traits;
use Illuminate\Support\Facades\Auth;
use App\Models\Hotel;

trait myHelper
{
    // Hàm để tạo số điện thoại Việt Nam
    public function vnPhone()
    {
        // Số điện thoại Việt Nam bắt đầu bằng 0 và có 10 ký tự
        return '0' . rand(100000000, 999999999);
    }

    public function ownerId(){
        $owner =  Auth::guard('owner')->user();
        return $owner->o_id;
    }
    public function hotelOfOwner($id){
        $hotel = Hotel::where('h_id', $id)->where('o_id', $this->ownerId())->firstOrFail();
        return $hotel->h_id;
    }
}