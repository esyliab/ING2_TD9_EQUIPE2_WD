<?php
// logout.php

// Start session
session_start();

// Destroy session
session_destroy();

// Redirect to the menu page
header("Location: menu.html");
exit();
?>
