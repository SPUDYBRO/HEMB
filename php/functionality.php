<?php

function set_accessibility_defaults(): void {
    // This session variable will carry all data related to accessibility settings, so if another accessibility feature is added, data related to toggling that will be added to this array
    $_SESSION['accessibility'] = array(
        'color_scheme' => 'default',
        'text_size' => 'default'
    );
}


function set_accessibility(): void {

    $preferences = implode(" ", array_filter(
        $_SESSION['accessibility'],
        function($array_item) {
            return !str_contains($array_item, "default");
        }
    ));

    if ($preferences == "") {
        echo ""; // No accessibility settings are set, so do nothing
    }
    else {
        echo $preferences; // Accessibility settings are set, so return them
    }
}




session_start();

if (!isset($_SESSION['accessibility']) ||
    !isset($_SESSION['accessibility']['color_scheme']) ||
    !isset($_SESSION['accessibility']['text_size'])) { // check if the accessibility array is set for this user
        set_accessibility_defaults();
}


