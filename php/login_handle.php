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


if (!isset($_POST['username'])) {
    $error[] = "No username field was submitted";
}
if (!isset($_POST['password'])) {
    $error[] = "No password field was submitted";
}

// Handle login stuff here

if (empty($_POST['username'])) {
    $error[] = "empty username";
}
if (empty($_POST['password'])) {
    $error[] = "empty password";
}


if (count($error) > 0) {
    $error_msg = "Errors found:\n";

    foreach ($error as $err) {
        $error_msg .= $err . "\n";
    }
    set_data_response("error", "Error", "Click for more info", "The values you submitted didn't meet the requirements to be passed", "Something in the form you submitted wasn't accepted and caused an error", "The following are the errors that were found:" . $error_msg, $_POST);
}