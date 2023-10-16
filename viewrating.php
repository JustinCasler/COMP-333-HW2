<!DOCTYPE html>
<html>
<body>
    <?php
        session_start();
        include_once 'includes/dbh.php';
        $id = $_GET['id'];

        // Retrieve the current rating data based on the provided ID
        $sql = "SELECT ID, username, artist, song, rating FROM ratings WHERE ID = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    ?>
    <text>You are logged in as user: <?php echo $_SESSION['username']; ?></text>
    <p>
    <a href="login.php">Logout</a>
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
    <a href="overview.php">Back</a>
</body>
</html>