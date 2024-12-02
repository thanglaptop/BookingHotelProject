<?php

namespace App\Traits;

use App\Models\Employee;
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

    public function cccd()
    {
        // Số điện thoại Việt Nam bắt đầu bằng 0 và có 10 ký tự
        return '0' . rand(10000000000, 99999999999);
    }

    public function ownerId()
    {
        $owner =  Auth::guard('owner')->user();
        return $owner ? $owner->o_id : null;
    }

    public function Employee()
    {
        $employee = Auth::guard('employee')->user();
        return $employee ? $employee : null;
    }
    public function hotelOfOwner($id)
    {
        if($this->ownerId()){
            $hotel = Hotel::where('h_id', $id)->where('o_id', $this->ownerId())->first();
        }
        if($this->Employee()){
            $employee = $this->Employee();
            $hotel = Hotel::where('h_id', $id)->where('o_id', $employee->o_id)->first();
        }
        if($hotel){
            return $hotel->h_id;
        }
        return null;
    }

    public function hotelOfEmployee($id){
        if($this->Employee()){
            $employee = $this->Employee();
            $hotel = Hotel::where('h_id', $employee->h_id)->firstOrFail();
        }
        return $hotel->h_id;
    }
}
