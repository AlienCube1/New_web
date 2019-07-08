<?php

include_once('config.php');
$username = $_POST['username'];
$password = $_POST['password'];

if($pdo) {
	$get_user = "SELECT username,password FROM login WHERE username =:username && password =:password";
	$stmt = $pdo->prepare($get_user);
	$stmt->execute(['username' => $username, 'password' => $password]);
	$post = $stmt->fetchAll();
	if($post) {
		echo "Succes";
	}
}


?>