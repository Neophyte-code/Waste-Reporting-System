// === Redeem Modal ===
const redeemModal = document.getElementById('redeemModal');
const openRedeemBtn = document.getElementById('openRedeemModal');
const closeRedeemBtn = document.getElementById('closeRedeemModal');
const redeemFileInput = document.getElementById('file-input-redeem');
const redeemPreviewDiv = document.getElementById('preview-redeem');
const redeemUploadDiv = document.getElementById('upload-redeem');
const redeemPreviewImg = document.getElementById('preview-image-redeem');
const redeemClosePreview = document.getElementById('close-preview-redeem');
const redeemForm = document.getElementById('redeem-form');
const conversionButtons = document.querySelectorAll('.conversion-btn');
const gcashNumber = document.getElementById('gcashNumber');
const pointsInput = document.getElementById('points');

// Handle button selection
conversionButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        // Remove active style from all buttons
        conversionButtons.forEach(b => b.classList.remove('bg-green-200', 'ring-2', 'ring-green-500'));

        // Add active style to clicked button
        btn.classList.add('bg-green-200', 'ring-2', 'ring-green-500');

        // Set hidden points input
        pointsInput.value = btn.dataset.points;
    });
});

// Allow only numbers in mobile number input
gcashNumber.addEventListener('input', () => {
    gcashNumber.value = gcashNumber.value.replace(/\D/g, ''); 
});

// Open modal
openRedeemBtn?.addEventListener("click", () => {
    redeemModal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');

    // Reset form on open
    resetRedeemForm();
});

// Close modal
closeRedeemBtn?.addEventListener("click", () => {
    redeemModal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    resetRedeemForm();
});

// Handle file input change for image preview
redeemFileInput?.addEventListener('change', () => {
    const file = redeemFileInput.files[0];
    if (file) {
        // Validate file type
        const validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            alert('Please upload a PNG, JPG, or JPEG file.');
            resetRedeemFileInput();
            return;
        }

        // Validate file size (10MB = 10 * 1024 * 1024 bytes)
        if (file.size > 10 * 1024 * 1024) {
            alert('File size exceeds 10MB limit.');
            resetRedeemFileInput();
            return;
        }

        // Read and display the image
        const reader = new FileReader();
        reader.onload = (e) => {
            redeemPreviewImg.src = e.target.result;
            redeemPreviewDiv.classList.remove('hidden');
            redeemUploadDiv.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        resetRedeemFileInput();
    }
});

// Reset file input and preview
redeemClosePreview?.addEventListener('click', () => {
    resetRedeemFileInput();
});

// Function to reset file input and preview
function resetRedeemFileInput() {
    redeemFileInput.value = '';
    redeemPreviewDiv.classList.add('hidden');
    redeemUploadDiv.classList.remove('hidden');
    redeemPreviewImg.src = ''; 
}

// Function to reset entire form
function resetRedeemForm() {
    // Reset buttons
    conversionButtons.forEach(b => b.classList.remove('bg-green-200', 'ring-2', 'ring-green-500'));
    pointsInput.value = '';

    // Reset inputs
    gcashNumber.value = '';
    document.getElementById('gcashName').value = '';

    // Reset file
    resetRedeemFileInput();
}

// Handle form submission with validation
redeemForm.addEventListener('submit', (event) => {
    const gcashNumberValue = gcashNumber.value;
    const gcashName = document.getElementById('gcashName').value;
    const file = redeemFileInput.files[0];

    if (!pointsInput.value) {
        alert('Please select a conversion amount.');
        event.preventDefault();
        return;
    }
    if (!gcashNumberValue || gcashNumberValue.length !== 11) {
        alert('Please enter a valid 11-digit mobile number.');
        event.preventDefault();
        return;
    }
    if (!gcashName) {
        alert('Please enter a Gcash name.');
        event.preventDefault();
        return;
    }
    if (!file) {
        alert('Please upload a file.');
        event.preventDefault();
        return;
    }
});