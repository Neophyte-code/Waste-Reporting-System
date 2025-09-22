<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Management — Super Admin</title>
    <link href="<?php echo URL_ROOT; ?>/css/output.css" rel="stylesheet">
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

<body class="bg-green-50 text-green-900 overflow-hidden">
    <div class="min-h-screen flex ">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed md:static top-0 left-0 h-screen w-64 bg-white p-4 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50 flex-shrink-0">
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
            <header class="flex items-center justify-between p-4 shadow-md bg-white">
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
                                class="p-2 text-sm border border-gray-400 rounded outline-none focus:outline-none">
                            <!-- Add Admin Button -->
                            <button id="addAdminBtn" class="px-3 py-2 rounded bg-green-600 hover:bg-green-700 text-white text-sm">
                                + Add Admin
                            </button>
                        </div>
                    </div>

                    <div class="overflow-hidden">
                        <div class="max-h-[68vh] overflow-auto">
                            <table id="adminTable" class="w-full text-sm border-collapse">
                                <thead class="sticky top-0 bg-green-100 text-green-800 z-10">
                                    <tr>
                                        <th class="p-3 border-b text-left">Name</th>
                                        <th class="p-3 border-b text-left">Password</th>
                                        <th class="p-3 border-b text-left">Email</th>
                                        <th class="p-3 border-b text-left">Barangay</th>
                                        <th class="p-3 border-b text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="adminTable">
                                    <?php if (empty($data['admin'])): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-gray-500">
                                                No Admin Found
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($data['admin'] as $admin): ?>
                                            <tr class="hover:bg-green-50">
                                                <td class="p-3 border-b border-gray-400"><?= htmlspecialchars($admin['firstname'] . ' ' . $admin['lastname']) ?></td>
                                                <td class="p-3 border-b border-gray-400">•••••••</td>
                                                <td class="p-3 border-b border-gray-400"><?= htmlspecialchars($admin['email']) ?></td>
                                                <td class="p-3 border-b border-gray-400"><?= htmlspecialchars($admin['name']) ?></td>
                                                <td class="p-3 border-b border-gray-400">
                                                    <button
                                                        class="editBtn px-2 py-1 text-xs rounded border border-green-400 hover:bg-green-300 hover:text-white"
                                                        data-id="<?= htmlspecialchars($admin['id']) ?>"
                                                        data-firstname="<?= htmlspecialchars($admin['firstname']) ?>"
                                                        data-lastname="<?= htmlspecialchars($admin['lastname']) ?>"
                                                        data-email="<?= htmlspecialchars($admin['email']) ?>"
                                                        data-barangay="<?= htmlspecialchars($admin['name']) ?>">
                                                        Edit
                                                    </button>
                                                    <button
                                                        class="deleteBtn px-2 py-1 text-xs rounded border border-red-400 hover:bg-red-300 hover:text-white"
                                                        data-id="<?= htmlspecialchars($admin['id']) ?>">
                                                        Delete
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
            </main>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 flex hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold text-green-800 mb-4">Edit Admin</h2>

            <form id="editForm" action="<?php echo URL_ROOT; ?>/superadmin/editAdmin" method="POST" class="space-y-3">
                <input type="hidden" name="editId" id="editId">
                <div>
                    <label class="block text-sm font-medium text-green-700">Firstname</label>
                    <input name="editFirstname" type="text" id="addFirstname" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Lastname</label>
                    <input name="editLastname" type="text" id="addLastname" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Password</label>
                    <input name="editPassword" type="text" id="editPassword" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Email</label>
                    <input name="editEmail" type="email" id="editEmail" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Barangay</label>
                    <select name="barangay" class="w-full p-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-transparent">
                        <option value="Tapilon">Tapilon</option>
                        <option value="Maya">Maya</option>
                        <option value="Poblacion">Poblacion</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 mt-4 text-white">
                    <button type="button" id="cancelEdit" class="px-4 py-2 rounded bg-red-600 hover:bg-red-700  hover:text-white text-sm">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded bg-green-600 hover:bg-green-700  text-white hover:text-white text-sm">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold text-green-800 mb-4">Add Admin</h2>
            <form id="addForm" action="<?php echo URL_ROOT; ?>/superadmin/createAdmin" method="POST" class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-green-700">Firstname</label>
                    <input name="firstname" type="text" id="addFirstname" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Lastname</label>
                    <input name="lastname" type="text" id="addLastname" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Password</label>
                    <input name="password" type="text" id="addPassword" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Email</label>
                    <input name="email" type="email" id="addEmail" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Barangay</label>
                    <select name="barangay" type="text" id="addBarangay" class="w-full p-2 border rounded text-sm outline-none focus:outline-none" required>
                        <option value="" selected>Select Barangay</option>
                        <option value="Tapilon">Tapilon</option>
                        <option value="Maya">Maya</option>
                        <option value="Poblacion">Poblacion</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" id="cancelAdd" class="px-4 py-2 rounded bg-slate-100 hover:bg-slate-200 text-sm">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white text-sm">Add</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 flex hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h2 class="text-lg font-semibold text-red-600 mb-4">Delete Admin</h2>
            <p class="text-sm text-gray-700 mb-4">Are you sure you want to delete this admin account?</p>

            <form id="deleteForm" action="<?php echo URL_ROOT; ?>/superadmin/deleteAdmin" method="POST">
                <input type="hidden" name="id" id="deleteId">
                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelDelete" class="px-4 py-2 rounded bg-gray-400 hover:bg-gray-500 text-sm text-white">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white text-sm">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-80">
            <h2 class="text-lg font-semibold text-green-700 mb-3">Confirm Logout</h2>
            <p class="text-sm text-gray-600 mb-5">Are you sure you want to logout?</p>
            <div class="flex justify-end gap-3">
                <button id="cancelLogout" class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200">Cancel</button>
                <a href="<?php echo URL_ROOT; ?>/auth/logout" class="px-3 py-1 rounded bg-red-500 hover:bg-red-600 text-white">Logout</a>
            </div>
        </div>
    </div>

    <script>
        // Get elements
        const addAdminBtn = document.getElementById("addAdminBtn");
        const addModal = document.getElementById("addModal");
        const cancelAdd = document.getElementById("cancelAdd");

        // Open modal when button is clicked
        addAdminBtn.addEventListener("click", () => {
            addModal.classList.remove("hidden");
            addModal.classList.add("flex");
        });

        // Close modal when cancel button is clicked
        cancelAdd.addEventListener("click", () => {
            addModal.classList.add("hidden");
            addModal.classList.remove("flex");
        });

        //Close modal when clicking outside of modal content
        addModal.addEventListener("click", (e) => {
            if (e.target === addModal) {
                addModal.classList.add("hidden");
                addModal.classList.remove("flex");
            }
        });

        //flash message
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            setTimeout(() => {
                flashMessage.classList.add('flash-hide');
                setTimeout(() => flashMessage.remove(), 800);
            }, 3000);
        }

        // Elements
        const logoutModal = document.getElementById("logoutModal");
        const logoutTrigger = document.getElementById("logoutBtn");
        const cancelLogout = document.getElementById("cancelLogout");

        // Show modal when logout button is clicked
        logoutTrigger.addEventListener("click", (e) => {
            e.preventDefault(); // stop immediate navigation
            logoutModal.classList.remove("hidden");
        });

        // Hide modal when cancel is clicked
        cancelLogout.addEventListener("click", () => {
            logoutModal.classList.add("hidden");
        });

        // Hide modal when clicking outside modal box
        logoutModal.addEventListener("click", (e) => {
            if (e.target === logoutModal) {
                logoutModal.classList.add("hidden");
            }
        });


        // js functionality for editing/updating account
        document.addEventListener("DOMContentLoaded", () => {
            const editButtons = document.querySelectorAll(".editBtn");
            const modal = document.getElementById("editModal");
            const cancelBtn = document.getElementById("cancelEdit");

            const idInput = document.getElementById("editId");
            const firstnameInput = document.getElementById("addFirstname");
            const lastnameInput = document.getElementById("addLastname");
            const emailInput = document.getElementById("editEmail");
            const barangaySelect = document.querySelector("select[name='barangay']");

            // Open modal and fill data
            editButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    idInput.value = btn.dataset.id;
                    firstnameInput.value = btn.dataset.firstname;
                    lastnameInput.value = btn.dataset.lastname;
                    emailInput.value = btn.dataset.email;

                    // Select barangay
                    for (let option of barangaySelect.options) {
                        if (option.value === btn.dataset.barangay) {
                            option.selected = true;
                        }
                    }

                    modal.classList.remove("hidden");
                });
            });

            // Close modal
            cancelBtn.addEventListener("click", () => {
                modal.classList.add("hidden");
            });

            // Hide modal when clicking outside modal box
            modal.addEventListener("click", (e) => {
                if (e.target === modal) {
                    modal.classList.add("hidden");
                }
            });
        });


        //use to delete account
        document.addEventListener("DOMContentLoaded", () => {
            const deleteButtons = document.querySelectorAll(".deleteBtn");
            const modal = document.getElementById("deleteModal");
            const cancelBtn = document.getElementById("cancelDelete");
            const deleteIdInput = document.getElementById("deleteId");

            // Open modal when delete button is clicked
            deleteButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    const adminId = btn.dataset.id;
                    deleteIdInput.value = adminId;
                    modal.classList.remove("hidden");
                });
            });

            // Close modal when cancel is clicked
            cancelBtn.addEventListener("click", () => {
                modal.classList.add("hidden");
            });

            // Optional: close modal if background overlay is clicked
            modal.addEventListener("click", (e) => {
                if (e.target === modal) {
                    modal.classList.add("hidden");
                }
            });
        });


        //javascript for search admin algorithm
        document.addEventListener("DOMContentLoaded", () => {
            const searchInput = document.getElementById("searchInput");
            const table = document.getElementById("adminTable");
            const rows = table.getElementsByTagName("tr");

            searchInput.addEventListener("keyup", () => {
                const filter = searchInput.value.toLowerCase();

                // Loop through table rows
                for (let i = 1; i < rows.length; i++) {
                    let row = rows[i];
                    let text = row.textContent.toLowerCase();

                    if (text.includes(filter)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                }
            });
        });
    </script>
</body>

</html>