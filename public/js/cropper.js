document.getElementById('upload-image').addEventListener('change', function (e) {
    const file = e.target.files[0];
    const reader = new FileReader();
    document.getElementById('crop-area').setAttribute('style','display:block');

    reader.onload = function (event) {
        const img = new Image();
        img.onload = function () {
            const canvas = document.getElementById('canvas');
            const ctx = canvas.getContext('2d');
            const maxWidth = 320;
            const scale = maxWidth / img.width;

            const displayWidth = maxWidth;
            const displayHeight = img.height * scale;

            // Set the display size
            canvas.style.width = displayWidth + 'px';
            canvas.style.height = displayHeight + 'px';

            // Set the actual canvas size to the original image size
            canvas.width = img.width;
            canvas.height = img.height;

            ctx.drawImage(img, 0, 0, img.width, img.height);

            initCropArea(displayWidth, displayHeight);
        }
        img.src = event.target.result;
    }

    reader.readAsDataURL(file);
});

function initCropArea(displayWidth, displayHeight) {
    const cropArea = document.getElementById('crop-area');
    const canvasContainer = document.getElementById('canvas-container');
    const canvas = document.getElementById('canvas');

    cropArea.style.width = '150px';
    cropArea.style.height = '150px';
    cropArea.style.left = '85px';
    cropArea.style.top = '10px';

    cropArea.onmousedown = function (e) {
        e.preventDefault();

        let shiftX = e.clientX - cropArea.getBoundingClientRect().left;
        let shiftY = e.clientY - cropArea.getBoundingClientRect().top;

        document.onmousemove = function (e) {
            let newLeft = e.clientX - shiftX - canvasContainer.getBoundingClientRect().left;
            let newTop = e.clientY - shiftY - canvasContainer.getBoundingClientRect().top;

            newLeft = Math.max(0, Math.min(newLeft, displayWidth - cropArea.clientWidth));
            newTop = Math.max(0, Math.min(newTop, displayHeight - cropArea.clientHeight));

            cropArea.style.left = newLeft + 'px';
            cropArea.style.top = newTop + 'px';
        }

        document.onmouseup = function () {
            document.onmousemove = null;
            document.onmouseup = null;
        }
    }

    cropArea.ondragstart = function () {
        return false;
    }
}

function cropImageAndPutToInput(onComplete){
    const cropArea = document.getElementById('crop-area');
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');

    const cropCanvas = document.getElementById('cropped-canvas');
    const cropCtx = cropCanvas.getContext('2d');

    const displayWidth = parseInt(canvas.style.width);
    const displayHeight = parseInt(canvas.style.height);
    const actualWidth = canvas.width;
    const actualHeight = canvas.height;

    const scaleX = actualWidth / displayWidth;
    const scaleY = actualHeight / displayHeight;

    const cropX = parseInt(cropArea.style.left) * scaleX;
    const cropY = parseInt(cropArea.style.top) * scaleY;
    const cropWidth = cropArea.clientWidth * scaleX;
    const cropHeight = cropArea.clientHeight * scaleY;

    cropCanvas.width = cropWidth;
    cropCanvas.height = cropHeight;

    const imageData = ctx.getImageData(cropX, cropY, cropWidth, cropHeight);
    cropCtx.putImageData(imageData, 0, 0);

    // Convert the cropped canvas to a data URL and create a new File object
    cropCanvas.toBlob(function(blob) {
        const file = new File([blob], "cropped-image.png", { type: "image/png" });

        // Create a new DataTransfer object and add the file
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);

        // Set the file to the hidden input element
        const croppedImageFileInput = document.getElementById('cropped-image-file');
        croppedImageFileInput.files = dataTransfer.files;
        
        onComplete();

    });
}
