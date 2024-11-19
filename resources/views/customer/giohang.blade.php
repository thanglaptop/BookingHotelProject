@extends('layouts.app')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">Giỏ hàng của tôi</h2>
    <div class="cart-items">
        @forelse ($cartItems as $item)
            @php
                $hotel = $item->hotel;
                $room = $item->room;
                $firstImage = $hotel->hotel_imgs->firstWhere('hi_vitri', 1);
                $imgPath = $firstImage
                    ? '/images/hotels/h' . $hotel->h_id . '/' . $firstImage->hi_name
                    : '/images/other/placeholder-image.png';
            @endphp
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ $imgPath }}" class="img-fluid rounded-start" alt="Room Image">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">{{ $room->r_name }}</h5>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="cart_id" value="{{ $item->cart_id }}">
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </div>
                            <p class="card-text">{{ $hotel->h_name }}</p>
                            <p class="card-text">Số lượng: {{ $item->cart_quantity }}</p>
                            <p class="card-text">Thời gian:
                                <small class="text-muted">
                                    {{ date('d/m/Y', strtotime($item->cart_checkin)) }} - 
                                    {{ date('d/m/Y', strtotime($item->cart_checkout)) }}
                                </small>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary">
                                    {{ number_format($room->r_price * $item->cart_quantity, 0, ',', '.') }} VNĐ
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                Giỏ hàng của bạn đang trống.
            </div>
        @endforelse
    </div>

    @if(count($cartItems) > 0)
        <div class="cart-summary card p-3 mt-3">
            @php
                $subtotal = $cartItems->sum(function($item) {
                    return $item->room->r_price * $item->cart_quantity;
                });
                $tax = $subtotal * 0.1; // Thuế 10%
                $total = $subtotal + $tax;
            @endphp
            <div class="d-flex justify-content-between mb-2">
                <span>Tổng tiền phòng:</span>
                <span>{{ number_format($subtotal, 0, ',', '.') }} VNĐ</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Thuế và phí:</span>
                <span>{{ number_format($tax, 0, ',', '.') }} VNĐ</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-3">
                <strong>Tổng cộng:</strong>
                <strong class="text-primary">{{ number_format($total, 0, ',', '.') }} VNĐ</strong>
            </div>
            <form action="{{ route('booking.create') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary w-100">Tiến hành đặt phòng</button>
            </form>
        </div>
    @endif
</div>
@endsection
