<?php 
include_once("config.php");
//// Class for picture uploading, idk why I did this, but I'm trying to get the grasp of OOP.

class user {
	public $image;
	public $user_id;

	function get_pic($image, $user_id) {
		$this->image = $image;
		$this->user_id = $user_id;
	}
	function upload(){
		global $pdo;
		$sql = 'INSERT INTO picture(image, user_id) VALUES (:image, :user_id)';
		$stmt = $pdo->prepare($sql);
		$stmt->execute(["image"=>$this->image, "user_id"=>$this->user_id]);
	}

}
//// Function to get user information(id)
function get_user($username){
	global $pdo;
	$get_user_info = "SELECT id FROM login WHERE username=:username";
	$get_user_stmt = $pdo->prepare($get_user_info);
	$get_user_stmt->execute(['username' => $username]);
	$get_user_post = $get_user_stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($get_user_post as $row) {
		return $row['id'];
	}
	}

session_start();

$is_logged_in = $_SESSION['loggedin'];
$username = $_SESSION['username'];

$userId = get_user($username);
$new_upload = new user($image_file, $userId);
/*

//// Loop to check which button is pressed 
if($is_logged_in == true) {
	if(isset($_POST['upload'])){


	}
	if(isset($_POST['name_change'])){

	}
	if(isset($_POST['pass_change'])){

	}


}


*/
?>