<!DOCTYPE HTML>
<html lang="en">
    <head>
    <meta http-equiv="Content-Type" content="application/x-www-form-urlencoded"/>
    <title>Overview</title>
    </head>
</html>
<?php
    session_start();
    echo('You are logged in as user: ' . $_SESSION['username']);
    

?>
