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
        $hotelpminfo = Auth::guard('owner')->user()->paymentInfos;
    @endphp
    <section class="noidung">
        <div class="container p-4">
            <button type="button" class=" btn btn-success" style="white-space: nowrap;" data-bs-toggle="modal"
                data-bs-target="#add-detail-ddp"><i class="bi bi-plus-circle"></i> Tạo</button>
            @include('owner/mainownercontent/pminfocontent/addpminfo')
            <div class="row">
                <div class="col-12 text-center">
                    <h3>Danh sách thông tin thanh toán</h3>
                </div>
                @foreach ($hotelpminfo as $pm)
                    <div class="p-4 pb-0">
                        <div class="card h-100">
                            <div class="row p-3">
                                <h4 class="card-title text-center">{{ $pm->pm_name }}</h4>
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="add-pm-athotel" @if ($pm->pm_athotel == 1) checked @endif
                                            disabled>
                                        <label class="form-check-label" for="add-pm-athotel"
                                            style="font-weight: 600;">Cho
                                            phép
                                            thanh toán
                                            tại khách sạn</label>
                                    </div>
                                </div>
                                <div
                                    class="col-6 col-md-3 p-2 gap-2 d-flex align-items-center justify-content-center flex-column">
                                    <div style="font-weight: 600;">Momo</div>
                                    <img src="/images/other/placeholder-image.png" class="rounded"
                                        style="width: 120px; height: 120px; object-fit: cover;" />
                                    <div>{{ $pm->pm_momo }}</div>
                                </div>

                                <div
                                    class="col-6 col-md-3 p-2 gap-2 d-flex align-items-center justify-content-center flex-column">
                                    <div style="font-weight: 600;">Ngân hàng</div>
                                    <img src="/images/other/placeholder-image.png" class="rounded"
                                        style="width: 120px; height: 120px; object-fit: cover;" />
                                    <div>{{ $pm->pm_bank }}</div>
                                </div>
                                <div class="col-12 col-md-5 p-2">{{ $pm->pm_mota }}</div>
                                <div class="nhom-button col-12">
                                    <a href="/owner/editRoom.html"><button type="button"
                                            class="btn btn-primary">Sửa</button></a>
                                    <button type="button" class="btn btn-danger">Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @vite('resources/js/owner.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
