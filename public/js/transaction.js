// HISTORY MODAL
const tabItems = document.querySelectorAll('.tab-item');
const modal = document.getElementById('historyModal');
const modalBox = document.getElementById('modalBox');
const openBtn = document.querySelector('.transaction');
const closeBtn = document.querySelector('.close');

// Tab functionality
tabItems.forEach(item => {
    item.addEventListener('click', () => {
        tabItems.forEach(el => el.classList.remove('bg-green-400')); 
        item.classList.add('bg-green-400');
    });
});

// Fetch transaction history
async function fetchHistory() {
    try {
        const response = await fetch(`${URL_ROOT}/user/getHistory`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        });
        
        if (!response.ok) {
            console.error('Response not OK:', response);
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const history = await response.json();

        const historyContainer = document.querySelector('#historyModal .space-y-4');
        
        // Clear existing history items (keep only the container)
        historyContainer.innerHTML = '';

        if (!history || history.length === 0) {
            historyContainer.innerHTML = `
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-history text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">No transaction history</h3>
                    <p class="text-gray-500 text-sm">Your transaction history will appear here.</p>
                </div>
            `;
            return;
        }

        // Sort history by date (newest first)
        history.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

        history.forEach(transaction => {
            const historyItem = document.createElement('div');
            historyItem.className = 'flex justify-between item-center border border-gray-300 rounded-md shadow-md px-3 py-4';

            // Determine icon and status based on transaction type
            let icon, statusText, statusColor, pointsDisplay;
            
            if (transaction.type === 'redemption_request') {
                icon = 'fa-solid fa-circle-dollar-to-slot';
                pointsDisplay = `- ${Math.abs(transaction.points_change)}`;
                
                // Determine status color based on transaction status
                if (transaction.status === 'pending') {
                    statusText = 'Pending';
                    statusColor = 'text-yellow-500';
                } else if (transaction.status === 'approved') {
                    statusText = 'Successful';
                    statusColor = 'text-green-500';
                } else if (transaction.status === 'rejected') {
                    statusText = 'Failed';
                    statusColor = 'text-red-500';
                }
            } else if (transaction.type === 'waste_report') {
                icon = 'fa-solid fa-clipboard-list';
                pointsDisplay = transaction.points_change > 0 ? `+ ${transaction.points_change}` : `${transaction.points_change}`;
                
                if (transaction.status === 'pending') {
                    statusText = 'Pending';
                    statusColor = 'text-yellow-500';
                } else if (transaction.status === 'approved') {
                    statusText = 'Successful';
                    statusColor = 'text-green-500';
                } else if (transaction.status === 'rejected') {
                    statusText = 'Failed';
                    statusColor = 'text-red-500';
                }
            } else if (transaction.type === 'report_litterer') {
                icon = 'fa-solid fa-clipboard-list';
                pointsDisplay = transaction.points_change > 0 ? `+ ${transaction.points_change}` : `${transaction.points_change}`;
                
                if (transaction.status === 'pending') {
                    statusText = 'Pending';
                    statusColor = 'text-yellow-500';
                } else if (transaction.status === 'approved') {
                    statusText = 'Successful';
                    statusColor = 'text-green-500';
                } else if (transaction.status === 'rejected') {
                    statusText = 'Failed';
                    statusColor = 'text-red-500';
                }
            } else {
                // Default for other types
                icon = 'fa-solid fa-clipboard-list';
                pointsDisplay = transaction.points_change > 0 ? `+ ${transaction.points_change}` : `${transaction.points_change}`;
                statusText = transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1);
                statusColor = 'text-gray-500';
            }

            // Format the date
            const transactionDate = new Date(transaction.created_at);
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 1);

            let dateDisplay, timeDisplay;
            if (transactionDate.toDateString() === today.toDateString()) {
                dateDisplay = 'Today';
            } else if (transactionDate.toDateString() === yesterday.toDateString()) {
                dateDisplay = 'Yesterday';
            } else {
                dateDisplay = transactionDate.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric'
                });
            }
            
            timeDisplay = transactionDate.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });

            // Create the HTML structure
            historyItem.innerHTML = `
                <div class="flex justify-between items-center gap-4">
                    <i class="${icon} text-green-500 text-4xl"></i>
                    <div class="flex flex-col space-y-1">
                        <h1 class="text-sm font-bold">${transaction.title}</h1>
                        ${transaction.message ? `<p class="text-xs text-gray-500">${transaction.message}</p>` : ''}
                        <div class="flex gap-2 text-xs text-gray-400">
                            <p>${dateDisplay}</p>
                            <p>${timeDisplay}</p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center items-center">
                    ${transaction.type === 'redemption_request' 
                        ? (transaction.status === 'pending' 
                            ? `<p class="${statusColor} text-sm w-24 font-bold text-center py-1 rounded-2xl">${statusText}</p>`
                            : transaction.status === 'approved'
                                ? `<p class="text-red-500 text-sm w-24 font-bold text-center py-1 rounded-2xl">${pointsDisplay}</p>`
                                : `<p class="${statusColor} text-sm w-24 font-bold text-center py-1 rounded-2xl">${statusText}</p>`)
                        : transaction.points_change !== 0 
                            ? `<p class="${transaction.points_change > 0 ? 'text-green-500' : 'text-red-500'} text-sm w-24 font-bold text-center py-1 rounded-2xl">${pointsDisplay}</p>`
                            : `<p class="${statusColor} text-sm w-24 font-bold text-center py-1 rounded-2xl">${statusText}</p>`
                    }
                </div>
            `;

            historyContainer.appendChild(historyItem);
        });

    } catch (error) {
        console.error('Error fetching history:', error);
        // Show error state in UI
        const historyContainer = document.querySelector('#historyModal .space-y-4');
        historyContainer.innerHTML = `
            <div class="p-8 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-exclamation-triangle text-2xl text-red-500"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Error loading history</h3>
                <p class="text-gray-500 text-sm">Please try again later.</p>
                <button onclick="fetchHistory()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Retry
                </button>
            </div>
        `;
    }
}

// Open Modal
openBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');

    // Trigger animation after small delay to allow DOM render
    setTimeout(() => {
        modalBox.classList.remove('opacity-0', 'translate-y-10', 'scale-95');
        modalBox.classList.add('opacity-100', 'translate-y-0', 'scale-100');
    }, 10);

    // Fetch history data when modal opens
    fetchHistory();
});

// Close Modal
closeBtn.addEventListener('click', () => {
    // Animate out
    modalBox.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
    modalBox.classList.add('opacity-0', 'translate-y-10', 'scale-95');

    // Wait for animation to finish before hiding
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }, 200); 
});

// Close modal when clicking outside
modal.addEventListener('click', (event) => {
    if (event.target === modal && !modalBox.contains(event.target)) {
        closeBtn.click(); 
    }
});

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
});