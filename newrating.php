<!DOCTYPE html>
<html>
<body>
    <?php session_start(); ?>
    <text>You are logged in as user: <?php echo $_SESSION['username']; ?></text>
    <p>
    <a href="login.php">Logout</a>
    <h1>Add New Rating</h1>
    <form method="POST" onsubmit="return validateForm()">  
        Username: <?php echo $_SESSION['username']; ?>
        <br>
        Artist: <input type="text" name="artist" id="artist" required>
        <br>
        Song: <input type="text" name="song" id="song" required>
        <br>
        Rating: <input type="number" name="rating" id="rating" min="1" max="5" required>
        <br>
        <button type="submit" name="addnewrating">Submit</button>
        <a href="index.php">Cancel</a>
    </form>

    <script>
        function validateForm() {
            var artist = document.getElementById("artist").value;
            var song = document.getElementById("song").value;
            var rating = document.getElementById("rating").value;

            if (artist === "" || song === "" || rating === "") {
                alert("Please fill in all required fields.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>

<?php
// Start a session to maintain user login state
include_once 'includes/dbh.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit;
}

// Create a new rating if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addnewrating'])) {
    $artist = $_POST["artist"];
    $song = $_POST["song"];
    $rating = $_POST["rating"];
    $username = $_SESSION['username'];

    // Check if the rating is an integer from 1 to 5
    if (!is_numeric($rating) || $rating < 1 || $rating > 5) {
        echo "Rating must be an integer between 1 and 5.";
    } else {
        // Check if the user has already rated the same song by the same artist
        $sql_check = "SELECT id FROM ratings WHERE username = ? AND artist = ? AND song = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param('sss', $username, $artist, $song);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            echo "You have already rated this song by the same artist.";
        } else {
            // Insert the new rating into the "ratings" table using a prepared statement
            $sql = "INSERT INTO ratings (username, artist, song, rating) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssi', $username, $artist, $song, $rating);

            if ($stmt->execute()) {
                // Redirect to index.php
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
?>
