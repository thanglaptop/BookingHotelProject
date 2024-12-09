document.addEventListener('DOMContentLoaded', function () {
  let Alert = document.querySelectorAll('.alert[role="alert"]');
  Alert.forEach(function (alertElement) {
    setTimeout(() => {
      let alert = new bootstrap.Alert(alertElement);
      alert.close();
    }, 2000); // 2 giây
  });
  checkImageLimit();

  //hàm reset form khi đóng
  window.resetForm = function (tenForm) {
    document.getElementById(tenForm).reset();
    const anhks = document.querySelectorAll('.image-container');
    anhks.forEach(element => element.remove());
    const anhqr = document.querySelectorAll('.anhQR');
    anhqr.forEach(element => element.src = "/images/placeholder-image.png");
  }

  let selectedFiles = []; // Mảng lưu trữ các ảnh đã chọn
  // Hàm hiển thị ảnh khi thêm từ input file
  window.displayAnh = function (event, elementId, insertBeforeTage) {
    const displayRoomImage = document.getElementById(elementId);
    const fileInput = event.target;
    const insertBeforeT = document.getElementById(insertBeforeTage);

    // Kiểm tra nếu có files được chọn
    if (fileInput.files) {
      // Lặp qua tất cả các file được chọn (có thể là 1 hoặc nhiều ảnh)
      for (let i = 0; i < fileInput.files.length; i++) {
        const file = fileInput.files[i];

        // Kiểm tra nếu file đã được chọn rồi, tránh trùng lặp
        if (!selectedFiles.includes(file)) {
          selectedFiles.push(file); // Thêm file vào mảng selectedFiles

          const reader = new FileReader();

          reader.onload = function (e) {
            const newDivImage = document.createElement("div");
            newDivImage.className = "image-container draggable";
            newDivImage.setAttribute("draggable", "true");

            const newButtonClose = document.createElement("button");
            newButtonClose.setAttribute("type", "button");
            newButtonClose.className = "btn-close";
            newButtonClose.setAttribute("aria-label", "Close");
            newButtonClose.setAttribute("onclick", "removeImage(this)");

            const newImage = document.createElement("img");
            newImage.src = e.target.result; // Đọc ảnh dưới dạng base64
            newImage.className = "add-image m-1";

            const newInput = document.createElement("input");
            newInput.type = "hidden";
            newInput.value = file.name;
            newInput.name = "newhinh[]";

            newDivImage.appendChild(newButtonClose);
            newDivImage.appendChild(newImage);
            newDivImage.appendChild(newInput);

            // Chèn ảnh vào DOM
            displayRoomImage.insertBefore(newDivImage, insertBeforeT);
            addDraggable(newDivImage); // Giả sử addDraggable là hàm để thêm khả năng kéo thả
            checkImageLimit();
          };

          reader.readAsDataURL(file); // Đọc ảnh từ file
        }
      }

      // Cập nhật lại giá trị cho input hidden để gửi lên server
      updateFileInput();
    }
  }


  // Hàm để loại bỏ ảnh khi nhấn nút xóa
  window.removeImage = function (button) {
    const imageDiv = button.parentElement;
    const fileName = imageDiv.querySelector("input").value;

    // Loại bỏ file khỏi mảng selectedFiles
    selectedFiles = selectedFiles.filter(file => file.name !== fileName);

    // Cập nhật lại giá trị cho input hidden sau khi xóa ảnh

    updateFileInput();

    imageDiv.remove(); // Xóa ảnh khỏi DOM
    checkImageLimit();
  }

  window.updateFileInput = function () {
    // Lấy input file có id là 25
    const fileInput = document.getElementById('nutThemAnh');

    // Kiểm tra nếu input file tồn tại
    if (!fileInput || fileInput.type !== 'file') {
      console.error('Input file with id not found or invalid type.');
      return;
    }

    // Tạo một đối tượng DataTransfer
    const dataTransfer = new DataTransfer();

    // Thêm từng file trong selectedFiles vào DataTransfer
    selectedFiles.forEach(file => {
      dataTransfer.items.add(file);
    });

    // Gán DataTransfer vào input file
    fileInput.files = dataTransfer.files;

    console.log('Files successfully added to input file');
  };



  //hàm thay đổi vị trí ảnh bằng kéo thả
  let draggedImage = null;
  window.addDraggable = function (image) {
    image.addEventListener('dragstart', (e) => {
      draggedImage = image;
      e.dataTransfer.effectAllowed = "move";
    });

    // Sự kiện khi kéo ảnh đến một ảnh khác
    image.addEventListener('dragover', (e) => {
      e.preventDefault();
      e.dataTransfer.dropEffect = "move";
    });

    // Sự kiện khi thả ảnh vào vị trí mới
    image.addEventListener('drop', (e) => {
      e.preventDefault();
      if (draggedImage !== image) {
        let parent = image.parentNode;
        let draggedImagePosition = Array.from(parent.children).indexOf(draggedImage);
        let droppedImagePosition = Array.from(parent.children).indexOf(image);

        if (draggedImagePosition < droppedImagePosition) {
          parent.insertBefore(draggedImage, image.nextSibling);
        } else {
          parent.insertBefore(draggedImage, image);
        }
      }
    });

    // Sự kiện khi kết thúc kéo
    image.addEventListener('dragend', () => {
      draggedImage = null;
    });
    // });
  }

  // Gán sự kiện kéo thả cho tất cả ảnh hiện có ngay lúc tải trang
  window.addEventListener('load', () => {
    const existingImages = document.querySelectorAll('.draggable');
    existingImages.forEach((image) => {
      addDraggable(image);
    });
  });


  // Hàm cập nhật giá và thành tiền khi ngày thay đổi
  window.updatePricesByDateChange = function () {
    const tbody = document.querySelector('.dgvDDP table tbody');
    const rows = tbody.querySelectorAll('tr');
    const checkin = document.getElementById("inputCin").value;
    const checkout = document.getElementById("inputCout").value;
    const songay = getDaysDifference(checkin, checkout);

    rows.forEach(row => {
      const quantityCell = row.querySelector('td:nth-child(3)');
      const unitPriceCell = row.querySelector('td:nth-child(5)');
      const totalCell = row.querySelector('td:nth-child(6)');

      const quantity = parseInt(quantityCell.textContent);
      const unitPrice = parseInt(unitPriceCell.textContent.replace(/\D/g, '')); // Lấy giá mỗi ngày
      const newTotal = unitPrice * quantity * songay;
      totalCell.innerHTML = '<input type="hidden" value="' + newTotal + '" name="thanhtien[]">' + newTotal.toLocaleString('vi-VN') + ' VNĐ';
    });

    updateTotalPrice();
    console.log("duoc goi");
  }

  // // Lắng nghe sự kiện thay đổi ngày check-in và check-out
  // document.getElementById("inputCin").addEventListener('change', updatePricesByDateChange);
  // document.getElementById("inputCout").addEventListener('change', updatePricesByDateChange);


  window.handleDateChange = function () {
    const checkinInput = document.getElementById("inputCin");
    const checkoutInput = document.getElementById("inputCout");

    const checkinDateStr = checkinInput.value;
    const checkoutDateStr = checkoutInput.value; 

    const checkinDate = new Date(checkinDateStr);
    const checkoutDate = new Date(checkoutDateStr);

    // Kiểm tra nếu ngày check-out < ngày check-in
    if (checkoutDateStr && checkoutDate <= checkinDate) {
      // alert("Ngày check-out không được nhỏ hơn hoặc bằng ngày check-in.");
      checkoutInput.value = ""; // Reset ngày check-out
      return;
    }

    // Nếu ngày check-in > ngày check-out
    if (checkinDateStr && checkoutDateStr && checkinDate >= checkoutDate) {
      // alert("Ngày check-in không được lớn hơn hoặc bằng ngày check-out.");
      checkoutInput.value = ""; // Reset ngày check-out
      return;
    }
  };

  // Lắng nghe sự kiện thay đổi ngày check-in và check-out
  document.getElementById("inputCin").addEventListener('change', handleDateChange);
  document.getElementById("inputCout").addEventListener('change', handleDateChange);

});

//xác thực các ô nhập liệu không được bỏ trống
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
    }, false)
  })
})()

// Hàm kiểm tra và cập nhật trạng thái nút thêm ảnh
function checkImageLimit() {
  const maxImages = 5;
  const currentImagesCount = document.querySelectorAll('#displayImage .image-container').length;

  // Kiểm tra nếu số lượng ảnh đã đạt 5
  const addButton = document.getElementById('btnAddImage');
  // const fileInput = document.getElementById('nutThemAnh');

  if (currentImagesCount >= maxImages) {
    // Ẩn nút thêm ảnh nếu số lượng ảnh đạt tối đa
    addButton.style.display = 'none';
    console.log("ko cho them");
  } else {
    // Hiển thị nút thêm ảnh nếu số lượng ảnh chưa đủ
    addButton.style.display = 'block';
    console.log("cho them");
  }
}




