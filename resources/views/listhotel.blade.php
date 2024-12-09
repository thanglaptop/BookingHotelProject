<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- css --}}
    @vite('resources/css/customer.css')
    {{-- @vite('resources/css/user.css') --}}

    {{-- css bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- icon bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <title>AGOBEE</title>
</head>

<body>
    @include('header')

    <section>
        <div class="searchbar">
            <div class="container">
                <form action="{{ route('searchplace') }}" method="GET">
                    <div class="row d-flex g-2">
                        <div class="col-lg-4 col-12"><input type="text" name="search"
                                value="{{ $keyword ?? $city->ct_name }}" class="form-control form-control-lg h-100"
                                placeholder="Nhập địa điểm tên du lịch hoặc tên khách sạn">
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="input-group h-100">
                                <input id="inputCin" type="date" name="checkin" class="form-control form-control-lg"
                                    value="{{ $checkin ?? date('Y-m-d') }}">
                                <input id="inputCout" type="date" name="checkout"
                                    class="form-control form-control-lg"
                                    value="{{ $checkout ?? date('Y-m-d', strtotime('+1 day')) }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-12" id="RoomAndPerson">
                            <div id="popover-toggle" class="form-control form-control-lg h-100 d-flex scroll-1"
                                aria-label="Toggle popover">
                                {{ $slphong ?? 1 }} phòng, {{ $sladult ?? 2 }} người lớn, {{ $slkid ?? 0 }} trẻ em
                            </div>
                            <input type="hidden" value="{{ $slphong ?? 1 }}" name="room" id="room">
                            <input type="hidden" value="{{ $sladult ?? 2 }}" name="adult" id="adult">
                            <input type="hidden" value="{{ $slkid ?? 0 }}" name="kid" id="kid">
                        </div>
                        <div class="col-lg-1 col-12 text-center"><button class="btn btn-primary btn-lg">Tìm</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>


        <div class="container p-4">
            <div class="row">
                @if ($forecast == [])
                    <div class="d-flex flex-column align-items-center col-lg-3">
                        <img src="/images/other/find.png" style="width:100px; height:100px">
                        <h4 class="text-center">Chưa có dự báo thời tiết vào khoảng thời gian này</h4>
                    </div>
                @else
                    <div class="col-lg-3 d-flex scroll-1 gap-3 p-2" style="height: max-content">
                        @foreach ($forecast as $day)
                            @php
                                $iconUrl = "https://openweathermap.org/img/wn/{$day['iconCode']}@2x.png"; // URL của ảnh
                            @endphp
                            <div class="weather-card d-flex flex-column align-items-center rounded p-4">
                                <p>{{ $day['city'] }}</p>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $iconUrl }}" alt="Weather Icon">
                                    <h1>{{ $day['temperature'] }} °C</h1>
                                </div>
                                <h2>{{ $day['description'] }}</h2>
                                <h5>{{ \Carbon\Carbon::parse($day['date'])->format('d/m, H:i') }}</h5>
                                <div class="d-flex gap-2">
                                    <p><i class="bi bi-moisture"></i> {{ $day['humidity'] }}%</p>
                                    <p><i class="bi bi-wind"></i> {{ $day['wind_speed'] }} m/s</p>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="col-lg-9">

                    <div class="d-grid gap-4">
                        <div class="filter mt-2">
                            <div class="container">
                                <form action="{{ route('searchwithfilter') }}" method="GET">
                                    <input type="hidden" name="search" value="{{ $keyword ?? $city->ct_name }}">
                                    <input type="hidden" name="checkin" value="{{ $checkin ?? date('Y-m-d') }}">
                                    <input type="hidden" name="checkout"
                                        value="{{ $checkout ?? date('Y-m-d', strtotime('+1 day')) }}">
                                    <input type="hidden" value="{{ $slphong ?? 1 }}" name="room" id="room">
                                    <input type="hidden" value="{{ $sladult ?? 2 }}" name="adult" id="adult">
                                    <input type="hidden" value="{{ $slkid ?? 0 }}" name="kid" id="kid">
                                    @php
                                        $price = [
                                            '0' => 'Tất cả giá',
                                            'min' => 'Giá thấp nhất',
                                            'max' => 'Giá cao nhất',
                                            'mintomax' => 'Giá thấp đến cao',
                                            'maxtomin' => 'Giá cao đến thấp',
                                        ];
                                        $rate = [
                                            '0' => 'tất cả đánh giá',
                                            'low' => 'Đánh giá thấp nhất',
                                            'high' => 'Đánh giá cao nhất',
                                            'lowtohigh' => 'Đánh giá thấp đến cao',
                                            'hightolow' => 'Đánh giá cao đến thấp',
                                        ];
                                    @endphp
                                    <div class="row d-flex align-items-center">
                                        <div class="col-5 text-center">
                                            <select name="price" class="form-select sort">
                                                @foreach ($price as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ request('price') == $key ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-5 text-center">
                                            <select name="rate" class="form-select sort">
                                                @foreach ($rate as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ request('rate') == $key ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2 text-center"><button class="btn btn-orange">Lọc</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @if ($hotels->isEmpty())
                            <div class="d-flex flex-column align-items-center">
                                <img src="/images/other/find.png" style="width:300px; height:300px">
                                <h3>Rất tiếc! không có kết quả nào phù hợp</h3>
                            </div>
                        @else
                            @foreach ($hotels as $hotel)
                                @php
                                    $minprice = $hotel->rooms()->min('r_price');
                                    $maxprice = $hotel->rooms()->max('r_price');
                                @endphp
                                <div class="card hotel-detail">
                                    <div class="scroll-1 scrollimage">
                                        @foreach ($hotel->hotel_imgs as $img)
                                            <img src="/images/hotels/h{{ $hotel->h_id }}/{{ $img->hi_name }}"
                                                class="card-img-top">
                                        @endforeach
                                    </div>
                                    <div class="card-body row">
                                        <h4 class="card-title col-12">{{ $hotel->h_name }}</h4>
                                        <small class="col-12"><i class="bi bi-house-heart-fill"></i>
                                            {{ $hotel->loaihinh->lh_name }}</small>
                                        <p class="card-text star col-lg-3"><i class="bi bi-star-fill">
                                                {{ $hotel->average_star }} <a style="color: goldenrod;"
                                                    href="{{ route('seedanhgia', ['hid' => $hotel->h_id]) }}">xem đánh
                                                    giá</a></i>
                                        </p>
                                        <p class="col-9 address"><i class="bi bi-geo-alt-fill"></i>
                                            {{ $hotel->h_dchi }}
                                        </p>
                                        <div class="col-12 mb-2 d-flex scroll-1">
                                            @foreach ($hotel->dsTienNghi()->where('tn_ofhotel', 1)->get() as $tn)
                                                <span class="me-2"><i class="bi bi-check-lg"></i>
                                                    {{ $tn->tn_name }}</span>
                                            @endforeach
                                        </div>
                                        <h4 class="col-lg-6 price">{{ number_format($minprice, 0, ',', '.') }} -
                                            {{ number_format($maxprice, 0, ',', '.') }} VNĐ</h4>
                                        <form class="col-lg-5"
                                            action="{{ route('showdetailhotel', ['id' => $hotel->h_id]) }}"
                                            method="GET">
                                            @php
                                                $ngaycheckin = $checkin ?? date('Y-m-d');
                                                $ngaycheckout = $checkout ?? date('Y-m-d');
                                                // dd($ngaycheckin);
                                            @endphp
                                            @if (
                                                ($ngaycheckin >= $hotel->h_dateclose && $ngaycheckin < $hotel->h_dateopen) ||
                                                    ($ngaycheckout >= $hotel->h_dateclose && $ngaycheckout <= $hotel->h_dateopen))
                                                <button class="btn btn-danger w-100">đang đóng cửa</button>
                                            @else
                                                <button class="btn btn-primary w-100">xem chi tiết</button>
                                            @endif
                                            <input type="hidden" name="checkin"
                                                value="{{ $checkin ?? date('Y-m-d') }}">
                                            <input type="hidden" name="checkout"
                                                value="{{ $checkout ?? date('Y-m-d', strtotime('+1 day')) }}">
                                            <input type="hidden" name="room" value="{{ $slphong ?? 1 }}">
                                            <input type="hidden" name="adult" value="{{ $sladult ?? 2 }}">
                                            <input type="hidden" name="kid" value="{{ $slkid ?? 0 }}">
                                        </form>
                                        <div class="col-1"></div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        window.handleDateChange = function() {
            const checkinInput = document.getElementById("inputCin");
            const checkoutInput = document.getElementById("inputCout");

            const checkinDateStr = checkinInput.value;
            const checkoutDateStr = checkoutInput.value;

            const checkinDate = new Date(checkinDateStr);
            const checkoutDate = new Date(checkoutDateStr);

            // Kiểm tra nếu ngày check-out < ngày check-in
            if (checkoutDateStr && checkoutDate < checkinDate) {
                // alert("Ngày check-out không được nhỏ hơn hoặc bằng ngày check-in.");
                checkoutInput.value = ""; // Reset ngày check-out
                return;
            }

            // Nếu ngày check-in > ngày check-out
            if (checkinDateStr && checkoutDateStr && checkinDate > checkoutDate) {
                // alert("Ngày check-in không được lớn hơn hoặc bằng ngày check-out.");
                checkoutInput.value = ""; // Reset ngày check-out
                return;
            }
        };

        // Lắng nghe sự kiện thay đổi ngày check-in và check-out
        document.getElementById("inputCin").addEventListener('change', handleDateChange);
        document.getElementById("inputCout").addEventListener('change', handleDateChange);
    </script>
    @include('footer')

    @vite('resources/js/customer.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
