document.addEventListener('DOMContentLoaded', function () {
    window.displaySelectedImage = function (event, elementId) {
        const selectedImage = document.getElementById(elementId);
        const fileInput = event.target;

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                selectedImage.src = e.target.result;
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    }
});

(() => {
    'use strict';

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation');

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            let isFormValid = true; // Biến kiểm tra tính hợp lệ tổng quát

            // Kiểm tra tên TTTT
            const pmnameInput = form.querySelector('.pm-name');
            const pmnameFeedback = form.querySelector('.pm-name-feedback');
            if (pmnameInput.value.trim() != '' && pmnameInput.value.length < 5 || pmnameInput.value.length > 50) {
                pmnameInput.setCustomValidity('invalid');
                pmnameFeedback.textContent = 'tên thông tin thanh toán phải từ 5 - 50 ký tự';
                isFormValid = false; // Có lỗi
            } else {
                pmnameInput.setCustomValidity('');
            }

            // Kiểm tra số momo TTTT
            const pmmomoInput = form.querySelector('.momo-number');
            const pmmomoFeedback = form.querySelector('.momo-number-feedback');
            if (pmmomoInput.value.trim() != '' && isNaN(pmmomoInput.value) || pmmomoInput.value.length < 10 || pmmomoInput.value.length > 15) {
                pmmomoInput.setCustomValidity('invalid');
                pmmomoFeedback.textContent = 'số momo phải là số và có từ 10 - 15 số';
                isFormValid = false; // Có lỗi
            } else {
                pmmomoInput.setCustomValidity('');
            }

            // Kiểm tra số momo TTTT
            const pmbankInput = form.querySelector('.bank-number');
            const pmbankFeedback = form.querySelector('.bank-number-feedback');
            if (pmbankInput.value.trim() != '' && isNaN(pmbankInput.value) || pmbankInput.value.length < 10 || pmbankInput.value.length > 15) {
                pmbankInput.setCustomValidity('invalid');
                pmbankFeedback.textContent = 'số ngân hàng phải là số và có từ 10 - 15 số';
                isFormValid = false; // Có lỗi
            } else {
                pmbankInput.setCustomValidity('');
            }

            // Kiểm tra mô tả
            const pmmota = form.querySelector('.pm-mota-input');
            const pmmotaFeedback = form.querySelector('.pm-mota-feedback');
            if (pmmota.value.trim() != '' && (pmmota.value.length < 10 || pmmota.value.length > 400)) {
                pmmota.setCustomValidity('invalid');
                pmmotaFeedback.textContent = 'Mô tả phải từ 10 - 400 kí tự';
                isFormValid = false; // Có lỗi
            } else {
                pmmota.setCustomValidity('');
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