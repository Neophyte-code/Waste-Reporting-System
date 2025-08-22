<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Admin ViewReports</title>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/output.css">
</head>

<body class="min-h-screen h-screen  overflow-hidden flex flex-col bg-gradient-to-r from-green-100 via-emerald-200 to-green-500">

    <div class="flex-grow flex flex-col flex-1 md:flex-row h-full">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-green-100 min-w-55 p-4 flex flex-col items-center absolute md:relative md:translate-x-0 -translate-x-full transition-transform duration-300 z-50 h-full md:h-auto shadow-lg">
            <img src="<?php echo URL_ROOT; ?>/images/icons/tree3.png" alt="" class="w-[110px] h-[110px] rounded-full mt-2">
            <p class="text-center text-md mt-1 mb-4">
                Welcome back<br>
                <span class="font-semibold">Admin</span>
            </p>
            <!-- Navigation -->
            <nav id="navMenu" class="flex flex-col w-full">
                <ul class="space-y-1">
                    <li>
                        <a href="<?php echo URL_ROOT; ?>/admin" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
                            <img class="size-5" src="<?php echo URL_ROOT; ?>/images/icons/dashboard-icon.png" alt=""> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo URL_ROOT; ?>/admin/reports" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
                            <img class="size-5" src="<?php echo URL_ROOT; ?>/images/icons/view-report-icon.png" alt=""> Reports
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo URL_ROOT; ?>/admin/user_info" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
                            <img class="size-5" src="<?php echo URL_ROOT; ?>/images/icons/user-icon.png" alt=""> User Info.
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo URL_ROOT; ?>/admin/announcement" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
                            <img class="size-5" src="<?php echo URL_ROOT; ?>/images/icons/announcement-icon.png" alt=""> Announcement
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo URL_ROOT; ?>/admin/litterer" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
                            <img class="size-5" src="<?php echo URL_ROOT; ?>/images/icons/litterer-icon.png" alt=""> Litterers Records
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo URL_ROOT; ?>/admin/redemptions" class="nav-btn flex items-center text-sm gap-3 bg-gray-400 p-2 rounded-lg">
                            <img class="size-5" src="<?php echo URL_ROOT; ?>/images/icons/redeem-icon.png" alt=""> Redemption
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo URL_ROOT; ?>/admin/settings" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
                            <img class="size-5" src="<?php echo URL_ROOT; ?>/images/icons/setting-icon.png" alt=""> Settings
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="mt-auto text-center text-xs text-gray-600">
                <p>Tuesday | 8:00 am</p>
                <p>May 28, 2025</p>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="p-4 md:p-6 flex-1 relative overflow-hidden h-full">

            <div class="flex  mb-6">
                <!-- Toggle Button (Mobile Only) -->
                <button id="toggleSidebar" class="md:hidden bg-green-500 size-8 text-white px-1 rounded-sm shadow-lg">
                    ☰
                </button>

                <!-- Header -->
                <h1 class="text-lg ml-4 md:text-3xl font-bold">Waste Reporting System</h1>
            </div>

            <div class="bg-green-100 shadow-xl rounded-md p-2">
                <h2 class="text-xl font-semibold mb-4">Redemptions</h2>

                <div class="max-h-[calc(92vh-100px)] sm:max-h-[calc(91vh-100px)]max-h-[calc(92vh-100px)] sm:max-h-[calc(91vh-100px)] overflow-auto rounded-md border">
                    <table class="w-full text-sm border-collapse  rounded-md">
                        <thead>
                            <tr class="text-white">
                                <th class="sticky top-0 z-10 bg-green-500 py-2 px-4 text-left">Name</th>
                                <th class="sticky top-0 z-10 bg-green-500 p-2.5 hidden sm:table-cell text-left">Address</th>
                                <th class="sticky top-0 z-10 bg-green-500 p-2.5 hidden md:table-cell text-left">Email Address</th>
                                <th class="sticky top-0 z-10 bg-green-500 p-2.5 hidden lg:table-cell text-left w-[250px]">Date & Time</th>
                                <th class="sticky top-0 z-10 bg-green-500 p-2.5 text-left w-[110px]">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr class="border-b">
                                <td class="text-base py-2 px-4">Jerwin Noval
                                    <dl class="lg:hidden gap-1">
                                        <dt class="sr-only">Address</dt>
                                        <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                                        <dt class="sr-only">Email Address</dt>
                                        <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                                        <dt class="sr-only">Date & Time</dt>
                                        <dd class="lg:hidden mt-1 text-xs text-gray-400">May 28, 2025 12:00:00 AM GMT+8</dd>
                                    </dl>
                                </td>
                                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                                <td class="hidden lg:table-cell p-2.5">May 28, 2025 12:00:00 AM GMT+8</td>
                                <td class=" p-2.5">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded">
                                        Scan
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="text-base py-2 px-4">Jerwin Noval
                                    <dl class="lg:hidden">
                                        <dt class="sr-only">Address</dt>
                                        <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                                        <dt class="sr-only">Email Address</dt>
                                        <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                                        <dt class="sr-only">Date & Time</dt>
                                        <dd class="lg:hidden mt-1 text-xs text-gray-400">May 28, 2025 12:00:00 AM GMT+8</dd>
                                    </dl>
                                </td>
                                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                                <td class="hidden lg:table-cell p-2.5">May 28, 2025 12:00:00 AM GMT+8</td>
                                <td class=" p-2.5">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded">
                                        Scan
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="text-base py-2 px-4">Jerwin Noval
                                    <dl class="lg:hidden">
                                        <dt class="sr-only">Address</dt>
                                        <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                                        <dt class="sr-only">Email Address</dt>
                                        <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                                        <dt class="sr-only">Date & Time</dt>
                                        <dd class="lg:hidden mt-1 text-xs text-gray-400">May 28, 2025 12:00:00 AM GMT+8</dd>
                                    </dl>
                                </td>
                                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                                <td class="hidden lg:table-cell p-2.5">May 28, 2025 12:00:00 AM GMT+8</td>
                                <td class=" p-2.5">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded">
                                        Scan
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="text-base py-2 px-4">Jerwin Noval
                                    <dl class="lg:hidden">
                                        <dt class="sr-only">Address</dt>
                                        <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                                        <dt class="sr-only">Email Address</dt>
                                        <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                                        <dt class="sr-only">Date & Time</dt>
                                        <dd class="lg:hidden mt-1 text-xs text-gray-400">May 28, 2025 12:00:00 AM GMT+8</dd>
                                    </dl>
                                </td>
                                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                                <td class="hidden lg:table-cell p-2.5">May 28, 2025 12:00:00 AM GMT+8</td>
                                <td class=" p-2.5">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded">
                                        Scan
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="text-base py-2 px-4">Jerwin Noval
                                    <dl class="lg:hidden">
                                        <dt class="sr-only">Address</dt>
                                        <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                                        <dt class="sr-only">Email Address</dt>
                                        <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                                        <dt class="sr-only">Date & Time</dt>
                                        <dd class="lg:hidden mt-1 text-xs text-gray-400">May 28, 2025 12:00:00 AM GMT+8</dd>
                                    </dl>
                                </td>
                                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                                <td class="hidden lg:table-cell p-2.5">May 28, 2025 12:00:00 AM GMT+8</td>
                                <td class=" p-2.5">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded">
                                        Scan
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="text-base py-2 px-4">Jerwin Noval
                                    <dl class="lg:hidden">
                                        <dt class="sr-only">Address</dt>
                                        <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                                        <dt class="sr-only">Email Address</dt>
                                        <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                                        <dt class="sr-only">Date & Time</dt>
                                        <dd class="lg:hidden mt-1 text-xs text-gray-400">May 28, 2025 12:00:00 AM GMT+8</dd>
                                    </dl>
                                </td>
                                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                                <td class="hidden lg:table-cell p-2.5">May 28, 2025 12:00:00 AM GMT+8</td>
                                <td class=" p-2.5">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded">
                                        Scan
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="text-base py-2 px-4">Jerwin Noval
                                    <dl class="lg:hidden">
                                        <dt class="sr-only">Address</dt>
                                        <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                                        <dt class="sr-only">Email Address</dt>
                                        <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                                        <dt class="sr-only">Date & Time</dt>
                                        <dd class="lg:hidden mt-1 text-xs text-gray-400">May 28, 2025 12:00:00 AM GMT+8</dd>
                                    </dl>
                                </td>
                                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                                <td class="hidden lg:table-cell p-2.5">May 28, 2025 12:00:00 AM GMT+8</td>
                                <td class=" p-2.5">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded">
                                        Scan
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="text-base py-2 px-4">Jerwin Noval
                                    <dl class="lg:hidden">
                                        <dt class="sr-only">Address</dt>
                                        <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                                        <dt class="sr-only">Email Address</dt>
                                        <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                                        <dt class="sr-only">Date & Time</dt>
                                        <dd class="lg:hidden mt-1 text-xs text-gray-400">May 28, 2025 12:00:00 AM GMT+8</dd>
                                    </dl>
                                </td>
                                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                                <td class="hidden lg:table-cell p-2.5">May 28, 2025 12:00:00 AM GMT+8</td>
                                <td class=" p-2.5">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded">
                                        Scan
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="text-base py-2 px-4">Jerwin Noval
                                    <dl class="lg:hidden">
                                        <dt class="sr-only">Address</dt>
                                        <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                                        <dt class="sr-only">Email Address</dt>
                                        <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                                        <dt class="sr-only">Date & Time</dt>
                                        <dd class="lg:hidden mt-1 text-xs text-gray-400">May 28, 2025 12:00:00 AM GMT+8</dd>
                                    </dl>
                                </td>
                                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                                <td class="hidden lg:table-cell p-2.5">May 28, 2025 12:00:00 AM GMT+8</td>
                                <td class=" p-2.5">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded">
                                        Scan
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="text-base py-2 px-4">Jerwin Noval
                                    <dl class="lg:hidden">
                                        <dt class="sr-only">Address</dt>
                                        <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                                        <dt class="sr-only">Email Address</dt>
                                        <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                                        <dt class="sr-only">Date & Time</dt>
                                        <dd class="lg:hidden mt-1 text-xs text-gray-400">May 28, 2025 12:00:00 AM GMT+8</dd>
                                    </dl>
                                </td>
                                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                                <td class="hidden lg:table-cell p-2.5">May 28, 2025 12:00:00 AM GMT+8</td>
                                <td class=" p-2.5">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded">
                                        Scan
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="text-base py-2 px-4">Jerwin Noval
                                    <dl class="lg:hidden">
                                        <dt class="sr-only">Address</dt>
                                        <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                                        <dt class="sr-only">Email Address</dt>
                                        <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                                        <dt class="sr-only">Date & Time</dt>
                                        <dd class="lg:hidden mt-1 text-xs text-gray-400">May 28, 2025 12:00:00 AM GMT+8</dd>
                                    </dl>
                                </td>
                                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                                <td class="hidden lg:table-cell p-2.5">May 28, 2025 12:00:00 AM GMT+8</td>
                                <td class=" p-2.5">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded">
                                        Scan
                                    </button>
                                </td>
                            </tr>
                            <!-- Add more rows -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Background -->
            <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-40 items-center justify-center z-50 hidden">

                <!-- Modal Container for scan -->
                <div id="wasteModal" class="bg-[#e5f9e0] w-full max-w-sm sm:max-w-md md:max-w-lg rounded-lg shadow-lg relative p-4 sm:p-6  mx-4 hidden">
                    <!-- Close Button -->
                    <button id="wasteClose" class="absolute top-2 right-4 text-2xl font-bold text-gray-700 hover:text-black">&times;</button>

                    <!-- Reporter Info -->
                    <div class="mb-2 border-b-2 border-gray-400 flex justify-center items-center">
                        <p class="text-2xl font-semibold pb-4">QR Code</p>
                    </div>

                    <div class="w-full flex flex-col justify-center items-center mb-4 hidden">
                        <p class="text-lg font-semibold">&#8369; <span class="font-bold">100.00</span></p>
                        <p class="font-semibold">09263547382</p>
                    </div>

                    <div class="flex justify-center items-center w-full mt-2 mb-2">
                        <label class="text-xl pt-1 font-semibold text-gray-700 ">&#8369;</label>
                        <input type="text" value="100.00" class="max-w-16 bg-transparent font-semibold text-gray-700 rounded text-center mt-1 text-xl focus:outline-none" readonly>
                    </div>

                    <!-- QR Image -->
                    <div class=" mb-4 flex h-60 justify-center items-center rounded overflow-hidden">
                        <img src="images/QR Code.jpg" alt="QR Code" class="w-full h-full object-contain ">
                    </div>



                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="text-sm font-semibold text-gray-700">Name</label>
                            <input type="text" value="Jeriwin A. Noval" class="w-full border border-gray-300 rounded p-2 text-center mt-1 text-sm focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-700">Number</label>
                            <input type="text" value="09374652863" class="w-full border border-gray-300 rounded p-2 text-center mt-1 text-sm focus:outline-none" readonly>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-center">
                        <button id="wasteDone" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">Approve</button>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
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

        // Toggle button should not allow the document click handler to immediately close it
        if (toggleBtn) toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleSidebarMenu();
        });

        // Prevent clicks inside the sidebar from bubbling to document (so it won't close)
        if (sidebar) sidebar.addEventListener('click', (e) => {
            e.stopPropagation();
        });

        // Close sidebar when clicking outside it (only when it's currently open)
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


        // Modal wiring for Scan -> open wasteModal
        (function() {
            const overlay = document.getElementById('modalOverlay');
            const wasteModal = document.getElementById('wasteModal');
            const wasteClose = document.getElementById('wasteClose');
            const wasteDone = document.getElementById('wasteDone');

            let activeRow = null;

            function showModal(name) {
                if (!overlay || !wasteModal) return;
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
                wasteModal.classList.remove('hidden');
            }

            function hideModal() {
                if (!overlay || !wasteModal) return;
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
                wasteModal.classList.add('hidden');
                activeRow = null;
            }

            // Delegate Scan clicks
            document.querySelector('main').addEventListener('click', (e) => {
                const btn = e.target.closest('button');
                if (!btn) return;
                if (btn.textContent && btn.textContent.trim() === 'Scan') {
                    const row = btn.closest('tr');
                    activeRow = row || null;
                    const nameCell = row ? row.querySelector('td') : null;
                    const name = nameCell ? nameCell.textContent.trim().split('\n')[0].trim() : 'Reporter';
                    showModal(name);
                }
            });

            // close handlers
            if (wasteClose) wasteClose.addEventListener('click', hideModal);
            if (wasteDone) wasteDone.addEventListener('click', () => {
                if (activeRow && activeRow.parentElement) activeRow.remove();
                hideModal();
            });
            if (overlay) overlay.addEventListener('click', (e) => {
                if (e.target === overlay) hideModal();
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') hideModal();
            });
        })();
    </script>

</body>

</html>