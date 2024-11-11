<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dondatphong extends Model
{
    use HasFactory;

    protected $table = 'dondatphong';

    protected $primaryKey = 'ddp_id';

    protected $fillable = [
        'ddp_ngaydat',
        'ddp_customername',
        'ddp_sdt',
        'ddp_total',
        'ddp_pttt',
        'ddp_status',
        'c_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'c_id', 'c_id');
    }

    public function detail_ddps()
    {
        return $this->hasMany(Detail_Ddp::class, 'ddp_id', 'ddp_id'); //class, foreignkey, localkey
    }
}
