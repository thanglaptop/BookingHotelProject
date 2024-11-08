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
    
    @include('owner/header')

    <section class="noidung">
        <div class="container p-4">
                <a href="{{ route('managehotel', ['id' => $room->h_id]) }}"><button type="button" class="btn btn-danger"><i class="bi bi-caret-left-fill"></i> trở về</button></a>
                <div class="row">
                    <h1 class="text-center">Sửa Thông Tin Phòng</h1>
                    <form id="formAddHotel" class="row g-3 needs-validation" novalidate>
                        <div style="font-weight: 600;">Ảnh phòng</div>
                        <div class="col-12" id="add-room-image">
                            <div class="zone-display-image scroll-1 border" id="displayRoomImage">

                                @php
                                    $phandu = $room->r_id % 5;
                                    if($phandu != 0)
                                        $roomnumber = $phandu;
                                    else $roomnumber = 5;
                                @endphp
                                @foreach ($room->room_imgs as $img)
                                @php
                                $roompath = '/images/hotels/h'.$room->hotel->h_id.'/room/r'.$roomnumber.'/'.$img->ri_name;
                            @endphp
                                <div class="image-container draggable" draggable="true">
                                    <button type="button" class="btn-close" aria-label="Close"
                                        onclick="removeImage(this)"></button>
                                    <img src="{{$roompath}}"
                                        class="add-image m-1" alt="ảnh không tồn tại">
                                </div>
                            @endforeach
                                <div class="m-1" id="btnAddImage">
                                    <label for="nutThemAnh"><i class="bi bi-plus-square icon-add-room"></i></label>
                                </div>
                            </div>
                            <input type="file" class="form-control d-none" id="nutThemAnh"
                                onchange="displayAnh(event, 'displayRoomImage', 'btnAddImage')" required />
                            <div class="invalid-feedback">
                                hãy thêm ảnh cho phòng
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="add-room-name" class="form-label">Tên phòng</label>
                            <input type="text" class="form-control" id="add-room-name" value="{{$room->r_name}}" required>
                            <div class="invalid-feedback">
                                hãy nhập tên phòng
                            </div>
                        </div>
                        <div class="col-8">
                            <label for="add-room-price" class="form-label">Giá phòng</label>
                            <input type="text" class="form-control" id="add-room-price" value="{{$room->r_price}}" required>
                            <div class="invalid-feedback">
                                hãy nhập giá phòng
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="add-room-quantity" class="form-label">Số lượng phòng</label>
                            <input type="number" class="form-control" id="add-room-quantity" value="{{$room->r_soluong}}" required>
                            <div class="invalid-feedback">
                                hãy nhập số lượng phòng
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="add-room-describe" class="form-label">Mô tả phòng</label>
                            <textarea name="" class="form-control" id="add-room-describe" style="height: 120px;"
                                required>{{$room->r_mota}}</textarea>
                            <div class="invalid-feedback">
                                hãy nhập mô tả phòng
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-label">Tiện ích phòng</div>
                            <div class="row g-2 mt-1">
                                @foreach($tiennghiroom as $tn)
                                <div class="form-check col-3">
                                    <input class="form-check-input" type="checkbox" name="tiennghi[]" id="add-room-utilities">
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
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>