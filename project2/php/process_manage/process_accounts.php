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
    } elseif (!isset($_POST['Account_Create']) && !isset($_POST['Account_Update']) && !isset($_POST['Account_Delete'])) {
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
    header('Location: ../../manage.php?Mode=Accounts');
    die();
}


$error = [];
$is_create = false;
$is_update = false;
$is_delete = false;

if (isset($_POST['Account_Create'])) { // Flags for the type of request
    $is_create = true;
}
if (isset($_POST['Account_Update'])) {
    $is_update = true;
}
if (isset($_POST['Account_Delete'])) {
    $is_delete = true;
}



// check if more then one flag is set
if (($is_create && $is_update) || ($is_create && $is_delete) || ($is_update && $is_delete)) {
    set_data_response('error', 'Invalid Request', 'Multiple actions specified', 'Invalid Request', 'Please specify only one action (Create, Update, Delete)', '', $_POST);
    header('Location: ../../manage.php?Mode=Accounts');
    die();
}



// ====================== EXISTENCE VALIDATION ======================
//       check that the user has submitted everything required

    if (($is_update || $is_delete) && !isset($_POST['ID'])) { // ID is required for update and delete
        $error[] = "Account ID is missing";
    }
    if (($is_update || $is_create) && !isset($_POST['Username'])) {
        $error[] = "Username is missing";
    }
    if ($is_create && !isset($_POST['Password'])) {
        $error[] = "Password is missing";
    }
    if (($is_update || $is_create) && !isset($_POST['Role'])) {
        $error[] = "Role is missing";
    }

    if (count($error) > 0) {
        set_data_response('error', 'Missing Data', 'Some required fields are missing', 'Missing Data', 'Please ensure all required fields are filled out', implode(', ', $error), $_POST);
        header('Location: ../../manage.php?Mode=Accounts');
        die();
    }

    if (($is_update || $is_delete) && empty($_POST['ID'])) {
        $error[] = "Account ID cannot be empty";
    }
    if (($is_update || $is_create) && empty($_POST['Username'])) {
        $error[] = "Username cannot be empty";
    }
    if ($is_create && empty($_POST['Password'])) {
        $error[] = "Password can not be empty for account creation";
    }
    if (($is_update || $is_create) && empty($_POST['Role'])) {
        $error[] = "Role cannot be empty";
    }

    if (count($error) > 0) {
        set_data_response('error', 'Empty Fields', 'Some fields are empty', 'Empty Fields', 'Please ensure all fields are filled out', implode(', ', $error), $_POST);
        header('Location: ../../manage.php?Mode=Accounts');
        die();
    }

    

// ====================== TYPE VALIDATION ======================
//      check that the user has submitted the correct types

    if (($is_update || $is_delete) && !is_numeric($_POST['ID'])) { // ID is required for update and delete
        $error[] = "Account ID must be a number";
    }
    if (($is_update || $is_create) && !is_string($_POST['Username'])) {
        $error[] = "Username must be a string";
    }
    if ($is_create && !is_string($_POST['Password'])) {
        $error[] = "Password must be a string";
    }
    if (($is_update || $is_create) && !is_string($_POST['Role'])) {
        $error[] = "Role must be a string";
    }

    if (count($error) > 0) {
        set_data_response('error', 'Invalid Data Types', 'Some fields have incorrect data types', 'Invalid Data Types', 'Please ensure all fields have the correct data types', implode(', ', $error), $_POST);
        header('Location: ../../manage.php?Mode=Accounts');
        die();
    }

// ====================== RANGE VALIDATION ======================
//     check that the user has submitted the appropriate data

    if (($is_update || $is_delete) && $_POST['ID'] < 1) {
        $error[] = "Account ID must be greater than 0";
    }
    if (($is_update || $is_create) && (strlen($_POST['Username']) < 3 || strlen($_POST['Username']) > 32)) {
        $error[] = "Username must be between 3 and 32 characters";
    }
    if ($is_create) {
        if (strlen($_POST['Password']) < 8) {
            $error[] = "Password must be at least 8 characters long";
        }
        if (!preg_match('/[A-Z]/', $_POST['Password']) || !preg_match('/[a-z]/', $_POST['Password']) || !preg_match('/[0-9]/', $_POST['Password']) || !preg_match('/[\W]/', $_POST['Password'])) {
            $error[] = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character";
        }
    }
    if (($is_update || $is_create) && !in_array($_POST['Role'], ['Admin', 'Member'])) {
        $error[] = "Role must be either 'Admin' or 'Member'";
    }

    if (count($error) > 0) {
        set_data_response('error', 'Invalid Data', 'Some fields have invalid data', 'Invalid Data', 'Please ensure all fields have valid data', implode(', ', $error), $_POST);
        header('Location: ../../manage.php?Mode=Accounts');
        die();
    }


// ====================== UPDATE / DELETE OR CREATE ======================
//       Update / delete or create the account based on the request
    

    $time_stamp = date(format: '[ Y-m-d | H:i:s ]');

    if ($is_create) { // Create
        // Create a new account


        $password = password_hash($_POST['Password'], PASSWORD_DEFAULT);


        $stmt = $db->prepare("INSERT INTO users (Username, Password, Role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $_POST['Username'], $password, $_POST['Role']);
        $result = $stmt->execute();
        if ($result) {
            set_data_response('success', 'Account Created', 'The account has been created successfully', 'Account Created', 'The account has been created successfully', '', $_POST);
            header('Location: ../../manage.php?Mode=Accounts');
            die();
        } else {
            set_data_response('error', 'Database Error', 'Failed to create the account', 'Database Error', 'Failed to create the account: ' . $stmt->error, '', $_POST);
            error_log("$time_stamp  [Account Create]: " . mysqli_error($db) . "\n");
            header('Location: ../../manage.php?Mode=Accounts');
            die();
        }


    } elseif ($is_update) { // Update

        // Update an existing account

        if (empty($_POST['Password'])) {
            $stmt = $db->prepare("UPDATE Users SET Username = ?, Role = ? WHERE ID = ?");
            $stmt->bind_param("ssi", $_POST['Username'], $_POST['Role'], $_POST['ID']);
        } else {
            $password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE Users SET Username = ?, Password = ?, Role = ? WHERE ID = ?");
            $stmt->bind_param("sssi", $_POST['Username'], $password, $_POST['Role'], $_POST['ID']);
        }
        $result = $stmt->execute();


        if ($result) {
            set_data_response('success', 'Account Updated', 'The account has been updated successfully', 'Account Updated', 'The account has been updated successfully', '', $_POST);
            header('Location: ../../manage.php?Mode=Accounts');
            die();
        } else {
            set_data_response('error', 'Database Error', 'Failed to update the account', 'Database Error', 'Failed to update the account: ' . $stmt->error, '', $_POST);
            error_log("$time_stamp  [Account Update]: " . mysqli_error($db) . "\n");
            header('Location: ../../manage.php?Mode=Accounts');
            die();
        }



    } elseif ($is_delete) { // Delete
        // Delete an existing account
        
        $stmt = $db->prepare("DELETE FROM Users WHERE ID = ?");
        $stmt->bind_param("i", $_POST['ID']);
        $result = $stmt->execute();

        if ($result) {
            set_data_response('success', 'Account Deleted', 'The account has been deleted successfully', 'Account Deleted', 'The account has been deleted successfully', '', $_POST);
            header('Location: ../../manage.php?Mode=Accounts');
            die();
        } else {
            set_data_response('error', 'Database Error', 'Failed to delete the account', 'Database Error', 'Failed to delete the account: ' . $stmt->error, '', $_POST);
            error_log("$time_stamp  [Account Delete]: " . mysqli_error($db) . "\n");
            header('Location: ../../manage.php?Mode=Accounts');
            die();
        }

    }
    else {
        set_data_response('error', 'Invalid Request', 'No valid action specified', 'Invalid Request', 'Please specify a valid action (Create, Update, Delete)', '', $_POST);
        header('Location: ../../manage.php?Mode=Accounts');
    }


