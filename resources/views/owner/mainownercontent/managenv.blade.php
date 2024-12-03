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
        <h1 class="text-center">Quản Lý Nhân Viên</h1>
        <form class="row g-3 needs-validation border border-secondary rounded-3 p-2 mt-3" action="{{route('addemployee')}}" method="POST"
            novalidate>
            @csrf
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="col-6">
                <label for="nvname" class="form-label">Họ và tên</label>
                <input type="text" name="fullname" class="form-control border-secondary" id="nvname" required>
                <div class="invalid-feedback">
                    hãy nhập họ và tên
                </div>
            </div>
            <div class="col-6">
                <label for="nvhotel" class="form-label">Làm việc tại</label>
                <select class="form-select border-secondary" name="hotel" id="nvhotel" required>
                    @foreach ($owner->hotels as $hotel)
                        <option value="{{ $hotel->h_id }}">{{ $hotel->h_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label for="nvusername" class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" class="form-control border-secondary" id="nvusername" required>
                <div class="invalid-feedback">
                    hãy nhập tên đăng nhập
                </div>
            </div>
            <div class="col-6">
                <label for="nvpassword" class="form-label">Mật khẩu</label>
                <input type="text" name="password" class="form-control border-secondary" id="nvpassword" required>
                <div class="invalid-feedback">
                    hãy nhập mật khẩu
                </div>
            </div>
            <div class="col-12 text-center">
                <button class="btn btn-primary">Lưu nhân viên</button>
            </div>
        </form>

        <h4 class="mt-3">Danh sách nhân viên</h4>
        <table class="table">
            <tr>
                <th>Mã NV</th>
                <th>Họ và tên</th>
                <th>Tên đăng nhập</th>
                <th>Làm việc tại</th>
                <th></th>
            </tr>
            @foreach ($owner->employees as $nv)
                @php
                    for ($i = 0; $i < count($owner->hotels); $i++) {
                        if ($nv->h_id == $owner->hotels[$i]['h_id']) {
                            $hotelname = $owner->hotels[$i]['h_name'];
                            break;
                        }
                    }
                @endphp
                <tr>
                    <td>{{ $nv->e_id }}</td>
                    <td>{{ $nv->e_name }}</td>
                    <td>{{$nv->e_username}}</td>
                    <td>{{ $hotelname }}</td>
                    <td>
                        <a href="{{route('showeditnv', ['nvid' => $nv->e_id])}}"><button class="btn btn-info">Sửa</button></a>
                        <a href="#Xoa"><button class="btn btn-danger">Xóa</button></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </section>


    @vite('resources/js/owner.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
