<?php
    include "./functionality.php";
    require_once "./settings.php";
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./styles/styles.css">
        <title>Login in</title>
    </head>


    <body id="post_request">

        <?php 


            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                echo "<h1>This page is only accessible via POST requests.</h1>";
                echo "<p>this page will not serve anything</p>";
                echo "<a href='../index.php'>Home</a>";
                echo "</body></html>";
                die();
            }
            

            if (isset($_SESSION['User'])) { # the user is already logged in...
                session_regenerate_id(true);
                header("Location: ../manage.php");
                die();
            }


            $error = [];


            // Check if the user has attempted to login more then times
            if (isset($_SESSION['Block_Time'])) {
                if (time() - $_SESSION['Block_Time'] > 600) {
                    unset($_SESSION['Block_Time']);
                    $_SESSION['login_requests'] = 0;
                }
            }


            if ($_SESSION['login_requests'] >= 5) {
                if (!isset($_SESSION['Block_Time'])) {
                    $_SESSION['Block_Time'] = time();
                }
                $time_lift_formatted = date("h:i a", $_SESSION['Block_Time'] + 600) . " (AEST)";
                set_data_response(
                    "error",
                    "Too many attempts",
                    "Please Wait 10 minutes | Till " . $time_lift_formatted,
                    "Too many login attempts!",
                    "You will be able to attempt to login again after 10 minutes",
                    "Your login ban will be lifted at: " . $time_lift_formatted,
                    ["Sensitive data, no debug available" => "No data"]
                );
                header("Location: ../login.php");
                die();
            }


            // check if the user has submitted the appropriate fields
            if (!isset($_POST['username'])) {
                $error[] = "No username field was submitted";
            }
            if (!isset($_POST['password'])) {
                $error[] = "No password field was submitted";
            }


            // Check if the user has not just submitted empty fields
            if (empty($_POST['username'])) {
                $error[] = "empty username";
            }
            if (empty($_POST['password'])) {
                $error[] = "empty password";
            }



            // Check if the user has submitted the correct username and password
            $db = mysqli_connect($host, $user, $pwd, $sql_db);


            if (!$db) { # the connection failed
                set_data_response("error", 
                "Error", 
                "Database connection error", 
                "The database connection failed", 
                "There was an error connecting to the database", 
                "The following is the error message:<br><pre>" . mysqli_connect_error() . "</pre>");
                header("Location: ../login.php");
                die();
            }


            $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s", $_POST['username']);
            $stmt->execute();
            $result = $stmt->get_result();


            if ($result->num_rows == 0) { # That username doesn't exist!
                $error[] = "The username is incorrect";
            }


            if ($result->num_rows > 1) { # That username exists more then once!
                $error[] = "The username exists more then once"; # This should never happen though
            }


            $row = $result->fetch_assoc();


            if (!password_verify($_POST['password'], $row['Password'])) { # The password is incorrect
                $error[] = "The password is incorrect";
            }

            $db->close(); #if the code reaches this point without errors then let them in. but if there are errors then deal with it


            // There was an error somewhere, so set the error message and return back to the login page
            if (count($error) > 0) {

                if (!isset($_SESSION['login_requests'])) {
                    $_SESSION['login_requests'] = 0;
                } else {
                    $_SESSION['login_requests']++;
                }
                $error_msg = "";

                if (count($error) == 1) { $preview_message = $error[0]; }
                else { $preview_message = "Click for more info";}

                foreach ($error as $err) {
                    $error_msg .= $err . "\n";
                }

                set_data_response("error", 
                "Error", 
                $preview_message . " | attempts " . $_SESSION['login_requests'] . "/5", 
                "The values you submitted didn't meet the requirements to be passed", 
                "Something in the form you submitted wasn't accepted and caused an error", 
                "The following are the errors that were found:<br><pre>" . $error_msg . "</pre>", 
                ["Sensitive data, no debug available" => "No data"]);
                header("Location: ../login.php");
                die();
                
            } else {
                session_regenerate_id(true);
                $_SESSION['User'] = new User($row['ID'], $row['Username'], $row['Role']);
                $_SESSION['login_requests'] = 0;
                header("Location: ../manage.php");
                die();
            }
            

        ?>
    
    </body>

</html>