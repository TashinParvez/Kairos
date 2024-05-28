<?php

include 'navbar.php';

// connect database
$servername = 'localhost';
$username = 'root';
$password = '';
$databasename = 'Kairos';

$conn = mysqli_connect($servername, $username, $password, $databasename);

// check connection
if (!$conn) {
    die("Sorry failed to connect: " . mysqli_connect_error());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Search Results</title>
</head>

<body>
    <div class="container mt-5">
        <h2>Search Results for "<?php echo htmlspecialchars($_GET['query']); ?>"</h2>
        <?php
        if (isset($_GET['query'])) {
            $searchQuery = $_GET['query'];
            $userHandle = 'tashin19';


            //------------ for notes
            $sql = "SELECT DISTINCT title, details, created_at
                    FROM notes
                    WHERE userHandle ='tashin19' AND
                    (title LIKE '%$searchQuery%'  OR details LIKE '%$searchQuery%')";

            $result = mysqli_query($conn, $sql);
            $notes_output = mysqli_fetch_all($result);


            //------------ for journal
            $sql = "SELECT DISTINCT title, details, lastUpdate
                    FROM personal_journal
                    WHERE userHandle ='tashin19' AND
                    (title LIKE '%$searchQuery%'  OR details LIKE '%$searchQuery%');";

            $result = mysqli_query($conn, $sql);
            $journals_output = mysqli_fetch_all($result);


            //------------ for blog
            $sql = "SELECT DISTINCT topicName, description, created_at, userHandle
                    FROM blog
                    WHERE userHandle LIKE '%$searchQuery%'  OR topicName LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%'";

            $result = mysqli_query($conn, $sql);
            $blogs_output = mysqli_fetch_all($result);

    
            //------------ for life_library
            $sql = "SELECT DISTINCT bookName, authorName, details
                    FROM life_library
                    WHERE bookName LIKE '%$searchQuery%'  OR authorName LIKE '%$searchQuery%'  OR details LIKE '%$searchQuery%';";

            $result = mysqli_query($conn, $sql);
            $life_library_output = mysqli_fetch_all($result);
        }
        ?>
    </div>
</body>

</html>