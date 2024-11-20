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
    {{-- script ajax --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>AGOBEE</title>
</head>

<body>
    @include('header')

    <section>
        <div class="searchbar">
            <div class="container">
                <div class="row d-flex g-2">
                    <div class="col-lg-4 col-12"><input type="text" class="form-control form-control-lg h-100"
                            placeholder="Nhập địa điểm tên du lịch hoặc tên khách sạn" value="{{ $hotel->h_name }}">
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="input-group h-100">
                            <input type="date" class="form-control form-control-lg" value="{{ date('Y-m-d') }}">
                            <input type="date" class="form-control form-control-lg"
                                value="{{ date('Y-m-d', strtotime('+1 day')) }}">
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
            <div class="scroll-1 image-detail-hotel rounded-4">
                @foreach ($hotel->hotel_imgs as $img)
                    <img src="/images/hotels/h{{ $hotel->h_id }}/{{ $img->hi_name }}">
                @endforeach
            </div>
            <div class="border border-secondary-subtle p-4 mt-4 rounded">
                <h3>{{ $hotel->h_name }}</h3>
                <div class="d-flex gap-4">
                    <span class="star"> <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i></span>
                    <span>
                        <i class="bi bi-house-heart-fill"></i>
                        <span>{{ $hotel->loaihinh->lh_name }}</span>
                    </span>

                </div>
                <div class="address"><i class="bi bi-geo-alt-fill"></i> {{ $hotel->h_dchi }}</div>
                <hr>
                <div>{{ $hotel->h_mota }}</div>
            </div>
            <div class="border border-secondary-subtle p-4 rounded mt-2">
                <h4>Tiện nghi của khách sạn</h4>
                <div class="d-flex scroll-1 gap-3">
                    @for ($i = 0; $i < 10; $i++)
                        <div><i class="bi bi-check-lg"></i> bồn tắm</div>
                    @endfor
                </div>
            </div>
            <div class="mt-4">
                <h3>Hãy chọn phòng bạn muốn</h3>
                @foreach ($hotel->rooms as $room)
                    @php
                        $phandu = $room->r_id % 5;
                        if ($phandu != 0) {
                            $roomnumber = $phandu;
                        } else {
                            $roomnumber = 5;
                        }
                    @endphp
                    <div class="card hotel-detail mb-4 mt-3">
                        <div class="scroll-1 scrollimage">
                            @foreach ($room->room_imgs as $img)
                                <img src="/images/hotels/h{{ $hotel->h_id }}/room/r{{ $roomnumber }}/{{ $img->ri_name }}"
                                    class="card-img-top">
                            @endforeach
                        </div>
                        <div class="card-body row g-2">
                            <h4 class="card-title col-12">{{ $room->r_name }}</h4>
                            <div class="address">tối đa mấy người | 22m vuông | còn lại: 5 phòng</div>
                            <div class="col-12">
                                <h6>Mô tả</h6>
                                <div>{{ $room->r_mota }}</div>
                            </div>
                            <div class="col-12">
                                <h6>Tiện nghi của phòng</h6>
                                <div class="d-flex scroll-1 gap-3">
                                    @for ($i = 0; $i < 10; $i++)
                                        <div><i class="bi bi-check-lg"></i> bồn tắm</div>
                                    @endfor
                                </div>
                            </div>
                            <h4 class="col-md-3 col-12 price" style="white-space: nowrap;">Giá:
                                {{ number_format($room->r_price, 0, ',', '.') }} VNĐ</h4>
                            <div class="col-12 row">
                                <div class="col-6 p-1">
                                    <button class="btn btn-primary w-100">Đặt ngay</button>
                                </div>
                                <div class="col-6 p-1"><button id="add-to-cart" data-room-id="{{ $room->r_id }}"
                                        class="btn btn-outline-primary col-6 w-100">Thêm vào giỏ hàng</button></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    @include('footer')
    <div class="position-fixed top-50 start-50 translate-middle" style="z-index: 1050;">
        <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="successToast">
            <div class="d-flex">
                <h4 class="toast-body text-center d-flex">
                    <!-- Nơi sẽ cập nhật thông báo từ AJAX -->
                </h4>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>


    <script>
        $(document).on('click', '#add-to-cart', function() {
            let roomID = $(this).data('room-id');

            $.ajax({
                url: '{{ route('addtocart') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    room_id: roomID
                },
                success: function(response) {
                    // Hiển thị toast
                    let toastBody = $('#successToast .toast-body');
                    toastBody.html(
                        '<i class="bi bi-check-circle me-1" id="checkIcon" style="font-size: 3rem;"></i>' +
                        response.message); // Cập nhật thông báo
                    let toastElement = document.getElementById('successToast');
                    let toast = new bootstrap.Toast(toastElement, {
                        delay: 2000
                    });

                    toast.show();
                    // Cập nhật số lượng giỏ hàng trong header
                    $('#btn-nav').html('<span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger rounded-circle"></span><span class="navbar-toggler-icon"></span>');
                    $('#cart-count').html('Giỏ Hàng <span class="badge text-bg-danger">'+ response.cartCount +'</span>'); // #cart-count là ID phần tử hiển thị số lượng
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
    @vite('resources/js/customer.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>