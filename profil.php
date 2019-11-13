<html>
<head>
	<title>WEB poslovi | Moj profil</title>
	<link rel="stylesheet" type="text/css" href="/style/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Nudimo najbolji i najveći izbor poslova vezanih uz WEB Development. Tražite i objavljujte poslove kod nas.">
  <meta name="keywords" content="posao,web dizajn,web razvoj,php,javascript,html,html5,php developer,javascript developer,frontend,backend,web,poslovi,dizajner,programer,jquery,developer,js,stranica,web stranica,web posao, oglas,oglasnik,oglas za posao,laptop,računalo,posao od kuće,rad od kuće,rad na daljinu">
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

<script type="text/javascript">
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
</script>
</body>
</html>