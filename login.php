<!DOCTYPE HTML>
<html lang="en">
    <head>
    <meta http-equiv="Content-Type" content="application/x-www-form-urlencoded"/>
    <title>Login</title>
    </head>

    <!-- HTML form displayed to the user -->
    <h1>Welcome to Music DB</h1>
    <h2>Login</h2>
    <text> Please fill in your credentials to login </text>
    <p>
    <body>
        <form method="POST">  
            Username: <input type="text" name="name" id="username">
            <br>
            Password: <input type="password" name="password" id="password">
            <br>
            <button type="submit" name="login">Login</button>
        </form>
        <p>
        Don't have an account? <a href="registration.php">Sign up now</a>
    </body>
</html>

<?php 
session_start();
include_once 'includes/dbh.php';

if (isset($_POST['login'])) {
    $username = $_POST['name'];
    $password = $_POST['password'];

    // Prepare the SQL statement with placeholders
    $sql_check = "SELECT * FROM users WHERE username = ?";
    
    // Create a prepared statement
    $stmt = $conn->prepare($sql_check);

    if ($stmt) {
        // Bind the parameter to the prepared statement
        $stmt->bind_param("s", $username);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Get the result
            $result_check = $stmt->get_result();

            if ($result_check->num_rows == 1) {
                $row = $result_check->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    $_SESSION['username'] = $username; // Store the username in a session
                    $_SESSION['loggedin'] = true;
                    header('Location: overview.php'); // Redirect to the dashboard or another authenticated page
                } else {
                    echo "Incorrect password. Please try again.";
                }
            } else {
                echo "Username not found. Please register or try a different username.";
            }
        } else {
            echo "Error executing the query: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }
}
?>