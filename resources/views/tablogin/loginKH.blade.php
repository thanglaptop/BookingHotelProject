<div id="KhachHang" class="choLogin p-3 active">
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form id="loginUser" class="row g-3 needs-validation" action="{{ route('customerlogin') }}" method="POST" novalidate>
        <div class="col-12">
            @csrf
            <label for="loginCusUsername" class="form-label">tên đăng nhập</label>
            <input type="text" class="form-control" id="loginCusUsername" name="txtCUsername" required>
            <div class="invalid-feedback">
                vui lòng không bỏ trống tên đăng nhập
            </div>
        </div>
        <div class="col-12">
            <label for="loginCusPass" class="form-label">mật khẩu</label>
            <input type="password" class="form-control" id="loginCusPass" name="txtCPass" required>
            <div class="invalid-feedback">
                vui lòng không bỏ trống mật khẩu
            </div>
        </div>
        <div class="col-12 d-flex justify-content-center">
            <button class="btn btn-orange" type="submit">đăng nhập</button>
        </div>
    </form>
    <div class="bottomLoginForm mt-2">
        <span onclick="bottomLogin('DangKyTaiKhoan','KhachHang')">đăng ký tài khoản</span>
        <span onclick="bottomLogin('QuenMatKhau','KhachHang')">quên mật khẩu</span>
    </div>
</div>
