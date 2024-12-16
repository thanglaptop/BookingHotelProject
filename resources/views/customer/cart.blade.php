<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- css --}}
    @vite('resources/css/customer.css')

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

    <form action="{{ route('checkout') }}" method="GET">
        <section class="container p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 id="quantityInCart">Giỏ Hàng @if (count($listroom) != 0)
                        ({{ count($listroom) }} phòng)
                    @endif
                </h1>
                <div>
                    <button type="submit" class="btn btn-primary" @if ($listroom->isEmpty()) disabled @endif>Đặt
                        Đơn</button>
                </div>
            </div>

            <hr>
            <div class="row mt-4">
                @if ($listroom->isEmpty())
                    <div class="d-flex flex-column align-items-center">
                        <img src="/images/other/find.png" style="width:300px; height:300px">
                        <h3>Bạn chưa có đơn đơn nào trong giỏ hàng</h3>
                    </div>
                @else
                    @php
                        $grouped = [];

                        // Nhóm các ngày checkin và checkout
                        foreach ($listroom as $room) {
                            $key = $room->pivot->g_checkin . ' to ' . $room->pivot->g_checkout; // Tạo key để nhóm các phần tử lại với nhau
                            if (!isset($grouped[$key])) {
                                $grouped[$key] = [];
                            }
                            $grouped[$key][] = $room;
                        }

                        // Lấy kết quả
                        $uniqueDates = array_keys($grouped);

                    @endphp
                    @for ($i = 0; $i < count($uniqueDates); $i++)
                        @foreach ($listhotel as $hotel)
                            @php
                                $listroomavailable = [];
                            @endphp
                            @foreach ($listroom as $room)
                                @php
                                    $ngay = $room->pivot->g_checkin . ' to ' . $room->pivot->g_checkout;
                                @endphp
                                @if ($room->h_id == $hotel->h_id && $ngay == $uniqueDates[$i])
                                    @php
                                        $kochodatviquasoluong = false;
                                        $kochodatviquangay = false;
                                        $conlai = 0; // Giá trị mặc định nếu không tìm thấy
                                        foreach ($listroomwithremain as $roomData) {
                                            $ngaykt = $roomData['checkin'] . ' to ' . $roomData['checkout'];
                                            if ($roomData['r_id'] == $room->r_id && $ngaykt == $ngay) {
                                                $conlai = $roomData['r_conlai'];
                                                break; // Thoát vòng lặp sau khi tìm thấy
                                            }
                                        }
                                        if ($room->pivot->g_soluong > $conlai) {
                                            $kochodatviquasoluong = true;
                                            $hotelId = $hotel->h_id;
                                        }

                                        if ($room->pivot->g_checkin < date('Y-m-d')) {
                                            $kochodatviquangay = true;
                                            $hotelId = $hotel->h_id;
                                        }
                                        $tongcong = 0;
                                        $listroomavailable[] = $room;
                                    @endphp
                                @endif
                            @endforeach
                            @if ($listroomavailable != [])
                                <div class="border p-2 mb-3 border-secondary rounded-3">
                                    <div class="d-flex align-items-center">
                                        @php
                                            $cinAndcout = explode(' to ', $uniqueDates[$i]);
                                            $cinAndcout[] = $hotel->h_id;
                                            $infoddp = implode(',', $cinAndcout);
                                        @endphp
                                        <input id="ck{{ $hotel->h_id }}" class="form-check-input border-secondary"
                                            type="checkbox" name="listhotel[]" value="{{ $infoddp }}"
                                            @if (($kochodatviquasoluong && $hotel->h_id == $hotelId) || ($kochodatviquangay && $hotel->h_id == $hotelId)) disabled @endif>
                                        <h3 class="mb-0 ms-2"><a style="text-decoration:none;"
                                                href="{{ route('showdetailhotel', ['id' => $hotel->h_id]) }}">{{ $hotel->h_name }}</a>
                                            (<i class="bi bi-geo-alt-fill"></i>
                                            {{ $hotel->city->ct_name }})
                                        </h3>
                                    </div>
                                    @foreach ($listroom as $room)
                                        @php
                                            $ngay = $room->pivot->g_checkin . ' to ' . $room->pivot->g_checkout;
                                        @endphp
                                        @if ($room->h_id == $hotel->h_id && $ngay == $uniqueDates[$i])
                                            @php

                                                $firstImage = $room->room_imgs->firstWhere('ri_vitri', 1);
                                                $phandu = $room->r_id % 5;
                                                if ($phandu != 0) {
                                                    $roomnumber = $phandu;
                                                } else {
                                                    $roomnumber = 5;
                                                }
                                                $roomimgsrc =
                                                    '/images/hotels/h' .
                                                    $hotel->h_id .
                                                    '/room/r' .
                                                    $roomnumber .
                                                    '/' .
                                                    $firstImage->ri_name;

                                                $daycheckin = date(
                                                    '\\n\gà\y j \\t\há\n\g n \\n\ă\m Y',
                                                    strtotime($room->pivot->g_checkin),
                                                );
                                                $daycheckout = date(
                                                    '\\n\gà\y j \\t\há\n\g n \\n\ă\m Y',
                                                    strtotime($room->pivot->g_checkout),
                                                );
                                                $checkin = $room->pivot->g_checkin;
                                                $checkout = $room->pivot->g_checkout;
                                                $allow = '';
                                                if ($room->r_maxadult != 0 && $room->r_maxkid != 0) {
                                                    $allow =
                                                        $room->r_maxadult .
                                                        ' người lớn, ' .
                                                        $room->r_maxkid .
                                                        ' trẻ em';
                                                } elseif ($room->r_maxadult != 0 && $room->r_maxkid == 0) {
                                                    $allow = $room->r_maxadult . ' người lớn';
                                                } else {
                                                    $allow = $room->r_maxperson . ' người lớn và trẻ em';
                                                }
                                                $conlai = 0; // Giá trị mặc định nếu không tìm thấy
                                                foreach ($listroomwithremain as $roomData) {
                                                    $ngaykt = $roomData['checkin'] . ' to ' . $roomData['checkout'];
                                                    if ($roomData['r_id'] == $room->r_id && $ngaykt == $ngay) {
                                                        $conlai = $roomData['r_conlai'];
                                                        break; // Thoát vòng lặp sau khi tìm thấy
                                                    }
                                                }
                                                $days = (strtotime($checkout) - strtotime($checkin)) / (60 * 60 * 24);
                                                $total = $room->r_price * $days * $room->pivot->g_soluong;
                                                $tongcong += $total;

                                            @endphp
                                            <div class="border border-secondary-subtle rounded-3 m-2">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-3 col-4">
                                                        <img src="{{ $roomimgsrc }}" class="imgcart w-100 h-100">
                                                    </div>
                                                    <div class="col-lg-10 col-md-9 col-8 p-2">
                                                        <div class="d-flex justify-content-between">
                                                            <h5>{{ $room->r_name }}</h5>
                                                            <i class="bi bi-trash3 me-3" id="remove-room"
                                                                data-room-id="{{ $room->r_id }}"
                                                                data-checkin="{{ $checkin }}"
                                                                data-checkout="{{ $checkout }}"
                                                                style="cursor: pointer;"></i>
                                                        </div>
                                                        <div class="me-2"><small><i class="bi bi-calendar2-check"></i>
                                                                {{ $daycheckin }} <i class="bi bi-arrow-right"></i>
                                                                {{ $daycheckout }}</small></div>
                                                        @if ($kochodatviquangay)
                                                            <div class="text-danger">Không thể đặt đơn có ngày checkin
                                                                dưới ngày {{ date('d/m/Y') }}</div>
                                                        @elseif($kochodatviquasoluong)
                                                            <div class="text-danger">Không thể đặt đơn có số lượng nhiều
                                                                hơn số lượng còn lại</div>
                                                        @else
                                                            <div class="me-2"><small><i class="bi bi-person"></i> tối
                                                                    đa:
                                                                    {{ $allow }}/phòng || còn lại:
                                                                    {{ $conlai }}</small>
                                                            </div>
                                                            <div class="mt-2">
                                                                <button type="button" id="minus-quantity"
                                                                @if ($room->pivot->g_soluong <= $conlai) disabled @endif
                                                                    data-room-id="{{ $room->r_id }}"
                                                                    data-hotel-id="{{ $room->h_id }}"
                                                                    data-room-conlai="{{ $conlai }}"
                                                                    data-room-price="{{ $room->r_price }}"
                                                                    data-checkin="{{ $checkin }}"
                                                                    data-checkout="{{ $checkout }}"
                                                                    class="btn btn-outline-secondary btn-sm rounded-3"><i
                                                                        class="bi bi-dash-lg"></i></i></button>
                                                                <span
                                                                    id="sl{{ $room->r_id }}{{ $checkin }}{{ $checkout }}">{{ $room->pivot->g_soluong }}</span>
                                                                <button type="button" id="add-quantity"
                                                                    @if ($room->pivot->g_soluong >= $conlai) disabled @endif
                                                                    data-room-id="{{ $room->r_id }}"
                                                                    data-room-conlai="{{ $conlai }}"
                                                                    data-room-price="{{ $room->r_price }}"
                                                                    data-checkin="{{ $checkin }}"
                                                                    data-checkout="{{ $checkout }}"
                                                                    class="btn btn-outline-secondary btn-sm rounded-3"><i
                                                                        class="bi bi-plus-lg"></i></button>
                                                            </div>
                                                            <h5 id="total{{ $room->r_id }}{{ $checkin }}{{ $checkout }}"
                                                                class="mt-2">Thành
                                                                tiền:
                                                                {{ number_format($total, 0, ',', '.') }} VNĐ</h5>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if (!$kochodatviquasoluong)

                                    @elseif(!$kochodatviquangay)

                                    @else
                                        <h4 id="tongcong{{ $checkin }}{{ $checkout }}" class="text-end me-2">
                                            Tổng cộng:
                                            {{ number_format($tongcong, 0, ',', '.') }} VNĐ</h4>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    @endfor
                    <div style="height: 120px;"></div>
                @endif
            </div>
    </form>
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
        $(document).on('click', '#add-quantity', function() {
            let roomID = $(this).data('room-id');
            let conlai = $(this).data('room-conlai');
            let roomprice = $(this).data('room-price');
            let ngaycheckin = $(this).data('checkin');
            let ngaycheckout = $(this).data('checkout');
            let totalElement = $(`#total${roomID}${ngaycheckin}${ngaycheckout}`); // Lấy phần tử hiển thị thành tiền
            let tongcong = $(`#tongcong${ngaycheckin}${ngaycheckout}`);
            let addButton = $(this);
            $.ajax({
                url: '{{ route('addtocart') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    room_id: roomID,
                    checkin: ngaycheckin,
                    checkout: ngaycheckout,
                    conlai : conlai
                },
                success: function(response) {
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
                    // Tính toán thành tiền mới
                    let newTotal = response.newquantity * roomprice; // Tính lại tổng giá trị
                    totalElement.html(`Thành tiền: ${newTotal.toLocaleString()} VNĐ`);

                    // Lấy giá trị "Tổng cộng" hiện tại
                    let currentTongCong = parseInt(tongcong.text().replace(/\D/g, '')) || 0;
                    // Tính toán giá trị mới cho "Tổng cộng"
                    let updatedTongCong = currentTongCong + roomprice;

                    // Cập nhật giá trị "Tổng cộng"
                    tongcong.html(`Tổng cộng: ${updatedTongCong.toLocaleString()} VNĐ`);
                    // Cập nhật số lượng giỏ hàng trong header
                    $(`#sl${roomID}${ngaycheckin}${ngaycheckout}`).html(response.newquantity);
                    // Kiểm tra nếu số lượng đã đạt giới hạn (conlai)
                    if (response.newquantity >= conlai) {
                        addButton.prop('disabled', true); // Vô hiệu hóa nút "Thêm"
                    }

                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        $(document).on('click', '#minus-quantity', function() {
            let roomID = $(this).data('room-id');
            let minusButton = $(this);
            let hotelId = $(this).data('hotel-id');
            let conlai = $(this).data('room-conlai');
            let roomprice = $(this).data('room-price');
            let ngaycheckin = $(this).data('checkin');
            let ngaycheckout = $(this).data('checkout');
            let totalElement = $(`#total${roomID}${ngaycheckin}${ngaycheckout}`); // Lấy phần tử hiển thị thành tiền
            let tongcong = $(`#tongcong${ngaycheckin}${ngaycheckout}`);
            $.ajax({
                url: '{{ route('decreasetocart') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    room_id: roomID,
                    checkin: ngaycheckin,
                    checkout: ngaycheckout
                },
                success: function(response) {
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
                    $(`#sl${roomID}${ngaycheckin}${ngaycheckout}`).html(response.newquantity);
                    // Kiểm tra nếu số lượng đã đạt giới hạn (conlai)
                    if (response.newquantity <= 1) {
                        minusButton.prop('disabled', true); // Vô hiệu hóa nút "Thêm"
                    }
                    // Kiểm tra nếu số lượng mới <= conlai thì bỏ disabled cho checkbox
                    let hotelCheckbox = $(`#ck${hotelId}`);
                    if (response.newquantity <= conlai) {
                        hotelCheckbox.prop('disabled', false);
                    }
                    // Tính toán thành tiền mới
                    let newTotal = response.newquantity * roomprice; // Tính lại tổng giá trị
                    totalElement.html(`Thành tiền: ${newTotal.toLocaleString()} VNĐ`);

                    // Lấy giá trị "Tổng cộng" hiện tại
                    let currentTongCong = parseInt(tongcong.text().replace(/\D/g, '')) || 0;
                    // Tính toán giá trị mới cho "Tổng cộng"
                    let updatedTongCong = currentTongCong - roomprice;

                    // Cập nhật giá trị "Tổng cộng"
                    tongcong.html(`Tổng cộng: ${updatedTongCong.toLocaleString()} VNĐ`);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        $(document).on('click', '#remove-room', function() {
            let roomID = $(this).data('room-id');
            let roomElement = $(this).closest('.border.border-secondary-subtle'); // Tìm thẻ chứa thông tin phòng
            let parentElement = $(this).closest(
                '.border.p-2.mb-3.border-secondary.rounded-3'); // Tìm thẻ cha lớn nhất
            let ngaycheckin = $(this).data('checkin');
            let ngaycheckout = $(this).data('checkout');
            let totalElement = $(`#total${roomID}${ngaycheckin}${ngaycheckout}`);
            let tongcong = $(`#tongcong${ngaycheckin}${ngaycheckout}`);
            $.ajax({
                url: '{{ route('removefromcart') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    room_id: roomID,
                    checkin: ngaycheckin,
                    checkout: ngaycheckout
                },
                success: function(response) {
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
                    // Tính toán thành tiền mới
                    let Total = parseInt(totalElement.text().replace(/\D/g, '')) || 0;

                    // Lấy giá trị "Tổng cộng" hiện tại
                    let currentTongCong = parseInt(tongcong.text().replace(/\D/g, '')) || 0;
                    // Tính toán giá trị mới cho "Tổng cộng"
                    let updatedTongCong = currentTongCong - Total;

                    // Cập nhật giá trị "Tổng cộng"
                    tongcong.html(`Tổng cộng: ${updatedTongCong.toLocaleString()} VNĐ`);
                    // Xóa phần tử khỏi giao diện
                    roomElement.remove();
                    // Nếu không còn phòng nào trong parentElement thì xóa luôn
                    // Cập nhật số lượng phòng trong giỏ hàng
                    let roomCount = $('.border.border-secondary-subtle').length;
                    if (roomCount === 0) {
                        $('#quantityInCart').html('Giỏ Hàng'); // Không có phòng nào
                    } else {
                        $('#quantityInCart').html('Giỏ Hàng (' + roomCount +
                            ' phòng)'); // Cập nhật số phòng
                    }

                    // Nếu không còn phòng nào trong parentElement thì xóa luôn
                    if (parentElement.find('.border.border-secondary-subtle').length === 0) {
                        parentElement.remove();
                    }

                    $('#btn-nav').html(
                        '<span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger rounded-circle"></span><span class="navbar-toggler-icon"></span>'
                    );
                    $('#cart-count').html('Giỏ Hàng <span class="badge text-bg-danger">' + response
                        .cartCount + '</span>'); // #cart-count là ID phần tử hiển thị số lượng
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
