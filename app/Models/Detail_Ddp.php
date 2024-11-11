<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Ddp extends Model
{
    use HasFactory;

    protected $table = 'detail_ddp';

    protected $primaryKey = 'detail_id';

    protected $fillable = [
        'detail_checkin',
        'detail_checkout',
        'detail_soluong',
        'detail_thanhtien',
        'r_id',
        'ddp_id'
    ];  

    public function danhgia()
    {
        return $this->hasOne(Danhgia::class, 'detail_id', 'detail_id'); //class, foreignkey, localkey
    }

    public function dondatphong()
    {
        return $this->belongsTo(Dondatphong::class, 'ddp_id', 'ddp_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'r_id', 'r_id');
    }
}
