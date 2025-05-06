<?php

if (isset($_SESSION['PHP_RESPONSE']) && !empty($_SESSION['PHP_RESPONSE'])) {

    echo '<div class="card card_' . $_SESSION["PHP_RESPONSE"]["status"] . '">';
    echo    '<div class="countdown"></div>';
    echo    '<div class="icon_container">';
    if ($_SESSION['PHP_RESPONSE']['status'] == 'success') {
        echo '<img src="../images/check_circle.svg" alt="check mark">';
    }
    else {
        echo '<img src="../images/cross.svg" alt="circle with a cross inside">';
    }
    echo    '</div>';
    echo    '<div class="card_text">';
    echo        '<h2>' . $_SESSION['PHP_RESPONSE']['title'] . '</h2>';
    echo        '<p>' . $_SESSION['PHP_RESPONSE']['message'] . '</p>';
    echo    '</div>';
    echo '</div>';

    unset($_SESSION['PHP_RESPONSE']);
}


?>