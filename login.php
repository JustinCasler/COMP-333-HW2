<!DOCTYPE HTML>
<html lang="en">
    <head>
    <meta http-equiv="Content-Type" content="application/x-www-form-urlencoded"/>
    <title>Login</title>
    </head>

<!-- 
  HTML form displayed to the user
 -->
    <h1>Welcome to Music DB</h1>
    <h2>Login</h2>
    <text> Please fill in your credentials to login </text>
    <p>
    <body>
        <form method="POST">  
            Username: <input type="text" name="name" id="username">
            <br>
            Password: <input type="password" name="pwd" id="password">
            <br>
            <button type="submit" name="login">Login</button>
        </form>
        <p>
        Dont have an account? <a href="registration.php">Sign up now</a>
    </body>
</html>

<?php 
session_start();
include_once 'includes/dbh.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['name']);
    $password = $_POST['pwd'];

    $sql_check = "SELECT * FROM users WHERE username = '$username';";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) == 1) {
        $row = mysqli_fetch_assoc($result_check);
        if (password_verify($password, $row['pwd'])) {
            $_SESSION['username'] = $username; // Store the username in a session
            $_SESSION['loggedin'] = true;
            header('Location: newrating.php'); // Redirect to the dashboard or another authenticated page
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "Username not found. Please register or try a different username.";
    }
}
?>