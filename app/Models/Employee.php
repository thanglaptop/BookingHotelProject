<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;
    
    protected $table = 'employee'; 
    public $timestamps = false;
    protected $primaryKey = 'e_id'; // Đặt khóa chính nếu không phải là 'id'

    protected $fillable = [
        'e_username',
        'e_pass',
        'e_name',
        'o_id',
        'h_id', 
    ];

    protected $hidden = [
        'e_pass', // Ẩn mật khẩu khi chuyển đổi sang mảng hoặc JSON
    ]; 

     // Đặt trường mật khẩu 
     public function getAuthPassword()
     {
        //  return $this->o_pass;
        return 'e_pass';
     }
  
     // Đặt trường tên đăng nhập
     public function getAuthIdentifierName()
     {
         return 'e_username';
     }

    public function owner() 
    {
        return $this->belongsTo(Owner::class, 'o_id', 'o_id');
    }
    // Quan hệ với model Hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'h_id', 'h_id');
    }
}
