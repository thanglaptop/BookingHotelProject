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
    @php
        $customer = Auth::guard('customer')->user();
        $listroom = $customer->hasManyRoomInGiohang;
        $listhotel = [];
        for ($i = 0; $i < count($listroom); $i++) {
            if (!in_array($listroom[$i]['hotel'], $listhotel)) {
                $listhotel[] = $listroom[$i]['hotel'];
            }
        }
    @endphp
    <section class="container p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Giỏ Hàng @if (count($listroom) != 0)
                    ({{ count($listroom) }} phòng)
                @endif
            </h1>
            <div>
                <button class="btn btn-primary">Đặt Đơn</button>
                <button class="btn btn-danger">Xóa</button>
            </div>
        </div>

        <hr>
        <div class="row mt-4">
            @if ($listroom != null)
                @foreach ($listhotel as $hotel)
                    <div class="border p-2 mb-3 border-secondary rounded-3">
                        <div class="d-flex align-items-center">
                            <input class="form-check-input border-secondary" type="checkbox" value="">
                            <h3 class="mb-0 ms-2"><a style="text-decoration:none;" href="{{route('showdetailhotel', ['id' => $hotel->h_id])}}">{{ $hotel->h_name }}</a> (<i class="bi bi-geo-alt-fill"></i>
                                {{ $hotel->city->ct_name }})</h3>
                        </div>
                        @foreach ($listroom as $room)
                            @if ($room->h_id == $hotel->h_id)
                                @php
                                    $firstImage = $room->room_imgs->firstWhere('ri_vitri', 1);
                                    $phandu = $room->r_id % 5;
                                    if ($phandu != 0) {
                                        $roomnumber = $phandu;
                                    } else {
                                        $roomnumber = 5;
                                    }
                                    $roomimgsrc =
                                        '/images/hotels/h' .
                                        $hotel->h_id .
                                        '/room/r' .
                                        $roomnumber .
                                        '/' .
                                        $firstImage->ri_name;

                                    $checkin = date(
                                        '\\n\gà\y j \\t\há\n\g n \\n\ă\m Y',
                                        strtotime($room->pivot->g_checkin),
                                    );
                                    $checkout = date(
                                        '\\n\gà\y j \\t\há\n\g n \\n\ă\m Y',
                                        strtotime($room->pivot->g_checkout),
                                    );

                                    $allow = '';
                                    if ($room->r_maxadult != 0 && $room->r_maxkid != 0) {
                                        $allow = $room->r_maxadult . ' người lớn, ' . $room->r_maxkid . ' trẻ em';
                                    } elseif ($room->r_maxadult != 0 && $room->r_maxkid == 0) {
                                        $allow = $room->r_maxadult . ' người lớn';
                                    } else {
                                        $allow = $room->r_maxperson . ' người lớn và trẻ em';
                                    }
                                @endphp
                                <div class="border border-secondary-subtle rounded-3 m-2">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-4">
                                            <img src="{{ $roomimgsrc }}" class="imgcart w-100 h-100">
                                        </div>
                                        <div class="col-lg-10 col-md-9 col-8 p-2">
                                            <div class="d-flex justify-content-between">
                                                <h5>{{ $room->r_name }}</h5>
                                                <i class="bi bi-trash3 me-3" style="cursor: pointer;"></i>
                                            </div>
                                            <div class="me-2"><small><i class="bi bi-calendar2-check"></i>
                                                    {{ $checkin }} </small><i class="bi bi-arrow-right"></i>
                                                {{ $checkout }}</div>
                                            <div class="me-2"><small><i class="bi bi-person"></i> tối đa:
                                                    {{ $allow }}/phòng</small></div>
                                            <div class="mt-2">
                                                <button class="btn btn-outline-secondary btn-sm rounded-3"><i
                                                        class="bi bi-dash-lg"></i></i></button>
                                                {{ $room->pivot->g_soluong }} <button
                                                    class="btn btn-outline-secondary btn-sm rounded-3"><i
                                                        class="bi bi-plus-lg"></i></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    @include('footer')

    @vite('resources/js/customer.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
