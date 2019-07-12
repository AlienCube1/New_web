<?php
include_once('read.php');
session_start();
if(isset($_POST['Contact'])){
	$post_id = $_POST['post_id']; #id of the post, currently not in use but don't delete
	$desc = $_POST['desc']; #description of post so I can display it fully
	$user_id = $_POST['post_name']; #id of user who posted
	$poster_name = $_POST['post_name'];#name of user who posted pic
	$sender = $_SESSION['username']; #name of user who is sending
	#echo $poster_name;
	#echo $sender;

}

?>
<html>
<head>
<!-- Im not even going to try to explain the css, I don't understand shit,it's copy paste from stack-->
<style>
.first{
     width:70%;
     height:10px;
     position:absolute;
     
 }
.second{
    width:40%;
    height:50px;
    position: relative;
    top: 50px;
}
.third{
	width:40%;
	height:10px;
	position: relative;
	top:75px;
}
.fourth{
	width:40%;
	height:10px;
	position: relative;
	top:400px;
}
</style>
</head>
<body>
	<!--- Ako mozes stavi ove labele da stoje iznad tog sveg il kak god ti izgl lijepo -->
	<div id='message'>
		<form action='create.php' method ='post'>

	<div class='first'>
		<input readonly type='text'  name= 'recipient' value='<?php echo $user_id ?>'>
		<label for='recipient'>Primatelj</label>
	</div>

	<div class='second'>
		<input type='text'  name= 'header'>
		<label for='header'>Naslov Poruke</label>
	</div>

	<div class='third'>
		<textarea rows="20" cols="50" name ='msg'></textarea>
		<label for='msg'>Sadržaj poruke</label>
	</div>

	<div class='fourth'>
		<input type='hidden' name="sender_name" value="<?php echo $sender ?>"> <!--Hidden for sending name of user -->
		<input type='hidden' name="reciver_name" value="<?php echo $poster_name ?>">
		<input type='submit' name='send_msg' value='Pošalji'>
	</div>
</form>
</div>


</body>
</html>