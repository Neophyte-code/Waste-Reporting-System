<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barangay Admin - Settings</title>
  <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/output.css">
  <style>
    /* Dark mode overrides (class-based) */
    body.dark {
      background: #071218 !important;
      color: #dff7ea;
    }

    body.dark .bg-green-100 {
      background-color: #0e2a21 !important;
    }

    body.dark .bg-green-50 {
      background-color: #072015 !important;
    }

    body.dark .bg-gradient-to-br {
      background: linear-gradient(135deg, #07221a, #0a2431) !important;
    }

    body.dark input,
    body.dark textarea {
      background-color: #0f2b22 !important;
      color: #e6f7ee !important;
      border-color: #234 !important;
    }

    body.dark .text-gray-600 {
      color: #9fcfb6 !important;
    }

    body.dark .svgIcon {
      filter: brightness(0.9) saturate(0.6);
    }
  </style>
</head>

<body class="bg-green-100 font-sans flex flex-col min-h-screen">
  <div class="flex flex-grow">

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
            <a href="<?php echo URL_ROOT; ?>/admin/redemptions" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
              <img class="size-5" src="<?php echo URL_ROOT; ?>/images/icons/redeem-icon.png" alt=""> Redemption
            </a>
          </li>
          <li>
            <a href="<?php echo URL_ROOT; ?>/admin/settings" class="nav-btn flex items-center text-sm gap-3 bg-gray-400 p-2 rounded-lg">
              <img class="size-5" src="<?php echo URL_ROOT; ?>/images/icons/setting-icon.png" alt=""> Settings
            </a>
          </li>
        </ul>
      </nav>

      <!-- time and date -->
      <div class="mt-auto text-center text-xs text-black">
        <p id="sidebar-time"></p>
        <p id="sidebar-date"></p>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-4 sm:p-6 bg-gradient-to-br from-green-200 to-green-300 relative">

      <div class="flex  mb-6">
        <!-- Toggle Button (Mobile Only) -->
        <button id="toggleSidebar" class="md:hidden bg-green-500 size-8 text-white px-1 rounded-sm shadow-lg">
          ☰
        </button>

        <!-- Header -->
        <h1 class="text-lg ml-4 md:text-3xl font-bold">Waste Reporting System</h1>
      </div>

      <div class="p-4 sm:p-6 bg-green-100 rounded-md ">

        <div class="flex justify-between mb-4">
          <h2 class="text-xl font-semibold ">Settings</h2>
        </div>

        <div class="bg-green-50 p-2 sm:p-6 rounded-lg shadow flex flex-col md:flex-row gap-6 max-h-[calc(120vh-100px)]">

          <!-- Left Side -->
          <div class="flex flex-col sm:justify-center sm:items-center w-full ">

            <div class="sm:w-[450px] md:w-[400px] lg:w-[500px] space-y-2 p-1 sm:p-4">

              <div class="flex justify-end gap-2 pt-1">
                <div class="flex justify-end gap-2">
                  <button id="editBtn" class="px-3 py-1 bg-green-400 text-white rounded">Edit</button>
                  <button id="updateBtn" class="px-3 py-1 bg-yellow-400 text-white rounded hidden">Cancel</button>
                  <button id="saveBtn" class="px-3 py-1 bg-blue-600 text-white rounded hidden">Save</button>
                </div>
                <button id="logoutBtn" class="flex bg-green-400 hover:bg-green-500 py-2 px-4 items-center rounded-md">
                  <svg class="svgIcon h-3.5 w-4 -rotate-90" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
                    <path d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8 224 64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"></path>
                  </svg>
                  <span class="icon2 w-1 h-4 border-b-2 border-r-2 border-t-2 border-black"></span>
                </button>
              </div>


              <div class="flex flex-col justify-between">

                <p class="font-semibold">Name</p>
                <input id="nameInput" type="text" value="<?php echo htmlspecialchars($data['user']['firstname'] . ' ' . $data['user']['lastname'] ?? 'Guest User'); ?>" class="w-full border border-gray-300 rounded p-2 mt-1 text-md focus:outline-none" readonly>

              </div>

              <div class="flex flex-col justify-between">

                <p class="font-semibold">Barangay</p>
                <input id="addressInput" type="text" value="<?php echo htmlspecialchars($data['user']['barangay'] ?? 'Unknown'); ?>" class="w-full border border-gray-300 rounded p-2 mt-1 text-md focus:outline-none" readonly>

              </div>

              <div class="flex flex-col justify-between">

                <p class="font-semibold">Email Address</p>
                <input id="emailInput" type="text" value="<?php echo htmlspecialchars($data['user']['email'] ?? 'guest@example.com'); ?>" class="w-full border border-gray-300 rounded p-2 mt-1 text-md focus:outline-none" readonly>

              </div>

              <div class="flex l justify-between items-center border-t-2 border-gray-400 mt-6 py-5">

                <p class="font-semibold">Records</p>

                <select class="w-40 py-1 px-2 outline-none border-gray-900" name="" id="">
                  <option>Select year</option>
                  <option value="">2025</option>
                  <option value="">2026</option>
                  <option value="">2027</option>
                </select>
              </div>
              <button class="w-full py-1 text-white text-center bg-green-400 rounded hover:bg-green-500 cursor-pointer">Download Records</button>
            </div>
          </div>


        </div>
      </div>
    </main>

    <!-- Modal Background for logout -->
    <div id="logoutModal" class="fixed inset-0 bg-opacity-40 flex items-center justify-center z-50" style="display:none;">

      <!-- Modal Container for logout -->
      <div class="bg-[#e5f9e0] w-full max-w-xs rounded-lg shadow-lg relative p-4">

        <h1 class="font-bold text-xl mb-4">Confirm Logout</h1>

        <p>Are you sure you want to logout?</p>

        <div class="flex justify-end gap-2 mt-4">
          <button id="cancelLogoutBtn" class="hover:bg-gray-400 px-4 py-1 rounded-md">Cancel</button>
          <a id="confirmLogoutBtn" href="<?php echo URL_ROOT; ?>/auth/logout" class="hover:bg-gray-400 px-4 py-1 rounded-md">OK</a>
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

      // Logout modal handlers
      (function() {
        const logoutBtn = document.getElementById('logoutBtn');
        const overlay = document.getElementById('logoutModal');
        const cancelBtn = document.getElementById('cancelLogoutBtn');
        const confirmBtn = document.getElementById('confirmLogoutBtn');

        function showLogoutModal() {
          if (overlay) overlay.style.display = 'flex';
        }

        function hideLogoutModal() {
          if (overlay) overlay.style.display = 'none';
        }

        if (logoutBtn) logoutBtn.addEventListener('click', (e) => {
          e.preventDefault();
          showLogoutModal();
        });
        if (cancelBtn) cancelBtn.addEventListener('click', hideLogoutModal);
        if (confirmBtn) confirmBtn.addEventListener('click', () => {
          hideLogoutModal(); /* add logout logic here */
        });

        // close when clicking on overlay background
        if (overlay) overlay.addEventListener('click', (e) => {
          if (e.target === overlay) hideLogoutModal();
        });

        // close on Escape
        document.addEventListener('keydown', (e) => {
          if (e.key === 'Escape') hideLogoutModal();
        });
      })();
    </script>
</body>

</html>