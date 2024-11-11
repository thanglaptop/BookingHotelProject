<div class="background"><img src="/images/other/bg.jpg">
    <div class="blur-background"></div>
    <div class="overlay-content">
        <h2 class="text-center p-3">A Good Online Booking Experience</h3>
            <div class="row">
                <div class="col-md-2 col-1"></div>
                <div class="col-md-8 col-10 p-3 search-form">
                    <form action="">
                        <div class="row g-3">
                            <div class="col-12">
                                <h4 class="title-search">Bạn muốn đi đâu, AGOBEE đưa bạn đến!</h4>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control form-control-lg"
                                    placeholder="Nhập địa điểm tên du lịch hoặc tên khách sạn">
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-lg">
                                    <input type="date" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="col-md-6 col-12" id="RoomAndPerson">
                                <div id="popover-toggle" class="form-control form-control-lg"
                                    aria-label="Toggle popover">
                                    1 phòng, 2 người lớn, 0 trẻ em
                                </div>

                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <button class="btn btn-primary btn-lg w-50">Tìm</button>
                            </div>
                        </div>
                    </form>
                    <div class="col-md-2 col-1"></div>
                </div>
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
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <h3 class="mt-5">Các điểm thu hút nhất Việt Nam</h3>
    <div class="d-flex scroll-1">
        @foreach ($cities as $city)
            <div class="card flex-shrink-0 m-3 city-card">
                <img src="/images/cities/{{ $city->ct_img }}" class="card-img-top h-100"
                    alt="ảnh không tồn tại">
                <div class="card-body">
                    <h5 class="card-title">{{ $city->ct_name }}</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Có {{ $city->hotels_count }} chỗ
                        ở</h6>
                </div>
            </div>
        @endforeach
    </div>

    <h3 class="mt-5">Những chỗ nghỉ nổi bật được đề xuất cho quý khách</h3>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            @foreach ($cities as $city)
                @php $active = $loop->first ? "active" : "" @endphp
                <button class="nav-link {{ $active }}" id="CT{{ $city->ct_id }}-tab"
                    data-bs-toggle="tab" data-bs-target="#CT{{ $city->ct_id }}" type="button"
                    role="tab" aria-controls="CT{{ $city->ct_id }}"
                    aria-selected="true">{{ $city->ct_name }}</button>
            @endforeach
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        @foreach ($cities as $city)
            @php $showactive = $loop->first ? "show active" : "" @endphp
            <div class="tab-pane fade {{ $showactive }}" id="CT{{ $city->ct_id }}" role="tabpanel"
                aria-labelledby="CT{{ $city->ct_id }}-tab" tabindex="0">
                <div class="d-flex scroll-1">
                    @foreach ($city->hotels as $hotel)
                        @php
                            $firstImage = $hotel->hotel_imgs->firstWhere('hi_vitri', 1);
                            $imgpath = $firstImage
                                ? '/images/hotels/h' . $hotel->h_id . '/' . $firstImage->hi_name
                                : '/images/other/placeholder-image.png';

                            $minprice = $room->where('h_id', $hotel->h_id)->min('r_price');
                            $maxprice = $room->where('h_id', $hotel->h_id)->max('r_price');
                        @endphp
                        <div class="card flex-shrink-0 m-3 city-card">
                            <img src="{{ $imgpath }}" class="card-img-top h-100"
                                alt="ảnh không tồn tại">
                            <div class="card-body">
                                <h5 class="card-title scroll-1">{{ $hotel->h_name }}</h5>
                                <p style="font-size: 12px;">Giá mỗi đếm chưa bao gồm thuế và phí</p>
                                <h6 class="price">{{ number_format($minprice, 0, ',', '.') }} -
                                    {{ number_format($maxprice, 0, ',', '.') }} VNĐ</h6>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>