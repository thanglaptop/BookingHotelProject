<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;
    
    protected $table = 'owner';
    public $timestamps = false;
    protected $primaryKey = 'o_id'; // Đặt khóa chính nếu không phải là 'id'

    protected $fillable = [
        'o_username',
        'o_pass',
        'o_name',
        'o_sdt',
        'o_dchi', 
        'o_nsinh',
    ];

    protected $hidden = [
        'o_pass', // Ẩn mật khẩu khi chuyển đổi sang mảng hoặc JSON
    ]; 

    public function paymentInfos()
    {
        return $this->hasMany(Paymnet_Info::class, 'pm_id', 'pm_id'); //class, foreignkey, localkey
    }
    // Quan hệ với model Hotel
    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'o_id', 'o_id'); //class, foreignkey, localkey
    }
}
