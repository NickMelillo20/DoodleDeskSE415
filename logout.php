<?php
include 'include.php';

// Remove id from user session (log out)
unset($_SESSION['id']);

// Notify the user they logged out
$_SESSION['messages'][] = "Logged out!";

// Redirect them to the front page
header('Location: front.php');
?>
