<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report-Waste</title>
    <link href="<?php echo URL_ROOT; ?>/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=upload" />
    <!-- Local Leaflet CSS -->
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/js/leaflet/leaflet.css" />
</head>

<body class="flex flex-col font-[sans-serif] bg-gradient-to-r from-green-100 via-emerald-200 to-green-500 min-h-screen w-full transition-all duration-300">
    <header class="bg-white w-full">
        <nav class="flex justify-between items-center w-[92%] mx-auto">
            <div>
                <a href="<?php echo URL_ROOT; ?>/user">
                    <img class="w-[100px] cursor-pointer" src="<?php echo URL_ROOT; ?>/images/WasteWise.png" alt="WasteWise Logo">
                </a>
            </div>
            <div class="nav-links duration-500 md:static absolute bg-white md:min-h-fit min-h-[38vh] left-0 top-[-100%] md:w-auto z-1 w-full flex items-center px-5 py-8 sm:py-0">
                <ul class="w-full flex items-center justify-center md:flex-row flex-col md:text-md md:h-full md:items-center md:gap-[2vw] gap-8 font-bold">
                    <li>
                        <a class="hover:text-green-500" href="<?php echo URL_ROOT; ?>/user">HOME</a>
                    </li>
                    <li>
                        <a class="hover:text-green-500" href="<?php echo URL_ROOT; ?>/user/about">ABOUT</a>
                    </li>
                    <li>
                        <a class="hover:text-green-500" href="<?php echo URL_ROOT; ?>/user/contact">CONTACT</a>
                    </li>
                    <li>
                        <a class="hover:text-green-500" href="<?php echo URL_ROOT; ?>/user/announcement">ANNOUNCEMENT</a>
                    </li>
                    <li class="relative">
                        <button onclick="toggleDropdown()" class="hover:text-green-500 cursor-pointer flex items-center gap-2 font-bold">
                            REPORT
                            <img src="<?php echo URL_ROOT; ?>/images/icons/dropdown.png" alt="dropdown" class="h-4">
                        </button>
                        <div id="reportDropdown" class="absolute hidden bg-white shadow-lg mt-2 rounded w-44 z-20 text-sm">
                            <a href="<?php echo URL_ROOT; ?>/user/waste" class="block px-4 py-2 hover:bg-green-100 text-black">Report Waste</a>
                            <a href="<?php echo URL_ROOT; ?>/user/litterer" class="block px-4 py-2 hover:bg-green-100 text-black">Report Litterer</a>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- profile and notification icon -->
            <div class="flex items-center gap-3">
                <div class="relative">
                    <img src="<?php echo URL_ROOT; ?>/images/icons/bell.png" alt="" class="h-8 text-3xl cursor-pointer hover:text-green-500 transition-colors" onclick="openNotificationModal()">
                    <div id="notificationBadge" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-white text-xs flex items-center justify-center font-bold">0</div>
                </div>
                <div class="relative">
                    <img src="<?php echo URL_ROOT . '/' . htmlspecialchars($data['user']['profile_picture'] ?? 'images/profile.png'); ?>"
                        alt="Profile"
                        class="w-10 h-10 rounded-full cursor-pointer border-2 border-gray-300 hover:border-green-500 transition-colors"
                        onclick="openProfileModal()">
                </div>
                <img id="menuIcon" onclick="onToggleMenu(this)" name="menu" src="<?php echo URL_ROOT; ?>/images/icons/menu.png" alt="" class="h-10 cursor-pointer md:hidden z-10">
            </div>
        </nav>
    </header>

    <!-- Notification Modal -->
    <div id="notificationModal" class="fixed top-16 right-2 z-50 hidden" style="width: 350px;">
        <div class="bg-white rounded-2xl shadow-2xl transform transition-all duration-300 translate-x-full opacity-0" id="notificationModalContent">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-100 rounded-tr-2xl rounded-tl-2xl">
                <div class="flex items-center gap-2">
                    <h2 class="text-lg font-bold text-gray-800">Notifications</h2>
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold" id="notificationCount">0</span>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="markAllAsRead()" class="text-sm text-green-500 hover:text-green-600 font-medium">
                        Mark all read
                    </button>
                    <button onclick="closeNotificationModal()" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                        <img src="<?php echo URL_ROOT; ?>/images/icons/close-icon.png" alt="" class="h-4">
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
                        <img src="<?php echo URL_ROOT; ?>/images/icons/silent.png" alt="" class="h-10">
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
                    <img src="<?php echo URL_ROOT; ?>/images/icons/close-icon.png" alt="" class="h-5">
                </button>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="relative group">
                        <img src="<?php echo URL_ROOT . '/' . htmlspecialchars($data['user']['profile_picture'] ?? 'images/profile.png'); ?>"
                            alt="Profile"
                            class="w-20 h-20 rounded-full border-4 border-green-100 cursor-pointer"
                            id="profileImage">
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center"></div>
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
                        <img src="<?php echo URL_ROOT; ?>/images/icons/logout.png" alt="" class="h-8">
                        <span class="font-bold">Log Out</span>
                    </a>
                </div>
                <form id="editForm" class="hidden" action="<?php echo URL_ROOT; ?>/user/updateProfile" method="POST" enctype="multipart/form-data">
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

    <!-- LITTERER CONTENT -->
    <main class="flex-grow flex flex-col justify-center items-center w-full">
        <div class=" container flex flex-col justify-center items-center gap-4 px-6 mt-4 sm:mt-10 sm:px-0 md:px-10">
            <div class=" flex w-full max-w-200 justify-between mt-6 sm:mt-8 items-center">
                <h1 class=" text-md sm:text-2xl font-bold ">Report Literrer</h1>

                <div class="flex justify-center items-center gap-2 sm:gap-4 h-full">
                    <div class="bg-gray-100 flex items-center justify-center rounded-3xl shadow-2xl inset-shadow-sm inset-shadow-gray-500/50 gap-1 py-1 sm:py-1 px-2">
                        <div class="bg-green-500 flex justify-center items-center text-white text-xs sm:text-lg w-4 h-4 sm:w-6 sm:h-6 rounded-full">&#9733;</div>
                        <h1 class="text-xs sm:text-xl font-bold text-green-500 text-center"><?php echo htmlspecialchars($data['user']['points'] ?? '0.00'); ?></h1>
                    </div>

                    <div class="bg-gray-100 flex justify-center items-center p-1 w-6 h-6 sm:w-9 sm:h-9 rounded-md shadow-2xl inset-shadow-sm inset-shadow-gray-500/50">
                        <img class="transaction w-7 cursor-pointer " src="<?php echo URL_ROOT; ?>/images/icons/transaction-icon.png" alt="...">
                    </div>

                    <button id="openRedeemModal" class="bg-green-500 flex justify-center items-center py-1 w-18 sm:w-30 h-full rounded-md shadow-2xl text-center text-xs sm:text-xl text-white hover:bg-green-600" type="button">Redeem</button>
                </div>

            </div>

            <!-- form for submitting litterer report -->
            <div class="bg-gray-100 max-w-200 px-6 sm:px-8 py-6 sm:py-10 mb-6 w-full shadow-2xl rounded-lg">
                <h1 class="font-semibold">Upload Literrer Image</h1>
                <form action="<?php echo URL_ROOT; ?>/user/submitLittererReport" method="post" enctype="multipart/form-data">
                    <div class="relative h-48 sm:h-60 rounded-lg border-dashed border-2 border-green-500 bg-gray-100 flex justify-center items-center mt-2">

                        <!-- Upload Prompt -->
                        <div id="upload-prompt" class="absolute w-full px-2 max-w-full">
                            <div class="flex flex-col items-center text-center px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" height="40" viewBox="0 -960 960 960" width="40" fill="#666666">
                                    <path d="M450-313v-371L330-564l-43-43 193-193 193 193-43 43-120-120v371h-60ZM220-160q-24 0-42-18t-18-42v-143h60v143h520v-143h60v143q0 24-18 42t-42 18H220Z" />
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
                        <input type="file" id="file-input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".png,.jpg,.jpeg" name="littererImage">

                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 mt-6">
                        <div class="flex flex-col w-full gap-2">
                            <h1 class="text-gray-700 font-semibold">Name of the suspect (if applicable)</h1>
                            <input class=" px-4 bg-gray-300 rounded-md p-2 focus:outline-none" type="text" name="name" id="" placeholder="Name of the suspect">
                        </div>
                        <div class="flex flex-col w-full gap-2">
                            <h1 class="text-gray-700 font-semibold">Estimated Age</h1>
                            <input class=" px-4 bg-gray-300 rounded-md p-2 focus:outline-none" type="text" name="age" id="" placeholder="Enter age">
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 mt-6">
                        <div class="flex flex-col w-full gap-2">
                            <h1 class="text-gray-700 font-semibold">Gender</h1>
                            <select name="gender" id="gender" class="text-green-900 px-4 bg-gray-300 rounded-md p-2 focus:outline-none sm:py-3 sm:px-4 font-medium  transition-colors " aria-label="Gender">
                                <option value="" selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="flex flex-col w-full gap-2">
                            <h1 class="text-gray-700 font-semibold">Distinguishing features</h1>
                            <input class=" px-4 bg-gray-300 rounded-md p-2 focus:outline-none" type="text" name="features" id="" placeholder="(Tattoo, hair styles, hair color, skin tone)">
                        </div>
                    </div>

                    <!-- Location Section -->
                    <div class="flex flex-col mt-4 gap-2">
                        <h1 class="text-gray-700 font-semibold">Location</h1>
                        <div class="w-full h-[300px] rounded-lg">
                            <!-- location marker map -->
                            <div id="map" class="h-full z-0"></div>
                            <input type="hidden" id="latitude" name="latitude" required>
                            <input type="hidden" id="longitude" name="longitude" required>
                        </div>
                    </div>

                    <!-- submit error/success display -->
                    <?php if (!empty($data['success'])): ?>
                        <p class="text-green-500 text-center mt-4 text-xs sm:text-sm"><?php echo $data['success'] ?></p>
                    <?php endif; ?>
                    <?php if (!empty($data['error'])): ?>
                        <p class="text-red-500 text-center mt-4 text-xs sm:text-sm"><?php echo $data['error']; ?></p>
                    <?php endif; ?>

                    <button id="submit-button" class="w-full bg-green-500 mt-6 rounded-md py-1 text-lg text-center text-white hover:bg-green-600" type="submit">Submit Report</button>
                </form>
            </div>

        </div>

        <!-- Transaction Modal -->
        <div id="historyModal" class="fixed inset-0 z-50 bg-white/70 pt-10 mt-10 hidden">
            <!-- MODAL BOX -->
            <div id="modalBox" class="w-[90%] max-w-lg mx-auto max-h-135 overflow-y-auto bg-white p-4 sm:p-6 rounded-xl shadow-2xl opacity-0 translate-y-10 scale-95 transition-all duration-300 scrollbar-none">
                <hr class="w-1/4 mx-auto border-t-4 border-gray-500 rounded-full">
                <div class="flex justify-between items-center pr-4">
                    <h1 class="mt-2 text-2xl">Transactions</h1>
                    <img class="close w-5 cursor-pointer" src="<?php echo URL_ROOT; ?>/images/icons/close-icon.png" alt="...">
                </div>

                <!-- Loading state (initially shown) -->
                <div id="loadingHistory" class="mt-6 space-y-4">
                    <div class="p-8 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-spinner fa-spin text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Loading transactions...</h3>
                        <p class="text-gray-500 text-sm">Please wait while we fetch your history.</p>
                    </div>
                </div>

                <!-- Dynamic content container (populated by AJAX) -->
                <div class="mt-6 space-y-4">
                    <!-- This will be populated by the fetchHistory() function -->
                </div>
            </div>
        </div>

        <!-- Redeem Modal -->
        <div id="redeemModal" class="fixed inset-0 z-50 bg-white/70 overflow-y-auto hidden py-10 mt-10">
            <!-- MODAL BOX -->
            <div class="w-[90%] max-w-md mx-auto bg-white p-6 rounded-xl shadow-2xl">
                <div class="flex justify-center items-center w-full py-1">
                    <h1 class="w-90 rounded-md bg-gray-300 text-center p-1 font-semibold text-xl">Redeem Points</h1>
                </div>
                <!-- CONVERTION OPTIONS -->
                <div class="flex w-full justify-between mt-8 mb-4 items-center">
                    <h1 class="text-md font-bold">Select Convertion</h1>
                    <div class="flex justify-between max-w-30 h-full items-center rounded-3xl shadow-2xl inset-shadow-sm inset-shadow-gray-500/50 gap-1 px-2">
                        <div class="bg-green-500 flex justify-center items-center text-sm text-white size-4 rounded-full">&#9733;</div>
                        <h1 class="text-center text-md sm:text-lg font-bold text-green-500"><?php echo htmlspecialchars($data['user']['points'] ?? '0.00'); ?></h1>
                    </div>
                </div>

                <!-- AMOUNT OPTIONS -->
                <form id="redeem-form" method="post" action="<?php echo URL_ROOT; ?>/user/redeemPoints" enctype="multipart/form-data">
                    <div class="space-y-2 mb-4">
                        <button type="button" class="conversion-btn w-full flex justify-between items-center bg-gray-100 px-4 py-2 rounded-md hover:bg-gray-300" data-points="25.00">
                            <div class="flex gap-2 px-2 items-center">
                                <div class="bg-green-500 flex justify-center items-center text-md text-white size-5 rounded-full">&#9733;</div>
                                <h1 class="text-md font-bold text-green-500">25.00</h1>
                            </div>
                            <div class="flex w-18">
                                <span class="font-bold">&#8369; 25.00</span>
                            </div>
                        </button>
                        <button type="button" class="conversion-btn w-full flex justify-between items-center bg-gray-100 px-4 py-2 rounded-md hover:bg-gray-300" data-points="50.00">
                            <div class="flex gap-2 px-2 items-center">
                                <div class="bg-green-500 flex justify-center items-center text-md text-white size-5 rounded-full">&#9733;</div>
                                <h1 class="text-md font-bold text-green-500">50.00</h1>
                            </div>
                            <div class="flex w-18">
                                <span class="font-bold">&#8369; 50.00</span>
                            </div>
                        </button>
                        <button type="button" class="conversion-btn w-full flex justify-between items-center bg-gray-100 px-4 py-2 rounded-md hover:bg-gray-300" data-points="75.00">
                            <div class="flex gap-2 px-2 items-center">
                                <div class="bg-green-500 flex justify-center items-center text-md text-white size-5 rounded-full">&#9733;</div>
                                <h1 class="text-md font-bold text-green-500">75.00</h1>
                            </div>
                            <div class="flex w-18">
                                <span class="font-bold">&#8369; 75.00</span>
                            </div>
                        </button>
                        <button type="button" class="conversion-btn w-full flex justify-between items-center bg-gray-100 px-4 py-2 rounded-md hover:bg-gray-300" data-points="100.00">
                            <div class="flex gap-2 px-2 items-center">
                                <div class="bg-green-500 flex justify-center items-center text-md text-white size-5 rounded-full">&#9733;</div>
                                <h1 class="text-md font-bold text-green-500">100.00</h1>
                            </div>
                            <div class="flex w-18">
                                <span class="font-bold">&#8369; 100.00</span>
                            </div>
                        </button>
                    </div>

                    <!-- Hidden input for points -->
                    <input type="hidden" id="points" name="points" value="">

                    <!-- FORM INPUTS -->
                    <div class="flex flex-col gap-2">
                        <h1 class="text-md font-bold">Enter Mobile Number</h1>
                        <input type="text" id="gcashNumber" name="gcashNumber" placeholder="Enter Mobile Number" class="w-full p-2 bg-gray-200 rounded" maxlength="11" required />
                    </div>
                    <div class="flex flex-col gap-2 mt-2 mb-6">
                        <h1 class="text-md font-bold">Enter Gcash Name</h1>
                        <input type="text" id="gcashName" name="gcashName" placeholder="Gcash Name" class="w-full p-2 bg-gray-200 rounded" required />
                    </div>

                    <!-- FILE UPLOAD + PREVIEW -->
                    <h1 class="text-md font-bold">Upload Gcash QR Code</h1>
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
                            accept=".png,.jpg,.jpeg" name="gcashQR" required>
                    </div>

                    <!-- submit error/success display -->
                    <?php if (!empty($data['redeemSuccess'])): ?>
                        <p class="text-green-500 text-center mt-4 text-xs sm:text-sm"><?php echo $data['redeemSuccess'] ?></p>
                    <?php endif; ?>
                    <?php if (!empty($data['redeemError'])): ?>
                        <p class="text-red-500 text-center mt-4 text-xs sm:text-sm"><?php echo $data['redeemError']; ?></p>
                    <?php endif; ?>

                    <!-- ACTION BUTTONS -->
                    <div class="flex justify-between gap-4 mt-6">
                        <button id="closeRedeemModal" type="button" class="w-full bg-gray-300 text-gray-800 text-sm sm:text-lg py-2 rounded-md hover:bg-gray-400">Close</button>
                        <button id="submitRedeem" type="submit" class="w-full bg-green-500 text-white text-sm sm:text-lg py-2 rounded-md hover:bg-green-600">Submit Redemption</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="text-gray bg-green-50 py-2">
        <h1 class="text-center text-xs">&copyWasteWise 2025 All Rights Reserved</h1>
    </footer>
    <script>
        const URL_ROOT = '<?php echo URL_ROOT; ?>';
    </script>
    <script src="<?php echo URL_ROOT; ?>/js/profile.js"></script>
    <script src="<?php echo URL_ROOT; ?>/js/redeem.js"></script>
    <script src="<?php echo URL_ROOT; ?>/js/notifications.js"></script>
    <script src="<?php echo URL_ROOT; ?>/js/transaction.js"></script>
    <script src="<?php echo URL_ROOT; ?>/js/litterer-report.js"></script>
    <script src="<?php echo URL_ROOT; ?>/js/leaflet/leaflet.js"></script>
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

        // script for leatlet map
        L.Icon.Default.imagePath = '<?php echo URL_ROOT; ?>/js/leaflet/images/';
        // Initialize the map
        const map = L.map('map').setView([11.255255, 124.029840], 13);

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let marker = null;

        // Add click event to place marker
        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker(e.latlng).addTo(map);

            // Update form fields
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });

        // for responsive navbar(burger)
        document.addEventListener('DOMContentLoaded', () => {
            const navLinks = document.querySelector('.nav-links');
            const menuIcon = document.getElementById('menuIcon');

            window.onToggleMenu = function(icon) {
                // Toggle visibility of nav menu
                navLinks.classList.toggle('top-[0px]');
                navLinks.classList.toggle('top-[-100%]');

                // Change icon between menu and close
                if (icon.name === 'menu') {
                    icon.src = '<?php echo URL_ROOT; ?>/images/icons/close-icon.png';
                    icon.name = 'close';
                    icon.classList.remove('h-10');
                    icon.classList.add('h-6');
                } else {
                    icon.src = '<?php echo URL_ROOT; ?>/images/icons/menu.png';
                    icon.name = 'menu';
                }
            };

            //close nav if user clicks outside it
            document.addEventListener('click', (event) => {
                const isClickInsideNav = navLinks.contains(event.target);
                const isClickOnMenuIcon = menuIcon.contains(event.target);

                if (!isClickInsideNav && !isClickOnMenuIcon && menuIcon.name === 'close') {
                    navLinks.classList.remove('top-[0px]');
                    navLinks.classList.add('top-[-100%]');
                    menuIcon.src = '<?php echo URL_ROOT; ?>/images/icons/menu.png';
                    menuIcon.name = 'menu';
                }
            });

            // reset menu when switching to desktop view
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    navLinks.classList.remove('top-[0px]');
                    navLinks.classList.remove('top-[-100%]');
                    menuIcon.src = '<?php echo URL_ROOT; ?>/images/icons/menu.png';
                    menuIcon.name = 'menu';
                } else {
                    // Keep hidden by default on small screens
                    navLinks.classList.add('top-[-100%]');
                }
            });
        });
    </script>
</body>

</html>