<!-- Group Task A - 2
"Create a file to store your database connection variables “settings.php”" 

Password and database need to be changed. -->





<?php
// Only show the HTML if this file is accessed directly via the browser (not included/required by another PHP file)
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])):
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Post Request</title>
</head>
<body id="post_request">
    <h1>This page does not serve anything</h1>
    <p>Please return back to the website</p>
    <a href='../index.php'>Home</a>
</body>
</html>
<?php
    // Stop further execution so the rest of the file (functions, etc.) is not output
    exit;
endif;

// Written by chatGPT because i didn't know how to make it so it only outputs the HTML if the file is accessed directly
?>



<?php
    $host = "localhost";
    $user = "root";
    $pwd = "";
    $sql_db = "hemb";

    date_default_timezone_set('Australia/Melbourne');
?>


<!-- 
Admin Account

user: localhost
password: hembdatabase

-->