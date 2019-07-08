<?php
$host = "localhost";
$name = "m_bockovac";
$pw = "Marcel123";
$dbname = 'user_database';

// SET DSN
$dsn = 'mysql:host='. $host .';dbname='. $dbname;

// Create a PDO instance
$pdo = new PDO($dsn, $name, $pw);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);


?>