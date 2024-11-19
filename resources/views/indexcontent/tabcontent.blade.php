<div class="tab-content" id="myTabContent">
 <!-- Tab navigation -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="GH-tab" data-bs-toggle="tab" href="#GH" role="tab" aria-controls="GH" aria-selected="true">Giỏ hàng</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="DDP-tab" data-bs-toggle="tab" href="#DDP" role="tab" aria-controls="DDP" aria-selected="false">Đơn đặt phòng</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="TTCN-tab" data-bs-toggle="tab" href="#TTCN" role="tab" aria-controls="TTCN" aria-selected="false">Thông tin cá nhân</a>
    </li>
</ul>

<!-- Tab content -->
<div class="tab-content" id="myTabContent">
    <!-- Tab Giỏ hàng -->
    <div class="tab-pane fade show active" id="GH" role="tabpanel" aria-labelledby="GH-tab">
        <!-- Nội dung của tab Giỏ hàng -->
        <div class="container my-4">
            <h2 class="mb-4">Giỏ hàng của tôi</h2>
            <div class="cart-items">
                <!-- Lặp qua các mục trong giỏ hàng -->
                @foreach($cartItems as $item)
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ $item->image_url }}" class="img-fluid rounded-start" alt="Room Image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->room_name }}</h5>
                                    <p class="card-text">Đặt cho {{ $item->number_of_people }} người lớn</p>
                                    <p class="card-text"><small class="text-muted">Check-in: {{ $item->checkin_date }} | Check-out: {{ $item->checkout_date }}</small></p>
                                    <h5 class="text-primary mb-0">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Nếu giỏ hàng trống -->
                @if($cartItems->isEmpty())
                    <div class="alert alert-info">Giỏ hàng của bạn đang trống.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tab Đơn đặt phòng -->
    <div class="tab-pane fade" id="DDP" role="tabpanel" aria-labelledby="DDP-tab">
        <!-- Nội dung của tab Đơn đặt phòng -->
        <div class="container my-4">
            <h2 class="mb-4">Đơn đặt phòng của tôi</h2>
            <div class="booking-list">
                @foreach($bookings as $booking)
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <span>Mã đặt phòng: #{{ $booking->id }}</span>
                                <span class="badge {{ $booking->status_class }}">{{ $booking->status }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $booking->hotel_name }}</h5>
                            <p class="card-text">{{ $booking->room_name }} - {{ $booking->number_of_people }} người lớn</p>
                            <p class="card-text"><small class="text-muted">Check-in: {{ $booking->checkin_date }} | Check-out: {{ $booking->checkout_date }}</small></p>
                            <h5 class="text-primary">{{ number_format($booking->total, 0, ',', '.') }} VND</h5>
                        </div>
                    </div>
                @endforeach
                @if($bookings->isEmpty())
                    <div class="alert alert-info">Bạn chưa có đơn đặt phòng nào.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tab Thông tin cá nhân -->
    <div class="tab-pane fade" id="TTCN" role="tabpanel" aria-labelledby="TTCN-tab">
        <!-- Nội dung của tab Thông tin cá nhân -->
        <div class="container my-4">
            <h2 class="mb-4">Thông tin cá nhân</h2>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="avatar" class="form-label">Ảnh đại diện</label>
                    <input type="file" name="avatar" class="form-control" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" class="form-control" value="{{ $user->email }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="tel" name="phone" id="phone" class="form-control" value="{{ $user->phone }}">
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label">Ngày sinh</label>
                    <input type="date" name="birthday" id="birthday" class="form-control" value="{{ $user->birthday }}">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ</label>
                    <textarea name="address" id="address" class="form-control" rows="3">{{ $user->address }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </form>
        </div>
    </div>
</div>

</div>
