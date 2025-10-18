       // Profile Modal Functions
    function openProfileModal() {
        const modal = document.getElementById('profileModal');
        const modalContent = document.getElementById('modalContent');
        
        // Close notification modal if open
        closeNotificationModal();
        
        modal.classList.remove('hidden');
        
        // Trigger animation - slide in from right
        setTimeout(() => {
            modalContent.classList.remove('translate-x-full', 'opacity-0');
            modalContent.classList.add('translate-x-0', 'opacity-100');
        }, 10);
    }

    function closeProfileModal() {
        const modal = document.getElementById('profileModal');
        const modalContent = document.getElementById('modalContent');
        
        if (!modal.classList.contains('hidden')) {
            modalContent.classList.remove('translate-x-0', 'opacity-100');
            modalContent.classList.add('translate-x-full', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                // Reset to menu view if in edit mode
                if (!document.getElementById('editForm').classList.contains('hidden')) {
                    cancelEdit();
                }
            }, 300);
        }
    }

    function toggleEditMode() {
        const menuItems = document.getElementById('menuItems');
        const editForm = document.getElementById('editForm');
        
        menuItems.classList.toggle('hidden');
        editForm.classList.toggle('hidden');
    }

    function saveProfile() {
        // Here you would typically save the profile data
        alert('Profile saved successfully!');
        cancelEdit();
    }

    function cancelEdit() {
        const menuItems = document.getElementById('menuItems');
        const editForm = document.getElementById('editForm');
        
        menuItems.classList.remove('hidden');
        editForm.classList.add('hidden');
    }

    function handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
                // Here you would typically upload the image to your server
                alert('Profile picture updated!');
            }
            reader.readAsDataURL(file);
        }
    }

    // Close modals when clicking outside
    document.addEventListener('click', function(e) {
        const profileModal = document.getElementById('profileModal');
        const notificationModal = document.getElementById('notificationModal');
        const profileImg = document.querySelector('img[onclick="openProfileModal()"]');
        const notificationIcon = document.querySelector('img[onclick="openNotificationModal()"]');
        
        // Check profile modal
        if (!profileModal.classList.contains('hidden') && 
            !profileModal.contains(e.target) && 
            e.target !== profileImg) {
            closeProfileModal();
        }
        
        // Check notification modal
        if (!notificationModal.classList.contains('hidden') && 
            !notificationModal.contains(e.target) && 
            e.target !== notificationIcon) {
            closeNotificationModal();
        }
    });