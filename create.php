<?php
include_once("config.php");
$confirmcode = rand();

//// function to insert into db after registering
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
////Function for setting messages
function message($head, $sender, $recive, $content) {
		global $pdo;
		$time = date('H:i d.m.Y');
		$message_query = "INSERT INTO message(title,user_send,user_recive,message,time_stamp) VALUES(:head, :sender, :recive, :content,:time_stamp)";
		$msg_stmt = $pdo->prepare($message_query);
		$msg_stmt->execute(['head'=>$head, 'sender'=>$sender, 'recive'=>$recive, 'content'=>$content, 'time_stamp'=>$time]);
		header("location: index.php");
}


//// Function to check is that username available
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

//// Function to get id of current user
function get_user($username){
	global $pdo;
	global $user_name;
	$get_user_info = "SELECT id FROM login WHERE username=:username";
	$get_user_stmt = $pdo->prepare($get_user_info);
	$get_user_stmt->execute(['username' => $username]);
	$get_user_post = $get_user_stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($get_user_post as $row) {
		return $row['id'];
	}
	}
function insert_ad($name,$desc,$price,$file=null, $user_id, $username) {
	global $pdo;
	$adInsert = 'INSERT INTO oglas(ad_title, ad_description, ad_price, ad_file,ad_user_id, username) VALUES(:ad_title, :ad_description, :ad_price, :ad_file, :ad_user_id, :username)';
	$adStmt = $pdo->prepare($adInsert);
	$adStmt->execute(['ad_title'=>$name, 'ad_description'=>$desc, 'ad_price'=>$price, 'ad_file'=>$file, 'ad_user_id'=> $user_id, 'username'=>$username]);
	if ($adStmt == true) {
		header("location: poslovi.php");
	}

}

session_start();
$user_name = $_SESSION['username'];
if(isset($_POST['register'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$repsw = $_POST['repsw'];
	$email = $_POST['email'];

	if($password == $repsw) {
		check_avail($username, $email);
}
	else{
		echo"Lozinke se ne podudaraju";
	}
}
if(isset($_POST['submit_job'])) {
	$ad_name = $_POST['ime_posla'];
	$ad_desc = $_POST['opis_posla'];
	$ad_price =$_POST['cijena_posla'];
	$ad_user_id = get_user($user_name);

	//// Allowed files
	$total = count($_FILES['datoteke']['name']);

	//// IF no files were found, upload null
	if($total == 0) {
		echo "No Files found!";
		insert_ad($ad_name, $ad_desc, $ad_price, $ad_user_id, $user_name);
			}

	//// If a file was found, upload them all
	else if ($total != 0){

		for($i = 0; $i < $total; $i++){
			$tpm_file_name = $_FILES['datoteke']['tmp_name'][$i];
			var_dump($tpm_file_name);
			insert_ad($ad_name, $ad_desc, $ad_price, $tpm_file_name, $ad_user_id, $user_name);
			echo "Uploaded file number " . $i;
	}
		}

}

//// Message sending and storing thing
if(isset($_POST['send_msg'])){
	$msg = $_POST['msg'];
	$sender = $_POST['sender_name'];
	$reciver = $_POST['reciver_name'];
	$title = $_POST['header'];
	echo "Nalosv: ". $title . "<br>";
	echo "Sadrzaj: ". $msg . "<br>";
	echo "Salje: " .$sender. "<br>";
	echo "Prima: " . $reciver . "<br>";
	message($title, $sender, $reciver, $msg);



}




?>
