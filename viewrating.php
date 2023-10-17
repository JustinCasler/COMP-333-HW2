<!DOCTYPE html>
<html>
<body>
    <?php
        session_start();
        include_once 'includes/dbh.php';
        //End session and redirect to login.php when user click on the logout link
        if (isset($_GET['logout'])) {
            // User clicked the logout link
            session_destroy(); // Destroy the session data
            $conn->close(); // Close the database connection
            header("Location: login.php"); // Redirect to the login page
            exit(); // Stop executing the rest of the page
        }

        $id = $_GET['id'];

        // Retrieve the current rating data based on the provided ID
        $sql = "SELECT ID, username, artist, song, rating FROM ratings WHERE ID = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            // Handle the case where no matching record is found
            echo "Rating not found.";
        } else {
            $row = $result->fetch_assoc();
        }
    ?>
    <text>You are logged in as user: <?php echo $_SESSION['username']; ?></text>
    <p>
    <a href="?logout=1">Logout</a>
    <p>
    <h1>View Song Rating</h1>
    <p>
    <text>Username: </text>
    <p>
    <strong><?php echo $row['username']; ?></strong>
    <p>
    <text>Artist: </text>
    <p>
    <strong><?php echo $row['artist']; ?></strong>
    <p>
    <text>Song: </text>
    <p>
    <strong><?php echo $row['song']; ?></strong>
    <p>
    <text>Rating: </text>
    <p>
    <strong><?php echo $row['rating']; ?></strong>
    <p>
    <a href="index.php">Back</a>
</body>
</html>
