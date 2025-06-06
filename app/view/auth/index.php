<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="<?php echo URL_ROOT; ?>/css/output.css" rel="stylesheet">
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</head>

<body class="font-[sans-serif] bg-gradient-to-t from-[#fbc2eb] to-[#a6c1ee] m-h-screen">
    <header class="bg-white">
        <nav class="flex justify-between items-center w-[92%]  mx-auto">
            <div>
                <img class="w-40 cursor-pointer" src="<?php echo URL_ROOT; ?>/images/WasteWise.png" alt="...">
            </div>
            <div class="nav-links duration-500 md:static absolute bg-white md:min-h-fit min-h-[60vh] left-0 top-[-100%] md:w-auto  w-full flex items-center px-5">
                <ul class="flex md:flex-row flex-col md:items-center md:gap-[4vw] gap-8 font-bold">
                    <li>
                        <a class="hover:text-green-500" href="#">HOME</a>
                    </li>
                    <li>
                        <a class="hover:text-green-500" href="#">ABOUT</a>
                    </li>
                    <li>
                        <a class="hover:text-green-500" href="#">CONTACT</a>
                    </li>
                    <li>
                        <a class="hover:text-green-500" href="#">ANNOUNCEMENT</a>
                    </li>
                    <li>
                        <a class="hover:text-green-500" href="#">REPORT</a>
                    </li>
                </ul>
            </div>
            <div class="flex items-center gap-6">
                <button id="signInBtn" class="bg-green-500 text-lg p-2 text-white rounded hover:bg-green-600">Sign in</button>
                <ion-icon onclick="onToggleMenu(this)" name="menu" class="text-3xl cursor-pointer md:hidden"></ion-icon>
            </div>
    </header>

    <!-- HOME CONTENT -->

    <main class="flex-grow">
        <div class="bg-gradient-to-r from-green-100 via-emerald-200 to-green-500 p-4 sm:p-6 md:p-10 min-h-screen flex items-center justify-center">
            <div class="flex flex-col text- md:flex-row gap-6 px-4 sm:px-6 md:px-20 items-center justify-center w-full max-w-7xl">
                <div class="p-4 sm:p-6 md:p-8 w-full md:min-w-[60%] order-2 md:order-1">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-black mb-3">Welcome to Waste<span class="text-green-500">Wise</span></h1>
                    <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold text-black mb-3">Earn by reporting <span id="report" class="text-green-400"></span></h3>
                    <p class="mb-4 text-base sm:text-lg md:text-xl text-black">WasteWise is a user-friendly system designed to help individuals and communities report waste effectively. Our platform enables users to easily log and track waste, providing valuable insights into waste management practices and identifying areas for improvement. By promoting transparency and accountability, WasteWise aims to contribute to a more sustainable future for our planet.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/waste-reporting-system/public/" class="text-green-50 hover:text-green-500"><button class="w-full sm:w-auto border-2 border-green-500 rounded p-2 text-base sm:text-lg md:text-xl bg-green-500 hover:text-green hover:bg-transparent hover:border-2 hover:border-green-500 transition-colors">Report Waste</button></a>
                        <a href="/home" class="text-green-500 hover:text-green-50"><button class="w-full sm:w-auto border-2 border-green-500 rounded p-2 text-base sm:text-lg md:text-xl text-green hover:bg-green-500 hover:text-green-50 transition-colors">Report Litterer</button></a>
                    </div>
                </div>
                <div class="w-full md:min-w-[30%] flex items-center justify-center p-4 order-1 md:order-2 relative mt-20">
                    <!-- image -->
                    <img src="<?php echo URL_ROOT; ?>/images/tree3.png" alt="Tree illustration" class="w-full max-w-xs md:max-w-sm object-contain">

                    <div id="authModal" class="hidden absolute inset-0 flex items-center justify-center z-50 p-2 sm:p-4">
                        <div class="relative z-10 w-full">
                            <!-- Sign In Form -->
                            <form id="signInForm" action="#" method="post" class="form-container form-visible flex flex-col p-5 sm:p-6 md:p-8 gap-4 bg-white rounded-2xl shadow-lg w-full">
                                <h3 class="text-center text-green-800 font-bold text-xl sm:text-2xl md:text-3xl mb-3">Sign In</h3>
                                <input type="email" name="email" placeholder="Email" required class="text-green-900 border-2 border-green-300 rounded-lg p-2 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors" aria-label="Email">
                                <input type="password" name="password" placeholder="Password" required class="text-green-900 border-2 border-green-300 rounded-lg p-2 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors" aria-label="Password">
                                <button type="submit" class="rounded-full bg-green-600 text-white hover:bg-green-700 p-2 text-xs sm:text-sm font-semibold transition-colors">Sign In</button>
                                <p class="text-center text-green-800 text-xs">Don't have an account? <button type="button" id="showSignUp" class="text-green-600 hover:text-green-700 font-medium">Sign Up</button></p>
                            </form>

                            <!-- Sign Up Form -->
                            <form id="signUpForm" action="#" method="post" class="form-container form-hidden flex flex-col p-5 sm:p-6 md:p-8 gap-4 bg-white rounded-2xl shadow-lg w-full">
                                <h3 class="text-center text-green-800 font-bold text-xl sm:text-2xl md:text-3xl mb-3">Sign Up</h3>
                                <select name="barangay" id="barangay" class="text-green-900 border-2 border-green-300 rounded-lg p-2 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors pr-8" aria-label="Barangay">
                                    <option value="" selected>Select Barangay</option>
                                    <option value="tapilon">Tapilon</option>
                                    <option value="maya">Maya</option>
                                    <option value="poblacion">Poblacion</option>
                                </select>
                                <div class="flex gap-3">
                                    <input type="text" name="firstname" placeholder="First Name" required class="text-green-900 border-2 border-green-300 rounded-lg p-2 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors w-full" aria-label="First Name">
                                    <input type="text" name="lastname" placeholder="Last Name" required class="text-green-900 border-2 border-green-300 rounded-lg p-2 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors w-full" aria-label="Last Name">
                                </div>
                                <input type="email" name="email" placeholder="Email" required class="text-green-900 border-2 border-green-300 rounded-lg p-2 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors" aria-label="Email">
                                <input type="password" name="password" placeholder="Password" required class="text-green-900 border-2 border-green-300 rounded-lg p-2 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors" aria-label="Password">
                                <input type="password" name="confirm_password" placeholder="Confirm Password" required class="text-green-900 border-2 border-green-300 rounded-lg p-2 font-medium text-xs sm:text-sm focus:border-green-500 transition-colors" aria-label="Confirm Password">
                                <button type="submit" class="rounded-full bg-green-600 text-white hover:bg-green-700 p-2 text-xs sm:text-sm font-semibold transition-colors">Register</button>
                                <p class="text-center text-green-800 text-xs">Already have an account? <button type="button" id="showSignIn" class="text-green-600 hover:text-green-700 font-medium">Sign In</button></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
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
        });
    </script>
</body>

</html>