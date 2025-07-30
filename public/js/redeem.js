 // === Redeem Modal ===
        const redeemModal = document.getElementById('redeemModal');
        const openRedeemBtn = document.getElementById('openRedeemModal');
        const closeRedeemBtn = document.getElementById('closeRedeemModal');
        const redeemFileInput = document.getElementById('file-input-redeem');
        const redeemPreviewDiv = document.getElementById('preview-redeem');
        const redeemUploadDiv = document.getElementById('upload-redeem');
        const redeemPreviewImg = document.getElementById('preview-image-redeem');
        const redeemClosePreview = document.getElementById('close-preview-redeem');
        const submitRedeem = document.getElementById('submitRedeem');
        const conversionButtons = document.querySelectorAll('.conversion-btn');
        let selectedConversion = null;

        // Handle button selection
        conversionButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active style from all buttons
                conversionButtons.forEach(b => b.classList.remove('bg-green-200', 'ring-2', 'ring-green-500'));

                // Add active style to clicked button
                btn.classList.add('bg-green-200', 'ring-2', 'ring-green-500');
                selectedConversion = btn;
            });
        });

        // Allow only numbers in mobile number input
        const gcashNumber = document.getElementById('gcashNumber');
        gcashNumber.addEventListener('input', () => {
            gcashNumber.value = gcashNumber.value.replace(/\D/g, ''); // Remove non-digits
        });

        function handleRedeemSubmit() {
            const number = gcashNumber.value.trim();
            const name = document.getElementById('gcashName').value.trim();
            const file = redeemFileInput.files[0];

            if (!number || !name || !file || !selectedConversion) {
                alert('Please complete all required fields including selecting a conversion amount and uploading a file.');
                return;
            }

            alert('Redemption Submitted Successfully!');
            redeemModal.classList.add('hidden');

            // Reset state
            gcashNumber.value = '';
            document.getElementById('gcashName').value = '';
            resetRedeemFileInput();
            conversionButtons.forEach(b => b.classList.remove('bg-green-200', 'ring-2', 'ring-green-500'));
            selectedConversion = null;
        }



        openRedeemBtn?.addEventListener("click", () => {
            redeemModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Disable background scroll

            // Clear old listeners to prevent duplication
            const newSubmit = submitRedeem.cloneNode(true);
            submitRedeem.parentNode.replaceChild(newSubmit, submitRedeem);
            newSubmit.addEventListener('click', handleRedeemSubmit);
        });


        closeRedeemBtn?.addEventListener("click", () => {
            redeemModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden'); // Re-enable scroll
        });

        redeemFileInput?.addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    redeemPreviewImg.src = e.target.result;
                    redeemPreviewDiv.classList.remove('hidden');
                    redeemUploadDiv.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        redeemClosePreview?.addEventListener('click', () => {
            resetRedeemFileInput();
        });

        submitRedeem?.addEventListener('click', handleRedeemSubmit, {
            once: true
        });

        function handleRedeemSubmit() {
            const number = gcashNumber.value.trim();
            const name = document.getElementById('gcashName').value.trim();
            const file = redeemFileInput.files[0];

            if (!number || !name || !file || !selectedConversion) {
                alert('Please complete all required fields including selecting a conversion amount and uploading a file.');
                // Re-attach listener if validation fails
                submitRedeem.addEventListener('click', handleRedeemSubmit, {
                    once: true
                });
                return;
            }

            alert('Redemption Submitted Successfully!');
            redeemModal.classList.add('hidden');

            // Reset everything
            gcashNumber.value = '';
            document.getElementById('gcashName').value = '';
            resetRedeemFileInput();
            conversionButtons.forEach(b => b.classList.remove('bg-green-200', 'ring-2', 'ring-green-500'));
            selectedConversion = null;

            // Re-attach listener for next time
            submitRedeem.addEventListener('click', handleRedeemSubmit, {
                once: true
            });
        }


        function resetRedeemFileInput() {
            redeemPreviewImg.src = '';
            redeemPreviewDiv.classList.add('hidden');
            redeemUploadDiv.classList.remove('hidden');
            redeemFileInput.value = '';
        }
