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

    <title>AGOBEE</title>
</head>

<body>
    @include('header')

    <section class="container p-4">
        <a href="{{ session('previous_detailhotel', route('index')) }}"><button type="button" class="btn btn-danger"><i
            class="bi bi-caret-left-fill"></i> trở về</button></a>
        <h1 class="text-center">Thanh Toán</h1>
        <hr>
        <form action="{{ route('customertaoddp') }}" class="needs-validation" method="POST">
            @csrf
            @php
                $customer = Auth::guard('customer')->user();
            @endphp
            <div class="row">
                <h5>Thông tin thanh toán:</h5>
                <div class="col-6 col-lg-3"><strong>Họ và tên: </strong>{{ $customer->c_name }}</div>
                <div class="col-6 col-lg-3"><strong>Số điện thoại: </strong>{{ $customer->c_sdt }}</div>
                <div class="col-6 col-lg-3"><strong>Ngày sinh: </strong>{{ date('d/m/Y', $customer->c_ngaysinh) }}</div>
                <div class="col-6 col-lg-3"><strong>Email: </strong>{{ $customer->c_email }}</div>
            </div>

            <input type="hidden" name="name" value="{{ $customer->c_name }}">
            <input type="hidden" name="sdt" value="{{ $customer->c_sdt }}">
            <div class="row mt-4">
               @isset($listroom)
                    @foreach ($listhotel as $ks)
                        @php

                            $hotel = $hotels->firstWhere('h_id', $ks[2]);
                            $tongcong = 0;
                            $radioname = $hotel->h_id . 'rdb' . $ks[0] . 'rdb' . $ks[1];
                        @endphp
                        <div class="border p-2 mb-3 border-secondary rounded-3">
                            <div class="d-flex align-items-center">
                                <h3 class="mb-0 ms-2 text-primary">{{ $hotel->h_name }}</h3>
                                <input type="hidden" name="listhotel[]" value="{{ $hotel->h_id }}">
                                <input type="hidden" name="listcheckin[]" value="{{ $ks[0] }}">
                                <input type="hidden" name="listcheckout[]" value="{{ $ks[1] }}">
                            </div>
                            @foreach ($listroom as $room)
                                @if ($room->h_id == $hotel->h_id && $room->pivot->g_checkin == $ks[0] && $room->pivot->g_checkout == $ks[1])
                                    @php
                                        $checkin = date(
                                            '\\n\gà\y j \\t\há\n\g n \\n\ă\m Y',
                                            strtotime($room->pivot->g_checkin),
                                        );
                                        $checkout = date(
                                            '\\n\gà\y j \\t\há\n\g n \\n\ă\m Y',
                                            strtotime($room->pivot->g_checkout),
                                        );
                                        $allow = '';
                                        if ($room->r_maxadult != 0 && $room->r_maxkid != 0) {
                                            $allow = $room->r_maxadult . ' người lớn, ' . $room->r_maxkid . ' trẻ em';
                                        } elseif ($room->r_maxadult != 0 && $room->r_maxkid == 0) {
                                            $allow = $room->r_maxadult . ' người lớn';
                                        } else {
                                            $allow = $room->r_maxperson . ' người lớn và trẻ em';
                                        }
                                        $days =
                                            (strtotime($room->pivot->g_checkout) - strtotime($room->pivot->g_checkin)) /
                                            (60 * 60 * 24);
                                        $total = $room->r_price * $days * $room->pivot->g_soluong;
                                        $tongcong += $total;
                                    @endphp
                                    <div class="border border-secondary-subtle rounded-3 m-2">
                                        <div class="row p-2">
                                            <div class="col-12">
                                                <input type="hidden" name="listroom[]" value="{{ $room->r_id }}">
                                                <input type="hidden" name="listhotelId[]" value="{{ $room->h_id }}">
                                                <input type="hidden" name="listcheckinofroom[]"
                                                    value="{{ $ks[0] }}">
                                                <input type="hidden" name="listcheckoutofroom[]"
                                                    value="{{ $ks[1] }}">
                                                <h5>{{ $room->r_name }}</h5>
                                                <div class="me-2"><small><i class="bi bi-calendar2-check"></i>
                                                        {{ $checkin }} </small><i class="bi bi-arrow-right"></i>
                                                    {{ $checkout }}</div>
                                                <div class="me-2"><small><i class="bi bi-person"></i> tối đa:
                                                        {{ $allow }}/phòng || số lượng:
                                                        {{ $room->pivot->g_soluong }} phòng</small>
                                                    <input type="hidden" name="listsoluong[]"
                                                        value="{{ $room->pivot->g_soluong }}">
                                                </div>
                                                <h5 class="mt-2">Thành tiền: {{ number_format($total, 0, ',', '.') }}
                                                    VNĐ</h5>
                                                <input type="hidden" name="listthanhtien[]"
                                                    value="{{ $total }}">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <div class="border border-secondary-subtle rounded-3 m-2">
                                <div class="row p-2">
                                    @php
                                        $paymentinfo = $hotel->paymentinfo;
                                    @endphp
                                    <div class="col-12">
                                        <h5 class="text-center">Chọn phương thức thanh toán</h5>
                                        <div class=" row">
                                            <div class="col-lg-2 col-6 d-flex flex-column align-items-center">
                                                <div><strong>Momo</strong></div>
                                                <img src="/images/other/placeholder-image.png" alt=""
                                                    style="width:100px; heigh:100px;">
                                                <div>{{ $paymentinfo->pm_momo }}</div>
                                            </div>
                                            <div class="col-lg-2 col-6 d-flex flex-column align-items-center">
                                                <div><strong>Ngân hàng</strong></div>
                                                <img src="/images/other/placeholder-image.png" alt=""
                                                    style="width:100px; heigh:100px;">
                                                <div>{{ $paymentinfo->pm_momo }}</div>
                                            </div>
                                            <div class="col-lg-8 col-12">
                                                <div class="text-center"><strong>mô tả</strong></div>
                                                <div>{{ $paymentinfo->pm_mota }}</div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-3 justify-content-center">
                                            <div class="form-check">
                                                <input class="form-check-input border-secondary" type="radio"
                                                    name="{{ $radioname }}" value="tt" id="flexRadioDefault1"
                                                    @if ($paymentinfo->pm_athotel != 1) disabled @endif required>
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Tại khách sạn
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input border-secondary" type="radio"
                                                    name="{{ $radioname }}" value="momo" id="flexRadioDefault2"
                                                    required>
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Momo
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input border-secondary" type="radio"
                                                    name="{{ $radioname }}" value="bank" id="flexRadioDefault3"
                                                    required>
                                                <label class="form-check-label" for="flexRadioDefault3">
                                                    Ngân hàng
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="text-end me-2">Tổng cộng: {{ number_format($tongcong, 0, ',', '.') }} VNĐ</h4>
                            <input type="hidden" name="listtongcong[]" value="{{ $tongcong }}">
                        </div>
                    @endforeach
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Đặt đơn</button>
                    </div>
                @else
                    @php
                        $radioname = $hotel->h_id . 'rdb' . $checkin . 'rdb' . $checkout;
                        $tongcong = 0;
                    @endphp
                    <div class="border p-2 mb-3 border-secondary rounded-3">
                        <div class="d-flex align-items-center">
                            <h3 class="mb-0 ms-2 text-primary">{{ $hotel->h_name }}</h3>
                            <input type="hidden" name="listhotel[]" value="{{ $hotel->h_id }}">
                            <input type="hidden" name="listcheckin[]" value="{{ $checkin }}">
                            <input type="hidden" name="listcheckout[]" value="{{ $checkout }}">
                            <input type="hidden" name="booknow" value="{{$booknow}}">
                        </div>
                        @php
                            $checkinday = date('\\n\gà\y j \\t\há\n\g n \\n\ă\m Y', strtotime($checkin));
                            $checkoutday = date('\\n\gà\y j \\t\há\n\g n \\n\ă\m Y', strtotime($checkout));
                            $allow = '';
                            if ($room->r_maxadult != 0 && $room->r_maxkid != 0) {
                                $allow = $room->r_maxadult . ' người lớn, ' . $room->r_maxkid . ' trẻ em';
                            } elseif ($room->r_maxadult != 0 && $room->r_maxkid == 0) {
                                $allow = $room->r_maxadult . ' người lớn';
                            } else {
                                $allow = $room->r_maxperson . ' người lớn và trẻ em';
                            }
                            $days = (strtotime($checkout) - strtotime($checkin)) / (60 * 60 * 24);
                            $total = $room->r_price * $days * 1;
                            $tongcong += $total;
                        @endphp
                        <div class="border border-secondary-subtle rounded-3 m-2">
                            <div class="row p-2">
                                <div class="col-12">
                                    <input type="hidden" name="listroom[]" value="{{ $room->r_id }}">
                                    <input type="hidden" name="listhotelId[]" value="{{ $room->h_id }}">
                                    <input type="hidden" name="listcheckinofroom[]" value="{{ $checkin }}">
                                    <input type="hidden" name="listcheckoutofroom[]" value="{{ $checkout }}">
                                    <h5>{{ $room->r_name }}</h5>
                                    <div class="me-2"><small><i class="bi bi-calendar2-check"></i>
                                            {{ $checkinday }} </small><i class="bi bi-arrow-right"></i>
                                        {{ $checkoutday }}</div>
                                    <div class="me-2"><small><i class="bi bi-person"></i> tối đa:
                                            {{ $allow }}/phòng || số lượng:
                                            1 phòng</small>
                                        <input type="hidden" name="listsoluong[]" value="1">
                                    </div>
                                    <h5 class="mt-2">Thành tiền: {{ number_format($total, 0, ',', '.') }}
                                        VNĐ</h5>
                                    <input type="hidden" name="listthanhtien[]" value="{{ $total }}">
                                </div>
                            </div>
                        </div>
                        <div class="border border-secondary-subtle rounded-3 m-2">
                            <div class="row p-2">
                                @php
                                    $paymentinfo = $hotel->paymentinfo;
                                @endphp
                                <div class="col-12">
                                    <h5 class="text-center">Chọn phương thức thanh toán</h5>
                                    <div class=" row">
                                        <div class="col-lg-2 col-6 d-flex flex-column align-items-center">
                                            <div><strong>Momo</strong></div>
                                            <img src="/images/other/placeholder-image.png" alt=""
                                                style="width:100px; heigh:100px;">
                                            <div>{{ $paymentinfo->pm_momo }}</div>
                                        </div>
                                        <div class="col-lg-2 col-6 d-flex flex-column align-items-center">
                                            <div><strong>Ngân hàng</strong></div>
                                            <img src="/images/other/placeholder-image.png" alt=""
                                                style="width:100px; heigh:100px;">
                                            <div>{{ $paymentinfo->pm_momo }}</div>
                                        </div>
                                        <div class="col-lg-8 col-12">
                                            <div class="text-center"><strong>mô tả</strong></div>
                                            <div>{{ $paymentinfo->pm_mota }}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <div class="form-check">
                                            <input class="form-check-input border-secondary" type="radio"
                                                name="{{ $radioname }}" value="tt" id="flexRadioDefault1"
                                                @if ($paymentinfo->pm_athotel != 1) disabled @endif required>
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Tại khách sạn
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input border-secondary" type="radio"
                                                name="{{ $radioname }}" value="momo" id="flexRadioDefault2"
                                                required>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Momo
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input border-secondary" type="radio"
                                                name="{{ $radioname }}" value="bank" id="flexRadioDefault3"
                                                required>
                                            <label class="form-check-label" for="flexRadioDefault3">
                                                Ngân hàng
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-end me-2">Tổng cộng: {{ number_format($tongcong, 0, ',', '.') }} VNĐ</h4>
                        <input type="hidden" name="listtongcong[]" value="{{ $tongcong }}">
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Đặt đơn</button>
                    </div>
                @endisset
            </div>
        </form>

    </section>
    @include('footer')
    @vite('resources/js/customer.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
