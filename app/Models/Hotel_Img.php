<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel_Img extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'hotel_img';

    protected $fillable = [
        'h_id',
        'hi_name',
        'hi_vitri'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'h_id', 'h_id'); //class, foreignkey, ownerkey
    }
}


