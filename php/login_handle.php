<?php include "functionality.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Loggin in</title>
</head>
<body id="post_request">
<?php 
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<h1>This page is only accessible via POST requests.</h1>";
    echo "<p>this page will not serve anything</p>";
    echo "<a href='../project1/index.php'>Home</a>";
    echo "</body></html>";
    die();
}

$error = [];



// Check if the user has attempted to login more then times
if (!isset($_SESSION['login_requests'])) {
    $_SESSION['login_requests'] = 0;
} else {
    $_SESSION['login_requests']++;
}



if (isset($_SESSION['Block_Time'])) {
    if (time() - $_SESSION['Block_Time'] > 600) {
        unset($_SESSION['Block_Time']);
        $_SESSION['login_requests'] = 0;
    }
}

if ($_SESSION['login_requests'] > 5) {
    if (!isset($_SESSION['Block_Time'])) {
        $_SESSION['Block_Time'] = time();
    }
    set_data_response(
        "error",
        "Too many attempts",
        "Please Wait 10 minutes",
        "Too many login attempts!",
        "You will be able to attempt to login again after 10 minutes",
        "Your login ban will be lifted at: " . date("H:i", $_SESSION['Block_Time'] + 600),
        ["Sensitive data, no debug available" => "No data"]
    );
    header("Location: ../project1/login.php");
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







// There was an error somewhere, so set the error message and return back to the login page
if (count($error) > 0) {
    $error_msg = "";

    if (count($error) == 1) { $preview_message = $error[0]; }
    else { $preview_message = "Click for more info";}

    foreach ($error as $err) {
        $error_msg .= $err . "\n";
    }
    set_data_response("error", "Error", $preview_message . " | attempts " . $_SESSION['login_requests'] . "/5", "The values you submitted didn't meet the requirements to be passed", "Something in the form you submitted wasn't accepted and caused an error", "The following are the errors that were found:<br><pre>" . $error_msg . "</pre>", ["Sensitive data, no debug available" => "No data"]);
    header("Location: ../project1/login.php");
    die();
}