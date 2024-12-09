<?php

namespace App\Traits;

use App\Models\City;
use App\Models\Detail_Ddp;
use App\Models\Dondatphong;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use App\Models\Hotel;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

trait myHelper
{
    // Hàm để tạo số điện thoại Việt Nam
    public function vnPhone()
    {
        // Số điện thoại Việt Nam bắt đầu bằng 0 và có 10 ký tự
        return '0' . rand(100000000, 999999999);
    }

    public function cccd()
    {
        // Số điện thoại Việt Nam bắt đầu bằng 0 và có 10 ký tự
        return '0' . rand(10000000000, 99999999999);
    }

    public function ownerId()
    {
        $owner =  Auth::guard('owner')->user();
        return $owner ? $owner->o_id : null;
    }

    public function Employee()
    {
        $employee = Auth::guard('employee')->user();
        return $employee ? $employee : null;
    }
    public function hotelOfOwner($id)
    {
        if ($this->ownerId()) {
            $hotel = Hotel::where('h_id', $id)->where('o_id', $this->ownerId())->first();
        }
        if ($this->Employee()) {
            $employee = $this->Employee();
            $hotel = Hotel::where('h_id', $id)->where('o_id', $employee->o_id)->first();
        }
        if ($hotel) {
            return $hotel->h_id;
        }
        return null;
    }

    public function hotelOfEmployee()
    {
        if ($this->Employee()) {
            $employee = $this->Employee();
            $hotel = Hotel::where('h_id', $employee->h_id)->firstOrFail();
        }
        return $hotel->h_id;
    }

    public function returnHotelBelong($id)
    {
        $ownerId = $this->ownerId(); // Lấy ID của chủ sở hữu
        $employee = $this->Employee(); // Lấy ID của nhân viên
        if ($ownerId) {
            $hotel = Hotel::where('h_id', $id)->where('o_id', $ownerId)->first();
        }

        if ($employee) {
            $hotel = Hotel::join('employee', 'hotel.h_id', '=', 'employee.h_id')
                ->where('hotel.h_id', $id)
                ->where('employee.e_id', $employee->e_id)
                ->select('hotel.*') // Chỉ chọn cột từ bảng hotels (nếu cần)
                ->first();
        }
        return $hotel;
    }

    public function returnListRoomWithRemainQuantity($hid, $checkin, $checkout)
{
    $listroom = Room::where('h_id', $hid)->get();

    $roomsWithRemainingQuantity = $listroom->map(function ($room) use ($checkin, $checkout) {
        $bookedQuantity = Detail_Ddp::where('r_id', $room->r_id)
            ->whereHas('dondatphong', function ($query) {
                $query->whereIn('ddp_status', ['pending', 'confirmed', 'checkedin']);
            })
            ->where(function ($query) use ($checkin, $checkout) {
                $query->where(function ($subquery) use ($checkin, $checkout) {
                    // Điều kiện khoảng ngày đặt phòng trùng với khoảng ngày tìm kiếm
                    $subquery->where('detail_checkin', '<', $checkout)
                        ->where('detail_checkout', '>', $checkin);
                });
            })
            ->sum('detail_soluong');

        // Tính số lượng phòng còn lại
        $remainingQuantity = max(0, $room->r_soluong - $bookedQuantity);

        // Trả về thông tin phòng và số lượng còn lại
        return [
            'r_id' => $room->r_id,
            'r_name' => $room->r_name,
            'r_price' => $room->r_price,
            'r_soluong' => $room->r_soluong,
            'r_mota' => $room->r_mota,
            'r_maxadult' => $room->r_maxadult,
            'r_maxkid' => $room->r_maxkid,
            'r_maxperson' => $room->r_maxperson,
            'r_dientich' => $room->r_dientich,
            'h_id' => $room->h_id,
            'r_conlai' => $remainingQuantity,
            'checkin' => $checkin,
            'checkout' => $checkout
        ];
    });

    return $roomsWithRemainingQuantity;
}


    public function returnListHotelWithRevenue($oid, $ngaybd, $ngaykt)
    {
        $listhotel = Hotel::where('o_id', $oid)->get();

        $hotelsWithRevenue = $listhotel->map(function ($hotel) use ($ngaybd, $ngaykt) {
            // Tổng doanh thu từ bảng dondatphongs có h_id tương ứng và ddp_ngaydat nằm trong khoảng ngày,
            // và ddp_status là 'completed', kiểm tra detail_checkout trong khoảng thời gian
            $totalRevenue = Dondatphong::where('h_id', $hotel->h_id)
                ->whereIn('ddp_status', ['completed', 'rated']) // Kiểm tra trạng thái là 'completed'
                ->whereHas('detail_ddps', function ($query) use ($ngaybd, $ngaykt) {
                    // Kiểm tra ngày trả phòng (detail_checkout) trong khoảng thời gian
                    $query->whereBetween('detail_checkout', [$ngaybd, $ngaykt]);
                })
                ->sum('ddp_total'); // Tổng doanh thu

            $totalddp = Dondatphong::where('h_id', $hotel->h_id)
                ->whereIn('ddp_status', ['completed', 'rated']) // Kiểm tra trạng thái là 'completed'
                ->whereHas('detail_ddps', function ($query) use ($ngaybd, $ngaykt) {
                    // Kiểm tra ngày trả phòng (detail_checkout) trong khoảng thời gian
                    $query->whereBetween('detail_checkout', [$ngaybd, $ngaykt]);
                })
                ->count(); // Tổng doanh thu

            // Trả về thông tin khách sạn và doanh thu
            return [
                'h_id' => $hotel->h_id,
                'h_name' => $hotel->h_name,
                'h_dchi' => $hotel->h_dchi,
                'h_sdt' => $hotel->h_sdt,
                'h_doanhthu' => $totalRevenue,
                'h_ddp' => $totalddp
            ];
        });

        return $hotelsWithRevenue;
    }

    public function convertToSlug($string)
    {
        $string = Str::ascii($string);
        $string = strtolower($string);
        $string = str_replace(' ', '', $string);

        return $string;
    }

    public function returnResultAvailableClose($hid, $ngaydong, $ngaymo)
    {
        // Kiểm tra xem có đơn đặt phòng nào trong khoảng thời gian này hay không
        $hasBookings = Detail_Ddp::whereHas('dondatphong', function ($query) use ($hid) {
            // Lọc khách sạn với mã h_id
            $query->where('h_id', $hid)
                ->where('ddp_status', '!=', 'canceled'); // Lọc những đơn không có trạng thái 'canceled'
        })
            ->where(function ($query) use ($ngaydong, $ngaymo) {
                // Kiểm tra điều kiện thời gian đặt phòng
                $query->where(function ($subquery) use ($ngaydong, $ngaymo) {
                    $subquery->where('detail_checkin', '<', $ngaymo)
                        ->where('detail_checkout', '>=', $ngaydong);
                });
            })
            ->exists(); // Kiểm tra sự tồn tại của các đơn đặt phòng không bị hủy trong khoảng thời gian

        // Nếu không có đơn đặt phòng nào, trả về true
        return !$hasBookings;
    }


    public function returnResultAvailableRoomClose($roomId, $ngaydong, $ngaymo)
    {
        // Kiểm tra xem phòng có mã r_id có đơn đặt phòng nào trong khoảng thời gian này hay không
        $hasBookings = Detail_Ddp::where('r_id', $roomId)
            ->whereHas('dondatphong', function ($query) {
                // Lọc đơn đặt phòng có trạng thái không phải 'canceled'
                $query->where('ddp_status', '!=', 'canceled');
            })
            ->where(function ($query) use ($ngaydong, $ngaymo) {
                // Điều kiện thời gian trùng
                $query->where('detail_checkin', '<', $ngaymo) // Ngày check-in trước ngày mở
                    ->where('detail_checkout', '>=', $ngaydong); // Ngày check-out sau ngày đóng
            })
            ->exists(); // Kiểm tra sự tồn tại của đơn đặt phòng hợp lệ trong khoảng thời gian

        // Nếu không có đơn đặt phòng nào, trả về true
        return !$hasBookings;
    }


    public function returnListHotelResult($keyword, $checkin, $checkout, $slphong, $adult, $kid)
    {
        $newkeyword = $this->convertToSlug($keyword);
        $characters = str_split($newkeyword);
        $listhotelname = Hotel::all()->pluck('h_name');
        $listcityname =  City::whereHas('hotels')->pluck('ct_name');
        $hotels = collect();
        $keywordlength = count($characters);

        foreach ($listcityname as $ctname) {
            $splitctname = str_split($this->convertToSlug($ctname));
            $count = 0;
            foreach ($characters as $char) {
                if (in_array($char, $splitctname)) {
                    $count++;
                    if ($count >= $keywordlength) {
                        $city = City::where('ct_name', $ctname)->first();
                        if ($city) {
                            $hotels = $city->hotels; // Lấy danh sách hotels qua mối quan hệ
                        }
                        break 2;
                    }
                }
            }
        }
        while (count($hotels) < 1 && $keywordlength > 0) {
            foreach ($listhotelname as $name) {
                $splitname = str_split($this->convertToSlug($name));
                $count = 0;
                foreach ($characters as $char) {
                    if (in_array($char, $splitname)) {
                        $count++;
                        if ($count >= $keywordlength) {
                            $hotel = Hotel::firstWhere('h_name', $name);
                            if (!$hotels->contains($hotel)) {
                                $hotels->push($hotel);
                            }
                        }
                    }
                }
            }
            $keywordlength--;
        }

        $listhotel = collect();

        $sladult = $adult / $slphong;
        $slkid = $kid / $slphong;

        foreach ($hotels as $hotel) {
            $listroomremain = $this->returnListRoomWithRemainQuantity($hotel->h_id, $checkin, $checkout);
            foreach ($hotel->rooms as $room) {
                $conlai = $listroomremain->firstWhere('r_id', $room->r_id)['r_conlai'] ?? 0;
                if ($room->r_maxadult >= $sladult && $room->r_maxkid >= $slkid && $conlai >= $slphong) {
                    if (!$listhotel->contains($hotel)) {
                        $listhotel->push($hotel);
                    }
                } else if (($sladult + $slkid) <= $room->r_maxperson && $conlai >= $slphong) {
                    if (!$listhotel->contains($hotel)) {
                        $listhotel->push($hotel);
                    }
                }
            }
        }

        return $listhotel;
    }

    public function getWeatherForecast($cityname, $checkin, $checkout)
    {
        $city = Str::ascii($cityname);

        // Gọi API OpenWeatherMap
        $apiKey = 'dec8601cd2fe00c6d98fa9f6abae019f';

        // Hàm để gọi API với tên thành phố đã được chỉnh sửa
        $getWeatherData = function ($city) use ($apiKey) {
            return Http::get("https://api.openweathermap.org/data/2.5/forecast", [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric', // Đơn vị nhiệt độ là Celsius
                'lang' => 'vi',
            ]);
        };

        // Khởi tạo phản hồi là null để bắt đầu vòng lặp
        $response = $getWeatherData($city);

        // Chạy vòng lặp, tiếp tục cắt bỏ từ đầu tiên cho đến khi có dữ liệu
        while (!$response->successful()) {
            // Nếu không có dữ liệu, loại bỏ từ đầu tiên của tên thành phố và thử lại
            $cityArray = explode(' ', $city);

            // Loại bỏ từ đầu tiên và gộp lại các từ còn lại
            array_shift($cityArray);
            $city = implode(' ', $cityArray);

            // Nếu city đã hết từ, thoát khỏi vòng lặp
            if (count($cityArray) == 0) {
                return response()->json(['error' => 'Không tìm thấy dữ liệu dự báo'], 404);
            }

            // Gọi lại API với tên thành phố mới
            $response = $getWeatherData($city);
        }

        // Nếu có dữ liệu, xử lý tiếp
        $data = $response->json();

        // Lọc dữ liệu dự báo cho các ngày trong khoảng checkin và checkout
        $filteredData = collect($data['list'])->filter(function ($item) use ($checkin, $checkout) {
            $forecastDate = Carbon::parse($item['dt_txt']);
            return $forecastDate->between($checkin, $checkout);
        });

        // Tạo một mảng để chứa dữ liệu các ngày
        $forecastData = $filteredData->map(function ($item) use ($data) {
            return [
                'city' => $data['city']['name'],
                'date' => Carbon::parse($item['dt_txt'])->toDateTimeString(), // Lấy cả ngày và giờ
                'temperature' => round($item['main']['temp']),
                'description' => $item['weather'][0]['description'],
                'humidity' => $item['main']['humidity'],
                'wind_speed' => $item['wind']['speed'],
                'iconCode' => $item['weather'][0]['icon'],  // Lấy mã icon từ phản hồi API
            ];
        });

        // Trả về forecastData dưới dạng đối tượng (dùng phương thức toArray để chuyển thành mảng nếu cần)
        return $forecastData->toArray();
    }

    public function filterHotel($keyword, $checkin, $checkout, $slphong, $adult, $kid, $priceFilter, $rateFilter){
        $listhotel = $this->returnListHotelResult($keyword, $checkin, $checkout, $slphong, $adult, $kid);
        // Lọc theo giá
        if ($priceFilter != '0') {
            $listhotel = $listhotel->map(function ($hotel) {
                // Thêm thuộc tính giá phòng thấp nhất cho từng khách sạn
                $hotel->average_price = ($hotel->rooms->pluck('r_price')->min() + ($hotel->rooms->pluck('r_price')->max()))/2; // Giá trung bình
                return $hotel;
            });

            switch ($priceFilter) {
                case 'min': // Lấy khách sạn có giá phòng thấp nhất
                    $minPrice = $listhotel->min('average_price'); // Tìm giá thấp nhất trong danh sách
                    $listhotel = $listhotel->filter(function ($hotel) use ($minPrice) {
                        return $hotel->average_price == $minPrice;
                    })->values(); // Lọc danh sách khách sạn có giá thấp nhất
                    break;
                case 'max': // Lấy khách sạn có giá phòng cao nhất
                    $maxPrice = $listhotel->max('average_price'); // Tìm giá thấp nhất trong danh sách
                    $listhotel = $listhotel->filter(function ($hotel) use ($maxPrice) {
                        return $hotel->average_price == $maxPrice;
                    })->values(); // Lọc danh sách khách sạn có giá thấp nhất
                    break;
                case 'mintomax': // Sắp xếp giá thấp đến cao
                    $listhotel = $listhotel->sortBy('average_price')->values();
                    break;

                case 'maxtomin': // Sắp xếp giá cao đến thấp
                    $listhotel = $listhotel->sortByDesc('average_price')->values();
                    break;
            }
        }

        // Lọc theo đánh giá (rateFilter)
        if ($rateFilter != '0') {
            $listhotel = $listhotel->map(function ($hotel) {
                $hotel->rating = $hotel->average_star; // Gán thuộc tính sao trung bình
                return $hotel;
            });

            switch ($rateFilter) {
                case 'low': // Sắp xếp từ đánh giá thấp nhất
                    $minRating = $listhotel->min('rating'); // Tìm giá thấp nhất trong danh sách
                    $listhotel = $listhotel->filter(function ($hotel) use ($minRating) {
                        return $hotel->rating == $minRating;
                    })->values(); // Lọc danh sách khách sạn có giá thấp nhất
                    break;
                case 'high': // Sắp xếp từ đánh giá cao nhất
                    $maxRating = $listhotel->max('rating'); // Tìm giá thấp nhất trong danh sách
                    $listhotel = $listhotel->filter(function ($hotel) use ($maxRating) {
                        return $hotel->rating == $maxRating;
                    })->values(); // Lọc danh sách khách sạn có giá thấp nhất
                    break;
                case 'lowtohigh': // Sắp xếp đánh giá tăng dần
                    $listhotel = $listhotel->sortBy('rating')->values();
                    break;
                case 'hightolow': // Sắp xếp đánh giá giảm dần
                    $listhotel = $listhotel->sortByDesc('rating')->values();
                    break;
            }
        }
        return $listhotel;
    }
}
