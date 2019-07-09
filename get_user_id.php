<?php

include_once("config.php");
session_start();

$is_logged_in = $_SESSION['loggedin'];
$username = $_SESSION['username'];

function get_user($username){
	global $pdo;
	global $username;
	$get_user_info = "SELECT id FROM login WHERE username=:username";
	$get_user_stmt = $pdo->prepare($get_user_info);
	$get_user_stmt->execute(['username' => $username]);
	$get_user_post = $get_user_stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($get_user_post as $row) {
		return $row['id'];
	}
	}
$userId = get_user($username);


?>