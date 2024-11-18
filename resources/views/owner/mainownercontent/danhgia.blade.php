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
        <h1 class="text-center">Đánh Giá</h1>
        <hr>
        <div class="row mt-3">
            <div class="col-5">
                <label for="search-by-month" class="form-label">Khách sạn</label>
                <select class="form-select border-secondary" id="search-by-month">
                    <option value="allhotel">Xem tất cả</option>
                    @foreach($owner->hotels as $hotel)
                        <option value="{{$hotel->h_id}}">{{$hotel->h_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-5">
                <label for="search-by-month" class="form-label">Lượt sao</label>
                <select class="form-select border-secondary" id="search-by-month">
                    <option value="allstar">Xem tất cả</option>
                    @for($sao = 1; $sao < 6; $sao++)
                        <option value="sao{{$sao}}">{{$sao}} sao</option>
                    @endfor
                </select>
            </div>
            <div class="col-2 d-flex align-items-end"><button class="btn btn-primary">Xem</button></div>
        </div>
        <div class="row mt-4">
            @for ($i = 0; $i < 10; $i++)
                <div class="col-12 p-2">
                    <div class="h-100 border rounded-4 border-secondary-subtle">
                        <div class="p-3">
                            <h4 class="card-title">Nhà Bà Tư Boutique Hotel</h4>
                            <div>Phòng Tiêu Chuẩn Hướng Núi (Standard)</div>
                            <div class="star">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe, illo eaque minus perferendis, porro, non doloremque sed dolores accusantium blanditiis nesciunt! Repellendus esse laborum aliquid? Earum modi accusamus sed consequatur.</div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </section>

@vite('resources/js/owner.js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
</body>

</html>