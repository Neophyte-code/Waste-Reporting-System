<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Management — Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-50 text-green-900 overflow-hidden">
    <div class="min-h-screen flex ">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed md:static top-0 left-0 h-screen w-64 bg-white border-r p-4 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50 flex-shrink-0">
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
                    <h1 class="text-lg font-semibold">Admin Management</h1>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Real-time clock -->
                    <span id="clock" class="font-mono text-sm text-green-700"></span>
                </div>
            </header>


            <!-- Content -->
            <main class="p-6 overflow-hidden">
                <div class="bg-white p-4 rounded-lg shadow-md border border-green-100 ">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-green-700">Admin Accounts</h3>
                        <div class="flex items-center gap-3">
                            <!-- Search -->
                            <input
                                type="text"
                                id="searchInput"
                                placeholder="Search admin..."
                                class="p-2 text-sm border rounded outline-none focus:outline-none">
                            <!-- Add Admin Button -->
                            <button id="addAdminBtn" class="px-3 py-2 rounded bg-green-600 hover:bg-green-700 text-white text-sm">
                                + Add Admin
                            </button>
                        </div>
                    </div>

                    <div class="overflow-hidden">
                        <div class="max-h-[68vh] overflow-auto">
                            <table class="w-full text-sm border-collapse">
                                <thead class="sticky top-0 bg-green-100 text-green-800 z-10">
                                    <tr>
                                        <th class="p-3 border-b text-left">Name</th>
                                        <th class="p-3 border-b text-left">Password</th>
                                        <th class="p-3 border-b text-left">Email</th>
                                        <th class="p-3 border-b text-left">Barangay</th>
                                        <th class="p-3 border-b text-left">Status</th>
                                        <th class="p-3 border-b text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="adminTable">
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Alicia Ramos</td>
                                        <td class="p-3 border-b" data-password="123456">••••••</td>
                                        <td class="p-3 border-b">alicia@city.gov</td>
                                        <td class="p-3 border-b">Tapilon</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100 ml-2">Deactivate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Miguel Santos</td>
                                        <td class="p-3 border-b" data-password="mypassword">••••••</td>
                                        <td class="p-3 border-b">miguel@city.gov</td>
                                        <td class="p-3 border-b">Maya</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">Inactive</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100 ml-2">Activate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Alicia Ramos</td>
                                        <td class="p-3 border-b" data-password="123456">••••••</td>
                                        <td class="p-3 border-b">alicia@city.gov</td>
                                        <td class="p-3 border-b">Tapilon</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100 ml-2">Deactivate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Miguel Santos</td>
                                        <td class="p-3 border-b" data-password="mypassword">••••••</td>
                                        <td class="p-3 border-b">miguel@city.gov</td>
                                        <td class="p-3 border-b">Maya</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">Inactive</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100 ml-2">Activate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Alicia Ramos</td>
                                        <td class="p-3 border-b" data-password="123456">••••••</td>
                                        <td class="p-3 border-b">alicia@city.gov</td>
                                        <td class="p-3 border-b">Tapilon</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100 ml-2">Deactivate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Miguel Santos</td>
                                        <td class="p-3 border-b" data-password="mypassword">••••••</td>
                                        <td class="p-3 border-b">miguel@city.gov</td>
                                        <td class="p-3 border-b">Maya</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">Inactive</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100 ml-2">Activate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Alicia Ramos</td>
                                        <td class="p-3 border-b" data-password="123456">••••••</td>
                                        <td class="p-3 border-b">alicia@city.gov</td>
                                        <td class="p-3 border-b">Tapilon</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100 ml-2">Deactivate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Miguel Santos</td>
                                        <td class="p-3 border-b" data-password="mypassword">••••••</td>
                                        <td class="p-3 border-b">miguel@city.gov</td>
                                        <td class="p-3 border-b">Maya</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">Inactive</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100 ml-2">Activate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Alicia Ramos</td>
                                        <td class="p-3 border-b" data-password="123456">••••••</td>
                                        <td class="p-3 border-b">alicia@city.gov</td>
                                        <td class="p-3 border-b">Tapilon</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100 ml-2">Deactivate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Miguel Santos</td>
                                        <td class="p-3 border-b" data-password="mypassword">••••••</td>
                                        <td class="p-3 border-b">miguel@city.gov</td>
                                        <td class="p-3 border-b">Maya</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">Inactive</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100 ml-2">Activate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Alicia Ramos</td>
                                        <td class="p-3 border-b" data-password="123456">••••••</td>
                                        <td class="p-3 border-b">alicia@city.gov</td>
                                        <td class="p-3 border-b">Tapilon</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100 ml-2">Deactivate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Miguel Santos</td>
                                        <td class="p-3 border-b" data-password="mypassword">••••••</td>
                                        <td class="p-3 border-b">miguel@city.gov</td>
                                        <td class="p-3 border-b">Maya</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">Inactive</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100 ml-2">Activate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Alicia Ramos</td>
                                        <td class="p-3 border-b" data-password="123456">••••••</td>
                                        <td class="p-3 border-b">alicia@city.gov</td>
                                        <td class="p-3 border-b">Tapilon</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100 ml-2">Deactivate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Miguel Santos</td>
                                        <td class="p-3 border-b" data-password="mypassword">••••••</td>
                                        <td class="p-3 border-b">miguel@city.gov</td>
                                        <td class="p-3 border-b">Maya</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">Inactive</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100 ml-2">Activate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Alicia Ramos</td>
                                        <td class="p-3 border-b" data-password="123456">••••••</td>
                                        <td class="p-3 border-b">alicia@city.gov</td>
                                        <td class="p-3 border-b">Tapilon</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Active</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100 ml-2">Deactivate</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-green-50">
                                        <td class="p-3 border-b">Miguel Santos</td>
                                        <td class="p-3 border-b" data-password="mypassword">••••••</td>
                                        <td class="p-3 border-b">miguel@city.gov</td>
                                        <td class="p-3 border-b">Maya</td>
                                        <td class="p-3 border-b">
                                            <span class="status px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">Inactive</span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
                                            <button class="toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100 ml-2">Activate</button>
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

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold text-green-800 mb-4">Edit Admin</h2>
            <form id="editForm" class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-green-700">Name</label>
                    <input type="text" id="editName" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Password</label>
                    <input type="text" id="editPassword" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Email</label>
                    <input type="email" id="editEmail" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Barangay</label>
                    <input type="text" id="editBarangay" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" id="cancelEdit" class="px-4 py-2 rounded bg-slate-100 hover:bg-slate-200 text-sm">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white text-sm">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold text-green-800 mb-4">Add Admin</h2>
            <form id="addForm" class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-green-700">Name</label>
                    <input type="text" id="addName" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Password</label>
                    <input type="text" id="addPassword" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Email</label>
                    <input type="email" id="addEmail" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Barangay</label>
                    <input type="text" id="addBarangay" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" id="cancelAdd" class="px-4 py-2 rounded bg-slate-100 hover:bg-slate-200 text-sm">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white text-sm">Add</button>
                </div>
            </form>
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



    <script>
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

        function updateClock() {
            const clock = document.getElementById("clock");
            const now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();
            const ampm = hours >= 12 ? "PM" : "AM";

            hours = hours % 12;
            hours = hours ? hours : 12; // 12-hour format
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            clock.textContent = $;
            {
                hours
            }
            $;
            {
                minutes
            }
            $;
            {
                seconds
            }
            $;
            {
                ampm
            };
        }
        setInterval(updateClock, 1000);
        updateClock();


        // search engene
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#adminTable tr");

            rows.forEach(row => {
                let name = row.cells[0].textContent.toLowerCase();
                let email = row.cells[2].textContent.toLowerCase();
                let barangay = row.cells[3].textContent.toLowerCase();

                if (name.includes(filter) || email.includes(filter) || barangay.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });

        const editModal = document.getElementById("editModal");
        const addModal = document.getElementById("addModal");
        const editForm = document.getElementById("editForm");
        const addForm = document.getElementById("addForm");
        const cancelEdit = document.getElementById("cancelEdit");
        const cancelAdd = document.getElementById("cancelAdd");
        const adminTable = document.getElementById("adminTable");
        let editingRow = null;

        // Open edit modal
        document.querySelectorAll(".editBtn").forEach((btn) => {
            btn.addEventListener("click", () => {
                const row = btn.closest("tr");
                editingRow = row;
                document.getElementById("editName").value = row.children[0].innerText;
                document.getElementById("editPassword").value = row.children[1].dataset.password;
                document.getElementById("editEmail").value = row.children[2].innerText;
                document.getElementById("editBarangay").value = row.children[3].innerText;
                editModal.classList.remove("hidden");
                editModal.classList.add("flex");
            });
        });

        // Save edit
        editForm.addEventListener("submit", (e) => {
            e.preventDefault();
            editingRow.children[0].innerText = document.getElementById("editName").value;
            editingRow.children[1].dataset.password = document.getElementById("editPassword").value;
            editingRow.children[1].innerText = "••••••"; // hide in table
            editingRow.children[2].innerText = document.getElementById("editEmail").value;
            editingRow.children[3].innerText = document.getElementById("editBarangay").value;
            editModal.classList.add("hidden");
            editModal.classList.remove("flex");
        });

        cancelEdit.addEventListener("click", () => {
            editModal.classList.add("hidden");
            editModal.classList.remove("flex");
        });

        // Add admin
        document.getElementById("addAdminBtn").addEventListener("click", () => {
            addModal.classList.remove("hidden");
            addModal.classList.add("flex");
        });

        addForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const name = document.getElementById("addName").value;
            const password = document.getElementById("addPassword").value;
            const email = document.getElementById("addEmail").value;
            const barangay = document.getElementById("addBarangay").value;

            const newRow = document.createElement("tr");
            newRow.classList.add("hover:bg-green-50");
            newRow.innerHTML = `
        <td class="p-3 border-b">${name}</td>
        <td class="p-3 border-b" data-password="${password}">••••••</td>
        <td class="p-3 border-b">${email}</td>
        <td class="p-3 border-b">${barangay}</td>
        <td class="p-3 border-b">
          <span class="status px-2 py-1 text-xs rounded-full bg-red-100 text-red-600">Inactive</span>
        </td>
        <td class="p-3 border-b">
          <button class="editBtn px-2 py-1 text-xs rounded border border-green-300 hover:bg-green-100">Edit</button>
          <button class="toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100 ml-2">Activate</button>
        </td>
      `;
            adminTable.appendChild(newRow);

            // Rebind events
            bindRowEvents(newRow);

            addModal.classList.add("hidden");
            addModal.classList.remove("flex");
            addForm.reset();
        });

        cancelAdd.addEventListener("click", () => {
            addModal.classList.add("hidden");
            addModal.classList.remove("flex");
        });

        // Toggle activate/deactivate
        function bindRowEvents(row) {
            row.querySelector(".editBtn").addEventListener("click", () => {
                editingRow = row;
                document.getElementById("editName").value = row.children[0].innerText;
                document.getElementById("editPassword").value = row.children[1].dataset.password;
                document.getElementById("editEmail").value = row.children[2].innerText;
                document.getElementById("editBarangay").value = row.children[3].innerText;
                editModal.classList.remove("hidden");
                editModal.classList.add("flex");
            });

            row.querySelector(".toggleBtn").addEventListener("click", (btn) => {
                const statusSpan = row.querySelector(".status");
                const toggleBtn = row.querySelector(".toggleBtn");
                if (statusSpan.innerText === "Active") {
                    statusSpan.innerText = "Inactive";
                    statusSpan.className = "status px-2 py-1 text-xs rounded-full bg-red-100 text-red-600";
                    toggleBtn.innerText = "Activate";
                    toggleBtn.className = "toggleBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-100 ml-2";
                } else {
                    statusSpan.innerText = "Active";
                    statusSpan.className = "status px-2 py-1 text-xs rounded-full bg-green-100 text-green-700";
                    toggleBtn.innerText = "Deactivate";
                    toggleBtn.className = "toggleBtn px-2 py-1 text-xs rounded border border-red-300 hover:bg-red-100 ml-2";
                }
            });
        }

        // Bind existing rows
        document.querySelectorAll("#adminTable tr").forEach(bindRowEvents);

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
    </script>
</body>

</html>