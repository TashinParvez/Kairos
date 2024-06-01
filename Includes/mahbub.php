<?php
include('../Dashboard/connect_db.php'); // database connection

$userHandle = 'tashin19';

function fetchResults($conn, $userHandle, $searchQuery)
{
    //------------ for notes
    $sql = "SELECT DISTINCT title, details, created_at
            FROM notes
            WHERE userHandle ='$userHandle' AND
            (title LIKE '%$searchQuery%'  OR details LIKE '%$searchQuery%')";

    $result = mysqli_query($conn, $sql);
    $notes_result = mysqli_fetch_all($result);

    // print_r($notes_result);

    //------------ for journal
    $sql = "SELECT DISTINCT title, details, lastUpdate
            FROM personal_journal
            WHERE userHandle ='$userHandle' AND
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

        <form id="filterForm" action="mahbub.php" method="POST">
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkboxes = document.querySelectorAll('.filter-checkbox');
                const form = document.getElementById('filterForm');
                const dateRangeContainer = document.getElementById('date-range');
                const searchQuery = '<?php echo htmlspecialchars($searchQuery); ?>'; // Retain search query

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

                    const formData = new FormData(form);
                    const queryString = new URLSearchParams(formData).toString();
                    const url = form.action + '?' + queryString + '&country_name=' + encodeURIComponent(searchQuery);
                    window.location.href = url;
                }

                // Check if 'date' filter was checked and show date range inputs if necessary
                if (<?php echo json_encode(in_array('date', $filters)); ?>) {
                    dateRangeContainer.style.display = 'block';
                }
            });
        </script>

        <div class="result">
            <!-- Notes -->
            <div class="container mt-5 mb-3">
                <h2>Notes</h2>
                <div class="row">

                    <?php
                    foreach ($results['notes'] as $note) {
                        echo '
                        <div class="col-lg-4 mb-3">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <h5 class="card-title">' . $note[0] . '</h5>
                                    <p class="card-text">' . $note[1] . '</p>
                                    <p class="card-text"><small class="text-muted">' . $note[2] . '</small></p>
                                </div>
                            </div>
                        </div>';
                    }
                    ?>

                </div>
            </div>

            <!-- Journal -->
            <div class="container mt-5 mb-3">
                <h2>Journal</h2>
                <div class="row">

                    <?php
                    foreach ($results['journals'] as $journal) {
                        echo '
                        <div class="col-lg-4 mb-3">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <h5 class="card-title">' . $journal[0] . '</h5>
                                    <p class="card-text">' . $journal[1] . '</p>
                                    <p class="card-text"><small class="text-muted">' . $journal[2] . '</small></p>
                                </div>
                            </div>
                        </div>';
                    }
                    ?>

                </div>
            </div>

            <!-- Blog -->
            <div class="container mt-5 mb-3">
                <h2>Blog</h2>
                <div class="row">

                    <?php
                    foreach ($results['blogs'] as $blog) {
                        echo '
                        <div class="col-lg-4 mb-3">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <h5 class="card-title">' . $blog[0] . '</h5>
                                    <p class="card-text">' . $blog[1] . '</p>
                                    <p class="card-text"><small class="text-muted">' . $blog[2] . '</small></p>
                                </div>
                            </div>
                        </div>';
                    }
                    ?>

                </div>
            </div>

            <!-- Library -->
            <div class="container mt-5 mb-3">
                <h2>Library</h2>
                <div class="row">

                    <?php
                    foreach ($results['library'] as $library) {
                        echo '
                        <div class="col-lg-4 mb-3">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <h5 class="card-title">' . $library[0] . '</h5>
                                    <p class="card-text">' . $library[1] . '</p>
                                    <p class="card-text"><small class="text-muted">' . $library[2] . '</small></p>
                                </div>
                            </div>
                        </div>';
                    }
                    ?>

                </div>
            </div>

        </div>

    </main>

</body>

</html>