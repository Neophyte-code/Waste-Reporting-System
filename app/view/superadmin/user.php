<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Management — Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-50 text-green-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed md:static top-0 left-0 h-screen w-64 bg-white border-r p-4 
      transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50 flex-shrink-0">

            <div class="flex items-center gap-3 mb-6">
                <!-- Logo container (no SA text anymore) -->
                <div id="sidebarLogo" class="h-12 w-12  flex items-center justify-center overflow-hidden">
                    <!-- Empty, waiting for uploaded logo -->
                </div>
                <div>
                    <div class="font-semibold">Super Admin</div>
                    <div class="text-xs text-green-600">Waste Reporting System</div>
                </div>
            </div>
            <nav class="space-y-1 text-sm">
                <a href="<?php echo URL_ROOT; ?>/superadmin" class="nav-item block px-3 py-2 rounded hover:bg-green-100">🛡️ Admin Management</a>
                <a href="<?php echo URL_ROOT; ?>/superadmin/user" class="nav-item block px-3 py-2 rounded hover:bg-green-100">👥 User Management</a>
                <button id="logoutBtn" class="w-full text-left px-4 py-2 rounded hover:bg-green-100">⏻ Logout</button>
            </nav>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar -->
            <header class="flex items-center justify-between p-4 border-b bg-white">
                <div class="flex items-center gap-3">
                    <!-- Toggle Button -->
                    <button id="toggleSidebar" class="md:hidden px-3 py-2 rounded bg-green-100 hover:bg-green-200">
                        ☰
                    </button>
                    <h1 class="text-lg font-semibold">User Management</h1>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Real-time clock -->
                    <span id="clock" class="font-mono text-sm text-green-700"></span>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6">
                <div class="bg-white p-4 rounded-lg shadow-md border border-green-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-green-700">Registered Users</h3>
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Search user..."
                            class="p-2 text-sm border rounded outline-none focus:ring-1 focus:ring-green-400">
                    </div>

                    <div class="overflow-x-auto">
                        <div class="max-h-[68vh] overflow-y-auto">
                            <table class="w-full text-sm border-collapse">
                                <thead class="sticky top-0 bg-green-100 text-green-800 z-10">
                                    <tr>
                                        <th class="p-3 border-b text-left">Name</th>
                                        <th class="p-3 border-b text-left">Email</th>
                                        <th class="p-3 border-b text-left">Barangay</th>
                                        <th class="p-3 border-b text-left">Points</th>
                                        <th class="p-3 border-b text-left">Status</th>
                                        <th class="p-3 border-b text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="userTable">
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Juan Dela Cruz</td>
                                        <td class="p-3 border-b">juan@example.com</td>
                                        <td class="p-3 border-b">Tapilon</td>
                                        <td class="p-3 border-b">120</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100">Ban</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Maria Lopez</td>
                                        <td class="p-3 border-b">maria@example.com</td>
                                        <td class="p-3 border-b">Maya</td>
                                        <td class="p-3 border-b">85</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100">Verify</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Juan Dela Cruz</td>
                                        <td class="p-3 border-b">juan@example.com</td>
                                        <td class="p-3 border-b">Tapilon</td>
                                        <td class="p-3 border-b">120</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100">Ban</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Maria Lopez</td>
                                        <td class="p-3 border-b">maria@example.com</td>
                                        <td class="p-3 border-b">Maya</td>
                                        <td class="p-3 border-b">85</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100">Verify</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Juan Dela Cruz</td>
                                        <td class="p-3 border-b">juan@example.com</td>
                                        <td class="p-3 border-b">Tapilon</td>
                                        <td class="p-3 border-b">120</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100">Ban</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Maria Lopez</td>
                                        <td class="p-3 border-b">maria@example.com</td>
                                        <td class="p-3 border-b">Maya</td>
                                        <td class="p-3 border-b">85</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100">Verify</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Juan Dela Cruz</td>
                                        <td class="p-3 border-b">juan@example.com</td>
                                        <td class="p-3 border-b">Tapilon</td>
                                        <td class="p-3 border-b">120</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100">Ban</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Maria Lopez</td>
                                        <td class="p-3 border-b">maria@example.com</td>
                                        <td class="p-3 border-b">Maya</td>
                                        <td class="p-3 border-b">85</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100">Verify</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Juan Dela Cruz</td>
                                        <td class="p-3 border-b">juan@example.com</td>
                                        <td class="p-3 border-b">Tapilon</td>
                                        <td class="p-3 border-b">120</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100">Ban</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Maria Lopez</td>
                                        <td class="p-3 border-b">maria@example.com</td>
                                        <td class="p-3 border-b">Maya</td>
                                        <td class="p-3 border-b">85</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100">Verify</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-80">
            <h2 class="text-lg font-semibold text-green-700 mb-3">Confirm Logout</h2>
            <p class="text-sm text-gray-600 mb-5">Are you sure you want to logout?</p>
            <div class="flex justify-end gap-3">
                <button id="cancelLogout" class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200">Cancel</button>
                <a href="logout.html" class="px-3 py-1 rounded bg-red-500 hover:bg-red-600 text-white">Logout</a>
            </div>
        </div>
    </div>

    <!-- <script>
        // Real-time clock
        function updateClock() {
            const clock = document.getElementById("clock");
            const now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();
            const ampm = hours >= 12 ? "PM" : "AM";

            hours = hours % 12 || 12;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            clock.textContent = $ {
                hours
            }: $ {
                minutes
            }: $ {
                seconds
            }
            $ {
                ampm
            };
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Toggle Sidebar
        const toggleSidebar = document.getElementById("toggleSidebar");
        const sidebar = document.getElementById("sidebar");

        toggleSidebar.addEventListener("click", () => {
            if (sidebar.classList.contains("-translate-x-full")) {
                sidebar.classList.remove("-translate-x-full");
                sidebar.classList.add("translate-x-0");
            } else {
                sidebar.classList.add("-translate-x-full");
                sidebar.classList.remove("translate-x-0");
            }
        });

        // Search filter
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#userTable tr");

            rows.forEach(row => {
                let name = row.cells[0].textContent.toLowerCase();
                let email = row.cells[1].textContent.toLowerCase();
                let barangay = row.cells[2].textContent.toLowerCase();

                row.style.display = (name.includes(filter) || email.includes(filter) || barangay.includes(filter)) ? "" : "none";
            });
        });



        // Ban / Verify button functionality
        document.querySelectorAll("#userTable .toggleBtn").forEach(button => {
            button.addEventListener("click", function() {
                const row = this.closest("tr");
                const statusCell = row.querySelector(".status");

                if (this.textContent === "Ban") {
                    statusCell.textContent = "Banned";
                    statusCell.className = "status px-2 py-1 text-xs rounded-full bg-red-100 text-red-700";
                    this.textContent = "Unban";
                    this.className = "toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100";
                } else if (this.textContent === "Unban") {
                    statusCell.textContent = "Active";
                    statusCell.className = "status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700";
                    this.textContent = "Ban";
                    this.className = "toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100";
                } else if (this.textContent === "Verify") {
                    statusCell.textContent = "Active";
                    statusCell.className = "status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700";
                    this.textContent = "Ban";
                    this.className = "toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100";
                }
            });
        });

        // Logout modal logic
        const logoutBtn = document.getElementById("logoutBtn");
        const logoutModal = document.getElementById("logoutModal");
        const cancelLogout = document.getElementById("cancelLogout");
        const confirmLogout = document.getElementById("confirmLogout");

        logoutBtn.addEventListener("click", () => {
            logoutModal.classList.remove("hidden");
        });

        cancelLogout.addEventListener("click", () => {
            logoutModal.classList.add("hidden");
        });

        confirmLogout.addEventListener("click", () => {
            // Redirect to login page or perform logout action
            window.location.href = "login.html";
        });
    </script> -->
</body>

</html>