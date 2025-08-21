<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barangay Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Dark mode overrides (class-based) */
    body.dark { background: #071218 !important; color: #dff7ea; }
    body.dark .bg-green-100 { background-color: #0e2a21 !important; }
    body.dark .bg-green-50 { background-color: #072015 !important; }
    body.dark .bg-gradient-to-br { background: linear-gradient(135deg,#07221a,#0a2431) !important; }
    body.dark input, body.dark textarea { background-color: #0f2b22 !important; color: #e6f7ee !important; border-color: #234 !important; }
    body.dark .text-gray-600 { color: #9fcfb6 !important; }
    body.dark .svgIcon { filter: brightness(0.9) saturate(0.6); }
  </style>
</head>
<body class="bg-green-100 font-sans flex flex-col min-h-screen">
  <div class="flex flex-grow">

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
            <a href="Litterers-record.html" class="nav-btn flex items-center text-sm gap-3 hover:bg-gray-300 p-2 rounded-lg">
              <img class="size-5" src="images/litterer-icon.png" alt=""> Litterers Records
            </a>
          </li>
          <li>
            <a href="settings.html" class="nav-btn flex items-center text-sm gap-3 bg-gray-400 p-2 rounded-lg">
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

                <div class="flex gap-4">
                    
                    <label class="flex items-center relative">
                        <input class="peer hidden" id="toggle" type="checkbox" />
                        <div
                            class="relative w-[70px] h-[30px] bg-white peer-checked:bg-zinc-500 rounded-full after:absolute after:content-[''] after:w-[20px] after:h-[20px] after:bg-gradient-to-r from-orange-500 to-yellow-400 peer-checked:after:from-zinc-900 peer-checked:after:to-zinc-900 after:rounded-full after:top-[5px] after:left-[8px] active:after:w-[50px] peer-checked:after:left-[62px] peer-checked:after:translate-x-[-100%] shadow-sm duration-300 after:duration-300 after:shadow-md"
                        ></div>
                        <svg
                            height="0"
                            width="100"
                            viewBox="0 0 24 24"
                            data-name="Layer 1"
                            id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg"
                            class="fill-white peer-checked:opacity-60 absolute w-6 h-3 left-[6px]"
                        >
                            <path
                            d="M12,17c-2.76,0-5-2.24-5-5s2.24-5,5-5,5,2.24,5,5-2.24,5-5,5ZM13,0h-2V5h2V0Zm0,19h-2v5h2v-5ZM5,11H0v2H5v-2Zm19,0h-5v2h5v-2Zm-2.81-6.78l-1.41-1.41-3.54,3.54,1.41,1.41,3.54-3.54ZM7.76,17.66l-1.41-1.41-3.54,3.54,1.41,1.41,3.54-3.54Zm0-11.31l-3.54-3.54-1.41,1.41,3.54,3.54,1.41-1.41Zm13.44,13.44l-3.54-3.54-1.41,1.41,3.54,3.54,1.41-1.41Z"
                            ></path>
                        </svg>
                        <svg
                            height="512"
                            width="512"
                            viewBox="0 0 24 24"
                            data-name="Layer 1"
                            id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg"
                            class="fill-black opacity-60 peer-checked:opacity-70 peer-checked:fill-white absolute w-6 h-3 right-[6px]"
                        >
                            <path
                            d="M12.009,24A12.067,12.067,0,0,1,.075,10.725,12.121,12.121,0,0,1,10.1.152a13,13,0,0,1,5.03.206,2.5,2.5,0,0,1,1.8,1.8,2.47,2.47,0,0,1-.7,2.425c-4.559,4.168-4.165,10.645.807,14.412h0a2.5,2.5,0,0,1-.7,4.319A13.875,13.875,0,0,1,12.009,24Zm.074-22a10.776,10.776,0,0,0-1.675.127,10.1,10.1,0,0,0-8.344,8.8A9.928,9.928,0,0,0,4.581,18.7a10.473,10.473,0,0,0,11.093,2.734.5.5,0,0,0,.138-.856h0C9.883,16.1,9.417,8.087,14.865,3.124a.459.459,0,0,0,.127-.465.491.491,0,0,0-.356-.362A10.68,10.68,0,0,0,12.083,2ZM20.5,12a1,1,0,0,1-.97-.757l-.358-1.43L17.74,9.428a1,1,0,0,1,.035-1.94l1.4-.325.351-1.406a1,1,0,0,1,1.94,0l.355,1.418,1.418.355a1,1,0,0,1,0,1.94l-1.418.355-.355,1.418A1,1,0,0,1,20.5,12ZM16,14a1,1,0,0,0,2,0A1,1,0,0,0,16,14Zm6,4a1,1,0,0,0,2,0A1,1,0,0,0,22,18Z"
                            ></path>
                        </svg>
                    </label>

                    <button class="Btn flex flex-col bg-green-400 hover:bg-green-500 py-2 px-5 rounded-md">
                        <svg class="svgIcon h-2.5 w-4" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg"><path d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8 224 64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"></path></svg>
                        <span class="icon2 w-30 h-1 border-b-2 border-r-2 border-l-2 border-black"></span>
                    </button>

                </div>

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
                <svg class="svgIcon h-3.5 w-4 -rotate-90" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg"><path d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8 224 64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"></path></svg>
                <span class="icon2 w-1 h-4 border-b-2 border-r-2 border-t-2 border-black"></span>
            </button>
          </div>
          

          <div class="flex flex-col justify-between">
                        
            <p class="font-semibold">Name</p>
            <input id="nameInput" type="text" value="Jerwin A. Noval" class="w-full border border-gray-300 rounded p-2 mt-1 text-md focus:outline-none" readonly>
                        
          </div>

          <div class="flex flex-col justify-between">
                        
            <p class="font-semibold">Address</p>
            <input id="addressInput" type="text" value="Magsumbay, Tapilon, Daanbantayan, Cebu" class="w-full border border-gray-300 rounded p-2 mt-1 text-md focus:outline-none" readonly>
                        
          </div>

          <div class="flex flex-col justify-between">
                        
            <p class="font-semibold">Contact</p>
            <input id="contactInput" type="text" value="096521485692" class="w-full border border-gray-300 rounded p-2 mt-1 text-md focus:outline-none" readonly>
                        
          </div>

          <div class="flex flex-col justify-between">
                        
            <p class="font-semibold">Email Address</p>
            <input id="emailInput" type="text" value="jerwinnoval@gmail.com" class="w-full border border-gray-300 rounded p-2 mt-1 text-md focus:outline-none" readonly>
                        
          </div>

          
        </div>
            </div>

            
      </div>
        </div>
    </main>

    <!-- Modal Background for logout -->
  <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" style="display:none;">
    
    <!-- Modal Container for logout -->
    <div class="bg-[#e5f9e0] w-full max-w-xs rounded-lg shadow-lg relative p-4">
      
      <h1 class="font-bold text-xl mb-4">Confirm Logout</h1>

      <p>Are you sure you want to logout?</p>

      <div class="flex justify-end gap-2 mt-4">
  <button id="cancelLogoutBtn" class="hover:bg-gray-400 px-4 py-1 rounded-md">Cancel</button>
  <button id="confirmLogoutBtn" class="hover:bg-gray-400 px-4 py-1 rounded-md">OK</button>
      </div>
    </div>
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

    // Profile edit/update/save and persistence
    (function(){
      const editBtn = document.getElementById('editBtn');
      const updateBtn = document.getElementById('updateBtn');
      const saveBtn = document.getElementById('saveBtn');
      const nameInput = document.getElementById('nameInput');
      const addressInput = document.getElementById('addressInput');
      const contactInput = document.getElementById('contactInput');
      const emailInput = document.getElementById('emailInput');

      function setReadOnly(readonly) {
        [nameInput,addressInput,contactInput,emailInput].forEach(i=>{
          if (!i) return;
          i.readOnly = !!readonly;
          i.classList.toggle('bg-white', !readonly);
        });
      }

      function loadProfile(){
        try{
          const raw = localStorage.getItem('profile');
          if (!raw) return;
          const p = JSON.parse(raw);
          if (p.name) nameInput.value = p.name;
          if (p.address) addressInput.value = p.address;
          if (p.contact) contactInput.value = p.contact;
          if (p.email) emailInput.value = p.email;
        }catch(e){/* ignore */}
      }

      function saveProfile(){
        const p = { name: nameInput.value, address: addressInput.value, contact: contactInput.value, email: emailInput.value };
        localStorage.setItem('profile', JSON.stringify(p));
      }

      loadProfile();
      setReadOnly(true);

      if (editBtn) editBtn.addEventListener('click', ()=>{
        setReadOnly(false);
        editBtn.classList.add('hidden');
        updateBtn.classList.remove('hidden');
        saveBtn.classList.remove('hidden');
      });

      if (updateBtn) updateBtn.addEventListener('click', ()=>{
        // Cancel edits: reload profile values and exit edit mode
        loadProfile();
        setReadOnly(true);
        editBtn.classList.remove('hidden');
        updateBtn.classList.add('hidden');
        saveBtn.classList.add('hidden');
      });

      if (saveBtn) saveBtn.addEventListener('click', ()=>{
        saveProfile();
        setReadOnly(true);
        editBtn.classList.remove('hidden');
        updateBtn.classList.add('hidden');
        saveBtn.classList.add('hidden');
      });
    })();

    // Dark toggle (checkbox #toggle)
    (function(){
      const darkToggleCheckbox = document.getElementById('toggle');
      function applyDark(enabled){
        document.body.classList.toggle('dark', enabled);
        try{ localStorage.setItem('darkMode', enabled ? 'true' : 'false'); }catch(e){}
      }
      // init
      const stored = localStorage.getItem('darkMode');
      if (stored === 'true') {
        applyDark(true);
        if (darkToggleCheckbox) darkToggleCheckbox.checked = true;
      }
      if (darkToggleCheckbox) darkToggleCheckbox.addEventListener('change', (e)=>{
        applyDark(!!e.target.checked);
      });
    })();

    // Logout modal handlers
    (function(){
      const logoutBtn = document.getElementById('logoutBtn');
      const overlay = document.getElementById('logoutModal');
      const cancelBtn = document.getElementById('cancelLogoutBtn');
      const confirmBtn = document.getElementById('confirmLogoutBtn');

      function showLogoutModal(){ if (overlay) overlay.style.display = 'flex'; }
      function hideLogoutModal(){ if (overlay) overlay.style.display = 'none'; }

      if (logoutBtn) logoutBtn.addEventListener('click', (e)=>{ e.preventDefault(); showLogoutModal(); });
      if (cancelBtn) cancelBtn.addEventListener('click', hideLogoutModal);
      if (confirmBtn) confirmBtn.addEventListener('click', ()=>{ hideLogoutModal(); /* add logout logic here */ });

      // close when clicking on overlay background
      if (overlay) overlay.addEventListener('click', (e)=>{ if (e.target === overlay) hideLogoutModal(); });

      // close on Escape
      document.addEventListener('keydown', (e)=>{ if (e.key === 'Escape') hideLogoutModal(); });
    })();
  </script>
</body>
</html>
