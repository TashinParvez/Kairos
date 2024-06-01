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

//............gpt...........
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


                <!--................ Gpt.............. -->

                <form id="filterForm" action="global-search-bar.php" method="POST">
                        <div class="main">
                                <div class="row align-items-start">
                                        <div class="col-1">
                                                <div class="form-check">
                                                        <input class="form-check-input filter-checkbox" type="checkbox" name="notes" id="notes" <?php if (isset($_POST['notes'])) echo 'checked'; ?>>
                                                        <label class="form-check-label" for="flexCheckDefault1">
                                                                Notes
                                                        </label>
                                                </div>
                                        </div>
                                        <div class="col-1">
                                                <div class="form-check">
                                                        <input class="form-check-input filter-checkbox" type="checkbox" name="journal" id="journal">
                                                        <label class="form-check-label" for="flexCheckChecked1">
                                                                Journal
                                                        </label>
                                                </div>
                                        </div>
                                        <div class="col-1">
                                                <div class="form-check">
                                                        <input class="form-check-input filter-checkbox" type="checkbox" name="blog" id="blog">
                                                        <label class="form-check-label" for="flexCheckDefault2">
                                                                Blog
                                                        </label>
                                                </div>
                                        </div>
                                        <div class="col-1">
                                                <div class="form-check">
                                                        <input class="form-check-input filter-checkbox" type="checkbox" name="library" id="library">
                                                        <label class="form-check-label" for="flexCheckChecked2">
                                                                Library
                                                        </label>
                                                </div>
                                        </div>
                                </div>
                                <div class="row align-items-start">
                                        <div class="col-1">
                                                <div class="form-check">
                                                        <input class="form-check-input filter-checkbox" type="checkbox" name="title" id="title">
                                                        <label class="form-check-label" for="flexCheckDefault3">
                                                                Title
                                                        </label>
                                                </div>
                                        </div>
                                        <div class="col-1">
                                                <div class="form-check">
                                                        <input class="form-check-input filter-checkbox" type="checkbox" name="details" id="details">
                                                        <label class="form-check-label" for="flexCheckChecked3">
                                                                Details
                                                        </label>
                                                </div>
                                        </div>
                                        <div class="col-1">
                                                <div class="form-check">
                                                        <input class="form-check-input filter-checkbox" type="checkbox" name="date" id="date">
                                                        <label class="form-check-label" for="flexCheckChecked4">
                                                                Date
                                                        </label>
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

                <!-- <script>
                        document.addEventListener('DOMContentLoaded', function() {
                                const checkboxes = document.querySelectorAll('.filter-checkbox');
                                const form = document.getElementById('filterForm');
                                const dateRangeContainer = document.getElementById('date-range');

                                checkboxes.forEach(checkbox => {
                                        checkbox.addEventListener('change', handleCheckboxChange);
                                });

                                function handleCheckboxChange() {
                                        if (this.value === 'date') {
                                                if (this.checked) {
                                                        dateRangeContainer.style.display = 'block';
                                                } else {
                                                        dateRangeContainer.style.display = 'none';
                                                }
                                        }
                                        form.submit();
                                }
                        });
                </script> -->

                <!-- Bootstrap JavaScript Bundle with Popper -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-GFO+dQNH+5KeRfREh14HpyRHg6hZ3kRuEn++CfIMkYXfZrf/3jrjGFAq1qjbiMQT" crossorigin="anonymous"></script>
                <!-- ............................ -->

                <!-- <div class="main">
                        <div class="row align-items-start">
                                <div class="col-1">
                                        <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                        Notes
                                                </label>
                                        </div>
                                </div>
                                <div class="col-1">
                                        <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                        Jpurnal
                                                </label>
                                        </div>
                                </div>
                                <div class="col-1">
                                        <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                        Blog
                                                </label>
                                        </div>
                                </div>
                                <div class="col-1">
                                        <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                        Library
                                                </label>
                                        </div>
                                </div>
                        </div>
                        <div class="row align-items-start">
                                <div class="col-1">
                                        <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                        Title
                                                </label>
                                        </div>
                                </div>
                                <div class="col-1">
                                        <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                        Details
                                                </label>
                                        </div>
                                </div>
                                <div class="col-1">
                                        <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                        Date
                                                </label>
                                        </div>
                                </div>

                        </div>

                        <div id="results" class="mt-3">
                        <!-- Example of search results -->
                <div class="result-item" data-category="notes" data-date="2023-05-01"></div>
                <div class="result-item" data-category="journal" data-date="2023-05-02"></div>
                <div class="result-item" data-category="blog" data-date="2023-05-03"></div>
                <div class="result-item" data-category="library" data-date="2023-05-04"></div>
                <div class="result-item" data-category="title" data-date="2023-05-05"></div>
                <div class="result-item" data-category="details" data-date="2023-05-06"></div>
                <div class="result-item" data-category="date" data-date="2023-05-07"></div>
                </div>

                </div> -->
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