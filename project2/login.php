<?php include './php/functionality.php';?>


<!DOCTYPE html>
<html lang="en" class="<?php set_accessibility();?>">
    <?php display_info_card();?>

<head class="<?php set_accessibility();?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | HEMB-IT</title>
    <meta name="description" content="HEMB IT Solutions - Login Page for administrators to access 
    the admin panel so that they can utilies their modification tools. The login page contains a
    form for the administrator to enter their username and password. If the login is successful, the
    administrator will be redirected to the admin panel. If the login is unsuccessful, an error 
    message will be displayed.">
    <meta name="keywords" content="HEMB, IT, Solutions, Admin, Login, sign in">
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="icon" type="image/x-icon" href="./images/fav_icon.webp">
</head>
    <body id="login_body">
        <?php include './inc/accessibility.inc'; ?>
        <?php include './inc/navigation.inc'; ?>


        <main id="login_main">
            <div>
                <h1>Admin Login</h1>
                <p>Login as administrator</p>
                <hr>
            </div>
            <form action="./php/login_handle.php" method="POST" novalidate>
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

        <?php include "./inc/footer.inc";?>
    </body>
</html>