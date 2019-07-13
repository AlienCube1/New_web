<html>
<head>
    <!--
    ##########################################################################################
    #Pokušao sam promjenit style da limitam descritpion, ali ne radi pa pogledaj ak nije prob#
    #Ovo izgleda retardirano ali ne mogu naci mob sada i nea mi se palit fejs na lapsu pa myb#
    #vidis ovo. BTW, trebali bi pocet dodavat komentare, ovo je fuckfest xD                  #
    ##########################################################################################
    -->
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
				<?php
				session_start();
				if(isset($_SESSION['loggedin'])) { ?>
               <div id="searchDiv">
                    <form action="update.php" method="post">
                        <input onfocusin="set_width()" onfocusout="unset_width()" type="text" name="query" placeholder="Pretraži poslove..." /><br>
                        <input id="search_submit" type="submit" value="Pretraži" name='search' />
                    </form>
                </div>
				<?php } ?>
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

<script type="text/javascript" src="/js/js.js"></script>


<div id="jobs">
<?php
include_once('config.php');
$sql = $pdo->query('SELECT * FROM oglas');
while($row = $sql->fetch(PDO::FETCH_ASSOC)){?>
<div class='ovaj-container'>
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
?>

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
        submit_search.style.width = "11vw";
    }

    function unset_width() {
        submit_search.style.width = "8vw";
    }
</script>

</body>
</html>
