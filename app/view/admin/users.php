<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barangay Admin ViewReports</title>
  <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/output.css">
</head>
<style>
  .flash-message {
    position: fixed;
    top: 30px;
    right: -90px;
    transform: translate(-50%, -50%);
    background: #22C55E;
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

  /* Hidden state for animation */
  .flash-hide {
    opacity: 0;
    transform: translate(-50%, -60%);
  }
</style>

<body class="bg-green-200 font-sans overflow-hidden">

  <div class="flex min-h-screen">
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
            <a href="<?php echo URL_ROOT; ?>/admin/user_info" class="nav-btn flex items-center text-sm gap-3 bg-gray-400 p-2 rounded-lg">
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

      <!-- time and date -->
      <div class="mt-auto text-center text-xs text-gray-600">
        <p id="sidebar-time"></p>
        <p id="sidebar-date"></p>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-4 sm:p-6 overflow-hidden">
      <div class="flex  mb-6">
        <!-- Toggle Button (Mobile Only) -->
        <button id="toggleSidebar" class="md:hidden bg-green-500 size-8 text-white px-1 rounded-sm shadow-lg">
          ☰
        </button>

        <!-- Header -->
        <h1 class="text-lg ml-4 md:text-3xl font-bold">Waste Reporting System</h1>
      </div>
      <div class="bg-green-100 shadow-lg rounded-md p-2 sm:p-4">
        <h2 class="text-xl font-semibold mb-4">User Information</h2>

        <div class="max-h-[calc(92vh-100px)] sm:max-h-[calc(86vh-100px)] overflow-auto rounded">

          <!-- display flash message -->
          <?php if (!empty($data['message'])): ?>
            <div id="flash-message" class="flash-message">
              <?= htmlspecialchars($data['message'] ?? null); ?>
            </div>
          <?php endif; ?>

          <table class="w-full text-sm border-collapse table-fixed">
            <thead class="sticky top-0 bg-green-500 text-white">
              <tr>
                <th class="sticky top-0 z-10 bg-green-500 py-2 px-4 text-left">Name</th>
                <th class="sticky top-0 z-10 bg-green-500 p-2.5 hidden md:table-cell text-left">Email Address</th>
                <th class="sticky top-0 z-10 bg-green-500 p-2.5 text-center w-[150px]">Action</th>
              </tr>
            </thead>
            <tbody class="bg-white">

              <?php if (empty($data['users'])): ?>
                <p class="text-center">No Users Found</p>
              <?php else: ?>
                <?php foreach ($data['users'] as $user): ?>
                  <tr class="border-b border-gray-400 hover:bg-gray-200">
                    <td class="text-base py-2 px-4"><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?>
                      <dl class="lg:hidden gap-1">
                        <dt class="sr-only">Email Address</dt>
                        <dd class="md:hidden text-sm text-gray-500"><?= htmlspecialchars($user['email']) ?></dd>
                      </dl>
                    </td>
                    <td class="hidden md:table-cell p-2.5 text-blue-600"><?= htmlspecialchars($user['email']) ?></td>
                    <td class="p-3">
                      <button
                        class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded delete-btn"
                        data-user-id="<?= htmlspecialchars($user['id']) ?>">
                        Delete Account
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>

          <form id="deleteForm" method="POST" action="<?php echo URL_ROOT; ?>/admin/deleteUser" style="display:none;">
            <input type="hidden" name="user_id" id="deleteUserId">
          </form>

        </div>

      </div>
    </main>
  </div>

  <!-- Modal Background for delete account -->
  <div id="logoutModal" class="fixed inset-0 bg-opacity-40 flex items-center justify-center z-50" style="display:none;">

    <!-- Modal Container -->
    <div class="bg-[#e5f9e0] w-full max-w-xs rounded-lg shadow-lg relative p-4">

      <h1 class="font-bold text-xl mb-4">Confirm Delete</h1>

      <p>Are you sure you want to delete this user?</p>

      <div class="flex justify-end gap-2 mt-4">
        <button id="cancelBtn" class="hover:bg-gray-400 px-4 py-1 rounded-md">Cancel</button>
        <button id="deleteBtn" class="hover:bg-gray-400 px-4 py-1 rounded-md">OK</button>
      </div>
    </div>
  </div>

  <!-- script for responsive sidebar and flash message-->
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

    document.addEventListener('DOMContentLoaded', () => {
      const flashMessage = document.getElementById('flash-message');
      if (flashMessage) {
        setTimeout(() => {
          flashMessage.classList.add('flash-hide');
          setTimeout(() => flashMessage.remove(), 800); // Matches transition duration
        }, 3000); // Show for 3 seconds
      }

      // Delete modal logic
      const modal = document.getElementById('logoutModal');
      const cancelBtn = document.getElementById('cancelBtn');
      const deleteBtn = document.getElementById('deleteBtn');
      const deleteForm = document.getElementById('deleteForm');
      const deleteUserIdInput = document.getElementById('deleteUserId');

      let currentUserId = null;

      document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', () => {
          currentUserId = button.dataset.userId;
          modal.style.display = 'flex';
        });
      });

      cancelBtn.addEventListener('click', () => {
        modal.style.display = 'none';
      });

      deleteBtn.addEventListener('click', () => {
        if (currentUserId) {
          deleteUserIdInput.value = currentUserId;
          deleteForm.submit();
        }
      });
    });
  </script>
</body>

</html>