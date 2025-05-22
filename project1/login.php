<?php include '../php/functionality.php';?>


<!DOCTYPE html>
<html lang="en" class="<?php set_accessibility();?>">
    <?php display_info_card();?>

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
            <div>
                <h1>Admin Login</h1>
                <p>Login as administrator</p>
                <hr>
            </div>
            <form action="../php/login_handle.php" method="POST" novalidate>
                <div class="login_field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                

                <div class="login_field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>

            <p>Staff access only</p>

        </main>

        <?php include "../inc/footer.inc";?>
    </body>
</html>