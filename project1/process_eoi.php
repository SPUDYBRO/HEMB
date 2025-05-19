<?php
    session_start();

    require_once("settings.php");

    # I think it should be a html file but i just guessed so feel free to change it
    if (!isset($_SESSION['username'])) {
      header("Location: login.html");
      exit();
    }

    echo "<h1>Welcome to your profile, " . $_SESSION['username'] . "</h1>";
?>

