// Sidebar controls (named functions) + close on outside click
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

        function openSidebarMenu() {
            sidebar.classList.remove('-translate-x-full');
        }

        function closeSidebarMenu() {
            sidebar.classList.add('-translate-x-full');
        }

        function toggleSidebarMenu() {
            sidebar.classList.toggle('-translate-x-full');
        }

        // // Toggle button should not allow the document click handler to immediately close it
        if (toggleBtn) toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleSidebarMenu();
        });

        // // Prevent clicks inside the sidebar from bubbling to document (so it won't close)
        if (sidebar) sidebar.addEventListener('click', (e) => {
            e.stopPropagation();
        });

        // // Close sidebar when clicking outside it (only when it's currently open)
        document.addEventListener('click', (e) => {
            if (!sidebar) return;
            const isHidden = sidebar.classList.contains('-translate-x-full');
            if (!isHidden) {
                // click outside sidebar -> close
                if (!e.target.closest || !e.target.closest('#sidebar')) {
                    closeSidebarMenu();
                }
            }
        });