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
		$allowed = array("image/jpg", "image/png", "image/bmp"); #array for pictures
		if(!in_array($file_type, $allowed)) { #if file is not in array, don't upload it.
			echo "Not a picture file";
		}
		else { #If file is in array, upload it.
 		$userId = get_user($username);
		$new_upload = new user($imagetmp, $userId);
		echo $new_upload->upload();
}
	}/*
	if(isset($_POST['name_change'])){

	}
	if(isset($_POST['pass_change'])){

	}*/


}



?>