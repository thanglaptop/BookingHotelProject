<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
class Owner extends Authenticatable
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
        'o_email',
        'o_cccd'
    ];

    protected $hidden = [
        'o_pass', // Ẩn mật khẩu khi chuyển đổi sang mảng hoặc JSON
    ]; 

     // Đặt trường mật khẩu
     public function getAuthPassword()
     {
        //  return $this->o_pass;
        return 'o_pass';
     }
  
     // Đặt trường tên đăng nhập
     public function getAuthIdentifierName()
     {
         return 'o_username';
     }

    public function paymentInfos() 
    {
        return $this->hasMany(Paymnet_Info::class, 'o_id', 'o_id'); //class, foreignkey, localkey
    }
    // Quan hệ với model Hotel
    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'o_id', 'o_id'); //class, foreignkey, localkey
    }

    public function employees(){
        return $this->hasMany(Employee::class, 'o_id', 'o_id');
    }
}
