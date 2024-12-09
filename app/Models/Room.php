<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'room';

    protected $primaryKey = 'r_id';

    protected $fillable = [
        'r_name',
        'r_price',
        'r_soluong',
        'r_mota',
        'r_isclose',
        'r_dateclose',
        'r_dateopen',
        'r_maxadult',
        'r_maxkid',
        'r_maxperson',
        'r_dientich',
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
        return $this->belongsToMany(Tiennghi::class, 'room_tiennghi', 'R_ID', 'TN_ID');  //class, foreignkey, localkey
    }

    public function detail_ddps()
    {
        return $this->hasMany(Detail_Ddp::class, 'r_id', 'r_id'); //class, foreignkey, localkey
    }

    public function hasManyInGioHangCustomer()
    {
        return $this->belongsToMany(Customer::class, 'giohang', 'R_ID', 'C_ID')->withPivot('g_checkin', 'g_checkout', 'g_soluong'); //class, foreignkey, localkey
    }
}
