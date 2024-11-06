document.addEventListener('DOMContentLoaded', function () {

  //function switch tablogin giua khach hang va chu khach san
  window.moLogin = function(evt, tenTab) {
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
  window.bottomLogin = function(tabCanMo, tabCanDong){
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
});


(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {

      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')

      // KT SDT
      const phoneInput = form.querySelector('.phone-input');
      const phoneRegex = /^(0|\+84)[3-9][0-9]{8}$/;
      if (phoneInput.value != '' && !phoneRegex.test(phoneInput.value)) {
        const phoneFeedback = form.querySelector('.phone-feedback');
        phoneInput.setCustomValidity('invalid');
        phoneFeedback.textContent = 'số điện thoại không hợp lệ';
      } else {
        phoneInput.setCustomValidity(''); // Xóa lỗi nếu hợp lệ
      }


      // KT MK nhập lại
      const pw1 = form.querySelector('.pw1-input');
      if(pw1.value != '' && (pw1.value.length < 8 || pw1.value.length > 20)){
        const pw1Feedback = form.querySelector('.pw1-feedback');
        pw1.setCustomValidity('invalid');
        pw1Feedback.textContent = 'mật khẩu phải từ 8 - 20 kí tự';
      }
      else {
        pw1.setCustomValidity('');
      }

      const pw2 = form.querySelector('.pw2-input');
      if (pw2.value != '' && pw2.value != pw1.value) {
        const pw2Feedback = form.querySelector('.pw2-feedback');
        pw2.setCustomValidity('invalid');
        pw2Feedback.textContent = 'mật khẩu không khớp';
      }else {
        pw2.setCustomValidity('');
      }

      
    }, false)
  })
})()
