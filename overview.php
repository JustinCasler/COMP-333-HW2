<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="application/x-www-form-urlencoded"/>
    <title>Overview</title>
</head>
<body>
    <?php session_start(); ?>
    <text>You are logged in as user: <?php echo $_SESSION['username']; ?></text>
    <br>
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
        // Retrieve and display all ratings from the database
        $sql = "SELECT ID, username, artist, song, rating FROM ratings";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['ID'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['artist'] . "</td>";
                echo "<td>" . $row['song'] . "</td>";
                echo "<td>" . $row['rating'] . "</td>";
                echo "<td>";
                if ($row['username'] == $_SESSION['username']) {
                    echo "<a href='view.php?id=" . $row['ID'] . "'>View</a> ";
                    // User can see "Update" and "Delete" links for their own ratings
                    echo "<a href='update.php?id=" . $row['ID'] . "'>Update</a> ";
                    echo "<a href='delete.php?id=" . $row['ID'] . "'>Delete</a>";
                } else {
                    // User can only see "View" link for other ratings
                    echo "<a href='view.php?id=" . $row['ID'] . "'>View</a>";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "No ratings found.";
        }
        ?>
    </table>
</body>
</html>

