(() => {
    'use strict';

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation');

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            let isFormValid = true; // Biến kiểm tra tính hợp lệ tổng quát

            // Kiểm tra tên phòng
            const roomname = form.querySelector('.room-name-input');
            const roomnameFeedback = form.querySelector('.room-name-feedback');
            if (roomname.value.trim() !== '' && (roomname.value.length < 5 || roomname.value.length > 50)) {
                roomname.setCustomValidity('invalid');
                roomnameFeedback.textContent = 'Tên phòng phải từ 5 - 50 kí tự';
                isFormValid = false; // Có lỗi
            } else {
                roomname.setCustomValidity('');
            }

            // Kiểm tra giá phòng
            const roomprice = form.querySelector('.room-price-input');
            const roompriceFeedback = form.querySelector('.room-price-feedback');
            const priceValue = roomprice.value.trim(); // Lấy giá trị bỏ qua khoảng trắng
            if (priceValue === '' || priceValue < 50000) {
                roomprice.setCustomValidity('invalid');
                roompriceFeedback.textContent = 'Giá phòng phải lớn hơn hoặc bằng 50.000 VNĐ';
                isFormValid = false; // Có lỗi
            } else {
                roomprice.setCustomValidity('');
            }

            // Kiểm tra số lượng phòng
            const roomsl = form.querySelector('.room-sl-input');
            const roomslFeedback = form.querySelector('.room-sl-feedback');
            if (roomsl.value === '' || roomsl.value <= 0) {
                roomsl.setCustomValidity('invalid');
                roomslFeedback.textContent = 'số lượng phòng phải lớn hơn 0';
                isFormValid = false; // Có lỗi
            } else {
                roomsl.setCustomValidity('');
            }

            // Kiểm tra mô tả
            const roommota = form.querySelector('.room-mota-input');
            const roommotaFeedback = form.querySelector('.room-mota-feedback');
            if (roommota.value.trim() === '' && (roommota.value.length < 10 || roomname.value.length > 400)) {
                roommota.setCustomValidity('invalid');
                roommotaFeedback.textContent = 'Tên phòng phải từ 10 - 400 kí tự';
                isFormValid = false; // Có lỗi
            } else {
                roommota.setCustomValidity('');
            }

            // Kiểm tra diện tích
            const roomdt = form.querySelector('.room-dt-input');
            const roomdtFeedback = form.querySelector('.room-dt-feedback');
            if (roomdt.value === '' || roomdt.value < 10) {
                roomdt.setCustomValidity('invalid');
                roomdtFeedback.textContent = 'diện tích phòng phải lớn hơn hoặc bằng 10';
                isFormValid = false; // Có lỗi
            } else {
                roomdt.setCustomValidity('');
            }




            // Kiểm tra người lớn
            const adultsl = form.querySelector('.adult-input');
            const adultFeedback = form.querySelector('.adult-feedback');

            // Kiểm tra trẻ em
            const kidsl = form.querySelector('.kid-input');
            const kidFeedback = form.querySelector('.kid-feedback');

            // Kiểm tra người lớn và trẻ em tổng cộng
            const allsl = form.querySelector('.all-input');
            const allFeedback = form.querySelector('.all-feedback');
            
            // isFormValid = true; // Biến kiểm tra tổng thể

            // Kiểm tra người lớn
            if (adultsl.value.trim() !== '' && Number(adultsl.value) <= 0) {
                adultsl.setCustomValidity('invalid');
                adultFeedback.textContent = 'Số người lớn phải lớn hơn 0';
                isFormValid = false;
            } else {
                adultsl.setCustomValidity('');
            }

            // Kiểm tra trẻ em
            if (kidsl.value.trim() !== '' && Number(kidsl.value) < 0) {
                kidsl.setCustomValidity('invalid');
                kidFeedback.textContent = 'Số trẻ em phải lớn hơn hoặc bằng 0';
                isFormValid = false;
            } else {
                kidsl.setCustomValidity('');
            }

            // Kiểm tra người lớn và trẻ em tổng cộng
            if (allsl.value.trim() !== '' && Number(allsl.value) < 0) {
                allsl.setCustomValidity('invalid');
                allFeedback.textContent = 'Số người lớn và trẻ em phải lớn hơn hoặc bằng 0';
                isFormValid = false;
            } else {
                allsl.setCustomValidity('');
            }

            // Kiểm tra logic giữa các input
            if (Number(adultsl.value) > 0 || Number(kidsl.value) > 0) {
                if (Number(allsl.value) !== 0) {
                    allsl.setCustomValidity('invalid');
                    allFeedback.textContent = 'Nếu có người lớn hoặc trẻ em, tổng cộng phải bằng 0';
                    isFormValid = false;
                } else {
                    allsl.setCustomValidity('');
                }
            } else if (Number(allsl.value) > 0) {
                if (Number(adultsl.value) !== 0 || Number(kidsl.value) !== 0) {
                    adultsl.setCustomValidity('invalid');
                    kidsl.setCustomValidity('invalid');
                    isFormValid = false;
                } else {
                    adultsl.setCustomValidity('');
                    isFormValid = true;
                    kidsl.setCustomValidity('');
                }
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
