  function openNotificationModal() {
    const modal = document.getElementById('notificationModal');
    const modalContent = document.getElementById('notificationModalContent');
    
    // Close profile modal if open
    closeProfileModal();
    
    // Reset the modal state
    resetNotificationModal();
    
    modal.classList.remove('hidden');
    
    // Trigger animation - slide in from right
    setTimeout(() => {
        modalContent.classList.remove('translate-x-full', 'opacity-0');
        modalContent.classList.add('translate-x-0', 'opacity-100');
    }, 10);
}

function resetNotificationModal() {
    const notificationContent = document.getElementById('notificationContent');
    // Reset overflow to hidden when reopening modal
    notificationContent.classList.remove('overflow-y-auto');
    notificationContent.classList.add('overflow-y-hidden');
    
    // Hide all notifications beyond the first few
    const allNotifications = document.querySelectorAll('#notificationContent > div:not(#emptyNotifications)');
    const maxInitialNotifications = 3;
    
    allNotifications.forEach((notification, index) => {
        if (index >= maxInitialNotifications) {
            notification.classList.add('hidden');
        } else {
            notification.classList.remove('hidden');
        }
    });
    
    // Show the "View All Notifications" button if there are more notifications
    const viewAllButton = document.getElementById('viewAllButtonContainer');
    if (allNotifications.length > maxInitialNotifications) {
        viewAllButton.classList.remove('hidden');
    } else {
        viewAllButton.classList.add('hidden');
    }
    
    // Hide the empty state if it was shown
    document.getElementById('emptyNotifications').classList.add('hidden');
    
    // Update notification count
    updateNotificationCount();
}

function closeNotificationModal() {
    const modal = document.getElementById('notificationModal');
    const modalContent = document.getElementById('notificationModalContent');
    
    modalContent.classList.remove('translate-x-0', 'opacity-100');
    modalContent.classList.add('translate-x-full', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function markAsRead(element) {
    // Remove the blue dot indicator
    const blueDot = element.querySelector('.bg-blue-500');
    if (blueDot) {
        blueDot.remove();
        // Update notification count
        updateNotificationCount();
    }
}

function markAllAsRead() {
    // Remove all blue dots
    const blueDots = document.querySelectorAll('#notificationModal .bg-blue-500');
    blueDots.forEach(dot => {
        if (dot.classList.contains('w-2') && dot.classList.contains('h-2')) {
            dot.remove();
        }
    });
    
    // Update notification count
    updateNotificationCount();
}

function updateNotificationCount() {
    const unreadDots = document.querySelectorAll('#notificationModal .bg-blue-500.w-2.h-2');
    const count = unreadDots.length;
    const badge = document.getElementById('notificationBadge');
    const headerBadge = document.querySelector('#notificationModal .bg-red-500');
    
    if (count === 0) {
        badge.style.display = 'none';
        if (headerBadge) headerBadge.style.display = 'none';
        
        // Check if we should show empty state
        const hasVisibleNotifications = document.querySelectorAll('#notificationContent > div:not(.hidden):not(#emptyNotifications)').length > 0;
        const emptyState = document.getElementById('emptyNotifications');
        
        if (!hasVisibleNotifications) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    } else {
        badge.textContent = count;
        badge.style.display = 'flex';
        if (headerBadge) {
            headerBadge.textContent = count;
            headerBadge.style.display = 'inline-block';
        }
    }
}

function viewAllNotifications() {
    // Show all hidden notifications
    const hiddenNotifications = document.querySelectorAll('#notificationContent .hidden');
    hiddenNotifications.forEach(notification => {
        notification.classList.remove('hidden');
    });
    
    // Change overflow to auto to enable scrolling
    const notificationContent = document.getElementById('notificationContent');
    notificationContent.classList.remove('overflow-y-hidden');
    notificationContent.classList.add('overflow-y-auto');
    
    // Hide the "View All Notifications" button
    document.getElementById('viewAllButtonContainer').classList.add('hidden');
    
    // Update notification count in case some were hidden
    updateNotificationCount();
}

     
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
        const notificationIcon = document.querySelector('ion-icon[onclick="openNotificationModal()"]');
        
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