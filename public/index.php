<?php


// Start session with configuration
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_secure', '0'); // Set to '1' for HTTPS in production
    ini_set('session.use_strict_mode', '1'); // Prevent session fixation
    session_name('WasteWiseSession'); // Custom session name
    session_start();
}

require_once '../app/init.php';

$app = new App;
