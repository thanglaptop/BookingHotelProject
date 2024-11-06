<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'room';
    
    protected $primaryKey = 'r_id';

    protected $fillable = [
        'r_name',
        'r_price',
        'h_soluong',
        'r_mota',
        'h_id'
    ]; 

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'h_id', 'h_id'); //class, foreignkey, ownerkey
    }

    public function room_imgs()
    {
        return $this->hasMany(Room_Img::class, 'r_id', 'r_id'); //class, foreignkey, localkey
    }

    public function dsTienNghi()
     {
         return $this->belongsToMany(Tiennghi::class, 'room_tiennghi', 'TN_ID', 'R_ID'); //class, foreignkey, localkey
     }

     public function detail_ddps()
    {
        return $this->hasMany(Detail_Ddp::class, 'r_id', 'r_id'); //class, foreignkey, localkey
    }

     public function hasManyInGioHangCustomer()
     {
         return $this->belongsToMany(Customer::class, 'giohang', 'C_ID', 'R_ID')->withPivot('g_checkin','g_checkout','g_soluong'); //class, foreignkey, localkey
     }
}
