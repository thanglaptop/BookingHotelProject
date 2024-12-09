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
            <div class="col-md-7 col-12">
                <form class="d-flex align-items-end gap-2" action="{{ route('doanhthu') }}" method="GET">
                    <div class="flex-fill"><label for="inputCin" class="form-label">ngày bắt đầu</label>
                        <input type="date" name="daystart" class="daystart form-control border-secondary w-100"
                            id="inputCin" value="{{ old('daystart', request('daystart', date('Y-m-d'))) }}">
                    </div>
                    <div class="flex-fill"><label for="inputCout" class="form-label">ngày kết thúc</label>
                        <input type="date" name="dayend" class="dayend form-control border-secondary w-100"
                            id="inputCout" value="{{ old('dayend', request('dayend', date('Y-m-d'))) }}">
                    </div>
                    <div>
                        <button type="submit" class=" btn btn-primary">Tìm</button>
                    </div>
                </form>
            </div>

            <div class="col-md-5 col-12">
                <form action="{{ route('doanhthu') }}" method="GET">
                    <label for="search-by-month" class="form-label">Xem theo tháng</label>
                    <select class="form-select border-secondary" name="thang" id="search-by-month"
                        onchange="this.form.submit()">
                        <option value="0">chọn tháng bạn muốn xem</option>
                        @for ($month = 1; $month < 13; $month++)
                            <option value="{{ $month }}" {{ request('thang') == $month ? 'selected' : '' }}>Tháng
                                {{ $month }}</option>
                        @endfor
                    </select>
                </form>
            </div>
        </div>
        <div class="row mt-2">
            @foreach ($owner->hotels as $hotel)
                @php
                    $doanhthu = $listhotelwithrevenue->firstWhere('h_id', $hotel->h_id)['h_doanhthu'] ?? 0;
                    $soddp = $listhotelwithrevenue->firstWhere('h_id', $hotel->h_id)['h_ddp'] ?? 0;
                @endphp
                <div class="col-lg-3 col-md-4 col-6 p-2">
                    <div class="h-100 border rounded-3 border-secondary p-3">
                        <h4 class="title">{{ $hotel->h_name }}</h4>
                        <div class="mt-2">Ngày bắt đầu: {{ date('d/m/Y', strtotime($ngaybd)) }}</div>
                        <div>Ngày kết thúc: {{ date('d/m/Y', strtotime($ngaykt)) }}</div>
                        <div><strong>Số đơn hoàn thành: {{ $soddp }}</strong></div>
                        <div><strong>Doanh thu: {{ number_format($doanhthu, 0, ',', '.') }} VNĐ</strong></div>
                    </div>
                </div>
            @endforeach
            <div class="col-lg-3 col-md-4 col-6 p-2">
                <div class="h-100 border rounded-3 border-primary p-3">
                    <h4 class="title text-primary">TỔNG DOANH THU</h4>
                    <div class="mt-2 text-primary">Ngày bắt đầu: {{ date('d/m/Y', strtotime($ngaybd)) }}</div>
                    <div class="text-primary">Ngày kết thúc: {{ date('d/m/Y', strtotime($ngaykt)) }}</div>
                    <div class="text-primary"><strong>Số đơn hoàn thành: {{ $totalddp }}</strong></div>
                    <div class="text-primary"><strong>Doanh thu: {{ number_format($totalrevenue, 0, ',', '.') }}
                            VNĐ</strong></div>
                </div>
            </div>
        </div>
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
