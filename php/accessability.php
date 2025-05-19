<?php
    session_start();
    // Constants for colour schemes
    define('COLOUR_SCHEME_DEFAULT', 'default');
    define('COLOUR_SCHEME_BLACK_WHITE', 'black_white');

    // constants for text sizes
    define('TEXT_SIZE_DEFAULT', 'default');
    define('TEXT_SIZE_LARGE', 'font_large');
    define('TEXT_SIZE_SMALL', 'font_small');

    // constants for Setting possibilities
    define('COLOUR_SCHEME_OPTIONS', [
        COLOUR_SCHEME_DEFAULT,
        COLOUR_SCHEME_BLACK_WHITE
    ]);
    define('TEXT_SIZE_OPTIONS', [
        TEXT_SIZE_DEFAULT,
        TEXT_SIZE_LARGE,
        TEXT_SIZE_SMALL
    ]);

    function set_accessibility_defaults(): void {
        // Set default values for accessibility settings
        $_SESSION['accessibility']['colour_scheme'] = COLOUR_SCHEME_DEFAULT;
        $_SESSION['accessibility']['text_size'] = TEXT_SIZE_DEFAULT;
    }


    // Function to toggle between modes

    /**
     * A dynamic switch to toggle between colour schemes for the website.
     * 
     * To add a new colour scheme, add it to the `COLOUR_SCHEME_OPTIONS` array.
     * you will also need to add a description and response message
     * 
     *
     * @return string The new colour scheme.
     * Note: Automatically sets the accessibility session variable for colour scheme.
     */
    function toggle_colour_scheme(): array {

        $current = $_SESSION['accessibility']['colour_scheme'] ?? COLOUR_SCHEME_DEFAULT;

        $index = array_search($current, COLOUR_SCHEME_OPTIONS);

        if ($index === false) {
            $index = 0; // Invalid current colour scheme
        }

        // next index (wraps around)
        $next_index = ($index + 1) % count(COLOUR_SCHEME_OPTIONS);

        $_SESSION['accessibility']['colour_scheme'] = COLOUR_SCHEME_OPTIONS[$next_index];
        $new = $_SESSION['accessibility']['colour_scheme'];

        $detailed_description = '';
        if ($new == COLOUR_SCHEME_DEFAULT) {
            $detailed_description = 'Default colour scheme is the standard colour scheme for the website, providing a balanced and visually appealing experience.';
        } elseif ($new == COLOUR_SCHEME_BLACK_WHITE) {
            $detailed_description = 'Black and white colour scheme is designed to enhance readability and accessibility for users with visual impairments.';
        }

        return $response_data = [
            'status' => 'success',
            'preview_title' => 'Colour scheme changed',
            'preview_message' => 'Colour scheme changed to ' . $new,
            'detailed_title' => 'Colour scheme changed to ' . $new,
            'detailed_message' => 'Your preferred colour scheme has been set to ' . $new,
            'detailed_description' => $detailed_description
        ];
    }

    /**
     * A dynamic switch to toggle between text sizes for the website.
     * 
     * To add a new text size, add it to the `TEXT_SIZE_OPTIONS` array.
     * you will also need to add a description and response message
     * 
     *
     * @return string The new text size.
     * Note: Automatically sets the accessibility session variable for text size.
     */
    function toggle_text_size(): array {

        $current = $_SESSION['accessibility']['text_size'] ?? TEXT_SIZE_DEFAULT;

        $index = array_search($current, TEXT_SIZE_OPTIONS);

        if ($index === false) {
            $index = 0; // Invalid current text size
        }

        // next index (wraps around)
        $next_index = ($index + 1) % count(TEXT_SIZE_OPTIONS);

        $_SESSION['accessibility']['text_size'] = TEXT_SIZE_OPTIONS[$next_index];
        $new = $_SESSION['accessibility']['text_size'];

        $detailed_description = '';
        if ($new == TEXT_SIZE_DEFAULT) {
            $detailed_description = 'Default text size is the standard text size for the website, being in the middle of large and small it leaves the website looking as intended.';
        } elseif ($new == TEXT_SIZE_LARGE) {
            $detailed_description = 'Increased text size is made to help those with visual impairments read the text on the website easier.';
        } elseif ($new == TEXT_SIZE_SMALL) {
            $detailed_description = 'Decreased text size is to help those on smaller devices have a better content flow.';
        }

        return $response_data = [
            'status' => 'success',
            'preview_title' => 'Text size changed',
            'preview_message' => 'Text size changed to ' . $new,
            'detailed_title' => 'Text size changed to ' . $new,
            'detailed_message' => 'Your preferred text size has been set to ' . $new,
            'detailed_description' => $detailed_description
        ];

    }


    function set_data_response($status, $preview_title, $preview_message, $detailed_title, $detailed_message, $detailed_description, $post_debug_data): void {
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



    if ($_SERVER['REQUEST_METHOD'] === 'GET') {


        if (isset($_GET['accessibility']))
        // Check if the request is for toggling colour scheme
            if ($_GET['accessibility'] == 'colour_scheme') {
                $response_data = toggle_colour_scheme();
                set_data_response($response_data['status'], $response_data['preview_title'], $response_data['preview_message'], $response_data['detailed_title'], $response_data['detailed_message'], $response_data['detailed_description'], $_GET);
            }

            // Check if the request is for toggling text size
            elseif ($_GET['accessibility'] == 'text_size') {
                $response_data = toggle_text_size();
                set_data_response($response_data['status'], $response_data['preview_title'], $response_data['preview_message'], $response_data['detailed_title'], $response_data['detailed_message'], $response_data['detailed_description'], $_GET);
            }

            else {
                set_data_response('error', 'Invalid request', 'No action taken', 'Invalid request', 'incorrect/ improper data was submitted and could not be handled', 'If issues persist please contact us using the button in the navigation. and send us the table below (hover over debug)', $_GET);
            }

        else {
            // Handle other GET requests or do nothing
            set_data_response('error', 'Invalid request', 'No action taken', 'Invalid request', 'incorrect/ improper data was submitted and could not be handled', 'If issues persist please contact us using the button in the navigation. and send us the table below (hover over debug)', $_GET);
        }

        if (isset($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('Location: ../project1/index.php');
        }
        exit();
    }
