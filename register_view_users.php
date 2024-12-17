<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register User/Dy</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="includes.css">
</head>
<body>
    <div id="container">
        <?php include('header.php'); ?>
        <?php include('nav.php'); ?>
        <?php include('info-col.php'); ?>

        <div id="content">
            <h2>Register Users</h2>
            <p>
            <?php
            require('mysqli_connect.php');
            // Fetch data through query
            $q = "SELECT user_id, lname, fname, email, DATE_FORMAT(registration_date, '%M %D, %Y') AS regdate FROM users ORDER BY registration_date ASC";
            $result = @mysqli_query($dbcon, $q);

            if ($result) { // Success
                echo '<table id="users-table">
                        <tr>
                            <td>Name</td>
                            <td>email</td>
                            <td>Registration Date</td>
                            <td>Edit</td>
                            <td>Delete</td>
                        </tr>';
                
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo '<tr>
                            <td>' . $row['lname'] . '  ' . $row['fname'] . '</td>
                            <td>' . $row['email'] . '</td>
                            <td>' . $row['regdate'] . '</td>
                            <td><a href="edit_user.php?id=' . $row['user_id'] . '">Edit</a></td>
                            <td><a href="delete_user.php?id=' . $row['user_id'] . '">Delete</a></td>
                          </tr>';
                }
                
                echo '</table>';
                mysqli_free_result($result);
            } else {
                echo '<p class="error">The current users could not be retrieved due to a system error. Please report this incident to the Sysadmin. Error Code: 17</p>';
            }

            mysqli_close($dbcon);
            ?>
            </p>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>