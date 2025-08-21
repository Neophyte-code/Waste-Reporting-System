<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barangay Admin ViewReports</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-200 flex flex-col font-sans overflow-hidden">

<div class="flex flex-grow min-h-screen ">
  <!-- Sidebar -->
    <aside id="sidebar" class="bg-green-100 min-w-55 p-4 flex flex-col items-center absolute md:relative md:translate-x-0 -translate-x-full transition-transform duration-300 z-50 h-full md:h-auto shadow-lg">
      <img src="images/dashboard-icon.png" alt="" class="w-[110px] h-[110px] rounded-full mt-2">
      <p class="text-center text-md mt-1 mb-4">
        Welcome back<br>
        <span class="font-semibold">Admin</span>
      </p>
      <!-- Navigation -->
      <nav id="navMenu" class="flex flex-col w-full">
        <ul class="space-y-1">
          <li>
            <a href="dashboard.html" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
            <img class="size-5" src="images/dashboard-icon.png" alt=""> Dashboard
            </a>
          </li>
          <li>
            <a href="viewreports.html" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
            <img class="size-5" src="images/view-report-icon.png" alt=""> Reports
            </a>
          </li>
          <li>
            <a href="user-info.html" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
              <img class="size-5" src="images/user-icon.png" alt=""> User Info.
            </a>
          </li>
          <li>
            <a href="announcement.html" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
              <img class="size-5" src="images/announcement-icon.png" alt=""> Announcement
            </a>
          </li>
          <li>
            <a href="Litterers-record.html" class="nav-btn flex items-center text-sm gap-3 bg-gray-400 p-2 rounded-lg">
              <img class="size-5" src="images/litterer-icon.png" alt=""> Litterers Records
            </a>
          </li>
          <li>
            <a href="settings.html" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
              <img class="size-5" src="images/setting-icon.png" alt=""> Settings
            </a>
          </li>
          <li>
            <a href="Redemption.html" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
            <img class="size-5" src="images/redeem-icon.png" alt=""> Redemption
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
  <main class="flex-1 p-4 sm:p-6 bg-gradient-to-br from-green-200 to-green-300">
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

      <div class="max-h-[calc(93vh-100px)] sm:max-h-[calc(89vh-100px)] overflow-y-auto rounded-md border">
  <table class="w-full text-sm border-collapse table-fixed">
    <thead class="sticky top-0 bg-green-500 text-white">
      <tr>
        <th class="sticky top-0 z-10 bg-green-500 py-2 px-4 text-left ">Name</th>
        <th class="sticky top-0 z-10 bg-green-500 p-2.5 hidden md:table-cell text-left ">Address</th>
        <th class="sticky top-0 z-10 bg-green-500 p-2.5 hidden sm:table-cell text-left ">No. of Offense</th>
        <th class="sticky top-0 z-10 bg-green-500 p-2.5 text-left w-[110px]">Remarks</th>
      </tr>
    </thead>
    <tbody class="bg-white">
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">1</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">1</td>
        <td class="p-3 text-yellow-400 font-bold">Warning</td>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">2</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">2</td>
        <td class="p-3 text-yellow-400 font-bold">Warning</td>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">3</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">3</td>
        <td class="p-3 text-red-500 font-bold">Penalty</td>
      </tr>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">1</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">1</td>
        <td class="p-3 text-yellow-400 font-bold">Warning</td>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">2</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">2</td>
        <td class="p-3 text-yellow-400 font-bold">Warning</td>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">3</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">3</td>
        <td class="p-3 text-red-500 font-bold">Penalty</td>
      </tr>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">1</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">1</td>
        <td class="p-3 text-yellow-400 font-bold">Warning</td>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">2</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">2</td>
        <td class="p-3 text-yellow-400 font-bold">Warning</td>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">3</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">3</td>
        <td class="p-3 text-red-500 font-bold">Penalty</td>
      </tr>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">1</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">1</td>
        <td class="p-3 text-yellow-400 font-bold">Warning</td>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">2</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">2</td>
        <td class="p-3 text-yellow-400 font-bold">Warning</td>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">3</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">3</td>
        <td class="p-3 text-red-500 font-bold">Penalty</td>
      </tr>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">1</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">1</td>
        <td class="p-3 text-yellow-400 font-bold">Warning</td>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">2</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">2</td>
        <td class="p-3 text-yellow-400 font-bold">Warning</td>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">3</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">3</td>
        <td class="p-3 text-red-500 font-bold">Penalty</td>
      </tr>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">1</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">1</td>
        <td class="p-3 text-yellow-400 font-bold">Warning</td>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">2</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">2</td>
        <td class="p-3 text-yellow-400 font-bold">Warning</td>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">3</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">3</td>
        <td class="p-3 text-red-500 font-bold">Penalty</td>
      </tr>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">1</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">1</td>
        <td class="p-3 text-yellow-400 font-bold">Warning</td>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">2</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">2</td>
        <td class="p-3 text-yellow-400 font-bold">Warning</td>
      </tr>
      <tr class="border-b hover:bg-gray-200">
        <td class="py-2 px-4">Jerwin Noval
            <dl class="lg:hidden gap-1">
                <dt class="sr-only">Address</dt>
                <dd class="md:hidden text-sm text-gray-700">Magsaysay</dd>
                <dt class="sm:hidden inline text-sm text-gray-600">No. of Offense:</dt>
                <dd class="inline sm:hidden text-sm text-gray-500">3</dd>
            </dl>
        </td>
        <td class="hidden md:table-cell p-2.5">Magsaysay</td>
        <td class="hidden sm:table-cell p-2.5">3</td>
        <td class="p-3 text-red-500 font-bold">Penalty</td>
      </tr>
    </tbody>
  </table>
</div>

        </div>
    </main>
</div>

<script>
    // Sidebar controls (named functions) + close on outside click
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

        function openSidebarMenu(){ sidebar.classList.remove('-translate-x-full'); }
        function closeSidebarMenu(){ sidebar.classList.add('-translate-x-full'); }
        function toggleSidebarMenu(){ sidebar.classList.toggle('-translate-x-full'); }

        // Toggle button should not allow the document click handler to immediately close it
        if (toggleBtn) toggleBtn.addEventListener('click', (e)=>{ e.stopPropagation(); toggleSidebarMenu(); });

        // Prevent clicks inside the sidebar from bubbling to document (so it won't close)
        if (sidebar) sidebar.addEventListener('click', (e)=>{ e.stopPropagation(); });

        // Close sidebar when clicking outside it (only when it's currently open)
        document.addEventListener('click', (e)=>{
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
</body>
 </html>
