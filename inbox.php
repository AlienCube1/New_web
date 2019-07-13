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

<?php
require_once('config.php');
session_start();

function get_message($user){
    global $pdo;
    $select_message = "SELECT * FROM message WHERE user_recive= :user_recive";
    $select_stmt = $pdo->prepare($select_message);
    $select_stmt->execute(['user_recive'=>$user]);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo $row['message'];
    }

}


$username = $_SESSION['username'];

//// Get message from database

// get_message($username);

 ?>
</html>
