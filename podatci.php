<html>
<body>

<?php
include_once('get_user_id.php');
session_start();

$profile = "SELECT image FROM picture WHERE user_id= :user_id";
$stmt = $pdo->prepare($profile);
$stmt->execute(['user_id' => $userId]);


while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
$imagedata = $row['image'];
echo "<div id='okvir_slike'>";
	echo '<img width="256" height="256" src="data:image/png;base64,' .  base64_encode(stripslashes($imagedata))  . '" />';
echo "</div>";

}

?>
	<div id='objavi_sliku'>
		<form method='post' action='update.php' enctype='multipart/form-data'>
    		<input type='file' name='image' value="Odaberite datoteku">
    		<button type='submit'>Odaberi</button>
    	</form>
	</div>
</body>
</html>



