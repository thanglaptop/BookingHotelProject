<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loaihinh extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'loaihinh';

    protected $primaryKey = 'lh_id';

    protected $fillable = [
        'lh_name',
    ]; 

     // Quan hệ với model Hotel
     public function hotels()
     {
         return $this->hasMany(Hotel::class, 'lh_id', 'lh_id'); //class, foreignkey, localkey
     }
}
