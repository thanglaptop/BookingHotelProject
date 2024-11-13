<div id="ChuKhachSan" class="choLogin p-3">
    <form id="loginOwner" class="row g-3 needs-validation" action="{{ route('ownerlogin') }}" method="POST" novalidate>
        <div class="col-12">
            @csrf
            <label for="loginOwnUsername" class="form-label">tên đăng nhập</label>
            <input type="text" class="form-control" id="loginOwnUsername" name="txtOUsername" required>
            <div class="invalid-feedback">
                vui lòng không bỏ trống tên đăng nhập
            </div>
        </div>
        <div class="col-12">
            <label for="loginOwnPass" class="form-label">mật khẩu</label>
            <input type="password" class="form-control" id="loginOwnPass" name="txtOPass" required>
            <div class="invalid-feedback">
                vui lòng không bỏ trống mật khẩu
            </div>
        </div>
        <div class="col-12 d-flex justify-content-center">
            <button class="btn btn-orange" type="submit">đăng nhập</button>
        </div>
    </form>
</div>