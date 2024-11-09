<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- css --}}
    @vite('resources/css/owner.css')
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
    @include('owner/header')

    <div class="background"><img src="images/other/bg.jpg" alt="">
        <div class="blur-background"></div>
        <div class="overlay-content">
            <h2 class="text-center p-3">A Good Online Booking Experience</h3>
                <div class="row">
                    <div class="col-md-2 col-1"></div>
                    <div class="col-md-8 col-10 p-3 search-form">
                        <div class="row g-3">
                            <div class="col-12">
                                <h4 class="title-search">Bạn muốn đi đâu, AGOBEE đưa bạn đến!</h4>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control form-control-lg"
                                    placeholder="Nhập địa điểm tên du lịch hoặc tên khách sạn">
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-lg">
                                    <input type="date" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control form-control-lg">
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <button class="btn btn-primary btn-lg w-50">Tìm</button>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-2 col-1"></div>
                </div>
        </div>
    </div>
    <div class="container">
        <h3>Chương trình khuyến mãi chỗ ở</h3>
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/images/other/km1.png" class="d-block w-100" alt="...">
                </div>
                @php
                    $array_km = ['km2.png', 'km3.png', 'km4.png', 'km5.png'];
                @endphp
                @foreach ($array_km as $km)
                    <div class="carousel-item">
                        <img src="/images/other/{{ $km }}" class="d-block w-100" alt="...">
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <h3 class="mt-5">Các điểm thu hút nhất Việt Nam</h3>
        <div class="d-flex scroll-1">
            @foreach ($cities as $city)
                <div class="card flex-shrink-0 m-3 city-card">
                    <img src="/images/cities/{{ $city->ct_img }}" class="card-img-top h-100" alt="ảnh không tồn tại">
                    <div class="card-body">
                        <h5 class="card-title">{{ $city->ct_name }}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Có {{ $city->hotels_count }} chỗ ở</h6>
                    </div>
                </div>
            @endforeach
        </div>

        <h3 class="mt-5">Những chỗ nghỉ nổi bật được đề xuất cho quý khách</h3>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                @foreach ($cities as $city)
                    @if ($loop->first)
                        <button class="nav-link active" id="CT{{ $city->ct_id }}-tab" data-bs-toggle="tab"
                            data-bs-target="#CT{{ $city->ct_id }}" type="button" role="tab"
                            aria-controls="CT{{ $city->ct_id }}" aria-selected="true">{{ $city->ct_name }}</button>
                    @else
                        <button class="nav-link" id="CT{{ $city->ct_id }}-tab" data-bs-toggle="tab"
                            data-bs-target="#CT{{ $city->ct_id }}" type="button" role="tab"
                            aria-controls="CT{{ $city->ct_id }}" aria-selected="false">{{ $city->ct_name }}</button>
                    @endif
                @endforeach
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            @foreach ($cities as $city)
                @if ($loop->first)
                    <div class="tab-pane fade show active" id="CT{{ $city->ct_id }}" role="tabpanel"
                        aria-labelledby="CT{{ $city->ct_id }}-tab" tabindex="0">
                        <div class="d-flex scroll-1">
                            @foreach ($city->hotels as $hotel)
                                @php
                                    $firstImage = $hotel->hotel_imgs->firstWhere('hi_vitri', 1);
                                    $imgpath = $firstImage
                                        ? '/images/hotels/h' . $hotel->h_id . '/' . $firstImage->hi_name
                                        : '/images/other/placeholder-image.png';
                                @endphp
                                <div class="card flex-shrink-0 m-3 city-card">
                                    <img src="{{ $imgpath }}" class="card-img-top h-100"
                                        alt="ảnh không tồn tại">
                                    <div class="card-body">
                                        <h5 class="card-title scroll-1">{{ $hotel->h_name }}</h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="tab-pane fade" id="CT{{ $city->ct_id }}" role="tabpanel"
                        aria-labelledby="CT{{ $city->ct_id }}-tab" tabindex="0">
                        <div class="d-flex scroll-1">
                            @foreach ($city->hotels as $hotel)
                                @php
                                    $firstImage = $hotel->hotel_imgs->firstWhere('hi_vitri', 1);
                                    $imgpath = $firstImage
                                        ? '/images/hotels/h' . $hotel->h_id . '/' . $firstImage->hi_name
                                        : '/images/other/placeholder-image.png';
                                @endphp
                                <div class="card flex-shrink-0 m-3 city-card">
                                    <img src="{{ $imgpath }}" class="card-img-top h-100"
                                        alt="ảnh không tồn tại">
                                    <div class="card-body">
                                        <h5 class="card-title scroll-1">{{ $hotel->h_name }}</h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="footer-section col-12 col-md-4">
                    <h4>Liên hệ</h4>
                    <ul>
                        <li>Email: mogiawjbu@gmail.com</li>
                        <li>Điện thoại: 0933-987-800</li>
                        <li>Địa chỉ: Cao lỗ,phường 4 quận 8 tpHCM</li>
                    </ul>
                </div>
                <div class="footer-section col-12 col-md-4">
                    <h4>Liên kết hữu ích</h4>
                    <ul>
                        <li><a href="/user/html_user/lienhe.html">Về chúng tôi</a></li>
                        <li><a href="/user/html_user/loichuc.html">Lời cảm ơn</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                        <li><a href="#">Điều khoản sử dụng</a></li>
                    </ul>
                </div>
                <div class="footer-section col-12 col-md-4">
                    <h4>Theo dõi chúng tôi</h4>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/tiensu.lactroi.3" target="_blank">
                            <i class="bi bi-facebook"  style="font-size: 24px; margin-right: 15px;"></i>
                        </a>
    
                        <a href="#"><i class="bi bi-instagram"  style="font-size: 24px; margin-right: 15px;"></i></a>
                        <a href="#"><i class="bi bi-twitter"  style="font-size: 24px; margin-right: 15px;"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
