<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="<?php echo URL_ROOT; ?>/css/output.css" rel="stylesheet">
</head>

<body class="box-border m-0 p-0 static font-sans flex flex-col min-h-screen">
    <header>
        <nav class="bg-green-50 p-4 drop-shadow-2xl">
            <div class="flex justify-around items-center ">
                <a href="/public/" class=" text-3xl font-bold">Waste<span class="text-green-500">Wise</span></a>
                <ul class="flex gap-4 font-semibold text-lg">
                    <li><a href="/" class="text-black hover:text-green-500">HOME</a></li>
                    <li><a href="/about" class="text-black hover:text-green-500">ABOUT</a></li>
                    <li><a href="/contact" class="text-black hover:text-green-500">CONTACT</a></li>
                    <li><a href="/services" class="text-black hover:text-green-500">REPORT</a></li>
                </ul>
                <div>
                    <button id="login" class="bg-green-500 text-lg p-2 text-white rounded hover:bg-green-600">Login</button>
                </div>
            </div>
        </nav>
    </header>

    <!-- HOME CONTENT -->

    <main class="flex-grow">
        <div class="bg-gradient-to-r from green-200 via-emerald-200 to-cyan-200 bg-cover bg-no-repeat p-10 h-screen flex items-center justify-center text-sm/7">
            <div class="flex gap-15 m-20 items-center justify-center">
                <div class="p-5 min-w-3/4">
                    <h1 class="text-6xl font-bold text-black mb-3">Welcome to Waste<span class="text-green-500 ">Wise</span></h1>
                    <h3 class="text-black text-5xl font-bold mb-3">Earn by reporting <span id="report" class="text-red-400"></span> </h3>
                    <p class="mb-3 text-xl text-black">WasteWise is a user-friendly system designed to help individuals and communities report waste effectively. Our platform enables users to easily log and track waste, providing valuable insights into waste management practices and identifying areas for improvement. By promoting transparency and accountability, WasteWise aims to contribute to a more sustainable future for our planet.</p>
                    <div class="flex gap-4">
                        <a href="/public/home" class="text-green-50 hover:text-green-500"><button class="border-2 border-green-500 rounded p-2 text-xl bg-green-500 hover:text-green hover:bg-transparent hover:border-2 hover:border-green-500">Report Waste</button></a>
                        <a href="/public/home" class="text-green-500 hover:text-green-50"><button class="border-2 border-green-500 rounded p-2 text-xl text-green hover:bg-green-500">Report Litterer</button></a>
                    </div>
                </div>
                <div class="bg-white-400 gap-4 flex flex-col min-w-1/3 drop-shadow-2xl">
                    <!-- Register -->
                    <form id="signUpForm" action="/MVC-PRACTICE/public/auth/register" method="post" class="hidden flex flex-col p-10 gap-5 bg-green-50 rounded-xl">
                        <h3 class="text-center text-green-950 font-bold text-4xl">Sign Up</h3>
                        <input type="text" name="firstname" placeholder="First Name" required class="text-green-900 border-2 border-green-500 rounded p-1 font-bold">
                        <input type="text" name="lastname" placeholder="Last Name" required class="text-green-900 border-2 border-green-500 rounded p-1 font-bold">
                        <input type="text" name="email" placeholder="Email" required class="text-green-900 border-2 border-green-500 rounded p-1 font-bold">
                        <input type="password" name="password" placeholder="Password" required class="text-green-900 border-2 border-green-500 rounded p-1 font-bold">
                        <button type="submit" class="rounded-full bg-green-500 text-white hover:bg-green-600">Register</button>
                        <p class="text-center text-green-950">Already have an account? <span><button type="button" id="showSignIn" class="text-green-500">Sign In</button></span></p>
                    </form>

                    <!-- Login -->
                    <form id="signInForm" action="/MVC-PRACTICE/public/auth/login" method="post" class="hidden flex flex-col p-10 gap-5 bg-green-50 rounded-xl">
                        <h3 class="text-center text-green-950 font-bold text-4xl">Sign In</h3>
                        <input type="text" name="email" placeholder="Email" required class="text-green-900 border-2 border-green-500 rounded p-1 font-bold">
                        <input type="password" name="password" placeholder="Password" required class="text-green-900 border-2 border-green-500 rounded p-1 font-bold">
                        <button type="submit" class="rounded-full bg-green-500 text-white hover:bg-green-600">Register</button>
                        <p class="text-center text-green-950">Don't have an account? <span><button type="button" id="showSignUpLink" class="text-green-500">Sign Up</button></span></p>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script src="/public/js/home.js"></script>


    <footer class="text-gray bg-green-50 py-4">
        <h1 class="text-center">&copyWasteWise 2025 All Rights Reserved</h1>
    </footer>
</body>

</html>