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
        <h1 class="text-center">Để Lại Đánh Giá {{ $ddp->hotel->h_name }}</h1>
        <hr>
        <form action="{{route('createdanhgia')}}" method="POST">
            @csrf
        @foreach ($ddp->detail_ddps as $detail)
            @php
                $room = $detail->room;
                $hotel = $room->hotel;

                $firstImage = $room->room_imgs->firstWhere('ri_vitri', 1);
                $phandu = $room->r_id % 5;
                if ($phandu != 0) {
                    $roomnumber = $phandu;
                } else {
                    $roomnumber = 5;
                }
                $roomimgsrc = '/images/hotels/h' . $hotel->h_id . '/room/r' . $roomnumber . '/' . $firstImage->ri_name;

                $daycheckin = date('\\n\gà\y j \\t\há\n\g n \\n\ă\m Y', strtotime($detail->detail_checkin));
                $daycheckout = date('\\n\gà\y j \\t\há\n\g n \\n\ă\m Y', strtotime($detail->detail_checkin));

                $allow = '';
                $room = $detail->room;
                if ($room->r_maxadult != 0 && $room->r_maxkid != 0) {
                    $allow = $room->r_maxadult . ' người lớn, ' . $room->r_maxkid . ' trẻ em';
                } elseif ($room->r_maxadult != 0 && $room->r_maxkid == 0) {
                    $allow = $room->r_maxadult . ' người lớn';
                } else {
                    $allow = $room->r_maxperson . ' người lớn và trẻ em';
                }
            @endphp
            <div class="border border-secondary-subtle rounded-3 p-2">
                <input type="hidden" name="listdetailid[]" value="{{$detail->detail_id}}">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-4">
                        <img src="{{ $roomimgsrc }}" class="imgcart w-100 h-100">
                    </div>
                    <div class="col-lg-5 col-md-9 col-8 p-2">
                            <h5>{{ $room->r_name }}</h5>
                        <div class="me-2"><small><i class="bi bi-calendar2-check"></i>
                                {{ $daycheckin }} <i class="bi bi-arrow-right"></i>
                                {{ $daycheckout }}</small></div>
                        <div class="me-2"><small><i class="bi bi-person"></i> tối
                                đa:
                                {{ $allow }}/phòng || số lượng:
                                {{ $detail->detail_soluong }} phòng</small>
                        </div>
                        <h5 class="mt-2">
                            Thành
                            tiền:
                            {{ number_format($detail->detail_thanhtien, 0, ',', '.') }} VNĐ</h5>
                    </div>
                    <div class="col-lg-5 col-12">
                        @php
                            $stars = [
                                1 => '1 sao',
                                2 => '2 sao',
                                3 => '3 sao',
                                4 => '4 sao',
                                5 => '5 sao',
                            ];
                        @endphp
                        <select name="listsao[]" class="form-select border-secondary w-50 mt-2">
                            @foreach ($stars as $value => $name)
                                <option @if ($value == 5) selected @endif value="{{ $value }}">
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <textarea name="listnhanxet[]" style="height:80px" class="form-control border-secondary mt-2 me-2" placeholder="Hãy để lại nhận xét của bạn..."></textarea>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="mt-2 text-center">
        <button class="btn btn-primary btn-lg">Gửi đánh giá</button>
        </div>
    </form>
    </section>

    @include('footer')
    @vite('resources/js/customer.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
