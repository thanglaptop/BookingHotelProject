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
        <a href="{{ route('managehotel', ['id' => $hotel->h_id]) }}"><button type="button" class="btn btn-danger"><i
                    class="bi bi-caret-left-fill"></i> trở về</button></a>
        <h1 class="text-center">Tạo Đơn Đặt Phòng</h1>
        <hr>
        <form action="">
            <div class="row">
                <h5 class="col-12">Thông tin đơn đặt:</h5>
                <div class="col-6">
                    <label for="inputName" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" id="inputName" required>
                </div>
                <div class="col-6">
                    <label for="inputSdt" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="inputSdt" required>
                </div>
                <div class="col-6 col-lg-4 mt-1">
                    <label for="inputCin" class="form-label">Check-in</label>
                    <input type="date" class="form-control" id="inputCin" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-6 col-lg-4 mt-1">
                    <label for="inputCout" class="form-label">Check-out</label>
                    <input type="date" class="form-control" id="inputCout" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-lg-4 col-12 mt-1">
                    <label for="inputPM" class="form-label">Thanh toán</label>
                    <div class="d-flex align-items-center">
                    <select name="" id="inputPM" class="form-select">
                        <option value="1">Tiền mặt</option>
                        <option value="2">Momo</option>
                        <option value="3">Ngân hàng</option>
                    </select>
                    <button class="btn btn-primary ms-3">Tạo</button>
                </div>
                </div>
                {{-- <div class="col-lg-4 col-9 d-flex align-items-end mt-1">
                    <h5>Thành tiền: 1.500.000 VNĐ</h5>
                    
                </div> --}}
                <h5 class="mt-3">Chi tiết đơn đặt phòng:</h5>
                <div class="col-12 dgvDDP w-100 border border-secondary rounded-3 scroll-2">
                    <table class="table table-hover ">
                        <tr class="sticky-top">
                            <th>STT</th>
                            <th>Tên phòng</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng tiền</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Phòng Tiêu Chuẩn Hướng Núi (Standard)</td>
                            <td>5</td>
                            <td>100.000 VNĐ</td>
                            <td>500.000 VNĐ</td>
                            <td><i class="bi bi-trash3"></i></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Phòng Loại sang (Deluxe)</td>
                            <td>2</td>
                            <td>500.000 VNĐ</td>
                            <td>1.000.000 VNĐ</td>
                            <td><i class="bi bi-trash3"></i></td>
                        </tr>

                        <tr class="sticky-bottom">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Thành tiền:</th>
                            <th>2.500.000 VNĐ</th>
                            <th></th>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
        <h5 class="mt-3">Chọn Phòng: </h5>
        <div class="row border border-secondary rounded-3">
            @foreach ($listroom as $room)
                @php
                    $allow = '';
                    if ($room->r_maxadult != 0 && $room->r_maxkid != 0) {
                        $allow = $room->r_maxadult . ' người lớn, ' . $room->r_maxkid . ' trẻ em';
                    } elseif ($room->r_maxadult != 0 && $room->r_maxkid == 0) {
                        $allow = $room->r_maxadult . ' người lớn';
                    } else {
                        $allow = $room->r_maxperson . ' người lớn và trẻ em';
                    }
                @endphp
                <div class="p-1 col-lg-3 col-md-4 col-6"><button class="btn btn-light border border-warning h-100 w-100">
                        <h6>{{ $room->r_name }}</h6>
                        <div>diện tích: {{ $room->r_dientich }}m<sup>2</sup></div>
                        <div>cho phép: {{ $allow }}</div>
                        <div>còn lại: {{ $room->r_soluong }}</div>
                    </button></div>
            @endforeach
        </div>
    </section>

    @vite('resources/js/owner.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
