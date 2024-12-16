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
        @if (Auth::guard('owner')->check())
            <a href="{{ session('previous_url', route('owner.managehotel', ['id' => $ddp->h_id, 'tab' => 'don-dat-phong'])) }}">
            @elseif(Auth::guard('employee')->check())
                <a href="{{ session('previous_url', route('employee.managehotel', ['id' => $ddp->h_id, 'tab' => 'don-dat-phong'])) }}">
        @endif
        <button type="button" class="btn btn-danger"><i class="bi bi-caret-left-fill"></i> trở về</button></a>
        <h1 class="text-center">Chi Tiết Đơn Đặt Phòng</h1>
        <hr>
        <div class="row">
            @php
                switch ($ddp->ddp_pttt) {
                    case 'momo':
                        $pttt = 'Momo';
                        break;
                    case 'bank':
                        $pttt = 'Ngân hàng';
                        break;
                    default:
                        $pttt = 'Trực tiếp';
                        break;
                }
                $stt = 1;
                $day = $ddp->detail_ddps->first();
            @endphp
            <div class="col-lg-3 col-6"><strong>Họ và tên: </strong>{{ $ddp->ddp_customername }}</div>
            <div class="col-lg-3 col-6"><strong>Số điện thoại: </strong>{{ $ddp->ddp_sdt }}</div>
            <div class="col-lg-2 col-6"><strong>Ngày đặt: </strong>{{ date('d/m/Y', strtotime($ddp->ddp_ngaydat)) }}
            </div>
            <div class="col-lg-4 col-6"><strong>Phương thức thanh toán: </strong>{{ $pttt }}</div>
            <div class="col-lg-3 col-6"><strong>Check-in: </strong>{{ date('d/m/Y', strtotime($day->detail_checkin)) }}
            </div>
            <div class="col-lg-3 col-6"><strong>Check-out:
                </strong>{{ date('d/m/Y', strtotime($day->detail_checkout)) }}</div>
        </div>
        <div class="border-table scroll-1 p-2">
            <table class="table table-hover ">
                <thead class="sticky-top">
                    <th>STT</th>
                    <th>Tên phòng</th>
                    <th>Số lượng</th>
                    <th>Số đêm</th>
                    <th>Giá</th>
                    <th>Tổng tiền</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($ddp->detail_ddps as $detail)
                        @php
                            $tenphong = $listroom->where('r_id', $detail->r_id)->first()->r_name;
                            $sodem =
                                (strtotime($detail->detail_checkout) - strtotime($detail->detail_checkin)) /
                                (60 * 60 * 24);
                            $giaphong = number_format(
                                $listroom->where('r_id', $detail->r_id)->first()->r_price,
                                0,
                                ',',
                                '.',
                            );
                            $thanhtien = number_format($detail->detail_thanhtien, 0, ',', '.');
                        @endphp
                        <tr>
                            <td>{{ $stt++ }}</td>
                            <td>{{ $tenphong }}</td>
                            <td>{{ $detail->detail_soluong }}</td>
                            <td>{{ $sodem }}</td>
                            <td>{{ $giaphong }} VNĐ</td>
                            <td>{{ $thanhtien }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="sticky-bottom">
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Thành tiền:</th>
                    <th>{{ number_format($ddp->ddp_total, 0, ',', '.') }} VNĐ</th>
                    <th></th>
                </tfoot>
            </table>
        </div>
        @php
            $status = [
                'pending' => ['label' => 'Chờ duyệt', 'color' => 'bg-info'],
                'confirmed' => ['label' => 'Xác nhận', 'color' => 'bg-primary'],
                'checkedin' => ['label' => 'Đã checkin', 'color' => 'bg-warning'],
                'completed' => ['label' => 'Hoàn thành', 'color' => 'bg-success'],
                'rated' => ['label' => 'Đã đánh giá', 'color' => 'bg-success'],
                'canceled' => ['label' => 'Đã hủy', 'color' => 'bg-danger'],
            ];
        @endphp
        <div class="row mt-2">
            <form
                @if (Auth::guard('owner')->check()) action="{{ route('owner.updateddp') }}"
            @elseif(Auth::guard('employee')->check())
            action="{{ route('employee.updateddp') }}" @endif
                method="POST">
                @method('PUT')
                @csrf
                <input type="hidden" name="ddpid" value="{{ $ddp->ddp_id }}">
                <div class="col-lg-6 col-12 d-flex justify-content-between align-items-center text-nowrap">
                    @if ($ddp->ddp_status == 'completed' || $ddp->ddp_status == 'rated' || $ddp->ddp_status == 'canceled')
                        <strong>Trạng thái: 
                        <span @if($ddp->ddp_status == 'canceled') class="text-danger" @else class="text-success" @endif>{{ $status[$ddp->ddp_status]['label'] }}</span>
                        </strong>
                    @else
                        <strong>Trạng thái:</strong>
                        <select class="form-select bg-primary text-white mx-2" id="statusddp" name="status">
                            @foreach ($status as $key => $value)
                            @if($key != 'rated')
                                <option class="bg-light text-dark" data-color="{{ $value['color'] }}"
                                    value="{{ $key }}" @if ($key == $ddp->ddp_status) selected @endif>
                                    {{ $value['label'] }}
                                </option>
                                @endif
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    @endif
                </div>
            </form>
        </div>

    </section>
    <script>
        document.getElementById('statusddp').addEventListener('change', function() {
            // Lấy option được chọn
            const selectedOption = this.options[this.selectedIndex];
            const colorClass = selectedOption.getAttribute('data-color');

            // Xóa tất cả các lớp màu cũ khỏi select
            this.className = 'form-select border-secondary text-white mx-2';

            // Thêm lớp màu mới
            this.classList.add(colorClass);
        });

        // Thiết lập màu ban đầu
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('statusddp');
            const selectedOption = select.options[select.selectedIndex];
            const colorClass = selectedOption.getAttribute('data-color');
            select.classList.add(colorClass);
        });
    </script>

@include('footer')
    @vite('resources/js/owner.js')
    @vite('resources/js/ddp.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
