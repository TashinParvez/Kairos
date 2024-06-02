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
// if (isset($_POST['date'])) {
//     echo 'Notes is checked<br>';
// }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['date'])) {
        $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : '';
        $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : '';

        echo 'Date is checked<br>';
        echo 'From Date: ' . htmlspecialchars($fromDate) . '<br>';
        echo 'To Date: ' . htmlspecialchars($toDate) . '<br>';
    }
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


    <style>
        button {
            border: none;
            /* Remove border from the button */
            background: none;
            /* Remove background from the button */
            padding: 0;
            /* Remove padding from the button */
            cursor: pointer;
            /* Change cursor to pointer */
        }

        .form-check {
            display: inline-flex;
            /* Display the checkbox and label inline */
            align-items: center;
            /* Align items vertically */
        }

        .form-check-input {
            margin-right: 0.5em;
            /* Adjust margin between checkbox and label */
        }
    </style>
    <script>
        function toggleDateRange() {
            const dateCheckbox = document.getElementById('date');
            const dateRange = document.getElementById('date-range');
            dateRange.style.display = dateCheckbox.checked ? 'block' : 'none';
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            // Initialize the date range visibility based on checkbox state
            toggleDateRange();

            // Add event listener to the date checkbox
            document.getElementById('date').addEventListener('change', toggleDateRange);
        });
    </script>
</head>

<body>

    <?php
    include('../Includes/NavBarSecond.php'); // uncomment
    include('../Includes/Sidebar.php'); // uncomment
    include('../Includes/HappyJar.php'); // uncomment
    ?>
    <main class="main bg-white shadow m-0 p-0">


        <!--................ .............. -->
        <form id="filterForm" action="nomanTry.php?country_name=<?php echo $searchQuery ?>" method="POST">
            <div class="main">
                <div class="row align-items-start">
                    <div class="col-1">
                        <div class="form-check">
                            <button type="submit" style="border: none;">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="notes" id="notes" <?php if (isset($_POST['notes'])) echo 'checked'; ?>>
                                <label class="form-check-label" for="notes">
                                    Notes
                                </label>
                            </button>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-check">
                            <button type="submit" style="border: none;">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="journal" id="journal" <?php if (isset($_POST['journal'])) echo 'checked'; ?>>
                                <label class="form-check-label" for="journal">
                                    Journal
                                </label>
                            </button>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-check">
                            <button type="submit" style="border: none;">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="blog" id="blog" <?php if (isset($_POST['blog'])) echo 'checked'; ?>>
                                <label class="form-check-label" for="blog">
                                    Blog
                                </label>
                            </button>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-check">
                            <button type="submit" style="border: none;">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="library" id="library" <?php if (isset($_POST['library'])) echo 'checked'; ?>>
                                <label class="form-check-label" for="library">
                                    Library
                                </label>
                            </button>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-check">
                            <button type="button" onclick="document.getElementById('date').click();" style="border: none;">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="date" id="date" <?php if (isset($_POST['date'])) echo 'checked'; ?>>
                                <label class="form-check-label" for="date">
                                    Date
                                </label>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row align-items-start">
                    <div class="col-4">

                    </div>
                    <div class="col-3" id="date-range" style="display:none;">
                        <label for="fromDate">From:</label>
                        <input type="date" id="fromDate" name="fromDate" class="form-control" value="<?php echo isset($_POST['fromDate']) ? $_POST['fromDate'] : ''; ?>">
                        <label for="toDate">To:</label>
                        <input type="date" id="toDate" name="toDate" class="form-control" value="<?php echo isset($_POST['toDate']) ? $_POST['toDate'] : ''; ?>">
                    </div>
                    <button type="submit">Submit</button>
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
                if (!empty($results['notes'])) {
                    echo "<h3>Notes</h3>";
                    foreach ($results['notes'] as $note) {
                        echo "<p>Title: " . htmlspecialchars($note[0]) . "<br>Details: " . htmlspecialchars($note[1]) . "<br>Created At: " . htmlspecialchars($note[2]) . "</p>";
                    }
                }

                if (!empty($results['journals'])) {
                    echo "<h3>Journals</h3>";
                    foreach ($results['journals'] as $journal) {
                        echo "<p>Title: " . htmlspecialchars($journal[0]) . "<br>Details: " . htmlspecialchars($journal[1]) . "<br>Last Update: " . htmlspecialchars($journal[2]) . "</p>";
                    }
                }

                if (!empty($results['blogs'])) {
                    echo "<h3>Blogs</h3>";
                    foreach ($results['blogs'] as $blog) {
                        echo "<p>Topic Name: " . htmlspecialchars($blog[0]) . "<br>Description: " . htmlspecialchars($blog[1]) . "<br>Created At: " . htmlspecialchars($blog[2]) . "<br>User Handle: " . htmlspecialchars($blog[3]) . "</p>";
                    }
                }

                if (!empty($results['library'])) {
                    echo "<h3>Life Library</h3>";
                    foreach ($results['library'] as $library) {
                        echo "<p>Book Name: " . htmlspecialchars($library[0]) . "<br>Author Name: " . htmlspecialchars($library[1]) . "<br>Details: " . htmlspecialchars($library[2]) . "</p>";
                    }
                }
            }
            ?>
        </div>

    </main>
</body>

</html>