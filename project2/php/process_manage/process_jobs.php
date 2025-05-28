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
    } elseif (!isset($_POST['Job_Update']) && !isset($_POST['Job_Delete'])) {
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
    header('Location: ../../manage.php?Mode=Jobs');
    die();
}



/*
data that can be passed in the post request:

- Reference_Number
- Reference_Number_old
- Job_Title
- Type
- Work_Hours
- Salary
- Supervisor
- Benefits
- Description
- Responsibilities
- essential_qualifications
- preferable_qualifications

- Job_Update
- Job_Delete


*/

$error = [];
$is_update = false;
$is_delete = false;


if (isset($_POST['Job_Update'])) {
    $is_update = true;
}
if (isset($_POST['Job_Delete'])) {
    $is_delete = true;
}



// check if more then one flag is set
if ($is_create && $is_update) {
    set_data_response('error', 'Invalid Request', 'Multiple actions specified', 'Invalid Request', 'Please specify only one action (Create, Update, Delete)', '', $_POST);
    header('Location: ../../manage.php?Mode=Jobs');
    die();
}



// ====================== EXISTENCE VALIDATION ======================
//       check that the user has submitted everything required

    if (($is_update || $is_delete) && !isset($_POST['Reference_Number'])) {
        $error[] = "No Reference Number was submitted";
    }
    if ($is_update && !isset($_POST['Reference_Number_old'])) {
        $error[] = "No old Reference Number was submitted";
    }
    if ($is_update && !isset($_POST['Job_Title'])) {
        $error[] = "No Job Title was submitted";
    }
    if ($is_update && !isset($_POST['Type'])) {
        $error[] = "No Type was submitted";
    }
    if ($is_update && !isset($_POST['Work_Hours'])) {
        $error[] = "No Work Hours were submitted";
    }
    if ($is_update && !isset($_POST['Salary'])) {
        $error[] = "No Salary was submitted";
    }
    if ($is_update && !isset($_POST['Supervisor'])) {
        $error[] = "No Supervisor was submitted";
    }
    if ($is_update && !isset($_POST['Benefits'])) {
        $error[] = "No Benefits were submitted";
    }
    if ($is_update && !isset($_POST['Description'])) {
        $error[] = "No Description was submitted";
    }
    if ($is_update && !isset($_POST['Responsibilities'])) {
        $error[] = "No Responsibilities were submitted";
    }
    if ($is_update && !isset($_POST['essential_qualifications'])) {
        $error[] = "No Essential Qualifications were submitted";
    }
    if ($is_update && !isset($_POST['preferable_qualifications'])) {
        $error[] = "No Preferable Qualifications were submitted";
    }

    if (count($error) > 0) {
        set_data_response('error', 'Missing Fields', 'Please fill in all required fields', 'Missing Fields', 'The following fields are missing: ' . implode(', ', $error), '', $_POST);
        header('Location: ../../manage.php?Mode=Jobs');
        die();
    }

    if (($is_update || $is_delete) && empty($_POST['Reference_Number'])) {
        $error[] = "Reference Number must not be empty";
    }
    if ($is_update && empty($_POST['Reference_Number_old'])) {
        $error[] = "Old Reference Number must not be empty";
    }
    if ($is_update && empty($_POST['Job_Title'])) {
        $error[] = "Job Title must not be empty";
    }
    if ($is_update && empty($_POST['Type'])) {
        $error[] = "Type must not be empty";
    }
    if ($is_update && empty($_POST['Work_Hours'])) {
        $error[] = "Work Hours must not be empty";
    }
    if ($is_update && empty($_POST['Salary'])) {
        $error[] = "Salary must not be empty";
    }
    if ($is_update && empty($_POST['Supervisor'])) {
        $error[] = "Supervisor must not be empty";
    }
    if ($is_update && empty($_POST['Benefits'])) {
        $error[] = "Benefits must not be empty";
    }
    if ($is_update && empty($_POST['Description'])) {
        $error[] = "Description must not be empty";
    }
    if ($is_update && empty($_POST['Responsibilities'])) {
        $error[] = "Responsibilities must not be empty";
    }
    if ($is_update && empty($_POST['essential_qualifications'])) {
        $error[] = "Essential Qualifications must not be empty";
    }
    if ($is_update && empty($_POST['preferable_qualifications'])) {
        $error[] = "Preferable Qualifications must not be empty";
    }

    if (count($error) > 0) {
        set_data_response('error', 'Empty Fields', 'Please fill in all required fields', 'Empty Fields', 'The following fields are empty: ' . implode(', ', $error), '', $_POST);
        header('Location: ../../manage.php?Mode=Jobs');
        die();
    }


    

// ====================== TYPE VALIDATION ======================
//      check that the user has submitted the correct types

    if (($is_update || $is_delete) && !is_string($_POST['Reference_Number'])) {
        $error[] = "Reference Number must be a number";
    }
    if ($is_update && !is_string($_POST['Reference_Number_old'])) {
        $error[] = "Old Reference Number must be a number";
    }
    if ($is_update && !is_string($_POST['Job_Title'])) {
        $error[] = "Job Title must be a string";
    }
    if ($is_update && !is_string($_POST['Type'])) {
        $error[] = "Type must be a string";
    }
    if ($is_update && !is_string($_POST['Work_Hours'])) {
        $error[] = "Work Hours must be a string";
    }
    if ($is_update && !is_string($_POST['Salary'])) {
        $error[] = "Salary must be a string";
    }
    if ($is_update && !is_string($_POST['Supervisor'])) {
        $error[] = "Supervisor must be a string";
    }
    if ($is_update && !is_string($_POST['Benefits'])) {
        $error[] = "Benefits must be a string";
    }
    if ($is_update && !is_string($_POST['Description'])) {
        $error[] = "Description must be a string";
    }
    if ($is_update && !is_string($_POST['Responsibilities'])) {
        $error[] = "Responsibilities must be a string";
    }
    if ($is_update && !is_string($_POST['essential_qualifications'])) {
        $error[] = "Essential Qualifications must be a string";
    }
    if ($is_update && !is_string($_POST['preferable_qualifications'])) {
        $error[] = "Preferable Qualifications must be a string";
    }

    if (count($error) > 0) {
        set_data_response('error', 'Invalid Types', 'Please check the types of the fields', 'Invalid Types', 'The following fields have invalid types: ' . implode(', ', $error), '', $_POST);
        header('Location: ../../manage.php?Mode=Jobs');
        die();
    }






// ====================== RANGE VALIDATION ======================
//     check that the user has submitted the appropriate data

    if (($is_update || $is_delete) && $_POST['Reference_Number'] < 1) {
        $error[] = "Reference Number must be a positive number";
    }
    if ($is_update && $_POST['Reference_Number_old'] < 1) {
        $error[] = "Old Reference Number must be a positive number";
    }
    if ($is_update && strlen($_POST['Job_Title']) < 3) {
        $error[] = "Job Title must be at least 3 characters long";
    }
    if ($is_update && in_array($_POST['Type'], ['Full Time', 'Part Time']) === false) {
        $error[] = "Type must be either Full-Time or Part-Time";
    }
    if ($is_update && strlen($_POST['Work_Hours']) < 3 || strlen($_POST['Work_Hours']) > 50) {
        $error[] = "Work Hours must be between 3 and 50 characters long";
    }
    if ($is_update && !preg_match('/^\$\d{1,3}(,\d{3})* - \$\d{1,3}(,\d{3})*$/', $_POST['Salary'])) {
        $error[] = "Salary must be in the format \$money - \$money (e.g. $1,000 - $2,000 or $55,000 - $80,000)\nYou must include the $ sign and the , every 3 zeros with a space before and after the - sign";
    }
    if ($is_update && strlen($_POST['Supervisor']) < 3 || strlen($_POST['Supervisor']) > 50) {
        $error[] = "Supervisor must be between 3 and 50 characters long";
    }
    if ($is_update && strlen($_POST['Benefits']) < 3) {
        $error[] = "Benefits must be at least 3 characters long";
    }
    if ($is_update && strlen($_POST['Description']) < 3) {
        $error[] = "Description must be at least 3 characters long";
    }
    if ($is_update && strlen($_POST['Responsibilities']) < 3) {
        $error[] = "Responsibilities must be at least 3 characters long";
    }
    if ($is_update && strlen($_POST['essential_qualifications']) < 3) {
        $error[] = "Essential Qualifications must be at least 3 characters long";
    }
    if ($is_update && strlen($_POST['preferable_qualifications']) < 3) {
        $error[] = "Preferable Qualifications must be at least 3 characters long";
    }

    if (count($error) > 0) {
        set_data_response('error', 'Invalid Data', 'Please check the data you have submitted', 'Invalid Data', 'The following fields have invalid data: ' . implode(', ', $error), '', $_POST);
        header('Location: ../../manage.php?Mode=Jobs');
        die();
    }





// ====================== UPDATE / DELETE ======================
//       Update / delete or create the account based on the request
    $time_stamp = date(format: '[ Y-m-d | H:i:s ]');
    $db->begin_transaction(MYSQLI_TRANS_START_READ_WRITE, 'process_jobs');



    if ($is_update) {

        $stmt = $db->prepare("UPDATE jobs SET reference_number = ?, title = ?, type = ?, work_hours = ?, salary = ?, supervisor = ?, description = ?, responsibilities = ?, essential_qualifications = ?, preferable_qualifications = ?, benefits = ? WHERE reference_number = ?");
        $stmt->bind_param("ssssssssssss", $_POST['Reference_Number'], $_POST['Job_Title'], $_POST['Type'], $_POST['Work_Hours'], $_POST['Salary'], $_POST['Supervisor'], $_POST['Description'], $_POST['Responsibilities'], $_POST['essential_qualifications'], $_POST['preferable_qualifications'], $_POST['Benefits'], $_POST['Reference_Number_old']);

        try {
            $result = $stmt->execute();
        }
        catch (Exception $e) {
            $db->rollback();
            set_data_response('error', 'Database Error', 'Failed to update the job', 'Failed to update the job', "Something went wrong and failed to update the job", "Error: <pre>" . $e->getMessage() . "</pre>", $_POST);
            error_log("$time_stamp  [Jobs Update]: " . mysqli_error($db) . "\n");
            header('Location: ../../manage.php?Mode=Jobs');
            die();
        }

        if ($result) {
            $db->commit();
            set_data_response('success', 'Job Updated', 'The job has been updated successfully', 'Job Updated', 'The job has been updated successfully', '', $_POST);
            header('Location: ../../manage.php?Mode=Jobs');
            die();
        } else {
            $db->rollback();
            set_data_response('error', 'Update Failed', 'Failed to update the job', 'Update Failed', 'Failed to update the job', '', $_POST);
            error_log("$time_stamp  [Jobs Update]: " . mysqli_error($db) . "\n");
            header('Location: ../../manage.php?Mode=Jobs');
            die();
        }
    }
    elseif ($is_delete) {

        $stmt = $db->prepare("DELETE FROM jobs WHERE reference_number = ?");
        $stmt->bind_param("s", $_POST['Reference_Number_old']);

        try {
            $result = $stmt->execute();
        }
        catch (Exception $e) {
            $db->rollback();
            set_data_response('error', 'Database Error', 'Failed to delete the job', 'Failed to delete the job', "Something went wrong and failed to delete the job", "Error: <pre>" . $e->getMessage() . "</pre>", $_POST);
            error_log("$time_stamp  [Jobs Delete]: " . mysqli_error($db) . "\n");
            header('Location: ../../manage.php?Mode=Jobs');
            die();
        }

        if ($result) {
            $db->commit();
            set_data_response('success', 'Job Deleted', 'The job has been deleted successfully', 'Job Deleted', 'The job has been deleted successfully', '', $_POST);
            header('Location: ../../manage.php?Mode=Jobs');
            die();
        } else {
            $db->rollback();
            set_data_response('error', 'Delete Failed', 'Failed to delete the job', 'Delete Failed', 'Failed to delete the job', '', $_POST);
            error_log("$time_stamp  [Jobs Delete]: " . mysqli_error($db) . "\n");
            header('Location: ../../manage.php?Mode=Jobs');
            die();
        }
    } else {
        set_data_response('error', 'Invalid Request', 'No action specified', 'Invalid Request', 'Please specify an action (Update, Delete)', '', $_POST);
        header('Location: ../../manage.php?Mode=Jobs');
        die();
    }
