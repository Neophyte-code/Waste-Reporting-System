<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WasteWise</title>
    <link href="<?php echo URL_ROOT; ?>/css/output.css" rel="stylesheet">
    <style>
        @keyframes fadeInFromTop {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOutToTop {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        .animate-fade-in-from-top {
            animation: fadeInFromTop 0.5s ease-in forwards;
        }

        .animate-fade-out-to-top {
            animation: fadeOutToTop 0.5s ease-out forwards;
        }
    </style>
</head>

<body class="font-[sans-serif] bg-gradient-to-r from-green-100 via-emerald-200 to-green-500 h-screen flex flex-col">
    <header class="bg-white w-full">
        <nav class="flex justify-between items-center w-[92%] mx-auto sm:py-0">
            <div>
                <img class="w-27 cursor-pointer" src="<?php echo URL_ROOT; ?>/images/WasteWise.png" alt="...">
            </div>
            <div class="flex items-center gap-4 sm:gap-6">
                <button id="signInBtn" class="bg-green-500 md:shadow-lg text-sm sm:text-md px-4 py-1 text-white rounded hover:bg-green-600">Sign in</button>
            </div>
        </nav>
    </header>

    <!-- AUTH CONTENT -->
    <main class="flex-grow w-full">
        <div class="p-2 sm:p-4 md:p-6 lg:p-8 h-full flex items-center justify-center w-full">
            <div class="flex flex-col lg:flex-row gap-4 sm:gap-6 px-2 sm:px-4 md:px-6 lg:px-8 items-center justify-center w-full max-w-7xl">
                <div class="p-1 mt-15 w-full py-10 order-2 sm:p-6 md:p-8 md:order-2 md:min-w-[60%] lg:order-1">
                    <h1 class="text-2xl -mt-[70px] font-bold text-black mb-2 sm:text-3xl md:text-4xl md:-mt-[10px]">Welcome to Waste<span class="text-green-500">Wise</span></h1>
                    <h3 class="text-1xl font-bold text-black mb-2 sm:text-2xl md:text-3xl ">Earn by reporting <span id="report" class="text-green-400"></span></h3>
                    <p class="mb-4 text-sm text-black sm:text-lg md:text-xl ">WasteWise is a user-friendly system designed to help individuals and communities report waste effectively. Our platform enables users to easily log and track waste, providing valuable insights into waste management practices and identifying areas for improvement. By promoting transparency and accountability, WasteWise aims to contribute to a more sustainable future for our planet.</p>
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <a href="#" id="reportWasteBtn" class="text-green-50 hover:text-green-500"><button class="w-full border-2 border-green-500 rounded py-2 px-6 text-base bg-green-500 hover:text-green hover:bg-transparent hover:border-2 hover:border-green-500 transition-colors sm:w-auto sm:text-lg md:text-xl">Report Waste</button></a>
                        <a href="#" id="reportLittererBtn" class="text-green-500 hover:text-green-50"><button class="w-full border-2 border-green-500 rounded py-2 px-6 text-base text-green hover:bg-green-500 hover:text-green-50 transition-colors sm:w-auto sm:text-lg md:text-xl">Report Litterer</button></a>
                    </div>
                </div>
                <div class="w-full lg:min-w-[30%] flex items-center justify-center p-1 order-1 lg:order-2 relative mt-4 sm:mt-6 md:mt-8 h-75 sm:h-90">
                    <!-- Responsive tree image -->
                    <img src="<?php echo URL_ROOT; ?>/images/tree3.png" alt="Tree illustration"
                        class="w-60 h-60 sm:w-75 sm:h-75 md:w-85 md:h-85 lg:w-96 lg:h-96 object-contain transition-all duration-300">
                    <!-- Login Required Modal -->
                    <div id="loginRequiredModal" class="hidden fixed top-14 left-1/2 transform -translate-x-1/2 z-50 p-4 max-w-lg w-full">
                        <div
                            role="alert"
                            class="bg-yellow-200 border-l-4 gap-2 border-yellow-600 text-yellow-800 p-2 rounded-lg flex items-center shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                            <img src="<?php echo URL_ROOT; ?>/images/icons/circle-info-solid-full.svg" class="h-5" alt="Warning Icon">
                            <p class="text-sm font-semibold">
                                Whooops! - You need to log in first to report waste or a litterer.
                            </p>
                        </div>
                    </div>


                    <!-- Auth Modal -->
                    <div id="authModal" class="hidden absolute inset-0 flex items-center justify-center z-40 p-1 sm:p-2 md:p-4">
                        <div class="relative z-10 w-full flex justify-center items-center">
                            <!-- Sign In Form -->
                            <form id="signInForm" action="<?php echo URL_ROOT; ?>/auth/login" method="post" class="form-container form-visible flex flex-col gap-3 p-4 sm:p-4 md:p-6 lg:p-8 sm:gap-3 md:gap-4 bg-white rounded-lg sm:rounded-xl md:rounded-2xl shadow-lg w-full max-w-xs sm:max-w-sm md:max-w-md">
                                <h3 class="text-center text-green-800 font-bold text-lg sm:text-xl md:text-2xl lg:text-3xl">Sign In</h3>
                                <!-- Sign in error display -->
                                <?php if (isset($data['error']) && $data['form'] === 'signin'): ?>
                                    <p class="text-red-500 text-center text-xs sm:text-sm"><?php echo htmlspecialchars($data['error']); ?></p>
                                <?php endif; ?>
                                <input type="email" name="email" placeholder="Email" required class="text-green-900 border-2 border-green-300 rounded-md p-1 sm:p-2 font-medium text-xs sm:text-sm focus:outline-none focus:border-green-500 transition-colors" aria-label="Email">
                                <div class="relative">
                                    <input type="password" name="password" placeholder="Password" required class="text-green-900 border-2 border-green-300 rounded-md p-1 sm:p-2 pr-8 font-medium text-xs sm:text-sm focus:outline-none focus:border-green-500 transition-colors w-full" aria-label="Password">
                                    <button type="button" onclick="togglePassword(this)"
                                        class="absolute right-2 sm:right-3 top-1/2 transform -translate-y-1/2 text-green-600 hover:text-green-800 focus:outline-none transition-colors">
                                        <img src="<?php echo URL_ROOT; ?>/images/icons/eye-slash-solid-full.svg"
                                            alt="Toggle Password Visibility"
                                            class="h-4 w-4">
                                    </button>
                                </div>
                                <button type="submit" class="rounded-md bg-green-600 text-white hover:bg-green-700 p-1 sm:p-2 text-xs sm:text-sm font-semibold transition-colors">Sign In</button>
                                <p class="text-center text-black text-xs sm:text-sm">Don't have an account? <button type="button" id="showSignUp" class="text-green-600 hover:text-green-700 font-medium underline">Sign Up</button></p>
                            </form>
                            <!-- Sign Up Form -->
                            <form id="signUpForm" action="<?php echo URL_ROOT; ?>/auth/register" method="post" enctype="multipart/form-data" class="form-container form-hidden flex flex-col px-6 py-4 sm:px-8 sm:py-5 lg:py-8 gap-4 bg-white rounded-lg sm:rounded-xl md:rounded-2xl shadow-lg w-full max-w-xs sm:max-w-sm md:max-w-md">
                                <h3 class="text-center text-green-800 font-bold text-lg sm:text-xl md:text-2xl lg:text-3xl">Sign Up</h3>
                                <!-- Sign up error/success display -->
                                <?php if (isset($data['error']) && $data['form'] === 'signup'): ?>
                                    <p class="text-red-500 text-center text-xs sm:text-sm"><?php echo htmlspecialchars($data['error']); ?></p>
                                <?php endif; ?>
                                <?php if (isset($data['success']) && $data['form'] === 'signup'): ?>
                                    <p class="text-green-500 text-center text-xs sm:text-sm"><?php echo htmlspecialchars($data['success']); ?></p>
                                <?php endif; ?>
                                <!-- STEP 1 -->
                                <div id="step1" class="flex flex-col gap-2 sm:gap-3">
                                    <select name="barangay" id="barangay" class="text-green-900 border-2 border-green-300 rounded-md p-1 sm:p-1.5 text-sm focus:outline-none focus:border-green-500 transition-colors">
                                        <option value="" selected>Select Barangay</option>
                                        <option value="Tapilon">Tapilon</option>
                                        <option value="Maya">Maya</option>
                                        <option value="Poblacion">Poblacion</option>
                                    </select>
                                    <div class="flex gap-3">
                                        <input type="text" name="firstname" placeholder="First Name" required class="text-green-900 border-2 border-green-300 rounded-md p-1 sm:p-1.5 text-sm focus:outline-none focus:border-green-500 w-full">
                                        <input type="text" name="lastname" placeholder="Last Name" required class="text-green-900 border-2 border-green-300 rounded-md p-1 sm:p-1.5 text-sm focus:outline-none focus:border-green-500 w-full">
                                    </div>
                                    <input type="email" name="email" placeholder="Email" required class="text-green-900 border-2 border-green-300 rounded-md p-1 sm:p-1.5 text-sm focus:outline-none focus:border-green-500">
                                    <div class="relative">
                                        <input type="password" name="password" placeholder="Password" required class="text-green-900 border-2 border-green-300 rounded-md p-1 sm:p-1.5 pr-8 font-medium text-sm focus:outline-none focus:border-green-500 transition-colors w-full" aria-label="Password">
                                        <button type="button" onclick="togglePassword(this)"
                                            class="absolute right-2 sm:right-3 top-1/2 transform -translate-y-1/2 text-green-600 hover:text-green-800 focus:outline-none transition-colors">
                                            <img src="<?php echo URL_ROOT; ?>/images/icons/eye-slash-solid-full.svg"
                                                alt="Toggle Password Visibility"
                                                class="h-4 w-4">
                                        </button>
                                    </div>
                                    <div class="relative">
                                        <input type="password" name="confirm_password" placeholder="Confirm Password" required class="text-green-900 border-2 border-green-300 rounded-md p-1 sm:p-1.5 pr-8 font-medium text-sm focus:outline-none focus:border-green-500 transition-colors w-full" aria-label="Confirm Password">
                                        <button type="button" onclick="togglePassword(this)"
                                            class="absolute right-2 sm:right-3 top-1/2 transform -translate-y-1/2 text-green-600 hover:text-green-800 focus:outline-none transition-colors">
                                            <img src="<?php echo URL_ROOT; ?>/images/icons/eye-slash-solid-full.svg"
                                                alt="Toggle Password Visibility"
                                                class="h-4 w-4">
                                        </button>
                                    </div>
                                    <button type="button" id="nextBtn" class="rounded-md bg-green-600 text-white hover:bg-green-700 p-2 text-sm font-semibold transition-colors">Next</button>
                                    <p class="text-center text-black text-xs sm:text-sm">
                                        Already have an account?
                                        <button type="button" class="showSignIn text-green-600 hover:text-green-700 font-medium underline">Sign In</button>
                                    </p>
                                </div>
                                <!-- STEP 2 -->
                                <div id="step2" class="hidden flex flex-col gap-3 relative">
                                    <button type="button" id="backBtn" class="absolute -top-11 md:-top-13 lg:-top-16 -left-2 bg-green-100 text-green-600 hover:bg-green-200 rounded-full py-0.5 px-2 shadow-md">←</button>
                                    <label class="block text-sm font-medium text-green-700">Upload Philsys ID ( Front & Back )</label>
                                    <input type="file" id="fileUpload1" name="files[]" accept="image/*" class="text-green-900 border-2 border-green-300 rounded-md p-2 text-sm focus:border-green-500">
                                    <input type="file" id="fileUpload2" name="files[]" accept="image/*" class="text-green-900 border-2 border-green-300 rounded-md p-2 text-sm focus:border-green-500">
                                    <button type="submit" class="rounded-md bg-green-600 text-white hover:bg-green-700 p-2 mt-2 sm:mt-0 text-sm font-semibold transition-colors">Register</button>
                                    <p class="text-center text-black text-xs sm:text-sm">
                                        Already have an account?
                                        <button type="button" class="showSignIn text-green-600 hover:text-green-700 font-medium underline">Sign In</button>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="text-gray bg-green-50 py-1 sm:py-2 mt-auto">
        <h1 class="text-center text-xs sm:text-sm">©WasteWise 2025 All Rights Reserved</h1>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12/lib/typed.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var typed = new Typed('#report', {
                strings: ['Waste', 'Litterer'],
                typeSpeed: 150,
                backSpeed: 100,
                backDelay: 1000,
                loop: true
            });

            // Modal elements
            const loginRequiredModal = document.getElementById('loginRequiredModal');
            const authModal = document.getElementById('authModal');
            const signInForm = document.getElementById('signInForm');
            const signUpForm = document.getElementById('signUpForm');
            const reportWasteBtn = document.getElementById('reportWasteBtn');
            const reportLittererBtn = document.getElementById('reportLittererBtn');

            // Restore modal state from localStorage
            const modalState = localStorage.getItem('modalState');
            const activeForm = localStorage.getItem('activeForm');
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

            // Show login required modal with animation when Report Waste or Report Litterer is clicked
            function showLoginModal() {
                loginRequiredModal.classList.remove('hidden', 'animate-fade-out-to-top');
                loginRequiredModal.classList.add('animate-fade-in-from-top');
                authModal.classList.add('hidden');
                setTimeout(() => {
                    loginRequiredModal.classList.remove('animate-fade-in-from-top');
                    loginRequiredModal.classList.add('animate-fade-out-to-top');
                    setTimeout(() => {
                        loginRequiredModal.classList.add('hidden');
                        loginRequiredModal.classList.remove('animate-fade-out-to-top');
                        localStorage.setItem('modalState', 'hidden');
                        localStorage.setItem('activeForm', 'signIn');
                    }, 500);
                }, 5000);
            }

            reportWasteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                showLoginModal();
            });

            reportLittererBtn.addEventListener('click', function(e) {
                e.preventDefault();
                showLoginModal();
            });

            // Show Sign Up form and reset it
            document.getElementById('showSignUp').addEventListener('click', function() {
                signInForm.classList.add('hidden');
                signUpForm.classList.remove('hidden');
                localStorage.setItem('modalState', 'visible');
                localStorage.setItem('activeForm', 'signUp');
                resetSignUpForm();
            });

            // Show Sign In form for all buttons with class 'showSignIn'
            document.querySelectorAll('.showSignIn').forEach(button => {
                button.addEventListener('click', function() {
                    signUpForm.classList.add('hidden');
                    signInForm.classList.remove('hidden');
                    authModal.classList.remove('hidden');
                    loginRequiredModal.classList.add('hidden');
                    localStorage.setItem('modalState', 'visible');
                    localStorage.setItem('activeForm', 'signIn');
                });
            });

            // Show Sign In modal when Sign In button is clicked
            document.getElementById('signInBtn').addEventListener('click', function() {
                authModal.classList.remove('hidden');
                signInForm.classList.remove('hidden');
                signUpForm.classList.add('hidden');
                loginRequiredModal.classList.add('hidden');
                localStorage.setItem('modalState', 'visible');
                localStorage.setItem('activeForm', 'signIn');
            });

            // Hide modals when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInsideLoginModal = event.target.closest('#loginRequiredModal');
                const isClickInsideAuthModal = event.target.closest('#signInForm') || event.target.closest('#signUpForm');
                const isClickOnSignInBtn = event.target.closest('#signInBtn');
                const isClickOnShowSignIn = event.target.closest('.showSignIn');
                const isClickOnReportButtons = event.target.closest('#reportWasteBtn') || event.target.closest('#reportLittererBtn');

                if (!isClickInsideLoginModal && !isClickInsideAuthModal && !isClickOnSignInBtn && !isClickOnShowSignIn && !isClickOnReportButtons) {
                    loginRequiredModal.classList.add('hidden');
                    authModal.classList.add('hidden');
                    localStorage.setItem('modalState', 'hidden');
                    localStorage.setItem('activeForm', 'signIn');
                    resetSignUpForm();
                }
            });

            // Function to reset Sign Up form
            function resetSignUpForm() {
                const signUpForm = document.getElementById('signUpForm');
                signUpForm.reset();
                const step1 = document.getElementById('step1');
                const step2 = document.getElementById('step2');
                step1.classList.remove('hidden');
                step2.classList.add('hidden');
            }
        });

        // function to show and hide password
        function togglePassword(button) {
            const input = button.previousElementSibling;
            const img = button.querySelector('img');

            if (input.type === "password") {
                input.type = "text";
                img.src = "<?php echo URL_ROOT; ?>/images/icons/eye-solid-full.svg";
            } else {
                input.type = "password";
                img.src = "<?php echo URL_ROOT; ?>/images/icons/eye-slash-solid-full.svg";
            }
        }

        // Step Navigation
        const nextBtn = document.getElementById("nextBtn");
        const backBtn = document.getElementById("backBtn");
        const step1 = document.getElementById("step1");
        const step2 = document.getElementById("step2");

        nextBtn.addEventListener("click", () => {
            step1.classList.add("hidden");
            step2.classList.remove("hidden");
        });

        backBtn.addEventListener("click", () => {
            step2.classList.add("hidden");
            step1.classList.remove("hidden");
        });

        // Step 1 field validation
        const barangaySelect = document.querySelector('#step1 select[name="barangay"]');
        const firstnameInput = document.querySelector('#step1 input[name="firstname"]');
        const lastnameInput = document.querySelector('#step1 input[name="lastname"]');
        const emailInput = document.querySelector('#step1 input[name="email"]');
        const passwordInput = document.querySelector('#step1 input[name="password"]');
        const confirmPasswordInput = document.querySelector('#step1 input[name="confirm_password"]');

        // Create password match message element
        const passwordMatchMsg = document.createElement('p');
        passwordMatchMsg.className = 'text-xs mt-1';
        confirmPasswordInput.parentElement.insertAdjacentElement('afterend', passwordMatchMsg);

        // Function to validate all step 1 fields
        function validateStep1() {
            const barangay = barangaySelect.value.trim();
            const firstname = firstnameInput.value.trim();
            const lastname = lastnameInput.value.trim();
            const email = emailInput.value.trim();
            const password = passwordInput.value.trim();
            const confirmPassword = confirmPasswordInput.value.trim();

            // Check password match
            let passwordsMatch = false;
            if (password && confirmPassword) {
                if (password === confirmPassword) {
                    passwordMatchMsg.textContent = 'Passwords match';
                    passwordMatchMsg.className = 'text-xs mt-1 text-green-600';
                    passwordsMatch = true;
                } else {
                    passwordMatchMsg.textContent = 'Passwords do not match';
                    passwordMatchMsg.className = 'text-xs mt-1 text-red-600';
                    passwordsMatch = false;
                }
            } else {
                passwordMatchMsg.textContent = '';
            }

            // Check if all fields are filled and passwords match
            const allFieldsFilled = barangay && firstname && lastname && email && password && confirmPassword && passwordsMatch;

            // Enable or disable the Next button
            if (allFieldsFilled) {
                nextBtn.disabled = false;
                nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                nextBtn.classList.add('hover:bg-green-700');
            } else {
                nextBtn.disabled = true;
                nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
                nextBtn.classList.remove('hover:bg-green-700');
            }
        }

        // Add event listeners to all step 1 fields
        barangaySelect.addEventListener('change', validateStep1);
        firstnameInput.addEventListener('input', validateStep1);
        lastnameInput.addEventListener('input', validateStep1);
        emailInput.addEventListener('input', validateStep1);
        passwordInput.addEventListener('input', validateStep1);
        confirmPasswordInput.addEventListener('input', validateStep1);

        // Run validation on page load to set initial state
        validateStep1();

        // Update the Next button click handler to include validation
        nextBtn.addEventListener("click", () => {
            if (!nextBtn.disabled) {
                step1.classList.add("hidden");
                step2.classList.remove("hidden");
            }
        });
    </script>
</body>

</html>