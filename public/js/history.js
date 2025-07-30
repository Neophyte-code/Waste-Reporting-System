// HISTORY MODAL

        const tabItems = document.querySelectorAll('.tab-item');

        tabItems.forEach(item => {
            item.addEventListener('click', () => {
                tabItems.forEach(el => el.classList.remove('bg-green-400')); // remove active class from all
                item.classList.add('bg-green-400'); // add active class to clicked
            });
        });

        const modal = document.getElementById('historyModal');
        const modalBox = document.getElementById('modalBox');
        const openBtn = document.querySelector('.transaction');
        const closeBtn = document.querySelector('.close');

        // Open Modal
        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // Trigger animation after small delay to allow DOM render
            setTimeout(() => {
                modalBox.classList.remove('opacity-0', 'translate-y-10', 'scale-95');
                modalBox.classList.add('opacity-100', 'translate-y-0', 'scale-100');
            }, 10);

            // Always show all history when modal opens
            filterHistory('all');

            // Optionally, reset active tab styling to 'All'
            tabItems.forEach(el => el.classList.remove('bg-green-400'));
            allButton.classList.add('bg-green-400');
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
            }, 200); // match transition duration
        });

        // Filtering logic
        const allButton = document.getElementById('filter-all');
        const reportButton = document.getElementById('filter-report');
        const redeemButton = document.getElementById('filter-redeem');


        // Grab all history entries
        const historyItems = document.querySelectorAll('#historyModal .space-y-4 > div');

        // Helper function to filter
        function filterHistory(type) {
            historyItems.forEach(item => {
                const title = item.querySelector('h1').textContent.toLowerCase();
                if (type === 'all') {
                    item.classList.remove('hidden');
                } else if (type === 'report') {
                    if (title.includes('waste-report') || title.includes('report-literrer')) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                } else if (type === 'redeem') {
                    if (title.includes('redeem')) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                }
            });
        }

        // Event listeners for filter buttons
        allButton.addEventListener('click', () => filterHistory('all'));
        reportButton.addEventListener('click', () => filterHistory('report'));
        redeemButton.addEventListener('click', () => filterHistory('redeem'));
