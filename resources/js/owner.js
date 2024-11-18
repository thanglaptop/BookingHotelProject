document.addEventListener('DOMContentLoaded', function () {

  //hàm reset form khi đóng
  window.resetForm = function (tenForm) {
    document.getElementById(tenForm).reset();
    const anhks = document.querySelectorAll('.image-container');
    anhks.forEach(element => element.remove());
    const anhqr = document.querySelectorAll('.anhQR');
    anhqr.forEach(element => element.src = "/images/placeholder-image.png");
  }

  //hàm hiển thị ảnh khi thêm từ input file
  window.displayAnh = function (event, elementId, insertBeforeTage) {
    const displayRoomImage = document.getElementById(elementId);
    const fileInput = event.target;
    const insertBeforeT = document.getElementById(insertBeforeTage);

    if (fileInput.files && fileInput.files[0]) {
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
        newImage.src = e.target.result;
        // newImage.alt = "ảnh không tồn tại";
        newImage.className = "add-image m-1";



        newDivImage.appendChild(newButtonClose);
        newDivImage.appendChild(newImage);

        displayRoomImage.insertBefore(newDivImage, insertBeforeT);
        addDraggable(newDivImage);
      };

      reader.readAsDataURL(fileInput.files[0]);
    }
  }

  //hàm xóa ảnh
  window.removeImage = function (button) {
    // Tìm phần tử cha chứa hình ảnh và nút
    var imageContainer = button.parentElement;
    // Xóa phần tử cha khỏi DOM
    imageContainer.remove();
  }

  //hàm hiển thị ảnh QR khi thêm từ input file
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

  //hàm thay đổi vị trí ảnh bằng kéo thả
  let draggedImage = null;
  window.addDraggable = function(image){
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

// // Lấy ngày hôm nay
// const today = new Date();
// // Định dạng ngày dưới dạng yyyy-mm-dd cho input date
// const formattedDate = today.toISOString().split('T')[0];
// // Gán giá trị cho input date
// const inputNgay = document.getElementsByClassName('form-control');
// inputNgay[0].value = formattedDate;
// inputNgay[1].value = formattedDate;











// Lấy tất cả các mục trong dropdown
const dropdownItems = document.querySelectorAll('.dropdown-item');

// Gắn sự kiện click vào từng mục dropdown
dropdownItems.forEach(item => {
  item.addEventListener('click', function (e) {
    e.preventDefault(); // Ngăn không cho chuyển hướng nếu có href="#"

    // Lấy nút dropdown chứa mục đã chọn
    const dropdown = this.closest('.dropdown');
    const dropdownButton = dropdown.querySelector('.dropdown-toggle');

    // Lấy nội dung của mục được chọn
    const selectedText = this.textContent.trim();

    // Đổi nội dung của nút thành nội dung mục được chọn
    dropdownButton.textContent = selectedText;

    // Đổi màu nút dựa trên mục được chọn
    switch (selectedText) {
      case 'Chờ Duyệt':
        dropdownButton.className = 'btn btn-danger dropdown-toggle btn-sm';
        break;
      case 'Confirmed':
        dropdownButton.className = 'btn btn-info dropdown-toggle btn-sm';
        break;
      case 'Đã Nhận':
        dropdownButton.className = 'btn btn-primary dropdown-toggle btn-sm';
        break;
      case 'Hoàn Thành':
        dropdownButton.className = 'btn btn-success dropdown-toggle btn-sm';
        break;
      default:
        break;
    }
  });
});
