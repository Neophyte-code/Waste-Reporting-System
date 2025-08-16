// HISTORY MODAL
        const tabItems = document.querySelectorAll('.tab-item');

        tabItems.forEach(item => {
            item.addEventListener('click', () => {
                tabItems.forEach(el => el.classList.remove('bg-green-400')); 
                item.classList.add('bg-green-400');
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