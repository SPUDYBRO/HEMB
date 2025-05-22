
<?php 
require_once '../php/settings.php';
include '../php/functionality.php';
?>




<!DOCTYPE html>
<html lang="en">
<head class="<?php set_accessibility();?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin management page for handling data for the website">
    <meta name="keywords" content="HEMB, IT, Solutions, Admin, Management, Data">
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Manager | HEMB-IT</title>
</head>
<body>
    <?php display_info_card();?>
    <?php include '../inc/accessibility.inc'; ?>
    <?php include '../inc/navigation.inc'; ?>



    <main id="manage_main">
        <div id="manage_header">
            <h1>Admin Management</h1>
            <!-- Since the session isn't built yet, we will use a default name ME!!! mwhaaha-->
            <p>Welcome <?php echo htmlspecialchars(isset($_SESSION['username']) ? $_SESSION['username'] : "Evan"); ?></p>
            <hr>
        </div>

        <form id="manager_options" method="get" action="manage.php">
            <button class="<?php if (isset($_GET['Mode']) && $_GET['Mode'] == "EOI") { echo "current";}?>" type="submit" name="Mode" value="EOI">EOIS</button>
            <button class="<?php if (isset($_GET['Mode']) && $_GET['Mode'] == "Accounts") { echo "current";}?>" type="submit" name="Mode" value="Accounts">Accounts</button>
            <button class="<?php if (isset($_GET['Mode']) && $_GET['Mode'] == "Employees") { echo "current";}?>" type="submit" name="Mode" value="Employees">Employees</button>
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
                        echo '<meta http-equiv="refresh" content="0;url=manage.php">'; // guys this just redirects the user back to this page (clearing the get request) so it can display the error message. and header doesn't work because i have already sent HTML
                        die();
                    }

                    $query = "SELECT * FROM eoi";
                    $result = mysqli_query($db, $query);
                    if (!$result) {
                        set_data_response('error', 'Database Error', 'failed to query the database', 'Failed to query the database', "Something went wrong and failed to query the database", "Error: <pre>" . mysqli_error($db) . "</pre>", $_GET);
                        echo '<meta http-equiv="refresh" content="0;url=manage.php">';
                        die();
                    }

                    if (mysqli_num_rows($result) == 0) {
                        echo "<p>No one have submitted an EOI</p>";
                        echo "<a href='manage.php?Mode=EOI'>Refresh</a>";
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

                            echo '<form>Status: 
                                <select name="status">
                                    <option value="New"' . ($row['Status'] == 'New' ? ' selected' : '') . '>New</option>
                                    <option value="Current"' . ($row['Status'] == 'Current' ? ' selected' : '') . '>Current</option>
                                    <option value="Final"' . ($row['Status'] == 'Final' ? ' selected' : '') . '>Final</option>
                                </select>
                                <button type="submit" name="update" value="' . htmlspecialchars($row['EOInumber']) . '">Update</button>
                            </form>';
                            echo "</section>";
                        }
                    }






                } elseif ($_GET['Mode'] == "Accounts") {
                    // =================== Account Management ===================
                    echo "<h2>Account Management</h2>";
                    echo "<p>Manage the account data here</p>";









                } elseif ($_GET['Mode'] == "Employees") {
                    // =================== Employee Management ===================
                    echo "<h2>Employee Management</h2>";
                    echo "<p>Manage the employee data here</p>";








                }

            ?>
        </section>

    </main>
    <?php include '../inc/footer.inc';?>
    
</body>
</html>