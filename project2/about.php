<?php

    include './php/functionality.php'; 
    require_once './php/settings.php';


    // Connect to the database
    $conn = new mysqli($host, $user, $pwd, $sql_db);
    if ($conn->connect_error) {
        set_data_response('error', 'Database Error', 'failed to connect to the database', 'Failed to connect to the database', "Something went wrong and failed to connect to the database", "Error: <pre>" . mysqli_connect_error() . "</pre>", $_POST);
        header('Location: manage.php?Mode=Account');
        die();
    }


    // Fetch employee data
    $query = "
    SELECT
        e.*,
        t.Name               AS tutor_Name,
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
    ";
    $result = $conn->query($query);

    
    if (!$result) {
        set_data_response('error', 'Query Error', 'Failed to fetch employee data', 'Query Error', 'Failed to fetch employee data from the database', "Error: <pre>" . $conn->error . "</pre>", $_POST);
        header('Location: ../manage.php?Mode=Account');
        die();
    }


    $contributions = [];
    
?>



<!DOCTYPE html>
<html lang="en" class="<?php set_accessibility(); ?>">


    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About Us | HEMB-IT</title>
        <meta name="description" content="HEMB IT Solutions - About Page containing information 
        about the team and their contributions. In addition, it contains information about 
        the employees regarding their class times, tutor names, student IDs and overall general insight.">
        <meta name="keywords" content="HEMB, IT, Solutions, About Page">
        <meta name="author" content="Ben Romano, Evan Harrison, Henry Bennett">
        <link rel="stylesheet" href="./styles/styles.css">
        <link rel="icon" type="image/x-icon" href="./images/fav_icon.webp">
    </head>


    <body>
        <?php 
            display_info_card();
            include './inc/accessibility.inc';
            include './inc/navigation.inc'; 
        ?>


        <main id="About_Main">
            <h1 id="about_us_heading">About Us</h1>
            <hr>

            <h2 class="about_us">What We Do!</h2>
            <p class="about_us">
                At HEMB IT Solutions, we provide reliable, high-quality IT support tailored to the unique needs of businesses of all sizes.
                From troubleshooting and system maintenance to network optimization and cybersecurity, our team delivers proactive support
                that empowers your business to thrive in a fast-paced digital world.
            </p>
            <hr>


            <div id="employee_info" class="main_section">


                <?php
                    // Loop through each employee and display their information
                    while ($row = $result->fetch_assoc()) {
                        $contributions = explode(',', $row['contributions']);
                        echo "<div class='individual_employee'>";
                        echo "<div class='title_image_and_list_flex_container'>";
                        echo "<div class='title_image'>";
                        echo "<h3>" . htmlspecialchars($row['First_name']) . " " . htmlspecialchars($row['Last_name']) . "</h3>";
                        echo "<img class='individual_employee_photos' src='images/" . htmlspecialchars($row['Photo']) . "' alt='Front-facing picture of " . htmlspecialchars($row['First_name']) . ", one of the team members'>";
                        echo "</div>";
                        echo "<ul>";
                        echo "<li><strong>Student ID:</strong> " . htmlspecialchars($row['Student_ID']) . "</li>";
                        echo "<li><strong>Tutor Name:</strong> " . htmlspecialchars($row['tutor_Name']) . "</li>";
                        echo "<li><strong>Class Times:</strong> " . htmlspecialchars($row['class_time_Day']) . " " . htmlspecialchars($row['class_start_time']) . " - " . htmlspecialchars($row['class_end_time']) . "</li>";

                        echo "</div>";

                        echo "<p>" . htmlspecialchars($row['Description']) . "</p>";

                        echo "</div>";
                    }
                ?>


                <hr>
                <section id='member_contributions'>
                    <h2>Member Contributions</h2>
                    <p>Each member of our team has played a crucial role in the development of this project. Below is a summary of each member's contributions:</p>
                    <dl>
                    <?php
                    $result = $conn->query($query);
                    while ($row = $result->fetch_assoc()) {
                        echo "<dt>" . htmlspecialchars($row['First_name']) . " " . htmlspecialchars($row['Last_name']) . "</dt>";
                        echo "<dd>" . htmlspecialchars($row['contributions']) . "</dd>";
                    }
                    ?>
                </dl>
                </section>

                <img id="Group_Photo" src="images/Group_Photo.webp" alt="A Photo of 4 people showing the developer team">


            </div>

        </main>


        <?php 
            display_info_card();
            include './inc/footer.inc'; 
        ?>

    </body>

    
</html>