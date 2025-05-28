<?php
    require_once "./settings.php";
    include "./functionality.php";



    if (!is_logged_in()) {
        set_data_response('error', 'Access Denied', 'You must be logged in to access this page', 'Access Denied', 'You must be logged in to access this page', '', $_POST);
        header('Location: ./index.php');
        die();
    }


    if ($_SERVER['REQUEST_METHOD'] == "POST") {


        // ================================= EOI =================================

            if (isset($_POST['EOI_Update'])) {
                try {
                    $db = mysqli_connect($host, $user, $pwd, $sql_db);
                } catch (Exception $e) {
                    set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . $e->getMessage() . "</pre>", $_POST);
                    header('Location: ../manage.php?Mode=EOI');
                    die();
                }

                $stmt = $db->prepare("UPDATE eoi SET Status = ? WHERE EOInumber = ?");
                $stmt->bind_param("si", $_POST['status'], $_POST['EOInumber']);

                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    set_data_response('success', 'EOI Updated', 'The EOI has been updated successfully', 'EOI Updated', 'The EOI has been updated successfully', '', $_POST);
                    header('Location: ../manage.php?Mode=EOI');
                } else {
                    set_data_response('error', 'EOI Update Failed', 'Failed to update the EOI', 'EOI Update Failed', 'Failed to update the EOI, please try again later', '', $_POST);
                    header('Location: ../manage.php?Mode=EOI');
                }
            }
            elseif (isset($_POST['EOI_Delete'])) {
                try {
                    $db = mysqli_connect($host, $user, $pwd, $sql_db);
                } catch (Exception $e) {
                    set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . $e->getMessage() . "</pre>", $_POST);
                    header('Location: ../manage.php?Mode=EOI');
                    die();
                }

                $stmt = $db->prepare("DELETE FROM eoi WHERE EOInumber = ?");
                $stmt->bind_param("i", $_POST['EOInumber']);

                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    set_data_response('success', 'EOI Deleted', 'The EOI has been deleted successfully', 'EOI Deleted', 'The EOI has been deleted successfully', '', $_POST);
                    header('Location: ../manage.php?Mode=EOI');
                } else {
                    set_data_response('error', 'EOI Deletion Failed', 'Failed to delete the EOI', 'EOI Deletion Failed', 'Failed to delete the EOI, please try again later', '', $_POST);
                    header('Location: ../manage.php?Mode=EOI');
                }
            }

        
        // ================================= Account Management =================================

            if (isset($_POST['Account_Update'])) {
                if ($_SESSION['User']->Role != 'Admin') {
                    set_data_response('error', 'Access Denied', 'You do not have permission to update accounts', 'Access Denied', 'You do not have permission to update accounts', '', $_POST);
                    header('Location: ../manage.php?Mode=Accounts');
                    die();
                }

                try {
                    $db = mysqli_connect($host, $user, $pwd, $sql_db);
                } catch (Exception $e) {
                    set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . $e->getMessage() . "</pre>", $_POST);
                    header('Location: ../manage.php?Mode=Account');
                    die();
                }

                if (isset($_POST['Password']) || !empty($_POST['Password'])) {
                    $query = "UPDATE users SET Username = ?, Password = ?, Role = ? WHERE ID = ?";
                    $password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
                } else {
                    $query = "UPDATE users SET Username = ?, Role = ? WHERE ID = ?";
                }
                $stmt = $db->prepare($query);
                if (isset($_POST['Password']) || !empty($_POST['Password'])) {
                    $stmt->bind_param("sssi", $_POST['Username'], $password, $_POST['Role'], $_POST['ID']);
                } else {
                    $stmt->bind_param("ssi", $_POST['Username'], $_POST['Role'], $_POST['ID']);
                }

                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    set_data_response('success', 'Account Updated', 'The account has been updated successfully', 'Account Updated', 'The account has been updated successfully', '', $_POST);
                    header('Location: ../manage.php?Mode=Accounts');
                } else {
                    set_data_response('error', 'Account Update Failed', 'Failed to update the account', 'Account Update Failed', 'Failed to update the account, please try again later', '', $_POST);
                    header('Location: ../manage.php?Mode=Accounts');
                }
            }

            elseif (isset($_POST['Account_Create'])) {
                if ($_SESSION['User']->Role != 'Admin') {
                    set_data_response('error', 'Access Denied', 'You do not have permission to create accounts', 'Access Denied', 'You do not have permission to create accounts', '', $_POST);
                    header('Location: ../manage.php?Mode=Accounts');
                    die();
                }

                try {
                    $db = mysqli_connect($host, $user, $pwd, $sql_db);
                } catch (Exception $e) {
                    set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . $e->getMessage() . "</pre>", $_POST);
                    header('Location: ../manage.php?Mode=Account');
                    die();
                }

                $stmt = $db->prepare("INSERT INTO users (Username, Password, Role) VALUES (?, ?, ?)");
                $password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
                $stmt->bind_param("sss", $_POST['Username'], $password, $_POST['Role']);

                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    set_data_response('success', 'Account Created', 'The account has been created successfully', 'Account Created', 'The account has been created successfully', '', $_POST);
                    header('Location: ../manage.php?Mode=Accounts');
                } else {
                    set_data_response('error', 'Account Creation Failed', 'Failed to create the account', 'Account Creation Failed', 'Failed to create the account, please try again later', '', $_POST);
                    header('Location: ../manage.php?Mode=Accounts');
                }
            }
            elseif (isset($_POST['Account_Delete'])) {
                if ($_SESSION['User']->Role != 'Admin') {
                    set_data_response('error', 'Access Denied', 'You do not have permission to delete accounts', 'Access Denied', 'You do not have permission to delete accounts', '', $_POST);
                    header('Location: ../manage.php?Mode=Accounts');
                    die();
                }

                if ($_SESSION['User']->ID == $_POST['ID']) {
                    set_data_response('error', 'Account Deletion Failed', 'You cannot delete your own account', 'Account Deletion Failed', 'You cannot delete your own account, please contact an administrator', '', $_POST);
                    header('Location: ../manage.php?Mode=Accounts');
                    die();
                }

                try {
                    $db = mysqli_connect($host, $user, $pwd, $sql_db);
                } catch (Exception $e) {
                    set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . $e->getMessage() . "</pre>", $_POST);
                    header('Location: ../manage.php?Mode=Account');
                    die();
                }

                $stmt = $db->prepare("DELETE FROM users WHERE ID = ?");
                $stmt->bind_param("i", $_POST['ID']);

                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    set_data_response('success', 'Account Deleted', 'The account has been deleted successfully', 'Account Deleted', 'The account has been deleted successfully', '', $_POST);
                    header('Location: ../manage.php?Mode=Accounts');
                } else {
                    set_data_response('error', 'Account Deletion Failed', 'Failed to delete the account', 'Account Deletion Failed', 'Failed to delete the account, please try again later', '', $_POST);
                    header('Location: ../manage.php?Mode=Accounts');
                }
            }

        // ================================= Employees management =================================

            if (isset($_POST['Employee_Update'])) {
                try {
                    $db = mysqli_connect($host, $user, $pwd, $sql_db);
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
                    $db = mysqli_connect($host, $user, $pwd, $sql_db);
                } catch (Exception $e) {
                    set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . $e->getMessage() . "</pre>", $_POST);
                    header('Location: ../manage.php?Mode=Employees');
                    die();
                }

                // drop all rows with the Employee_ID of $_POST['ID'] in contributions
                $stmt = $db->prepare("DELETE FROM contributions WHERE Employee_ID = ?");
                $stmt->bind_param("i", $_POST['ID']);
                $stmt->execute();

                

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


            // ================================= Jobs management =================================

                if (isset($_POST['Job_Update'])) {
                    try {
                        $db = mysqli_connect($host, $user, $pwd, $sql_db);
                    } catch (Exception $e) {
                        set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . $e->getMessage() . "</pre>", $_POST);
                        header('Location: ../manage.php?Mode=Jobs');
                        die();
                    }

                    $query = "UPDATE jobs SET Reference_Number = ?, title = ?, type = ?, work_hours = ?, salary = ?, supervisor = ?, description = ?, responsibilities = ?, essential_qualifications = ?, preferable_qualifications = ?, benefits = ? WHERE reference_number = ?";

                    $stmt = $db->prepare($query);
                    $stmt->bind_param("ssssssssssss", $_POST['Reference_Number'], $_POST['Job_Title'], $_POST['Type'], $_POST['Work_Hours'], $_POST['Salary'], $_POST['Supervisor'], $_POST['Description'], $_POST['Responsibilities'], $_POST['essential_qualifications'], $_POST['preferable_qualifications'], $_POST['Benefits'], $_POST['Reference_Number_old']);



                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        set_data_response('success', 'Job Updated', 'The job has been updated successfully', 'Job Updated', 'The job has been updated successfully', '', $_POST);
                        header('Location: ../manage.php?Mode=Jobs');
                    } else {
                        set_data_response('error', 'No changes made', 'Failed to update the job', 'Job Update Failed', 'Failed to update the job, please try again later', '', $_POST);
                        header('Location: ../manage.php?Mode=Jobs');
                    }
                }
                if (isset($_POST['Job_Delete'])) {
                    try {
                        $db = mysqli_connect($host, $user, $pwd, $sql_db);
                    } catch (Exception $e) {
                        set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . $e->getMessage() . "</pre>", $_POST);
                        header('Location: ../manage.php?Mode=Jobs');
                        die();
                    }

                    $stmt = $db->prepare("DELETE FROM jobs WHERE Reference_Number = ?");
                    $stmt->bind_param("s", $_POST['Reference_Number_old']);

                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        set_data_response('success', 'Job Deleted', 'The job has been deleted successfully', 'Job Deleted', 'The job has been deleted successfully', '', $_POST);
                        header('Location: ../manage.php?Mode=Jobs');
                    } else {
                        set_data_response('error', 'Job Deletion Failed', 'Failed to delete the job', 'Job Deletion Failed', 'Failed to delete the job, please try again later', '', $_POST);
                        header('Location: ../manage.php?Mode=Jobs');
                    }


                }





            if (isset($db)) {
                $db->close();
            }
    }
?>