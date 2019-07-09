<html>
<body>

	<div id="promjena1">
		<form  action='update.php' method='post'>
			<p id="login_text">Promjenite ime</p>
			<input type='text' name='change_username'><br>
			<input type='submit' name='name_change'class='btn-3d green' value='Promjena imena'>
		</form>
	</div>
	<div id="promjena2">
		<p id = "login_text">Promjenite lozinku</p>
		<form  action='update.php' method='post'>

			<p class="login_text">Unesite staru lozinku</p>
			<input type='password' name='change_password'>

			<p class ="login_text">Unesite novu lozinku</p> 
			<input type='password' name='repeat_pw'><br>

			<input type='submit' name='pass_change'class='btn-3d green' value='Promjena lozinke'>
		</form>
	</div>


</body>
</html>