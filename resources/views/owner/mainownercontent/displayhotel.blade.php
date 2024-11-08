<div class="row">
    @if ($owner->hotels != null)
        @foreach ($owner->hotels as $hotel)
            @php
                $firstImage = $hotel->hotel_imgs->firstWhere('hi_vitri', 1);
                $imgpath = $firstImage
                    ? '/images/hotels/h' . $hotel->h_id . '/' . $firstImage->hi_name
                    : '/images/other/placeholder-image.png';
            @endphp
            <div class="col-lg-3 col-md-4 col-6 p-2">
                <div class="card h-100">
                    <img src="{{ $imgpath }}" class="card-img-top h-100" alt="ảnh không tồn tại">
                    <div class="card-body">
                        <h4 class="card-title scroll-1">{{ $hotel->h_name }}</h4>
                        <div class="nhom-button">
                            <a href="{{ route('managehotel', ['id' => $hotel->h_id]) }}"> <button type="button" class="btn btn-primary btn-sm">Quản
                                    Lý</button>
                            </a>

                            <a href="{{ route('edithotel', ['id' => $hotel->h_id]) }}"><button type="button"
                                    class="btn btn-secondary btn-sm">Sửa</button></a>
                            <button type="button" class="btn btn-danger btn-sm">Đóng Cửa</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <div class="col-lg-3 col-md-4 col-6 p-2">
        <div class="card h-100" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#add-hotel-modal">
            <img alt="" src="/images/other/plus-sign.png" class="card-img-top last-card p-4" />
            <div class="card-body">
                <h4 class="card-title scroll-1">
                    Thêm khách sạn mới
                </h4>
            </div>

        </div>
    </div>
</div>
