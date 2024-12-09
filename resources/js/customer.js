document.addEventListener('DOMContentLoaded', function () {
  let Alert = document.querySelectorAll('.alert[role="alert"]');
  Alert.forEach(function (alertElement) {
    setTimeout(() => {
      let alert = new bootstrap.Alert(alertElement);
      alert.close();
    }, 2000); // 2 giây
  });

  // Khởi tạo giá trị
  let roomCount = document.getElementById('room').value || 1;
  let adultsCount = document.getElementById('adult').value || 2;
  let kidsCount = document.getElementById('kid').value || 0;
  var popoverTrigger = document.getElementById('popover-toggle');

  //trả về giá trị luôn cập nhật
  function getpopoverContent() {
    return `<div class='popover-content d-grid gap-3'>
        <div class='d-flex justify-content-between align-items-center'>
            <h6>Phòng</h6>
            <div>
                <button type='button' class='btn btn-outline-secondary btn-sm rounded' id='decrease-room'><i class="bi bi-dash-lg"></i></button>
                <span class='mx-2' id='room-count'>${roomCount}</span>
                <button type='button' class='btn btn-outline-secondary btn-sm rounded' id='increase-room'><i class="bi bi-plus-lg"></i></button>
            </div>
        </div>
        <div class='d-flex justify-content-between align-items-center'>
            <div>
                <h6 class='mb-0'>Người lớn</h6>
                <small class='text-muted'>18 tuổi trở lên</small>
            </div>
            <div>
                <button type='button' class='btn btn-outline-secondary btn-sm rounded' id='decrease-adults'><i class="bi bi-dash-lg"></i></button>
                <span class='mx-2' id='adults-count'>${adultsCount}</span>
                <button type='button' class='btn btn-outline-secondary btn-sm rounded' id='increase-adults'><i class="bi bi-plus-lg"></i></button>
            </div>
        </div>
        <div class='d-flex justify-content-between align-items-center'>
            <div>
                <h6 class='mb-0'>Trẻ em</h6>
                <small class='text-muted'>0-17 tuổi</small>
            </div>
            <div>
                <button type='button' class='btn btn-outline-secondary btn-sm rounded' id='decrease-kids'><i class="bi bi-dash-lg"></i></button>
                <span class='mx-2' id='kids-count'>${kidsCount}</span>
                <button type='button' class='btn btn-outline-secondary btn-sm rounded' id='increase-kids'><i class="bi bi-plus-lg"></i></button>
            </div>
        </div>
    </div>
    `}

  var popover = new bootstrap.Popover(popoverTrigger, {
    html: true,
    content: getpopoverContent,
    placement: 'bottom',
    template: '<div class="popover custom-popover" role="tooltip"><div class="popover-arrow"></div><div class="popover-header"></div><div class="popover-body"></div></div>',
    sanitize: false // bỏ kiểm tra bảo mật cho HTML
  });


  //cập nhật số và hiển thị ở thẻ thông tin
  function updateRoomAndPerson() {
    document.getElementById('popover-toggle').innerHTML = `
        ${roomCount} phòng, ${adultsCount} người lớn, ${kidsCount}, trẻ em`;
    document.getElementById('room').value = roomCount;
    document.getElementById('adult').value = adultsCount;
    document.getElementById('kid').value = kidsCount;
  }

  // Đảm bảo sự kiện được gắn sau khi popover được kích hoạt
  popoverTrigger.addEventListener('shown.bs.popover', function () {

    if (roomCount <= 1) {
      document.getElementById('decrease-room').disabled = true;
    }
    if (kidsCount <= 0) {
      document.getElementById('decrease-kids').disabled = true;
    }

    // Gắn sự kiện cho các nút trong popover
    document.getElementById('increase-room').addEventListener('click', function () {
      roomCount++;
      document.getElementById('room-count').innerHTML = roomCount;

      if (roomCount > adultsCount) {
        adultsCount++;
        document.getElementById('adults-count').textContent = adultsCount;
      }
      if (adultsCount > roomCount) {
        document.getElementById('decrease-adults').disabled = false;
      } else document.getElementById('decrease-adults').disabled = true;
      if (roomCount > 1) {
        document.getElementById('decrease-room').disabled = false;
      }
      if (roomCount >= 30) {
        document.getElementById('increase-room').disabled = true;
      }

      updateRoomAndPerson(); // Cập nhật giá trị cho div ngoài popover

    });

    document.getElementById('decrease-room').addEventListener('click', function () {
      if (roomCount > 1) {
        roomCount--;
        document.getElementById('room-count').textContent = roomCount;
        if (adultsCount > roomCount) {
          document.getElementById('decrease-adults').disabled = false;
        }
        if (roomCount <= 1) {
          document.getElementById('decrease-room').disabled = true;
        }
        if (roomCount < 30) {
          document.getElementById('increase-room').disabled = false;
        }
        updateRoomAndPerson(); // Cập nhật giá trị cho div ngoài popover
      }

    });

    document.getElementById('increase-adults').addEventListener('click', function () {
      adultsCount++;
      document.getElementById('adults-count').textContent = adultsCount;
      if (adultsCount >= roomCount) {
        document.getElementById('decrease-adults').disabled = false;
      }
      if (adultsCount >= 60) {
        document.getElementById('increase-adults').disabled = true;
      }
      updateRoomAndPerson(); // Cập nhật giá trị cho div ngoài popover
    });

    document.getElementById('decrease-adults').addEventListener('click', function () {
      if (adultsCount > 1) {
        adultsCount--;
        document.getElementById('adults-count').textContent = adultsCount;
        if (adultsCount <= roomCount) {
          document.getElementById('decrease-adults').disabled = true;
        }
        if (adultsCount < 60) {
          document.getElementById('increase-adults').disabled = false;
        }
        updateRoomAndPerson(); // Cập nhật giá trị cho div ngoài popover
      }
    });

    document.getElementById('increase-kids').addEventListener('click', function () {
      kidsCount++;
      document.getElementById('kids-count').textContent = kidsCount;
      if (kidsCount > 0) {
        document.getElementById('decrease-kids').disabled = false;
      }
      if (kidsCount >= 30) {
        document.getElementById('increase-kids').disabled = true;
      }
      updateRoomAndPerson(); // Cập nhật giá trị cho div ngoài popover
    });

    document.getElementById('decrease-kids').addEventListener('click', function () {
      if (kidsCount > 0) {
        kidsCount--;
        document.getElementById('kids-count').textContent = kidsCount;
        if (kidsCount <= 0) {
          document.getElementById('decrease-kids').disabled = true;
        }
        if (kidsCount < 30) {
          document.getElementById('increase-kids').disabled = false;
        }
        updateRoomAndPerson(); // Cập nhật giá trị cho div ngoài popover
      }
    });
  });

  var popoverpriceTrigger = document.getElementById('popover-toggle-price');
  //trả về giá trị luôn cập nhật
  function getpopoverpriceContent() {
    return `<div class="d-flex">
                <div class="me-2">100</div>
                <input type="range" class="form-range mx-2" id="customRange1" value="100">
                <div class="ms-2">10000</div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
            <span>Max: 500.000 VNĐ</span>
            <button class="btn btn-primary btn-sm">Tìm</button>
            </div>`}
  var popoverprice = new bootstrap.Popover(popoverpriceTrigger, {
    html: true,
    content: getpopoverpriceContent,
    placement: 'bottom',
    template: '<div class="popover custom-popover" role="tooltip"><div class="popover-arrow"></div><div class="popover-header"></div><div class="popover-body"></div></div>',
    sanitize: false // bỏ kiểm tra bảo mật cho HTML
  });


  var popoverfilterTrigger = document.getElementById('popover-toggle-filter');
  //trả về giá trị luôn cập nhật
  function getpopoverfilterContent() {
    return `<div class="d-flex">
                <div class="me-2">100</div>
                <input type="range" class="form-range mx-2" id="customRange1" value="100">
                <div class="ms-2">10000</div>
            </div>
            <div class="d-flex align-items-center justify-content-between"> 
            <span>Max: 500.000 VNĐ</span>
            <button class="btn btn-primary btn-sm">Tìm</button>
            </div>`}
  var popoverfilter = new bootstrap.Popover(popoverfilterTrigger, {
    html: true,
    content: getpopoverfilterContent,
    placement: 'bottom',
    template: '<div class="popover custom-popover" role="tooltip"><div class="popover-arrow"></div><div class="popover-header"></div><div class="popover-body"></div></div>',
    sanitize: false // bỏ kiểm tra bảo mật cho HTML
  });

});

