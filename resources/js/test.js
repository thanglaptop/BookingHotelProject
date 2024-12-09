const images = document.querySelectorAll('.draggable');
let draggedImage = null;

images.forEach((image) => {
  // Sự kiện khi bắt đầu kéo ảnh
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
});