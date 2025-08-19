
async function fetchNotifications() {
    try {
        const response = await fetch(`${URL_ROOT}/waste/getNotifications`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        });

        console.log('Response status:', response.status);
        console.log('Response headers:', [...response.headers.entries()]);
        
        if (!response.ok) {
            console.error('Response not OK:', response);
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const notifications = await response.json();
        console.log('Received notifications:', notifications);

        const notificationContent = document.getElementById('notificationContent');
        const notificationBadge = document.getElementById('notificationBadge');
        const notificationCount = document.getElementById('notificationCount');
        const emptyNotifications = document.getElementById('emptyNotifications');

        // Clear existing notifications
        notificationContent.innerHTML = '';

        if (!notifications || notifications.length === 0) {
            emptyNotifications.classList.remove('hidden');
            notificationBadge.textContent = '0';
            notificationCount.textContent = '0';
            return;
        }

        emptyNotifications.classList.add('hidden');
        
        // Count unread notifications
        const unreadCount = notifications.filter(n => !n.is_read).length;
        notificationBadge.textContent = unreadCount;
        notificationCount.textContent = unreadCount;

        // Sort notifications by date (newest first)
        notifications.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

        notifications.forEach(notification => {
            const notificationItem = document.createElement('div');
            notificationItem.className = `p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors ${notification.is_read ? '' : 'bg-gray-50'}`;
            notificationItem.onclick = () => markAsRead(notification.id, notificationItem);

            // Determine icon and colors based on notification type
            let iconName, bgClass, iconColor;
            if (notification.type === 'report_status') {
                iconName = 'trash';
                bgClass = 'bg-green-100';
                iconColor = 'text-green-600';
            } else if (notification.type === 'report_submitted') {
                iconName = 'checkmark-circle';
                bgClass = 'bg-blue-100';
                iconColor = 'text-blue-600';
            } else {
                iconName = 'notifications';
                bgClass = 'bg-gray-100';
                iconColor = 'text-gray-600';
            }

            // Format the date
            const notificationDate = new Date(notification.created_at);
            const formattedDate = notificationDate.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            notificationItem.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 ${bgClass} rounded-full flex items-center justify-center">
                            <ion-icon name="${iconName}" class="${iconColor} text-lg"></ion-icon>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="text-sm font-semibold text-gray-800">${notification.title}</h4>
                            ${notification.is_read ? '' : '<div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>'}
                        </div>
                        <p class="text-sm text-gray-600 mb-1">${notification.message}</p>
                        <p class="text-xs text-gray-400">${formattedDate}</p>
                    </div>
                </div>
            `;
            notificationContent.appendChild(notificationItem);
        });

    } catch (error) {
        console.error('Error fetching notifications:', error);
        // Show error state in UI
        const notificationContent = document.getElementById('notificationContent');
        notificationContent.innerHTML = `
            <div class="p-8 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <ion-icon name="warning" class="text-2xl text-red-500"></ion-icon>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Error loading notifications</h3>
                <p class="text-gray-500 text-sm">Please try again later.</p>
            </div>
        `;
    }
}

// Mark a notification as read
async function markAsRead(notificationId, element) {
    try {
        console.log('Marking notification as read:', notificationId); // Debug log
        const response = await fetch(`${URL_ROOT}/waste/markNotificationAsRead`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: notificationId }),
            credentials: 'same-origin'
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        console.log('Mark as read result:', result); // Debug log

        if (result.success) {
            // Remove the unread indicator
            element.querySelector('.bg-blue-500')?.remove();
            // Update the unread count
            fetchNotifications();
        }
    } catch (error) {
        console.error('Error marking notification as read:', error);
    }
}

// Mark all notifications as read
async function markAllAsRead() {
    try {
        console.log('Marking all notifications as read'); // Debug log
        const response = await fetch(`${URL_ROOT}/waste/markAllNotificationsAsRead`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        console.log('Mark all as read result:', result); // Debug log

        if (result.success) {
            fetchNotifications();
        }
    } catch (error) {
        console.error('Error marking all notifications as read:', error);
    }
}

// Fetch notifications when modal is opened
function openNotificationModal() {
    const modal = document.getElementById('notificationModal');
    const modalContent = document.getElementById('notificationModalContent');
    
    console.log('Opening notification modal'); // Debug log
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('translate-x-full', 'opacity-0');
    }, 10);
    
    fetchNotifications();
}

function closeNotificationModal() {
    const modal = document.getElementById('notificationModal');
    const modalContent = document.getElementById('notificationModalContent');
    
    console.log('Closing notification modal'); // Debug log
    modalContent.classList.add('translate-x-full', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('notificationModal');
    const modalContent = document.getElementById('notificationModalContent');
    
    if (event.target === modal && !modalContent.contains(event.target)) {
        closeNotificationModal();
    }
});

// Initialize notification system when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if notification elements exist
    if (document.getElementById('notificationModal')) {
        console.log('Initializing notification system'); // Debug log
        
        // Add click handler to notification icon
        const notificationIcon = document.querySelector('ion-icon[name="notifications-outline"]');
        if (notificationIcon) {
            notificationIcon.addEventListener('click', openNotificationModal);
        }
        
        // Initial fetch of notifications
        fetchNotifications();
        
        // Set up periodic refresh (every 5 minutes)
        setInterval(fetchNotifications, 300000);
    }
});

// View all notifications (if you have a separate page for this)
function viewAllNotifications() {
    window.location.href = `${URL_ROOT}/notifications`;
}