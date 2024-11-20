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
                <div class="row d-flex g-2">
                    <div class="col-lg-4 col-12"><input type="text" class="form-control form-control-lg h-100"
                            placeholder="Nhập địa điểm tên du lịch hoặc tên khách sạn" value="{{$city->ct_name}}">
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="input-group h-100">
                            <input type="date" class="form-control form-control-lg" value="{{ date('Y-m-d') }}">
                            <input type="date" class="form-control form-control-lg" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div id="popover-toggle" class="form-control form-control-lg h-100 d-flex scroll-1"
                            aria-label="Toggle popover">
                            1 phòng, 2 người lớn, 0 trẻ em
                        </div>
                    </div>
                    <div class="col-lg-1 col-12 text-center"><button class="btn btn-primary btn-lg">Tìm</button></div>
                </div>
            </div>
        </div>


        <div class="container p-4">
            <div class="row">
                <div class="col-lg-3 weather-forecast">
                    <h1 class="weather-forecast">Dự báo thời tiết ở đây</h1>
                </div>
                <div class="col-lg-9">

                    <div class="d-grid gap-4">
                        <div class="filter">
                            <div class="container">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <div id="popover-toggle-filter" class="text-center" aria-label="Toggle popover">
                                            Bộ lọc <i class="bi bi-caret-down-fill"></i>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div id="popover-toggle-price" class="text-center" aria-label="Toggle popover">
                                            Giá tiền <i class="bi bi-caret-down-fill"></i>
                                        </div>
                                    </div>
                                    <div class="col-4 text-center">
                                        <select name="" id="" class="sort">
                                            <option value="">Giá thấp nhất</option>
                                            <option value="">Giá cao nhất</option>
                                            <option value="">sao (5 đến 0)</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @foreach ($hotels as $hotel)
                            @php
                                $minprice = $room->where('h_id', $hotel->h_id)->min('r_price');
                                $maxprice = $room->where('h_id', $hotel->h_id)->max('r_price');
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
                                    <p class="card-text star col-lg-2"><i class="bi bi-star-fill"></i><i
                                            class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                            class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></p>
                                    <p class="col-10 address"><i class="bi bi-geo-alt-fill"></i> {{ $hotel->h_dchi }}
                                    </p>
                                    <div class="col-12"><i class="bi bi-check-lg"></i> list tiện nghi</div>
                                    <h4 class="col-lg-6 price">{{ number_format($minprice, 0, ',', '.') }} -
                                        {{ number_format($maxprice, 0, ',', '.') }} VNĐ</h4>
                                    <a class="col-lg-5" href="{{ route('showdetailhotel', ['id' => $hotel->h_id]) }}"><button
                                            class="btn btn-primary w-100">xem chi tiết</button></a>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

   
    @include('footer')

    @vite('resources/js/customer.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
