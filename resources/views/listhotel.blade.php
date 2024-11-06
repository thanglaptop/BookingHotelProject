<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Booking</title>

    <!-- Link đến file CSS -->
    @vite('resources/css/viewdau.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

    <style>

    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <a href="/user/user.html">
                <img src="/user/image_user/agobeelogo.png" alt="Logo" />
            </a>
        </div>


        <div class="search-bar">
            <input id="search-input" placeholder="Hồ Chí Minh - 5715 nơi ở có phòng" type="text"
                onfocus="showSuggestions()" onblur="hideSuggestions()" />
            <button>Tìm</button>
            <div id="suggestions" class="suggestions">
                <div>Hồ Chí Minh</div>
                <div>Đà Nẵng</div>
                <div>Huế</div>
                <div>Hà Nội</div>
                <div>Vũng Tàu</div>
            </div>
        </div>


        <div class="icons">
            <i class="fas fa-calendar-alt"></i>
            <i class="fas fa-user"></i>
            <i class="fas fa-shopping-cart"></i>
            <i class="fas fa-bars"></i>
        </div>
    </div>

    <div class="nav">
        <a href="#">Sự kiện</a>
        <a class="active" href="#" style="color: blue;">Phòng trống</a>

        <a href="#">Địa điểm</a>
        <a href="#">Khuyến mãi</a>
        <a href="#">Tin tức</a>
    </div>

    <div class="content">
        <div class="sidebar">
            <div class="weather-widget">
                <div class="temp">28°</div>
                <div class="forecast">
                    <div>
                        <i class="fas fa-cloud-showers-heavy"></i>
                        <div>Th5</div>
                        <div>28°</div>
                    </div>
                    <div>
                        <i class="fas fa-cloud-showers-heavy"></i>
                        <div>Th6</div>
                        <div>27°</div>
                    </div>
                    <div>
                        <i class="fas fa-cloud-showers-heavy"></i>
                        <div>Th7</div>
                        <div>27°</div>
                    </div>

                </div>
            </div>
        </div>

        <div class="main-content">
            @foreach ($hotels as $hotel)
                @php
                    $firstImage = $hotel->hotel_imgs->firstWhere('hi_vitri', 1);
                    $imgpath = $firstImage
                        ? '/images/hotels/h' . $hotel->h_id . '/' . $firstImage->hi_name
                        : '/images/other/placeholder-image.png';
                @endphp
                <div class="hotel-card">
                    <img src="{{ $imgpath }}" alt="ảnh không tồn tại" width="200" height="150" />
                    <div class="details">
                        <h3>{{ $hotel->h_name }}</h3>
                        <p class="rating">★★★★☆</p>
                        <p class="location">{{ $hotel->h_dchi }}</p>
                        <p>Cơ sở lưu trú này có:</p>
                        <p>Không cần thẻ tín dụng</p>
                        <p>Thường hoàn tiền nát: 104.551 đ</p>
                        <div class="cta">
                            <div class="cta">
                                <a href="{{ route('showinfohotel', ['id' => $hotel->h_id]) }}">
                                    <button>Xem tất cả</button>
                                </a>
                                <button onclick="openModal()">Đặt phòng</button>
                            </div>
                        </div>
                    </div>
                    <div class="price-details">
                        <p class="rating">7,5 Rất tốt</p>
                        <p>3.020 Nhận xét</p>
                        <p class="availability">Còn 1 phòng GIẢM 01%</p>
                        <p class="old-price">1.841.628 đ</p>
                        <p class="price">346.685 đ</p>
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

                <a href="#"><i class="fab fa-instagram"
                        style="font-size: 24px; color: white; margin-right: 15px;"></i></a>
                <a href="#"><i class="fab fa-twitter" style="font-size: 24px; color: white;"></i></a>
            </div>
        </div>
    </footer>



    </div>
    <!-- bang dat phong -->
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Đặt Phòng</h2>
            <form id="bookingForm">
                <div class="form-group">
                    <label for="name">Họ và tên:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="checkin">Ngày nhận phòng:</label>
                    <input type="date" id="checkin" name="checkin" required>
                </div>
                <div class="form-group">
                    <label for="checkout">Ngày trả phòng:</label>
                    <input type="date" id="checkout" name="checkout" required>
                </div>
                <div class="form-group">
                    <label for="guests">Số lượng khách:</label>
                    <input type="number" id="guests" name="guests" min="1" required>
                </div>
                <button type="submit">Xác nhận đặt phòng</button>
            </form>
        </div>
    </div>


    <!-- bang gi hang -->

    <div id="bookingHistoryModal" class="modal">
        <div class="modal-content">
            <span class="close-history">&times;</span>
            <h2>Lịch Sử Đặt Phòng</h2>
            <div id="bookingHistoryList">
                <!-- Danh sách đặt phòng sẽ được thêm vào đây -->
            </div>
        </div>
    </div>

    <!-- Thêm modal xác nhận hủy đặt phòng -->
    <div id="cancelConfirmModal" class="modal">
        <div class="modal-content" style="max-width: 400px;">
            <h2>Xác Nhận Hủy Đặt Phòng</h2>
            <p>Bạn có chắc chắn muốn hủy đặt phòng này không?</p>
            <div class="confirm-buttons">
                <button id="confirmCancel" class="btn-confirm">Xác nhận hủy</button>
                <button id="cancelCancel" class="btn-cancel">Không hủy</button>
            </div>
        </div>
    </div>
    @vite('resources/js/viewdau.js')
</body>

</html>
