<?php

if (isset($_SESSION['PHP_RESPONSE']) && !empty($_SESSION['PHP_RESPONSE'])) {

    echo '<div class="card card_' . $_SESSION["PHP_RESPONSE"]["status"] . '">';
    echo    '<div class="countdown"></div>';
    echo    '<div class="icon_container">';
    if ($_SESSION['PHP_RESPONSE']['status'] == 'success') {
        echo    '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M44 22.16V24C43.9975 28.3128 42.601 32.5094 40.0187 35.9636C37.4363 39.4179 33.8066 41.945 29.6707 43.1678C25.5349 44.3906 21.1145 44.2438 17.0689 42.7492C13.0234 41.2545 9.5693 38.4922 7.22191 34.8741C4.87452 31.2561 3.75957 26.9761 4.04334 22.6726C4.32711 18.3691 5.9944 14.2727 8.79655 10.9941C11.5987 7.71564 15.3856 5.43076 19.5924 4.48029C23.7992 3.52982 28.2005 3.96467 32.14 5.72M44 8L24 28.02L18 22.02"
                        stroke="currentColor" stroke-opacity="1" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>';
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