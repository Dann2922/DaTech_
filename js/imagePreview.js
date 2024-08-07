function previewImage(input, previewContainer) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imgElement = document.createElement('img');
            imgElement.src = e.target.result;
            previewContainer.innerHTML = '';
            previewContainer.appendChild(imgElement);
        }
        reader.readAsDataURL(file);
    }
}

// Main image preview
document.getElementById('pro_image_detail').addEventListener('change', function() {
    previewImage(this, document.getElementById('pro_image_detail_preview'));
});

// Sub-images preview
function previewSubImages() {
    const subImagesContainer = document.getElementById('sub-images-container');
    const subImagesPreview = document.getElementById('sub_images_preview');
    subImagesPreview.innerHTML = '';
    const inputs = subImagesContainer.querySelectorAll('input[type="file"]');
    inputs.forEach(input => {
        if (input.files.length > 0) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                subImagesPreview.appendChild(imgElement);
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
}

// Add event listener to sub-images input container
document.getElementById('sub-images-container').addEventListener('change', previewSubImages);

// Add new sub-image input
document.getElementById('add-sub-image-button').addEventListener('click', function() {
    const container = document.getElementById('sub-images-container');
    const div = document.createElement('div');
    div.innerHTML = '<input type="file" name="sub_images[]" required>';
    container.appendChild(div);

    // Add event listener to new input
    div.querySelector('input').addEventListener('change', previewSubImages);
});
