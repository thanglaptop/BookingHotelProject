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
        <a href="{{ route('managenv') }}"><button type="button" class="btn btn-danger"><i
            class="bi bi-caret-left-fill"></i> trở về</button></a>
        <h1 class="text-center">Sửa Thông Tin Nhân Viên</h1>
        <form class="row g-3 needs-validation border border-secondary rounded-3 p-2 mt-3" action="{{route('updatenv')}}" method="POST"
            novalidate>
            @method('PUT')
            @csrf
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="col-lg-6 col-12">
                <input type="hidden" name="nvid" value="{{$nv->e_id}}" required>
                <label for="nvname" class="form-label">Họ và tên</label>
                <input type="text" name="fullname" class="form-control border-secondary" id="nvname" value="{{$nv->e_name}}" required>
                <div class="invalid-feedback">
                    hãy nhập họ và tên
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <label for="nvhotel" class="form-label">Làm việc tại</label>
                <select class="form-select border-secondary" name="hotel" id="nvhotel" required>
                    @foreach ($owner->hotels as $hotel)
                        <option value="{{ $hotel->h_id }}" @if($nv->h_id == $hotel->h_id) selected @endif>{{ $hotel->h_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-6 col-12">
                <label for="nvusername" class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" class="form-control border-secondary" id="nvusername" value="{{$nv->e_username}}" required>
                <div class="invalid-feedback">
                    hãy nhập tên đăng nhập
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <label for="ownerpassword" class="form-label">Xác nhận mật khẩu chủ khách sạn</label>
                <input type="password" name="password" class="form-control border-secondary" id="ownerpassword" required>
                <div class="invalid-feedback">
                    hãy nhập mật khẩu chủ khách sạn để xác nhận
                </div>
            </div>
            <div class="col-12 text-center">
                <button class="btn btn-primary">Lưu nhân viên</button>
            </div>
        </form>

        <form class="row g-3 needs-validation border border-secondary rounded-3 p-2 mt-3" action="{{route('updatemknv')}}" method="POST"
            novalidate>
            @method('PUT')
            @csrf
            <h3 class="text-center">Đổi mật khẩu nhân viên</h3>
            @if (session('successpw'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('successpw') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif(session('errorpw'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('errorpw') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="col-lg-6 col-12">
                <input type="hidden" name="nvid" value="{{$nv->e_id}}" required>
                <label for="newpassword" class="form-label">Mật khẩu mới cho nhân viên</label>
                <input type="password" name="newpassword" class="form-control border-secondary" id="newpassword"required>
                <div class="invalid-feedback">
                    hãy nhập mật khẩu mới cho nhân viên
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <label for="password" class="form-label">Xác nhận mật khẩu chủ khách sạn</label>
                <input type="password" name="ownerpassword" class="form-control border-secondary" id="password" required>
                <div class="invalid-feedback">
                    hãy nhập mật khẩu chủ khách sạn để xác nhận
                </div>
            </div>
            <div class="col-12 text-center">
                <button class="btn btn-primary">Đổi mật khẩu</button>
            </div>
        </form>
    </section>

    @include('footer')
    @vite('resources/js/owner.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
