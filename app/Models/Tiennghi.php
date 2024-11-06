<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiennghi extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'tiennghi';

    protected $primaryKey = 'tn_id';

    protected $fillable = [
        'tn_name',
        'tn_ofhotel'
    ]; 

    public function rooms()
     {
         return $this->belongsToMany(Room::class, 'room_tiennghi', 'R_ID', 'TN_ID'); //class, foreignkey, localkey
     }
     public function hotels()
     {
         return $this->belongsToMany(Hotel::class, 'hotel_tiennghi', 'H_ID', 'TN_ID'); //class, foreignkey, localkey
     }
}
