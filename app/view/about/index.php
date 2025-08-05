<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="<?php echo URL_ROOT; ?>/css/output.css" rel="stylesheet">
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</head>

<body class="relative flex flex-col font-[sans-serif] bg-gradient-to-r from-green-100 via-emerald-200 to-green-500 min-h-screen w-full">
    <header class="bg-white sticky top-0 w-full py-0.5">
        <nav class="flex justify-between items-center w-[92%] mx-auto sm:py-0">
            <div>
                <img class="w-[100px] cursor-pointer" src="<?php echo URL_ROOT; ?>/images/WasteWise.png" alt="WasteWise Logo">
            </div>
            <div class="nav-links duration-500 md:static absolute bg-white md:min-h-fit min-h-[38vh] left-0 top-[-100%] md:w-auto w-full flex items-center px-5 py-8 sm:py-0 z-10">
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
                            <a href="<?php echo URL_ROOT; ?>/waste" class="block px-4 py-2 hover:bg-green-100 text-black">Report Waste</a>
                            <a href="<?php echo URL_ROOT; ?>/litterer" class="block px-4 py-2 hover:bg-green-100 text-black">Report Litterer</a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- profile and notification icon -->
            <div class="flex items-center gap-3">
                <div class="relative">
                    <ion-icon name="notifications-outline" class="text-3xl cursor-pointer hover:text-green-500 transition-colors" onclick="openNotificationModal()"></ion-icon>
                    <div id="notificationBadge" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-white text-xs flex items-center justify-center font-bold">0</div>
                </div>
                <div class="relative">
                    <img src="<?php echo URL_ROOT . '/' . htmlspecialchars($data['user']['profile_picture'] ?? 'images/profile.png'); ?>"
                        alt="Profile"
                        class="w-10 h-10 rounded-full cursor-pointer border-2 border-gray-300 hover:border-green-500 transition-colors"
                        onclick="openProfileModal()">
                </div>
                <ion-icon id="menuIcon" onclick="onToggleMenu(this)" name="menu" class="text-3xl cursor-pointer md:hidden z-10"></ion-icon>
            </div>
        </nav>
    </header>

    <!-- Notification Modal -->
    <div id="notificationModal" class="fixed top-16 right-2 z-50 hidden" style="width: 350px;">
        <div class="bg-white rounded-2xl shadow-2xl transform transition-all duration-300 translate-x-full opacity-0" id="notificationModalContent">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-100 rounded-tr-2xl rounded-tl-2xl">
                <div class="flex items-center gap-2">
                    <ion-icon name="notifications" class="text-xl text-green-500"></ion-icon>
                    <h2 class="text-lg font-bold text-gray-800">Notifications</h2>
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold" id="notificationCount">0</span>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="markAllAsRead()" class="text-sm text-green-500 hover:text-green-600 font-medium">
                        Mark all read
                    </button>
                    <button onclick="closeNotificationModal()" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                        <ion-icon name="close" class="text-xl text-gray-500"></ion-icon>
                    </button>
                </div>
            </div>

            <!-- Notification Content -->
            <div class="h-[27rem] overflow-y-auto">

                <!-- Notifications list goes here -->
                <div id="notificationContent"></div>

                <!-- Empty State (hidden by default) -->
                <div id="emptyNotifications" class="p-8 text-center hidden">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <ion-icon name="notifications-off" class="text-2xl text-gray-400"></ion-icon>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">No notifications</h3>
                    <p class="text-gray-500 text-sm">You're all caught up! Check back later for updates.</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal" class="fixed top-16 right-2 z-50 hidden" style="width: 320px;">
        <div class="bg-white rounded-2xl shadow-2xl transform transition-all duration-300 translate-x-full opacity-0" id="modalContent">
            <div class="flex items-center justify-between px-6 py-3 border-b border-gray-100 bg-gray-200 rounded-tr-2xl rounded-tl-2xl">
                <h2 class="text-lg font-bold text-gray-800">My Profile</h2>
                <button onclick="closeProfileModal()" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                    <ion-icon name="close" class="text-xl text-gray-500"></ion-icon>
                </button>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="relative group">
                        <img src="<?php echo URL_ROOT . '/' . htmlspecialchars($data['user']['profile_picture'] ?? 'images/profile.png'); ?>"
                            alt="Profile"
                            class="w-20 h-20 rounded-full border-4 border-green-100 cursor-pointer"
                            id="profileImage">
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                            <ion-icon name="checkmark" class="text-white text-sm"></ion-icon>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800" id="profileName"><?php echo htmlspecialchars($data['user']['firstname'] . ' ' . $data['user']['lastname'] ?? 'Guest User'); ?></h3>
                        <p class="text-sm text-gray-500" id="profileEmail"><?php echo htmlspecialchars($data['user']['email'] ?? 'guest@example.com'); ?></p>
                        <p class="text-sm text-gray-500" id="profileBarangay"><?php echo htmlspecialchars($data['user']['barangay'] ?? 'Unknown'); ?></p>
                        <button class="mt-1 text-sm text-blue-500 hover:text-blue-600 font-medium" onclick="toggleEditMode()">Edit Profile</button>
                    </div>
                </div>
                <div class="space-y-1" id="menuItems">
                    <a href="<?php echo URL_ROOT; ?>/auth/logout" class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-100 cursor-pointer transition-colors text-red-600">
                        <ion-icon name="log-out-outline" class="text-xl"></ion-icon>
                        <span class="-ml-8">Log Out</span>
                        <ion-icon name="chevron-forward" class="text-red-400 ml-auto"></ion-icon>
                    </a>
                </div>
                <form id="editForm" class="hidden" action="<?php echo URL_ROOT; ?>/home/updateProfile" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="old_email" value="<?php echo htmlspecialchars($data['user']['email'] ?? ''); ?>">
                    <div>
                        <label class="block text-sm font-sm text-gray-700 mb-1">Profile Picture</label>
                        <div class="relative">
                            <input type="file" id="profileImageInputForm" name="profile_picture" accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                onchange="handleImageUpload(event)">
                            <button type="button"
                                class="w-full p-1 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 text-sm font-medium hover:bg-gray-100 transition-colors focus:ring-2 focus:ring-green-500 focus:outline-none">
                                Choose Image
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-sm text-gray-700 mb-1">First Name</label>
                        <input type="text" name="firstname" value="<?php echo htmlspecialchars($data['user']['firstname'] ?? ''); ?>"
                            class="w-full p-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-sm text-gray-700 mb-1">Last Name</label>
                        <input type="text" name="lastname" value="<?php echo htmlspecialchars($data['user']['lastname'] ?? ''); ?>"
                            class="w-full p-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-sm text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($data['user']['email'] ?? ''); ?>"
                            class="w-full p-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-sm text-gray-700 mb-1">Barangay</label>
                        <select name="barangay" class="w-full p-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-transparent">
                            <option value="Tapilon" <?php echo ($data['user']['barangay'] ?? '') === 'Tapilon' ? 'selected' : ''; ?>>Tapilon</option>
                            <option value="Maya" <?php echo ($data['user']['barangay'] ?? '') === 'Maya' ? 'selected' : ''; ?>>Maya</option>
                            <option value="Poblacion" <?php echo ($data['user']['barangay'] ?? '') === 'Poblacion' ? 'selected' : ''; ?>>Poblacion</option>
                        </select>
                    </div>
                    <div class="flex gap-2 pt-2 mt-2">
                        <button type="submit" class="flex-1 bg-green-500 text-white py-1 rounded-lg font-medium hover:bg-green-600 transition-colors">
                            Save Changes
                        </button>
                        <button type="button" onclick="cancelEdit()" class="flex-1 border border-gray-300 text-gray-700 py-1 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
                <?php if (isset($_SESSION['profile_success'])): ?>
                    <p class="text-green-500 text-sm mt-2"><?php echo $_SESSION['profile_success'];
                                                            unset($_SESSION['profile_success']); ?></p>
                <?php endif; ?>
                <?php if (isset($_SESSION['profile_error'])): ?>
                    <p class="text-red-500 text-sm mt-2"><?php echo $_SESSION['profile_error'];
                                                            unset($_SESSION['profile_error']); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ABOUT CONTENT -->

    <main class="flex-grow w-full">
        <div class=" flex flex-col w-full  md:py-12 xl:py-15 lg:flex-row">
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
    <script>
        const URL_ROOT = '<?php echo URL_ROOT; ?>';
    </script>
    <script src="<?php echo URL_ROOT; ?>/js/notifications.js"></script>
    <script src="<?php echo URL_ROOT; ?>/js/profile.js"></script>
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