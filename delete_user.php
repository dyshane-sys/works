<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dy Web - Delete User</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="includes.css">
</head>
<body>
    <div id="container">
        <?php include('header.php'); ?>
        <?php include('navdel.php'); ?>
        <?php include('info-col.php'); ?>

        <div id="content">
            <h3>Deleting Records</h3>
            <?php
            // Check if a valid user ID is provided
            if ((isset($_GET['id'])) && is_numeric($_GET['id'])) {
                $id = $_GET['id'];
            } elseif ((isset($_POST['id'])) && is_numeric($_POST['id'])) {
                $id = $_POST['id'];
            } else {
                echo '<p class="error">This page has been accessed by mistake.</p>';
                include('footer.php');
                exit();
            }

            require('mysqli_connect.php');

            // Handle the form submission
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($_POST['sure'] == 'Yes') {
                    $q = "DELETE FROM users WHERE user_id = $id LIMIT 1";  // Delete query
                    $result = @mysqli_query($dbcon, $q);
                    if (mysqli_affected_rows($dbcon) == 1) {
                        echo '<h3>The record has been deleted.</h3>';
                    } else {
                        echo '<h3 class="error">The record could not be deleted.</h3>';
                    }
                } else {
                    echo '<h3>Record deletion canceled.</h3>';
                }
            } else {
                // Display the confirmation form
                $q = "SELECT CONCAT(fname, ' ', lname) FROM users WHERE user_id = $id";
                $result = @mysqli_query($dbcon, $q);

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_array($result, MYSQLI_NUM);
                    echo "<h3>Are you sure you want to permanently delete $row[0]?</h3>";
                    echo '
                        <form action="delete_user.php" method="post">
                            <input id="submit-yes" type="submit" name="sure" value="Yes">
                            <input id="submit-no" type="submit" name="sure" value="No">
                            <input type="hidden" name="id" value="' . $id . '">
                        </form>
                    ';
                } else {
                    echo '<p class="error">No such user found.</p>';
                }
            }

            mysqli_close($dbcon);
            include('footer.php');
            ?>
        </div>
    </div>
</body>
</html>
