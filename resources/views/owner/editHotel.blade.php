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

    <section class="noidung">
        <div class="container p-4">
            <a href="{{ route('mainowner')}}"><button type="button" class="btn btn-danger"><i
                        class="bi bi-caret-left-fill"></i> trở về</button></a>
            <div class="row">
                <h1 class="text-center">Sửa Thông Tin Khách Sạn</h1>
                <form id="formAddHotel" class="row g-3 needs-validation" novalidate>
                    <div style="font-weight: 600;">Ảnh khách sạn</div>
                    <div class="col-12" id="add-hotel-image">
                        <div class="zone-display-image scroll-1 border border-secondary" id="displayHotelImage">
                            @foreach ($hotel->hotel_imgs as $himg)
                                <div class="image-container draggable" draggable="true">
                                    <button type="button" class="btn-close" aria-label="Close"
                                        onclick="removeImage(this)"></button>
                                    <img src="{{ '/images/hotels/h' . $hotel->h_id . '/' . $himg->hi_name }}"
                                        class="add-image m-1" alt="ảnh không tồn tại">
                                </div>
                            @endforeach
                            <div class="m-1" id="btnAddImage">
                                <label for="nutThemAnh"><i class="bi bi-plus-square icon-add-room"></i></label>
                            </div>
                        </div>
                        <input type="file" class="form-control d-none" id="nutThemAnh"
                            onchange="displayAnh(event, 'displayHotelImage', 'btnAddImage')" required />
                        <div class="invalid-feedback">
                            hãy thêm ảnh cho khách sạn
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="add-hotel-type" class="form-label">Loại Hình</label>
                        <select class="form-select border-secondary" id="add-hotel-type" required>
                            @foreach ($loaihinhs as $lh)
                                <option value="{{ $lh->lh_id }}" @if ($lh->lh_id == $hotel->lh_id) selected @endif>
                                    {{ $lh->lh_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            hãy chọn loại hình
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="add-hotel-city" class="form-label">Thành Phố</label>
                        <select class="form-select border-secondary" id="add-hotel-city" required>
                            @foreach ($cities as $city)
                                <option value="{{ $city->ct_id }}" @if ($city->ct_id == $hotel->ct_id) selected @endif>
                                    {{ $city->ct_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            hãy chọn thành phố
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="add-hotel-phone" class="form-label">Số Điện Thoại</label>
                        <input type="text" class="form-control border-secondary" id="add-hotel-phone" value="{{ $hotel->h_sdt }}"
                            required>
                        <div class="invalid-feedback">
                            hãy nhập số điện thoại
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="add-hotel-name" class="form-label">Tên Khách Sạn</label>
                        <input type="text" class="form-control border-secondary" id="add-hotel-name" value="{{ $hotel->h_name }}"
                            required>
                        <div class="invalid-feedback">
                            hãy nhập tên khách sạn
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="add-hotel-address" class="form-label">Địa Chỉ</label>
                        <input type="text" class="form-control border-secondary" id="add-hotel-address" value="{{ $hotel->h_dchi }}"
                            required>
                        <div class="invalid-feedback">
                            hãy nhập địa chỉ
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="add-hotel-describe" class="form-label">Mô tả khách sạn</label>
                        <textarea name="" class="form-control border-secondary" id="add-hotel-describe" style="height: 120px;" required>{{ $hotel->h_mota }}</textarea>
                        <div class="invalid-feedback">
                            hãy nhập mô tả khách sạn
                        </div>
                    </div>

                    <div class="col-4">
                        <label for="edit-hotel-pm" class="form-label">Thông tin thanh toán</label>
                        <select class="form-select border-secondary" id="edit-hotel-pm" required>
                            @foreach ($hotelpminfo as $pm)
                                <option value="{{ $pm->pm_id }}" @if ($pm->pm_id == $hotel->pm_id) selected @endif>
                                    {{ $pm->pm_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            hãy chọn thông tin thanh toán
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-label">Tiện ích phòng</div>
                        <div class="row g-2 mt-1">
                            @foreach($tiennghihotel as $tn)
                            <div class="form-check col-3 col-md-2">
                                <input class="form-check-input border-secondary" type="checkbox" value="" id="add-room-utilities">
                                <label class="form-check-label" for="add-room-utilities">
                                    {{$tn->tn_name}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Lưu</button>
                    </div>
                </form>

            </div>

        </div>
    </section>

    @vite('resources/js/owner.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
