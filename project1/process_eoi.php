<?php
    session_start();

    require_once("settings.php");

    # I think it should be a html file but i just guessed so feel free to change it

    # its gonna be a php because it will need t include the header and footer and stuff - Evan
    if (!isset($_SESSION['username'])) {
      header("Location: login.php");
      exit();
    }

    echo "<h1>Welcome to your profile, " . $_SESSION['username'] . "</h1>";
?>

