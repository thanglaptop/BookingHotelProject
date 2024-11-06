<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'customer';

    protected $primaryKey = 'c_id'; // Đặt khóa chính nếu không phải là 'id'

    protected $fillable = [
        'c_username',
        'c_pass',
        'c_name',
        'c_sdt',
        'c_nsinh',
        'c_email',
        'c_avatar',
    ]; 

    protected $hidden = [
        'c_pass', // Ẩn mật khẩu khi chuyển đổi sang mảng hoặc JSON
    ];

    public function dondatphongs()
    {
        return $this->hasMany(Dondatphong::class, 'c_id', 'c_id'); //class, foreignkey, localkey
    }

    public function danhgias()
    {
        return $this->hasMany(Danhgia::class, 'c_id', 'c_id'); //class, foreignkey, localkey
    }
    
    public function hasManyRoomInGiohang()
    {
        return $this->belongsToMany(Room::class, 'giohang', 'R_ID', 'C_ID')->withPivot('g_checkin','g_checkout','g_soluong'); //class, foreignkey, localkey
    }
}
