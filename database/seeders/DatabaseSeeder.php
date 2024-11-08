<?php

namespace Database\Seeders;

use App\Models\Owner;
use App\Models\City;
use App\Models\Loaihinh;
use App\Models\Hotel;
use App\Models\Hotel_Img;
use App\Models\Paymnet_Info;
use App\Models\Tiennghi;
use App\Models\Customer;
use App\Models\Room;
use App\Models\Room_Img;
use Illuminate\Database\Seeder;
use App\Traits\myHelper;
use Pest\ArchPresets\Custom;

class DatabaseSeeder extends Seeder
{
    use myHelper;
    public function run(): void
    {
        //chủ khách sạn
        Owner::factory()->create([
            'o_username' => 'admin',
            'o_pass' => 'admin',
            'o_name'  => 'ADMIN',
            'o_sdt' => '0123456789',
            'o_dchi' => 'Địa chỉ mẫu',
            'o_nsinh' => '2000-01-01'
        ]);
        Customer::create([
            'c_username' => 'customer',
            'c_pass' => 'customer',
            'c_name'  => 'KHÁCH HÀNG TEST',
            'c_sdt' => '0123456789',
            'c_nsinh' => '2000-01-01',
            'c_email' => 'test@gmail.com',
            'c_avatar' => '0123456789'
        ]);
        Owner::factory()->count(4)->create();

        //thành phố
        $cities = [
            'An Giang',
            'Bà Rịa - Vũng Tàu',
            'Bắc Giang',
            'Bắc Kạn',
            'Bạc Liêu',
            'Bắc Ninh',
            'Bến Tre',
            'Bình Định',
            'Bình Dương',
            'Bình Phước',
            'Bình Thuận',
            'Cà Mau',
            'Cần Thơ',
            'Cao Bằng',
            'Đà Nẵng',
            'Đắk Lắk',
            'Đắk Nông',
            'Điện Biên',
            'Đồng Nai',
            'Đồng Tháp',
            'Gia Lai',
            'Hà Giang',
            'Hà Nam',
            'Hà Nội',
            'Hà Tĩnh',
            'Hải Dương',
            'Hải Phòng',
            'Hậu Giang',
            'Hồ Chí Minh',
            'Hòa Bình',
            'Hưng Yên',
            'Khánh Hòa',
            'Kiên Giang',
            'Kon Tum',
            'Lai Châu',
            'Lâm Đồng',
            'Lạng Sơn',
            'Lào Cai',
            'Long An',
            'Nam Định',
            'Nghệ An',
            'Ninh Bình',
            'Ninh Thuận',
            'Phú Thọ',
            'Phú Yên',
            'Quảng Bình',
            'Quảng Nam',
            'Quảng Ngãi',
            'Quảng Ninh',
            'Quảng Trị',
            'Sóc Trăng',
            'Sơn La',
            'Tây Ninh',
            'Thái Bình',
            'Thái Nguyên',
            'Thanh Hóa',
            'Thừa Thiên - Huế',
            'Tiền Giang',
            'Trà Vinh',
            'Tuyên Quang',
            'Vĩnh Long',
            'Vĩnh Phúc',
            'Yên Bái',
        ];
        $ds5tp = ['Bà Rịa - Vũng Tàu', 'Đà Nẵng', 'Hà Nội', 'Hồ Chí Minh', 'Thừa Thiên - Huế'];
        $dsimg = ['vungtau.jpg', 'danang.jpg', 'hanoi.jpg', 'hcm.jpg', 'hue.jpg'];
        $vitri = 0;
        foreach ($cities as $key => $city) {
            if (in_array($cities[$key], $ds5tp)) {
                City::create(['ct_name' => $city, 'ct_img' => $dsimg[$vitri]]);
                $vitri++;
            } else {
                City::create(['ct_name' => $city]);
            }
        }

        //loại hình
        $manyloaihinh = ['Khách sạn', 'Homestay', 'Resort', 'Căn hộ', 'Nhà nghỉ'];
        foreach ($manyloaihinh as $loaihinh) {
            Loaihinh::create(['lh_name' => $loaihinh]);
        }

        $dstenTTTT = [
            'Dành chung',
            'Dành riêng cho khách sạn A',
            'TTTT hotel B',
            'Phương thức 2',
            'TTTT chỉ cho Quận 5'
        ];
        $pm_mota = "Nếu bạn thanh toán qua momo hoặc chuyển khoản, hãy ghi nội dung chuyển khoản theo mẫu sau <họ và tên, ngày đặt đơn, số điện thoại, số tiền thanh toán>, Ví dụ: NGUYEN VAN A, 30/01/2025, 0123456789, 500000. Chúng tôi sẽ kiểm tra và xác nhận đơn đặt cho bạn sớm nhất có thể, nếu có bất kỳ thắc mắc gì bạn hãy liên hệ với chúng tôi qua số điện thoại sau của khách sạn 0123456789.";
        $oId = 1;
        for ($i = 0; $i < 15; $i++) {
            Paymnet_Info::create([
                'pm_name' => fake()->randomElement($dstenTTTT),
                'pm_athotel' => 1,
                'pm_momo' => $this->vnPhone(),
                'pm_bank' => $this->vnPhone(),
                'pm_QRmomo' => $this->vnPhone(),
                'pm_QRbank' => $this->vnPhone(),
                'pm_mota' => $pm_mota,
                'o_id' => $oId,
            ]);
            $oId++;
            if ($oId == 6) {
                $oId = 1;
            }
        }

        $hotel_mota = "Hãy để chuyến đi của quý khách có một khởi đầu tuyệt vời khi ở lại khách sạn này, nơi có Wi-Fi miễn phí trong tất cả các phòng. Nằm ở vị trí chiến lược, cho phép quý khách lui tới và gần với các điểm thu hút và tham quan địa phương. Được xếp hạng cao, chỗ nghỉ chất lượng cao này cho phép khách nghỉ sử dụng bể bơi ngoài trời, phòng tập và nhà hàng ngay trong khuôn viên.";
        $admin_pm_id = Paymnet_Info::where('o_id', 1)->inRandomOrder()->value('pm_id');
        Hotel::create([
            'h_name' => "Nhà Bà Tư Boutique Hotel",
            'h_dchi' => "Hẻm 139 Phan Chu Trinh, Phường 2, Vũng Tàu",
            'h_sdt' => $this->vnPhone(),
            'h_mota' => $hotel_mota,
            'h_isclose' => 0,
            'o_id' => 1,
            'lh_id' => 1,
            'ct_id' => 2,
            'pm_id' => $admin_pm_id,
        ]);
        Hotel::create([
            'h_name' => "Shin&Sam Hotel",
            'h_dchi' => "17/5 Hồ Quý Ly, Phường Thắng Tam, Vũng Tàu",
            'h_sdt' => $this->vnPhone(),
            'h_mota' => $hotel_mota,
            'h_isclose' => 0,
            'o_id' => 1,
            'lh_id' => 1,
            'ct_id' => 2,
            'pm_id' => $admin_pm_id,
        ]);
        //khách sạn
        $hotelNames = [
            'Green Hotel Vũng Tàu',
            'Khách sạn Bãi biển Annata',
            'Khách sạn La Casa',
            'The Sóng Apartment Vũng Tàu',
            'Vung Tau RiVa Hotel',
            'Golden Lotus Grand Da Nang',
            'Khách sạn Radisson Đà Nẵng',
            'La Belle Vie Boutique Hotel',
            'RHM HOTEL',
            'Wyndham Đà Nẵng Golden Bay',
            'Hotel Royal',
            'Khách sạn Bel Ami Hà Nội',
            'Khách sạn Chariot',
            'Khách sạn Sunrise Hà Nội',
            'Libre Homestay',
            'Cozrum Homes - Sonata Residence',
            'Hotel Continental Saigon',
            'Huazhu Hotel',
            'Khách sạn La Memoria - Trung tâm thành phố',
            'KHÁCH SẠN LA VELA SÀI GÒN',
            'Boom Casa Homestay',
            'Huong Giang Hotel Resort & Spa',
            'Khách sạn The Sunriver Boutique Huế',
            'LA VELA HUE HOTEL',
            'Park View Hotel'
        ];

        // Tạo mảng chứa các giá trị cho ct_id
        $top5tp = [2, 15, 24, 29, 57];

        // Tạo mảng với mỗi giá trị xuất hiện 5 lần
        $top5lap5 = [];
        foreach ($top5tp as $tp) {
            for ($i = 0; $i < 5; $i++) {
                $top5lap5[] = $tp;
            }
        }
        $dem = 1;
        $increaseID = 1;
        foreach ($top5lap5 as $city) {
            $ownerId = rand(1, 5);
            $pmId = Paymnet_Info::where('o_id', $ownerId)->inRandomOrder()->value('pm_id');
            Hotel::create([
                'h_name' => array_shift($hotelNames),
                'h_dchi' => fake()->address,
                'h_sdt' => $this->vnPhone(),
                'h_mota' => $hotel_mota,
                'h_isclose' => 0,
                'o_id' => $increaseID,
                'lh_id' => rand(1, 5),
                'ct_id' => $city,
                'pm_id' => $pmId,
            ]);
            $dem++;
            if ($dem > 5) {
                $increaseID++;
                $dem = 1;
            }
        }

        //thêm ảnh cho 27 khách sạn đầu tiên
        $demks = 1;
        for ($i = 1; $i < 6; $i++) {
            Hotel_Img::create([
                'h_id' => $demks,
                'hi_name' => "h" . $demks . "img" . $i . ".png",
                'hi_vitri' => $i
            ]);
            if ($i == 5) {
                $i = 0;
                $demks++;
            }
            if ($demks > 27)
                break;
        }


        //tiện nghi
        $dstiennghi = [
            'bồn tắm',
            'ấm đun',
            'máy sấy',
            'tv',
            'điều hòa',
            'tủ lạnh',
            'két sắt',
            'tủ quần áo',
            'bàn ủi',
            'gương',
            'sofa',
            'ban công',
            'đồ dùng cá nhân',
            'giá treo',
            'vòi nóng lạnh',
            'hút thuốc',
            'bàn làm việc',
            'nước miễn phí',
            'bếp',
            'dép trong nhà',

            'hồ bơi',
            'bãi để xe',
            'internet',
            'phòng gym',
            'sân chơi',
            'spa/xông hơi',
            'tiếp tân 24h',
            'đưa đón sân bay',
            'câu lạc bộ đêm',
            'cho phép thú cưng',
            'có bữa sáng',
            'giữ hành lý',
            'TT tại khách sạn',
        ];
        $demtiennghi = 0;
        foreach ($dstiennghi as $tn) {
            $demtiennghi++;
            if ($demtiennghi > 20) {
                Tiennghi::create([
                    'tn_name' => $tn,
                    'tn_ofhotel' => 1
                ]);
            } else {
                Tiennghi::create([
                    'tn_name' => $tn,
                ]);
            }
        }
        $room_name = [
            'Phòng Tiêu Chuẩn Hướng Núi (Standard)',
            'Phòng Giường Đôi (Standard Double)',
            'Phòng Superior Hướng Biển (Superior)',
            'Studio Có Ban Công (Studio With Balcony)',
            'Phòng Loại Sang (Deluxe)'
        ];
        $room_price = [600000, 850000, 1100000, 1300000, 1500000];
        //phòng
        $room_mota = "Phòng phù hợp để nghỉ dưỡng kèm vui chơi, ban công hướng biển thoáng mát, phòng có đầy đủ tiện nghi cho bạn sử dụng như bồn tắm, tv, giường lớn,... phòng sẽ phục vụ cho bạn bữa sáng mỗi ngày, còn chần chờ gì nữa hãy đặt phòng ngay thôi nào!";
        for ($ks = 1; $ks < 28; $ks++) {
            for ($room = 0; $room < 5; $room++) {
                Room::create([
                    'r_name' => $room_name[$room],
                    'r_price' => $room_price[$room],
                    'r_soluong' => 10,
                    'r_mota' => $room_mota,
                    'h_id' => $ks
                ]);
            }
        }

        //ảnh phòng, chỉ demo 5 phòng, mỗi phòng 5 ảnh
        // for ($ks = 1; $ks < 28; $ks++) {
        //     for ($room = 1; $room < 6; $room++) {
        //         for ($img = 1; $img < 6; $img++) {
        //             Room_Img::create([
        //                 'r_id' => $ks,
        //                 'ri_name' => "r" . $room . "img" . $img,
        //                 'ri_vitri' => $img
        //             ]);
        //         }
        //     }
        // }
        $dem = 1;
        for ($room = 1; $room < 136; $room++) {
            for ($img = 1; $img < 6; $img++) {
                Room_Img::create([
                    'r_id' => $room,
                    'ri_name' => "r" . $dem . "img" . $img . ".png",
                    'ri_vitri' => $img
                ]);
            }
            $dem++;
            if ($dem > 5)
                $dem = 1;
        }
    }
}
