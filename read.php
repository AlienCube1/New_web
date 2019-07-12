<?php

include_once('config.php');
//submit
if(isset($_POST['prijava'])) {

$username = $_POST['username'];
$password = $_POST['password'];
$hashed = md5($password);
#echo $hashed;
//// select from db
//// This is login thing, i'll rewrite it to a function later.
if($pdo) {
	$get_user = "SELECT username,password FROM login WHERE username =:username && password =:password";
	$stmt = $pdo->prepare($get_user);
	$stmt->execute(['username' => $username, 'password' => $hashed]);
	$post = $stmt->fetchAll();
	// var_dump($post);
	//// if info correct  set session and cookies accordingly
	if($post) {
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['loggedin'] = true;
		$_SESSION['Wrong_pw_user'] = false;
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
	else {
		session_start();
		$_SESSION['Wrong_pw_user'] = true;
		header('location:index.php');
	}
	}

}
//// Promjeni html klase i to ovdje, mjenjaj na <p> class, id sta god trebas, ostalo mi ne diraj, ty.
if(isset($_POST['detail'])){
	////For getting user_id
	include_once('get_user_id.php');
	$userid = get_user($username);

	$post_id = $_POST['post_id'];
	#echo "$post_id";
	include_once('config.php');
	////GET AD ID
	$sql ='SELECT * FROM oglas WHERE ad_id=:ad_id';
	$sql_stmt = $pdo->prepare($sql);
	$sql_stmt->execute(['ad_id'=>$post_id]);
	while($row = $sql_stmt->fetch(PDO::FETCH_ASSOC)){?>
	<!-- Place them all 'Nicely' :) -->
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
	<p><?php
	echo "Objavio: " . $row['username'] . '<br>';
	?></p>
	<p><?php
	$file = $row['ad_file'];

	echo"<a download href=".$row['ad_file'].">Download file</a>";

	// echo "Prilozene datoteke:: " . "<a href=" . $row['ad_file'] . "download=''>";
	#echo "Priložene datoteke: " . $row['ad_file'] . '<br>';
	?></p>
	<?php $post_desc = $row['ad_description'] ?>
	<?php $poster_name = $row['username']?>
	<p>
	<?php

	   if($row['ad_user_id']!= $userid) {
	   ?>
	   <!-- This forms are for getting contact info of user who is trying to contact and user who is contacting -->
		<form action='message.php' method='post'>
		<input type="hidden" name="post_id" value="<?php echo $post_id ?>">
		<input type="hidden" name="desc" value="<?php echo $post_desc ?>">
		<input type="hidden" name="post_name" value="<?php echo $poster_name ?>">
		<input type='submit' class='btn-3d green' value='Kontaktiraj' name='Contact'>
	</p>
	</div>
<?php
}}
echo "<a href='https://marcelbockovac.from.hr/index.php'>Povratak</a>";
}
?>
