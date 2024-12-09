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
        <a href="{{ route('mainowner') }}"><button type="button" class="btn btn-danger"><i
            class="bi bi-caret-left-fill"></i> trở về</button></a>
        <h1 class="text-center">Đóng Cửa {{ $hotel->h_name }}</h1>
        <hr>
        <div class="d-flex gap-2">
            <h4>Trạng thái: </h4>
            @if ($hotel->h_isclose == 0)
                <h4 class="text-success">Đang hoạt động</h4>
            @else
            @php
            $ngaydong = date('d/m/Y', strtotime($hotel->h_dateclose));
            $ngaymo = date('d/m/Y', strtotime($hotel->h_dateopen));
            @endphp
                <h4 class="text-danger">đóng cửa ({{$ngaydong .' tới '. $ngaymo}})</h4>
            @endif
        </div>
        <form 
        @if($hotel->h_isclose == 0)
        action="{{ route('closehotel', ['hid' => $hotel->h_id]) }}"
        @else
        action="{{ route('openhotel', ['hid' => $hotel->h_id]) }}"
        @endif
        method="POST" class="row mt-2">
            @method('PUT')
            @csrf
            <div class="col-md-8 col-12 d-flex align-items-end gap-2">
                <div class="flex-fill"><label for="ngayBD">ngày đóng cửa</label>
                    <input id="inputCin" type="date" name="dayclose" class="form-control border-secondary w-100"
                    @if ($hotel->h_isclose == 1) disabled @endif>
                </div>
                <div class="flex-fill"><label for="ngayKT">ngày mở lại</label>
                    <input id="inputCout" type="date" name="dayopen" class="form-control border-secondary w-100"
                    @if ($hotel->h_isclose == 1) disabled @endif>
                </div>
            </div>
            <div class="col-md-4 col-12 d-flex align-items-end gap-2">
                <div class="flex-fill">
                    <label for="passcheck">nhập mật khẩu xác nhận</label>
                    <input type="password" name="pw" class="form-control border-secondary w-100" id="pascheck">
                </div>
            </div>
            <div class="col-12 text-center mt-4">
                @if ($hotel->h_isclose == 0)
                    <button type="submit" class="btn btn-danger">Đóng cửa</button>
                @else
                    <button type="submit" class="btn btn-success">Mở cửa</button>
                @endif
            </div>
        </form> 
    </section>
    <script>
        window.handleDateChange = function() {
            const checkinInput = document.getElementById("inputCin");
            const checkoutInput = document.getElementById("inputCout");

            const checkinDateStr = checkinInput.value;
            const checkoutDateStr = checkoutInput.value;

            const checkinDate = new Date(checkinDateStr);
            const checkoutDate = new Date(checkoutDateStr);

            // Kiểm tra nếu ngày check-out < ngày check-in
            if (checkoutDateStr && checkoutDate < checkinDate) {
                // alert("Ngày check-out không được nhỏ hơn hoặc bằng ngày check-in.");
                checkoutInput.value = ""; // Reset ngày check-out
                return;
            }

            // Nếu ngày check-in > ngày check-out
            if (checkinDateStr && checkoutDateStr && checkinDate > checkoutDate) {
                // alert("Ngày check-in không được lớn hơn hoặc bằng ngày check-out.");
                checkoutInput.value = ""; // Reset ngày check-out
                return;
            }
        };

        // Lắng nghe sự kiện thay đổi ngày check-in và check-out
        document.getElementById("inputCin").addEventListener('change', handleDateChange);
        document.getElementById("inputCout").addEventListener('change', handleDateChange);
    </script>
    @include('footer')
    @vite('resources/js/owner.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
