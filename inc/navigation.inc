<!-- Main Navigation -->

<?php
    $currentfile = basename($_SERVER['PHP_SELF'])
?>
         
<nav class="main_navigation" id="<?php echo substr($currentfile, 0, -4); ?>_nav">
    <!-- Applies to all pages -->
    <a class="<?php if ($currentfile == "index.php") { echo "current";} ?>" href="./index.php"><img src="../images/home_icon.webp" alt="an image of a house icon">Home</a>
    <a class="<?php if ($currentfile == "about.php") { echo "current";} ?>" href="./about.php"><img src="../images/about_icon.webp" alt="an image of a sheet of paper icon">About</a>
    <a class="<?php if ($currentfile == "jobs.php") { echo "current";} ?>" href="./jobs.php"><img src="../images/job_icon.webp" alt="an image of a brief case icon">Jobs</a>
    <a class="<?php if ($currentfile == "apply.php") { echo "current";} ?>" href="./apply.php"><img src="../images/apply_icon.webp" alt="an image of a pen and paper icon">Apply</a>
    <a href="mailto:hemb.ithelp@gmail.com"><img src="../images/mail_icon.webp" alt="an image of a mail icon">Email us!</a>
</nav>