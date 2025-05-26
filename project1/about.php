<?php
    include '../php/functionality.php'; 
    require_once '../php/settings.php';

    // Connect to the database
    $conn = new mysqli($host, $user, $pwd, $employees_db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch employee data
    $query = "
        SELECT 
            e.id, e.first_name, e.last_name, e.student_id, e.photo, e.photo_alt, e.description,
            t.name AS tutor_name,
            CONCAT(ct.day, ' ', TIME_FORMAT(ct.start_time, '%H:%i'), ' - ', TIME_FORMAT(ct.end_time, '%H:%i')) AS class_time,
            GROUP_CONCAT(c.contribution SEPARATOR ', ') AS contributions
        FROM employees e
        LEFT JOIN tutors t ON e.tutor_id = t.tutor_id
        LEFT JOIN class_times ct ON e.id = ct.employee_id
        LEFT JOIN contributions c ON e.id = c.employee_id
        GROUP BY e.id
        ORDER BY e.id ASC
    ";
    $result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en" class="<?php set_accessibility(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | HEMB-IT</title>
    <meta name="description" content="HEMB IT Solutions - About Page">
    <meta name="keywords" content="HEMB, IT, Solutions, About Page">
    <meta name="author" content="Ben Romano, Evan Harrison, Henry Bennett">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="icon" type="image/x-icon" href="../images/fav_icon.webp">
</head>
<body>
    <?php 
        display_info_card();
        include '../inc/accessibility.inc';
        include '../inc/navigation.inc'; 
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

        <section id="employee_info" class="main_section">
            <h2>Meet the Team</h2>
            <hr>

            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="individual_employee">
                        <div class="title_image_and_list_flex_container">
                            <div class="title_image">
                                <h3><?= htmlspecialchars($row['first_name']) ?><br><?= htmlspecialchars($row['last_name']) ?></h3>
                                <img class="individual_employee_photos" 
                                     src="../images/<?= htmlspecialchars($row['photo']) ?>" 
                                     alt="<?= htmlspecialchars($row['photo_alt']) ?>" 
                                     loading="lazy">
                            </div>
                            <ul>
                                <li><strong>Student ID:</strong> <?= htmlspecialchars($row['student_id']) ?></li>
                                <li><strong>Tutor Name:</strong> <?= htmlspecialchars($row['tutor_name']) ?></li>
                                <li><strong>Class Times:</strong> <?= htmlspecialchars($row['class_time']) ?></li>
                                <li><strong>Contributions:</strong> <?= htmlspecialchars($row['contributions']) ?></li>
                            </ul>
                        </div>
                        <p><?= htmlspecialchars($row['description']) ?></p>
                    </div>
                    <hr>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No employee data found.</p>
            <?php endif; ?>
        </section>

        <section id="member_contributions">
            <p></p>
            <h2>Member Contributions</h2>
            <p>Each member of our team played a vital role in the success of this project. Below is a summary of individual contributions:</p>

            <?php
                $query = "
                    SELECT 
                        e.id, e.first_name, e.last_name, 
                        GROUP_CONCAT(c.contribution SEPARATOR ', ') AS contributions
                    FROM employees e
                    LEFT JOIN contributions c ON e.id = c.employee_id
                    GROUP BY e.id
                    ORDER BY e.id ASC
                ";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
            ?>
                        <div class="member-contribution">
                            <h3 style="margin: 0;"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></h3>
                            <ul>
                                <?php foreach (explode(', ', $row['contributions']) as $contribution): ?>
                                    <li><?= htmlspecialchars($contribution); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
            <?php
                    endwhile;
                else:
                    echo "<p>No contributions found.</p>";
                endif;
            ?>
        </section>

        <hr>

        <h2>Group Photo</h2>
        <img id="Group_Photo" src="../images/Group_Photo.webp" alt="A photo of the developer team" loading="lazy">
    </main>

    <?php 
        display_info_card();
        include '../inc/footer.inc'; 
    ?>
</body>
</html>