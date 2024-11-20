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
        <h1 class="text-center">Thông Tin Cá Nhân</h1>
        <div class="row g-3">
            <div class="col-6">
                <label for="owner-name" class="form-label">Họ và tên</label>
                <input type="text" class="form-control border-secondary" id="owner-name" value="{{$owner->o_name}}" disabled>
            </div>
            <div class="col-6">
                <label for="owner-email" class="form-label">Email</label>
                <input type="text" class="form-control border-secondary" id="owner-email" value="{{$owner->o_email}}" disabled>
            </div>
            <div class="col-12">
                <label for="owner-address" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control border-secondary" id="owner-name" value="{{$owner->o_dchi}}" disabled>
            </div>
            <div class="col-6">
                <label for="owner-phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control border-secondary" id="owner-phone" value="{{$owner->o_sdt}}" disabled>
            </div>
            <div class="col-6">
                <label for="owner-birthday" class="form-label">Ngày sinh</label>
                <input type="date" class="form-control border-secondary" id="owner-birthday" value="{{$owner->o_nsinh}}" disabled>
            </div>
            <div class="col-6">
                <label for="owner-username" class="form-label">Tên đăng nhập</label>
                <input type="text" class="form-control border-secondary" id="owner-phone" value="{{$owner->o_username}}" disabled>
            </div>
            <div class="col-6">
                <label for="owner-cccd" class="form-label">Căn cước công dân</label>
                <input type="text" class="form-control border-secondary" id="owner-cccd" value="{{$owner->o_cccd}}" disabled>
            </div>
            <div class="col-12 text-center text-primary">Nếu có muốn thay đổi thông tin cá nhân đã đăng ký hãy liên hệ với bộ phận hỗ trợ của AGOBEE để được thay đổi</div>
        </div>

        <hr class="mt-4">
        <h1 class="text-center mt-4">Đổi mật khẩu</h1>
        <form action="" class="row g-3 needs-validation" novalidate>
            <div class="col-12">
                <label for="owner-oldpass" class="form-label">Mật khẩu cũ</label>
                <input type="text" class="form-control border-secondary" id="owner-oldpass" required>
                <div class="invalid-feedback">
                    mật khẩu cũ không được bỏ trống
                </div>
            </div>
            <div class="col-12">
                <label for="owner-oldpass" class="form-label">Mật khẩu mới</label>
                <input type="text" class="form-control border-secondary" id="owner-oldpass" required>
                <div class="invalid-feedback">
                    mật khẩu mới không được bỏ trống
                </div>
            </div>
            <div class="col-12">
                <label for="owner-newpass" class="form-label">Nhập lại mật khẩu mới</label>
                <input type="text" class="form-control border-secondary" id="owner-newpass" required>
                <div class="invalid-feedback">
                    nhập lại mật khẩu không được bỏ trống
                </div>
            </div>
            <div class="col-12 text-center"><button class="btn btn-primary">Cập nhật</button></div>
        </form>
    </section>

    @vite('resources/js/owner.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
