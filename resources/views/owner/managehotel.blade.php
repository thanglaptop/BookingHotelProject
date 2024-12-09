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
            @if (Auth::guard('owner')->check())
                <a href="{{ route('mainowner') }}"><button type="button" class="btn btn-danger"><i
                            class="bi bi-caret-left-fill"></i> trở về</button></a>
            @endif
            <h1 class="text-center">{{ $hotel->h_name }}</h1>
            <nav class="mt-5">
                <div class="nav nav-tabs h3" id="nav-tab" role="tablist">
                    <button
                        @if ($tab != 'manage-phong') class="nav-link w-50 active"
                    @else class="nav-link w-50" @endif
                        id="tab-don-dat-phong" data-bs-toggle="tab" data-bs-target="#don-dat-phong" type="button"
                        role="tab" aria-controls="don-dat-phong" aria-selected="true">Đơn Đặt Phòng</button>
                    <button
                        @if ($tab == 'manage-phong') class="nav-link w-50 active"
                    @else class="nav-link w-50" @endif
                        id="tab-manage-phong" data-bs-toggle="tab" data-bs-target="#manage-phong" type="button"
                        role="tab" aria-controls="manage-phong" aria-selected="false">Quản Lý Phòng</button>

                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">

                @include('owner/managehotelcontent/managebooking')

                @include('owner/managehotelcontent/manageroom')

            </div>
    </section>

    @include('footer')
    @vite('resources/js/validateinput.js')
    @vite('resources/js/owner.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
