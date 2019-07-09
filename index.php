<html>
<head>
	<title>Stranica hehe</title>
	<link rel="stylesheet" type="text/css" href="/style/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
			<ul>
				<a href="index.php" class="btn-3d green">Početna</a>
				<a href="about.php" class="btn-3d green">O nama</a>
				<?php
                session_start();
                if(isset($_SESSION['loggedin'])==false) {
                echo"<button id='log' class='btn-3d green'>Prijava</button>";
				echo"<button id='reg' class='btn-3d green'>Registracija</button>";
                }
                ?>
                

                <?php
                session_start();
                if(isset($_SESSION['loggedin'])) {
                    echo"<a href='profil.php' class='btn-3d green'>Profil</a>";
                    echo"<a href='logout.php' class='btn-3d red'>Odjava</a>";
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
    <div id="error">
    	<p class="login_text">Lozinke se ne podudaraju!</p>
    </div>
  </div>

</div>

<script type="text/javascript" src="/js/js.js"></script>
</body>
</html>