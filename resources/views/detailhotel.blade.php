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
                <form action="{{ route('searchplace') }}" method="GET">
                    <div class="row d-flex g-2">
                        <div class="col-lg-1 col-12 d-flex align-items-center">
                            <a href="{{ session('previous_listhotel', route('index')) }}">
                                <button type="button" class="btn btn-danger">trở
                                    về</button></a>
                        </div>
                        <div class="col-lg-3 col-12"><input type="text" name="search"
                                class="form-control form-control-lg h-100"
                                placeholder="Nhập địa điểm tên du lịch hoặc tên khách sạn" value="{{ $hotel->h_name }}">
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="input-group h-100">
                                <input id="inputCin" type="date" name="checkin" class="form-control form-control-lg"
                                    value="{{ $checkin }}">
                                <input id="inputCout" type="date" name="checkout"
                                    class="form-control form-control-lg" value="{{ $checkout }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-12" id="RoomAndPerson">
                            <div id="popover-toggle" class="form-control form-control-lg h-100 d-flex scroll-1"
                                aria-label="Toggle popover">
                                {{ $slphong }} phòng, {{ $sladult }} người lớn, {{ $slkid }} trẻ em
                            </div>
                            <input type="hidden" value="{{ $slphong }}" name="room" id="room">
                            <input type="hidden" value="{{ $sladult }}" name="adult" id="adult">
                            <input type="hidden" value="{{ $slkid }}" name="kid" id="kid">
                        </div>
                        <div class="col-lg-1 col-12 text-center"><button class="btn btn-primary btn-lg">Tìm</button>
                        </div>
                    </div>
                </form>
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
                    <span class="star"><i class="bi bi-star-fill"> {{ $hotel->average_star }} <a
                                style="color: goldenrod;" href="{{ route('seedanhgia', ['hid' => $hotel->h_id]) }}">xem
                                đánh giá</a></i>
                    </span>
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
                    @foreach ($hotel->dsTienNghi()->where('tn_ofhotel', 1)->get() as $tn)
                        <span><i class="bi bi-check-lg"></i> {{ $tn->tn_name }}</span>
                    @endforeach
                </div>
            </div>
            <div class="mt-4">
                <h3>Hãy chọn phòng bạn muốn</h3>
                @foreach ($hotel->rooms as $room)
                    @php
                        if ($room->r_id <= 135) {
                            $phandu = $room->r_id % 5;
                            if ($phandu != 0) {
                                $roomnumber = $phandu;
                            } else {
                                $roomnumber = 5;
                            }
                        } else {
                            $roomnumber = $room->r_id;
                        }
                        $allow = '';
                        if ($room->r_maxadult != 0 && $room->r_maxkid != 0) {
                            $allow = $room->r_maxadult . ' người lớn, ' . $room->r_maxkid . ' trẻ em';
                        } elseif ($room->r_maxadult != 0 && $room->r_maxkid == 0) {
                            $allow = $room->r_maxadult . ' người lớn';
                        } else {
                            $allow = $room->r_maxperson . ' người lớn và trẻ em';
                        }
                        $conlai = $listroom->firstWhere('r_id', $room->r_id)['r_conlai'] ?? 0;
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
                            <div class="address">tối đa: {{ $allow }} | {{ $room->r_dientich }}m<sup>2</sup> |
                                còn lại: {{ $conlai }} phòng</div>
                            <div class="col-12">
                                <h6>Mô tả</h6>
                                <div>{{ $room->r_mota }}</div>
                            </div>
                            <div class="col-12">
                                <h6>Tiện nghi của phòng</h6>
                                <div class="d-flex scroll-1 gap-3">
                                    @foreach ($room->dsTienNghi()->where('tn_ofhotel', 0)->get() as $tn)
                                        <span><i class="bi bi-check-lg"></i> {{ $tn->tn_name }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <h4 class="col-md-3 col-12 price" style="white-space: nowrap;">Giá:
                                {{ number_format($room->r_price, 0, ',', '.') }} VNĐ</h4>
                            <div class="col-12 row">
                                @php
                                    $ngaycheckin = $checkin ?? date('Y-m-d');
                                    $ngaycheckout = $checkout ?? date('Y-m-d');
                                @endphp
                                @if (Auth::guard('customer')->check() &&
                                        (($ngaycheckin >= $room->r_dateclose && $ngaycheckin < $room->r_dateopen) ||
                                            ($ngaycheckout >= $room->r_dateclose && $ngaycheckout <= $room->r_dateopen)))
                                    <button class="btn btn-danger">Đang đóng cửa</button>
                                @elseif (Auth::guard('customer')->check() &&
                                        (($ngaycheckin < $hotel->h_dateclose && $ngaycheckout < $hotel->h_dateclose) ||
                                            ($ngaycheckout >= $hotel->h_dateopen && $ngaycheckin >= $hotel->h_dateopen)))
                                    <div class="col-6 p-1">
                                        <form action="{{ route('booknow') }}" method="GET">
                                            <input type="hidden" name="hotel" value="{{$room->h_id}}">
                                            <input type="hidden" name="room" value="{{$room->r_id}}">
                                            <input type="hidden" name="checkin" value="{{$checkin ?? date('Y-m-d')}}">
                                            <input type="hidden" name="checkout" value="{{$checkout ?? date('Y-m-d', strtotime('+1 day'))}}">
                                        <button class="btn btn-primary w-100" @if($conlai <= 0) disabled @endif>Đặt ngay</button></form>
                                    </div>
                                    <div class="col-6 p-1"><button id="add-to-cart" data-room-id="{{ $room->r_id }}"
                                            data-checkin="{{ $checkin ?? date('Y-m-d') }}"
                                            data-checkout="{{ $checkout ?? date('Y-m-d', strtotime('+1 day')) }}"
                                            data-conlai = "{{ $conlai }}"
                                            class="btn btn-outline-primary col-6 w-100" @if($conlai <= 0) disabled @endif>Thêm vào giỏ hàng</button></div>
                                @elseif(Auth::guard('customer')->check() &&
                                        (($ngaycheckin >= $hotel->h_dateclose && $ngaycheckin < $hotel->h_dateopen) ||
                                            ($ngaycheckout >= $hotel->h_dateclose && $ngaycheckout <= $hotel->h_dateopen)))
                                    <button class="btn btn-danger">Đang đóng cửa</button>
                                @else
                                    <a href="{{ route('loginpage') }}"><button class="btn btn-primary w-100">Đăng
                                            nhập</button></a>
                                @endif
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
    <div class="position-fixed top-50 start-50 translate-middle" style="z-index: 1050;">
        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="dangerToast">
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
            let reqcheckin = $(this).data('checkin');
            let reqcheckout = $(this).data('checkout');
            let phongconlai = $(this).data('conlai');
            $.ajax({
                url: '{{ route('addtocart') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    room_id: roomID,
                    checkin: reqcheckin,
                    checkout: reqcheckout,
                    conlai: phongconlai
                },
                success: function(response) {
                    if (response.error) {
                        console.log("error");
                        // Hiển thị toast
                        let toastBody = $('#dangerToast .toast-body');
                        toastBody.html(
                            '<i class="bi bi-x-circle me-1" id="checkIcon" style="font-size: 3rem;"></i>' +
                            response.message); // Cập nhật thông báo
                        let toastElement = document.getElementById('dangerToast');
                        let toast = new bootstrap.Toast(toastElement, {
                            delay: 500
                        });

                        toast.show();
                    } else {
                        // Hiển thị toast
                        let toastBody = $('#successToast .toast-body');
                        toastBody.html(
                            '<i class="bi bi-check-circle me-1" id="checkIcon" style="font-size: 3rem;"></i>' +
                            response.message); // Cập nhật thông báo
                        let toastElement = document.getElementById('successToast');
                        let toast = new bootstrap.Toast(toastElement, {
                            delay: 500
                        });

                        toast.show();
                        // Cập nhật số lượng giỏ hàng trong header
                        $('#btn-nav').html(
                            '<span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger rounded-circle"></span><span class="navbar-toggler-icon"></span>'
                        );
                        $('#cart-count').html('Giỏ Hàng <span class="badge text-bg-danger">' + response
                            .cartCount + '</span>'); // #cart-count là ID phần tử hiển thị số lượng
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
    <script>
        window.handleDateChange = function() {
            const checkinInput = document.getElementById("inputCin");
            const checkoutInput = document.getElementById("inputCout");

            const checkinDateStr = checkinInput.value;
            const checkoutDateStr = checkoutInput.value;

            const checkinDate = new Date(checkinDateStr);
            const checkoutDate = new Date(checkoutDateStr);

            // Kiểm tra nếu ngày check-out < ngày check-in
            if (checkoutDateStr && checkoutDate < checkinDate) {
                // alert("Ngày check-out không được nhỏ hơn hoặc bằng ngày check-in.");
                checkoutInput.value = ""; // Reset ngày check-out
                return;
            }

            // Nếu ngày check-in > ngày check-out
            if (checkinDateStr && checkoutDateStr && checkinDate > checkoutDate) {
                // alert("Ngày check-in không được lớn hơn hoặc bằng ngày check-out.");
                checkoutInput.value = ""; // Reset ngày check-out
                return;
            }
        };

        // Lắng nghe sự kiện thay đổi ngày check-in và check-out
        document.getElementById("inputCin").addEventListener('change', handleDateChange);
        document.getElementById("inputCout").addEventListener('change', handleDateChange);
    </script>
    @vite('resources/js/customer.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
