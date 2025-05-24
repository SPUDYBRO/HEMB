<?php
    include '../php/functionality.php'; 
?>

<!DOCTYPE html>
<html lang="en" class="<?php set_accessibility(); ?>">

<head>
    <title>About Us | HEMB-IT</title>
    <meta name="description" content="HEMB IT Solutions - About Page">
    <meta name="keywords" content="HEMB, IT, Solutions, About Page">
    <meta name="author" content="Ben Romano, Evan Harrison, Henry Bennett">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="icon" type="image/x-icon" href="../images/fav_icon.webp">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<?php 
    display_info_card();
    include '../inc/accessibility.inc';
    include '../inc/navigation.inc'; 
?>

<main id="About_Main">

<?php
    $conn = new mysqli("localhost", "root", "", "hemb_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sections = ['about', 'what_we_do'];

    foreach ($sections as $section) {
        $stmt = $conn->prepare("SELECT heading, content FROM about_us_content WHERE section = ?");
        $stmt->bind_param("s", $section);
        $stmt->execute();
        $stmt->bind_result($heading, $content);

        if ($stmt->fetch()) {
            if ($section === 'about') {
                echo "<h1 id='about_us_heading'>" . htmlspecialchars($heading) . "</h1><hr>";
            } else {
                echo "<h2 class='about_us'>" . htmlspecialchars($heading) . "</h2>";
            }

            if (!empty($content)) {
                echo "<p class='about_us'>" . nl2br(htmlspecialchars($content)) . "</p>";
            }
        }

        $stmt->close();
    }
?>

<hr>

<section id="employee_info" class="main_section">
    <?php
        $sql = "SELECT name, student_id, tutor_name, class_times, website_goal, description FROM team_members";
        $result = $conn->query($sql);

        $images = [
            "Evan Harrison"      => "../images/Evan_Harrison.webp",
            "Henry Bennett"      => "../images/Henry_Bennett.webp",
            "Ben Romano"         => "../images/Ben_Romano.webp",
            "Michael Sharpley"   => "../images/Michael_Sharpley.webp"
        ];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = htmlspecialchars($row['name']);
                $image = isset($images[$name]) ? $images[$name] : "../images/default.webp";

                echo '<div class="individual_employee">';
                echo '  <div class="title_image_and_list_flex_container">';
                echo '      <div class="title_image">';
                echo "          <h3>$name</h3>";
                echo "          <img class='individual_employee_photos' src='$image' alt='Photo of $name' loading='lazy'>";
                echo '      </div>';
                echo '      <ul>';
                echo "          <li><strong>Student ID:</strong> " . htmlspecialchars($row['student_id']) . "</li>";
                echo "          <li><strong>Tutor Name:</strong> " . htmlspecialchars($row['tutor_name']) . "</li>";
                echo "          <li><strong>Class Times:</strong> " . htmlspecialchars($row['class_times']) . "</li>";
                echo '      </ul>';
                echo '  </div>';
                echo '  <p>' . nl2br(htmlspecialchars($row['description'])) . '</p>';
                echo '</div><hr>';
            }
        } else {
            echo "<p>No team member data found.</p>";
        }
    ?>
</section>

<section id="contributions">
    <?php
        $stmt = $conn->prepare("SELECT heading, content FROM about_us_content WHERE section = 'contributions'");
        $stmt->execute();
        $stmt->bind_result($heading, $content);

        if ($stmt->fetch()) {
            echo "<h2>" . htmlspecialchars($heading) . "</h2><hr>";
            echo "<p>" . nl2br(htmlspecialchars($content)) . "</p>";
        } else {
            echo "<p>No contributions section found.</p>";
        }

        $stmt->close();
    ?>
</section>

<section id="member_roles">
    <?php
        $stmt = $conn->prepare("SELECT heading, content FROM about_us_content WHERE section = 'member_roles'");
        $stmt->execute();
        $stmt->bind_result($heading, $content);

        if ($stmt->fetch()) {
            echo "<h2>" . htmlspecialchars($heading) . "</h2><hr>";
            echo "<p>" . nl2br(htmlspecialchars($content)) . "</p>";
        }

        $stmt->close();

        $sql = "SELECT name, contribution FROM member_roles";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo '<dl class="member-roles-list">';
            while ($row = $result->fetch_assoc()) {
                echo "<dt><strong><u>" . htmlspecialchars($row['name']) . "</u></strong></dt>";
                echo "<dd>" . htmlspecialchars($row['contribution']) . "</dd>";
            }
            echo '</dl>';
        } else {
            echo "<p>No member roles found.</p>";
        }
    ?>
</section>

<img id="Group_Photo" src="../images/Group_Photo.webp" alt="A Photo of 4 people showing the developer team" loading="lazy">

</main>

<?php 
    display_info_card();
    include '../inc/footer.inc'; 
    $conn->close();
?>

</body>
</html>