<html>
<head>
	<title>Stranica hehe</title>
	<link rel="stylesheet" type="text/css" href="/style/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
		body {
			display: flex;
			margin: 0;
			padding: 0;
			text-align: center;
		}
	</style>
</head>
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
            if($code_post != 1 && $usercode == true) {
            echo "<div id='not_confirmed'>";
                echo"<p>Vaša e-mail adresa nije potvrđena, potvrdite e-mail adresu kako biste nastavili koristiti naše usluge.</p>";
            echo"</div>"; 
            } 
            ?>
			<ul>
				<a href="index.php" class="btn-3d green">Početna</a>
        <a href="poslovi.php" class="btn-3d green">Poslovi</a>
				<a href="about.php" class="btn-3d green">O nama</a>
        <a href='message.php' class='btn-3d green'>Poruke</a>
        <a href='profil.php' class='btn-3d green'>Profil</a>
				<a href='logout.php' class='btn-3d red'>Odjava</a>
			</ul>
		</div>
	</header>
<body>
	<div id="profilNav">

			<button class="profilNavButtons login_text" onclick='podatci()'>Podatci</button><br>
			<button class="profilNavButtons login_text" onclick='racun()'>Račun</button><br>
			<button class="profilNavButtons login_text" onclick='privatnost()'>Postavke privatnosti</button><br>

	</div>

	<div id="content" ></div>

<script>
function podatci() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("content").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "podatci.php", true);
  xhttp.send();
}

function racun() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("content").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "account.php", true);
  xhttp.send();
}

function privatnost() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("content").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "privacy.php", true);
  xhttp.send();
}
</script>
</body>
</html>