<<!doctype html>
<html lang="en">
<head>
    <title>Edit User Info</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="includes.css">
</head>
<body>
    <div id="container">
        <?php include('header.php'); ?>
        <?php include('navedit.php'); ?>
        <?php include('info-col.php'); ?>
        
        <div id="content">
            <h2>Edit User Information</h2>
            <?php 
                // Check for a valid user ID
                if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
                    $id = $_GET['id'];
                } elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
                    $id = $_POST['id'];
                } else {
                    echo '<p class="error">This page has been accessed in error.</p>';
                    include('footer.php');
                    exit();
                }

                require('mysqli_connect.php');

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $errors = array();

                    // Validate first name, last name, and email fields
                    if (empty($_POST['fname'])) $errors[] = 'Please enter your first name.';
                    else $fn = trim($_POST['fname']);

                    if (empty($_POST['lname'])) $errors[] = 'Please enter your last name.';
                    else $ln = trim($_POST['lname']);

                    if (empty($_POST['email'])) $errors[] = 'Please enter your email.';
                    else $e = trim($_POST['email']);

                    if (empty($errors)) {
                        // Update user information
                        $q = "UPDATE users SET fname='$fn', lname='$ln', email='$e' WHERE user_id='$id' LIMIT 1";
                        $result = @mysqli_query($dbcon, $q);
                        if (mysqli_affected_rows($dbcon) == 1) {
                            echo '<h3>User information updated successfully!</h3>';
                        } else {
                            echo '<h3>Update failed. Please try again.</h3>';
                        }
                    } else {
                        echo '<h2>Error!</h2><p class="error">The following errors occurred:<br>';
                        foreach ($errors as $msg) {
                            echo " - $msg<br>\n";
                        }
                        echo '<p>Please try again.</p>';
                    }
                }

                // Retrieve the user’s information
                $q = "SELECT fname, lname, email FROM users WHERE user_id='$id'";
                $result = @mysqli_query($dbcon, $q);

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Create form with current user data
                    echo '
                        <form action="edit_user.php" method="post">
                            <p><label for="fname">First Name:</label>
                            <input type="text" name="fname" size="30" maxlength="40" value="' . $row['fname'] . '"></p>

                            <p><label for="lname">Last Name:</label>
                            <input type="text" name="lname" size="30" maxlength="40" value="' . $row['lname'] . '"></p>

                            <p><label for="email">Email:</label>
                            <input type="text" name="email" size="30" maxlength="50" value="' . $row['email'] . '"></p>

                            <p><input type="submit" name="submit" value="Save Changes"></p>
                            <input type="hidden" name="id" value="' . $id . '">
                        </form>
                    ';
                } else {
                    echo '<h2>Error</h2><p>The user does not exist.</p>';
                }

                mysqli_close($dbcon);
            ?>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
