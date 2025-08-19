  
        // === Report waste Submission ===
        const reportFileInput = document.getElementById('file-input');
        const reportPreviewContainer = document.getElementById('preview-container');
        const reportPreviewImage = document.getElementById('preview-image');
        const reportClosePreview = document.getElementById('close-preview');
        const reportUploadPrompt = document.getElementById('upload-prompt');
        const reportSubmitButton = document.getElementById('submit-button');

        let reportFileUploaded = false;

        reportFileInput?.addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    reportPreviewImage.src = e.target.result;
                    reportPreviewContainer.classList.remove('hidden');
                    reportUploadPrompt.classList.add('hidden');
                    reportFileUploaded = true;
                };
                reader.readAsDataURL(file);
            } else {
                alert('Invalid file type. Please upload PNG, JPG, or JPEG.');
                this.value = '';
            }
        });

        reportClosePreview?.addEventListener('click', function() {
            resetReportFileInput();
        });

        reportSubmitButton?.addEventListener('click', function(e) {
            e.preventDefault(); // prevent form submission

            const wasteTypeInput = document.querySelector('input[placeholder*="Waste Type"]');
            const estimatedWasteInput = document.querySelector('input[placeholder*="Estimated Weight"]');

            const wasteType = wasteTypeInput?.value.trim();
            const estimatedWaste = estimatedWasteInput?.value.trim();

            if (!wasteType || !estimatedWaste || !reportFileUploaded) {
                alert('Please fill in all fields and upload an image before submitting the report.');
                return;
            }

            alert('Report submitted successfully!');
            // Reset form
            wasteTypeInput.value = '';
            estimatedWasteInput.value = '';
            resetReportFileInput();
        });

        function resetReportFileInput() {
            reportPreviewImage.src = '';
            reportPreviewContainer.classList.add('hidden');
            reportUploadPrompt.classList.remove('hidden');
            reportFileInput.value = '';
            reportFileUploaded = false;
        }