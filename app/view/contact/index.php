<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="<?php echo URL_ROOT; ?>/css/output.css" rel="stylesheet">
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                            <a href="<?php echo URL_ROOT; ?>/report/literrer" class="block px-4 py-2 hover:bg-green-100 text-black">Report Litterer</a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- profile and notifcation icon -->
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
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold">3</span>
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
            <div class="h-[27rem] overflow-y-hidden " id="notificationContent">
                <!-- Notification Item 1 -->
                <div class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors" onclick="markAsRead(this)">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <ion-icon name="trash" class="text-green-600 text-lg"></ion-icon>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="text-sm font-semibold text-gray-800">Waste Report Approved</h4>
                                <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                            </div>
                            <p class="text-sm text-gray-600 mb-1">Your waste report at Tapilon Street has been approved. You earned 50 points!</p>
                            <p class="text-xs text-gray-400">2 hours ago</p>
                        </div>
                    </div>
                </div>

                <!-- Notification Item 2 -->
                <div class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors" onclick="markAsRead(this)">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                <ion-icon name="warning" class="text-yellow-600 text-lg"></ion-icon>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="text-sm font-semibold text-gray-800">Report Under Review</h4>
                                <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                            </div>
                            <p class="text-sm text-gray-600 mb-1">Your litterer report is currently being reviewed by our team.</p>
                            <p class="text-xs text-gray-400">5 hours ago</p>
                        </div>
                    </div>
                </div>

                <!-- Notification Item 3 -->
                <div class="p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors" onclick="markAsRead(this)">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <ion-icon name="medal" class="text-blue-600 text-lg"></ion-icon>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="text-sm font-semibold text-gray-800">Achievement Unlocked!</h4>
                                <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                            </div>
                            <p class="text-sm text-gray-600 mb-1">Congratulations! You've reached 500 points and unlocked the "Eco Warrior" badge.</p>
                            <p class="text-xs text-gray-400">1 day ago</p>
                        </div>
                    </div>
                </div>

                <div class="hidden p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors" onclick="markAsRead(this)">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <ion-icon name="medal" class="text-blue-600 text-lg"></ion-icon>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="text-sm font-semibold text-gray-800">Achievement Unlocked!</h4>
                                <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                            </div>
                            <p class="text-sm text-gray-600 mb-1">Congratulations! You've reached 500 points and unlocked the "Eco Warrior" badge.</p>
                            <p class="text-xs text-gray-400">1 day ago</p>
                        </div>
                    </div>
                </div>


                <div class="hidden p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors" onclick="markAsRead(this)">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <ion-icon name="trash" class="text-green-600 text-lg"></ion-icon>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="text-sm font-semibold text-gray-800">New Waste Collection</h4>
                                <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                            </div>
                            <p class="text-sm text-gray-600 mb-1">A new waste collection point has been added near your location.</p>
                            <p class="text-xs text-gray-400">2 days ago</p>
                        </div>
                    </div>
                </div>
                <!-- Hidden Notifications -->
                <div class="hidden p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors" onclick="markAsRead(this)">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <ion-icon name="star" class="text-purple-600 text-lg"></ion-icon>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="text-sm font-semibold text-gray-800">Weekly Leaderboard</h4>
                                <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                            </div>
                            <p class="text-sm text-gray-600 mb-1">You're in the top 10 contributors this week! Keep up the good work.</p>
                            <p class="text-xs text-gray-400">3 days ago</p>
                        </div>
                    </div>
                </div>

                <!-- Empty State (hidden by default) -->
                <div id="emptyNotifications" class="hidden p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <ion-icon name="notifications-off" class="text-2xl text-gray-400"></ion-icon>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">No notifications</h3>
                    <p class="text-gray-500 text-sm">You're all caught up! Check back later for updates.</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 -mt-10 py-4 border-t border-gray-100" id="viewAllButtonContainer">
                <button onclick="viewAllNotifications()" class="w-full text-center text-green-500 hover:text-green-600 font-medium text-sm">
                    View All Notifications
                </button>
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
            <form method="post" action="<?php echo URL_ROOT; ?>/contact/contactForm" class="flex-1 bg-white p-6 rounded-lg shadow-md space-y-4 sm:max-w-xl lg:px-6">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-bold pb-0.5 lg:text-lg text-black">First Name</label>
                        <input name="firstname" type="text" required placeholder="Enter first name" class="w-full border-2 border-green-400 rounded p-2 bg-gray-200" />
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-bold pb-0.5 lg:text-lg text-black">Last Name</label>
                        <input name="lastname" type="text" required placeholder="Enter last name" class="w-full border-2 border-green-400 rounded p-2 bg-gray-200" />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-bold pb-0.5 lg:text-lg text-black">Gmail</label>
                        <input name="gmail" type="email" required placeholder="example@gmail.com" class="w-full border-2 border-green-400 rounded p-2 bg-gray-200" />
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-bold pb-0.5 lg:text-lg text-black">Mobile Number</label>
                        <input name="phone" type="tel" required placeholder="09123456789" class="w-full border-2 border-green-400 rounded p-2 bg-gray-200" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold pb-0.5 lg:text-lg text-black">Message</label>
                    <textarea name="message" required placeholder="Type your message here" class="w-full border-2 border-green-400 rounded p-2 bg-gray-200 h-27 resize-none"></textarea>
                </div>

                <!-- submit error/success display -->
                <?php if (!empty($data['success'])): ?>
                    <p class="text-green-500 text-center text-xs sm:text-sm"><?php echo $data['success']; ?></p>
                <?php endif; ?>

                <?php if (!empty($data['error'])): ?>
                    <p class="text-red-500 text-center text-xs sm:text-sm"><?php echo $data['error']; ?></p>
                <?php endif; ?>


                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-full font-bold hover:bg-green-700 transition">SUBMIT</button>
            </form>

            <!-- Contact Info + Map -->
            <div class=" flex flex-col gap-4 w-full lg:w-98.5  sm:items-center sm:justify-center lg:justify-between lg:items-start  sm:flex-row sm:h-50 lg:flex-col lg:h-107">
                <!-- Info Box -->
                <div class="bg-white py-6 px-8 rounded-lg shadow-md sm:h-50 lg:h-50 lg:w-full">
                    <h2 class="text-lg lg:text-xl text-center font-semibold mb-4 text-gray-800">Contact Information</h2>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-green-500 text-xl"><i class="fa-solid fa-phone" style="color: #39b828;"></i></span>
                        <span><?= $data['barangayDetails']['phone'] ?></span>
                    </div>
                    <div class="flex items-center gap-2 mb-2 text-wrap">
                        <span class="text-green-500 text-xl"><i class="fa-solid fa-envelope" style="color: #39b828;"></i></span>
                        <span><?= $data['barangayDetails']['gmail']  ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-green-500 text-xl"><i class="fa-brands fa-facebook" style="color: #39b828;"></i></span>
                        <a href="<?= $data['barangayDetails']['facebook'] ?>" target="_blank"><?= $data['barangayDetails']['fbName'] ?></a>
                    </div>
                </div>

                <!-- Map Image -->
                <div class="rounded-lg overflow-hidden shadow-2xl flex justify-center items-center lg:items-start sm:max-w-lg ">
                    <iframe src="<?= $data['barangayDetails']['map'] ?>"
                        class="w-full h-full sm:h-50 lg:h-60 lg:w-98.5"
                        style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-gray bg-green-50 py-2 mt-2">
        <h1 class="text-center text-xs">&copyWasteWise 2025 All Rights Reserved</h1>
    </footer>
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