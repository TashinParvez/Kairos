<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kairos";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// $userHandle = $_SESSION['userHandle'];

$userHandle = 'aarifeen';

$cat_id = 2; // for namaz

//---------------------------- ALL Post Data Fetch -------------------------------------
$sql = "SELECT * 
        FROM user_post
        WHERE categoryID = $cat_id 
        ORDER BY created_at DESC;";

$result = mysqli_query($conn, $sql);
$allpost = mysqli_fetch_all($result);


//---------------------------- Joined Btn clicked -------------------------------------

//--------------  update user cnt 
$sql = "SELECT cntUser
        FROM category
        WHERE id = $cat_id";

$result = mysqli_query($conn, $sql);
$cntUser = mysqli_fetch_all($result);
$cntUser += 1;

$sql = "UPDATE category
        SET cntUser = $cntUser
        WHERE id = $cat_id;";

$result = mysqli_query($conn, $sql);

// ------ used info add in joined table
$sql = "INSERT INTO user_joined_category (`userHandle`, `cat_id`) 
        VALUES ('$userHandle', '$cat_id');";

$result = mysqli_query($conn, $sql);


//---------------------------- Graph Code ----------------------------------------
// avg prev him after
$sql = "SELECT * 
        FROM (SELECT j.userHandle, nc.date, AVG(nc.fajar+nc.dhuhr+nc.asr+nc.magrib+nc.isha) as total_namaz
              FROM user_joined_category as j
              INNER JOIN
              namaz_c as nc 
              ON nc.userHandle = j.userHandle
                WHERE j.cat_id = 2
                GROUP BY nc.date
            ) as AVG

        UNION ALL

        SELECT * 
        FROM (SELECT j.userHandle, nc.date, nc.fajar+nc.dhuhr+nc.asr+nc.magrib+nc.isha as total_namaz
              FROM user_joined_category as j 
              INNER JOIN
              namaz_c as nc 
              ON nc.userHandle = j.userHandle
              WHERE joined_date <
                    (    SELECT joined_date
                   		 FROM user_joined_category
                  		 WHERE userHandle = 'tashin19' && cat_id = 2
                    ) && nc.date BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) AND CURRENT_DATE
                    && j.cat_id = 2
                ORDER BY joined_date DESC
                LIMIT 2
            ) as earlier_entries

        UNION ALL

        SELECT * 
        FROM (SELECT j.userHandle, nc.date, (nc.fajar+nc.dhuhr+nc.asr+nc.magrib+nc.isha) as total_namaz
              FROM user_joined_category as j
              INNER JOIN
              namaz_c as nc
              ON nc.userHandle = j.userHandle
              WHERE j.userHandle = 'tashin19' && j.cat_id = 2
            ) as himself
            
        UNION ALL

        SELECT * 
        FROM (SELECT j.userHandle, nc.date, nc.fajar+nc.dhuhr+nc.asr+nc.magrib+nc.isha as total_namaz
              FROM user_joined_category as j 
              INNER JOIN
              namaz_c as nc 
              ON nc.userHandle = j.userHandle
                WHERE joined_date >
                    (   SELECT joined_date
                   		FROM user_joined_category
                  		WHERE userHandle = 'tashin19' && cat_id = 2
                    ) && nc.date BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) AND CURRENT_DATE
                    && j.cat_id = 2
                ORDER BY joined_date DESC
                LIMIT 2
            ) as later_entries;";

$result = mysqli_query($conn, $sql);
$graphsdata = mysqli_fetch_all($result);


//---------------------------- update todays namaz ----------------------------------------

if (isset($_POST['update'])) {
    $fajarPrayer = isset($_POST['fajarPrayer']) ? 1 : 0;
    $dhuhrPrayer = isset($_POST['dhuhrPrayer']) ? 1 : 0;
    $asrPrayer = isset($_POST['asrPrayer']) ? 1 : 0;
    $magribPrayer = isset($_POST['magribPrayer']) ? 1 : 0;
    $ishaPrayer = isset($_POST['ishaPrayer']) ? 1 : 0;

    $sql = "INSERT INTO namaz_c (userHandle, categoryID, fajar, asr, dhuhr, magrib, isha) 
        VALUES ('$userHandle', (SELECT id FROM category WHERE name=(SELECT religion FROM user_info WHERE userHandle='$userHandle')), $fajarPrayer, $asrPrayer, $dhuhrPrayer, $magribPrayer, $ishaPrayer)";
    if ($conn->query($sql) === TRUE) {
    } else {
        echo json_encode(array("status" => "error", "message" => $conn->error));
    }
}


// ------------------------------------- inner Page search -----------------------------
$search_text = '';

if (isset($_POST['search'])) {
    $search_text = $_POST['search_field'];

    $sql = "SELECT DISTINCT userHandle, title, description, created_at, userInteractions
            FROM user_post
            WHERE categoryID = '2' AND
            (userHandle LIKE '%" . $search_text . "%' || title LIKE '%" . $search_text . "%' || description LIKE '%" . $search_text . "%');";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $posts = mysqli_fetch_all($result);
    } else {
        $posts = 'Empty result!';
    }
}

// ------------------------------------- New Post add btn click -----------------------------
$title = '';
$description = '';

$sql = "INSERT INTO `user_post` (`userHandle`, `created_at`, `title`, `description`, `userInteractions`, `categoryID`) 
        VALUES ('$userHandle', current_timestamp(), '$title', '$description', '0', '$cat_id');";

$result = mysqli_query($conn, $sql);



$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ritual Namaz</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Reddit+Mono:wght@200..900&display=swap');

        html,
        body {
            overflow-y: hidden;
            height: 100%;
        }

        .container-fluid {
            height: 100%;
            overflow-y: auto;
        }

        * {
            margin: 0;
            padding: 0;
            font-family: "Reddit Mono", sans-serif;
        }

        .card {
            width: 100%;
        }

        .navbar-wrapper {
            margin: 0 15px;
        }

        .card-body {
            height: 150px;
            position: relative;
        }

        .container-wrapper {
            margin: 0 15px;
        }

        .mt-auto {
            margin-top: auto;
        }

        @media (min-width: 576px) {
            .card {
                width: calc(100% - 20px);
            }
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            height: 100%;
        }

        .sidebar button {
            width: 100%;
        }
    </style>
</head>

<body class="bg-custom p-2 text-dark">
    <?php
    include '../Includes/NavBarSecond.php';
    include '../Includes/Sidebar.php';
    ?>
    <main>
        <div class="bg-white">
            <div class="row justify-content-left">
                <div>
                    <h1 class="bg-custom2">Namaz</h1>
                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 0%">0%</div>
                    </div>
                    <form action="Namaj.php" method="post">
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Fajar" id="fajarPrayer" name="fajarPrayer">
                                <label class="form-check-label" for="Fajar">
                                    Fajar
                                </label>
                            </div>
                        </div>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Dhuhr" id="dhuhrPrayer" name="dhuhrPrayer">
                                <label class="form-check-label" for="dhuhrPrayer">
                                    Dhuhr
                                </label>
                            </div>
                        </div>
                </div>
                <div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="asr" id="asrPrayer" name="asrPrayer">
                        <label class="form-check-label" for="asrPrayer">
                            Asr
                        </label>
                    </div>
                </div>
            </div>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="magrib" id="magribPrayer" name="magribPrayer">
                    <label class="form-check-label" for="magribPrayer">
                        Magrib
                    </label>
                </div>
            </div>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="isha" id="ishaPrayer" name="ishaPrayer">
                    <label class="form-check-label" for="ishaPrayer">
                        Isha
                    </label>
                </div>
            </div>
            <button class="btn btn-outline-primary mb-2" type="submit" name="update">Update</button>
            </form>
        </div>
    </main>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fajarCheckbox = document.getElementById('fajarPrayer');
            const dhuhrCheckbox = document.getElementById('dhuhrPrayer');
            const asrCheckbox = document.getElementById('asrPrayer');
            const magribCheckbox = document.getElementById('magribPrayer');
            const ishaCheckbox = document.getElementById('ishaPrayer');
            const progressBar = document.querySelector('.progress-bar');
            fajarCheckbox.addEventListener('change', updateProgress);
            dhuhrCheckbox.addEventListener('change', updateProgress);
            asrCheckbox.addEventListener('change', updateProgress);
            magribCheckbox.addEventListener('change', updateProgress);
            ishaCheckbox.addEventListener('change', updateProgress);

            function updateProgress() {
                const progress = (fajarCheckbox.checked ? 20 : 0) + (dhuhrCheckbox.checked ? 20 : 0) + (asrCheckbox.checked ? 20 : 0) + (magribCheckbox.checked ? 20 : 0) + (ishaCheckbox.checked ? 20 : 0);

                progressBar.style.width = progress + '%';
                progressBar.innerText = progress + '%';

                fetch('save_progress.php', {
                        method: 'POST',
                        body: JSON.stringify({
                            progress: progress
                        }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            }
        });
    </script>
</body>