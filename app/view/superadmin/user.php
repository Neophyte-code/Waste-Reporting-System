<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>User Management — Super Admin</title>
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

<body class="bg-green-50 text-green-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed md:static top-0 left-0 h-screen w-64 bg-white p-4 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50 flex-shrink-0">

            <div class="flex items-center gap-3 mb-6">
                <!-- Logo container (no SA text anymore) -->
                <div id="sidebarLogo" class="h-12 w-12  flex items-center justify-center overflow-hidden">
                    <img src="<?php echo URL_ROOT; ?>/images/tree3.png" alt="logo" class="h-15">
                </div>
                <div>
                    <div class="font-semibold">Super Admin</div>
                    <div class="text-xs text-green-600">Waste Reporting System</div>
                </div>
            </div>
            <nav class="space-y-1 text-sm">
                <a href="<?php echo URL_ROOT; ?>/superadmin" class="nav-item px-3 py-2 rounded hover:bg-green-100 flex gap-2"><img src="<?php echo URL_ROOT; ?>/images/icons/admin.png" alt="logout" class="h-5">Admin Management</a>
                <a href="<?php echo URL_ROOT; ?>/superadmin/user" class="nav-item px-3 py-2 rounded hover:bg-green-100 flex gap-2"><img src="<?php echo URL_ROOT; ?>/images/icons/profile.png" alt="user-logo" class="h-5"> User Management</a>
                <button id="logoutBtn" class="w-full flex text-left px-4 py-2 rounded hover:bg-green-100 gap-2"><img src="<?php echo URL_ROOT; ?>/images/icons/logout.png" alt="logout" class="h-5">Logout</button>
            </nav>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar -->
            <header class="flex items-center justify-between p-4 bg-white shadow-md">
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
                            class="p-2 text-sm border border-gray-400 rounded outline-none focus:ring-1 focus:ring-green-400">
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
                                    <?php if (empty($data['users'])): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-gray-500">
                                                No registered user
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($data['users'] as $user): ?>
                                            <tr class="hover:bg-green-50 border-b border-gray-400   ">
                                                <td class="p-3 "><?php echo $user['firstname'] . ' ' . $user['lastname'] ?></td>
                                                <td class="p-3 "><?php echo $user['email'] ?></td>
                                                <td class="p-3 "><?php echo $user['name'] ?></td>
                                                <td class="p-3 "><?php echo $user['points'] ?></td>
                                                <td class="p-3">
                                                    <span class="status px-2 py-1 text-xs rounded-full <?= $user['status'] === 'banned' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' ?>">
                                                        <?= ucfirst($user['status']) ?>
                                                    </span>
                                                </td>
                                                <td class="p-3">
                                                    <form method="POST" action="<?php echo URL_ROOT; ?>/superadmin/updateStatus">
                                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                                        <input type="hidden" name="action" value="<?= $user['status'] === 'banned' ? 'unban' : 'ban' ?>">
                                                        <button type="submit"
                                                            class="px-2 py-1 text-xs rounded border 
                                                            <?= $user['status'] === 'banned' ? 'border-green-300 hover:bg-green-100' : 'border-red-300 hover:bg-red-100' ?>">
                                                            <?= $user['status'] === 'banned' ? 'Unban' : 'Ban' ?>
                                                        </button>
                                                    </form>
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
        // Elements
        const logoutModal = document.getElementById("logoutModal");
        const logoutTrigger = document.getElementById("logoutBtn");
        const cancelLogout = document.getElementById("cancelLogout");

        // Show modal when logout button is clicked
        logoutTrigger.addEventListener("click", (e) => {
            e.preventDefault();
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

        //flash message
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            setTimeout(() => {
                flashMessage.classList.add('flash-hide');
                setTimeout(() => flashMessage.remove(), 800);
            }, 3000);
        }

        //script for searching user
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#userTable tr');

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>

</html>