flatpickr("#check-in", {
    dateFormat: "d-m-Y",
    minDate: "today",
});

flatpickr("#check-out", {
    dateFormat: "d-m-Y",
    minDate: "today",
});

const guestInput = document.getElementById('guest-input');
const guestDropdown = document.getElementById('guest-dropdown');
const locationInput = document.getElementById('location-input');
const locationDropdown = document.getElementById('location-dropdown');
let adults = 1;
let rooms = 1;

guestInput.addEventListener('click', () => {
    guestDropdown.style.display = guestDropdown.style.display === 'none' ? 'block' : 'none';
});

locationInput.addEventListener('click', () => {
    locationDropdown.style.display = locationDropdown.style.display === 'none' ? 'block' : 'none';
});

function changeGuests(type, change) {
    if (type === 'adults') {
        adults = Math.max(1, adults + change);
        document.getElementById('adults-count').textContent = adults;
    } else if (type === 'rooms') {
        rooms = Math.max(1, rooms + change);
        document.getElementById('rooms-count').textContent = rooms;
    }
    updateGuestInput();
}

function updateGuestInput() {
    guestInput.textContent = `${adults} người lớn, ${rooms} phòng`;
}

function selectLocation(location) {
    locationInput.value = location;
    locationDropdown.style.display = 'none';
}

// Close dropdowns when clicking outside
document.addEventListener('click', (event) => {
    if (!guestInput.contains(event.target) && !guestDropdown.contains(event.target)) {
        guestDropdown.style.display = 'none';
    }
    if (!locationInput.contains(event.target) && !locationDropdown.contains(event.target)) {
        locationDropdown.style.display = 'none';
    }
});