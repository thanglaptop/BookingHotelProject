<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = 'city';

    protected $primaryKey = 'ct_id';

    protected $fillable = [
        'ct_name',
        'ct_img'
    ]; 

     // Quan hệ với model Hotel
     public function hotels()
     {
         return $this->hasMany(Hotel::class, 'ct_id', 'ct_id'); //class, foreignkey, localkey
     }
}
