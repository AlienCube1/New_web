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

	<head>
	<title>WEB poslovi | Detalji o poslu</title>
	<link rel="stylesheet" type="text/css" href="/style/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Nudimo najbolji i najveći izbor poslova vezanih uz WEB Development. Tražite i objavljujte poslove kod nas.">
    <meta name="keywords" content="posao,web dizajn,web razvoj,php,javascript,html,html5,php developer,javascript developer,frontend,backend,web,poslovi,dizajner,programer,jquery,developer,js,stranica,web stranica,web posao, oglas,oglasnik,oglas za posao,laptop,računalo,posao od kuće,rad od kuće,rad na daljinu">
    <style type="text/css">
    	#posao-container {
    		margin: 9vh 14vw 3vh 14vw;
    		width: 70vw;
    		height: 80vh;
    		padding: 1vh 1vw 1vh 1vw;
    		background: rgba(51,51,153,0.5);
    		border-radius: 100px;
    	}

    	#naslov-posla {
    		font-family: "Courier New", Courier, monospace;
    		text-transform: uppercase;
    		font-weight: 700;
    		font-size: 2vw;
    		text-align: center;
    	}

    	#opis-posla {
    		text-align: center;
    		width: 60vw;
    		height: 40vh;
    		margin: -1vh 4vw 0 4vw;
    		border-radius: 50px 50px 50px 0;
    		padding: 2vh 1vw 0 1vw;
    		background: rgba(51,51,153,0.5);
    		font-family: "Courier New", Courier, monospace;
    		font-size: 1vw;
    		font-weight: 500;
    	}

    	#cijena-posla {
    		text-align: center;
    		height: 4vh;
    		margin: 0 1vw 0 4vw;
    		border-radius: 0 0 30px 30px;
    		padding: 1vh 1vw 1vh 1vw;
    		background: rgba(51,51,153,0.5);
    		font-family: "Courier New", Courier, monospace;
    		font-size: 1vw;
    		font-weight: 550;
    		float: left;
    	}
    	#tko-je-objavio, #kontakt-btn {
    		display: inline-block;
    	}
    	#tko-je-objavio {
    		text-align: center;
    		
    		height: 4vh;
    		color: rgba(255,255,255,0.8);
    		background: rgba(68,68,68,0.5);
    		font-family: "Courier New", Courier, monospace;
    		font-size: 1vw;
    		font-weight: 500;
    		margin-right: 10vw;
    		margin-top: 0;
    		padding: 1vw 1vw 0 1vw;
    		border-radius: 0 0 30px 30px;
    		float: right;
    	}

    	#kontakt-btn {
    		text-align: center;
    		border: 3px solid rgba(68,68,68,0.7);
    		background: rgba(51,204,51,0.6);
    		height: 5vw;
    		width: 60vw;
    		border-radius: 30px;
    		padding: 0 1vw 0 1vw;
    		margin-top: 2vh;
    		margin-left: 4vw;
    		margin-right: 4vw;
    		font-family: "Courier New", Courier, monospace;
    		font-size: 2vw;
    		text-transform: uppercase;
    	}

    	#povratak-link {
    		height: 6vw;
    		width: 15vw;
    		position: fixed;
    		left: 0;
    		bottom: 0;
    		padding: 2vw 3vw 1vw 0;
    		color: rgba(255,255,255,0.8);
    		border: 3px solid rgba(51, 0, 153, 0.7);
    		background: rgba(51, 102, 153, 0.6);
    		border-radius:0% 100% 0% 100% / 100% 100% 0% 0%;
    		font-family: "Courier New", Courier, monospace;
    		text-transform: uppercase;
    		font-weight: 600;
    		font-size: 1.5vw;
    		text-shadow: 3px 3px 5px rgba(150, 150, 150, 1);
    	}

    	#povratak-link:hover, #povratak-link:focus {
    		cursor: pointer;
    		border: 3px solid rgba(31, 0, 141, 1);
    		background: rgba(35, 111, 161, 1);
    	}

    	#kontakt-btn:hover, #kontakt-btn:focus {
    		cursor: pointer;
    		border: 3px solid rgba(51, 0, 153, 1);
    		background: rgba(51,102,153,1);
    	}
    </style>
	</head>
	<body scroll="no" style="overflow: hidden;">
	<div id='posao-container'>
	<p id="naslov-posla"><?php
	echo "".$row['ad_title'];
	 ?></p>
	<p id="opis-posla"><?php
	echo "".$row['ad_description'] . '<br>';
	?></p>
	<p id="cijena-posla"><?php
	echo "Plaćanje: ".$row['ad_price'] . '<br>';
	?></p>
	<p id="tko-je-objavio"><?php
	echo "Objavio: " . $row['username'] . '<br>';
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
		<input type='submit' id="kontakt-btn" value='Kontaktirajte  <?php echo $row['username'] ?>' name='Contact'>
		</form>
	</p>
	</div>
<?php
}}
echo "<button id='povratak-link' onclick='pocetna()'>Povratak</button>";
}
?>
<script type="text/javascript">
	function pocetna() {
		window.location.replace('https://marcelbockovac.from.hr/index.php');
	}
</script>
</body>