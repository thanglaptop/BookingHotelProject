<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotel';
    public $timestamps = false;
    protected $primaryKey = 'h_id';

    protected $fillable = [
        'h_name',
        'h_dchi',
        'h_sdt',
        'h_mota',
        'h_isclose',
        'h_dateclose',
        'h_dateopen',
        'o_id',
        'lh_id',
        'ct_id',
        'pm_id'
    ];


    // Quan hệ với model Owner
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'o_id', 'o_id'); //class, foreignkey, ownerkey
    }

    // Quan he voi LoaiHinh
    public function loaihinh()
    {
        return $this->belongsTo(Loaihinh::class, 'lh_id', 'lh_id');
    }

    // Quan he voi City
    public function city()
    {
        return $this->belongsTo(City::class, 'ct_id', 'ct_id');
    }

    public function paymentinfo()
    {
        return $this->belongsTo(Paymnet_Info::class, 'pm_id', 'pm_id');
    }

    public function hotel_imgs()
    {
        return $this->hasMany(Hotel_Img::class, 'h_id', 'h_id'); //class, foreignkey, localkey
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'h_id', 'h_id'); //class, foreignkey, localkey
    }

    public function dsTienNghi()
    {
        return $this->belongsToMany(Tiennghi::class, 'hotel_tiennghi', 'H_ID', 'TN_ID'); //class, foreignkey, localkey
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'h_id', 'h_id');
    }

    public function dondatphongs()
    {
        return $this->hasMany(Dondatphong::class, 'h_id', 'h_id'); //class, foreignkey, localkey
    }

    // Định nghĩa Accessor để tính sao trung bình
    public function getAverageStarAttribute()
    {
        // Lấy tất cả đánh giá của khách sạn này
        $ratings = Danhgia::whereHas('detail_ddp.dondatphong.hotel', function ($query) {
            $query->where('h_id', $this->h_id);
        })->get();

        // Kiểm tra nếu có đánh giá
        if ($ratings->count() > 0) {
            $totalStars = 0;
            foreach ($ratings as $rating) {
                // Lấy ký tự đầu tiên của dg_star và chuyển nó thành số
                $star = (int) substr($rating->dg_star, 0, 1); // Lấy ký tự đầu tiên và ép kiểu sang số
                $totalStars += $star;
            }
            return round($totalStars / $ratings->count(), 1); // Trả về sao trung bình
        }

        // Nếu không có đánh giá, trả về 0 sao
        return 0;
    }
}
