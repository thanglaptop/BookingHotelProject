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
    @php
        $owner = Auth::guard('owner')->user();
    @endphp

    <section class="container p-4">
        <h1 class="text-center">Doanh Thu</h1>
        <hr>
        <div class="row mt-3">
            <div class="col-md-7 col-12 d-flex align-items-end gap-2">
                <div class="flex-fill"><label for="ngayBD" class="form-label">ngày bắt đầu</label>
                    <input type="date" class="form-control border-secondary w-100" id="todayDate" value="{{date('Y-m-d')}}">
                </div>
                <div class="flex-fill"><label for="ngayKT" class="form-label">ngày kết thúc</label>
                    <input type="date" class="form-control border-secondary w-100" id="todayDate" value="{{date('Y-m-d')}}">
                </div>
                <div class="">
                    <button type="button" class=" btn btn-primary">Tìm</button>
                </div>
            </div>
            <div class="col-md-5 col-12">
                <label for="search-by-month" class="form-label">Xem theo tháng</label>
                <select class="form-select border-secondary" id="search-by-month">
                    <option>chọn tháng bạn muốn xem</option>
                    @for($month = 1; $month < 13; $month++)
                        <option value="t{{$month}}">Tháng {{$month}}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="row mt-2">
            @foreach ($owner->hotels as $hotel)
                <div class="col-lg-3 col-md-4 col-6 p-2">
                    <div class="h-100 border rounded-3 border-secondary-subtle p-3">
                            <h4 class="title">{{ $hotel->h_name }}</h4>
                            <div class="mt-2">Ngày bắt đầu: {{date('d-m-Y')}}</div>
                            <div>Ngày kết thúc: {{date('d-m-Y')}}</div>
                            <div>Số lượng đơn đặt: 1000</div>
                            <div>Doanh thu: {{ number_format(1000000, 0, ',', '.') }} VNĐ</div>
                    </div>
                </div>
            @endforeach
            <div class="col-lg-3 col-md-4 col-6 p-2">
                <div class="h-100 border rounded-3 border-primary p-3">
                    <h4 class="title text-primary">TỔNG DOANH THU</h4>
                    <div class="mt-2 text-primary">Ngày bắt đầu: {{date('d-m-Y')}}</div>
                    <div class="text-primary">Ngày kết thúc: {{date('d-m-Y')}}</div>
                    <div class="text-primary">Số lượng đơn đặt: 7000</div>
                    <div class="text-primary">Doanh thu: {{ number_format(7000000, 0, ',', '.') }} VNĐ</div>
            </div>
            </div>
        </div>
    </section>

    @vite('resources/js/owner.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
