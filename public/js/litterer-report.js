// report litterer 
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('file-input');
            const uploadPrompt = document.getElementById('upload-prompt');
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            const closePreview = document.getElementById('close-preview');

            fileInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    // Check file size (10MB limit)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('File size exceeds 10MB limit');
                        fileInput.value = '';
                        return;
                    }

                    // Check file type
                    const validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
                    if (!validTypes.includes(file.type)) {
                        alert('Please upload a PNG, JPG, or JPEG file');
                        fileInput.value = '';
                        return;
                    }

                    // Create URL for preview
                    const imageUrl = URL.createObjectURL(file);
                    previewImage.src = imageUrl;

                    // Show preview and hide prompt
                    previewContainer.classList.remove('hidden');
                    uploadPrompt.classList.add('hidden');
                }
            });

            // Clear preview when close button is clicked
            closePreview.addEventListener('click', () => {
                fileInput.value = '';
                previewImage.src = '';
                previewContainer.classList.add('hidden');
                uploadPrompt.classList.remove('hidden');
            });
        });