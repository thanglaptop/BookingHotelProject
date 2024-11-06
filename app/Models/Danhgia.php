<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Danhgia extends Model
{
    use HasFactory;

    protected $table = 'danhgia';

    protected $primaryKey = 'dg_id'; // Đặt khóa chính nếu không phải là 'id'

    protected $fillable = [
        'dg_star',
        'dg_nhanxet',
        'dg_ngaydg',
        'c_id',
        'detail_id'
    ]; 

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'c_id', 'c_id');
    }

    public function detail_ddp()
    {
        return $this->belongsTo(Detail_Ddp::class, 'detail_id', 'detail_id');
    }
}
