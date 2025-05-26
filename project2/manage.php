
<?php 
require_once './settings.php';
include './functionality.php';



if (!is_logged_in()) {
    set_data_response('error', 'Access Denied', 'This page is only for staff', 'This page is only allowed for staff', "You are not allowed to access this page", "if you are staff, please navigate to the login page to get access");
    header('Location: ' . "./index.php");
    die();
}

if (isset($_GET['Mode'])) {
    if ($_GET['Mode'] == "Logout") {
        logout();
        header('Location: ' . "./index.php");
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="<?php set_accessibility();?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin management page for handling data for the website">
    <meta name="keywords" content="HEMB, IT, Solutions, Admin, Management, Data">
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Manager | HEMB-IT</title>
</head>
<body>
    <?php display_info_card();?>
    <?php include '../accessibility.inc'; ?>
    <?php include '../navigation.inc'; ?>



    <main id="manage_main">
        <div id="manage_header">
            <h1>Admin Management</h1>
            <p>Welcome <?php echo $_SESSION['User']->Username; ?></p>
            <hr>
        </div>

        <form id="manager_options" method="get" action="./manage.php">
            <button class="<?php if (isset($_GET['Mode']) && $_GET['Mode'] == "EOI") { echo "current";}?>" type="submit" name="Mode" value="EOI">EOIS</button>
            <?php
            if ($_SESSION['User']->Role == "Admin") {
                if (isset($_GET['Mode']) && $_GET['Mode'] == "Accounts") { $current = "current";} else { $current = ""; }
                echo "<button class=" . $current . " type='submit' name='Mode' value='Accounts'>All Accounts</button>";
            }
            ?>
            <button class="<?php if (isset($_GET['Mode']) && $_GET['Mode'] == "Employees") { echo "current";}?>" type="submit" name="Mode" value="Employees">Employees</button>
            <button class="<?php if (isset($_GET['Mode']) && $_GET['Mode'] == "Logout") { echo "current";}?>" type="submit" name="Mode" value="Logout">Logout</button>
        </form>


        <section class="main_section" id="manage_section">
            <?php
                if (!isset($_GET['Mode'])) {
                    echo "<h2>Select an option to begin</h2>";
                    echo "<p>Click on the buttons above to select an option</p>";
                }
                elseif ($_GET['Mode'] == "EOI") {
                    // =================== EOI Management ===================
                    echo "<h2>EOI Management</h2>";
                    echo "<p>Evaluate Expressions of interest</p>";

                    try {
                        $db = mysqli_connect($host, $user, $pwd, $sql_db);
                    } catch (Exception $e) {
                        set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . $e->getMessage() . "</pre>", $_GET);
                        echo '<meta http-equiv="refresh" content="0;url=./manage.php">'; // guys this just redirects the user back to this page (clearing the get request) so it can display the error message. and header doesn't work because i have already sent HTML
                        die();
                    }

                    $query = "SELECT * FROM eoi";
                    $result = mysqli_query($db, $query);
                    if (!$result) {
                        set_data_response('error', 'Database Error', 'failed to query the database', 'Failed to query the database', "Something went wrong and failed to query the database", "Error: <pre>" . mysqli_error($db) . "</pre>", $_GET);
                        echo '<meta http-equiv="refresh" content="0;url=./manage.php">';
                        die();
                    }

                    if (mysqli_num_rows($result) == 0) {
                        echo "<p>No one have submitted an EOI</p>";
                        echo "<a href='./manage.php?Mode=EOI'>Refresh</a>";
                    }
                    else {
                        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                            $row = mysqli_fetch_assoc($result);
                            echo "<section class='result'>";
                            echo "<h3>" . htmlspecialchars($row['Firstname']) . " " . htmlspecialchars($row['Lastname']) . "</h3>";

                            echo "<h4><br>Information</h4>";
                            echo "<table class='result_table'>";
                            echo "<thead>";
                            echo "<tr>
                                <th>EOI Number</th>
                                <th>Job Ref Num</th>
                                <th>Address</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                                  </tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['EOInumber']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Job_Ref_Num']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Address']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Email_Address']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Phone_Number']) . "</td>";
                            echo "</tr>";
                            echo "</tbody>";
                            echo "</table>";

                            echo "<div class='result_text'>";
                            echo "<h4>Skills:</h4>";
                            echo "<p>" . htmlspecialchars($row['Technical_Skills']) . "</p>";
                            echo "</div><div class='result_text'>";
                            echo "<h4>Other Skills:</h4>";
                            echo "<p>" . htmlspecialchars($row['Other_Skills']) . "</p>";
                            echo "</div>";

                            echo '<form method="post" action="./process_manage.php" autocomplete="off">Status: 
                                <input type="hidden" name="EOInumber" value="' . htmlspecialchars($row['EOInumber']) . '">
                                <select name="status">
                                    <option value="New"' . ($row['Status'] == 'New' ? ' selected' : '') . '>New</option>
                                    <option value="Current"' . ($row['Status'] == 'Current' ? ' selected' : '') . '>Current</option>
                                    <option value="Final"' . ($row['Status'] == 'Final' ? ' selected' : '') . '>Final</option>
                                </select>
                                <button type="submit" name="EOI_Update">Update</button>
                                <button type="submit" name="EOI_Delete">Delete</button>
                            </form>';
                            echo "</section>";
                        }
                    }






                } elseif ($_GET['Mode'] == "Accounts") {
                    // =================== Account Management ===================

                    if ($_SESSION['User']->Role != "Admin") {
                        echo "<h2>Access Denied</h2>";
                        echo "<p>You do not have permission to access this page</p>";
                    } else {
                        echo "<h2>Account Management</h2>";
                        echo "<p>Manage the account data here</p>";
                        echo "<form method='post' action='./manage.php?Mode=Accounts'>
                                <button type='submit' name='Account_Create'>Create New Account</button>
                            </form>";

                        $db = mysqli_connect($host, $user, $pwd, $sql_db);
                        if (!$db) {
                            set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . mysqli_connect_error() . "</pre>", $_GET);
                            echo '<meta http-equiv="refresh" content="0;url=./manage.php">';
                            die();
                        }

                        $stmt = $db->prepare("SELECT * FROM users");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if (!$result) {
                            set_data_response('error', 'Database Error', 'failed to query the database', 'Failed to query the database', "Something went wrong and failed to query the database", "Error: <pre>" . mysqli_error($db) . "</pre>", $_GET);
                            echo '<meta http-equiv="refresh" content="0;url=./manage.php">';
                            die();
                        }

                        if (isset($_POST['Account_Create'])) {
                            echo "<form method='post' action='./process_manage.php'>";
                            echo "<input type='text' name='Username' placeholder='Username' required>";
                            echo "<input type='password' name='Password' placeholder='Password' required>";
                            echo "<select name='Role' required>
                                    <option value='Member'>Member</option>
                                    <option value='Admin'>Admin</option>
                                </select>";
                            echo "<button type='submit' name='Account_Create'>Create Account</button>";
                            echo "</form>";
                        }

                        if (mysqli_num_rows($result) == 0) {
                            echo "<p>No accounts found</p>";
                        } else {
                            for( $i = 0; $i < mysqli_num_rows($result); $i++) {
                                $row = mysqli_fetch_assoc($result);
                                echo "<section class='result'>";
                                $title = "<h3>" . htmlspecialchars($row['Username']);
                                if ($_SESSION['User']->ID == $row['ID']) {
                                    $title .= " | (you)</h3>";
                                } else { $title .= "</h3>"; }
                                
                                echo $title;
                                echo "<table class='result_table'>";
                                echo "<thead>";
                                echo "<tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Password (can only be changed)</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                  </tr>";
                                echo "</thead>";
                                echo "<form method='post' action='./process_manage.php' autocomplete='off'>";
                                echo "<tbody>";
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                                echo "<input type='hidden' name='ID' value='". $row['ID'] . "'>";
                                echo "<td> <input type='text' name='Username' value='" . htmlspecialchars($row['Username']) . "' required></td>";
                                echo "<td> <input type='password' name='Password' placeholder='Leave blank to keep current password' autocomplete='new-password'></td>";
                                echo "<td>
                                    <select name='Role'>
                                        <option value='User'" . ($row['Role'] == 'Member' ? ' selected' : '') . ">Member</option>
                                        <option value='Admin'" . ($row['Role'] == 'Admin' ? ' selected' : '') . ">Admin</option>
                                    </select>";
                                echo "</td>";
                                echo "<td><button type='submit' name='Account_Update'>Update</button>
                                        <button type='submit' name='Account_Delete'>Delete</button></td>";
                                echo "</tr>";
                                echo "</tbody>";
                                echo "</form>";
                                echo "</table>";
                                echo "</section>";
                            }
                        }
                    }
                    


                } elseif ($_GET['Mode'] == "Employees") {
                    // =================== Employee Management ===================
                    echo "<h2>Employee Management</h2>";
                    echo "<p>Manage the employee data here</p>";

                    $db = mysqli_connect($host, $user, $pwd, $employees_db);
                    if (!$db) {
                        set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . mysqli_connect_error() . "</pre>", $_GET);
                        echo '<meta http-equiv="refresh" content="0;url=./manage.php">';
                        die();
                    }
                    $result = $db->query("
                    SELECT
                        e.*,
                        t.Name       	    AS tutor_Name,
                        ct.Day              AS class_time_Day,
                        ct.Start_Time       AS class_start_time,
                        ct.End_Time         AS class_end_time,
                        GROUP_CONCAT(c.Contribution ORDER BY c.Contribution SEPARATOR ',') AS contributions
                    FROM employees AS e
                    LEFT JOIN tutors AS t
                        ON e.Tutor_ID = t.Tutor_ID
                    LEFT JOIN class_times AS ct
                        ON e.Class_Time_ID = ct.Class_Time_ID
                    LEFT JOIN contributions AS c
                        ON e.ID = c.Employee_ID
                    GROUP BY e.ID;
                    ");
                    if (!$result) {
                        set_data_response('error', 'Database Error', 'failed to query the database', 'Failed to query the database', "Something went wrong and failed to query the database", "Error: <pre>" . mysqli_error($db) . "</pre>", $_GET);
                        echo '<meta http-equiv="refresh" content="0;url=./manage.php?Mode=Employees">';
                        die();
                    }
                    if (mysqli_num_rows($result) == 0) {
                        set_data_response('info', 'No Employees Found', 'There are no employees in the database', 'No Employees Found', 'There are no employees in the database', '', $_GET);
                        echo '<meta http-equiv="refresh" content="0;url=./manage.php?Mode=Employees">';
                        die();
                    }
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<section class='result'>";
                        echo "<h3>" . htmlspecialchars($row['First_name']) . " " . htmlspecialchars($row['Last_name']) . "</h3>";

                        echo "<table class='result_table'>";

                        echo "<thead>";
                        echo "<tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Student ID</th>
                            <th>Tutor</th>
                            <th>Class Time</th>";
                        echo "</tr>";
                        echo "</thead>";

                        echo "<tbody>";
                        echo "<form method='post' action='./process_manage.php' autocomplete='off'>";
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                        echo "<input type='hidden' name='ID' value='" . htmlspecialchars($row['ID']) . "'>";
                        echo "<td><input type='text' name='First_name' value='" . htmlspecialchars($row['First_name']) . "' required></td>";
                        echo "<td><input type='text' name='Last_name' value='" . htmlspecialchars($row['Last_name']) . "' required></td>";
                        echo "<td><input type='text' name='Student_ID' value='" . htmlspecialchars($row['Student_ID']) . "' required></td>";
                        echo "<td><input type='text' name='Tutor_name' value='" . htmlspecialchars($row['tutor_Name']) . "' required></td>";
                        echo "<input type='hidden' name='Tutor_ID' value='" . htmlspecialchars($row['Tutor_ID']) . "'>";
                        echo "<td><input type='text' name='class_time' placeholder='Day start Time -- End time' name='Class_Time' value='" . htmlspecialchars($row['class_time_Day']) . " " . htmlspecialchars($row['class_start_time']). " - " . htmlspecialchars($row['class_end_time']) . "' required></td>";

                        echo "<input type='hidden' name='Class_Time_ID' value='" . htmlspecialchars($row['Class_Time_ID']) . "'>";
                        
                        echo "</tr>";
                        echo "</tbody>";

                        echo "</table>";

                        echo "<textarea name='contributions' placeholder='Contributions (comma separated)' required>" . htmlspecialchars($row['contributions']) . "</textarea>";

                        echo "<textarea name='description' placeholder='Description' required>" . htmlspecialchars($row['Description']) . "</textarea>";

                        echo "<img src='../images/" . htmlspecialchars($row['Photo']) . "' alt='" . htmlspecialchars($row['Photo_Alt']) . "'</img>";

                        echo "<button type='submit' name='Employee_Update'>Update</button>";
                        echo "<button type='submit' name='Employee_Delete'>Delete</button>";
                        echo "</form>";

                        echo "</section>";               
                    }
                }
 
                if (isset($db)) {
                    mysqli_close($db);
                }
            ?>
        </section>

    </main>
    <?php include '../footer.inc';?>
    
</body>
</html>