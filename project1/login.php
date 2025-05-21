<!DOCTYPE html>
<html lang="en">

<?php include '../php/functionality.php';?>

<head class="<?php set_accessibility();?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | HEMB-IT</title>
    <meta name="description" content="Admin login page for HEMB IT Solutions to get access to a variety of admin options">
    <meta name="keywords" content="HEMB, IT, Solutions, Admin, Login, sign in">
    <link rel="stylesheet" href="../styles/styles.css">
</head>
    <body id="login_body">
        <?php include '../inc/accessibility.inc'; ?>
        <?php include '../inc/navigation.inc'; ?>


        <main id="login_main">
            <h1>Admin Login</h1>
            <p>Login as administrator</p>
            <form action="login.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Login</button>
            </form>
        </main>

        <?php include "../inc/footer.inc";?>
    </body>
</html>