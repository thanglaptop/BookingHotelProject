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
                @if (session('successlogin'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('successlogin') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('errorddp'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('errorddp') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('successddp'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('successddp') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
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
                                    <a class="nav-link {{ Route::currentRouteName() == 'managenv' ? 'active' : '' }}"
                                        href="{{ route('managenv') }}">Quản Lý Nhân Viên</a></a>
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
                        $soluongphong = count($customer->hasManyRoomInGiohang);
                    @endphp
                    <button class="navbar-toggler position-relative" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation"
                        id="btn-nav">
                        @if ($soluongphong != null)
                            <span
                                class="position-absolute top-0 start-100 translate-middle p-2 bg-danger rounded-circle">
                            </span>
                        @endif
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
                                    <a class="nav-link {{ Route::currentRouteName() == 'cart' ? 'active' : '' }}"
                                        href="{{ route('cart') }}" id="cart-count"> Giỏ hàng
                                        @if ($soluongphong != null)
                                            <span class="badge text-bg-danger">{{ $soluongphong }}</span>
                                        @endif
                                    </a>

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
                    @elseif(Auth::guard('employee')->check())
                    @php
                        $employee = Auth::guard('employee')->user();
                    @endphp
                    <button class="navbar-toggler position-relative" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation"
                        id="btn-nav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Chào {{ $employee->e_name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('employeelogout') }}">Đăng Xuất</a>
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
