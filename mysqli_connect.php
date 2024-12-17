<?php
$dbcon = new mysqli('localhost', 'Dyshane', 'Dyshane', 'members_dy');

if ($dbcon->connect_error) {
    die("Connection failed: " . $dbcon->connect_error);
}
$dbcon->set_charset('utf8');
?>
