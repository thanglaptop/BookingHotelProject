<div id="QuenMatKhau" class="choLogin p-3">
    <form id="FP" class="row g-3 needs-validation" action="{{route('forgetpw')}}" method="POST" novalidate>
        @csrf
        <div class="col-12">
            <label for="FPUsername" class="form-label">nhập tên đăng nhập</label>
            <input type="text" name="username" class="form-control" id="FPUsername" required>
            <div class="invalid-feedback">
                vui lòng không bỏ trống tên đăng nhập
            </div>
        </div>
        <div class="col-12">
            <label for="FPEmail" class="form-label">nhập email</label>
            <input type="email" name="email" class="form-control" id="FPEmail" required>
            <div class="invalid-feedback">
                vui lòng không bỏ trống email
            </div>
        </div>
        <div class="col-12 d-flex justify-content-center">
            <button class="btn btn-orange" type="submit">gửi</button>
        </div>
    </form>
</div>