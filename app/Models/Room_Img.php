<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room_Img extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'room_img';

    protected $fillable = [
        'r_id',
        'ri_name',
        'ri_vitri'
    ]; 

    public function room()
    {
        return $this->belongsTo(Room::class, 'r_id', 'r_id'); //class, foreignkey, ownerkey
    }
}
