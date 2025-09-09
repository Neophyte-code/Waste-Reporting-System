<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Admin - Redemptions</title>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/output.css">
</head>
<style>
    .flash-message {
        position: fixed;
        top: 5px;
        right: 5px;
        color: white;
        padding: 16px 24px;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: bold;
        text-align: center;
        opacity: 1;
        transition: opacity 0.8s ease, transform 0.8s ease;
        z-index: 9999;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .flash-message.flash-success {
        background: #22C55E;
    }

    .flash-message.flash-failed {
        background: #EF4444;
    }

    .flash-message.flash-hide {
        opacity: 0;
        transform: translateX(10px);
    }
</style>
<!-- Display flash message -->
<?php if (!empty($data['message'])): ?>
    <div id="flash-message" class="flash-message flash-<?= htmlspecialchars($data['messageType'] ?? 'success') ?>">
        <?= htmlspecialchars($data['message']); ?>
    </div>
<?php endif; ?>

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

            <!-- time and date -->
            <div class="mt-auto text-center text-xs text-gray-600">
                <p id="sidebar-time"></p>
                <p id="sidebar-date"></p>
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
                                <th class="sticky top-0 z-10 bg-green-500 p-2.5 hidden md:table-cell text-left">Email Address</th>
                                <th class="sticky top-0 z-10 bg-green-500 p-2.5 hidden lg:table-cell text-left w-[250px]">Date & Time</th>
                                <th class="sticky top-0 z-10 bg-green-500 p-2.5 text-left w-[110px]">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <?php if (empty($data['redemption'])): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500">
                                        No Waste Reports Found
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($data['redemption'] as $redemption): ?>
                                    <tr class="border-b">
                                        <td class="text-base py-2 px-4"><?= htmlspecialchars($redemption['firstname'] . ' ' . $redemption['lastname']) ?>
                                            <dl class="lg:hidden gap-1">
                                                <dt class="sr-only">Email Address</dt>
                                                <dd class="md:hidden text-sm text-gray-500"><?= htmlspecialchars($redemption['email']) ?></dd>
                                                <dt class="sr-only">Date & Time</dt>
                                                <dd class="lg:hidden mt-1 text-xs text-gray-400"><?= htmlspecialchars($redemption['request_date']) ?></dd>
                                            </dl>
                                        </td>
                                        <td class="hidden md:table-cell p-2.5 text-blue-600"><?= htmlspecialchars($redemption['email']) ?></td>
                                        <td class="hidden lg:table-cell p-2.5"><?= htmlspecialchars($redemption['request_date']) ?></td>
                                        <td class=" p-2.5">
                                            <button
                                                class="scan-btn bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded"
                                                data-id="<?= $redemption['id'] ?>"
                                                data-fullname="<?= htmlspecialchars($redemption['firstname'] . ' ' . $redemption['lastname']) ?>"
                                                data-email="<?= htmlspecialchars($redemption['email']) ?>"
                                                data-amount="<?= htmlspecialchars($redemption['points_amount']) ?>"
                                                data-gcash="<?= htmlspecialchars($redemption['gcash_number']) ?>"
                                                data-gcash-name="<?= htmlspecialchars($redemption['gcash_name']) ?>"
                                                data-qr="<?= htmlspecialchars($redemption['qr_code_path']) ?>">
                                                Scan
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Background -->
            <div id="modalOverlay" class="fixed inset-0 bg-opacity-40 flex items-center justify-center z-50 hidden">

                <!-- Modal Container for scan -->
                <div id="scanModal" class="bg-[#e5f9e0] w-full max-w-sm sm:max-w-md md:max-w-lg rounded-lg shadow-lg relative p-4 sm:p-6  mx-4 hidden">
                    <!-- Close Button -->
                    <button id="wasteClose" class="absolute top-2 right-4 text-2xl font-bold text-gray-700 hover:text-black">&times;</button>

                    <!-- scan Info -->
                    <div class="mb-2 border-b-2 border-gray-400 flex justify-center items-center">
                        <p class="text-2xl font-semibold pb-4">QR Code</p>
                    </div>

                    <!-- Fullname & Email -->
                    <div class="mb-4 text-center">
                        <p id="modalFullname" class="text-lg font-semibold text-gray-800"></p>
                        <p id="modalEmail" class="text-sm text-gray-600"></p>
                    </div>

                    <!-- Amount -->
                    <div class="flex justify-center items-center w-full mt-2 mb-2">
                        <label class="text-xl pt-1 font-semibold text-gray-700">&#8369;</label>
                        <input id="modalAmount" type="text" class="max-w-16 bg-transparent font-semibold text-gray-700 rounded text-center mt-1 text-xl focus:outline-none" readonly>
                    </div>

                    <!-- QR Image -->
                    <div class="mb-4 flex h-60 justify-center items-center rounded overflow-hidden">
                        <img id="modalQr" src="" alt="QR Code" class="w-full h-full object-contain">
                    </div>

                    <!-- GCash Info -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="text-sm font-semibold text-gray-700">Name</label>
                            <input id="modalGcashName" type="text" class="w-full border border-gray-300 rounded p-2 text-center mt-1 text-sm focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-700">Number</label>
                            <input id="modalGcashNumber" type="text" class="w-full border border-gray-300 rounded p-2 text-center mt-1 text-sm focus:outline-none" readonly>
                        </div>
                    </div>


                    <form id="approveForm" action="<?= URL_ROOT ?>/admin/approveRedemption" method="POST">
                        <input type="hidden" name="id" id="modalRedemptionId">
                        <div class="flex justify-center">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">
                                Approve
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- for responsive navbar -->
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

        // time and date
        function updateDateTime() {
            const timeElement = document.getElementById("sidebar-time");
            const dateElement = document.getElementById("sidebar-date");

            const now = new Date();

            // Format options
            const optionsTime = {
                weekday: "long",
                hour: "numeric",
                minute: "numeric",
                hour12: true
            };
            const optionsDate = {
                year: "numeric",
                month: "long",
                day: "numeric"
            };

            // Update content
            timeElement.textContent = now.toLocaleTimeString("en-US", optionsTime);
            dateElement.textContent = now.toLocaleDateString("en-US", optionsDate);
        }

        // Run once immediately
        updateDateTime();

        // Update every 30 seconds
        setInterval(updateDateTime, 30000);
    </script>
    <!-- for redemptions modal functionality -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const scanButtons = document.querySelectorAll(".scan-btn");
            const modalOverlay = document.getElementById("modalOverlay");
            const scanModal = document.getElementById("scanModal");
            const closeModal = document.getElementById("wasteClose");

            // Fields inside modal
            const amountInput = document.getElementById("modalAmount");
            const qrImage = document.getElementById("modalQr");
            const gcashNameInput = document.getElementById("modalGcashName");
            const gcashNumberInput = document.getElementById("modalGcashNumber");
            const fullnameText = document.getElementById("modalFullname");
            const emailText = document.getElementById("modalEmail");

            // Hidden input for approve form
            const redemptionIdInput = document.getElementById("modalRedemptionId");

            // Base URL
            const baseURL = "<?= URL_ROOT ?>/";

            // Show modal with data
            scanButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");
                    const fullname = this.getAttribute("data-fullname");
                    const email = this.getAttribute("data-email");
                    const amount = this.getAttribute("data-amount");
                    const qr = this.getAttribute("data-qr");
                    const gcashName = this.getAttribute("data-gcash-name");
                    const gcashNumber = this.getAttribute("data-gcash");

                    // Update modal fields
                    fullnameText.textContent = fullname;
                    emailText.textContent = email;
                    amountInput.value = amount;
                    qrImage.src = baseURL + qr;
                    gcashNameInput.value = gcashName;
                    gcashNumberInput.value = gcashNumber;

                    // Set redemption ID into form hidden input
                    redemptionIdInput.value = id;

                    // Show modal
                    modalOverlay.classList.remove("hidden");
                    scanModal.classList.remove("hidden");
                });
            });

            // Close modal (X button)
            closeModal.addEventListener("click", function() {
                modalOverlay.classList.add("hidden");
                scanModal.classList.add("hidden");
            });

            // Close when clicking outside modal
            modalOverlay.addEventListener("click", function(e) {
                if (e.target === modalOverlay) {
                    modalOverlay.classList.add("hidden");
                    scanModal.classList.add("hidden");
                }
            });
        });

        //flash message
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            setTimeout(() => {
                flashMessage.classList.add('flash-hide');
                setTimeout(() => flashMessage.remove(), 800);
            }, 3000);
        }
    </script>

</body>

</html>