<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="application/x-www-form-urlencoded"/>
    <title>Overview</title>
</head>
<body>
    <?php 
        session_start(); 
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit(); // Stop executing the rest of the page
        }
    ?>
    <text>You are logged in as user: <?php echo $_SESSION['username']; ?></text>
    <p>
    <a href="login.php">Logout</a>
    <br>
    <h1>Song Ratings</h1>
    <a href="newrating.php">Add New Song Rating</a>
    <br>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Artist</th>
            <th>Song</th>
            <th>Rating</th>
            <th>Action</th>
        </tr>
        <?php
        include_once 'includes/dbh.php';

        // Prepare the SQL statement with placeholders
        $sql = "SELECT ID, username, artist, song, rating FROM ratings";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Execute the prepared statement
            if ($stmt->execute()) {
                // Bind the result variables
                $stmt->bind_result($id, $username, $artist, $song, $rating);

                while ($stmt->fetch()) {
                    echo "<tr>";
                    echo "<td>" . $id . "</td>";
                    echo "<td>" . $username . "</td>";
                    echo "<td>" . $artist . "</td>";
                    echo "<td>" . $song . "</td>";
                    echo "<td>" . $rating . "</td>";
                    echo "<td>";
                    if ($username == $_SESSION['username']) {
                        echo "<a href='viewrating.php?id=" . $id . "'>View</a> ";
                        // User can see "Update" and "Delete" links for their own ratings
                        echo "<a href='update.php?id=" . $id . "'>Update</a> ";
                        echo "<a href='delete.php?id=" . $id . "'>Delete</a>";
                    } else {
                        // User can only see "View" link for other ratings
                        echo "<a href='viewrating.php?id=" . $id . "'>View</a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "Error executing the query: " . $stmt->error;
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            echo "Error preparing the statement: " . $conn->error;
        }
        ?>
    </table>
</body>
</html>