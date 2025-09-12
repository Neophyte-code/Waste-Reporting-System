<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/css/output.css">
    <title>403 Forbidden</title>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
        <!-- Bigger error code -->
        <h1 class="text-6xl font-bold text-red-600 mb-4">403</h1>

        <!-- Larger "Access Denied" -->
        <p class="text-2xl font-semibold text-gray-800 mb-2">Access Denied</p>

        <p class="text-lg text-gray-700 mb-6">You don't have permission to view this page.</p>

        <img src="<?php echo URL_ROOT; ?>/images/gif/403.gif" alt="403 error" class="mx-auto mb-6">

        <a href="javascript:history.back()" class="inline-block bg-red-600 text-white px-6 py-3 rounded-full hover:bg-red-700 transition duration-300">Go Back</a>
    </div>
</body>

</html>