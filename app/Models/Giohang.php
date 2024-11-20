<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

//bang trung gian co vai thuoc tinh rieng
class Giohang extends Pivot
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'giohang';

    protected $fillable = [
        'C_ID',
        'R_ID',
        'g_checkin',
        'g_checkout',
        'g_soluong'
    ];
    // public function getIncrementing()
    // {
    //     return false;
    // }

    // public function getKeyName()
    // {
    //     return null;
    // }

    // protected function setKeysForSaveQuery($query)
    // {
    //     return $query
    //         ->where('C_ID', $this->C_ID)
    //         ->where('R_ID', $this->R_ID);
    // }
}
