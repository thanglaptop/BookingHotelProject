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
                <a href="{{ session('previous_url', route('showddp')) }}">
            <button type="button" class="btn btn-danger"><i class="bi bi-caret-left-fill"></i> trở về</button></a>
        <h1 class="text-center star">Đánh Giá Của {{ $hotel->h_name }} - {{$hotel->average_star}} <i
            class="bi bi-star-fill"></i></h1>
        <hr>
        @if ($listdanhgia->isEmpty())
            <div class="d-flex flex-column align-items-center">
                <img src="/images/other/find.png" style="width:300px; height:300px">
                <h3>Khách sạn chưa có đánh giá nào nào</h3>
            </div>
        @else
            @foreach ($listdanhgia as $danhgia)
                <div class="border border-secondary rounded m-2 p-2" id="{{$danhgia->detail_ddp->dondatphong->ddp_id}}">
                    <h6 class="star">{{ $danhgia->customer->c_name }} đánh giá {{ $danhgia->dg_star }} <i
                            class="bi bi-star-fill"></i></h6>
                    <small>{{ date('d/m/Y', strtotime($danhgia->dg_ngaydg)) }}</small>
                    <div>{{ $danhgia->dg_nhanxet }}</div>
                </div>
            @endforeach
        @endif
    </section>
    <div style="height: 100px;"></div>
    @include('footer')
    @vite('resources/js/customer.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
