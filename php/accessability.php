<?php

    if (isset($_GET['accessibility'])) {
        session_start();

        if (!isset($_SESSION['accessibility'])) {
            set_accessibility_defaults();
        }

        if ($_GET['accessibility'] == 'color_scheme') {
            if ($_SESSION['accessibility']['color_scheme'] == 'default') {
                $_SESSION['accessibility']['color_scheme'] = "black_white";
            } else {
                echo "session set, setting default<br>";
                $_SESSION['accessibility']['color_scheme'] = 'default';
            }
        }

        if ($_GET['accessibility'] == 'text_size') {
            if ($_SESSION['accessibility']['text_size'] == 'default') {
                $_SESSION['accessibility']['text_size'] = "font_large";
            } elseif ($_SESSION['accessibility']['text_size'] == 'font_large') {
                $_SESSION['accessibility']['text_size'] = 'font_small';
            } else {
                $_SESSION['accessibility']['text_size'] = 'default';
            }
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
}
