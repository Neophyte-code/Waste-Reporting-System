<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barangay Admin - Announcement</title>
  <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/output.css">
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

<body class=" font-sans">

  <!-- Container -->
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
            <a href="<?php echo URL_ROOT; ?>/admin/user_info" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
              <img class="size-5" src="<?php echo URL_ROOT; ?>/images/icons/user-icon.png" alt=""> User Info.
            </a>
          </li>
          <li>
            <a href="<?php echo URL_ROOT; ?>/admin/announcement" class="nav-btn flex items-center text-sm gap-3 bg-gray-400 p-2 rounded-lg">
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
    <main class="flex-1 p-4 sm:p-6 bg-gradient-to-br from-green-200 to-green-300 ">
      <div class="flex  mb-6">
        <!-- Toggle Button (Mobile Only) -->
        <button id="toggleSidebar" class="md:hidden bg-green-500 size-8 text-white px-1 rounded-sm shadow-lg">
          ☰
        </button>

        <!-- Header -->
        <h1 class="text-lg ml-4 md:text-3xl font-bold">Waste Reporting System</h1>
      </div>
      <!-- Announcement Form -->
      <section class=" bg-green-50 p-4 sm:p-6 rounded-lg shadow-md overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Announcement</h2>

        <!-- form -->
        <form method="post" action="<?php echo URL_ROOT; ?>/admin/createAnnouncement">
          <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 ">
            <div class="flex flex-1 flex-col gap-2">
              <div class="">
                <input type="hidden" name="id" id="announcement_id">
                <label class="font-semibold mb-1">Title:</label>
                <input name="title" type="text" id="title" required class="w-full border border-gray-300 p-2 rounded focus:outline-none" placeholder="Enter title">
              </div>
              <div class="flex w-full flex-col md:flex-row gap-2 sm:gap-4">
                <div class=" flex flex-col flex-1">
                  <label class="font-semibold mb-1">To:</label>
                  <input name="to" type="text" id="to" required class="w-full border border-gray-300 p-2 rounded focus:outline-none" placeholder="Tapilon Covered Court">
                </div>
                <div class=" flex flex-col flex-1">
                  <label class="font-semibold mb-1">Date:</label>
                  <input name="date" type="date" id="date" required class="w-full border border-gray-300 p-2 rounded focus:outline-none">
                </div>
              </div>
              <div class="flex flex-col md:flex-row w-full  gap-2 sm:gap-4">
                <div class=" flex flex-col flex-1">
                  <label class="font-semibold mb-1">Time:</label>
                  <input name="time" type="time" id="time" required class="w-full border border-gray-300 p-2 rounded focus:outline-none">
                </div>
                <div class=" flex flex-col flex-1">
                  <label class="font-semibold mb-1">Location:</label>
                  <input name="location" type="text" id="location" required class="w-full border border-gray-300 p-2 rounded focus:outline-none" placeholder="Enter Location">
                </div>
              </div>
            </div>

            <!-- Message -->
            <div class="flex flex-1 flex-col ">
              <label class="block font-semibold ">Message:</label>
              <textarea name="message" id="message" rows="5" required class="w-full h-full border border-gray-300 p-2 rounded focus:outline-none" placeholder="Enter announcement message"></textarea>
            </div>
          </div>

          <!-- Buttons -->
          <div class="mt-4 flex justify-end gap-3">
            <button type="button" id="clearBtn" class="bg-red-500 text-white px-8 py-1 rounded hover:bg-red-600">Clear</button>
            <button type="submit" id="saveBtn" class="bg-green-500 text-white px-8 py-1 rounded hover:bg-green-600">Save</button>
          </div>
        </form>

        <h2 class="text-xl font-semibold mt-6 sm:mt-0 mb-4">Announcement List</h2>
        <div id="announcementList" class="space-y-2 overflow-y-auto max-h-60">
          <!-- dislay message if no announcement yet -->
          <?php if (empty($data['announcement'])): ?>
            <p class="text-left text-gray-400">No announcement yet</p>
          <?php else: ?>
            <?php foreach ($data['announcement'] as $announcement): ?>
              <!-- Dynamic list will be rendered here -->
              <div class="bg-gray-300 p-3 flex justify-between items-center rounded mb-2">
                <div>
                  <span class="font-bold text-lg"><?= htmlspecialchars($announcement['title']) ?></span>
                  <p class="text-sm text-gray-600">
                    <?= date('M j, Y', strtotime($announcement['date'])) ?>
                  </p>
                </div>
                <div class="flex gap-3">
                  <div class="flex gap-3">
                    <button
                      type="button"
                      class="editBtn bg-neutral-100 p-2 rounded"
                      data-id="<?= $announcement['id'] ?>"
                      data-title="<?= htmlspecialchars($announcement['title']) ?>"
                      data-to="<?= htmlspecialchars($announcement['to_whom']) ?>"
                      data-date="<?= $announcement['date'] ?>"
                      data-time="<?= $announcement['time'] ?>"
                      data-location="<?= htmlspecialchars($announcement['location']) ?>"
                      data-message="<?= htmlspecialchars($announcement['message']) ?>">
                      <img src="<?php echo URL_ROOT; ?>/images/icons/pencil.png" alt="Edit" class="h-5 w-5">
                    </button>

                    <button
                      type="button"
                      class="deleteBtn bg-neutral-100 p-2 rounded"
                      data-id="<?= $announcement['id'] ?>"
                      data-title="<?= htmlspecialchars($announcement['title']) ?>">
                      <img src="<?php echo URL_ROOT; ?>/images/icons/delete.png" alt="Delete" class="h-5 w-5">
                    </button>
                  </div>

                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
      </section>
    </main>
  </div>

  <!-- Confirmation / Message Modal -->
  <div id="modalOverlay" class="hidden fixed inset-0 bg-opacity-50 z-50 transition-none" style="transition: none !important; animation: none !important;">
    <div class="h-full w-full flex items-center justify-center">
      <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-md p-6">
        <h3 id="modalTitle" class="text-lg font-semibold mb-2">Confirm Delete</h3>
        <p id="modalMessage" class="text-sm text-gray-700 mb-4">Are you sure you want to delete this annoucement?</p>
        <div class="flex justify-end gap-3">
          <button id="modalCancel" class="hidden bg-gray-200 text-gray-800 px-4 py-1 rounded hover:bg-gray-300">Cancel</button>
          <button id="modalConfirm" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Script -->
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

    //flash message
    const flashMessage = document.getElementById('flash-message');
    if (flashMessage) {
      setTimeout(() => {
        flashMessage.classList.add('flash-hide');
        setTimeout(() => flashMessage.remove(), 800);
      }, 3000);
    }

    // for deletion and updating announcement
    document.addEventListener("DOMContentLoaded", function() {
      const form = document.querySelector("form");
      const saveBtn = document.getElementById("saveBtn");
      const clearBtn = document.getElementById("clearBtn");

      const modalOverlay = document.getElementById("modalOverlay");
      const modalConfirm = document.getElementById("modalConfirm");
      const modalCancel = document.getElementById("modalCancel");
      const modalMessage = document.getElementById("modalMessage");

      let deleteId = null;

      // Handle Edit Button
      document.querySelectorAll(".editBtn").forEach(btn => {
        btn.addEventListener("click", function() {
          document.getElementById("announcement_id").value = this.dataset.id;
          document.getElementById("title").value = this.dataset.title;
          document.getElementById("to").value = this.dataset.to;
          document.getElementById("date").value = this.dataset.date;
          document.getElementById("time").value = this.dataset.time;
          document.getElementById("location").value = this.dataset.location;
          document.getElementById("message").value = this.dataset.message;

          form.action = "<?php echo URL_ROOT; ?>/admin/updateAnnouncement";
          saveBtn.textContent = "Update";
        });
      });

      // Handle Clear Button
      clearBtn.addEventListener("click", function() {
        form.reset();
        document.getElementById("announcement_id").value = "";
        form.action = "<?php echo URL_ROOT; ?>/admin/createAnnouncement";
        saveBtn.textContent = "Save";
      });

      // Handle Delete Button
      document.querySelectorAll(".deleteBtn").forEach(btn => {
        btn.addEventListener("click", function() {
          deleteId = this.dataset.id;
          const title = this.dataset.title;
          modalMessage.textContent = `Are you sure you want to delete "${title}"?`;
          modalOverlay.classList.remove("hidden");
          modalCancel.classList.remove("hidden");
        });
      });

      modalCancel.addEventListener("click", function() {
        modalOverlay.classList.add("hidden");
      });

      modalConfirm.addEventListener("click", function() {
        if (deleteId) {
          window.location.href = "<?php echo URL_ROOT; ?>/admin/deleteAnnouncement/" + deleteId;
        }
      });
    });
  </script>

</body>

</html>