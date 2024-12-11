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
        <form id="formEditPM" action="{{route('updatepaymentinfo')}}" class="row g-3 needs-validation" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')
            <input type="hidden" name="pmid" value="{{$pm->pm_id}}">
            <div class="col-12">
                <label for="add-pm_name" class="form-label">Tên thông tin thanh toán</label>
                <input type="text" name="namepm" class="form-control border-secondary pm-name" id="add-pm_name" value="{{ $pm->pm_name }}"
                    required>
                <div class="invalid-feedback pm-name-feedback">
                    hãy nhập tên thông tin thanh toán
                </div>
            </div>
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input border-secondary" name="allowpayathotel" type="checkbox" role="switch" id="add-pm-athotel"
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
                        <input type="text" name="momonumber" class="form-control border-secondary momo-number" id="add-pm-momo"
                            value="{{ $pm->pm_momo }}" required>
                        <div class="invalid-feedback momo-number-feedback">
                            hãy nhập số momo
                        </div>
                    </div>

                    <div class="col-md-5 col-12 mt-2">
                        <div class="d-flex justify-content-center mb-2">
                            <img id="selectedMomo" src="/images/QRmomo/{{$pm->pm_QRmomo}}" class="rounded"
                                style="width: 100px; height: 100px; object-fit: cover;" />
                        </div>
                        <div class="d-flex justify-content-center">
                            <div data-mdb-ripple-init class="btn btn-info btn-sm">
                                <label class="form-label text-white m-1" for="QRMomo">QR Momo</label>
                                <input type="file" name="momoQR" class="form-control d-none" id="QRMomo"
                                    onchange="displaySelectedImage(event, 'selectedMomo')" required/>
                                    <div class="invalid-feedback">
                                        hãy thêm ảnh QR momo
                                    </div>
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
                        <input type="text" name="banknumber" class="form-control border-secondary bank-number" id="add-pm-bank"
                            value="{{ $pm->pm_bank }}" required>
                        <div class="invalid-feedback bank-number-feedback"> 
                            hãy nhập số momo
                        </div>
                    </div>

                    <div class="col-md-5 col-12 mt-2">
                        <div class="d-flex justify-content-center mb-2">
                            <img id="selectedBank" src="/images/QRbank/{{$pm->pm_QRbank}}" class="rounded"
                                style="width: 100px; height: 100px; object-fit: cover;" />
                        </div>
                        <div class="d-flex justify-content-center">
                            <div data-mdb-ripple-init class="btn btn-info btn-sm">
                                <label class="form-label text-white m-1" for="QRBank">QR Bank</label>
                                <input type="file" name="bankQR" class="form-control d-none" id="QRBank"
                                    onchange="displaySelectedImage(event, 'selectedBank')" required/>
                                    <div class="invalid-feedback">
                                        hãy thêm ảnh QR ngân hàng
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <label for="add-pm-describe" class="form-label">Mô tả thông tin thanh toán</label>
                <textarea name="mota" class="form-control border-secondary pm-mota-input" id="add-pm-describe" style="height: 120px;" required>{{$pm->pm_mota}}</textarea>
                <div class="invalid-feedback pm-mota-feedback">
                    hãy nhập mô tả thông tin thanh toán
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Lưu</button>
            </div>
        </form>
    </section>

    @vite('resources/js/managepaymentinfo.js')
    @vite('resources/js/owner.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
