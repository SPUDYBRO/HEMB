<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/styles.css">
    <title>Post Request</title>
</head>
<body id="post_request">
    <?php
    require_once "../settings.php";
    include "../functionality.php";


    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo "<h1>This page is only accessible via POST requests.</h1>";
        echo "<p>this page will not serve anything</p>";
        echo "<a href='../../index.php'>Home</a>";
        echo "</body></html>";
        die();
    } elseif (!isset($_POST['EOI_Update']) && !isset($_POST['EOI_Delete'])) {
        echo "<h1>Invalid request.</h1>";
        echo "<p>this page will not serve anything</p>";
        echo "<a href='../../index.php'>Home</a>";
        echo "</body></html>";
        die();
    }
    ?>



<?php

// check if user is logged in
if (!is_logged_in()) {
    set_data_response('error', 'Access Denied', 'You must be logged in to access this page', 'Access Denied', 'You must be logged in to access this page', '', $_POST);
    header('Location: ../../index.php');
    die();
}

// Connect to the database

try {
    $db = mysqli_connect($host, $user, $pwd, $sql_db);
}
catch (Exception $e) {
    set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . $e->getMessage() . "</pre>", $_POST);
    header('Location: ../../manage.php?Mode=EOI');
    die();
}



$error = [];


// ====================== EXISTENCE VALIDATION ======================
//       check that the user has submitted everything required

    if (!isset($_POST['EOInumber'])) {
        $error[] = 'EOInumber is missing';
    }
    if (!isset($_POST['status'])) {
        $error[] = 'Status is missing';
    }


    if (count($error) > 0) {
        set_data_response('error', 'Invalid Request', 'Missing required fields', 'Invalid Request', 'The request is missing required fields: ' . implode(', ', $error), '', $_POST);
        header('Location: ../../manage.php?Mode=EOI');
        die();
    }

    if (empty($_POST['EOInumber'])) {
        $error[] = 'EOInumber cannot be empty';
    }
    if (empty($_POST['status'])) {
        $error[] = 'Status cannot be empty';
    }

    if (count($error) > 0) {
        set_data_response('error', 'Invalid Request', 'Empty fields found', 'Invalid Request', 'The request contains empty fields: ' . implode(', ', $error), '', $_POST);
        header('Location: ../../manage.php?Mode=EOI');
        die();
    }

    

// ====================== TYPE VALIDATION ======================
//      check that the user has submitted the correct types

    if (!is_numeric($_POST['EOInumber'])) {
        $error[] = 'EOInumber must be a number';
    }
    if (!is_string($_POST['status'])) {
        $error[] = 'Status must be a string';
    }

    if (count($error) > 0) {
        set_data_response('error', 'Invalid Request', 'Incorrect data types', 'Invalid Request', 'The request contains incorrect data types: ' . implode(', ', $error), '', $_POST);
        header('Location: ../../manage.php?Mode=EOI');
        die();
    }


// ====================== RANGE VALIDATION ======================
//     check that the user has submitted the appropriate data
    if ($_POST['EOInumber'] < 1) {
        $error[] = 'EOInumber must be greater than 0';
    }
    if (!in_array($_POST['status'], ['New', 'Current', 'Final'])) {
        $error[] = 'Status must be one of: New, Current, Final';
    }

    if (count($error) > 0) {
        set_data_response('error', 'Invalid Request', 'Out of range values', 'Invalid Request', 'The request contains out of range values: ' . implode(', ', $error), '', $_POST);
        header('Location: ../../manage.php?Mode=EOI');
        die();
    }




// ====================== UPDATE OR DELETE ======================
//         Update or delete the EOI based on the request

    if (isset($_POST['EOI_Update'])) { // update
        $stmt = $db->prepare("UPDATE eoi SET Status = ? WHERE EOInumber = ?");
        $stmt->bind_param("si", $_POST['status'], $_POST['EOInumber']);
        $result = $stmt->execute();

        if ($result) {
            set_data_response('success', 'EOI Updated', 'The EOI has been updated successfully', 'EOI Updated', 'The EOI has been updated successfully', '', $_POST);
            header('Location: ../../manage.php?Mode=EOI');
            die();
        } else {
            set_data_response('error', 'EOI Update Failed', 'Failed to update the EOI', 'EOI Update Failed', 'Failed to update the EOI, please try again later', '', $_POST);
            $time_stamp = date(format: '[ Y-m-d | H:i:s ]');
            error_log("$time_stamp  [EOI Update]: " . mysqli_error($db) . "\n");
            header('Location: ../../manage.php?Mode=EOI');
            die();
        }
    } 
    elseif (isset($_POST['EOI_Delete'])) { // delete
        $stmt = $db->prepare("DELETE FROM eoi WHERE EOInumber = ?");
        $stmt->bind_param("i", $_POST['EOInumber']);
        $result = $stmt->execute();

        if ($result) {
            set_data_response('success', 'EOI Deleted', 'The EOI has been deleted successfully', 'EOI Deleted', 'The EOI has been deleted successfully', '', $_POST);
            header('Location: ../../manage.php?Mode=EOI');
            die();
        } else {
            set_data_response('error', 'EOI Deletion Failed', 'Failed to delete the EOI', 'EOI Deletion Failed', 'Failed to delete the EOI, please try again later', '', $_POST);
            $time_stamp = date('[ Y-m-d | H:i:s ]');
            error_log("$time_stamp  [EOI Delete]: " . mysqli_error($db) . "\n");
            header('Location: ../../manage.php?Mode=EOI');
            die();
        }
    }
    else { // unrecognized action
        set_data_response('error', 'Invalid Request', 'No valid action specified', 'Invalid Request', 'No valid action specified in the request', '', $_POST);
        header('Location: ../../manage.php?Mode=EOI');
        die();
    }