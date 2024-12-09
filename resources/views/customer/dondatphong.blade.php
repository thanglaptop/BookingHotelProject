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

    <section class="container p-4">
        <h1 class="text-center">Đơn Đặt Phòng</h1>
        <hr>
        @if ($listddp->isEmpty())
            <div class="d-flex flex-column align-items-center">
                <img src="/images/other/find.png" style="width:300px; height:300px">
                <h3>Bạn chưa có đơn đặt phòng nào</h3>
            </div>
        @else
            <div class="accordion" id="accordionDDP">
                @foreach ($listddp as $ddp)
                    @php
                        switch ($ddp->ddp_status) {
                            case 'confirmed':
                                $status = '<div class="text-primary">Xác nhận</div>';
                                break;
                            case 'checkedin':
                                $status = '<div class="text-warning">Đã checkin</div>';
                                break;
                            case 'completed':
                                $status = '<div class="text-success">Hoàn thành</div>';
                                break;
                                case 'rated':
                                $status = '<div class="text-success">Đã đánh giá</div>';
                                break;
                            case 'canceled':
                                $status = '<div class="text-danger">Đã hủy</div>';
                                break;
                            default:
                                $status = '<div class="text-info">Chờ duyệt</div>';
                                break;
                        }
                    @endphp
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $ddp->ddp_id }}" aria-expanded="false"
                                aria-controls="collapse{{ $ddp->ddp_id }}">
                                <div class="d-flex gap-3">
                                    <div><strong>{{ $ddp->hotel->h_name }}</strong></div>
                                    <div>||</div>
                                    <div>{{ date('d/m/Y', strtotime($ddp->ddp_ngaydat)) }}</div>
                                    <div>||</div>
                                    <div>{{ number_format($ddp->ddp_total, 0, ',', '.') }} VNĐ</div>
                                    <div>||</div>
                                    {!! $status !!}
                                </div>
                            </button>

                        </h2>
                        <div id="collapse{{ $ddp->ddp_id }}" class="accordion-collapse collapse"
                            data-bs-parent="#accordionDDP">
                            <div class="accordion-body">
                                @foreach ($ddp->detail_ddps as $detail)
                                    @php
                                        $allow = '';
                                        $room = $detail->room;
                                        if ($room->r_maxadult != 0 && $room->r_maxkid != 0) {
                                            $allow = $room->r_maxadult . ' người lớn, ' . $room->r_maxkid . ' trẻ em';
                                        } elseif ($room->r_maxadult != 0 && $room->r_maxkid == 0) {
                                            $allow = $room->r_maxadult . ' người lớn';
                                        } else {
                                            $allow = $room->r_maxperson . ' người lớn và trẻ em';
                                        }
                                    @endphp
                                    <div class="border border-secondary-subtle rounded-3 m-2">
                                        <div class="row p-2">
                                            <div class="col-12">
                                                <h5>{{ $detail->room->r_name }}</h5>
                                                <div class="me-2"><small><i class="bi bi-calendar2-check"></i>
                                                        {{ date('d/m/Y', strtotime($detail->detail_checkin)) }}
                                                    </small><i class="bi bi-arrow-right"></i>
                                                    {{ date('d/m/Y', strtotime($detail->detail_checkin)) }}</div>
                                                <div class="me-2"><small><i class="bi bi-person"></i> tối đa:
                                                        {{ $allow }}/phòng || số lượng:
                                                        {{ $detail->detail_soluong }}phòng</small>
                                                </div>
                                                <h5 class="mt-2">Thành tiền:
                                                    {{ number_format($detail->detail_thanhtien, 0, ',', '.') }}
                                                    VNĐ</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="d-flex align-items-end flex-column">
                                    <p class="m-2">
                                        @if ($ddp->ddp_status == 'completed')
                                            <a href="{{route('showdanhgia', ['ddpid' => $ddp->ddp_id])}}"><button class="btn btn-primary">Đánh giá</button></a>
                                        @elseif($ddp->ddp_status == 'rated')
                                        <a href="{{route('seedanhgia', ['hid' => $ddp->h_id])}}#{{$ddp->ddp_id}}"><button class="btn btn-primary">Xem Đánh giá</button></a>
                                        @endif
                                        @if ($ddp->ddp_status == 'pending')
                                            <button class="btn btn-danger" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapsecancel{{$ddp->ddp_id}}" aria-expanded="false"
                                                aria-controls="collapsecancel{{$ddp->ddp_id}}">
                                                Hủy đơn đặt phòng
                                            </button>
                                        @endif
                                    </p>
                                    @if ($ddp->ddp_status == 'pending')
                                        <div class="collapse m-2" id="collapsecancel{{$ddp->ddp_id}}">
                                            <div class="card card-body">
                                                <h6>
                                                    Bạn có chắc muốn hủy không?
                                                </h6>
                                                <div class="d-flex justify-content-end gap-2"><button
                                                        class="btn btn-secondary btn-sm" data-bs-toggle="collapse"
                                                        data-bs-target="#collapsecancel{{$ddp->ddp_id}}">Không</button>
                                                    <a href="{{route('cancelddp', ['ddpid' => $ddp->ddp_id])}}"><button class="btn btn-danger btn-sm">Hủy</button></a>
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="height: 100px;"></div>
        @endif
    </section>

    @include('footer')
    @vite('resources/js/customer.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
