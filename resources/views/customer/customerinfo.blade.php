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
                    <h5 class="card-title fw-bold text-center text-primary mb-3">Thông Tin Cá Nhân</h5>
                    <p><i class="bi bi-person-circle"></i> <strong>Tên khách hàng:</strong> {{ $customer->c_name }}</p>
                    <p><i class="bi bi-envelope"></i> <strong>Email:</strong> {{ $customer->c_email }}</p>
                    <p><i class="bi bi-telephone"></i> <strong>Số điện thoại:</strong> {{ $customer->c_sdt }}</p>
                    <p><i class="bi bi-calendar"></i> <strong>Ngày sinh:</strong> {{date('d/m/Y', strtotime($customer->c_nsinh))}}</p>
                    <div class="text-center">
                        <!-- Link chỉnh sửa -->
                        <a class="btn btn-primary" href="{{ route('updatecustomerinfo') }}">Chỉnh sửa</a>
                    </div>

            </div>
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
