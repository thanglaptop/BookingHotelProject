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
        <a href="{{ route('paymentinfo') }}"><button type="button" class="btn btn-danger"><i
            class="bi bi-caret-left-fill"></i> trở về</button></a>
        <h1 class="text-center">Sửa Thông Tin Thanh Toán</h1>
        <hr>
        <form id="formEditPM" class="row g-3 needs-validation" novalidate>
            <div class="col-12">
                <label for="add-pm_name" class="form-label">Tên thông tin thanh toán</label>
                <input type="text" class="form-control border-secondary" id="add-pm_name" value="{{ $pm->pm_name }}"
                    required>
                <div class="invalid-feedback">
                    hãy nhập tên thông tin thanh toán
                </div>
            </div>
            <div class="col-12">
                {{-- <label for="add-hotel-pm1" class="form-label">Phương thức thanh toán</label> --}}
                <div class="form-check form-switch">
                    <input class="form-check-input border-secondary" type="checkbox" role="switch" id="add-pm-athotel"
                        @if ($pm->pm_athotel == 1) checked @endif >
                    <label class="form-check-label" for="add-pm-athotel">Cho phép thanh toán
                        tại khách sạn</label>
                </div>
            </div>
            <div class="col-6 p-2">
                <div style="font-weight: 600;">Momo</div>
                <div class="row d-flex align-items-center">

                    <div class="col-md-7 col-12">
                        <label for="add-pm-momo" class="form-label">Số momo</label>
                        <input type="text" class="form-control border-secondary" id="add-pm-momo"
                            value="{{ $pm->pm_momo }}" required>
                        <div class="invalid-feedback">
                            hãy nhập số momo
                        </div>
                    </div>

                    <div class="col-md-5 col-12 mt-2">
                        <div class="d-flex justify-content-center mb-2">
                            <img id="selectedMomo" src="/images/other/placeholder-image.png" class="rounded"
                                style="width: 100px; height: 100px; object-fit: cover;" />
                        </div>
                        <div class="d-flex justify-content-center">
                            <div data-mdb-ripple-init class="btn btn-info btn-sm">
                                <label class="form-label text-white m-1" for="QRMomo">QR Momo</label>
                                <input type="file" class="form-control d-none" id="QRMomo"
                                    onchange="displaySelectedImage(event, 'selectedMomo')" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 p-2">
                <div style="font-weight: 600;">Ngân hàng</div>
                <div class="row d-flex align-items-center">
                    <div class="col-md-7 col-12">
                        <label for="add-pm-bank" class="form-label">Số ngân hàng</label>
                        <input type="text" class="form-control border-secondary" id="add-pm-bank"
                            value="{{ $pm->pm_bank }}" required>
                        <div class="invalid-feedback">
                            hãy nhập số momo
                        </div>
                    </div>

                    <div class="col-md-5 col-12 mt-2">
                        <div class="d-flex justify-content-center mb-2">
                            <img id="selectedBank" src="/images/other/placeholder-image.png" class="rounded"
                                style="width: 100px; height: 100px; object-fit: cover;" />
                        </div>
                        <div class="d-flex justify-content-center">
                            <div data-mdb-ripple-init class="btn btn-info btn-sm">
                                <label class="form-label text-white m-1" for="QRBank">QR Bank</label>
                                <input type="file" class="form-control d-none" id="QRBank"
                                    onchange="displaySelectedImage(event, 'selectedBank')" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Lưu</button>
            </div>
        </form>
    </section>

    @vite('resources/js/owner.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
