<html>
<head>
    <title>WEB poslovi | Poruke</title>
    <link rel="stylesheet" type="text/css" href="/style/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Nudimo najbolji i najveći izbor poslova vezanih uz WEB Development. Tražite i objavljujte poslove kod nas.">
  <meta name="keywords" content="posao,web dizajn,web razvoj,php,javascript,html,html5,php developer,javascript developer,frontend,backend,web,poslovi,dizajner,programer,jquery,developer,js,stranica,web stranica,web posao, oglas,oglasnik,oglas za posao,laptop,računalo,posao od kuće,rad od kuće,rad na daljinu">
  <style type="text/css">
      #inbox_container {
        margin: 100px 0 0 100px;
        width: 300px;
        height: 400px;
      }
  </style>
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
               <!-- <div id="searchDiv">
                    <form action="update.php" method="post">
                        <input onfocusin="set_width()" onfocusout="unset_width()" type="text" name="query" placeholder="Pretraži poslove..." /><br>
                        <input id="search_submit" type="submit" value="Pretraži" />
                    </form>
                </div> -->
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
        submit_search.style.width = "11vw";
    }

    function unset_width() {
        submit_search.style.width = "8vw";
    }
</script>
</body>

<?php


function get_message($username){
    global $pdo;
    $select_message = "SELECT * FROM message WHERE user_recive= :user";
    $select_stmt = $pdo->prepare($select_message);
    $select_stmt->execute(['user'=>$username]);
    $counter = 0;
    $hour = date('H:i');
    $date = date('d.m.Y.');
    $sender = "";
    while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)){
    $sender = "";
echo "<div class='poruke-div'>";
if($row['user_send'] != $sender) {
//// Using counter so it doesnt display sender more than once.
        echo "<p id='posiljatelj-poruke'>".$row['user_send'] . "</p>";}
        echo "<p id='poruka-tekst'>". $row['message'] . "</p>";
        if($date == $row['date_of']){
            echo "<p id='vrijeme-poruka'>". $row['hour'] . "</p>";
        }
        else if ($time != $row['date_of']) {
            echo "<p id='vrijeme-poruka'>".$row['hour'] .$row['date_of'] ."</p>";
        }
    $sender == $row['user_send'];
    echo "</div>";
    #$counter +=1;
}

}
function get_sender($username){
    global $pdo;
    $select_message = "SELECT * FROM message WHERE user_recive= :user";
    $select_stmt = $pdo->prepare($select_message);
    $select_stmt->execute(['user'=>$username]);

    while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)){
        return $row['user_send'];
}


}
function send_message($username, $reciver, $msg){
    global $pdo;
    $time = date('H:i d.m.Y');
    $send_message= 'INSERT INTO message(user_send,user_recive,message,time_stamp) VALUE(:user_send, :user_recive, :message, :time_stamp)';
    $stmt_send = $pdo->prepare($send_message);
    $stmt_send->execute(['user_send'=>$username, 'user_recive'=> $reciver, 'message'=>$msg, 'time_stamp'=> $time]);
}


require_once('config.php');
session_start();
//// Get message from database
$username = $_SESSION['username'];
get_message($username);
$x = get_sender($username);



 ?>
</html>
