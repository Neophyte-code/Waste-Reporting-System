<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barangay Admin ViewReports</title>
  <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/output.css">
</head>

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

      <div class="mt-auto text-center text-xs text-gray-600">
        <p>Tuesday | 8:00 am</p>
        <p>May 28, 2025</p>
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

        <div class="max-h-[calc(92vh-100px)] sm:max-h-[calc(86vh-100px)] overflow-auto border">
          <table class="w-full text-sm border-collapse table-fixed">
            <thead class="sticky top-0 bg-green-500 text-white">
              <tr>
                <th class="sticky top-0 z-10 bg-green-500 py-2 px-4 text-left">Name</th>
                <th class="sticky top-0 z-10 bg-green-500 p-2.5 hidden sm:table-cell text-left">Address</th>
                <th class="sticky top-0 z-10 bg-green-500 p-2.5 hidden md:table-cell text-left">Email Address</th>
                <th class="sticky top-0 z-10 bg-green-500 p-2.5 text-center w-[150px]">Action</th>
              </tr>
            </thead>
            <tbody class="bg-white">
              <tr class="border-b hover:bg-gray-200">
                <td class="text-base py-2 px-4">Jerwin Noval
                  <dl class="lg:hidden gap-1">
                    <dt class="sr-only">Address</dt>
                    <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                    <dt class="sr-only">Email Address</dt>
                    <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                  </dl>
                </td>
                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                <td class="p-3">
                  <button class="bg-green-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                    Delete Account
                  </button>
                </td>
              </tr>
              <tr class="border-b hover:bg-gray-200">
                <td class="text-base py-2 px-4">Jerwin Noval
                  <dl class="lg:hidden gap-1">
                    <dt class="sr-only">Address</dt>
                    <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                    <dt class="sr-only">Email Address</dt>
                    <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                  </dl>
                </td>
                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                <td class="p-3">
                  <button class="bg-green-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                    Delete Account
                  </button>
                </td>
              </tr>
              <tr class="border-b hover:bg-gray-200">
                <td class="text-base py-2 px-4">Jerwin Noval
                  <dl class="lg:hidden gap-1">
                    <dt class="sr-only">Address</dt>
                    <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                    <dt class="sr-only">Email Address</dt>
                    <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                  </dl>
                </td>
                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                <td class="p-3">
                  <button class="bg-green-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                    Delete Account
                  </button>
                </td>
              </tr>
              <tr class="border-b hover:bg-gray-200">
                <td class="text-base py-2 px-4">Jerwin Noval
                  <dl class="lg:hidden gap-1">
                    <dt class="sr-only">Address</dt>
                    <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                    <dt class="sr-only">Email Address</dt>
                    <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                  </dl>
                </td>
                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                <td class="p-3">
                  <button class="bg-green-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                    Delete Account
                  </button>
                </td>
              </tr>
              <tr class="border-b hover:bg-gray-200">
                <td class="text-base py-2 px-4">Jerwin Noval
                  <dl class="lg:hidden gap-1">
                    <dt class="sr-only">Address</dt>
                    <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                    <dt class="sr-only">Email Address</dt>
                    <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                  </dl>
                </td>
                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                <td class="p-3">
                  <button class="bg-green-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                    Delete Account
                  </button>
                </td>
              </tr>
              <tr class="border-b hover:bg-gray-200">
                <td class="text-base py-2 px-4">Jerwin Noval
                  <dl class="lg:hidden gap-1">
                    <dt class="sr-only">Address</dt>
                    <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                    <dt class="sr-only">Email Address</dt>
                    <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                  </dl>
                </td>
                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                <td class="p-3">
                  <button class="bg-green-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                    Delete Account
                  </button>
                </td>
              </tr>
              <tr class="border-b hover:bg-gray-200">
                <td class="text-base py-2 px-4">Jerwin Noval
                  <dl class="lg:hidden gap-1">
                    <dt class="sr-only">Address</dt>
                    <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                    <dt class="sr-only">Email Address</dt>
                    <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                  </dl>
                </td>
                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                <td class="p-3">
                  <button class="bg-green-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                    Delete Account
                  </button>
                </td>
              </tr>
              <tr class="border-b hover:bg-gray-200">
                <td class="text-base py-2 px-4">Jerwin Noval
                  <dl class="lg:hidden gap-1">
                    <dt class="sr-only">Address</dt>
                    <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                    <dt class="sr-only">Email Address</dt>
                    <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                  </dl>
                </td>
                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                <td class="p-3">
                  <button class="bg-green-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                    Delete Account
                  </button>
                </td>
              </tr>
              <tr class="border-b hover:bg-gray-200">
                <td class="text-base py-2 px-4">Jerwin Noval
                  <dl class="lg:hidden gap-1">
                    <dt class="sr-only">Address</dt>
                    <dd class="sm:hidden text-sm text-gray-600">Magsaysay</dd>
                    <dt class="sr-only">Email Address</dt>
                    <dd class="md:hidden text-sm text-gray-500">jerwinnoval@gmail.com</dd>
                  </dl>
                </td>
                <td class="hidden sm:table-cell p-2.5">Magsaysay</td>
                <td class="hidden md:table-cell p-2.5 text-blue-600">jerwinoval@gmail.com</td>
                <td class="p-3">
                  <button class="bg-green-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                    Delete Account
                  </button>
                </td>
              </tr>


              <!-- More rows -->
            </tbody>
          </table>
        </div>

      </div>
    </main>
  </div>

  <!-- Modal Background for delete account -->
  <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" style="display:none;">

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

    // Delete account modal and table-row removal
    (function() {
      const table = document.querySelector('table');
      const overlay = document.getElementById('logoutModal');
      const cancelBtn = document.getElementById('cancelBtn');
      const deleteBtn = document.getElementById('deleteBtn');
      let activeRow = null;

      function showModal(name) {
        if (!overlay) return;
        // set confirmation text if available
        const p = overlay.querySelector('p');
        if (p && name) p.textContent = `Are you sure you want to delete ${name}?`;
        overlay.style.display = 'flex';
      }

      function hideModal() {
        if (overlay) overlay.style.display = 'none';
        activeRow = null;
      }

      // Delegate Delete button clicks in the table
      if (table) table.addEventListener('click', (e) => {
        const btn = e.target.closest('button');
        if (!btn) return;
        const txt = btn.textContent ? btn.textContent.trim() : '';
        if (txt === 'Delete Account') {
          const row = btn.closest('tr');
          if (!row) return;
          activeRow = row;
          // try to extract name from first cell
          const nameCell = row.querySelector('td');
          const name = nameCell ? nameCell.textContent.trim().split('\n')[0].trim() : '';
          showModal(name || 'this user');
        }
      });

      if (cancelBtn) cancelBtn.addEventListener('click', hideModal);
      if (deleteBtn) deleteBtn.addEventListener('click', () => {
        if (activeRow) activeRow.remove();
        hideModal();
      });

      // close when clicking on overlay background
      if (overlay) overlay.addEventListener('click', (e) => {
        if (e.target === overlay) hideModal();
      });

      // close on Escape
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') hideModal();
      });
    })();
  </script>

</body>

</html>