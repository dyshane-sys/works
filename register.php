<!doctype html>
<html lang="en">
<head>
    <title>Dy Web - Register</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="includes.css">
</head>
<body>
    <div id="container">
        <?php include('header.php'); ?>
        <?php include('nav.php'); ?>
        <?php include('info-col.php'); ?>
        
        <div id="content">
            <h3>Register</h3>
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $errors = array();
                    
                    if (empty($_POST['fname'])) $errors[] = 'Please enter your first name.';
                    else $fn = trim($_POST['fname']);
                    
                    if (empty($_POST['lname'])) $errors[] = 'Please enter your last name.';
                    else $ln = trim($_POST['lname']);
                    
                    if (empty($_POST['email'])) $errors[] = 'Please enter your email address.';
                    else $e = trim($_POST['email']);
                    
                    if (!empty($_POST['psword1'])) {
                        if ($_POST['psword1'] != $_POST['psword2']) {
                            $errors[] = 'Your passwords do not match.';
                        } else {
                            $p = trim($_POST['psword1']);
                            $hashedPassword = hash('sha256', $p);
                        }
                    } else {
                        $errors[] = 'Please enter your password.';
                    }
                    
                    if (empty($errors)) {
                        require('mysqli_connect.php');
                        $q = "INSERT INTO users (fname, lname, email, psword, registration_date, user_level)VALUES ('$fn', '$ln', '$e', '$hashedPassword' ,NOW(), 0)";
						$result = @mysqli_query($dbcon, $q);
						if($result){
							header("location: register-sucess.php");
							exit();
						}else{
							
							echo '<h2>System Error</h2>
							<p class = "error"> Your registration failed due to an unexpected error.</p>';
							
							echo '<p.'.mysqli_error($dbcon).'<p/>';
						}
						mysqli_close ($dbcon);
						include('footer.php');
						exit();
					}else{
						echo '<h3>An Error has occured</h3>
						<p class = "errors">The following error(s) has occured:<br/>';
						foreach($errors as $msg){
							echo " - $msg</br>\n";
						}
						echo '</p><h3>Please try Again.</h3><br/><br/>';
					}
				}
							
   
                      
            ?>
            
            <form action="register.php" method="post">
                <p><label for="fname">First Name:</label> <input type="text" name="fname" size="30" maxlength="40" value="<?php if (isset($_POST['fname'])) echo $_POST['fname']; ?>"></p>
                <p><label for="lname">Last Name:</label> <input type="text" name="lname" size="30" maxlength="40" value="<?php if (isset($_POST['lname'])) echo $_POST['lname']; ?>"></p>
                <p><label for="email">Email Address:</label> <input type="text" name="email" size="30" maxlength="50" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"></p>
                <p><label for="psword1">Password:</label> <input type="password" name="psword1" size="20" maxlength="20"></p>
                <p><label for="psword2">Confirm Password:</label> <input type="password" name="psword2" size="20" maxlength="20"></p>
                <p><input type="submit" name="submit" value="Register"></p>
            </form>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
