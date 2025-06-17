<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WasteWise</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</head>

<body class="font-[sans-serif] bg-gradient-to-r from-green-100 via-emerald-200 to-green-500 h-full w-full">
     <header class="bg-white w-full py-0.5">
        <nav class="flex justify-between items-center w-[92%] mx-auto sm:py-0">
            <div>
                <img class="w-[100px] cursor-pointer" src="<?php echo URL_ROOT; ?>/images/WasteWise.png" alt="...">
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
                    <img src="<?php echo URL_ROOT; ?>/images/tree3.png" 
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
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-3 border-b border-gray-100 bg-gray-200 rounded-tr-2xl rounded-tl-2xl">
            <h2 class="text-lg font-bold text-gray-800">My Profile</h2>
            <div class="flex items-center gap-3">
                
                <button onclick="closeProfileModal()" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                    <ion-icon name="close" class="text-xl text-gray-500"></ion-icon>
                </button>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="p-6">
            <!-- Profile Picture and Basic Info -->
            <div class="flex items-center gap-4 mb-4">
                <div class="relative group">
                    <img src="<?php echo URL_ROOT; ?>/images/tree3.png" 
                         alt="Profile" 
                         class="w-20 h-20 rounded-full border-4 border-green-100 cursor-pointer"
                         id="profileImage"
                         onclick="document.getElementById('profileImageInput').click()">
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                        <ion-icon name="checkmark" class="text-white text-sm"></ion-icon>
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-30 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer"
                         onclick="document.getElementById('profileImageInput').click()">
                        <ion-icon name="camera" class="text-white text-2xl"></ion-icon>
                    </div>
                    <input type="file" id="profileImageInput" accept="image/*" class="hidden" onchange="handleImageUpload(event)">
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800" id="profileName">Jerwin Noval</h3>
                    <p class="text-sm text-gray-500" id="profileEmail">jerwinnoval@gmail.com</p>
                    <button class="mt-1 text-sm text-blue-500 hover:text-blue-600 font-medium" onclick="toggleEditMode()">Edit Profile</button>
                </div>
            </div>

            <!-- Menu Items -->
            <div class="space-y-1" id="menuItems">
                <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-red-100 cursor-pointer transition-colors text-red-600">
                    <ion-icon name="log-out-outline" class="text-xl"></ion-icon>
                    <span class="-ml-8">Log Out</span>
                    <ion-icon name="chevron-forward" class="text-red-400 ml-auto"></ion-icon>
                </div>
            </div>

            <!-- Edit Form (Hidden by default) -->
            <div id="editForm" class="hidden">
                <div>
                    <label class="block text-sm font-sm text-gray-700 mb-1">First Name</label>
                    <input type="text" value="Jerwin" class="w-full p-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-sm text-gray-700 mb-1">Last Name</label>
                    <input type="text" value="Noval" class="w-full p-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-sm text-gray-700 mb-1">Email</label>
                    <input type="email" value="jerwinnoval@gmail.com" class="w-full p-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-sm text-gray-700 mb-1">Location</label>
                    <select class="w-full p-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none focus:border-transparent">
                        <option>Tapilon</option>
                        <option>Maya</option>
                        <option>Poblacion</option>
                    </select>
                </div>
                <div class="flex gap-2 pt-2 mt-2">
                    <button onclick="saveProfile()" class="flex-1 bg-green-500 text-white py-1 rounded-lg font-medium hover:bg-green-600 transition-colors">
                        Save Changes
                    </button>
                    <button onclick="cancelEdit()" class="flex-1 border border-gray-300 text-gray-700 py-1 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
            <h1>Welcome, <?php echo htmlspecialchars($data['user']['firstname'] . ' ' . $data['user']['lastname']); ?>!</h1>

            <div class="user-info">
                <p><strong>Email:</strong> <?php echo htmlspecialchars($data['user']['email']); ?></p>
                <p><strong>Barangay:</strong> <?php echo htmlspecialchars($data['user']['barangay']); ?></p>
            </div>

            <a href="<?php echo URL_ROOT; ?>/auth/logout">Logout</a>
        </div>


    <!-- HOME CONTENT -->
     <main class="flex-grow w-full">
        <div class=" p-4  h-screen flex items-center justify-center w-full sm:p-6 md:p-0 md:gap-10">
            <div class=" flex flex-col  gap-8 px-4 items-center justify-center w-full sm:mt-20 sm:px-6 md:flex-col md:max-w-full md:px-8 lg:flex-row">
                <div class=" p-1 mt-15  w-full py-10 order-2 sm:p-6 md:p-8 md:order-2 md:min-w-[60%] lg:order-1">
                    <h1 class="text-2xl -mt-[70px] font-bold text-black mb-2 sm:text-3xl md:text-4xl md:-mt-[10px]">Welcome to Waste<span class="text-green-500">Wise</span></h1>
                    <h3 class="text-1xl font-bold text-black mb-2 sm:text-2xl md:text-3xl ">Earn by reporting <span id="report" class="text-green-400"></span></h3>
                    <p class="mb-4 text-sm  text-black sm:text-lg md:text-xl ">WasteWise is a user-friendly system designed to help individuals and communities report waste effectively. Our platform enables users to easily log and track waste, providing valuable insights into waste management practices and identifying areas for improvement. By promoting transparency and accountability, WasteWise aims to contribute to a more sustainable future for our planet.</p>
                    <div class="flex flex-col  gap-4 sm:flex-row">
                        <a href="/waste-reporting-system/public/" class="text-green-50 hover:text-green-500"><button class="w-full  border-2 border-green-500 rounded p-2 text-base  bg-green-500 hover:text-green hover:bg-transparent hover:border-2 hover:border-green-500 transition-colors sm:w-auto sm:text-lg md:text-xl">Report Waste</button></a>
                        <a href="/home" class="text-green-500 hover:text-green-50"><button class="w-full  border-2 border-green-500 rounded p-2 text-base  text-green hover:bg-green-500 hover:text-green-50 transition-colors sm:w-auto sm:text-lg md:text-xl">Report Litterer</button></a>
                    </div>
                </div>
                <div class=" w-full  flex items-center justify-center p-1 order-1  h-full md:min-w-[30%] md:order-1 lg:mt-0 lg:order-2">
                    <!-- image -->
                    <img src="<?php echo URL_ROOT; ?>/images/tree3.png" alt="Tree illustration" class="w-60 max-w-xs object-contain sm:w-72  md:w-80 lg:w-96 md:mt-0.5 ">
                </div>
            </div>
        </div>
    </main>

   <footer class="text-gray bg-green-50 py-1 sm:py-2">
        <h1 class="text-center text-xs sm:text-sm">©WasteWise 2025 All Rights Reserved</h1>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12/lib/typed.min.js"></script>
    <script src="<?php echo URL_ROOT; ?>/js/home.js"></script>
    <script>
        // TYPEWRITER EFFECT
        document.addEventListener('DOMContentLoaded', function() {
            var typed = new Typed('#report', {
                strings: ['Waste', 'Litterer'],
                typeSpeed: 150,
                backSpeed: 100,
                backDelay: 1000,
                loop: true
            });
        });
    </script>
</body>

</html>