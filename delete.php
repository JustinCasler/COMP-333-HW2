<!DOCTYPE html>
<html>
<body>
    <?php
        session_start();
        include_once 'includes/dbh.php';
        $id = $_GET['id'];

        // Check if the user is logged in
        if (!isset($_SESSION['username'])) {
            // Redirect to the login page if not logged in
            header("Location: login.php");
            exit;
        }

        // Check if the rating with the specified ID exists
        $sql_check = "SELECT id, username FROM ratings WHERE id = '$id'";
        $result_check = mysqli_query($conn, $sql_check);

        if (mysqli_num_rows($result_check) === 0) {
            // Rating not found, show an error or redirect to an error page
            echo "Rating not found.";
            exit;
        }

        $ratingData = mysqli_fetch_assoc($result_check);

        if ($ratingData['username'] !== $_SESSION['username']) {
            // The rating does not belong to the current user, so they can't delete it.
            echo "You don't have permission to delete this rating.";
            exit;
        }

        // Handle the deletion when the user confirms
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteRating'])) {
            // Perform the deletion of the rating
            $sql_delete = "DELETE FROM ratings WHERE id = '$id'";
            if ($conn->query($sql_delete) === TRUE) {
                // Redirect to the overview page after successful deletion
                header("Location: overview.php");
                exit();
            } else {
                echo "Error: " . $sql_delete . "<br>" . $conn->error;
            }
        }
    ?>

    <text>You are logged in as user: <?php echo $_SESSION['username']; ?></text>
    <p>
    <a href="login.php">Logout</a>
    <br>
    <h1>Delete Rating</h1>
    <p>Are you sure you want to delete this rating?</p>
    
    <form method="POST">
        <button type="submit" name="deleteRating">Yes</button>
        <a href="overview.php">No</a>
    </form>
</body>
</html>