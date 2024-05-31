<?php
include('../Dashboard/connect_db.php'); // database connection

$userHandle = 'tashin19';

function fetchResults($conn, $userHandle, $searchQuery)
{
        //------------ for notes
        $sql = "SELECT DISTINCT title, details, created_at
                FROM notes
                WHERE userHandle ='tashin19' AND
                (title LIKE '%$searchQuery%'  OR details LIKE '%$searchQuery%')";

        $result = mysqli_query($conn, $sql);
        $notes_result = mysqli_fetch_all($result);

        // print_r($notes_result);


        //------------ for journal
        $sql = "SELECT DISTINCT title, details, lastUpdate
                FROM personal_journal
                WHERE userHandle ='tashin19' AND
                (title LIKE '%$searchQuery%'  OR details LIKE '%$searchQuery%');";

        $result = mysqli_query($conn, $sql);
        $journal_result = mysqli_fetch_all($result);


        //------------ for blog
        $sql = "SELECT DISTINCT topicName, description, created_at, userHandle
                FROM blog
                WHERE userHandle LIKE '%$searchQuery%'  OR topicName LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%'";

        $result = mysqli_query($conn, $sql);
        $blog_result = mysqli_fetch_all($result);


        //------------ for life_library
        $sql = "SELECT DISTINCT bookName, authorName, details
                FROM life_library
                WHERE bookName LIKE '%$searchQuery%'  OR authorName LIKE '%$searchQuery%'  OR details LIKE '%$searchQuery%';";

        $result = mysqli_query($conn, $sql);
        $library_result = mysqli_fetch_all($result);
        // ----------------------

        return [
                'notes' => $notes_result,
                'journals' => $journal_result,
                'blogs' => $blog_result,
                'library' => $library_result
        ];
}

if (isset($_GET['country_name'])) {
        $searchQuery = $_GET['country_name'];
        $results = fetchResults($conn, $userHandle, $searchQuery);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kairos</title>
        <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../Includes/style.css">
</head>

<body>

        <?php
        include('../Includes/NavBarSecond.php'); // uncomment
        include('../Includes/Sidebar.php'); // uncomment
        include('../Includes/HappyJar.php'); // uncomment
        ?>
        <main class="main bg-white shadow">
                <h2>Search Results for "<?php echo htmlspecialchars($_GET['country_name']); ?>"</h2>
                <?php
                if (isset($_GET['country_name'])) {

                        // print_r($results['notes']);
                        // // ----------------------------------------------------------------
                        // echo "<h3>Notes</h3>";
                        // foreach ($results['notes'] as $note) {
                        //         echo "<p>Title: " . htmlspecialchars($note[0]) . "<br>Details: " . htmlspecialchars($note[1]) . "<br>Created At: " . htmlspecialchars($note[2]) . "</p>";
                        // }
                        // // ----------------------------------------------------------------

                        echo "<h3>Notes</h3>";
                        foreach ($results['notes'] as $note) {
                                echo "<p>Title: " . htmlspecialchars($note[0]) . "<br>Details: " . htmlspecialchars($note[1]) . "<br>Created At: " . htmlspecialchars($note[2]) . "</p>";
                        }

                        echo "<h3>Journals</h3>";
                        foreach ($results['journals'] as $journal) {
                                echo "<p>Title: " . htmlspecialchars($journal[0]) . "<br>Details: " . htmlspecialchars($journal[1]) . "<br>Last Update: " . htmlspecialchars($journal[2]) . "</p>";
                        }
                        echo "<h3>Blogs</h3>";
                        foreach ($results['blogs'] as $blog) {
                                echo "<p>Topic Name: " . htmlspecialchars($blog[0]) . "<br>Description: " . htmlspecialchars($blog[1]) . "<br>Created At: " . htmlspecialchars($blog[2]) . "<br>User Handle: " . htmlspecialchars($blog[3]) . "</p>";
                        }
                        echo "<h3>Life Library</h3>";
                        foreach ($results['library'] as $library) {
                                echo "<p>Book Name: " . htmlspecialchars($library[0]) . "<br>Author Name: " . htmlspecialchars($library[1]) . "<br>Details: " . htmlspecialchars($library[2]) . "</p>";
                        }
                }
                ?>
        </main>
</body>

</html>