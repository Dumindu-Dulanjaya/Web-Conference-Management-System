<?php
session_start();

// Destroy session data
session_unset();
session_destroy();

// Redirect to the login or home page
header("Location: home.html");
exit;
?>
