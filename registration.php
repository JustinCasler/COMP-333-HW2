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

    <!-- HTML form displayed to the user -->
    <h1>Music DB Sign Up</h1>
    <body>
    <?php 
        session_start(); 
        if (isset($_SESSION['username'])) {
            header("Location: index.php");
            exit(); // Stop executing the rest of the page
        }
    ?>
        <form method="POST" onsubmit="return validateForm()">  
            Username: <input type="text" name="name" id="username">
            <br>
            Password: <input type="password" name="password" id="password">
            <br>
            Confirm Password: <input type="password" name="confirmPassword" id="confirmPassword">
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
    
        $username = $_POST['name'];
        $password = $_POST['password'];
    
        // Prepare the SQL statement with placeholders
        $sql_check = "SELECT * FROM users WHERE username = ?";
    
        // Create a prepared statement
        $stmt = $conn->prepare($sql_check);
    
        if ($stmt) {
            // Bind the parameter to the prepared statement
            $stmt->bind_param('s', $username);
    
            // Execute the prepared statement
            if ($stmt->execute()) {
                // Get the result
                $result_check = $stmt->get_result();
    
                if ($result_check->num_rows > 0) {
                    // Username already exists, so alert the user and do not insert into the database
                    echo "Username already exists. Please choose another username.";
                } else {
                    // Username is unique, hash the password and insert it into the database
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
    
                    if ($stmt) {
                        // Bind parameters to the placeholders
                        $stmt->bind_param('ss', $username, $hashed_password);
    
                        // Execute the prepared statement
                        if ($stmt->execute()) {
                            // Redirect to login
                            header('Location: login.php');
                        } else {
                            echo "Error inserting into the database: " . $stmt->error;
                        }
                    } else {
                        echo "Error preparing the insert statement: " . $conn->error;
                    }
                }
            } else {
                echo "Error executing the query: " . $stmt->error;
            }
    
            // Close the prepared statement
            $stmt->close();
        } else {
            echo "Error preparing the select statement: " . $conn->error;
        }
    }
?>
