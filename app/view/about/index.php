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
                    <img src="<?php echo URL_ROOT; ?>/images/tree3.png" 
                         alt="Profile" 
                         class="w-10 h-10 rounded-full cursor-pointer border-2 border-gray-300 hover:border-green-500 transition-colors"
                         onclick="openProfileModal()">
                </div>
                <ion-icon onclick="onToggleMenu(this)" name="menu" class="text-3xl cursor-pointer md:hidden z-10"></ion-icon>
            </div>
        </nav>
    </header>

    <!-- ABOUT CONTENT -->

    <main class="flex-grow w-full">
        <div class=" flex flex-col w-full h-auto md:py-12 xl:py-15 lg:flex-row">
            <div class="flex flex-col  justify-center gap-4 p-6 sm:p-10 order-2 lg:order-1 lg:pl-16 lg:w-[55%]">
                <h1 class="text-lg sm:text-xl md:text-2xl font-bold text-green-400">About</h1>
                <p class="text-sm  sm:text-lg ">The Innovative Waste Reporting System is a digital platform that makes it easy for residents to report waste-related issues directly to their local officials. </p>
                <p class="text-sm  sm:text-lg ">Our goal is to help create cleaner, safer, and more responsive communities by improving how waste concerns are reported and addressed. </p>
                <p class="text-sm  sm:text-lg ">With just a few clicks, citizens can take part in keeping their surroundings clean because a better environment starts with all of us.</p>
            </div>
            <div class=" flex flex-row justify-center items-center gap-4 lg:gap-6 px-10 py-15 order-1 lg:order-2  lg:w-[45%]">
                 <img src="<?php echo URL_ROOT; ?>/images/cleanup1.JPG" alt="images"
                 class="rounded-lg shadow-xl w-25 h-40 sm:w-30 sm:h-50 md:w-35 md:h-55 lg:w-40 lg:h-60 -mb-5 sm:-mb-8 md:-mb-15 lg:-mb-15">
                 <img src="<?php echo URL_ROOT; ?>/images/cleanup2.JPG" alt="images"
                 class="rounded-lg shadow-xl w-25 h-40 sm:w-30 sm:h-50 md:w-35 md:h-55 lg:w-40 lg:h-60 -mt-5 sm:-mt-8 md:-mt-15 lg:-mt-15">
                 <img src="<?php echo URL_ROOT; ?>/images/cleanup3.JPG" alt="images"
                 class="rounded-lg shadow-xl w-25 h-40 sm:w-30 sm:h-50 md:w-35 md:h-55 lg:w-40 lg:h-60 -mb-5 sm:-mb-8 md:-mb-15 lg:-mb-15">
            </div>
        </div>

        <div class=" flex w-full h-30 justify-center items-center ">
            <div class="flex w-50 md:w-90 xl:w-100 bg-white justify-center items-center rounded-md border-2 border-gray-500 shadow-2xl">
                <h1 class="text-md md:text-xl xl:text-2xl font-bold px-10 py-4 ">Our Goals</h1>
            </div>
        </div>


        <div class=" flex flex-col sm:flex-row w-full h-auto py-15 px-10 justify-center items-center gap-10">

            <div class="flex flex-col  w-50%  px-8 py-6 rounded-md bg-white shadow-2xl">
                
                <div class=" flex justify-center items-center w-full">
                    <h1 class="text-sm md:text-md xl:text-lg text-green-500 font-bold flex">CLEAN COMMUNITIES</h1>
                </div>
                <p class="text-sm md:text-md xl:text-lg text-justify h-40%  mt-7">We promote sustainable waste solutions to safeguard natural resources. 
                    Quick reporting helps reduce environmental harm for a healthier future.</p>
            </div>

            <div class="flex flex-col w-50%  px-8 py-6 rounded-md bg-white shadow-2xl">

                <div class=" flex justify-center items-center w-full">
                    <h1 class="text-sm md:text-md xl:text-lg text-green-500 font-bold flex">COMMUNITIES ENGAGEMENT</h1>
                </div>
                <p class="text-sm md:text-md xl:text-lg text-justify h-40%  mt-7">We empower citizens to take action by reporting waste issues and sharing ideas. 
                    Together, we foster a sense of shared responsibility.</p>
            </div>

            <div class="flex flex-col w-50%  px-8 py-6 rounded-md bg-white shadow-2xl">

                <div class=" flex justify-center items-center w-full">
                    <h1 class="text-sm md:text-md xl:text-lg text-green-500 font-bold flex">ENVIRONMENTAL PROTECTION</h1>
                </div>
                <p class="text-sm md:text-md xl:text-lg text-justify h-40%  mt-7">We promote sustainable waste solutions to safeguard natural resources. 
                    Quick reporting helps reduce environmental harm for a healthier future.</p>
            </div>
        </div>

    </main>

    <footer class="text-gray bg-green-50 py-2 mt-15">
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