<?php

namespace App\Traits;

trait myHelper
{
    // Hàm để tạo số điện thoại Việt Nam
    public function vnPhone()
    {
        // Số điện thoại Việt Nam bắt đầu bằng 0 và có 10 ký tự
        return '0' . rand(100000000, 999999999);
    }
}