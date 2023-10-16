<!DOCTYPE html>
<html>
<body>
    <?php
        session_start();
        include_once 'includes/dbh.php';
        $id = $_GET['id'];

        // Retrieve the current rating data based on the provided ID
        $sql = "SELECT ID, username, artist, song, rating FROM ratings WHERE ID = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $row = $result->fetch_assoc();
    ?>
    <text>You are logged in as user: <?php echo $_SESSION['username']; ?></text>
    <p>
    <a href="login.php">Logout</a>
    <br>
    <h1>Update Song Rating</h1>
    <form method="POST" id="updateForm">
        Username: <?php echo $_SESSION['username']; ?>
        <br>
        Artist: <input type="text" name="artist" value="<?php echo $row['artist']; ?>" id="artist" required>
        <br>
        Song: <input type="text" name="song" value="<?php echo $row['song']; ?>" id="song" required>
        <br>
        Rating: <input type="number" name="rating" value="<?php echo $row['rating']; ?>" id="rating" min="1" max="5" required>
        <br>
        <button type="submit" name="update">Update</button>
        <a href="overview.php">Cancel</a>
    </form>
    
    <?php
    // Handle the update submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $newArtist = $_POST["artist"];
        $newSong = $_POST["song"];
        $newRating = $_POST["rating"];

        // Update the rating in the database using a prepared statement
        $updateSql = "UPDATE ratings SET artist = ?, song = ?, rating = ? WHERE ID = ?";
        $stmtUpdate = $conn->prepare($updateSql);
        $stmtUpdate->bind_param("ssii", $newArtist, $newSong, $newRating, $id);

        if ($stmtUpdate->execute()) {
            header("Location: overview.php");
            exit();
        } else {
            echo "Error updating rating: " . $conn->error;
        }
    }
    ?>
</body>
</html>
