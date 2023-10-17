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

        // Check if the user is logged in
        if (!isset($_SESSION['username'])) {
            // Redirect to the login page if not logged in
            header("Location: login.php");
            exit;
        }

        // Check if the rating with the specified ID exists
        $sql_check = "SELECT id, username FROM ratings WHERE id = ?";
        
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows === 0) {
            // Rating not found, show an error or redirect to an error page
            echo "Rating not found.";
            exit;
        }

        $ratingData = $result_check->fetch_assoc();

        if ($ratingData['username'] !== $_SESSION['username']) {
            // The rating does not belong to the current user, so they can't delete it.
            echo "You don't have permission to delete this rating.";
            exit;
        }

        // Handle the deletion when the user confirms
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteRating'])) {
            // Perform the deletion of the rating
            $sql_delete = "DELETE FROM ratings WHERE id = ?";
            
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $id);
            if ($stmt_delete->execute()) {
                // Redirect to the index page after successful deletion
                header("Location: index.php");
                exit();
            } else {
                echo "Error during deletion.";
            }
        }
    ?>

    <text>You are logged in as user: <?php echo $_SESSION['username']; ?></text>
    <p>
    <a href="?logout=1">Logout</a>
    <br>
    <h1>Delete Rating</h1>
    <p>Are you sure you want to delete this rating?</p>
    
    <form method="POST">
        <button type="submit" name="deleteRating">Yes</button>
        <a href="index.php">No</a>
    </form>
</body>
</html>
