<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="<?php echo URL_ROOT; ?>/css/output.css" rel="stylesheet">
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</head>

<body class="font-[sans-serif] bg-gradient-to-r from-green-100 via-emerald-200 to-green-500 h-full w-full">
    <header class="bg-white w-full">
        <nav class="flex justify-between items-center w-[92%] mx-auto">
            <div>
                <img class="w-27 cursor-pointer " src="<?php echo URL_ROOT; ?>/images/WasteWise.png" alt="...">
            </div>
            <div class="nav-links duration-500 md:static absolute bg-white md:min-h-fit min-h-[38vh] left-0 top-[-100%] md:w-auto z-1 w-full flex items-center px-5">
                <ul class="w-full flex items-center justify-center md:flex-row flex-col md:text-md md:h-full md:items-center md:gap-[2vw] gap-8 font-bold">
                    <li>
                        <a class="hover:text-green-500" href="<?php echo URL_ROOT; ?>">HOME</a>
                    </li>
                    <li>
                        <a class="hover:text-green-500" href="<?php echo URL_ROOT; ?>/about">ABOUT</a>
                    </li>
                    <li>
                        <a class="hover:text-green-500" href="<?php echo URL_ROOT; ?>/contact">CONTACT</a>
                    </li>
                    <li>
                        <a class="hover:text-green-500" href="<?php echo URL_ROOT; ?>/announcement">ANNOUNCEMENT</a>
                    </li>
                    <li class="relative">
                        <button onclick="toggleDropdown()" class="hover:text-green-500 cursor-pointer flex items-center gap-1 font-bold">
                            REPORT
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.23 8.29a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="reportDropdown" class="absolute hidden bg-white shadow-lg mt-2 rounded w-44 z-20 text-sm">
                            <a href="<?php echo URL_ROOT; ?>/report/waste" class="block px-4 py-2 hover:bg-green-100 text-black">Report Waste</a>
                            <a href="<?php echo URL_ROOT; ?>/report/litterer" class="block px-4 py-2 hover:bg-green-100 text-black">Report Litterer</a>
                        </div>
                    </li>
                </ul>
            </div>
           <div class="flex items-center gap-3">
                <div class="relative">
                    <ion-icon name="notifications-outline" class="text-3xl cursor-pointer hover:text-green-500 transition-colors" onclick="openNotificationModal()"></ion-icon>
                    <div id="notificationBadge" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-white text-xs flex items-center justify-center font-bold">3</div>
                </div>
                <div class="relative">
                    <img src="<?php echo URL_ROOT . '/' . htmlspecialchars($data['user']['profile_picture'] ?? 'images/profile.png'); ?>"
                        alt="Profile"
                        class="w-10 h-10 rounded-full cursor-pointer border-2 border-gray-300 hover:border-green-500 transition-colors"
                        onclick="openProfileModal()">
                </div>
                <ion-icon onclick="onToggleMenu(this)" name="menu" class="text-3xl cursor-pointer md:hidden z-10"></ion-icon>
            </div>
            <div class="hidden flex items-center gap-6">
                <button id="signInBtn" class="bg-green-500 md:shadow-lg text-md px-2 py-1 text-white rounded hover:bg-green-600">Sign in</button>
                <ion-icon onclick="onToggleMenu(this)" name="menu" class="text-3xl cursor-pointer md:hidden z-1"></ion-icon>
            </div>
        </nav>
    </header>

    <!-- ANNOUNCEMENT CONTENT -->

    <main class="flex justify-center  w-full ">
        <div class="container flex flex-col justify-center items-center px-6 gap-10 py-6 mb-4">
            <div class="flex justify-center items-center mt-4 gap-5 mb-0 sm:mb-2 ">
                <h1 class="text-3xl sm:text-5xl lg:text-4xl font-bold ">Announcement</h1>
            </div>

            <div class="bg-gray-50 flex flex-col w-full sm:max-w-150 md:max-w-180 lg:max-w-200  p-4 gap-3 rounded-xl shadow-2xl">
                <div class="flex flex-col ">
                    <div class="flex items-center gap-2 ">
                        <span class="text-green-500 text-lg">📢</span>
                        <span>To: All Senior Citizen</span>
                    </div>
                    <div class="flex items-center gap-2  text-wrap">
                        <span class="text-green-500 text-lg">🗓️</span>
                        <span>Date: Sunday April 29, 2025</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-green-500 text-lg">⏰</span>
                        <span>Time: 10:00 AM</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-green-500 text-lg">📍</span>
                        <span>Location: Barangay Hall</span>
                    </div>
                </div>
                <div class="flex flex-col p-6 gap-4 bg-gray-300 rounded-lg">
                    <h1 class="font-bold">Dear senior citizens of Barangay Tapilon, </h1>
                    <div>
                        You are cordially invited to attend a community meeting scheduled for this coming Sunday. 
                        The agenda will include updates on government assistance programs, healthcare services, and other matters 
                        relevant to your welfare. Your participation and insights are highly valued, and we look forward to your presence.
                    </div>
                </div>


            </div>
            <div class="bg-gray-50 flex flex-col w-full sm:max-w-150 md:max-w-180 lg:max-w-200 p-4 gap-3 rounded-xl shadow-2xl">
                <div class="flex flex-col ">
                    <div class="flex items-center gap-2 ">
                        <span class="text-green-500 text-lg">📢</span>
                        <span>To: All Senior Citizen</span>
                    </div>
                    <div class="flex items-center gap-2  text-wrap">
                        <span class="text-green-500 text-lg">🗓️</span>
                        <span>Date: Sunday April 29, 2025</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-green-500 text-lg">⏰</span>
                        <span>Time: 10:00 AM</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-green-500 text-lg">📍</span>
                        <span>Location: Barangay Hall</span>
                    </div>
                </div>
                <div class="flex flex-col p-6 gap-4 bg-gray-300 rounded-lg">
                    <h1 class="font-bold">Dear senior citizens of Barangay Tapilon, </h1>
                    <div>
                        You are cordially invited to attend a community meeting scheduled for this coming Sunday. 
                        The agenda will include updates on government assistance programs, healthcare services, and other matters 
                        relevant to your welfare. Your participation and insights are highly valued, and we look forward to your presence.
                    </div>
                </div>


            </div>
            <div class="bg-gray-50 flex flex-col w-full sm:max-w-150 md:max-w-180 lg:max-w-200 p-4 gap-3 rounded-xl shadow-2xl">
                <div class="flex flex-col ">
                    <div class="flex items-center gap-2 ">
                        <span class="text-green-500 text-lg">📢</span>
                        <span>To: All Senior Citizen</span>
                    </div>
                    <div class="flex items-center gap-2  text-wrap">
                        <span class="text-green-500 text-lg">🗓️</span>
                        <span>Date: Sunday April 29, 2025</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-green-500 text-lg">⏰</span>
                        <span>Time: 10:00 AM</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-green-500 text-lg">📍</span>
                        <span>Location: Barangay Hall</span>
                    </div>
                </div>
                <div class="flex flex-col p-6 gap-4 bg-gray-300 rounded-lg">
                    <h1 class="font-bold">Dear senior citizens of Barangay Tapilon, </h1>
                    <div>
                        You are cordially invited to attend a community meeting scheduled for this coming Sunday. 
                        The agenda will include updates on government assistance programs, healthcare services, and other matters 
                        relevant to your welfare. Your participation and insights are highly valued, and we look forward to your presence.
                    </div>
                </div>


            </div>
            <div class="bg-gray-50 flex flex-col w-full sm:max-w-150 md:max-w-180 lg:max-w-200 p-4 gap-3 rounded-xl shadow-2xl">
                <div class="flex flex-col ">
                    <div class="flex items-center gap-2 ">
                        <span class="text-green-500 text-lg">📢</span>
                        <span>To: All Senior Citizen</span>
                    </div>
                    <div class="flex items-center gap-2  text-wrap">
                        <span class="text-green-500 text-lg">🗓️</span>
                        <span>Date: Sunday April 29, 2025</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-green-500 text-lg">⏰</span>
                        <span>Time: 10:00 AM</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-green-500 text-lg">📍</span>
                        <span>Location: Barangay Hall</span>
                    </div>
                </div>
                <div class="flex flex-col p-6 gap-4 bg-gray-300 rounded-lg">
                    <h1 class="font-bold">Dear senior citizens of Barangay Tapilon, </h1>
                    <div>
                        You are cordially invited to attend a community meeting scheduled for this coming Sunday. 
                        The agenda will include updates on government assistance programs, healthcare services, and other matters 
                        relevant to your welfare. Your participation and insights are highly valued, and we look forward to your presence.
                    </div>
                </div>


            </div>
        </div>
        
    
    </main>
    
    <footer class="text-gray bg-green-50 py-2">
        <h1 class="text-center text-xs">&copyWasteWise 2025 All Rights Reserved</h1>
    </footer>

    <script src="<?php echo URL_ROOT; ?>/js/auth.js"></script>
    <script>
        // Modern JavaScript for dropdown functionality
        function toggleDropdown() {
            const dropdown = document.getElementById("reportDropdown");
            dropdown.classList.toggle("hidden");
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById("reportDropdown");
            const button = event.target.closest('button[onclick="toggleDropdown()"]');

            // If click is not on the dropdown button, close the dropdown
            if (!button && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add("hidden");
            }
        });
    </script>
</body>

</html>