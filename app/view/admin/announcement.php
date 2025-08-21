<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barangay Admin - Announcement</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class=" font-sans">

  <!-- Container -->
  <div class="flex min-h-screen">

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
            <a href="announcement.html" class="nav-btn flex items-center text-sm gap-3 bg-gray-400 p-2 rounded-lg">
              <img class="size-5" src="images/announcement-icon.png" alt=""> Announcement
            </a>
          </li>
          <li>
            <a href="Litterers-record.html" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
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
      <section class=" bg-green-50 p-4 sm:p-6 rounded-lg shadow-md max-h-[calc(100vh-100px)] overflow-y-auto">
        <h2 class="text-xl font-semibold mb-4">Announcement</h2>
		<form action="" >
			<div class="flex flex-col sm:flex-row gap-2 sm:gap-4 ">
				<div class="flex flex-1 flex-col gap-2">
					<div class="">
						<label class="font-semibold mb-1">Title:</label>
						<input type="text" id="title" required class="w-full border border-gray-300 p-2 rounded focus:outline-none" placeholder="Enter title">
					</div>
					<div class="flex w-full flex-col md:flex-row gap-2 sm:gap-4">
						<div class=" flex flex-col flex-1">
							<label class="font-semibold mb-1">To:</label>
							<input type="text" id="to" required class="w-full border border-gray-300 p-2 rounded focus:outline-none" placeholder="">
						</div>
						<div class=" flex flex-col flex-1">
							<label class="font-semibold mb-1">Date:</label>
							<input type="date" id="date" required class="w-full border border-gray-300 p-2 rounded focus:outline-none">
						</div>
					</div>
					<div class="flex flex-col md:flex-row w-full  gap-2 sm:gap-4">
						<div class=" flex flex-col flex-1">
							<label class="font-semibold mb-1">Time:</label>
							<input type="time" id="time" required class="w-full border border-gray-300 p-2 rounded focus:outline-none" >
						</div>
						<div class=" flex flex-col flex-1">
							<label class="font-semibold mb-1">Location:</label>
							<input type="text" id="location" required class="w-full border border-gray-300 p-2 rounded focus:outline-none" placeholder="Enter Location">
						</div>
					</div>
				</div>

				<!-- Message -->
				<div class="flex flex-1 flex-col ">
					<label class="block font-semibold ">Message:</label>
					<textarea id="message" rows="5" required class="w-full h-full border border-gray-300 p-2 rounded focus:outline-none" placeholder="Enter announcement message"></textarea>
				</div>
			</div>

			<!-- Buttons -->
			<div class="mt-4 flex justify-end gap-3">
				<button type="button" id="clearBtn" class="bg-red-500 text-white px-8 py-1 rounded hover:bg-red-600">Clear</button>
				<button type="button" id="saveBtn" class="bg-green-500 text-white px-8 py-1 rounded hover:bg-green-600">Save</button>
			</div>
		</form>

        <h2 class="text-xl font-semibold mt-6 sm:mt-0 mb-4">Announcement List</h2>
        <div id="announcementList" class="space-y-2 overflow-y-auto max-h-60">
          <!-- Dynamic list will be rendered here -->
        </div>
      </section>
    </main>
  </div>

  <!-- Confirmation / Message Modal -->
  <div id="modalOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 transition-none" style="transition: none !important; animation: none !important;">
    <div class="h-full w-full flex items-center justify-center">
      <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-md p-6">
        <h3 id="modalTitle" class="text-lg font-semibold mb-2">Confirm</h3>
        <p id="modalMessage" class="text-sm text-gray-700 mb-4">Are you sure?</p>
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

  // Announcement CRUD using localStorage
  (function () {
      const key = 'announcements';
      const titleEl = document.getElementById('title');
      const toEl = document.getElementById('to');
      const dateEl = document.getElementById('date');
      const timeEl = document.getElementById('time');
      const locationEl = document.getElementById('location');
      const messageEl = document.getElementById('message');
      const saveBtn = document.getElementById('saveBtn');
      const clearBtn = document.getElementById('clearBtn');
      const listEl = document.getElementById('announcementList');

      let editId = null;

      function getAnnouncements() {
        try {
          return JSON.parse(localStorage.getItem(key) || '[]');
        } catch (e) {
          return [];
        }
      }

      function saveAnnouncements(arr) {
        localStorage.setItem(key, JSON.stringify(arr));
      }

      function clearForm() {
        titleEl.value = '';
        toEl.value = '';
        dateEl.value = '';
        timeEl.value = '';
        locationEl.value = '';
        messageEl.value = '';
        editId = null;
        saveBtn.textContent = 'Save';
      }

      // Modal helpers
      const modalOverlay = document.getElementById('modalOverlay');
      const modalTitle = document.getElementById('modalTitle');
      const modalMessage = document.getElementById('modalMessage');
  const modalCancel = document.getElementById('modalCancel');
  const modalConfirm = document.getElementById('modalConfirm');

      function showModal(title, message, confirmText = 'OK', showCancel = false) {
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        modalConfirm.textContent = confirmText;
        if (showCancel) {
          modalCancel.classList.remove('hidden');
        } else {
          modalCancel.classList.add('hidden');
        }
        modalOverlay.classList.remove('hidden');
      }

      function hideModal() {
        modalOverlay.classList.add('hidden');
      }

      function showConfirm(title, message, confirmText = 'Delete') {
        return new Promise(resolve => {
          showModal(title, message, confirmText, true);
          function onConfirm() {
            cleanup();
            resolve(true);
          }
          function onCancel() {
            cleanup();
            resolve(false);
          }
          function onOutside(e) {
            // close when clicking outside the modal content
            if (e.target === modalOverlay) {
              cleanup();
              resolve(false);
            }
          }
          function onKey(e) {
            if (e.key === 'Escape') {
              cleanup();
              resolve(false);
            }
          }
          function cleanup() {
            modalConfirm.removeEventListener('click', onConfirm);
            modalCancel.removeEventListener('click', onCancel);
            modalOverlay.removeEventListener('click', onOutside);
            document.removeEventListener('keydown', onKey);
            hideModal();
          }
          modalConfirm.addEventListener('click', onConfirm, { once: true });
          modalCancel.addEventListener('click', onCancel, { once: true });
          modalOverlay.addEventListener('click', onOutside);
          document.addEventListener('keydown', onKey);
        });
      }

      function renderAnnouncements() {
        const items = getAnnouncements();
        listEl.innerHTML = '';
        if (!items.length) {
          const empty = document.createElement('div');
          empty.className = 'text-gray-600';
          empty.textContent = 'No announcements yet.';
          listEl.appendChild(empty);
          return;
        }

        // helper to add 12 hours to HH:MM string
        function add12Hours(timeStr) {
          if (!timeStr) return '';
          const parts = timeStr.split(':');
          if (parts.length < 2) return timeStr;
          let hh = parseInt(parts[0], 10);
          const mm = parts[1];
          if (Number.isNaN(hh)) return timeStr;
          hh = (hh + 12) % 24;
          return String(hh).padStart(2, '0') + ':' + mm;
        }

        items.slice().reverse().forEach(item => {
          const row = document.createElement('div');
          row.className = 'bg-gray-200 p-3 rounded flex justify-between items-center shadow';

          const left = document.createElement('div');
          left.className = 'flex flex-col';
          const titleSpan = document.createElement('span');
          titleSpan.className = 'font-semibold';
          titleSpan.textContent = item.title || '(no title)';
          left.appendChild(titleSpan);
          const meta = document.createElement('small');
          meta.className = 'text-sm text-gray-700';
          const parts = [];
          if (item.date) parts.push(item.date);
          if (item.time) parts.push(add12Hours(item.time));
          meta.textContent = parts.join(' • ');
          left.appendChild(meta);

          const right = document.createElement('div');
          right.className = 'flex gap-2 items-center';

          const editBtn = document.createElement('button');
          editBtn.className = 'text-gray-500 hover:text-blue-500';
          editBtn.title = 'Edit';
          editBtn.innerText = '✏️';
          editBtn.addEventListener('click', () => onEdit(item.id));

          const delBtn = document.createElement('button');
          delBtn.className = 'text-gray-500 hover:text-red-500';
          delBtn.title = 'Delete';
          delBtn.innerText = '🗑️';
          delBtn.addEventListener('click', () => onDelete(item.id));

          right.appendChild(editBtn);
          right.appendChild(delBtn);

          row.appendChild(left);
          row.appendChild(right);
          listEl.appendChild(row);
        });
      }

      function onSave() {
        const title = titleEl.value.trim();
        const to = toEl.value.trim();
        const date = dateEl.value;
        const time = timeEl.value;
        const location = locationEl.value.trim();
        const message = messageEl.value.trim();

        const fields = [
          { name: 'Title', value: title, el: titleEl },
          { name: 'To', value: to, el: toEl },
          { name: 'Date', value: date, el: dateEl },
          { name: 'Time', value: time, el: timeEl },
          { name: 'Location', value: location, el: locationEl },
          { name: 'Message', value: message, el: messageEl }
        ];

        const missing = fields.filter(f => !f.value).map(f => f.name);
        if (missing.length) {
          const firstMissingEl = fields.find(f => !f.value).el;
          showModal('Missing fields', 'Please fill: ' + missing.join(', '), 'OK');
          modalConfirm.addEventListener('click', () => {
            hideModal();
            try { firstMissingEl.focus(); } catch (e) {}
          }, { once: true });
          return;
        }

        const items = getAnnouncements();
        if (editId) {
          const idx = items.findIndex(i => i.id === editId);
          if (idx !== -1) {
            items[idx] = { id: editId, title, to, date, time, location, message };
          }
        } else {
          const id = Date.now().toString();
          items.push({ id, title, to, date, time, location, message });
        }

        saveAnnouncements(items);
        renderAnnouncements();
        clearForm();
      }

      function onEdit(id) {
        const items = getAnnouncements();
        const item = items.find(i => i.id === id);
        if (!item) return;
        titleEl.value = item.title || '';
        toEl.value = item.to || '';
        dateEl.value = item.date || '';
        timeEl.value = item.time || '';
        locationEl.value = item.location || '';
        messageEl.value = item.message || '';
        editId = id;
        saveBtn.textContent = 'Update';
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }

      async function onDelete(id) {
        const ok = await showConfirm('Delete announcement', 'Delete this announcement? This action cannot be undone.', 'Delete');
        if (!ok) return;
        const items = getAnnouncements().filter(i => i.id !== id);
        saveAnnouncements(items);
        renderAnnouncements();
        // if we were editing the deleted item, clear form
        if (editId === id) clearForm();
      }

      // wire events
      saveBtn.addEventListener('click', onSave);
      clearBtn.addEventListener('click', clearForm);

      // initial render
      renderAnnouncements();
    })();
  </script>

</body>
</html>
