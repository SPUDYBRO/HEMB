<?php
    session_start();
    define('SUCCESS_SVG', '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M44 22.16V24C43.9975 28.3128 42.601 32.5094 40.0187 35.9636C37.4363 39.4179 33.8066 41.945 29.6707 43.1678C25.5349 44.3906 21.1145 44.2438 17.0689 42.7492C13.0234 41.2545 9.5693 38.4922 7.22191 34.8741C4.87452 31.2561 3.75957 26.9761 4.04334 22.6726C4.32711 18.3691 5.9944 14.2727 8.79655 10.9941C11.5987 7.71564 15.3856 5.43076 19.5924 4.48029C23.7992 3.52982 28.2005 3.96467 32.14 5.72M44 8L24 28.02L18 22.02" stroke="currentColor" stroke-opacity="1" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>');
    define('ERROR_SVG', '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none"><path d="M30 18L18 30M18 18L30 30M44 24C44 35.0457 35.0457 44 24 44C12.9543 44 4 35.0457 4 24C4 12.9543 12.9543 4 24 4C35.0457 4 44 12.9543 44 24Z" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>');
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


    function display_info_card() {
        /* check if there is anything to display */
        if (!isset($_SESSION['PHP_RESPONSE']) || empty($_SESSION['PHP_RESPONSE'])) {
            return; /* There is nothing to display */
        }
        $status = $_SESSION['PHP_RESPONSE']['status'];
        $preview_title = $_SESSION['PHP_RESPONSE']['preview_title'];
        $preview_message = $_SESSION['PHP_RESPONSE']['preview_message'];

        $detailed_title = $_SESSION['PHP_RESPONSE']['detailed_title'];
        $detailed_message = $_SESSION['PHP_RESPONSE']['detailed_message'];
        $detailed_description = $_SESSION['PHP_RESPONSE']['detailed_description'];
        $post_debug_data = $_SESSION['PHP_RESPONSE']['post_debug_data'];

        echo "
        <details class='card card_$status'>
            <summary tabindex='1'>
                <div class='card_preview_container'>
                    <div class='countdown'></div>
                    <div class='icon_container'>";
                        if ($status == "success") { echo SUCCESS_SVG; }
                        else { echo ERROR_SVG; }
        echo        "</div>
                    <div class='card_text'>
                        <h2>$preview_title</h2>
                        <p>$preview_message</p>
                    </div>
                </div>
            </summary>
            <div class='card_detailed'>
                <h1>$detailed_title</h1>
                <div class='card_detailed_status'>
                    <h3>Status</h3>
                    <p>$status</p>
                </div>
                <p>$detailed_message</p>
                <p>$detailed_description</p>
                <div class='card_detailed_debug_dropdown' tabindex='1'>
                    <div class='card_detailed_debug_dropdown_preview'>
                        <p>Debug</p>
                    </div>
                    <div class='card_detailed_debug_dropdown_content tabindex='1'>
                        <h3>Post request data</h3>
                        <p>For advanced users only</p>
                        <table class='card_detailed_debug_table'>
                            <thead>
                                <th>Name/Index</th>
                                <th>Value</th>
                            </thead>
                            <tbody> ";
                                foreach($post_debug_data as $key => $value) {
                                    echo "<tr>
                                            <td>$key</td>
                                            <td>$value</td>
                                        </tr>";
                                }
        echo                "</tbody>
                        </table>
                        <p>This table shows all data sent through POST or GET</p>
                    </div>
                </div>
            </div>
            <p class='card_detailed_note'>Click anywhere Inside to close this box</p>
        </details>";

        unset($_SESSION['PHP_RESPONSE']); // Clear the PHP_RESPONSE after displaying it
    }

