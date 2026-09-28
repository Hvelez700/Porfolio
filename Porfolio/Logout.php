<?php
//start the session variables
session_start();
//unset all session variables
unset($_SESSION["user_id"]);
unset($_SESSION["name"]);
//destroy the session
session_destroy();
//redirect to login page
header("Location: Login.php");
exit();


?>

