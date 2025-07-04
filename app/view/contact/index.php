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
                            <a href="<?php echo URL_ROOT; ?>/report/literrer" class="block px-4 py-2 hover:bg-green-100 text-black">Report Litterer</a>
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

    

    <!-- CONTACT CONTENT -->

    <main class="flex flex-col justify-center items-center min-h-full gap-4 px-4 pb-4">
    <!-- Header Section -->
    <div class=" container flex flex-col justify-center items-center pt-2 gap-3 text-center">
      <h1 class="text-4xl md:text-4xl font-extrabold">Get in Touch!</h1>
      <p class="text-base md:text-md font-thin max-w-2xl lg:max-w-4xl">WE ARE LOOKING FORWARD TO YOUR FEEDBACK TO HELP US KEEP THE ENVIRONMENT CLEAN AND SAFE.</p>
    </div>

    <!-- Contact Form + Info Container -->
    <div class=" flex flex-col lg:flex-row gap-6 w-full max-w-5xl sm:items-center lg:items-start">
      
        <!-- Contact Form -->
        <form class="flex-1 bg-white p-6 rounded-lg shadow-md space-y-4 sm:max-w-xl lg:px-6 ">
            <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label class="block text-sm font-bold pb-0.5 lg:text-lg text-black">First Name</label>
                <input type="text" placeholder="Enter first name" class="w-full border-2 border-green-400 rounded p-2 bg-gray-200" />
            </div>
            <div class="flex-1">
                <label class="block text-sm font-bold pb-0.5 lg:text-lg text-black">Last Name</label>
                <input type="text" placeholder="Enter last name" class="w-full border-2 border-green-400 rounded p-2 bg-gray-200" />
            </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label class="block text-sm font-bold pb-0.5 lg:text-lg text-black">Gmail</label>
                <input type="email" placeholder="example@gmail.com" class="w-full border-2 border-green-400 rounded p-2 bg-gray-200" />
            </div>
            <div class="flex-1">
                <label class="block text-sm font-bold pb-0.5 lg:text-lg text-black">Mobile Number</label>
                <input type="tel" placeholder="09123456789" class="w-full border-2 border-green-400 rounded p-2 bg-gray-200" />
            </div>
            </div>

            <div>
            <label class="block text-sm font-bold pb-0.5 lg:text-lg text-black">Message</label>
            <textarea placeholder="Type your message here" class="w-full border-2 border-green-400 rounded p-2 bg-gray-200 h-27 resize-none"></textarea>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-full font-bold hover:bg-green-700 transition">SUBMIT</button>
        </form>

        <!-- Contact Info + Map -->
        <div class=" flex flex-col gap-4 w-full lg:w-98.5  sm:items-center sm:justify-center lg:justify-between lg:items-start  sm:flex-row sm:h-50 lg:flex-col lg:h-107">
            <!-- Info Box -->
            <div class="bg-white py-6 px-8 rounded-lg shadow-md sm:h-50 lg:h-50 lg:w-full">
                <h2 class="text-lg lg:text-xl text-center font-semibold mb-4 text-gray-800">Contact Information</h2>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-green-500 text-xl">&#128241;</span>
                    <span>0912345678</span>
                </div>
                <div class="flex items-center gap-2 mb-2 text-wrap">
                    <span class="text-green-500 text-xl">&#128231;</span>
                    <span>barangaytapilon123@gmail.com</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-green-500 text-xl">&#127968;</span>
                    <span>Barangay Tapilon</span>
                </div>
            </div>

            <!-- Map Image -->
            <div class="rounded-lg overflow-hidden shadow-2xl flex justify-center items-center lg:items-start sm:max-w-lg ">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4299.785857526809!2d124.03293002155506!3d11.276335936459962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a877cdf2f92c03%3A0x5ebd702f1c7dd656!2sTapilon%20Barangay%20Hall!5e1!3m2!1sen!2sph!4v1751360802867!5m2!1sen!2sph" 
                class="w-full h-full sm:h-50 lg:h-60 lg:w-98.5"
                style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

    </div>
  </main>

    <footer class="text-gray bg-green-50 py-2 mt-2">
        <h1 class="text-center text-xs">&copyWasteWise 2025 All Rights Reserved</h1>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12/lib/typed.min.js"></script>
    <script src="<?php echo URL_ROOT; ?>/js/home.js"></script>
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