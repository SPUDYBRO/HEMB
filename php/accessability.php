<?php

    if (isset($_GET['accessibility'])) {
        session_start();

        if (!isset($_SESSION['accessibility'])) {
            set_accessibility_defaults();
        }

        if ($_GET['accessibility'] == 'color_scheme') { /* Color Scheme requested to be changed */

            

            if ($_SESSION['accessibility']['color_scheme'] == 'default') {
                /* was default so change to black and white */
                $_SESSION['accessibility']['color_scheme'] = "black_white";
                $success_message = "Color scheme set to black and white";

            } else {
                /* was something else so change to default */
                $_SESSION['accessibility']['color_scheme'] = 'default';
                $success_message = "Color scheme set to default";

            }

        }

        if ($_GET['accessibility'] == 'text_size') { /* Text size requested to be changed */
            if ($_SESSION['accessibility']['text_size'] == 'default') {
                /* was default so change to large */
                $_SESSION['accessibility']['text_size'] = "font_large";
                $success_message = "Font set to large";
            } elseif ($_SESSION['accessibility']['text_size'] == 'font_large') {
                /* was large so change to small */
                $_SESSION['accessibility']['text_size'] = 'font_small';
                $success_message = "Font set to small";
            } else {
                /* was something else so change to default */
                $_SESSION['accessibility']['text_size'] = 'default';
                $success_message = "Font set to default";
            }
        }


        if (isset($success_message) && !empty($success_message)) {
            $_SESSION['PHP_RESPONSE'] = array(
                'status' => 'success',
                'title' => 'Success',
                'message' => $success_message
            );
        } else {
            $_SESSION['PHP_RESPONSE'] = array(
                'status' => 'error',
                'title' => 'Failed',
                'message' => 'Something went wrong'
            );
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
}
