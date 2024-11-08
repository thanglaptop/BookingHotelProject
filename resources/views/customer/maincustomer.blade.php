<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGOBEE - Trang web du lịch</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/css/user.css')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    
</head>
<body>
    <header class="header">
        <a href="/user/user.html">
            <div class="">
                <img src="/user/image_user/agobeelogo.png" alt="logo" style="width:80px;height:80px;">
            </div>
        </a>
        
        <nav class="nav-items">
            <a href="#">Chỗ ở</a>
            <a href="#">Cẩm nang du lịch</a>
            <a href="#">Hành trình du lịch</a>
            <a href="#">Hoạt động</a>
        </nav>
        <div class="search-bar">
            <input type="text" placeholder="Tìm kiếm khách sạn">
            <button>Tìm kiếm</button>
        </div>
        <div>
            <a href="#"><i class="fas fa-shopping-cart" style="font-size: 24px; color: black; margin-right: 15px;"></i></a>
            <a href="#"><i class="fas fa-bars" style="font-size: 24px; color: black;"></i></a>
        </div>
    </header>

    <div class="search-container">
        <div class="search-tabs">
            <div class="search-tab">Khách sạn</div>
            <div class="search-tab">Nhà và căn hộ</div>
            <div class="search-tab">Chuyến bay</div>
            <div class="search-tab">Hoạt động</div>
        </div>
        <input type="text" class="search-input" id="location-input" placeholder="Chọn địa điểm">
        <div class="location-dropdown" id="location-dropdown">
            <div onclick="selectLocation('Hồ Chí Minh')">Hồ Chí Minh</div>
            <div onclick="selectLocation('Đà Lạt')">Đà Lạt</div>
            <div onclick="selectLocation('Vũng Tàu')">Vũng Tàu</div>
            <div onclick="selectLocation('Đà Nẵng')">Đà Nẵng</div>
            <div onclick="selectLocation('Hà Nội')">Hà Nội</div>
        </div>
        <div class="date-inputs">
            <input type="text" class="date-input" id="check-in" placeholder="8 tháng 10 2024">
            <input type="text" class="date-input" id="check-out" placeholder="9 tháng 10 2024">
            <div class="guest-input" id="guest-input">1 người lớn, 1 phòng</div>
            <div class="guest-dropdown" id="guest-dropdown">
                <div>
                    <span>Người lớn: </span>
                    <button onclick="changeGuests('adults', -1)">-</button>
                    <span id="adults-count">1</span>
                    <button onclick="changeGuests('adults', 1)">+</button>
                </div>
                <div>
                    <span>Phòng: </span>
                    <button onclick="changeGuests('rooms', -1)">-</button>
                    <span id="rooms-count">1</span>
                    <button onclick="changeGuests('rooms', 1)">+</button>
                </div>
            </div>
        </div>
    </div>

    <div class="destinations ">
        <h2>Các điểm thu hút nhất Việt Nam</h2>
        <div class="destination-grid scroll-1">
            @foreach($cityHasHotels as $city)
            <div class="destination-card">
                <img src="/images/cities/{{$city->ct_img}}" alt="ảnh không tồn tại">
                <div class="destination-info">
                    <a href="{{ route('showlisthotel', ['id' => $city->ct_id]) }}">
                        <h3>{{$city->ct_name}}</h3>
                    </a>
                    
                    <p>{{$city->hotels_count}} chỗ ở</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <footer class="footer">
        <div class="footer-section">
            <h4>Liên hệ</h4>
            <ul>
                <li>Email: mogiawjbu@gmail.com</li>
                <li>Điện thoại: 0933-987-800</li>
                <li>Địa chỉ: Cao lỗ,phường 4 quận 8 tpHCM</li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Liên kết hữu ích</h4>
            <ul>
                <li><a href="/user/html_user/lienhe.html">Về chúng tôi</a></li>
                <li><a href="/user/html_user/loichuc.html">Lời cảm ơn</a></li>
                <li><a href="#">Chính sách bảo mật</a></li>
                <li><a href="#">Điều khoản sử dụng</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Theo dõi chúng tôi</h4>
            <div class="social-icons">
                <a href="https://www.facebook.com/tiensu.lactroi.3" target="_blank">
                    <i class="fab fa-facebook-f" style="font-size: 24px; color: white; margin-right: 15px;"></i>
                </a>
                
                <a href="#"><i class="fab fa-instagram" style="font-size: 24px; color: white; margin-right: 15px;" ></i></a>
                <a href="#"><i class="fab fa-twitter" style="font-size: 24px; color: white;"></i></a>
            </div>
        </div>
    </footer>
    @vite('resources/js/user.js')
</body>
</html>