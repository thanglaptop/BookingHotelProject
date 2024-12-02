document.addEventListener('DOMContentLoaded', function () {
    window.addRoomToTable = function (id, name, quantity, price, availableQuantity, buttonElement) {
        // Kiểm tra số lượng phòng còn lại
        if (availableQuantity <= 0) {
            return; // Dừng không cho thêm phòng
        }

        // Tìm phần tbody trong bảng
        const tbody = document.querySelector('.dgvDDP table tbody');

        // Tìm xem phòng này đã có trong bảng chưa
        const existingRow = Array.from(tbody.querySelectorAll('tr')).find(row => {
            const roomCell = row.querySelector('td:nth-child(2)');
            return roomCell && roomCell.textContent.trim() === name;
        });

        const checkin = document.getElementById("inputCin").value;
        const checkout = document.getElementById("inputCout").value;
        const songay = getDaysDifference(checkin, checkout);
        // const giatien = price * songay;

        if (existingRow) {
            // Nếu phòng đã tồn tại, cập nhật số lượng và tổng tiền
            const quantityCell = existingRow.querySelector('td:nth-child(3)');
            const totalCell = existingRow.querySelector('td:nth-child(6)');

            const newQuantity = parseInt(quantityCell.textContent) + quantity;
            const newTotal = newQuantity * price * songay;

            quantityCell.innerHTML = '<input type="hidden" value="' + newQuantity + '" name="soluong[]">' + newQuantity;
            totalCell.innerHTML = '<input type="hidden" value="' + newTotal + '" name="thanhtien[]">' + newTotal.toLocaleString('vi-VN') + ' VNĐ';
        } else {
            // Nếu phòng chưa tồn tại, thêm dòng mới vào cuối tbody
            const newRow = document.createElement('tr');
            const totalPrice = quantity * price * songay;

            newRow.innerHTML = `
                <td></td> 
                <td><input type="hidden" value="${id}" name="room[]">${name}</td>
                <td><input type="hidden" value="${quantity}" name="soluong[]">${quantity}</td>
                <td>${songay}</td>
                <td>${price.toLocaleString('vi-VN')} VNĐ</td>
                <td><input type="hidden" value="${totalPrice}" name="thanhtien[]">${totalPrice.toLocaleString('vi-VN')} VNĐ</td>
                <td><i class="bi bi-trash3" style="cursor:pointer" onclick="removeRow(this, '${name}', ${price})"></i></td>
            `;

            // Thêm hàng vào cuối tbody
            tbody.appendChild(newRow);

            // Cập nhật lại STT (thứ tự của các dòng)
            updateRowIndexes();
        }

        // Cập nhật tổng tiền
        updateTotalPrice();

        // Giảm số lượng phòng còn lại
        const roomQuantityElement = buttonElement.querySelector('.room-quantity');
        let remainingQuantity = parseInt(roomQuantityElement.textContent);
        if (remainingQuantity > 0) {
            remainingQuantity--;
            roomQuantityElement.textContent = remainingQuantity;  // Cập nhật lại số lượng

            // Nếu số lượng còn lại bằng 0, ẩn nút
            if (remainingQuantity === 0) {
                buttonElement.disabled = true;  // Vô hiệu hóa nút
                buttonElement.style.backgroundColor = '#ccc';  // Thay đổi màu sắc nút (tùy chọn)
            }
        }
    }


    window.getDaysDifference = function (checkinDateStr, checkoutDateStr) {
        const checkinDate = new Date(checkinDateStr); // Chuyển chuỗi ngày check-in thành đối tượng Date
        const checkoutDate = new Date(checkoutDateStr); // Chuyển chuỗi ngày check-out thành đối tượng Date

        // Kiểm tra nếu ngày hợp lệ
        if (checkoutDate <= checkinDate) {
            return 1; // Trả về -1 nếu ngày check-out không lớn hơn ngày check-in
        }

        // Tính số ngày giữa hai ngày
        const timeDifference = checkoutDate - checkinDate; // Hiệu số thời gian (mili giây)
        const daysDifference = Math.round(timeDifference / (1000 * 60 * 60 * 24)); // Chuyển thành số ngày và làm tròn

        return daysDifference; // Trả về số ngày
    }

    // Hàm cập nhật lại chỉ số thứ tự (STT)
    function updateRowIndexes() {
        const tbody = document.querySelector('.dgvDDP table tbody');
        const rows = tbody.querySelectorAll('tr');

        rows.forEach((row, index) => {
            const sttCell = row.querySelector('td:nth-child(1)');
            sttCell.textContent = index + 1;  // Cập nhật số thứ tự (STT)
        });
    }

    // Hàm cập nhật tổng tiền
    function updateTotalPrice() {
        const table = document.querySelector('.dgvDDP table');
        const rows = table.querySelectorAll('tr:not(.sticky-top):not(.sticky-bottom)');
        let total = 0;

        // Tính tổng tiền
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const priceCell = cells[5];
            if (priceCell) {
                const price = parseInt(priceCell.textContent.replace(/\D/g, '')); // Lấy giá trị số
                total += price;
            }
        });

        // Cập nhật ô "Thành tiền"
        const totalCell = table.querySelector('.sticky-bottom th:nth-child(6)');
        totalCell.innerHTML = '<input type="hidden" value="' + total + '" name="total">' + total.toLocaleString('vi-VN') + ' VNĐ';
    }

    // Hàm xóa dòng
    window.removeRow = function (icon, name, price) {
        // Xóa hàng chứa icon được nhấn
        const row = icon.closest('tr');
        const quantityCell = row.querySelector('td:nth-child(3)');
        const totalCell = row.querySelector('td:nth-child(6)');
        const checkin = document.getElementById("inputCin").value;
        const checkout = document.getElementById("inputCout").value;
        const songay = getDaysDifference(checkin, checkout);
        const newQuantity = parseInt(quantityCell.textContent) - 1
        quantityCell.innerHTML = '<input type="hidden" value="' + newQuantity + '" name="soluong[]">' + newQuantity;

        const newTotal = price * newQuantity * songay;
        totalCell.innerHTML = '<input type="hidden" value="' + newTotal + '" name="thanhtien[]">' + newTotal.toLocaleString('vi-VN') + ' VNĐ';
        if (quantityCell.textContent == 0) {
            row.remove();
        }
        // Cập nhật tổng tiền
        updateTotalPrice();

        // Trả lại số lượng phòng cho nút
        const buttonElement = Array.from(document.querySelectorAll('.adddetail')).find(button => {
            return button.querySelector('h6').textContent.trim() === name;
        });

        if (buttonElement) {
            const roomQuantityElement = buttonElement.querySelector('.room-quantity');
            let remainingQuantity = parseInt(roomQuantityElement.textContent);
            // roomQuantityElement.textContent = remainingQuantity + parseInt(quantityCell.textContent);  // Cập nhật lại số lượng
            roomQuantityElement.textContent = remainingQuantity + 1;
            // Nếu số lượng còn lại là 0, hủy vô hiệu hóa nút
            if (remainingQuantity > 0) {
                buttonElement.disabled = false;
                buttonElement.style.backgroundColor = '';  // Khôi phục màu sắc ban đầu của nút
            }
        }

        // Cập nhật lại chỉ số thứ tự
        updateRowIndexes();
    }

});
