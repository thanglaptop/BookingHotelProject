document.addEventListener('DOMContentLoaded', function () {

  //function switch tablogin giua khach hang va chu khach san
  window.moLogin = function (evt, tenTab) {
    var i, choLogin, chuyenTab;
    choLogin = document.getElementsByClassName("choLogin");
    for (i = 0; i < choLogin.length; i++) {
      choLogin[i].style.display = "none";
    }
    chuyenTab = document.getElementsByClassName("chuyenTab");
    for (i = 0; i < chuyenTab.length; i++) {
      chuyenTab[i].className = chuyenTab[i].className.replace(" active", "");
    }
    document.getElementById(tenTab).style.display = "block";
    evt.currentTarget.className += " active";
    document.getElementById("loginUser").reset();
    document.getElementById("loginOwner").reset();
  }

  //function switch tablogin giua dang ky, dang nhap, quen mat khau phia duoi
  window.bottomLogin = function (tabCanMo, tabCanDong) {
    document.getElementById(tabCanMo).style.display = "block";
    document.getElementById(tabCanDong).style.display = "none";

    const forms = ["signUpCus", "FP", "loginUser", "loginOwner"];

    forms.forEach(formId => {
      const form = document.getElementById(formId);
      if (form) {
        form.reset();
        form.classList.remove('was-validated');
      }
    });
  }
  let Alert = document.querySelectorAll('.alert[role="alert"]');
  Alert.forEach(function (alertElement) {
    setTimeout(() => {
      let alert = new bootstrap.Alert(alertElement);
      alert.close();
    }, 3000); // 3 giây
  });
});


(() => {
  'use strict';

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation');

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      let isFormValid = true; // Biến kiểm tra tính hợp lệ tổng quát

      // Kiểm tra tên đăng nhập
      const username = form.querySelector('.username-input');
      const usernameFeedback = form.querySelector('.username-feedback');
      if (username.value !== '' && (username.value.length < 15 || username.value.length > 30)) {
        username.setCustomValidity('invalid');
        usernameFeedback.textContent = 'Tên đăng nhập phải từ 15 - 30 kí tự';
        isFormValid = false; // Có lỗi
      } else {
        username.setCustomValidity('');
      }

      // Kiểm tra số điện thoại
      const phoneInput = form.querySelector('.phone-input');
      const phoneFeedback = form.querySelector('.phone-feedback');
      const phoneRegex = /^(0|\+84)[3-9][0-9]{8}$/;
      if (phoneInput.value !== '' && !phoneRegex.test(phoneInput.value)) {
        phoneInput.setCustomValidity('invalid');
        phoneFeedback.textContent = 'Số điện thoại không hợp lệ';
        isFormValid = false; // Có lỗi
      } else {
        phoneInput.setCustomValidity('');
      }

      // Kiểm tra mật khẩu
      const pw1 = form.querySelector('.pw1-input');
      const pw1Feedback = form.querySelector('.pw1-feedback');
      if (pw1.value !== '' && (pw1.value.length < 8 || pw1.value.length > 20)) {
        pw1.setCustomValidity('invalid');
        pw1Feedback.textContent = 'Mật khẩu phải từ 8 - 20 kí tự';
        isFormValid = false; // Có lỗi
      } else {
        pw1.setCustomValidity('');
      }

      // Kiểm tra mật khẩu nhập lại
      const pw2 = form.querySelector('.pw2-input');
      const pw2Feedback = form.querySelector('.pw2-feedback');
      if (pw2.value !== '' && pw2.value !== pw1.value) {
        pw2.setCustomValidity('invalid');
        pw2Feedback.textContent = 'Mật khẩu không khớp';
        isFormValid = false; // Có lỗi
      } else {
        pw2.setCustomValidity('');
      }

      // Nếu có lỗi, ngăn submit
      if (!isFormValid || !form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }

      // Thêm lớp xác thực vào form
      form.classList.add('was-validated');
    }, false);
  });
})();
