<!-- Main Navigation -->

<?php
    $currentfile = basename($_SERVER['PHP_SELF'])
?>
         
<nav class="main_navigation" id="<?php echo substr($currentfile, 0, -4); ?>_nav">
    <!-- Applies to all pages -->
    <a class="<?php if ($currentfile == "index.php") { echo "current";} ?>" href="./index.php"><?php echo NAV_SVG_ICONS['Home']; ?>Home</a>
    <a class="<?php if ($currentfile == "about.php") { echo "current";} ?>" href="./about.php"><?php echo NAV_SVG_ICONS['About']; ?>About</a>
    <a class="<?php if ($currentfile == "jobs.php") { echo "current";} ?>" href="./jobs.php"><?php echo NAV_SVG_ICONS['Jobs']; ?>Jobs</a>
    <a class="<?php if ($currentfile == "apply.php") { echo "current";} ?>" href="./apply.php"><?php echo NAV_SVG_ICONS['Apply']; ?>Apply</a>
    <a href="mailto:hemb.ithelp@gmail.com"><?php echo NAV_SVG_ICONS['Email']; ?>Email</a>
    <a class="<?php if ($currentfile == "login.php") { echo "current";} ?>" href="./login.php"><?php echo NAV_SVG_ICONS['Staff']; ?>Staff</a>
</nav>