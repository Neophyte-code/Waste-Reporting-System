<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barangay Admin ViewReports</title>
  <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/output.css">
</head>
<style>
  @keyframes slideInRight {
    from {
      transform: translateX(100%);
      opacity: 0;
    }

    to {
      transform: translateX(0);
      opacity: 1;
    }
  }

  .toast {
    position: fixed;
    top: 1rem;
    right: 1rem;
    padding: 0.75rem 1.25rem;
    border-radius: 0.375rem;
    color: white;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    animation: slideInRight 0.4s ease forwards;
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
                    <td class="text-base py-2 px-4">
                      <?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?>
                      <dl class="lg:hidden gap-1">
                        <dt class="sr-only">Email Address</dt>
                        <dd class="md:hidden text-sm text-gray-500"><?= htmlspecialchars($user['email']) ?></dd>
                      </dl>
                    </td>
                    <td class="hidden md:table-cell p-2.5 text-blue-600"><?= htmlspecialchars($user['email']) ?></td>
                    <td class="p-3 flex gap-2 justify-center">
                      <?php if ($user['status'] === 'pending'): ?>
                        <button
                          class="bg-gray-300 hover:bg-green-300 text-white px-3 py-1 rounded verify-btn"
                          data-id="<?= htmlspecialchars($user['id']) ?>"
                          data-firstname="<?= htmlspecialchars($user['firstname']) ?>"
                          data-lastname="<?= htmlspecialchars($user['lastname']) ?>"
                          data-email="<?= htmlspecialchars($user['email']) ?>"
                          data-front="<?= URL_ROOT . '/' . htmlspecialchars($user['id_front']) ?>"
                          data-back="<?= URL_ROOT . '/' . htmlspecialchars($user['id_back']) ?>">
                          <img src="<?php echo URL_ROOT; ?>/images/icons/check.png" alt="verify" class="h-5 w-5">
                        </button>
                      <?php endif; ?>
                      <button
                        class="bg-gray-300 hover:bg-red-300 text-white px-3 py-1 rounded delete-btn"
                        data-user-id="<?= htmlspecialchars($user['id']) ?>">
                        <img src="<?php echo URL_ROOT; ?>/images/icons/delete.png" alt="delete" class="h-5 w-5">
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
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

  <!-- Verify Modal -->
  <div id="verifyModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
      <h2 class="text-xl font-bold text-green-700 mb-4 text-center">Verify User</h2>

      <div class="space-y-2 text-sm">
        <p><strong>First Name:</strong> <span id="modalFirstName"></span></p>
        <p><strong>Last Name:</strong> <span id="modalLastName"></span></p>
        <p><strong>Email:</strong> <span id="modalEmail"></span></p>

        <div class="grid grid-cols-2 gap-4 mt-4">
          <div>
            <p class="font-medium text-green-700 text-center mb-1">Front ID</p>
            <img id="modalFront" src="" alt="Front ID" class="w-full h-40 object-cover rounded border border-gray-300">
          </div>
          <div>
            <p class="font-medium text-green-700 text-center mb-1">Back ID</p>
            <img id="modalBack" src="" alt="Back ID" class="w-full h-40 object-cover rounded border border-gray-300">
          </div>
        </div>
      </div>

      <div class="mt-6 flex justify-center gap-2">
        <button id="closeModal" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
        <button id="approveBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Approve</button>
      </div>
    </div>
  </div>

  <!--Image Preview Modal -->
  <div id="imagePreviewModal"
    class="fixed inset-0 hidden z-[60] flex items-center justify-center">
    <img id="previewImage" src="" alt="Preview"
      class="max-h-[90vh] max-w-[90vw] rounded-lg shadow-2xl border-4 border-white">
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

    // script for approving the user account (status = active)
    document.addEventListener('DOMContentLoaded', () => {
      const modal = document.getElementById('verifyModal');
      const closeModal = document.getElementById('closeModal');
      const approveBtn = document.getElementById('approveBtn');
      const imagePreviewModal = document.getElementById('imagePreviewModal');
      const previewImage = document.getElementById('previewImage');

      // open verify modal
      document.querySelectorAll('.verify-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          document.getElementById('modalFirstName').textContent = btn.dataset.firstname;
          document.getElementById('modalLastName').textContent = btn.dataset.lastname;
          document.getElementById('modalEmail').textContent = btn.dataset.email;
          document.getElementById('modalFront').src = btn.dataset.front;
          document.getElementById('modalBack').src = btn.dataset.back;

          approveBtn.dataset.userId = btn.dataset.id;
          modal.classList.remove('hidden');
        });
      });

      // close modal when cancel button is click
      closeModal.addEventListener('click', () => modal.classList.add('hidden'));

      //close modal when outside is click
      modal.addEventListener('click', (e) => {
        if (e.target === modal) {
          modal.classList.add('hidden');
        }
      });

      approveBtn.addEventListener('click', () => {
        const userId = approveBtn.dataset.userId;
        fetch(`<?php echo URL_ROOT; ?>/admin/approveUser`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `user_id=${encodeURIComponent(userId)}`
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              const flash = document.createElement('div');
              flash.id = 'flash-message';
              flash.className = 'fixed top-4 right-4 transform bg-green-500 text-white px-4 py-2 rounded shadow-md z-50';
              flash.textContent = data.message || 'User approved successfully!';
              document.body.appendChild(flash);
              setTimeout(() => flash.remove(), 4000);

              // Hide modal and reload after a short delay
              modal.classList.add('hidden');
              setTimeout(() => location.reload(), 1500);
            } else {
              const flash = document.createElement('div');
              flash.id = 'flash-message';
              flash.className = 'fixed top-4 right-4 transform bg-red-500 text-white px-4 py-2 rounded shadow-md z-50';
              flash.textContent = data.message || 'Approval failed.';
              document.body.appendChild(flash);
              setTimeout(() => flash.remove(), 4000);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            const flash = document.createElement('div');
            flash.id = 'flash-message';
            flash.className = 'fixed top-4 right-4 transform bg-red-500 text-white px-4 py-2 rounded shadow-md z-50';
            flash.textContent = 'Network or server error.';
            document.body.appendChild(flash);
            setTimeout(() => flash.remove(), 4000);
          });
      });


      //Open the image preview for front ID
      document.getElementById('modalFront').addEventListener('click', () => {
        previewImage.src = document.getElementById('modalFront').src;
        imagePreviewModal.classList.remove('hidden');
      });

      //Open the image preview for back ID
      document.getElementById('modalBack').addEventListener('click', () => {
        previewImage.src = document.getElementById('modalBack').src;
        imagePreviewModal.classList.remove('hidden');
      });

      // close image preview when click outside
      imagePreviewModal.addEventListener('click', (e) => {
        if (e.target === imagePreviewModal) {
          imagePreviewModal.classList.add('hidden');
        }
      });
    });

    //script for user deletion
    document.addEventListener('DOMContentLoaded', () => {
      const deleteModal = document.getElementById('logoutModal');
      const cancelBtn = document.getElementById('cancelBtn');
      const confirmDeleteBtn = document.getElementById('deleteBtn');
      let selectedUserId = null;
      let selectedRow = null;

      // Open modal on delete click
      document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          selectedUserId = btn.dataset.userId;
          selectedRow = btn.closest('tr');
          deleteModal.style.display = 'flex';
        });
      });

      // Cancel delete
      cancelBtn.addEventListener('click', () => {
        deleteModal.style.display = 'none';
        selectedUserId = null;
      });

      // Click outside modal closes it
      deleteModal.addEventListener('click', (e) => {
        if (e.target === deleteModal) {
          deleteModal.style.display = 'none';
        }
      });

      // Confirm delete
      confirmDeleteBtn.addEventListener('click', () => {
        if (!selectedUserId) return;

        fetch(`<?php echo URL_ROOT; ?>/admin/deleteUser`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `user_id=${encodeURIComponent(selectedUserId)}`
          })
          .then(response => response.json())
          .then(data => {
            // Show toast
            const flash = document.createElement('div');
            flash.className = `toast ${data.success ? 'bg-green-500' : 'bg-red-500'}`;
            flash.textContent = data.message
            document.body.appendChild(flash);
            setTimeout(() => flash.remove(), 4000);


            // If success, remove row instantly
            if (data.success && selectedRow) {
              selectedRow.remove();
            }

            deleteModal.style.display = 'none';
          })
          .catch(() => {
            const flash = document.createElement('div');
            flash.className = 'toast bg-red-500';
            flash.textContent = 'Network or server error.';
            document.body.appendChild(flash);
            setTimeout(() => flash.remove(), 4000);
          });
      });
    });
  </script>
</body>

</html>