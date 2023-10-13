<!DOCTYPE HTML>
<html lang="en">
    <head>
    <meta http-equiv="Content-Type" content="Registration for PlaylistPulse"/>
    <title>Registration Page</title>
    <script>
        function validateForm() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            console.log(username)
            if (username == null || username.length ==0){
                alert("Username cannot be blank");
                // Prevent form submission
                return false; 
            }
            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                // Prevent form submission
                return false; 
            }
            if (password.length < 10) {
                alert("Password must be at least 10 characters long!");
                // Prevent form submission
                return false; 
            }
            // Allow form submission
            return true; 
        }
        function clearForm() {
            document.getElementById("username").value = "";
            document.getElementById("password").value = "";
            document.getElementById("confirmPassword").value = "";
            // You can add more input fields to clear here
        }
    </script>
    </head>

<!-- 
  HTML form displayed to the user
 -->
    <h1>Music DB Sign Up</h1>
    <body>
        <form method="POST" onsubmit="return validateForm()">  
            Username: <input type="text" name="name" id="username">
            <br>
            Password: <input type="password" name="pwd" id="password">
            <br>
            Confirm Password: <input type="password" name="confirmPwd" id="confirmPassword">
            <br>
            <button type="submit" name="submit">Submit</button>
            <button type="button" name="clear" onclick="clearForm()">Clear</button>
        </form>
        <p>
        Already have an account? <a href="login.php">Login here</a>
    </body>
</html>

<?php 
    session_start();
    if (isset($_POST['submit'])) {
        register(); // Call the register function when the form is submitted
    }
    function register() {
        include_once 'includes/dbh.php';
    
        $username = mysqli_real_escape_string($conn, $_POST['name']);
        $password = mysqli_real_escape_string($conn, $_POST['pwd']);
    
        $sql_check = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result_check = mysqli_stmt_get_result($stmt);
    
        if (mysqli_num_rows($result_check) > 0) {
            // Username already exists, so alert the user and do not insert into the database
            echo "Username already exists. Please choose another username.";
        } else {
            // Username is unique, hash the password and insert it into the database
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (username, pwd) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'ss', $username, $hashed_password);
            mysqli_stmt_execute($stmt);
            //redirect to login
            header('Location: login.php'); 
        }
    }
?>