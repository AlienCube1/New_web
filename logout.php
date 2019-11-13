<?php
session_start();
unset($_SESSION["loggedin"]);
unset($_SESSION["username"]);
session_destroy();
setcookie('username', "", time() - 3600);
setcookie('password', "", time() - 3600);
header("Location: index.php");
die;


?>
