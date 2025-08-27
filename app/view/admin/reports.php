<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Admin View Reports</title>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/output.css">
    <!-- Local Leaflet CSS -->
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/js/leaflet/leaflet.css" />
</head>
<style>
    #map {
        width: 100%;
        height: 400px;
    }

    /* Custom styles for map containers */
    .map-container {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    /* Ensure map containers have proper dimensions even when hidden */
    #wasteMap,
    #littererMap {
        height: 100%;
        width: 100%;
    }
</style>

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
                        <a href="<?php echo URL_ROOT; ?>/admin/reports" class="nav-btn flex items-center text-sm gap-3 bg-gray-400 p-2 rounded-lg">
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
                        <a href="<?php echo URL_ROOT; ?>/admin/redemptions" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
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
                <h2 class="text-xl font-semibold mb-4">View Reports</h2>

                <div class="max-h-[calc(92vh-100px)] sm:max-h-[calc(91vh-100px)]max-h-[calc(92vh-100px)] sm:max-h-[calc(91vh-100px)] overflow-auto rounded-md border">
                    <!-- table -->
                    <table class="w-full text-sm border-collapse  rounded-md">
                        <thead>
                            <tr class="text-white">
                                <th class="sticky top-0 z-10 bg-green-500 py-2 px-4 text-left">Name</th>
                                <th class="sticky top-0 z-10 bg-green-500 p-2.5 hidden md:table-cell text-left">Email Address</th>
                                <th class="sticky top-0 z-10 bg-green-500 p-2.5 hidden md:table-cell text-left">Report Type</th>
                                <th class="sticky top-0 z-10 bg-green-500 p-2.5 hidden lg:table-cell text-left w-[250px]">Date & Time</th>
                                <th class="sticky top-0 z-10 bg-green-500 p-2.5 text-left w-[110px]">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <?php if (empty($data['reports'])): ?>
                                <p class="text-center">No Waste Reports Found</p>
                            <?php else: ?>
                                <?php foreach ($data['reports'] as $report): ?>

                                    <tr class="border-b">
                                        <td class="text-base py-2 px-4"><?= htmlspecialchars($report['firstname'] . ' ' . $report['lastname']) ?>
                                            <dl class="lg:hidden">
                                                <dt class="sr-only">Email Address</dt>
                                                <dd class="md:hidden text-sm text-gray-500"><?= htmlspecialchars($report['email']) ?></dd>
                                                <dt class="sr-only">Report Type</dt>
                                                <dd class="md:hidden text-sm text-gray-500"><?= htmlspecialchars($report['report_type']) ?></dd>
                                                <dt class="sr-only">Date & Time</dt>
                                                <dd class="lg:hidden mt-1 text-xs text-gray-400"><?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($report['report_date']))); ?></dd>
                                            </dl>
                                        </td>
                                        <td class="hidden md:table-cell p-2.5"><?= htmlspecialchars($report['email']) ?></td>
                                        <td class="hidden md:table-cell p-2.5"><?= htmlspecialchars($report['report_type']) ?></td>
                                        <td class="hidden lg:table-cell p-2.5"><?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($report['report_date']))); ?></td>
                                        <td class=" p-2.5">
                                            <button
                                                class="verify-btn bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded"
                                                data-id="<?= $report['id'] ?>"
                                                data-type="<?= $report['report_type'] ?>"
                                                data-name="<?= htmlspecialchars($report['firstname'] . ' ' . $report['lastname']) ?>"
                                                data-email="<?= htmlspecialchars($report['email']) ?>"
                                                data-img="<?= htmlspecialchars($report['image_path']) ?>"
                                                data-details="<?= htmlspecialchars($report['details']) ?>"
                                                data-weight="<?= htmlspecialchars($report['estimated_weight'] ?? '') ?>"
                                                data-suspect="<?= htmlspecialchars($report['name'] ?? '') ?>"
                                                data-age="<?= htmlspecialchars($report['age'] ?? '') ?>"
                                                data-gender="<?= htmlspecialchars($report['gender'] ?? '') ?>"
                                                data-features="<?= htmlspecialchars($report['features'] ?? '') ?>"
                                                data-lat="<?= htmlspecialchars($report['latitude'] ?? '') ?>"
                                                data-lng="<?= htmlspecialchars($report['longitude'] ?? '') ?>">
                                                Verify
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>

    <!-- Modal Background -->
    <div id="modalOverlay" class="fixed inset-0 bg-white-200 flex items-center justify-center z-50 hidden">
        <!-- Waste Report Modal -->
        <div id="wasteModal" class="bg-[#e5f9e0] w-full max-w-sm sm:max-w-lg md:max-w-2xl rounded-lg shadow-lg relative p-4 sm:p-6 hidden mx-4">
            <button onclick="closeModal()" class="absolute top-2 right-4 text-2xl font-bold text-gray-700 hover:text-black">&times;</button>

            <!-- waste report reporter name -->
            <div class="mb-4">
                <p class="text-sm text-gray-700 font-semibold">Reporter</p>
                <p class="text-lg font-bold" id="wasteReporterName"></p>
                <p class="text-sm text-gray-600" id="wasteReporterEmail"></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div class="border border-gray-300 rounded overflow-hidden">
                        <img id="wasteImage" src="" alt="Report Image" class="w-full h-40 object-cover">
                    </div>
                    <!-- map -->
                    <div class="border border-green-400 rounded overflow-hidden">
                        <div class="map-container h-20">
                            <!-- Map container for waste reports -->
                            <div id="wasteMap"></div>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Estimated Weight</label>
                        <input type="text" id="wasteWeight" class="w-full border border-gray-300 rounded p-2 text-sm" readonly>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Description</label>
                        <textarea id="wasteDescription" class="w-full border border-gray-300 rounded p-2 text-sm h-16" readonly></textarea>
                    </div>
                </div>
            </div>

            <!-- waste report buttons -->
            <div class="flex justify-center gap-4">
                <button onclick="approveReport('waste')" class="bg-green-500 hover:bg-green-600 text-white px-8 py-2 rounded">Approve</button>
                <button onclick="rejectReport('waste')" class="bg-red-500 hover:bg-red-600 text-white px-8 py-2 rounded">Reject</button>
            </div>
        </div>

        <!-- Litterer Report Modal -->
        <div id="littererModal" class="bg-[#e5f9e0] w-full max-w-sm sm:max-w-lg md:max-w-2xl rounded-lg shadow-lg relative p-4 sm:p-6 hidden mx-4">
            <button onclick="closeModal()" class="absolute top-2 right-4 text-2xl font-bold text-gray-700 hover:text-black">&times;</button>

            <!-- litterer report reporter name -->
            <div class="mb-4">
                <p class="text-sm text-gray-700 font-semibold">Reporter</p>
                <p class="text-lg font-bold" id="littererReporterName"></p>
                <p class="text-sm text-gray-600" id="littererReporterEmail"></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div class="border border-gray-300 rounded overflow-hidden">
                        <img id="littererImage" src="" alt="Report Image" class="w-full h-40 object-cover">
                    </div>
                    <!-- map -->
                    <div class="border border-green-400 rounded overflow-hidden">
                        <div class="map-container">
                            <!-- Map container for litterer reports -->
                            <div id="littererMap"></div>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Suspect Name</label>
                        <input type="text" id="littererName" class="w-full border border-gray-300 rounded p-2 text-sm" readonly>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm font-semibold text-gray-700">Age</label>
                            <input type="text" id="littererAge" class="w-full border border-gray-300 rounded p-2 text-sm" readonly>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-700">Gender</label>
                            <input type="text" id="littererGender" class="w-full border border-gray-300 rounded p-2 text-sm" readonly>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Distinguishing Features</label>
                        <textarea id="littererFeatures" class="w-full border border-gray-300 rounded p-2 text-sm h-16" readonly></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-center gap-4">
                <button onclick="approveReport('litterer')" class="bg-green-500 hover:bg-green-600 text-white px-8 py-2 rounded">Approve</button>
                <button onclick="rejectReport('litterer')" class="bg-red-500 hover:bg-red-600 text-white px-8 py-2 rounded">Reject</button>
            </div>
        </div>
    </div>
    </main>
    </div>

    <script src="<?php echo URL_ROOT; ?>/js/leaflet/leaflet.js"></script>
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
    </script>

    <!-- for verifying and map initialization script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modalOverlay = document.getElementById('modalOverlay');
            const wasteModal = document.getElementById('wasteModal');
            const littererModal = document.getElementById('littererModal');
            let wasteMap = null;
            let littererMap = null;
            let currentReportId = null;
            let currentReportType = null;

            document.querySelectorAll('.verify-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const type = button.dataset.type;
                    const latitude = parseFloat(button.dataset.lat);
                    const longitude = parseFloat(button.dataset.lng);
                    currentReportId = button.dataset.id;
                    currentReportType = type;

                    modalOverlay.classList.remove('hidden');

                    const baseURL = "<?= URL_ROOT ?>/";

                    if (type === 'waste') {
                        wasteModal.classList.remove('hidden');
                        littererModal.classList.add('hidden');

                        // Fill Waste Modal
                        document.getElementById('wasteReporterName').textContent = button.dataset.name;
                        document.getElementById('wasteReporterEmail').textContent = button.dataset.email;
                        document.getElementById('wasteImage').src = baseURL + button.dataset.img;
                        document.getElementById('wasteWeight').value = button.dataset.weight || 'N/A';
                        document.getElementById('wasteDescription').value = button.dataset.details || 'N/A';

                        // Initialize waste map after a small delay to ensure modal is visible
                        setTimeout(() => {
                            initializeMap('waste', latitude, longitude);
                        }, 300);
                    }

                    if (type === 'litterer') {
                        littererModal.classList.remove('hidden');
                        wasteModal.classList.add('hidden');

                        // Fill Litterer Modal
                        document.getElementById('littererReporterName').textContent = button.dataset.name;
                        document.getElementById('littererReporterEmail').textContent = button.dataset.email;
                        document.getElementById('littererImage').src = baseURL + button.dataset.img;
                        document.getElementById('littererName').value = button.dataset.suspect || 'Unknown';
                        document.getElementById('littererAge').value = button.dataset.age || 'N/A';
                        document.getElementById('littererGender').value = button.dataset.gender || 'N/A';
                        document.getElementById('littererFeatures').value = button.dataset.features || 'N/A';

                        // Initialize litterer map after a small delay to ensure modal is visible
                        setTimeout(() => {
                            initializeMap('litterer', latitude, longitude);
                        }, 300);
                    }
                });
            });

            function initializeMap(reportType, lat, lng) {
                // Check if coordinates are valid
                if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
                    document.getElementById(reportType + 'Map').innerHTML = '<div class="flex items-center justify-center h-full bg-gray-200 text-gray-600">Location not available</div>';
                    return;
                }

                // Remove existing map if it exists
                if (reportType === 'waste' && wasteMap) {
                    wasteMap.remove();
                    wasteMap = null;
                } else if (reportType === 'litterer' && littererMap) {
                    littererMap.remove();
                    littererMap = null;
                }

                // Initialize new map
                const mapId = reportType + 'Map';
                const map = L.map(mapId, {
                    zoomControl: true,
                    scrollWheelZoom: true,
                    doubleClickZoom: true,
                    dragging: true,
                    touchZoom: true,
                    boxZoom: true,
                    keyboard: true
                }).setView([lat, lng], 16);

                // Store reference to the correct map
                if (reportType === 'waste') {
                    wasteMap = map;
                } else {
                    littererMap = map;
                }

                // Add tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);

                // Create custom marker icon based on report type
                let markerIcon;
                if (reportType === 'waste') {
                    markerIcon = L.divIcon({
                        html: '<div style="background-color: #ef4444; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
                        iconSize: [20, 20],
                        iconAnchor: [10, 10],
                        className: 'custom-marker'
                    });
                } else {
                    markerIcon = L.divIcon({
                        html: '<div style="background-color: #f97316; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
                        iconSize: [20, 20],
                        iconAnchor: [10, 10],
                        className: 'custom-marker'
                    });
                }

                // Add marker
                L.marker([lat, lng], {
                        icon: markerIcon
                    })
                    .addTo(map)
                    .bindPopup(`${reportType === 'waste' ? 'Waste' : 'Litterer'} Report Location`);

                // Force map to resize properly after it's visible
                setTimeout(() => {
                    map.invalidateSize();
                }, 100);
            }

            // Close modal function
            window.closeModal = function() {
                document.getElementById('modalOverlay').classList.add('hidden');
                document.getElementById('wasteModal').classList.add('hidden');
                document.getElementById('littererModal').classList.add('hidden');

                // Clean up maps
                if (wasteMap) {
                    wasteMap.remove();
                    wasteMap = null;
                }
                if (littererMap) {
                    littererMap.remove();
                    littererMap = null;
                }

                currentReportId = null;
                currentReportType = null;
            }

            // Approve and reject functions
            window.approveReport = function(type) {
                if (!currentReportId) return;

                if (!confirm(`Are you sure you want to approve this ${type} report?`)) {
                    return;
                }

                // Show loading state
                const approveBtn = document.querySelector(`#${type}Modal button:first-child`);
                const originalText = approveBtn.textContent;
                approveBtn.textContent = 'Processing...';
                approveBtn.disabled = true;

                // Send AJAX request to approve the report
                fetch('<?= URL_ROOT ?>/admin/approveReport/' + currentReportId, {
                        method: 'POST',
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            showNotification('Report approved successfully! The user has been notified.', 'success');

                            // Remove the approved report from the table
                            const row = document.querySelector(`.verify-btn[data-id="${currentReportId}"]`).closest('tr');
                            if (row) {
                                row.remove();
                            }

                            // Check if table is empty after removal
                            if (document.querySelectorAll('tbody tr').length === 0) {
                                document.querySelector('tbody').innerHTML = '<tr><td colspan="5" class="text-center py-4">No pending reports</td></tr>';
                            }
                        } else {
                            showNotification('Error: ' + data.message, 'error');
                        }
                        closeModal();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Error approving report', 'error');
                        closeModal();
                    })
                    .finally(() => {
                        // Reset button state
                        approveBtn.textContent = originalText;
                        approveBtn.disabled = false;
                    });
            }

            window.rejectReport = function(type) {
                if (!currentReportId) return;

                if (!confirm(`Are you sure you want to reject this ${type} report?`)) {
                    return;
                }

                // Show loading state
                const rejectBtn = document.querySelector(`#${type}Modal button:last-child`);
                const originalText = rejectBtn.textContent;
                rejectBtn.textContent = 'Processing...';
                rejectBtn.disabled = true;

                // Send AJAX request to reject the report
                fetch('<?= URL_ROOT ?>/admin/rejectReport/' + currentReportId, {
                        method: 'POST',
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            showNotification('Report rejected successfully! The user has been notified.', 'success');

                            // Remove the rejected report from the table
                            const row = document.querySelector(`.verify-btn[data-id="${currentReportId}"]`).closest('tr');
                            if (row) {
                                row.remove();
                            }

                            // Check if table is empty after removal
                            if (document.querySelectorAll('tbody tr').length === 0) {
                                document.querySelector('tbody').innerHTML = '<tr><td colspan="5" class="text-center py-4">No pending reports</td></tr>';
                            }
                        } else {
                            showNotification('Error: ' + data.message, 'error');
                        }
                        closeModal();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Error rejecting report', 'error');
                        closeModal();
                    })
                    .finally(() => {
                        // Reset button state
                        rejectBtn.textContent = originalText;
                        rejectBtn.disabled = false;
                    });
            }

            // Add this helper function for notifications
            function showNotification(message, type = 'info') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 m-5 z-50 px-4 py-3 rounded shadow-lg text-white ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            }`;
                notification.textContent = message;

                // Add to page
                document.body.appendChild(notification);

                // Remove after 3 seconds
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        });
    </script>
</body>

</html>