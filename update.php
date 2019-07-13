<?php
include_once("config.php");
session_start();

$is_logged_in = $_SESSION['loggedin'];
$username = $_SESSION['username'];
//// Class for picture uploading, idk why I did this, but I'm trying to get the grasp of OOP.

class user {
	private $imagetmp;
	private $userId;
	function __construct($imagetmp, $userId) {
		$this->imagetmp = $imagetmp;
		$this->userId = $userId;

	}
	function upload(){
		global $pdo;
		$sql = 'INSERT INTO picture(image, user_id) VALUES (:image, :user_id)';
		$stmt = $pdo->prepare($sql);
		$stmt->execute(["image"=>$this->imagetmp, "user_id"=>$this->userId]);
		echo "UPLOAD";
		header("location: profil.php");

	}

}
//// Function to get user information(id)
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








//// Loop to check which button is pressed
if($is_logged_in == true) {

	if(isset($_POST['upload'])){
		$user_id = get_user($username);
		///Check if user alredy has a profile picture, if he does delete it so he can upload a new one.
		$check_user = "SELECT image FROM picture WHERE user_id = :user_id";
		$check_stmt = $pdo->prepare($check_user);
		$check_stmt->execute(['user_id' => $user_id]);
		if($check_stmt) {
			$delete = "DELETE FROM picture WHERE user_id = :user_id";
			$stmt = $pdo->prepare($delete);
			$stmt->execute(['user_id'=> $user_id]);
		}

		////VARS FOR PICTURE INFO
		$imagetmp  = addslashes (file_get_contents($_FILES['image']['tmp_name'])); #Picture
		$file_type = $_FILES['image']['type']; #File type of picture
		$allowed = array("image/jpeg", "image/png", "image/bmp"); #array for pictures
		if(!in_array($file_type, $allowed)) { #if file is not in array, don't upload it.
			echo "Not a picture file";
		}
		else { #If file is in array, upload it.
 		$userId = get_user($username);
		$new_upload = new user($imagetmp, $userId);
		echo $new_upload->upload();
}
	}
	//// Query to update username with new username and return to profil.php
	if(isset($_POST['name_change'])){
		$new_username = $_POST['change_username'];
		$usersId = get_user($username);
		$sqlId = 'UPDATE login SET username = :username WHERE id = :id';
		$stmtId = $pdo->prepare($sqlId);
		$stmtId->execute(['username' => $new_username, 'id'=> $usersId]);
		echo 'Post updated';
		$_SESSION['username'] = $new_username;
		header("location: profil.php");



	}
	//// Query to update password, first check if old password is valid, and if it is change it to new
	if(isset($_POST['pass_change'])){
		$old_password = $_POST['change_password'];
		$hashed_old = md5($old_password);
		$new_password = $_POST['repeat_pw'];
		$hashed_new = md5($new_password);
		$idusera = get_user($username);
		$sqlOld = "SELECT password FROM login WHERE id = :id";
		$stmtOld = $pdo->prepare($sqlOld);
		$stmtOld->execute(['id' => $idusera]);
		$postOld = $stmtOld->fetchAll(PDO::FETCH_ASSOC);
		foreach($postOld as $old_pw) {
			$old_password_old = $old_pw['password'];
		}//// If old password is equal to new password, change it
		if($hashed_old == $old_password_old) {
			$sqlNew = 'UPDATE login SET password = :new_password WHERE id = :id';
			$stmtNew = $pdo->prepare($sqlNew);
			$stmtNew->execute(['new_password' => $hashed_new, 'id'=> $idusera]);
			echo 'Post updated';
			header("location: logout.php");
		}
	}
	if(isset($_POST['search'])){
		$searching_for = $_POST['query'];
		$search = "%".$searching_for."%";
		echo $search . "<br>";
		#echo $searching_for;
		$query = 'SELECT * FROM oglas WHERE ad_title LIKE :search';
		$stmt = $pdo->prepare($query);

		#$stmt->execute(['search' => '%' . $searching_for . '%']);
		$stmt->execute(['search'=>$search]);
		#$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		echo $row['ad_title'] . "<br>";
		echo $row['ad_description'] . "<br>";

}

	}




}



?>
