<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pool View Studio with Kitchenette</title>
    <link rel="stylesheet" href="/user/styles_user/view.css">
    @vite('resources/css/view.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>

</head>
<body>
    <div class="container">
        <div class="header">
            {{ $hotel->h_name}}
        </div>
        <div class="main-content">
            <div class="image-section">
                @php
                    $firstImage = $hotel->hotel_imgs->firstWhere('hi_vitri', 1);
                    $imgpath = $firstImage
                        ? '/images/hotels/h' . $hotel->h_id . '/' . $firstImage->hi_name
                        : '/images/other/placeholder-image.png';
                @endphp
                <img alt="ảnh không tồn tại" src="{{$imgpath}}"/>
            </div>
            <div class="details-section">
                <h3>Mô tả:</h3>
                <p>{{ $hotel->h_mota}}</p>
                <h3>Cơ sở vật chất:</h3>
                <ul>
                    <li><i class="fas fa-bed"></i> 1 giường đôi lớn &amp; 1 giường sofa</li>
                    <li><i class="fas fa-ruler-combined"></i> Diện tích phòng: 19 m²</li>
                    <li><i class="fas fa-swimming-pool"></i> Hướng Bể bơi</li>
                    <li><i class="fas fa-umbrella-beach"></i> Ban công/sân hiên</li>
                    <li><i class="fas fa-smoking-ban"></i> Không hút thuốc</li>
                    <li><i class="fas fa-shower"></i> Bồn tắm/vòi sen riêng</li>
                    <li><i class="fas fa-swimmer"></i> Bể bơi riêng</li>
                    <li><i class="fas fa-utensils"></i> Bếp nhỏ</li>
                    <li><i class="fas fa-wifi"></i> Wifi miễn phí</li>
                </ul>
            </div>
        </div>
        <div class="footer">
            <div class="thumbnails">
                @forEach($hotel->hotel_imgs as $img)
                <img alt="Thumbnail image 1" src="/images/hotels/h{{$hotel->h_id}}/{{$img->hi_name}}" />
                @endforeach
                
            </div>
        </div>

        

        <!-- Modal to display larger images -->
        <div id="imageModal" class="modal">
            <span class="close" onclick="closeModal()">&times;</span>
            <img class="modal-content" id="modalImage" />
        </div>
        
        <script>
            function openModal(src) {
                document.getElementById("imageModal").style.display = "flex"; // Sử dụng flexbox để căn giữa
                document.getElementById("modalImage").src = src;
            }

            function closeModal() {
                document.getElementById("imageModal").style.display = "none";
            }

            // Gán sự kiện click cho tất cả các ảnh thumbnail
            const thumbnails = document.querySelectorAll('.thumbnails img');
            thumbnails.forEach(img => {
                img.addEventListener('click', () => {
                    openModal(img.src);
                });
            });

            // Đóng modal khi nhấp ra ngoài hình ảnh
            window.addEventListener('click', (event) => {
                const modal = document.getElementById("imageModal");
                if (event.target === modal) {
                    closeModal();
                }
            });
        </script>
    </div>
</body>
</html>
