<?php

function set_accessibility_defaults(): void {
    // This session variable will carry all data related to accessibility settings, so if another accessibility feature is added, data related to toggling that will be added to this array
    $_SESSION['accessibility'] = array(
        'color_scheme' => 'default'
    );
}






