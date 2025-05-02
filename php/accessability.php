<?php


    if (isset($_GET['accessibility'])) {
        session_start();

        if (!isset($_SESSION['accessibility'])) {
            echo "session not set, setting defaults<br>";
            set_accessibility_defaults(); // ensures that the session variable is set to default values
        }

        if ($_GET['accessibility'] == 'color_scheme'){
            if ($_SESSION['accessibility']['color_scheme'] == 'default') {
                echo "session set, setting black white<br>";
                $_SESSION['accessibility']['color_scheme'] = "black_white";
            }
            else {
                echo "session set, setting default<br>";
                $_SESSION['accessibility']['color_scheme'] = 'default';
            }
        }
        

        header("Location: " . $_SERVER['HTTP_REFERER']);
    }