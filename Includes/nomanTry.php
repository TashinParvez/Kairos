<?php
include('../Dashboard/connect_db.php'); // database connection

$userHandle = 'tashin19';

function fetchResults($conn, $userHandle, $searchQuery)
{
    //------------ for notes
    $sqln = "SELECT DISTINCT title, details, created_at
                FROM notes
                WHERE userHandle ='tashin19' AND
                (title LIKE '%$searchQuery%'  OR details LIKE '%$searchQuery%')";



    // print_r($notes_result);


    //------------ for journal
    $sqlj = "SELECT DISTINCT title, details, lastUpdate
                FROM personal_journal
                WHERE userHandle ='tashin19' AND
                (title LIKE '%$searchQuery%'  OR details LIKE '%$searchQuery%')";




    //------------ for blog
    $sqlb = "SELECT DISTINCT topicName, description, created_at, userHandle
                FROM blog
                WHERE userHandle LIKE '%$searchQuery%'  OR topicName LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%'";



    //------------ for life_library
    $sqll = "SELECT DISTINCT bookName, authorName, details
                FROM life_library
                WHERE bookName LIKE '%$searchQuery%'  OR authorName LIKE '%$searchQuery%'  OR details LIKE '%$searchQuery%'";


    if (isset($_POST['notes'])) {
        // echo 'Notes is checked<br>';

    }
    // n
    $result = mysqli_query($conn, $sqln);
    $notes_result = mysqli_fetch_all($result);

    // j
    $result = mysqli_query($conn, $sqlj);
    $journal_result = mysqli_fetch_all($result);

    //bl
    $result = mysqli_query($conn, $sqlb);
    $blog_result = mysqli_fetch_all($result);


    // li
    $result = mysqli_query($conn, $sqll);
    $library_result = mysqli_fetch_all($result);


    //     && !isset($_POST['title']) && 
    // !isset($_POST['details']) && !isset($_POST['date']) 
    // ----------------------
    $else = null;
    if (!isset($_POST['notes']) && !isset($_POST['journal']) && !isset($_POST['blog']) && !isset($_POST['library'])) {
        return [
            'notes' => $notes_result,
            'journals' => $journal_result,
            'blogs' => $blog_result,
            'library' => $library_result
        ];
    }

    return [
        'notes' => isset($_POST['notes']) ? $notes_result : null,
        'journals' => isset($_POST['journal']) ? $journal_result : null,
        'blogs' => isset($_POST['blog']) ? $blog_result : null,
        'library' => isset($_POST['library']) ? $library_result : null
    ];
}

if (isset($_GET['country_name'])) {
    $searchQuery = $_GET['country_name'];
    $results = fetchResults($conn, $userHandle, $searchQuery);
}

//.......................
// Ensure $filters is always an array


if (isset($_POST['notes'])) {
    echo 'Notes is checked<br>';
}
if (isset($_POST['journal'])) {
    echo 'Notes is checked<br>';
}
if (isset($_POST['blog'])) {
    echo 'Notes is checked<br>';
}
if (isset($_POST['library'])) {
    echo 'Notes is checked<br>';
}
if (isset($_POST['title'])) {
    echo 'Notes is checked<br>';
}
if (isset($_POST['details'])) {
    echo 'Notes is checked<br>';
}
if (isset($_POST['date'])) {
    echo 'Notes is checked<br>';
}


//............


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
    <main class="main bg-white shadow m-0 p-0">


        <!--................ .............. -->

        <form id="filterForm" action="nomanTry.php" method="POST">
            <div class="main">
                <div class="row align-items-start">
                    <div class="col-1">
                        <div class="form-check">
                            <button type="submit" style="border: none;">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="notes" id="notes" <?php if (isset($_POST['notes'])) echo 'checked'; ?>>
                                <label class="form-check-label" for="flexCheckDefault1">
                                    Notes
                                </label>
                            </button>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-check">
                            <button type="submit" style="border: none;">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="journal" id="journal">
                                <label class="form-check-label" for="flexCheckChecked1">
                                    Journal
                                </label>
                            </button>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-check">
                            <button type="submit" style="border: none;">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="blog" id="blog">
                                <label class="form-check-label" for="flexCheckDefault2">
                                    Blog
                                </label>
                            </button>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-check">
                            <button type="submit" style="border: none;">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="library" id="library">
                                <label class="form-check-label" for="flexCheckChecked2">
                                    Library
                                </label>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row align-items-start">
                    <div class="col-1">
                        <div class="form-check">
                            <button type="submit" style="border: none;">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="title" id="title">
                                <label class="form-check-label" for="flexCheckDefault3">
                                    Title
                                </label>
                            </button>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-check">
                            <button type="submit" style="border: none;">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="details" id="details">
                                <label class="form-check-label" for="flexCheckChecked3">
                                    Details
                                </label>
                            </button>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-check">
                            <button type="submit" style="border: none;">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="date" id="date">
                                <label class="form-check-label" for="flexCheckChecked4">
                                    Date
                                </label>
                            </button>
                        </div>
                    </div>
                    <div class="col-3" id="date-range" style="display:block;">
                        <label for="fromDate">From:</label>
                        <input type="date" id="fromDate" name="fromDate" class="form-control">
                        <label for="toDate">To:</label>
                        <input type="date" id="toDate" name="toDate" class="form-control">
                    </div>
                </div>
            </div>
        </form>

        
        <div class="main bg-white shadow">
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
        </div>

    </main>
</body>

</html>