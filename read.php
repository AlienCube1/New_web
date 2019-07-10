<?php

include_once('config.php');
//submit
if(isset($_POST['prijava'])) {

$username = $_POST['username'];
$password = $_POST['password'];
$hashed = md5($password);
#echo $hashed;
//// select from db
if($pdo) {
	$get_user = "SELECT username,password FROM login WHERE username =:username && password =:password";
	$stmt = $pdo->prepare($get_user);
	$stmt->execute(['username' => $username, 'password' => $hashed]);
	$post = $stmt->fetchAll();
	var_dump($post);
	//// if info correct  set session and cookies accordingly
	if($post) {
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['loggedin'] = true;
		if(!empty($_POST["remember"])) {
			setcookie ("username",$_POST["username"],time()+ 3600);
			setcookie ("password",$_POST["password"],time()+ 3600);
			header("location:index.php");
			} 
		else {
			setcookie("username","");
			setcookie("password","");
			header("location:index.php");
			}			
		}
	}
}
//// Promjeni html klase i to ovdje, mjenjaj na <p> class, id sta god trebas, ostalo mi ne diraj, ty.
if(isset($_POST['detail'])){
	$post_id = $_POST['post_id'];
	echo "$post_id";
	include_once('config.php');
	$sql ='SELECT * FROM oglas WHERE ad_id=:ad_id';
	$sql_stmt = $pdo->prepare($sql);
	$sql_stmt->execute(['ad_id'=>$post_id]);
	while($row = $sql_stmt->fetch(PDO::FETCH_ASSOC)){?>
	<div id='ovaj-container'>
	<p><?php
	echo "Naziv posla: ".$row['ad_title'];
	 ?></p>
	<p><?php
	echo "Opis posla: ".$row['ad_description'] . '<br>';
	?></p>
	<p><?php
	echo "Cijena: ".$row['ad_price'] . '<br>';
	?></p>
	</div>
<?php
}
echo "<a href='https://marcelbockovac.from.hr/index.php'>Povratak</a>";
}
?>
