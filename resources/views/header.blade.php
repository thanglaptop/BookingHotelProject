<section class="header">
    <div class="container-fluid">
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-brand">
                    <a style="text-decoration:none;"
                        @if (Auth::guard('owner')->check()) href="{{ route('mainowner') }}"
                        @else href="{{ route('index') }}" @endif>
                        <img src="/images/other/Logo.png">
                    </a>
                    AGOBEE


                </div>
                @if (Auth::guard('owner')->check())
                    <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Chào
                                {{ Auth::guard('owner')->user()->o_name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() == 'mainowner' ? 'active' : '' }}"
                                        href="{{ route('mainowner') }}">Quản lý khách sạn</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() == 'paymentinfo' ? 'active' : '' }}"
                                        href="{{ route('paymentinfo') }}">Thông Tin Thanh Toán</a></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() == 'personalinfo' ? 'active' : '' }}"
                                        href="{{ route('personalinfo') }}">Thông Tin Cá Nhân</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() == 'doanhthu' ? 'active' : '' }}"
                                        href="{{ route('doanhthu') }}">Doanh Thu</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() == 'danhgia' ? 'active' : '' }}"
                                        href="{{ route('danhgia') }}">Đánh Giá</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('customerlogout') }}">Đăng Xuất</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @elseif(Auth::guard('customer')->check())
                    @php
                        $customer = Auth::guard('customer')->user();
                    @endphp
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Chào {{ $customer->c_name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() == 'index' ? 'active' : '' }}"
                                        href="{{ route('index') }}" aria-current="page">Trang Chủ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() == 'giohang' ? 'active' : '' }}" href="{{ route('giohang') }}">Giỏ Hàng</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Đơn Đặt Phòng</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Thông Tin Cá Nhân</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('customerlogout') }}">Đăng Xuất</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <a href="{{ route('loginpage') }}"><button class="btn btn-primary">Đăng nhập/Đăng ký</button></a>
                @endif
            </div>
        </nav>
    </div>
</section>
