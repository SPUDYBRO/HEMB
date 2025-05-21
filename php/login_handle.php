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




if (!isset($_POST['username']) || !isset($_POST['password'])) {
    echo "<h1>Invalid request</h1>";
    echo "<p>this page will not serve anything</p>";
    echo "</body></html>";
    die();
}

// Handle login stuff here
