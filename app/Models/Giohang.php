<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

//bang trung gian co vai thuoc tinh rieng
class Giohang extends Pivot
{
    use HasFactory;

    protected $table = 'giohang';

    protected $fillable = [
        'g_checkin',
        'g_checkout',
        'g_soluong'
    ];
}
