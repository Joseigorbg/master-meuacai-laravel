function openVideoPopup(videoSrc) {
    let videoPopupContent = `
        <div class="video-popup">
            <button class="close-button btn btn-danger">×</button>
            <video src="${videoSrc}" controls autoplay></video>
        </div>
    `;
    document.getElementById('modalContainer').innerHTML = videoPopupContent;

    var closeButton = document.querySelector('.close-button');
    if (closeButton) {
        closeButton.addEventListener('click', () => {
            document.getElementById('modalContainer').innerHTML = '';
        });
    }
}

function openImagePopup(index) {
    currentImageIndex = index;
    let imagePopupContent = `
        <div class="image-popup">
            <button class="close-button">×</button>
            <button class="nav-button prev-button" onclick="prevImage()">❮</button>
            <img src="${imagesArray[currentImageIndex]}" alt="Imagem do Ponto">
            <button class="nav-button next-button" onclick="nextImage()">❯</button>
        </div>
    `;
    document.getElementById('modalContainer').innerHTML = imagePopupContent;

    var closeButton = document.querySelector('.close-button');
    if (closeButton) {
        closeButton.addEventListener('click', () => {
            document.getElementById('modalContainer').innerHTML = '';
        });
    }
}

function prevImage() {
    if (currentImageIndex > 0) {
        currentImageIndex--;
        openImagePopup(currentImageIndex);
    }
}

function nextImage() {
    if (currentImageIndex < imagesArray.length - 1) {
        currentImageIndex++;
        openImagePopup(currentImageIndex);
    }
}