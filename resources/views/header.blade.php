<section class="header">
    <div class="container-fluid">
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-brand">
                    <img src="/images/other/Logo.png">
                    AGOBEE
                </div>
                @if (Route::currentRouteName() == 'mainowner')
                    <h6 class="mx-auto">Chào {{ $owner->o_name }}</h6>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="QLKS-tab" data-bs-toggle="tab"
                                        data-bs-target="#QLKS" type="button" role="tab" aria-controls="QLKS"
                                        aria-selected="true">Quản Lý Khách
                                        Sạn</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="TTTT-tab" data-bs-toggle="tab" data-bs-target="#TTTT"
                                        type="button" role="tab" aria-controls="TTTT" aria-selected="true">Thông
                                        Tin
                                        Thanh Toán</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="TTCN-tab" data-bs-toggle="tab" data-bs-target="#TTCN"
                                        type="button" role="tab" aria-controls="TTCN" aria-selected="false">Thông
                                        Tin
                                        Cá
                                        Nhân</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="DT-tab" data-bs-toggle="tab" data-bs-target="#DT"
                                        type="button" role="tab" aria-controls="DT" aria-selected="false">Doanh
                                        Thu</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="DG-tab" data-bs-toggle="tab" data-bs-target="#DG"
                                        type="button" role="tab" aria-controls="DG" aria-selected="false">Đánh
                                        Giá</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="{{ Route('loginpage') }}" style="text-decoration: none;"><button
                                            class="nav-link" type="button" role="tab" aria-selected="false">Đăng
                                            Xuất</button></a>

                                </li>
                            </ul>
                        </div>
                    </div>
                @elseif(Route::currentRouteName() == 'index')
                    <a href="{{ route('loginpage') }}"><button class="btn btn-primary">Đăng nhập/Đăng ký</button></a>
                @elseif(Route::currentRouteName() == 'maincustomer')
                    <h6 class="mx-auto">Chào {{ $customer->c_name }}</h6>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" id="myTab"
                                role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="TrangChu-tab" data-bs-toggle="tab"
                                        data-bs-target="#TrangChu" type="button" role="tab" aria-controls="TrangChu"
                                        aria-selected="true">Trang Chủ</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="GH-tab" data-bs-toggle="tab"
                                        data-bs-target="#GH" type="button" role="tab" aria-controls="GH"
                                        aria-selected="false">Giỏ Hàng</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="DDP-tab" data-bs-toggle="tab"
                                        data-bs-target="#DDP" type="button" role="tab" aria-controls="DDP"
                                        aria-selected="false">Đơn Đặt Phòng</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="TTCN-tab" data-bs-toggle="tab"
                                        data-bs-target="#TTCN" type="button" role="tab" aria-controls="TTCN"
                                        aria-selected="false">Thông Tin Cá Nhân</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="{{ Route('loginpage') }}" style="text-decoration: none;"><button
                                            class="nav-link" type="button" role="tab"
                                            aria-selected="false">Đăng
                                            Xuất</button></a>

                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    @php
                        $hotelname = isset($hotel) ? $hotel->h_name : $room->hotel->h_name;
                    @endphp
                    <h4 class="mx-auto">{{ $hotelname }}</h4>
                @endif
            </div>
        </nav>
    </div>
</section>
