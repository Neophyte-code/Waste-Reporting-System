<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barangay Admin Dashboard</title>
  <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/output.css">
</head>

<body class="min-h-screen flex flex-col bg-gradient-to-br from-green-200 to-green-300">

  <div class=" flex-grow flex flex-1 flex-col min-h-screen md:flex-row">
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
            <a href="<?php echo URL_ROOT; ?>/admin" class="nav-btn flex items-center text-sm gap-3 bg-gray-400 p-2 rounded-lg">
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
    <main class="flex-grow p-4 md:p-6  relative">

      <div class="flex mb-6">
        <!-- Toggle Button (Mobile Only) -->
        <button id="toggleSidebar" class="md:hidden bg-green-500 size-8 text-white px-1 rounded-sm shadow-lg">
          ☰
        </button>

        <!-- Header -->
        <h1 class="text-lg ml-4 md:text-3xl font-bold">Waste Reporting System</h1>
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-2 md:mb-6">
        <div class="bg-sky-300 shadow-lg rounded-lg p-2 md:p-4 text-center">
          <p class="text-sm lg:text-lg  text-gray-700 font-bold">Total Users</p>
          <p class="text-xl md:text-2xl font-bold"><?= $data['totalUsers'] ?></p>
        </div>
        <div class="bg-green-400 shadow-lg rounded-lg p-2 md:p-4 text-center">
          <p class="text-sm lg:text-lg  text-gray-700 font-bold">Total Reports</p>
          <p class="text-xl md:text-2xl font-bold"><?= $data['totalReports'] ?></p>
        </div>
        <div class="bg-sky-400 shadow-lg rounded-lg p-2 md:p-4 text-center">
          <p class="text-sm lg:text-lg  text-gray-700 font-bold">Verified</p>
          <p class="text-xl md:text-2xl font-bold"><?= $data['total_verified_reports'] ?></p>
        </div>
        <div class="bg-yellow-400 shadow-lg rounded-lg p-2 md:p-4 text-center">
          <p class="text-sm lg:text-lg  text-gray-700 font-bold">Pending</p>
          <p class="text-xl md:text-2xl font-bold"><?= $data['total_pending_reports'] ?></p>
        </div>
      </div>

      <!-- User Engagement -->
      <div class="w-full pt-4 md:p-4 mb-2">
        <!-- Header & Controls in one row -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-2">
          <!-- Title & Legend -->
          <div class="flex items-center gap-6">
            <h2 class="font-bold text-lg">User Engagement</h2>
          </div>

          <div class="flex items-center gap-6 flex-wrap">
            <span class="flex items-center gap-1">
              <span class="w-3 h-3 bg-yellow-400 inline-block rounded"></span> Waste
            </span>
            <span class="flex items-center gap-1">
              <span class="w-3 h-3 bg-green-400 inline-block rounded"></span> Litterer
            </span>

            <!-- Filter -->
            <select id="timeFilter" class="border rounded px-2 py-1 text-sm outline-none">
              <option value="daily">Daily</option>
              <option value="weekly">Weekly</option>
              <option value="month">Monthly</option>
              <option value="year">Yearly</option>
            </select>
          </div>
        </div>

        <!-- Chart -->
        <div id="chart-container"
          class="w-full bg-gray-50 p-4 rounded-sm shadow-lg"
          style="height:330px;"
          data-daily='<?= htmlspecialchars($data['dailyChartData'], ENT_QUOTES) ?>'
          data-weekly='<?= htmlspecialchars($data['weeklyChartData'], ENT_QUOTES) ?>'
          data-monthly='<?= htmlspecialchars($data['monthlyChartData'], ENT_QUOTES) ?>'
          data-yearly='<?= htmlspecialchars($data['yearlyChartData'], ENT_QUOTES) ?>'>
          <canvas id="engagementChart"></canvas>
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
  </script>
  <script src="<?php echo URL_ROOT; ?>/js/admin/chart.js"></script>
  <script src="<?php echo URL_ROOT; ?>/js/admin/chart.umd.min.js"></script>
</body>

</html>