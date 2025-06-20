<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WasteWise</title>
    <link href="<?php echo URL_ROOT; ?>/css/output.css" rel="stylesheet">
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</head>

<body class="font-[sans-serif] bg-gradient-to-t from-[#fbc2eb] to-[#a6c1ee] h-full w-full">
    <header class="bg-white w-full">
        <nav class="flex justify-between items-center w-[92%] mx-auto">
            <div>
                <img class="w-27 cursor-pointer" src="<?php echo URL_ROOT; ?>/images/WasteWise.png" alt="WasteWise Logo">
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
            <div class="flex items-center gap-6">
                <button id="signInBtn" class="bg-green-500 md:shadow-lg text-md px-2 py-1 text-white rounded hover:bg-green-600">Sign in</button>
                <ion-icon onclick="onToggleMenu(this)" name="menu" class="text-3xl cursor-pointer md:hidden z-1"></ion-icon>
            </div>
        </nav>
    </header>

    <!-- AUTH CONTENT -->
    <main class="flex-grow w-full">
        <div class="bg-gradient-to-r from-green-100 via-emerald-200 to-green-500 p-4 sm:p-6 md:p-0 h-screen flex items-center justify-center w-full">
            <div class="flex flex-col md:flex-col lg:flex-row gap-6 px-4 sm:px-6 md:px-8 items-center justify-center w-full md:max-w-full">
                <div class="p-1 mt-10 sm:p-6 md:p-8 w-full md:min-w-[60%] order-2 md:order-2 lg:order-1">
                    <h1 class="text-2xl -mt-[70px] md:-mt-[10px] sm:text-3xl md:text-4xl font-bold text-black mb-3">Welcome to Waste<span class="text-green-500">Wise</span></h1>
                    <h3 class="text-1xl sm:text-2xl md:text-3xl font-bold text-black mb-3">Earn by reporting <span id="report" class="text-green-400"></span></h3>
                    <p class="mb-4 text-sm sm:text-lg md:text-xl text-black">WasteWise is a user-friendly system designed to help individuals and communities report waste effectively. Our platform enables users to easily log and track waste, providing valuable insights into waste management practices and identifying areas for improvement. By promoting transparency and accountability, WasteWise aims to contribute to a more sustainable future for our planet.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/waste-reporting-system/public/" class="text-green-50 hover:text-green-500"><button class="w-full sm:w-auto border-2 border-green-500 rounded p-2 text-base sm:text-lg md:text-xl bg-green-500 hover:text-green hover:bg-transparent hover:border-2 hover:border-green-500 transition-colors">Report Waste</button></a>
                        <a href="/home" class="text-green-500 hover:text-green-50"><button class="w-full sm:w-auto border-2 border-green-500 rounded p-2 text-base sm:text-lg md:text-xl text-green hover:bg-green-500 hover:text-green-50 transition-colors">Report Litterer</button></a>
                    </div>
                </div>
                <div class="w-full md:min-w-[30%] flex items-center justify-center p-1 order-1 md:order-1 lg:order-2 relative mt-15 h-80">
                    <!-- image -->
                    <img src="<?php echo URL_ROOT; ?>/images/tree3.png" alt="Tree illustration" class="w-70 -mt-[100px] max-w-xs md:-ml-[30px] md:w-80 lg:w-90 md:max-w-sm object-contain">
                    <div id="authModal" class="hidden absolute -mt-[50px] inset-0 flex items-center justify-center z-50 p-2 sm:p-4">
                        <div class="relative z-10 w-full flex justify-center items-center">
                            <!-- Sign In Form -->
                            <form id="signInForm" action="<?php echo URL_ROOT; ?>/auth/login" method="post" class="form-container form-visible flex flex-col p-5 sm:p-6 md:p-8 gap-4 bg-white rounded-2xl shadow-lg w-full -mt-[70px] md:w-120">
                                <h3 class="text-center text-green-800 font-bold text-xl sm:text-2xl md:text-3xl mb-3">Sign In</h3>
                                <!-- Sign in error display -->
                                <?php if (isset($data['error']) && $data['form'] === 'signin'): ?>
                                    <p class="text-red-500 text-center text-sm"><?php echo htmlspecialchars($data['error']); ?></p>
                                <?php endif; ?>
                                <input type="email" name="email" placeholder="Email" required class="text-green-900 border-2 border-green-300 rounded-lg p-2 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors" aria-label="Email">
                                <div class="relative">
                                    <input type="password" name="password" placeholder="Password" required class="text-green-900 border-2 border-green-300 rounded-lg p-2 pr-10 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors w-full" aria-label="Password">
                                    <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-green-600 hover:text-green-800 focus:outline-none transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                <button type="submit" class="rounded-full bg-green-600 text-white hover:bg-green-700 p-2 text-xs sm:text-sm font-semibold transition-colors">Sign In</button>
                                <p class="text-center text-green-800 text-sm">Don't have an account? <button type="button" id="showSignUp" class="text-green-600 hover:text-green-700 font-medium underline">Sign Up</button></p>
                            </form>

                            <!-- Sign Up Form -->
                            <form id="signUpForm" action="<?php echo URL_ROOT; ?>/auth/register" method="post" class="form-container form-hidden flex flex-col p-5 sm:p-6 md:p-8 gap-4 bg-white rounded-2xl shadow-lg w-full -mt-[90px] sm:-mt-[50px] md:w-120 md:mt-2">
                                <h3 class="text-center text-green-800 font-bold text-xl sm:text-2xl md:text-3xl mb-3">Sign Up</h3>
                                <!-- Sign up error/success display -->
                                <?php if (isset($data['error']) && $data['form'] === 'signup'): ?>
                                    <p class="text-red-500 text-center text-sm"><?php echo htmlspecialchars($data['error']); ?></p>
                                <?php endif; ?>
                                <?php if (isset($data['success']) && $data['form'] === 'signup'): ?>
                                    <p class="text-green-500 text-center text-sm"><?php echo htmlspecialchars($data['success']); ?></p>
                                <?php endif; ?>
                                <select name="barangay" id="barangay" class="text-green-900 border-2 border-green-300 rounded-lg p-2 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors pr-8" aria-label="Barangay">
                                    <option value="" selected>Select Barangay</option>
                                    <option value="Tapilon">Tapilon</option>
                                    <option value="Maya">Maya</option>
                                    <option value="Poblacion">Poblacion</option>
                                </select>
                                <div class="flex gap-3">
                                    <input type="text" name="firstname" placeholder="First Name" required class="text-green-900 border-2 border-green-300 rounded-lg p-2 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors w-full" aria-label="First Name">
                                    <input type="text" name="lastname" placeholder="Last Name" required class="text-green-900 border-2 border-green-300 rounded-lg p-2 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors w-full" aria-label="Last Name">
                                </div>
                                <input type="email" name="email" placeholder="Email" required class="text-green-900 border-2 border-green-300 rounded-lg p-2 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors" aria-label="Email">
                                <div class="relative">
                                    <input type="password" name="password" placeholder="Password" required class="text-green-900 border-2 border-green-300 rounded-lg p-2 pr-10 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors w-full" aria-label="Password">
                                    <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-green-600 hover:text-green-800 focus:outline-none transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="relative">
                                    <input type="password" name="confirm_password" placeholder="Confirm Password" required class="text-green-900 border-2 border-green-300 rounded-lg p-2 pr-10 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors w-full" aria-label="Confirm Password">
                                    <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-green-600 hover:text-green-800 focus:outline-none transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                <button type="submit" class="rounded-full bg-green-600 text-white hover:bg-green-700 p-2 text-xs sm:text-sm font-semibold transition-colors">Register</button>
                                <p class="text-center text-green-800 text-sm">Already have an account? <button type="button" id="showSignIn" class="text-green-600 hover:text-green-700 font-medium underline">Sign In</button></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="text-gray bg-green-50 py-2">
        <h1 class="text-center text-xs">©WasteWise 2025 All Rights Reserved</h1>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12/lib/typed.min.js"></script>
    <script src="<?php echo URL_ROOT; ?>/js/auth.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var typed = new Typed('#report', {
                strings: ['Waste', 'Litterer'],
                typeSpeed: 150,
                backSpeed: 100,
                backDelay: 1000,
                loop: true
            });

            // Restore modal state from localStorage
            const modalState = localStorage.getItem('modalState');
            const activeForm = localStorage.getItem('activeForm');
            const authModal = document.getElementById('authModal');
            const signInForm = document.getElementById('signInForm');
            const signUpForm = document.getElementById('signUpForm');

            if (modalState === 'visible') {
                authModal.classList.remove('hidden');
                if (activeForm === 'signUp') {
                    signInForm.classList.add('hidden');
                    signUpForm.classList.remove('hidden');
                } else {
                    signInForm.classList.remove('hidden');
                    signUpForm.classList.add('hidden');
                }
            } else {
                authModal.classList.add('hidden');
                signInForm.classList.remove('hidden');
                signUpForm.classList.add('hidden');
            }
        });

        // Dropdown functionality
        function toggleDropdown() {
            const dropdown = document.getElementById("reportDropdown");
            dropdown.classList.toggle("hidden");
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById("reportDropdown");
            const button = event.target.closest('button[onclick="toggleDropdown()"]');
            if (!button && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add("hidden");
            }
        });

        // Show/hide password
        function togglePassword(button) {
            const input = button.previousElementSibling;
            const svg = button.querySelector('svg');
            if (input.type === "password") {
                input.type = "text";
                svg.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            } else {
                input.type = "password";
                svg.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                `;
            }
        }
    </script>
</body>

</html>