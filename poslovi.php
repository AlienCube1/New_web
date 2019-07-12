<html>
<head>
    <title>Stranica hehe</title>
    <link rel="stylesheet" type="text/css" href="/style/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">

        body {
            padding: 0;
            margin: 0;
            height: 100vh;
            text-align: center;
            display: flex;
        }

        #posao_form {

            margin: 25vh auto auto auto;
        }
        #objava {
            display: flex;

        }

        #opis {
            height: 150px;
            overflow: wrap;

        }
        #posao_form input[type=text] {
            width: 300px;
            margin: 10px;

        }

        textarea {
            border: 3px solid #999;
            border-radius: 10px;
            width: 300px;
            padding-left:10px;
            resize: vertical;
        }

        .posao_text {
            font-family: "Trebuchet MS", Helvetica, sans-serif;
            font-size: 28px;
            letter-spacing: 0px;
            word-spacing: 0px;
            color: #000000;
            font-weight: 700;
            font-style: italic;
            font-variant: small-caps;
            text-transform: none;
            text-shadow: rgb(0, 0, 0) 3px 2px 6px;
            margin: 10px;
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
<?php if($_SESSION['loggedin']==true){?>
<div id="nudim" class="posao">
    <button class="btn-3d blue large" onclick='nudim_posao()'>Nudim posao</button>
            <div class="snip1572">
                    <img onclick='nudim_posao()' src="./images/nudimposao.png">
            </div>
</div>
<?php
 }
?>
<div id="trazim" class="posao">
    <a href="index.php" class="btn-3d blue large">Tražim posao</a>
                <div class="snip1572">
                    <img onclick='trazim_posao()' src="./images/trazimposao.png">
            </div>
</div>

<div id="posao_form" style="display: none;">
    <form action="create.php" enctype="multipart/form-data" method="post">

        <p class="posao_text">Naziv posla: </p>
        <input type="text" name="ime_posla" required>



        <p class="posao_text">Opis posla: </p>
        <textarea name="opis_posla" rows="15" cols="40" required></textarea>



        <p class="posao_text">Cijena posla: </p>
        <input type="text" maxlength="25" name="cijena_posla" required>



        <p class="posao_text">Dodatne datoteke: </p><br>
        <input type="file" name="datoteke[]" multiple="multiple"><br>

        <div id="objava">
            <input class="btn-3d green" type="submit" name= 'submit_job'value="Objavi posao">
        </div>
    </form>

</div>

<script type="text/javascript" src="/js/js.js"></script>
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
</script>

</body>
</html>
