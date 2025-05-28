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
    } elseif (!isset($_POST['Employee_Update']) && !isset($_POST['Employee_Delete'])) {
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
$is_update = false;
$is_delete = false;

if (isset($_POST['Employee_Update'])) { // Flags for the type of request
    $is_update = true;
}
if (isset($_POST['Employee_Delete'])) {
    $is_delete = true;
}



// check if more then one flag is set
if (($is_update && $is_delete)) {
    set_data_response('error', 'Invalid Request', 'Multiple actions specified', 'Invalid Request', 'Please specify only one action (Create, Update, Delete)', '', $_POST);
    header('Location: ../../manage.php?Mode=Accounts');
    die();
}


# all data names that can be submitted
/*
- ID
- First_name
- Last_name
- Student_ID
- Tutor_name
- Tutor_ID
- class_time
- Class_Time_ID
- contributions
- contributions_old
- description
*/



// ====================== EXISTENCE VALIDATION ======================
//       check that the user has submitted everything required

    if (($is_update || $is_delete) && !isset($_POST['ID'])) {
        $error[] = "Employee ID is missing";
    }
    if ($is_update && !isset($_POST['First_name'])) {
        $error[] = "First name is missing";
    }
    if ($is_update && !isset($_POST['Last_name'])) {
        $error[] = "Last name is missing";
    }
    if ($is_update && !isset($_POST['Student_ID'])) {
        $error[] = "Student ID is missing";
    }
    if ($is_update && !isset($_POST['Tutor_name'])) {
        $error[] = "Tutor name is missing";
    }
    if ($is_update && !isset($_POST['Tutor_ID'])) {
        $error[] = "Tutor ID is missing";
    }
    if ($is_update && !isset($_POST['class_time'])) {
        $error[] = "Class time is missing";
    }
    if ($is_update && !isset($_POST['Class_Time_ID'])) {
        $error[] = "Class Time ID is missing";
    }
    if ($is_update && !isset($_POST['contributions'])) {
        $error[] = "Contributions are missing";
    }
    if ($is_update && !isset($_POST['contributions_old'])) {
        $error[] = "Old contributions are missing";
    }
    if ($is_update && !isset($_POST['description'])) {
        $error[] = "Description is missing";
    }

    if (count($error) > 0) {
        set_data_response('error', 'Missing Data', 'Some required fields are missing', 'Missing Data', 'Please ensure all required fields are filled out', implode(', ', $error), $_POST);
        header('Location: ../../manage.php?Mode=Accounts');
        die();
    }

    if (($is_update || $is_delete) && empty($_POST['ID'])) {
        $error[] = "Employee ID cannot be empty";
    }
    if ($is_update && empty($_POST['First_name'])) {
        $error[] = "First name cannot be empty";
    }
    if ($is_update && empty($_POST['Last_name'])) {
        $error[] = "Last name cannot be empty";
    }
    if ($is_update && empty($_POST['Student_ID'])) {
        $error[] = "Student ID cannot be empty";
    }
    if ($is_update && empty($_POST['Tutor_name'])) {
        $error[] = "Tutor name cannot be empty";
    }
    if ($is_update && empty($_POST['Tutor_ID'])) {
        $error[] = "Tutor ID cannot be empty";
    }
    if ($is_update && empty($_POST['class_time'])) {
        $error[] = "Class time cannot be empty";
    }
    if ($is_update && empty($_POST['Class_Time_ID'])) {
        $error[] = "Class Time ID cannot be empty";
    }
    if ($is_update && empty($_POST['contributions'])) {
        $error[] = "Contributions cannot be empty";
    }
    if ($is_update && empty($_POST['contributions_old'])) {
        $error[] = "Old contributions cannot be empty";
    }
    if ($is_update && empty($_POST['description'])) {
        $error[] = "Description cannot be empty";
    }
    if (count($error) > 0) {
        set_data_response('error', 'Empty Fields', 'Some fields are empty', 'Empty Fields', 'Please ensure all fields are filled out', implode(', ', $error), $_POST);
        header('Location: ../../manage.php?Mode=Accounts');
        die();
    }


// ====================== TYPE VALIDATION ======================
//      check that the user has submitted the correct types

    if (($is_update || $is_delete) && !is_numeric($_POST['ID'])) {
        $error[] = "Employee ID must be a number";
    }
    if ($is_update && !is_string($_POST['First_name'])) {
        $error[] = "First name must be a string";
    }
    if ($is_update && !is_string($_POST['Last_name'])) {
        $error[] = "Last name must be a string";
    }
    if ($is_update && !is_numeric($_POST['Student_ID'])) {
        $error[] = "Student ID must be a string";
    }
    if ($is_update && !is_string($_POST['Tutor_name'])) {
        $error[] = "Tutor name must be a string";
    }
    if ($is_update && !is_numeric($_POST['Tutor_ID'])) {
        $error[] = "Tutor ID must be a number";
    }

    if (count($error) > 0) {
        set_data_response('error', 'Invalid Data Types', 'Some fields have incorrect data types', 'Invalid Data Types', 'Please ensure all fields have the correct data types', implode(', ', $error), $_POST);
        header('Location: ../../manage.php?Mode=Accounts');
        die();
    }



// ====================== RANGE VALIDATION ======================
//     check that the user has submitted the appropriate data

    if (($is_update || $is_delete) && $_POST['ID'] < 1) {
        $error[] = "Employee ID must be a positive number";
    }
    if ($is_update && strlen($_POST['First_name']) < 3) {
        $error[] = "First name must be at least 3 character long";
    }
    if ($is_update && strlen($_POST['Last_name']) < 3) {
        $error[] = "Last name must be at least 3 character long";
    }
    if ($is_update && strlen($_POST['Student_ID']) != 9) {
        $error[] = "Student ID must be 9 characters long";
    }
    if ($is_update && strlen($_POST['Tutor_name']) < 3) {
        $error[] = "Tutor name must be at least 3 character long";
    }
    if ($is_update && $_POST['Tutor_ID'] < 1) {
        $error[] = "Tutor ID must be a positive number";
    }
    if ($is_update && !preg_match('/^\w+\s\d{2}:\d{2}:\d{2}\s-\s\d{2}:\d{2}:\d{2}$/', $_POST['class_time'])) {
        $error[] = "Class time must be in the format 'Day HH:MM:SS - HH:MM:SS'";
    }
    if ($is_update && $_POST['Class_Time_ID'] < 1) {
        $error[] = "Class Time ID must be a positive number";
    }
    if ($is_update && strlen($_POST['contributions']) < 1) {
        $error[] = "Contributions must be at least 1 character long";
    }
    if ($is_update && strlen($_POST['contributions_old']) < 1) {
        $error[] = "Old contributions must be at least 1 character long";
    }
    if ($is_update && strlen($_POST['description']) < 1) {
        $error[] = "Description must be at least 1 character long";
    }
    if (count($error) > 0) {
        set_data_response('error', 'Invalid Data', 'Some fields have invalid data', 'Invalid Data', 'Please ensure all fields have valid data', implode(', ', $error), $_POST);
        header('Location: ../../manage.php?Mode=Accounts');
        die();
    }


// ====================== UPDATE / DELETE OR CREATE ======================
//       Update / delete or create the employee data based on the request

$time_stamp = date(format: '[ Y-m-d | H:i:s ]');
$db->begin_transaction(MYSQLI_TRANS_START_READ_WRITE, 'process_employees');

    if ($is_update) {
        
        $stmt = $db->prepare("UPDATE employees SET First_name = ?, Last_name = ?, Student_ID = ?, Description = ? WHERE ID = ?");
        $stmt->bind_param("ssssi", $_POST['First_name'], $_POST['Last_name'], $_POST['Student_ID'], $_POST['description'], $_POST['ID']);
        $result = $stmt->execute();

        if (!$result) {
            $db->rollback();
            set_data_response('error', 'Failed to update employee', 'Failed to update the employee, please try again later', 'Failed to update employee', 'Failed to update the employee, please try again later', '', $_POST);
            error_log("$time_stamp  [Account Create]: " . mysqli_error($db) . "\n");
            header('Location: ../manage.php?Mode=Employees');
            die();
        }

        $stmt = $db->prepare("SELECT * FROM tutors WHERE Name = ?");
        $stmt->bind_param("s", $_POST['Tutor_name']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // No tutor found with the given name, insert a new tutor
            $stmt = $db->prepare("INSERT INTO tutors (Name) VALUES (?)");
            $stmt->bind_param("s", $_POST['Tutor_name']);
            $result = $stmt->execute();
            if (!$result) {
                $db->rollback();
                set_data_response('error', 'Failed to create tutor', 'Failed to create the tutor, please try again later', 'Failed to create tutor', 'Failed to create the tutor, please try again later', '', $_POST);
                error_log("$time_stamp  [Account Create]: " . mysqli_error($db) . "\n");
                header('Location: ../manage.php?Mode=Employees');
                die();
            }
            $tutor_id = $db->insert_id;
        } else {
            // Tutor found, get the ID
            $row = $result->fetch_assoc();
            $tutor_id = $row['Tutor_ID'];
        }

        $stmt = $db->prepare("UPDATE employees SET Tutor_ID = ? WHERE ID = ?");
        $stmt->bind_param("i", $tutor_id);
        $result = $stmt->execute();

        if (!$result) {
            $db->rollback();
            set_data_response('error', 'Failed to update tutor', 'Failed to update the tutor, please try again later', 'Failed to update tutor', 'Failed to update the tutor, please try again later', '', $_POST);
            error_log("$time_stamp  [Account Create]: " . mysqli_error($db) . "\n");
            header('Location: ../manage.php?Mode=Employees');
            die();
        }

        // Update contributions
        $contributions = explode(",", trim($_POST['contributions']));
        $match_contributions = [];
        foreach($contributions as $contrib) {
            $stmt->prepare("SELECT * FROM contributions WHERE Contribution = ?");
            $stmt->bind_param("s", $contrib);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows != 0) {
                $match_contributions[] = $contrib;
            }
        }
        $new_contributions = array_diff($contributions, $match_contributions);

        foreach($new_contributions as $contrib) {
            $stmt = $db->prepare("INSERT INTO contributions (Employee_ID, Contribution) VALUES (?, ?)");
            $stmt->bind_param("is", $_POST['ID'], $contrib);
            $result = $stmt->execute();
            if (!$result)
        }
        




    } elseif ($is_delete) {
        // delete their contributions first

        $stmt = $db->prepare("DELETE FROM contributions WHERE Employee_ID = ?");
        $stmt->bind_param("i", $_POST['ID']);
        $result = $stmt->execute();

        if (!$result) {
            $db->rollback();
            set_data_response('error', 'Failed to delete contributions', 'Failed to delete contributions for the employee', 'Failed to delete contributions', 'Failed to delete contributions for the employee, please try again later', '', $_POST);
            error_log("$time_stamp  [Account Create]: " . mysqli_error($db) . "\n");
            header('Location: ../manage.php?Mode=Employees');
            die();
        }

        $stmt = $db->prepare("DELETE FROM employees WHERE ID = ?");
        $stmt->bind_param("i", $_POST['ID']);
        $result = $stmt->execute();

        if ($result) {
            $db->commit();
            set_data_response('success', 'Employee Deleted', 'The employee has been deleted successfully', 'Employee Deleted', 'The employee has been deleted successfully', '', $_POST);
            header('Location: ../manage.php?Mode=Employees');
            die();
        } else {
            $db->rollback();
            set_data_response('error', 'Failed to delete employee', 'Failed to delete the employee, please try again later', 'Failed to delete employee', 'Failed to delete the employee, please try again later', '', $_POST);
            error_log("$time_stamp  [Account Create]: " . mysqli_error($db) . "\n");
            header('Location: ../manage.php?Mode=Employees');
            die();
        }


    } 




die();
// OLD CODE ==========================




if (isset($_POST['Employee_Update'])) {
try {
    $db = mysqli_connect($host, $user, $pwd, $employees_db);
} catch (Exception $e) {
    set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . $e->getMessage() . "</pre>", $_POST);
    header('Location: ../manage.php?Mode=Employees');
    die();
}

$stmt = $db->prepare("SELECT * FROM class_times WHERE Class_Time_ID = ?");
$stmt->bind_param("i", $_POST['Class_Time_ID']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    set_data_response('error', 'Invalid Class Time', 'The selected class time does not exist', 'Invalid Class Time', 'The selected class time does not exist, please select a valid class time', '', $_POST);
    header('Location: ../manage.php?Mode=Employees');
    die();
}
$row = $result->fetch_assoc();

//split the class_time into day, start time and end time from "day start_time - end_time"
// Example: "Thursday 13:20:00 - 16:30:00"
preg_match('/^(\w+)\s+(\d{2}:\d{2}:\d{2})\s*-\s*(\d{2}:\d{2}:\d{2})$/', $_POST['class_time'], $matches);
$day = isset($matches[1]) ? $matches[1] : '';
$start_time = isset($matches[2]) ? $matches[2] : '';
$end_time = isset($matches[3]) ? $matches[3] : '';
// Check if the class time already exists
if ($row['Day'] != $day || $row['Start_Time'] != $start_time || $row['End_Time'] != $end_time) {
    $stmt = $db->prepare("INSERT INTO class_times (Day, Start_Time, End_Time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $day, $start_time, $end_time);
    $stmt->execute();
    $new_class_time_id = $stmt->insert_id;
    $success = true;
}

//check if the tutors name was updated or changed to one of the other tutors
$stmt = $db->prepare("SELECT * FROM tutors WHERE Tutor_ID = ?");
$stmt->bind_param("i", $_POST['Tutor_ID']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    set_data_response('error', 'Invalid Tutor', 'The selected tutor does not exist', 'Invalid Tutor', 'The selected tutor does not exist, please select a valid tutor', '', $_POST);
    header('Location: ../manage.php?Mode=Employees');
    die();
}
$row = $result->fetch_assoc();
if ($row['Name'] != $_POST['Tutor_name']) {
    $stmt = $db->prepare("UPDATE tutors SET Name = ? WHERE Tutor_ID = ?");
    $stmt->bind_param("si", $_POST['Tutor_name'], $_POST['Tutor_ID']);
    $stmt->execute();
    $success = true;
}

if ($_POST['contributions'] != $_POST['contributions_old']) {
    // Drop all rows with the Employee_ID of $_POST['ID']
    $stmt = $db->prepare("DELETE FROM contributions WHERE Employee_ID = ?");
    $stmt->bind_param("i", $_POST['ID']);
    $stmt->execute();

    // Insert the new contributions
    $contributions = explode(',', $_POST['contributions']);
    foreach ($contributions as $contribution) {
        $contribution = trim($contribution);
        if (!empty($contribution)) {
            $stmt = $db->prepare("INSERT INTO contributions (Employee_ID, Contribution) VALUES (?, ?)");
            $stmt->bind_param("is", $_POST['ID'], $contribution);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $success = true;
            } else {
                set_data_response('error', 'Contribution Update Failed', 'Failed to update the contributions', 'Contribution Update Failed', 'Failed to update the contributions, please try again later', '', $_POST);
                header('Location: ../manage.php?Mode=Employees');
                die();
            }
        }
    }
}

if (isset($new_class_time_id)) {
    $stmt = $db->prepare("UPDATE employees SET First_Name = ?, Last_Name = ?, Student_ID = ?, Class_Time_ID = ?, Tutor_ID = ?, Description = ? WHERE ID = ?");
    $stmt->bind_param("sssiisi", $_POST['First_name'], $_POST['Last_name'], $_POST['Student_ID'], $new_class_time_id, $_POST['Tutor_ID'], $_POST['description'], $_POST['ID']);
} else {
    $stmt = $db->prepare("UPDATE employees SET First_Name = ?, Last_Name = ?, Student_ID = ?, Description = ?  WHERE ID = ?");
    $stmt->bind_param("ssssi", $_POST['First_name'], $_POST['Last_name'], $_POST['Student_ID'], $_POST['description'], $_POST['ID']);
}
$stmt->execute();
if ($stmt->affected_rows > 0) {
    set_data_response('success', 'Employee Updated', 'The employee has been updated successfully', 'Employee Updated', 'The employee has been updated successfully', '', $_POST);
    header('Location: ../manage.php?Mode=Employees');
} else {
    if (isset($success) && $success) {
        set_data_response('success', 'Employee Updated', 'The employee has been updated successfully', 'Employee Updated', 'The employee has been updated successfully', '', $_POST);
        header('Location: ../manage.php?Mode=Employees');
    } else {
        set_data_response('error', 'No Data changed', 'Failed to update the employee', 'Employee Update Failed', 'Failed to update the employee, please try again later', '', $_POST);
        header('Location: ../manage.php?Mode=Employees');
    }
}
}
if (isset($_POST['Employee_Delete'])) {
try {
    $db = mysqli_connect($host, $user, $pwd, $employees_db);
} catch (Exception $e) {
    set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . $e->getMessage() . "</pre>", $_POST);
    header('Location: ../manage.php?Mode=Employees');
    die();
}

// Delete all contributions for this employee
$stmt = $db->prepare("DELETE FROM contributions WHERE Employee_ID = ?");
$stmt->bind_param("i", $_POST['ID']);
$stmt->execute();

// Delete the employee
$stmt = $db->prepare("DELETE FROM employees WHERE ID = ?");
$stmt->bind_param("i", $_POST['ID']);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    set_data_response('success', 'Employee Deleted', 'The employee has been deleted successfully', 'Employee Deleted', 'The employee has been deleted successfully', '', $_POST);
    header('Location: ../manage.php?Mode=Employees');
} else {
    set_data_response('error', 'Employee Deletion Failed', 'Failed to delete the employee', 'Employee Deletion Failed', 'Failed to delete the employee, please try again later', '', $_POST);
    header('Location: ../manage.php?Mode=Employees');
}
}