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

<!-- MAIN CONTENT -->
<section class="container my-5">
    <!-- Header -->
    <div class="row text-center mb-4">
        <div class="col">
            <h1 class="fw-bold text-primary">Thông Tin Khách Hàng</h1>
            <p class="text-muted">Cập nhật và quản lý thông tin cá nhân của bạn.</p>
        </div>
    </div>

    <!-- Customer Info -->
    <div class="row">
        <div class="col-md-6 mx-auto mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary text-center">Thông Tin Cá Nhân</h5>
                    <form id="updateForm" action="{{route('updateinfo')}}" method="POST">
                        @csrf
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên khách hàng</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $customer->c_name }}" required readonly>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ $customer->c_email }}" required readonly>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                   value="{{ $customer->c_sdt }}" required readonly>
                        </div>

                        <!-- Date of Birth -->
                        <div class="mb-3">
                            <label for="dob" class="form-label">Ngày sinh</label>
                            <input type="date" class="form-control" id="dob" name="ngaysinh"
                                   value="{{ $customer->c_nsinh }}" required readonly>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" readonly>
                        </div>

                        <!-- Buttons -->
                        <div class="text-center">
                            <button type="button" id="editBtn" class="btn btn-secondary">Chỉnh sửa</button>
                            <button type="submit" id="confirmBtn" class="btn btn-success d-none">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-primary text-center">Đổi mật khẩu</h5>
                    <form action="{{route('updatecustomerpass')}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="oldpass" class="form-label">Nhập mật khẩu cũ</label>
                            <input type="text" class="form-control" id="oldpass" name="oldpass" required>
                        </div>

                        <div class="mb-3">
                            <label for="newpass" class="form-label">Nhập mật khẩu mới</label>
                            <input type="text" class="form-control" id="newpass" name="newpass" required>
                        </div>

                        <div class="mb-3">
                            <label for="newpass2" class="form-label">Nhập lại mật khẩu mới</label>
                            <input type="text" class="form-control" id="newpass2" name="newpass2" required>
                        </div>
                        <!-- Buttons -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                        </div>
                    </form>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        const editBtn = document.getElementById('editBtn');
        const confirmBtn = document.getElementById('confirmBtn');
        const form = document.getElementById('updateForm');

        // Kích hoạt chỉnh sửa và hiện nút xác nhận
        editBtn.addEventListener('click', () => {
            // Bật chỉnh sửa các trường
            form.querySelectorAll('input').forEach(input => {
                input.removeAttribute('readonly');
            });

            // Hiện nút "Lưu thay đổi" và đổi nút "Chỉnh sửa"
            editBtn.classList.add('d-none');
            confirmBtn.classList.remove('d-none');
        });

        // Hiển thị thông báo xác nhận khi nhấn nút "Lưu thay đổi"
        //confirmBtn.addEventListener('click', () => {
          //  if (confirm('Bạn có chắc chắn muốn lưu thay đổi không?')) {
          //      form.submit();
           // }
       // });

        // Đặt ban đầu các trường chỉ đọc
        window.onload = () => {
            form.querySelectorAll('input').forEach(input => {
                input.setAttribute('readonly', true);
            });
        };
    </script>


</html>
