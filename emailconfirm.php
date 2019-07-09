<?php
$username = $_GET['username'];
$code = $_GET['code'];
include_once("config.php");

	$sql = 'UPDATE login SET code=0, confirmed=1 WHERE username = :username';
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['username' => $username, ]);
	echo 'Post updated';


?>