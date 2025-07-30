const form = document.getElementById('uploadForm');
const imageInput = document.getElementById('wasteImage');
const previewContainer = document.getElementById('preview-container');
const uploadPrompt = document.getElementById('upload-prompt');
const previewImage = document.getElementById('preview-image');
const closePreview = document.getElementById('close-preview');
const errorDiv = document.getElementById('error');
const wasteDescription = document.getElementById('wasteDescription');
const wasteWeight = document.getElementById('wasteWeight');

// Preview image before upload
imageInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
const reader = new FileReader();
reader.onload = function(e) {
    previewImage.src = e.target.result;
    previewContainer.classList.remove('hidden');
    uploadPrompt.classList.add('hidden');
};
reader.readAsDataURL(file);
    }
});

// Remove preview image
closePreview.addEventListener('click', () => {
    previewImage.src = '';
    previewContainer.classList.add('hidden');
    uploadPrompt.classList.remove('hidden');
    imageInput.value = '';
});

// Handle form submission
form.addEventListener('submit', async function(e) {
    e.preventDefault();
    errorDiv.textContent = '';
    wasteDescription.value = '';
    wasteWeight.value = '';
    verifyBtn.value = 'Processing...'

    const formData = new FormData();
    if (imageInput.files[0]) {
        formData.append('wasteImage', imageInput.files[0]);
    } else {
        errorDiv.textContent = 'Please select an image.';
        return;
    }

    try {
        console.log("URL being fetched:", `${URL_ROOT}/waste/process`);
        const response = await fetch(`${URL_ROOT}/waste/process`, {
        method: 'POST',
        body: formData
    });

    const result = await response.json();

    if (response.ok) {
        wasteDescription.value = result.wasteType ;
        wasteWeight.value = result.wasteWeight;
    } else {
        errorDiv.textContent = result.error || 'An error occurred.';
    }
        } catch (error) {
        errorDiv.textContent = 'Failed to connect to the server.';
        }
    });