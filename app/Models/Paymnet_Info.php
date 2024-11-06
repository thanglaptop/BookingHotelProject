<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymnet_Info extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'payment_info';
    
    protected $primaryKey = 'pm_id';

    protected $fillable = [
        'pm_name',
        'pm_athotel',
        'pm_momo',
        'pm_bank',
        'pm_QRmomo',
        'pm_QRbank',
        'pm_mota',
        'o_id' 
    ]; 
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'o_id', 'o_id');
    }
}
