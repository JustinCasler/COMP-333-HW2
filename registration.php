<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="application/x-www-form-urlencoded"/>
<title>Sample Submission Form</title>
<script>
    function validateForm() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmPassword").value;
        console.log(username)
        if (username == null || username.length ==0){
            alert("Username cannot be blank");
            return false; // Prevent form submission
        }
        if (password !== confirmPassword) {
            alert("Passwords do not match!");
            return false; // Prevent form submission
        }
        if (password.length < 10) {
            alert("Password must be at least 10 characters long!");
            return false; // Prevent form submission
        }
        return true; // Allow form submission
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
    </body>
</html>

<?php 
    if (isset($_POST['submit'])) {
        register(); // Call the register function when the form is submitted
    }
    function register() 
    {
        include_once 'includes/dbh.php' ;
        $username = mysqli_real_escape_string($conn, $_POST['name']);
        $password = mysqli_real_escape_string($conn, $_POST['pwd']);

        $sql_check = "SELECT * FROM users WHERE username = '$username';";
        $result_check = mysqli_query($conn, $sql_check);
        if (mysqli_num_rows($result_check) > 0) {
            // Username already exists, so alert the user and do not insert into the database
            echo "Username already exists. Please choose another username.";
        } else {
            // Username is unique, insert it into the database
            $sql = "INSERT INTO users (username, pwd) VALUES ('$username', '$password');";
            mysqli_query($conn, $sql);
            echo "Registration successful!";
        }
    }
?>