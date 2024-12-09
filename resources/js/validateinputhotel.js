(() => {
    'use strict';

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation');

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            let isFormValid = true; // Biến kiểm tra tính hợp lệ tổng quát

            // Kiểm tra số điện thoại
            const phoneInput = form.querySelector('.hotel-phone-input');
            const phoneFeedback = form.querySelector('.hotel-phone-feedback');
            const phoneRegex = /^(0|\+84)[3-9][0-9]{8}$/;
            if (phoneInput.value !== '' && !phoneRegex.test(phoneInput.value)) {
                phoneInput.setCustomValidity('invalid');
                phoneFeedback.textContent = 'Số điện thoại không hợp lệ';
                isFormValid = false; // Có lỗi
            } else {
                phoneInput.setCustomValidity('');
            }

            // Kiểm tra tên khach sạn
            const hotelname = form.querySelector('.hotel-name-input');
            const hotelnameFeedback = form.querySelector('.hotel-name-feedback');
            if (hotelname.value.trim() !== '' && (hotelname.value.length < 5 || hotelname.value.length > 50)) {
                hotelname.setCustomValidity('invalid');
                hotelnameFeedback.textContent = 'Tên khách sạn phải từ 5 - 50 kí tự';
                isFormValid = false; // Có lỗi
            } else {
                hotelname.setCustomValidity('');
            }

            // Kiểm tra tên khach sạn
            const hoteldchi = form.querySelector('.hotel-dchi-input');
            const hoteldchiFeedback = form.querySelector('.hotel-dchi-feedback');
            if (hoteldchi.value.trim() !== '' && (hoteldchi.value.length < 10 || hoteldchi.value.length > 100)) {
                hoteldchi.setCustomValidity('invalid');
                hoteldchiFeedback.textContent = 'Địa chỉ phải từ 10 - 100 kí tự';
                isFormValid = false; // Có lỗi
            } else {
                hoteldchi.setCustomValidity('');
            }

            // Kiểm tra mô tả
            const hotelmota = form.querySelector('.hotel-mota-input');
            const hotelmotaFeedback = form.querySelector('.hotel-mota-feedback');
            if (hotelmota.value.trim() === '' && (hotelmota.value.length < 10 || hotelname.value.length > 400)) {
                hotelmota.setCustomValidity('invalid');
                hotelmotaFeedback.textContent = 'Mô tả phải từ 10 - 400 kí tự';
                isFormValid = false; // Có lỗi
            } else {
                hotelmota.setCustomValidity('');
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
