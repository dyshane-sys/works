<!doctype html>
<html lang="en">
<head>
    <title>Dy Web - Login</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="includes.css">
</head>
<body>
<div id="container">
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>
    <?php include('info-col.php'); ?>

    <div id="content">
        <h3>Login</h3>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require('mysqli_connect.php');

            // Validate email and password input
            if (!empty($_POST['email'])) {
                $e = mysqli_real_escape_string($dbcon, $_POST['email']);
            } else {
                echo '<p class="error">Please enter your email address.</p>';
            }

            if (!empty($_POST['psword'])) {
                $p = mysqli_real_escape_string($dbcon, $_POST['psword']);
            } else {
                echo '<p class="error">Please enter your password.</p>';
                $p = NULL;
            }

            if ($e && $p) {
                // Check if the user exists in the database
                $hashed = hash('sha256', $p);
                $q = "SELECT user_id, fname, user_level FROM users WHERE email = '$e' AND psword = '$hashed'";
                $result = mysqli_query($dbcon, $q);

                if (mysqli_num_rows($result) == 1) {
                    session_start();
                    $_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $_SESSION['user_level'] = (int)$_SESSION['user_level'];

                    // Redirect based on user level
                    $url = ($_SESSION['user_level'] === 1) ? 'admin.php' : 'members_page.php';
                    header('Location: ' . $url);
                    exit();
                } else {
                    echo '<p class="error">Invalid email or password. Please try again.</p>';
                }

                mysqli_free_result($result);
            } else {
                echo '<p class="error">Please enter both email and password.</p>';
            }

            mysqli_close($dbcon);
        }
        ?>

        <!-- Simple login form -->
        <form action="login.php" method="post">
            <p><label for="email">Email Address:</label>
                <input type="text" name="email" size="30" maxlength="50" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"></p>
            <p><label for="psword">Password:</label>
                <input type="password" name="psword" size="20" maxlength="20"></p>
            <p><input type="submit" name="submit" value="Login"></p>
        </form>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>
