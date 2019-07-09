<?php
include_once("config.php");
$confirmcode = rand();
//// function to insert into db
function insert($username, $password, $email, $code) {
	$hashed = md5($password);
	global $pdo;
	global $confirmcode;
	global $email;
	$sql = "INSERT INTO login(username, password, email, code) VALUES (:username, :password, :email, :code)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['username'=> $username, 'password'=> $hashed, 'email' => $email, 'code' => $confirmcode]);
	//// Send email
	$ime = $_POST['username'];
	$message =
			"
			Potvrdite Vaš email kako bi počeli koristiti našu web stranicu.
			Pritisnite link ispod kako bi potvrdili svoj račun.
			https://marcelbockovac.from.hr/emailconfirm.php?username=$ime&code=$confirmcode
			";

			mail($email, "Potvrdite vašu email adresu", $message, "From: dimworks.contact@gmail.com");
			echo "Uspješno ste napravili račun, poslali smo aktivacijski email na Vašu adresu: " . $email . "<br>";
			echo " Niste dobili mail? Molimo provjerite spam mapu.";
}
function check_avail($username, $email){
	global $pdo;
	global $okay;
	global $password;
	$exists = "SELECT username FROM login WHERE username =:username OR email =:email";
	$exists_stmt = $pdo->prepare($exists);
	$exists_stmt->execute(['username' => $username, 'email' =>$email]);
	$exists_post = $exists_stmt->fetchAll();
	if($exists_post){
		echo "Username or email alredy exists!";
		// return $okay = false;
	}
	else {
		insert($username, $password, $email, $confirmcode);
	}
}
$username = $_POST['username'];
$password = $_POST['password'];
$repsw = $_POST['repsw'];
$email = $_POST['email'];

if(isset($_POST['register'])) {
	if($password == $repsw) {
		check_avail($username, $email);
}
	else{
		echo"Lozinke se ne podudaraju";
	}
}




?>