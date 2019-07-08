<?php

include_once('config.php');

if(isset($_POST['submit'])) {

$username = $_POST['username'];
$password = $_POST['password'];
$hashed = md5($password);
//// select from db
if($pdo) {
	$get_user = "SELECT username,password FROM login WHERE username =:username && password =:password";
	$stmt = $pdo->prepare($get_user);
	$stmt->execute(['username' => $username, 'password' => $hashed]);
	$post = $stmt->fetchAll();
	//// if info correct  set session and cookies accordingly
	if($post) {
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['loggedin'] = true;
		if(!empty($_POST["remember"])) {
			setcookie ("username",$_POST["username"],time()+ 3600);
			setcookie ("password",$_POST["password"],time()+ 3600);
			} 
		else {
			setcookie("username","");
			setcookie("password","");
		}	
		if($_SESSION['loggedin']){
			header("location:index.php");
			}
		}
		}

}
?>