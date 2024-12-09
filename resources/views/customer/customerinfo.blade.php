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
    @php
    $customer = Auth::guard('customer')->user();


    $dondatphongs = \App\Models\Dondatphong::where('c_id', $customer->c_id)
                            ->orderBy('ddp_ngaydat', 'desc')
                            ->get();
    @endphp

<section class="container my-5">
    <!-- Header -->
    <div class="row text-center mb-4">
        <div class="col">
            <h1 class="fw-bold text-primary">Thông Tin Khách Hàng</h1>
            <p class="text-muted">Xem và quản lý các đặt phòng của bạn tại đây.</p>
        </div>
    </div>

    <!-- Customer Info -->
    <div class="row mb-4">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-center text-primary">Thông Tin Cá Nhân</h5>
                    <p><i class="bi bi-person-circle"></i> <strong>Tên khách hàng:</strong> {{ $customer->c_name }}</p>
                    <p><i class="bi bi-envelope"></i> <strong>Email:</strong> {{ $customer->c_email }}</p>
                    <p><i class="bi bi-telephone"></i> <strong>Số điện thoại:</strong> {{ $customer->c_sdt }}</p>
                    <p><i class="bi bi-calendar"></i> <strong>Ngày sinh:</strong> {{ $customer->c_nsinh }}</p>
                    <div class="d-flex justify-content-between">
                        <!-- Link chỉnh sửa -->
                        <a class="btn btn-primary" href="{{ route('updatecustomerinfo') }}">Chỉnh sửa</a>

                        <!-- Nút lưu thay đổi -->
                        <button type="button" id="confirmBtn" class="btn btn-success d-none">Lưu thay đổi</button>
                    </div>

            </div>
        </div>
    </div>

    <!-- Booking List -->
    <div class="row">
        <div class="col">
            <h4 class="fw-bold text-secondary mb-3">Danh Sách Đặt Phòng</h4>

            @if($dondatphongs->count() > 0)
                @foreach($dondatphongs as $ddp)
                <div class="card shadow-sm mb-4">
                    <div class="row g-0">
                        <!-- Image -->
                        <div class="col-md-3 d-flex justify-content-center align-items-center bg-light">
                            <img src="https://via.placeholder.com/150" class="img-fluid rounded-start p-3" alt="Hotel">
                        </div>
                        <!-- Booking Info -->
                        <div class="col-md-6">
                            <div class="card-body">
                                <h5 class="card-title">Đơn đặt phòng #{{ $ddp->ddp_id }}</h5>
                                <p class="mb-1"><strong>Tên khách hàng:</strong> {{ $ddp->ddp_customername }}</p>
                                <p class="mb-1"><strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($ddp->ddp_ngaydat)->format('d/m/Y') }}</p>
                                <p class="mb-1"><strong>Số điện thoại:</strong> {{ $ddp->ddp_sdt }}</p>
                                <p class="mb-1"><strong>Tổng tiền:</strong> {{ number_format($ddp->ddp_total, 0, ',', '.') }} VNĐ</p>
                                <p class="mb-1"><strong>Phương thức thanh toán:</strong> {{ $ddp->ddp_pttt }}</p>
                                <p class="mb-1"><strong>Trạng thái:</strong>
                                    <span class="fw-bold {{ $ddp->ddp_status == 'Đã xác nhận' ? 'text-success' : 'text-warning' }}">
                                        {{ $ddp->ddp_status }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <!-- Actions -->
                        <div class="col-md-3 d-flex flex-column justify-content-center align-items-center">
                            <a href="{{ route('dondatphong.detail', ['id' => $ddp->ddp_id]) }}" class="btn btn-primary btn-sm w-75 mb-2">Chi Tiết</a>
                            @if($ddp->ddp_status != 'Đã xác nhận')
                            <a href="{{ route('dondatphong.cancel', ['id' => $ddp->ddp_id]) }}"
                               class="btn btn-danger btn-sm w-75"
                               onclick="return confirm('Bạn có chắc muốn hủy đặt phòng này?')">
                                Hủy Đặt Phòng
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="alert alert-info text-center">
                    Bạn chưa có đơn đặt phòng nào.
                </div>
            @endif
        </div>
    </div>
</section>


    @include('footer')

    @vite('resources/js/customer.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
