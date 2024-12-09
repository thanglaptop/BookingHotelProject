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
        <form action="{{ route('danhgia') }}" method="GET">
            <div class="row mt-3">
                <div class="col-5">
                    <label for="search-by-hotel" class="form-label">Khách sạn</label>
                    <select name="hotel" class="form-select border-secondary" id="search-by-hotel">
                        <option value="0">Xem tất cả</option>
                        @foreach ($owner->hotels as $hotel)
                            <option value="{{ $hotel->h_id }}"
                                {{ request('hotel') == $hotel->h_id ? 'selected' : '' }}>{{ $hotel->h_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-5">
                    <label for="search-by-star" class="form-label">Lượt sao</label>
                    <select name="star" class="form-select border-secondary" id="search-by-star">
                        <option value="0">Xem tất cả</option>
                        @for ($sao = 1; $sao < 6; $sao++)
                            <option value="{{ $sao }}" {{ request('star') == $sao ? 'selected' : '' }}>
                                {{ $sao }} sao</option>
                        @endfor
                    </select>
                </div>
                <div class="col-2 d-flex align-items-end"><button type="submit" class="btn btn-primary">Xem</button>
                </div>
            </div>
        </form>
        <div class="row mt-4">
            @if ($listdetail->isEmpty())
                <div class="d-flex flex-column align-items-center">
                    <img src="/images/other/find.png" style="width:300px; height:300px">
                    <h3>Không có đánh giá nào phù hợp tiêu chí</h3>
                </div>
            @else
                @foreach ($listdetail as $dt)
                    <div class="col-12 p-2">
                        <div class="h-100 border rounded-4 border-secondary-subtle">
                            <div class="p-3">
                                <h4 class="card-title star">{{ $dt->dondatphong->hotel->h_name }} <i
                                        class="bi bi-star-fill"></i>
                                    {{ $dt->danhgia->dg_star }}</h4>
                                <div>{{ $dt->room->r_name }}</div>
                                <small>{{ date('d/m/Y', strtotime($dt->danhgia->dg_ngaydg)) }}</small>
                                <div class="card-text">{{ $dt->danhgia->dg_nhanxet }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    @include('footer')
    @vite('resources/js/owner.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
