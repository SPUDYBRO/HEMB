<?php
    session_start();
    define('SUCCESS_SVG', '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M44 22.16V24C43.9975 28.3128 42.601 32.5094 40.0187 35.9636C37.4363 39.4179 33.8066 41.945 29.6707 43.1678C25.5349 44.3906 21.1145 44.2438 17.0689 42.7492C13.0234 41.2545 9.5693 38.4922 7.22191 34.8741C4.87452 31.2561 3.75957 26.9761 4.04334 22.6726C4.32711 18.3691 5.9944 14.2727 8.79655 10.9941C11.5987 7.71564 15.3856 5.43076 19.5924 4.48029C23.7992 3.52982 28.2005 3.96467 32.14 5.72M44 8L24 28.02L18 22.02" stroke="currentColor" stroke-opacity="1" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>');
    define('ERROR_SVG', '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none"><path d="M30 18L18 30M18 18L30 30M44 24C44 35.0457 35.0457 44 24 44C12.9543 44 4 35.0457 4 24C4 12.9543 12.9543 4 24 4C35.0457 4 44 12.9543 44 24Z" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>');
    define('NAV_SVG_ICONS', [
        'Home' => '<svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" fill="none" class="nav_icon"><g id="Navigation / House_01"><path id="Vector" d="M20 17.0002V11.4522C20 10.9179 19.9995 10.6506 19.9346 10.4019C19.877 10.1816 19.7825 9.97307 19.6546 9.78464C19.5102 9.57201 19.3096 9.39569 18.9074 9.04383L14.1074 4.84383C13.3608 4.19054 12.9875 3.86406 12.5674 3.73982C12.1972 3.63035 11.8026 3.63035 11.4324 3.73982C11.0126 3.86397 10.6398 4.19014 9.89436 4.84244L5.09277 9.04383C4.69064 9.39569 4.49004 9.57201 4.3457 9.78464C4.21779 9.97307 4.12255 10.1816 4.06497 10.4019C4 10.6506 4 10.9179 4 11.4522V17.0002C4 17.932 4 18.3978 4.15224 18.7654C4.35523 19.2554 4.74432 19.6452 5.23438 19.8482C5.60192 20.0005 6.06786 20.0005 6.99974 20.0005C7.93163 20.0005 8.39808 20.0005 8.76562 19.8482C9.25568 19.6452 9.64467 19.2555 9.84766 18.7654C9.9999 18.3979 10 17.932 10 17.0001V16.0001C10 14.8955 10.8954 14.0001 12 14.0001C13.1046 14.0001 14 14.8955 14 16.0001V17.0001C14 17.932 14 18.3979 14.1522 18.7654C14.3552 19.2555 14.7443 19.6452 15.2344 19.8482C15.6019 20.0005 16.0679 20.0005 16.9997 20.0005C17.9316 20.0005 18.3981 20.0005 18.7656 19.8482C19.2557 19.6452 19.6447 19.2554 19.8477 18.7654C19.9999 18.3978 20 17.932 20 17.0002Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g></svg>',
        'About' => '<svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" fill="none" class="nav_icon"><path fill-rule="evenodd" clip-rule="evenodd" d="M9 9C9 7.3425 10.3425 6 12 6C13.6575 6 15 7.3425 15 9C15 10.6575 13.6575 12 12 12C10.3425 12 9 10.6575 9 9ZM12 7.5C12.825 7.5 13.5 8.175 13.5 9C13.5 9.825 12.825 10.5 12 10.5C11.175 10.5 10.5 9.825 10.5 9C10.5 8.175 11.175 7.5 12 7.5Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12 13.5C9.9975 13.5 6 14.505 6 16.5V18H18V16.5C18 14.505 14.0025 13.5 12 13.5ZM12 15C14.025 15 16.35 15.9675 16.5 16.5H7.5C7.6725 15.96 9.9825 15 12 15Z" fill="currentColor"/><path fill-rule="evenodd" clip-rule="evenodd" d="M19.7778 2H4.22222C3 2 2 3 2 4.22222V19.7778C2 21 3 22 4.22222 22H19.7778C21 22 22 21 22 19.7778V4.22222C22 3 21 2 19.7778 2ZM20 4V20H4V4H20Z" fill="currentColor"/></svg>',
        'Jobs' => '<svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" fill="none" class="nav_icon"><path fill-rule="evenodd" clip-rule="evenodd" d="M6 5V4C6 2.34315 7.34315 1 9 1H15C16.6569 1 18 2.34315 18 4V5H20C21.6569 5 23 6.34315 23 8V20C23 21.6569 21.6569 23 20 23H4C2.34315 23 1 21.6569 1 20V8C1 6.34315 2.34315 5 4 5H6ZM8 4C8 3.44772 8.44772 3 9 3H15C15.5523 3 16 3.44772 16 4V5H8V4ZM19.882 7H4.11803L6.34164 11.4472C6.51103 11.786 6.8573 12 7.23607 12H11C11 11.4477 11.4477 11 12 11C12.5523 11 13 11.4477 13 12H16.7639C17.1427 12 17.489 11.786 17.6584 11.4472L19.882 7ZM11 14H7.23607C6.09975 14 5.06096 13.358 4.55279 12.3416L3 9.23607V20C3 20.5523 3.44772 21 4 21H20C20.5523 21 21 20.5523 21 20V9.23607L19.4472 12.3416C18.939 13.358 17.9002 14 16.7639 14H13C13 14.5523 12.5523 15 12 15C11.4477 15 11 14.5523 11 14Z" fill="currentColor"/></svg>',
        'Apply' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="800px" width="800px" version="1.1" id="_x32_" viewBox="0 0 512 512" xml:space="preserve" class="nav_icon"><style type="text/css">.st0{fill:currentColor;}</style><g><path class="st0" d="M276.239,252.183c-6.37,2.127-13.165,3.308-20.239,3.308c-7.074,0-13.87-1.181-20.24-3.308   c-46.272,7.599-70.489,41.608-70.489,82.877H256h90.728C346.728,293.791,322.515,259.782,276.239,252.183z"/><path class="st0" d="M256,240.788c27.43,0,49.658-22.24,49.658-49.666v-14.087c0-27.426-22.228-49.659-49.658-49.659   c-27.43,0-49.658,22.233-49.658,49.659v14.087C206.342,218.548,228.57,240.788,256,240.788z"/><path class="st0" d="M378.4,0H133.582C86.234,0,47.7,38.542,47.7,85.899v340.22C47.7,473.476,86.234,512,133.582,512h205.695   h13.175l9.318-9.301l93.229-93.229l9.301-9.31v-13.174V85.899C464.3,38.542,425.766,0,378.4,0z M432.497,386.985H384.35   c-24.882,0-45.074,20.183-45.074,45.073v48.139H133.582c-29.866,0-54.078-24.221-54.078-54.078V85.899   c0-29.874,24.212-54.096,54.078-54.096H378.4c29.876,0,54.096,24.222,54.096,54.096V386.985z"/></g></svg>',
        'Email' => '<svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" fill="none" class="nav_icon"><path d="M4 7L10.94 11.3375C11.5885 11.7428 12.4115 11.7428 13.06 11.3375L20 7M5 18H19C20.1046 18 21 17.1046 21 16V8C21 6.89543 20.1046 6 19 6H5C3.89543 6 3 6.89543 3 8V16C3 17.1046 3.89543 18 5 18Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'Staff' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 16C14.7164 14.8589 13.481 14 12 14C10.519 14 9.28364 14.8589 9 16M11 3H13M12 10H12.01M8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.0799 3 8.2V16.8C3 17.9201 3 18.4802 3.21799 18.908C3.40973 19.2843 3.71569 19.5903 4.09202 19.782C4.51984 20 5.0799 20 6.2 20H17.8C18.9201 20 19.4802 20 19.908 19.782C20.2843 19.5903 20.5903 19.2843 20.782 18.908C21 18.4802 21 17.9201 21 16.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H16M13 10C13 10.5523 12.5523 11 12 11C11.4477 11 11 10.5523 11 10C11 9.44772 11.4477 9 12 9C12.5523 9 13 9.44772 13 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>'
    ]);




    class User {
        public $ID;
        public $Username;
        public $Role;

        function __construct($id, $username, $role) {
            $this->ID = $id;
            $this->Username = htmlspecialchars($username);
            $this->Role = $role;
        }

    }



    function set_accessibility(): void {
        if (!isset($_SESSION['accessibility']) || !isset($_SESSION['accessibility']['colour_scheme']) || !isset($_SESSION['accessibility']['text_size'])) {
            $_SESSION['accessibility']["colour_scheme"] = 'default';
            $_SESSION['accessibility']["text_size"] = 'default';

        }
        

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



    /**
     * This function sets the session data required for displaying the information cards
     * User must be redirected or refreshed to see the info-card after this function is called
     * 
     * 
     * There are two types of messages that can be displayed:
     * Preview message: A short message that is displayed in the preview (when the little card slides in)
     * Detailed message: A longer message that is displayed when the user clicks on the preview message
     * 
     * keep preview message short and simple as the card can only contain a few characters and all overflow will get cut off
     * The detailed message can be as long as you want, Keep information informative and useful. make people understand why something happened
     *
     * @param string $status The type. Can only be "success" or "error" (case sensitive)
     * @param string $preview_title The title of the preview message.
     * @param string $preview_message The message to display in the preview
     * @param string $detailed_title The title of the detailed message
     * @param string $detailed_message The detailed message to display. Usually this contains info about what happened and why
     * @param string $detailed_description A description of the detailed message. usually this contains info about what the user can do, or further details the error or success
     * @param array $post_debug_data (Optional. pass null if not needed) An array of data to display in the debug table. This is usually the $_POST or $_GET data that was sent to the server
     * @return void
     */
    function set_data_response($status, $preview_title, $preview_message, $detailed_title, $detailed_message, $detailed_description, $post_debug_data = ["No data" => "No data"]): void {
        $_SESSION['PHP_RESPONSE'] = [
            'status' => $status,
            'preview_title' => $preview_title,
            'preview_message' => $preview_message,
            'detailed_title' => $detailed_title,
            'detailed_message' => $detailed_message,
            'detailed_description' => $detailed_description,
            'post_debug_data' => $post_debug_data
        ];
    }



    /**
     * Checks if the user is logged in
     * 
     * @return bool `True` if the user is logged in, `false` if not
     */
    function is_logged_in() {
        if (!isset($_SESSION['User'])) {
            return false;
        }
        return true;
    }

    /**
     * Logs a user out, retaining the accessibility settings
     * Can only be called if headers haven't been sent yet
     * 
     * @return void
     */
    function logout() {
        if (isset($_SESSION['PHP_RESPONSE'])) {
            $php_response = $_SESSION['PHP_RESPONSE'];
        }
        $accessibility = $_SESSION['accessibility'];
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['accessibility'] = $accessibility;
        if (isset($php_response)) {
            $_SESSION['PHP_RESPONSE'] = $php_response;
        }
    }