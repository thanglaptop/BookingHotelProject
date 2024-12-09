<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- style -->
    @vite('resources/css/login.css')
    <!-- css bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>AGOBEE</title>
</head>

<body>
    <div class="loginPage">
        <a href="{{route('index')}}"><img src="{{ asset('images/other/logoAGOBEE.png') }}" alt="ảnh không tồn tại"></a>
        <div class="tabLogin">
            <button class="chuyenTab active" onclick="moLogin(event,'KhachHang')">Khách Hàng</button>
            <button class="chuyenTab" onclick="moLogin(event,'ChuKhachSan')">Khách Sạn</button>
        </div>
        <div class="tabContent">

            {{-- tab login cho khách hàng --}}
            @include('tablogin/loginKH')

            {{-- tab login cho chủ khách sạn --}}
            @include('tablogin/loginOwner')

            {{-- tab signup cho khách hàng --}}
            @include('tablogin/signupKH')

            {{-- tab quên mật khẩu cho khách hàng --}}
            @include('tablogin/FPKH')


        </div>
        <div style="height: 5rem;"></div>
    </div>

    @vite('resources/js/loginPage.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
