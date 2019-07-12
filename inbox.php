<?php
require_once('config.php');
session_start();


class message{
    private $username;


    //// Construct params
    function __construct($username) {
        $this->username = $username;

    }
    //// Get message from database.
    function get_message() {
        global $pdo;
        $sql = "SELECT * FROM message WHERE user_recive=:user_recive";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_recive' => $this->username]);
        #$post = $stmt->fetchall(PDO::FETCH_ASSOC);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<div>";
            echo "<p>"."Title: " . $row['title'] . "</p>". "<br>";
            echo "<p>"."Sender: " . $row['user_send'] . "</p>". "<br>";
            echo "<p>"."Message: " . $row['message'] ."</p>". "<br>";
            echo "<p>"."Time: " . $row['time_stamp'] . "</p>"."<br>";
            echo "</div>";
        }   echo"<a href='https://marcelbockovac.from.hr/index.php'>Povratak</a>";
    }


    function display() {


    }

}

$username = $_SESSION['username'];

//// Get message from database
$new_message = new message($username);
$new_message->get_message();

// get_message($username);

 ?>
