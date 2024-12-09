function showSuggestions() {
    document.getElementById("suggestions").style.display = "block";
}

function hideSuggestions() {
    setTimeout(() => {
        document.getElementById("suggestions").style.display = "none";
    }, 200); // Dùng setTimeout để menu không biến mất ngay khi nhấp vào
}

document.querySelectorAll(".suggestions div").forEach(item => {
    item.addEventListener("click", function () {
        document.getElementById("search-input").value = this.innerText;
        hideSuggestions();
    });
});


//-------------------------------------buttondatphong

// JavaScript để điều khiển modal
function openModal() {
    document.getElementById('bookingModal').style.display = 'block';
}

// Khi người dùng nhấp vào nút đóng (×)
document.querySelector('.close').onclick = function() {
    document.getElementById('bookingModal').style.display = 'none';
}

// Khi người dùng nhấp bên ngoài modal
window.onclick = function(event) {
    var modal = document.getElementById('bookingModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// Xử lý form submit
document.getElementById('bookingForm').onsubmit = function(e) {
    e.preventDefault();
    // Xử lý logic đặt phòng ở đây
    alert('Đặt phòng thành công!');
    document.getElementById('bookingModal').style.display = 'none';
}




//gio hang
let bookings = [];

// Hàm xử lý form submit
document.getElementById('bookingForm').onsubmit = function(e) {
    e.preventDefault();
    
    // Lấy thông tin từ form
    const booking = {
        id: Date.now(),
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        checkin: document.getElementById('checkin').value,
        checkout: document.getElementById('checkout').value,
        guests: document.getElementById('guests').value,
        hotel: document.querySelector('.hotel-card h3').textContent,
        status: 'Đã xác nhận',
        date: new Date().toLocaleDateString('vi-VN')
    };
    
    // Thêm vào mảng bookings
    bookings.push(booking);
    
    // Lưu vào localStorage
    localStorage.setItem('bookings', JSON.stringify(bookings));
    
    // Thông báo đặt phòng thành công
    alert('Đặt phòng thành công!');
    
    // Đóng modal đặt phòng
    document.getElementById('bookingModal').style.display = 'none';
    
    // Reset form
    document.getElementById('bookingForm').reset();
};

// Hàm hiển thị modal lịch sử đặt phòng
function showBookingHistory() {
    // Lấy dữ liệu từ localStorage
    const savedBookings = localStorage.getItem('bookings');
    bookings = savedBookings ? JSON.parse(savedBookings) : [];
    
    const historyList = document.getElementById('bookingHistoryList');
    historyList.innerHTML = '';
    
    if (bookings.length === 0) {
        historyList.innerHTML = '<div class="empty-history">Chưa có lịch sử đặt phòng</div>';
        return;
    }
    
    bookings.forEach(booking => {
        const bookingItem = document.createElement('div');
        bookingItem.className = 'booking-item';
        bookingItem.innerHTML = `
            <h3>${booking.hotel}</h3>
            <div class="booking-info">
                <div>
                    <p><strong>Họ tên:</strong> ${booking.name}</p>
                    <p><strong>Email:</strong> ${booking.email}</p>
                    <p><strong>Số điện thoại:</strong> ${booking.phone}</p>
                </div>
                <div>
                    <p><strong>Ngày nhận phòng:</strong> ${booking.checkin}</p>
                    <p><strong>Ngày trả phòng:</strong> ${booking.checkout}</p>
                    <p><strong>Số khách:</strong> ${booking.guests}</p>
                </div>
                <div>
                    <p><strong>Ngày đặt:</strong> ${booking.date}</p>
                    <p><span class="booking-status status-confirmed">
                        ${booking.status}
                    </span></p>
                </div>
            </div>
        `;
        historyList.appendChild(bookingItem);
    });
    
    document.getElementById('bookingHistoryModal').style.display = 'block';
}

// Thêm sự kiện click cho icon giỏ hàng
document.querySelector('.fa-shopping-cart').addEventListener('click', showBookingHistory);

// Đóng modal lịch sử
document.querySelector('.close-history').onclick = function() {
    document.getElementById('bookingHistoryModal').style.display = 'none';
}

// Click bên ngoài để đóng modal
window.onclick = function(event) {
    const historyModal = document.getElementById('bookingHistoryModal');
    const bookingModal = document.getElementById('bookingModal');
    
    if (event.target == historyModal) {
        historyModal.style.display = 'none';
    }
    if (event.target == bookingModal) {
        bookingModal.style.display = 'none';
    }
}

// Khởi tạo dữ liệu từ localStorage khi trang tải
window.onload = function() {
    const savedBookings = localStorage.getItem('bookings');
    if (savedBookings) {
        bookings = JSON.parse(savedBookings);
    }
}
let currentCancelBookingId = null;

// Cập nhật hàm hiển thị lịch sử đặt phòng
function showBookingHistory() {
    const savedBookings = localStorage.getItem('bookings');
    bookings = savedBookings ? JSON.parse(savedBookings) : [];
    
    const historyList = document.getElementById('bookingHistoryList');
    historyList.innerHTML = '';
    
    if (bookings.length === 0) {
        historyList.innerHTML = '<div class="empty-history">Chưa có lịch sử đặt phòng</div>';
        return;
    }
    
    bookings.forEach(booking => {
        const bookingItem = document.createElement('div');
        bookingItem.className = 'booking-item';
        
        // Kiểm tra xem có thể hủy đặt phòng không
        const canCancel = booking.status !== 'Đã hủy' && 
                         new Date(booking.checkin) > new Date();
        
        bookingItem.innerHTML = `
            <h3>${booking.hotel}</h3>
            <div class="booking-info">
                <div>
                    <p><strong>Họ tên:</strong> ${booking.name}</p>
                    <p><strong>Email:</strong> ${booking.email}</p>
                    <p><strong>Số điện thoại:</strong> ${booking.phone}</p>
                </div>
                <div>
                    <p><strong>Ngày nhận phòng:</strong> ${booking.checkin}</p>
                    <p><strong>Ngày trả phòng:</strong> ${booking.checkout}</p>
                    <p><strong>Số khách:</strong> ${booking.guests}</p>
                </div>
                <div>
                    <p><strong>Ngày đặt:</strong> ${booking.date}</p>
                    <p><span class="booking-status ${booking.status === 'Đã hủy' ? 'status-cancelled' : 'status-confirmed'}">
                        ${booking.status}
                    </span></p>
                    ${booking.status === 'Đã hủy' ? 
                        `<p class="cancelled-text">Đã hủy vào: ${booking.cancelDate || 'N/A'}</p>` : ''}
                </div>
            </div>
            ${canCancel ? 
                `<button class="btn-cancel-booking" onclick="showCancelConfirmation('${booking.id}')">
                    Hủy đặt phòng
                </button>` : ''}
        `;
        historyList.appendChild(bookingItem);
    });
    
    document.getElementById('bookingHistoryModal').style.display = 'block';
}

// Hàm hiển thị xác nhận hủy đặt phòng
function showCancelConfirmation(bookingId) {
    currentCancelBookingId = bookingId;
    document.getElementById('cancelConfirmModal').style.display = 'block';
}

// Hàm hủy đặt phòng
function cancelBooking() {
    if (!currentCancelBookingId) return;
    
    bookings = bookings.map(booking => {
        if (booking.id === currentCancelBookingId) {
            return {
                ...booking,
                status: 'Đã hủy',
                cancelDate: new Date().toLocaleDateString('vi-VN')
            };
        }
        return booking;
    });
    
    // Cập nhật localStorage
    localStorage.setItem('bookings', JSON.stringify(bookings));
    
    // Đóng modal xác nhận
    document.getElementById('cancelConfirmModal').style.display = 'none';
    
    // Cập nhật hiển thị
    showBookingHistory();
    
    // Reset biến tạm
    currentCancelBookingId = null;
    
    // Thông báo hủy thành công
    alert('Hủy đặt phòng thành công!');
}

// Thêm event listeners cho modal xác nhận hủy
document.getElementById('confirmCancel').addEventListener('click', cancelBooking);
document.getElementById('cancelCancel').addEventListener('click', () => {
    document.getElementById('cancelConfirmModal').style.display = 'none';
    currentCancelBookingId = null;
});

// Cập nhật window.onclick để xử lý cả modal xác nhận
window.onclick = function(event) {
    const historyModal = document.getElementById('bookingHistoryModal');
    const bookingModal = document.getElementById('bookingModal');
    const cancelConfirmModal = document.getElementById('cancelConfirmModal');
    
    if (event.target == historyModal) {
        historyModal.style.display = 'none';
    }
    if (event.target == bookingModal) {
        bookingModal.style.display = 'none';
    }
    if (event.target == cancelConfirmModal) {
        cancelConfirmModal.style.display = 'none';
        currentCancelBookingId = null;
    }
}