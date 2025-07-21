<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report-Waste</title>
    <link href="<?php echo URL_ROOT; ?>/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=upload" />
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</head>

<body class="flex flex-col font-[sans-serif] bg-gradient-to-r from-green-100 via-emerald-200 to-green-500 min-h-screen w-full transition-all duration-300">
    <header class="bg-white w-full">
        <nav class="flex justify-between items-center w-[92%] mx-auto">
            <div>
                <img class="w-27 cursor-pointer " src="<?php echo URL_ROOT; ?>/images/WasteWise.png" alt="...">
            </div>
            <div class="nav-links duration-500 md:static absolute bg-white md:min-h-fit min-h-[38vh] left-0 top-[-100%] md:w-auto z-1 w-full flex items-center px-5 py-8 sm:py-0">
                <ul class="w-full flex items-center justify-center md:flex-row flex-col md:text-md md:h-full md:items-center md:gap-[2vw] gap-8 font-bold">
                    <li>
                        <a class="hover:text-green-500" href="<?php echo URL_ROOT; ?>/home">HOME</a>
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

    <!-- WASTE CONTENT -->

    <main class="flex-grow flex flex-col justify-center items-center w-full">
        <div class=" container flex flex-col justify-center items-center gap-4 px-6 sm:mt-10 sm:px-0 md:px-10"> 
            <div class=" flex w-full max-w-200 justify-between mt-6 sm:mt-8 items-center">
                <h1 class=" text-md sm:text-2xl font-bold ">Waste Report</h1>

                <div class="flex justify-center items-center gap-2 sm:gap-4 h-full">
                    
                    <!-- <i class="fa-solid fa-list cursor-pointer text-green-600 text-lg sm:text-2xl"></i> -->
                    <!-- <i class="fa-solid fa-clock-rotate-left cursor-pointer text-green-600 text-lg sm:text-2xl"></i> -->
                    <div class="bg-gray-100 flex items-center justify-center rounded-3xl shadow-2xl inset-shadow-sm inset-shadow-gray-500/50 gap-1 py-1 sm:py-1 px-2">
                        <div class="bg-green-500 flex justify-center items-center text-white text-xs sm:text-lg w-4 h-4 sm:w-6 sm:h-6 rounded-full">&#9733;</div>
                        <h1 class="text-xs sm:text-xl font-bold text-green-500 text-center">1000.00</h1>
                    </div>
                    
                    <div class="bg-gray-100 shadow-md flex justify-center items-center p-1 w-6 h-6 sm:w-9 sm:h-9 rounded-md">
                        <img class="transaction w-7 cursor-pointer " src="<?php echo URL_ROOT; ?>/images/icons/transaction-icon.png" alt="...">
                    </div>

                    <button id="openRedeemModal" class="bg-green-500 flex justify-center items-center py-1 w-18 sm:w-30 h-full rounded-md shadow-2xl text-center text-xs sm:text-xl text-white hover:bg-green-600" type="button">Redeem</button>
                </div>

            </div>

            <div class="bg-gray-100 max-w-200 px-6 sm:px-8 py-6 sm:py-10 mb-6 w-full shadow-2xl rounded-lg">
                <h1 class="font-semibold">Upload Waste Image</h1>

               <div class="relative h-48 sm:h-60 rounded-lg border-dashed border-2 border-green-500 bg-gray-100 flex justify-center items-center mt-2">
    
                    <!-- Upload Prompt -->
                    <div id="upload-prompt" class="absolute w-full px-2 max-w-full">
                        <div class="flex flex-col items-center text-center px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" height="40" viewBox="0 -960 960 960" width="40" fill="#666666">
                                <path d="M450-313v-371L330-564l-43-43 193-193 193 193-43 43-120-120v371h-60ZM220-160q-24 0-42-18t-18-42v-143h60v143h520v-143h60v143q0 24-18 42t-42 18H220Z"/>
                            </svg>
                            <h1 class="text-green-500 font-bold text-sm sm:text-base">Attach your files here</h1>
                            <p class="text-gray-400 text-xs sm:text-sm">PNG, JPG, JPEG up to 10 MB</p>
                        </div>
                    </div>

                    <!-- Preview Container -->
                    <div id="preview-container" class="absolute w-full h-full max-w-full hidden flex justify-center items-center px-2">
                        <div class="relative inline-block">
                            <img id="preview-image" class="max-h-32 sm:max-h-40 object-contain rounded-md" src="" alt="Preview">
                            <!-- X Button inside img wrapper -->
                            <span id="close-preview"
                                class="absolute -top-2 -right-2 sm:-top-3 sm:-right-3 size-6 sm:size-7 bg-red-500 flex items-center justify-center text-white rounded-full text-xs sm:text-sm font-bold z-10 hover:bg-red-600 cursor-pointer"
                                title="Close">X</span>
                        </div>
                    </div>

                    <!-- Invisible File Input -->
                    <input type="file" id="file-input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".png,.jpg,.jpeg" name="file-upload">

                </div>


                <button class="w-full bg-green-500 mt-6 rounded-md py-1 text-lg text-center text-white hover:bg-green-600" type="submit">Verify Waste</button>
        
                <div class="flex flex-col sm:flex-row gap-4 mt-6">
                    <div class="flex flex-col w-full gap-2">
                        <h1 class="text-gray-700 font-semibold">Waste Type</h1>
                        <input class="px-4 bg-gray-300 rounded-md p-2 focus:outline-none" type="text" name="" id="" placeholder="Enter Waste Type (Plactics, Metal, Glass, ect.)">
                    </div>
                    <div class="flex flex-col w-full gap-2">
                        <h1 class="text-gray-700 font-semibold">Estimated Waste</h1>
                        <input class="px-4 bg-gray-300 rounded-md p-2 focus:outline-none" type="text" name="" id="" placeholder="Enter Estimated Weight (5 kg, 10kg, etc.)">
                    </div>
                </div>

                <div class="flex flex-col mt-4 gap-2">
                    <h1 class="text-gray-700 font-semibold">Location</h1>
                    <div class=" w-full h-50 rounded-lg">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4299.785857526809!2d124.03293002155506!3d11.276335936459962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a877cdf2f92c03%3A0x5ebd702f1c7dd656!2sTapilon%20Barangay%20Hall!5e1!3m2!1sen!2sph!4v1751360802867!5m2!1sen!2sph" 
                        class="w-full h-full rounded-lg"
                        style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <button id="submit-button" class="w-full bg-green-500 mt-6 rounded-md py-1 text-lg text-center text-white hover:bg-green-600" type="submit">Submit Report</button>
            </div>

            
        </div>

        <!-- History Modal -->
        <div id="historyModal" class="fixed inset-0 z-50 bg-white/70 pt-10 mt-10 hidden">
            <!-- MODAL BOX -->
           <div id="modalBox" class="w-[90%] max-w-lg mx-auto max-h-135 overflow-y-auto bg-white p-4 sm:p-6 rounded-xl shadow-2xl opacity-0 translate-y-10 scale-95 transition-all duration-300 ">
                <hr class="w-1/4 mx-auto border-t-4 border-gray-500 rounded-full">
                <div class="flex justify-between items-center pr-4">
                    <h1 class="mt-2 text-2xl">History</h1>
                    <img class="close w-5 cursor-pointer" src="<?php echo URL_ROOT; ?>/images/icons/close-icon.png" alt="...">
                    <!-- <i class="fa-solid fa-xmark text-gray-400 text-2xl cursor-pointer"></i> -->
                </div>

                <div class="flex justify-between gap-4  mt-4">
                    <button id="filter-all" class="bg-green-400 tab-item cursor-pointer px-4 rounded-xl">All</button>
                    <div class="flex gap-4">
                        <button id="filter-report" class="tab-item cursor-pointer px-4 rounded-xl">Report</button>
                        <button id="filter-redeem" class="tab-item cursor-pointer px-4 rounded-xl">Redeem</button>
                    </div>

                </div>

                <div class="mt-6 space-y-4">
                    
                    <div class="flex justify-between item-center border border-gray-300 rounded-md shadow-md px-3 py-4">
                        <div class="flex justify-between items-center gap-4">
                            <i class="fa-solid fa-clipboard-list text-green-500 text-4xl"></i>
                            <div class="flex flex-col space-y-1">
                                <h1 class="text-sm font-bold">Waste-Report</h1>
                                <p class="text-xs text-gray-500">Mixed Waste (Bottles, Glass, Plastics, Metals)</p>
                                <div class="flex gap-2 text-xs text-gray-400">
                                    <p>Today</p>
                                    <p>8:00 am</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center items-center ">
                            <p class="text-green-500 text-sm w-24 font-bold text-center py-1 rounded-2xl">Successful</p>
                        </div>
                    </div>

                    <div class="flex justify-between item-center border border-gray-300 rounded-md shadow-md px-3 py-4">
                        <div class="flex justify-between items-center gap-4">
                            <i class="fa-solid fa-clipboard-list text-green-500 text-4xl"></i>
                            <div class="flex flex-col space-y-1">
                                <h1 class="text-sm font-bold">Waste-Report</h1>
                                <p class="text-xs text-gray-500">Mixed Waste (Bottles, Glass, Plastics, Metals)</p>
                                <div class="flex gap-2 text-xs text-gray-400">
                                    <p>Today</p>
                                    <p>8:00 am</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center items-center ">
                            <p class="text-yellow-500 text-sm w-24 font-bold text-center py-1 rounded-2xl">Pending</p>
                        </div>
                    </div>

                    <div class="flex justify-between item-center border border-gray-300 rounded-md shadow-md px-3 py-4">
                        <div class="flex justify-between items-center gap-4">
                            <i class="fa-solid fa-circle-dollar-to-slot text-green-500 text-4xl"></i>
                            <div class="flex flex-col space-y-1">
                                <h1 class="text-sm font-bold">Redeem Points</h1>
                                <div class="flex gap-2 text-xs text-gray-400">
                                    <p>Today</p>
                                    <p>8:00 am</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center items-center ">
                            <p class="text-red-500 text-sm w-24 font-bold text-center py-1 rounded-2xl">- 50</p>
                        </div>
                    </div>

                    <div class="flex justify-between item-center border border-gray-300 rounded-md shadow-md px-3 py-4">
                        <div class="flex justify-between items-center gap-4">
                            <i class="fa-solid fa-circle-dollar-to-slot text-green-500 text-4xl"></i>
                            <div class="flex flex-col space-y-1">
                                <h1 class="text-sm font-bold">Redeem Points</h1>
                                <div class="flex gap-2 text-xs text-gray-400">
                                    <p>Today</p>
                                    <p>8:00 am</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center items-center ">
                            <p class="text-green-500 text-sm w-24 font-bold text-center py-1 rounded-2xl">+ 50</p>
                        </div>
                    </div>

                    <div class="flex justify-between item-center border border-gray-300 rounded-md shadow-md px-3 py-4">
                        <div class="flex justify-between items-center gap-4">
                            <i class="fa-solid fa-clipboard-list text-green-500 text-4xl"></i>
                            <div class="flex flex-col space-y-1">
                                <h1 class="text-sm font-bold">Report-Literrer</h1>
                                <p class="text-xs text-gray-500">Mixed Waste (Bottles, Glass, Plastics, Metals)</p>
                                <div class="flex gap-2 text-xs text-gray-400">
                                    <p>Today</p>
                                    <p>8:00 am</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center items-center ">
                            <p class="text-red-500 text-sm w-24 font-bold text-center py-1 rounded-2xl">Failed</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        
        <!-- Redeem Modal -->
        <div id="redeemModal" class="fixed inset-0 z-50 bg-white/70 overflow-y-auto hidden py-10  mt-10">
            <!-- MODAL BOX -->
            <div class="w-[90%] max-w-md mx-auto bg-white p-6 rounded-xl shadow-2xl">

                <div class=" flex justify-center items-center w-full py-1">
                    <h1 class=" w-90 rounded-md bg-gray-300 text-center p-1 font-semibold text-xl">Redeem Points</h1>
                </div>
                <!-- CONVERTION OPTIONS -->
                <div class="flex w-full justify-between mt-8 mb-4 items-center">
                    <h1 class="text-md font-bold">Select Convertion</h1>
                    <div class=" flex justify-between max-w-30 h-full items-center rounded-3xl shadow-2xl inset-shadow-sm inset-shadow-gray-500/50 gap-1 px-2">
                        <div class="bg-green-500 flex justify-center items-center text-sm text-white size-4 rounded-full">&#9733;</div>
                        <h1 class="text-center text-md sm:text-lg font-bold text-green-500">0.00</h1>
                    </div>
                </div>

                <!-- AMOUNT OPTIONS -->
                <div class="space-y-2 mb-4">
                    <!-- Repeat for each value -->
                    <button class="conversion-btn w-full flex justify-between items-center bg-gray-100 px-4 py-2 rounded-md hover:bg-gray-300">
                        <div class="flex gap-2 px-2 items-center">
                            <div class="bg-green-500 flex justify-center items-center text-md text-white size-5 rounded-full">&#9733;</div>
                            <h1 class="text-md font-bold text-green-500">25.00</h1>
                        </div>
                        <div class="flex w-18">
                            <span class="font-bold">&#8369; 25.00</span>
                        </div>
                    </button>
                    <button class="conversion-btn w-full flex justify-between items-center bg-gray-100 px-4 py-2 rounded-md hover:bg-gray-300">
                        <div class="flex gap-2 px-2 items-center">
                            <div class="bg-green-500 flex justify-center items-center text-md text-white size-5 rounded-full">&#9733;</div>
                            <h1 class="text-md font-bold text-green-500">50.00</h1>
                        </div>
                        <div class="flex w-18">
                            <span class="font-bold">&#8369; 50.00</span>
                        </div>
                    </button>
                    <button class="conversion-btn w-full flex justify-between items-center bg-gray-100 px-4 py-2 rounded-md hover:bg-gray-300">
                        <div class="flex gap-2 px-2 items-center">
                            <div class="bg-green-500 flex justify-center items-center text-md text-white size-5 rounded-full">&#9733;</div>
                            <h1 class="text-md font-bold text-green-500">75.00</h1>
                        </div>
                        <div class="flex w-18">
                            <span class="font-bold">&#8369; 75.00</span>
                        </div>
                    </button>
                    <button class="conversion-btn w-full flex justify-between items-center bg-gray-100 px-4 py-2 rounded-md hover:bg-gray-300">
                        <div class="flex gap-2 px-2 items-center">
                            <div class="bg-green-500 flex justify-center items-center text-md text-white size-5 rounded-full">&#9733;</div>
                            <h1 class="text-md font-bold text-green-500">100.00</h1>
                        </div>
                        <div class="flex w-18">
                            <span class="font-bold">&#8369; 100.00</span>
                        </div>
                    </button>
                </div>

                <!-- FORM INPUTS -->
                <div class="flex flex-col gap-2">
                    <h1 class="text-md font-bold">Enter Mobile Number</h1>
                    <input type="text" id="gcashNumber" placeholder="Enter Mobile Number" class="w-full p-2 bg-gray-200 rounded" />
                </div>
                <div class="flex flex-col gap-2 mt-2 mb-6">
                    <h1 class="text-md font-bold">Enter Gcash Name</h1>
                    <input type="text" id="gcashName" placeholder="Gcash Name" class="w-full p-2 bg-gray-200 rounded" />
                </div>

                <!-- FILE UPLOAD + PREVIEW -->
                <form id="upload-form">
                    <div class="relative rounded-lg border-dashed border-2 border-green-500 bg-gray-100 flex justify-center items-center mt-2 w-full max-w-md mx-auto h-40 sm:h-48 md:h-56">
                        
                        <!-- Upload Message -->
                        <div id="upload-redeem" class="absolute inset-0 flex flex-col items-center justify-center text-center px-2">
                            <span class="text-green-500 font-bold text-sm sm:text-base">Upload a file</span>
                            <h1 class="text-gray-400 text-xs sm:text-sm">PNG, JPG, JPEG up to 10 MB</h1>
                        </div>

                        <!-- Preview Image -->
                        <div id="preview-redeem" class="absolute inset-0 hidden flex justify-center items-center">
                            <div class="relative">
                                <img id="preview-image-redeem" class="max-h-32 w-auto object-contain rounded-md" src="" alt="Preview">
                                <span id="close-preview-redeem"
                                    class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center cursor-pointer hover:bg-red-600 text-sm font-bold z-10"
                                    title="Cancel">X</span>
                            </div>
                        </div>

                        <!-- File Input -->
                        <input type="file" id="file-input-redeem"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            accept=".png,.jpg,.jpeg" name="file-upload">
                    </div>
                </form>

                <!-- ACTION BUTTONS -->
                <div class="flex justify-between gap-4 mt-6">
                    <button id="closeRedeemModal" type="button" class="w-full bg-gray-300 text-gray-800 text-sm sm:text-lg py-2 rounded-md hover:bg-gray-400">Close</button>
                    <button id="submitRedeem" type="button" class="w-full bg-green-500 text-white text-sm sm:text-lg py-2 rounded-md hover:bg-green-600">Submit Redemption</button>
                </div>
            </div>
        </div> 

    </main>

        

    <footer class="text-gray bg-green-50 py-2">
        <h1 class="text-center text-xs">&copyWasteWise 2025 All Rights Reserved</h1>
    </footer>

    <script src="<?php echo URL_ROOT; ?>/js/auth.js"></script>
    <script>

        // DROP DOWN
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

        // HISTORY MODAL

        const tabItems = document.querySelectorAll('.tab-item');

        tabItems.forEach(item => {
            item.addEventListener('click', () => {
                tabItems.forEach(el => el.classList.remove('bg-green-400')); // remove active class from all
                item.classList.add('bg-green-400'); // add active class to clicked
            });
        });

        const modal = document.getElementById('historyModal');
        const modalBox = document.getElementById('modalBox');
        const openBtn = document.querySelector('.transaction');
        const closeBtn = document.querySelector('.close');

        // Open Modal
        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // Trigger animation after small delay to allow DOM render
            setTimeout(() => {
                modalBox.classList.remove('opacity-0', 'translate-y-10', 'scale-95');
                modalBox.classList.add('opacity-100', 'translate-y-0', 'scale-100');
            }, 10);

            // Always show all history when modal opens
            filterHistory('all');

            // Optionally, reset active tab styling to 'All'
            tabItems.forEach(el => el.classList.remove('bg-green-400'));
            allButton.classList.add('bg-green-400');
        });

        // Close Modal
        closeBtn.addEventListener('click', () => {
            // Animate out
            modalBox.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
            modalBox.classList.add('opacity-0', 'translate-y-10', 'scale-95');

            // Wait for animation to finish before hiding
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }, 200); // match transition duration
        });

        // Filtering logic
        const allButton = document.getElementById('filter-all');
        const reportButton = document.getElementById('filter-report');
        const redeemButton = document.getElementById('filter-redeem');


        // Grab all history entries
        const historyItems = document.querySelectorAll('#historyModal .space-y-4 > div');

        // Helper function to filter
        function filterHistory(type) {
            historyItems.forEach(item => {
                const title = item.querySelector('h1').textContent.toLowerCase();
                if (type === 'all') {
                    item.classList.remove('hidden');
                } else if (type === 'report') {
                    if (title.includes('waste-report') || title.includes('report-literrer')) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                } else if (type === 'redeem') {
                    if (title.includes('redeem')) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                }
            });
        }

        // Event listeners for filter buttons
        allButton.addEventListener('click', () => filterHistory('all'));
        reportButton.addEventListener('click', () => filterHistory('report'));
        redeemButton.addEventListener('click', () => filterHistory('redeem'));

        

        // === Redeem Modal ===
        const redeemModal = document.getElementById('redeemModal');
        const openRedeemBtn = document.getElementById('openRedeemModal');
        const closeRedeemBtn = document.getElementById('closeRedeemModal');
        const redeemFileInput = document.getElementById('file-input-redeem');
        const redeemPreviewDiv = document.getElementById('preview-redeem');
        const redeemUploadDiv = document.getElementById('upload-redeem');
        const redeemPreviewImg = document.getElementById('preview-image-redeem');
        const redeemClosePreview = document.getElementById('close-preview-redeem');
        const submitRedeem = document.getElementById('submitRedeem');
        const conversionButtons = document.querySelectorAll('.conversion-btn');
        let selectedConversion = null;

        // Handle button selection
        conversionButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active style from all buttons
                conversionButtons.forEach(b => b.classList.remove('bg-green-200', 'ring-2', 'ring-green-500'));

                // Add active style to clicked button
                btn.classList.add('bg-green-200', 'ring-2', 'ring-green-500');
                selectedConversion = btn;
            });
        });

        // Allow only numbers in mobile number input
        const gcashNumber = document.getElementById('gcashNumber');
        gcashNumber.addEventListener('input', () => {
            gcashNumber.value = gcashNumber.value.replace(/\D/g, ''); // Remove non-digits
        });

        function handleRedeemSubmit() {
        const number = gcashNumber.value.trim();
        const name = document.getElementById('gcashName').value.trim();
        const file = redeemFileInput.files[0];

        if (!number || !name || !file || !selectedConversion) {
            alert('Please complete all required fields including selecting a conversion amount and uploading a file.');
            return;
        }

        alert('Redemption Submitted Successfully!');
        redeemModal.classList.add('hidden');

        // Reset state
        gcashNumber.value = '';
        document.getElementById('gcashName').value = '';
        resetRedeemFileInput();
        conversionButtons.forEach(b => b.classList.remove('bg-green-200', 'ring-2', 'ring-green-500'));
        selectedConversion = null;
        }



        openRedeemBtn?.addEventListener("click", () => {
        redeemModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); // Disable background scroll

        // Clear old listeners to prevent duplication
        const newSubmit = submitRedeem.cloneNode(true);
        submitRedeem.parentNode.replaceChild(newSubmit, submitRedeem);
        newSubmit.addEventListener('click', handleRedeemSubmit);
        });


        closeRedeemBtn?.addEventListener("click", () => {
            redeemModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden'); // Re-enable scroll
        });

        redeemFileInput?.addEventListener('change', function () {
            const file = this.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    redeemPreviewImg.src = e.target.result;
                    redeemPreviewDiv.classList.remove('hidden');
                    redeemUploadDiv.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        redeemClosePreview?.addEventListener('click', () => {
            resetRedeemFileInput();
        });

        submitRedeem?.addEventListener('click', handleRedeemSubmit, { once: true });

            function handleRedeemSubmit() {
                const number = gcashNumber.value.trim();
                const name = document.getElementById('gcashName').value.trim();
                const file = redeemFileInput.files[0];

                if (!number || !name || !file || !selectedConversion) {
                    alert('Please complete all required fields including selecting a conversion amount and uploading a file.');
                    // Re-attach listener if validation fails
                    submitRedeem.addEventListener('click', handleRedeemSubmit, { once: true });
                    return;
                }

                alert('Redemption Submitted Successfully!');
                redeemModal.classList.add('hidden');

                // Reset everything
                gcashNumber.value = '';
                document.getElementById('gcashName').value = '';
                resetRedeemFileInput();
                conversionButtons.forEach(b => b.classList.remove('bg-green-200', 'ring-2', 'ring-green-500'));
                selectedConversion = null;

                // Re-attach listener for next time
                submitRedeem.addEventListener('click', handleRedeemSubmit, { once: true });
            }


        function resetRedeemFileInput() {
            redeemPreviewImg.src = '';
            redeemPreviewDiv.classList.add('hidden');
            redeemUploadDiv.classList.remove('hidden');
            redeemFileInput.value = '';
        }

        // === Report Submission ===
        const reportFileInput = document.getElementById('file-input');
        const reportPreviewContainer = document.getElementById('preview-container');
        const reportPreviewImage = document.getElementById('preview-image');
        const reportClosePreview = document.getElementById('close-preview');
        const reportUploadPrompt = document.getElementById('upload-prompt');
        const reportSubmitButton = document.getElementById('submit-button');

        let reportFileUploaded = false;

        reportFileInput?.addEventListener('change', function () {
            const file = this.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    reportPreviewImage.src = e.target.result;
                    reportPreviewContainer.classList.remove('hidden');
                    reportUploadPrompt.classList.add('hidden');
                    reportFileUploaded = true;
                };
                reader.readAsDataURL(file);
            } else {
                alert('Invalid file type. Please upload PNG, JPG, or JPEG.');
                this.value = '';
            }
        });

        reportClosePreview?.addEventListener('click', function () {
            resetReportFileInput();
        });

        reportSubmitButton?.addEventListener('click', function (e) {
            e.preventDefault(); // prevent form submission

            const wasteTypeInput = document.querySelector('input[placeholder*="Waste Type"]');
            const estimatedWasteInput = document.querySelector('input[placeholder*="Estimated Weight"]');

            const wasteType = wasteTypeInput?.value.trim();
            const estimatedWaste = estimatedWasteInput?.value.trim();

            if (!wasteType || !estimatedWaste || !reportFileUploaded) {
                alert('Please fill in all fields and upload an image before submitting the report.');
                return;
            }

            alert('Report submitted successfully!');
            // Reset form
            wasteTypeInput.value = '';
            estimatedWasteInput.value = '';
            resetReportFileInput();
        });

        function resetReportFileInput() {
            reportPreviewImage.src = '';
            reportPreviewContainer.classList.add('hidden');
            reportUploadPrompt.classList.remove('hidden');
            reportFileInput.value = '';
            reportFileUploaded = false;
        }
    </script>


</body>

</html>