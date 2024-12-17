<div id="DangKyTaiKhoan" class="choLogin p-3">
    <form id="signUpCus" class="row g-3 needs-validation" action="{{ route('signup') }}" method="POST" novalidate>
        @csrf
        <div class="col-12">
            <label for="signUpFullname" class="form-label">họ và tên</label>
            <input type="text" name="fullname" class="form-control" id="signUpFullname" required>
            <div class="invalid-feedback">
                vui lòng không bỏ trống họ và tên
            </div>
        </div>
        <div class="col-12">
            <label for="signUpPhone" class="form-label">số điện thoại</label>
            <input type="text" name="sdt" class="form-control phone-input" id="signUpPhone" required>
            <div class="invalid-feedback phone-feedback">
                vui lòng không bỏ trống số điện thoại
            </div>
        </div>
        <div class="col-12">
            <label for="signUpEmail" class="form-label">email</label>
            <input type="email" name="email" class="form-control" id="signUpEmail" required>
            <div class="invalid-feedback">
                vui lòng không bỏ trống email
            </div>
        </div>
        <div class="col-12">
            <label for="signUpBirthday" class="form-label">ngày sinh</label>
            <input type="date" name="birthday" class="form-control" id="signUpBirthday" required> 
            <div class="invalid-feedback">
                vui lòng không bỏ trống ngày sinh
            </div>
        </div>
        <div class="col-12">
            <label for="signUpUsername" class="form-label">tên đăng nhập</label>
            <input type="text" name="username" class="form-control username-input" id="signUpUsername" required>
            <div class="invalid-feedback username-feedback">
                vui lòng không bỏ trống tên đăng nhập
            </div>
        </div>
        <div class="col-12">
            <label for="signUpPass1" class="form-label">mật khẩu</label>
            <input type="password" class="form-control pw1-input" id="signUpPass1" required>
            <div class="invalid-feedback pw1-feedback">
                vui lòng không bỏ trống mật khẩu
            </div>
        </div>
        <div class="col-12">
            <label for="signUpPass2" class="form-label">nhập lại mật khẩu</label>
            <input type="password" name="password" class="form-control pw2-input" id="signUpPass2" required>
            <div class="invalid-feedback pw2-feedback">
                vui lòng không bỏ trống nhập lại mật khẩu
            </div>
        </div>
        <div class="col-12 d-flex justify-content-center">
            <button class="btn btn-orange" type="submit">đăng ký</button>
        </div>
    </form>
    <div class="bottomLoginForm mt-2">
        <span class="chuyenTab" onclick="bottomLogin('KhachHang','DangKyTaiKhoan')">đăng nhập</span>
    </div>
</div>