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
		//// Get old password, use md5 to check is it the same as db entry
		$old_password = $_POST['change_password'];
		$hashed_old = md5($old_password);
		//// Get new password, use md5 to check is it the same as db entry
		$new_password = $_POST['repeat_pw'];
		$hashed_new = md5($new_password);

		//// Get user id with get_user function
		$idusera = get_user($username);
		//// Query to select password where id of user is same as current users id
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
?>
	<html>
	<head>

		<title>WEB poslovi | Najbolji izbor poslova za internetske stranice</title>
		<link rel="stylesheet" type="text/css" href="/style/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Nudimo najbolji i najveći izbor poslova vezanih uz WEB Development. Tražite i objavljujte poslove kod nas.">
		<meta name="keywords" content="posao,web dizajn,web razvoj,php,javascript,html,html5,php developer,javascript developer,frontend,backend,web,poslovi,dizajner,programer,jquery,developer,js,stranica,web stranica,web posao, oglas,oglasnik,oglas za posao,laptop,računalo,posao od kuće,rad od kuće,rad na daljinu">
		<script src='https://unpkg.com/bodymovin-web-components@1.1.0/dist/bodymovin-web-components.js'></script>
	</head>
	<body>
		<?php
		if(isset($_COOKIE["username"])){
			$user_name = $_COOKIE['username'];
			session_start();
			$_SESSION['username'] = $user_name;
			$_SESSION['loggedin'] = true;
			}

		?>

		<header>
			<div id="nav">
				<?php
				session_start();
				include_once("config.php");
				$usercode = $_SESSION['username'];
				$code = "SELECT confirmed FROM login WHERE username = :username";
				$stmtcode = $pdo->prepare($code);
				$stmtcode->execute(['username' => $usercode]);
				$postcode = $stmtcode->fetchAll(PDO::FETCH_ASSOC);
				foreach($postcode as $row) {
					$code_post = $row['confirmed'];
				}
				if($code_post != 1 && $usercode==true) {
				echo "<div id='not_confirmed'>";
					echo"<p>Vaša e-mail adresa nije potvrđena, potvrdite e-mail adresu kako biste nastavili koristiti naše usluge.</p>";
				echo"</div>";
				}
				?>
				<ul>
					<button class="navbutton" onclick="pocetna()">Početna</button>
					<button class="navbutton" onclick="poslovi()">Poslovi</button>
					<button class="navbutton" onclick="about()">O nama</button>
					<?php
					session_start();
					if(isset($_SESSION['loggedin'])==false) {
					echo"<button id='log' class='navbutton'>Prijava</button>";
					echo"<button id='reg' class='navbutton'>Registracija</button>";
					}
					?>


					<?php
					session_start();
					if(isset($_SESSION['loggedin'])) {
						echo"<button class='navbutton' onclick='poruke()'>Poruke</button>";
						echo"<button class='navbutton' onclick='profil()'>Profil</button>";
						echo"<button class='navbuttonred' onclick='logout()'>Odjava</button>";
					}

					?>
				   <div id="searchDiv">
						<form action="/" method="post">
							<input onfocusin="set_width()" onfocusout="unset_width()" type="text" name="query" placeholder="Pretraži poslove..." /><br>
							<input id="search_submit" type="submit" value="Pretraži" />
						</form>
					</div>
				</ul>
			</div>

		</header>
		<div id="modalLog" class="modal">

	  <!-- Modal content -->
	  <div class="modal-content">
		<span class="close">&times;</span>
		<form action="read.php" method="post">

			<p class="login_text">Korisničko ime: </p>
			<input type="text" name="username" placeholder="Unesite korisničko ime">

			<p class="login_text">Lozinka: </p>
			<input type="password" name="password" placeholder="Unesite lozinku">

			<p class="checkbox" class="login_text">Zapamti me?</p>
			<input class="checkbox" id="checkbox" type="checkbox" name="remember">

			<input type="submit" name="prijava" class="btn-3d green" value="Prijava">
		</form>
	  </div>

	</div>
		<div id="modalReg" class="modal">

	  <!-- Modal content -->
	  <div class="modal-content">
		<span class="close">&times;</span>
		<form action="create.php" method="post">

			<p class="login_text">Korisničko ime: </p>
			<input type="text" name="username" placeholder="Unesite korisničko ime">

			<p class="login_text">E-mail adresa: </p>
			<input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Molimo da unesete pravilnu E-mail adresu.' : '')" placeholder="Unesite E-mail adresu" id="emailfield" required>

			<p class="login_text">Lozinka: </p>
			<input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Lozinka mora sadržavati najmanje 8 znakova, jednu znamenku, jedno veliko i jedno malo slovo.' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" placeholder="Unesite lozinku" required>

			<p class="login_text">Ponovite lozinku: </p>
			<input type="password" name="repsw"  id="password_two" placeholder="Ponovno unesite lozinku" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Molimo da unesete istu lozinku.' : '');" required>

			<input type="submit" name="register" class="btn-3d green" value="Registriraj me">
		</form>
	  </div>

	</div>
	<script type="text/javascript">


	    function trazim_posao() {
	        window.location.replace("http://marcelbockovac.from.hr/index.php");
	    }
	    function nudim_posao() {
	        document.getElementsByClassName("posao")[0].style.display = "none";
	        document.getElementsByClassName("posao")[1].style.display = "none";
	        document.getElementById("posao_form").style.display = "block";
	    }
	    function pocetna() {
	        window.location.replace("http://marcelbockovac.from.hr/index.php");
	    }
	    function poslovi() {
	        window.location.replace("https://marcelbockovac.from.hr/poslovi.php");
	    }
	    function about() {
	        window.location.replace("https://marcelbockovac.from.hr/about.php");
	    }
	    function profil() {
	        window.location.replace("https://marcelbockovac.from.hr/profil.php");
	    }
	    function logout() {
	        window.location.replace("https://marcelbockovac.from.hr/logout.php");
	    }
	    function poruke() {
	        window.location.replace("https://marcelbockovac.from.hr/inbox.php");
	    }
	    var submit_search = document.getElementById("search_submit");
	    function set_width() {
	        submit_search.style.width = "200px";
	    }

	    function unset_width() {
	        submit_search.style.width = "130px";
	    }
	</script>



<?php	//// Search bar functionality
	if(isset($_POST['search'])){
		echo"<div id ='jobs'>";
		$searching_for = $_POST['query'];
		$search = "%".$searching_for."%";
		#$echo $search . "<br>";
		#echo $searching_for;
		$query = 'SELECT * FROM oglas WHERE ad_title LIKE :search';
		$stmt = $pdo->prepare($query);

		#$stmt->execute(['search' => '%' . $searching_for . '%']);
		$stmt->execute(['search'=>$search]);
		#$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		echo "<div class='ovaj-container'>";?>
		<p class="login_text"><?php
		echo "".$row['ad_title'];
		 ?></p>
		<p class='claimedRight opis-posla'><?php
		echo "".$row['ad_description'] . '<br>';
		?></p>
		<p class="cijena-posla"><?php
		echo "Plaćanje: ".$row['ad_price'] . '<br>';
		?></p>
		<p class="objavio"><?php
		echo "Objavio: ".$row['username'] . '<br>';?></p>
		<form action ='read.php' method='post'>
		    <input type="hidden" name="post_id" value="<?php echo $row['ad_id'] ?>">
		    <input type='submit' class='detalji-button' value='Detalji' name='detail'>
		</form>
		</div>
<?php
}

	}




}



?>
</body>
</html>
