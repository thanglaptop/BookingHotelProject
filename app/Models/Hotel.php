<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotel';
    public $timestamps = false;
    protected $primaryKey = 'h_id';

    protected $fillable = [
        'h_name',
        'h_dchi',
        'h_sdt',
        'h_mota',
        'h_isclose',
        'h_dateclose',
        'h_dateopen',
        'o_id',
        'lh_id',
        'ct_id',
        'pm_id'
    ]; 

    // Quan hệ với model Owner
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'o_id', 'o_id'); //class, foreignkey, ownerkey
    }

    // Quan he voi LoaiHinh
    public function loaihinh()
    {
        return $this->belongsTo(Loaihinh::class, 'lh_id', 'lh_id');
    }

    // Quan he voi City
    public function city()
    {
        return $this->belongsTo(City::class, 'ct_id', 'ct_id');
    }

    // public function paymentinfo()
    // {
    //     return $this->belongsTo(Paymnet_Info::class, 'pm_id', 'pm_id');
    // }

    public function hotel_imgs()
    {
        return $this->hasMany(Hotel_Img::class, 'h_id', 'h_id'); //class, foreignkey, localkey
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'h_id', 'h_id'); //class, foreignkey, localkey
    }

    public function dsTienNghi()
     {
         return $this->belongsToMany(Tiennghi::class, 'hotel_tiennghi', 'TN_ID', 'H_ID'); //class, foreignkey, localkey
     }
}
