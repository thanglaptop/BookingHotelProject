<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGOBEE</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

    <!-- css owner -->
    @vite('resources/css/owner.css')

    <!-- css bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- icon bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css"
        rel="stylesheet">


</head>

<body>

    @include('header')

    <section class="container p-4">
        @if (Auth::guard('owner')->check()) 
        <a href="{{ session('previous_url',route('owner.managehotel', ['id' => $hotel->h_id, 'tab' => 'don-dat-phong'])) }}">
        @elseif(Auth::guard('employee')->check())
            <a href="{{ session('previous_url',route('employee.managehotel', ['id' => $hotel->h_id, 'tab' => 'don-dat-phong'])) }}">
    @endif
        <button type="button" class="btn btn-danger"><i class="bi bi-caret-left-fill"></i> trở về</button></a>
        <h1 class="text-center">Tạo Chi Tiết Đơn Đặt Phòng</h1>
        <hr>
        <form class="needs-validation"
        @if(Auth::guard('owner')->check())
        action="{{ route('owner.taodetailddp') }}"
        @elseif(Auth::guard('employee')->check())
        action="{{ route('employee.taodetailddp') }}"
        @endif
            method="POST" novalidate>
            @csrf
            <input type="hidden" name="hid" value="{{ $hotel->h_id }}">
            <div class="row">
                <h5 class="col-12">Thông tin đơn đặt: {{$hotel->h_name}}
                </h5>
                <div class="col-lg-3 col-6">
                    <div><strong>Họ và tên: </strong>{{$hoten}}</div>
                    <input type="hidden" name="name" value="{{$hoten}}">
                </div>
                <div class="col-lg-3 col-6">
                    <div><strong>Số điện thoại: </strong>{{$sdt}}</div>
                    <input type="hidden" name="sdt" value="{{$sdt}}">
                </div>
                <div class="col-lg-3 col-6">
                    <div><strong>Check-in: </strong>{{ date('d/m/Y', strtotime($checkin)) }}</div>
                    <input type="hidden" id="inputCin" name="checkin" value="{{$checkin}}">
                </div>
                <div class="col-lg-3 col-6">
                    <div><strong>Check-out: </strong>{{ date('d/m/Y', strtotime($checkout)) }}</div>
                    <input type="hidden" id="inputCout" name="checkout" value="{{$checkout}}">
                </div>
                <div class="col-12 mt-2">
                    <span class="d-flex align-items-center">
                        <strong style="white-space: nowrap">phương thức thanh toán: </strong>
                        <select name="thanhtoan" id="inputPM" class="ms-3 form-select">
                            <option value="tt">Tiền mặt</option>
                            <option value="momo">Momo</option>
                            <option value="bank">Ngân hàng</option>
                        </select>
                        <button class="btn btn-primary ms-3">Tạo</button>
                    </span>
                </div>

                <h5 class="mt-3">Chi tiết đơn đặt phòng:</h5>
                <div class="col-12 dgvDDP w-100 border border-secondary rounded-3 scroll-2">
                    <table class="table table-hover ">
                        <thead class="sticky-top">
                            <th>STT</th>
                            <th>Tên phòng</th>
                            <th>Số lượng</th>
                            <th>Số đêm</th>
                            <th>Giá</th>
                            <th>Tổng tiền</th>
                            <th></th>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot class="sticky-bottom">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Thành tiền:</th>
                            <th></th>
                            <th></th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </form>
        <h5 class="mt-3">Chọn Phòng: </h5>
        <div class="row border border-secondary rounded-3">
            @foreach ($listroom as $room)
                @php
                    $allow = '';
                    if ($room['r_maxadult'] != 0 && $room['r_maxkid'] != 0) {
                        $allow = $room['r_maxadult'] . ' người lớn, ' . $room['r_maxkid'] . ' trẻ em';
                    } elseif ($room['r_maxadult'] != 0 && $room['r_maxkid'] == 0) {
                        $allow = $room['r_maxadult'] . ' người lớn';
                    } else {
                        $allow = $room['r_maxperson'] . ' người lớn và trẻ em';
                    }
                @endphp
                <div class="p-1 col-lg-3 col-md-4 col-6"><button @if($room['r_conlai'] == 0) disabled @endif
                        class="btn btn-light border border-warning h-100 w-100 adddetail"
                        onclick="addRoomToTable('{{ $room['r_id'] }}','{{ $room['r_name'] }}', 1, {{ $room['r_price'] }}, {{ $room['r_conlai'] }}, this)">
                        <h6>{{ $room['r_name'] }}</h6>
                        <div>diện tích: {{ $room['r_dientich'] }}m<sup>2</sup></div>
                        <div>cho phép: {{ $allow }}</div>
                        <div>còn lại: <span class="room-quantity">{{ $room['r_conlai'] }}</span></div>
                    </button></div>
            @endforeach
        </div>
    </section>

    @include('footer')
    @vite('resources/js/owner.js')
    @vite('resources/js/ddp.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
