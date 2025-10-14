<!-- app/view/auth/verify.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <link href="<?php echo URL_ROOT; ?>/css/output.css" rel="stylesheet">
</head>

<body class="flex justify-center items-center h-screen bg-gray-100">

    <?php
    $email = htmlspecialchars($data['email'] ?? ($_GET['email'] ?? ''));
    ?>

    <form action="<?php echo URL_ROOT; ?>/auth/verifyOtp" method="post" class="bg-white p-6 rounded-lg shadow-md max-w-sm w-full">
        <h2 class="text-center text-green-700 text-xl font-semibold mb-2">Verify Your Email</h2>

        <?php if ($email): ?>
            <p class="text-center text-sm text-gray-600 mb-4">
                We’ve sent a 6-digit code to
                <span class="font-semibold text-green-700"><?php echo $email; ?></span>
            </p>
        <?php endif; ?>

        <?php if (isset($data['error'])): ?>
            <p class="text-red-500 text-center mb-2"><?php echo htmlspecialchars($data['error']); ?></p>
        <?php endif; ?>

        <?php if (isset($data['success'])): ?>
            <p class="text-green-500 text-center mb-2"><?php echo htmlspecialchars($data['success']); ?></p>
        <?php endif; ?>

        <input type="hidden" name="email" value="<?php echo $email; ?>">

        <label for="otp" class="block text-sm font-medium text-green-800 mb-2">Enter the OTP:</label>
        <input type="text" id="otp" name="otp" maxlength="6" required
            class="border border-green-400 rounded-md p-2 w-full mb-4 focus:border-green-600 outline-none">

        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded w-full transition">
            Verify
        </button>

        <p class="text-xs text-gray-500 mt-3 text-center">
            Didn’t get the code?
            <a href="<?php echo URL_ROOT; ?>/auth/resendOtp?email=<?php echo urlencode($email); ?>" class="text-green-700 hover:underline">
                Resend OTP
            </a>
        </p>
    </form>

</body>

</html>