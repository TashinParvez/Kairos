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
// print_r($cntUser);

$cntUser = $cntUser[0][0];
$cntUser = $cntUser + 1;

$sql = "UPDATE category
        SET cntUser = $cntUser
        WHERE id = $cat_id;";

$result = mysqli_query($conn, $sql);

// ------ used info add in joined table
$sql = "INSERT INTO user_joined_category (`userHandle`, `cat_id`) 
        VALUES ('$userHandle', '$cat_id');";

$result = mysqli_query($conn, $sql);


//---------------------------- update todays namaz ----------------------------------------

if (isset($_POST['update'])) {
    $fajarPrayer = isset($_POST['fajarPrayer']) ? 1 : 0;
    $dhuhrPrayer = isset($_POST['dhuhrPrayer']) ? 1 : 0;
    $asrPrayer = isset($_POST['asrPrayer']) ? 1 : 0;
    $magribPrayer = isset($_POST['magribPrayer']) ? 1 : 0;
    $ishaPrayer = isset($_POST['ishaPrayer']) ? 1 : 0;

    $sql = "INSERT INTO namaz_c (userHandle, categoryID, fajar, asr, dhuhr, magrib, isha) 
            VALUES ('$userHandle', (SELECT id FROM category 
            WHERE name=(SELECT religion FROM user_info WHERE userHandle='$userHandle')), $fajarPrayer, $asrPrayer, $dhuhrPrayer, $magribPrayer, $ishaPrayer)";
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
    <title>Namaz</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puja</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    </link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="../Includes/style.css">
    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Gold Reserves"
                },
                axisY: {
                    title: "Gold Reserves (in tonnes)"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.## tonnes",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
</head>

<body>
    <?php
    include '../Includes/NavBarSecond.php';
    include '../Includes/Sidebar.php';
    ?>
    <style>
        :root {
            --rad: .7rem;
            --dur: .3s;
            --color-dark: #2f2f2f;
            --color-light: #fff;
            --color-brand: #57bd84;
            --font-fam: 'Lato', sans-serif;
            --height: 5rem;
            --btn-width: 6rem;
            --bez: cubic-bezier(0, 0, 0.43, 1.49);
        }

        #srchForm {
            position: relative;
            max-width: 30rem;
            background: var(--color-brand);
            border-radius: var(--rad);
        }

        #srchBar,
        #btnSrch {
            height: var(--height);
            font-family: var(--font-fam);
            border: 0;
            color: var(--color-dark);
            font-size: 1.8rem;
        }

        #srchBar[type="search"] {
            outline: 0;
            width: 100%;
            background: var(--color-light);
            padding: 0 1.6rem;
            border-radius: var(--rad);
            appearance: none;
            transition: all var(--dur) var(--bez);
            transition-property: width, border-radius;
            z-index: 1;
            position: relative;
        }

        #btnSrch {
            display: none;
            position: absolute;
            top: 0;
            right: 0;
            width: var(--btn-width);
            font-weight: bold;
            background: var(--color-brand);
            border-radius: 0 var(--rad) var(--rad) 0;
        }

        #srchBar:not(:placeholder-shown) {
            border-radius: var(--rad) 0 0 var(--rad);
            width: calc(100% - var(--btn-width));

            +button {
                display: block;
            }
        }

        label {
            position: absolute;
            clip: rect(1px, 1px, 1px, 1px);
            padding: 0;
            border: 0;
            height: 1px;
            width: 1px;
            overflow: hidden;
        }

        #srchBar[type="search"] {
            width: 100%;
            /* Ensure it takes full width within form */
        }

        #srchBar:not(:placeholder-shown) {
            width: calc(100% - var(--btn-width));
            /* Adjusted width calculation */
            border-radius: var(--rad) 0 0 var(--rad);

            +button {
                display: block;
            }

        }

        #srchForm {
            position: relative;
            max-width: 30rem;
            background: var(--color-brand);
            border-radius: var(--rad);
        }

        #srchBar,
        #btnSrch {
            height: 47px;
            /* Adjust the height to 48px */
            font-family: var(--font-fam);
            border: 0;
            color: var(--color-dark);
            font-size: 1rem;
        }

        #srchBar[type="search"] {
            width: 100%;
        }

        #srchBar:not(:placeholder-shown) {
            width: calc(100% - var(--btn-width));
            border-radius: var(--rad) 0 0 var(--rad);

            +button {
                display: block;
            }
        }

        .form-check-label {
            background-color: black;
            /* Change this to your desired color */
            color: #000;
            /* Change this to your desired text color */
            padding: 0.5rem;
            /* Optional: add some padding for better visibility */
            border-radius: 0.25rem;
            /* Optional: add some border-radius for better styling */
        }
    </style>
    <!-- ------------------------ Main Segment ------------------------------- -->

    <main class="main shadow bg-white">

        <!--You Start Writing Content Here-->
        <div class="container bg-white p-1">
            <div class="row bg-white">
                <div class="col-auto bg-white">
                    <img src="namaj.svg" class="rounded" alt="" srcset="">
                </div>
                <div class="col-auto bg-transparent" style="align-items:center;">
                    <h1 class="bg-white">Namaz</h1>
                    <br>
                    <blockquote class="blockquote mb-0">
                        <p class="bg-white">Namaz is the key to paradise.</p>
                        <footer class="blockquote-footer bg-white">Prophet Muhammad (peace be upon him)
                        </footer>
                    </blockquote>
                    <br>
                </div>
            </div>

            <?php
            include 'Namaj_if_assigned.php';
            ?>
        </div>
        <div class="container m-0 bg-transparent p-0 mt-2" style="outline:none;">
            <div class="row bg-white m-0 mb-2" style="display: flex; align-items: flex-end;">
                <!-- Write Your Note Field (70% width) -->
                <div class="col-lg-9 bg-white m-0 p-0" style="position: sticky; z-index: 1000;">
                    <button id="openModalInput" style="outline:none;" class="form-control form-control-lg mt-3 pt-3 pb-3 d-flex align-items-center shadow" type="button" placeholder="Write Your Note" aria-label=".form-control-lg example">
                        <svg class="bg-white me-2" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 22C1 21.4477 1.44772 21 2 21H22C22.5523 21 23 21.4477 23 22C23 22.5523 22.5523 23 22 23H2C1.44772 23 1 22.5523 1 22Z" fill="#0F0F0F" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.3056 1.87868C17.1341 0.707107 15.2346 0.707107 14.063 1.87868L3.38904 12.5526C2.9856 12.9561 2.70557 13.4662 2.5818 14.0232L2.04903 16.4206C1.73147 17.8496 3.00627 19.1244 4.43526 18.8069L6.83272 18.2741C7.38969 18.1503 7.89981 17.8703 8.30325 17.4669L18.9772 6.79289C20.1488 5.62132 20.1488 3.72183 18.9772 2.55025L18.3056 1.87868ZM15.4772 3.29289C15.8677 2.90237 16.5009 2.90237 16.8914 3.29289L17.563 3.96447C17.9535 4.35499 17.9535 4.98816 17.563 5.37868L15.6414 7.30026L13.5556 5.21448L15.4772 3.29289ZM12.1414 6.62869L4.80325 13.9669C4.66877 14.1013 4.57543 14.2714 4.53417 14.457L4.0014 16.8545L6.39886 16.3217C6.58452 16.2805 6.75456 16.1871 6.88904 16.0526L14.2272 8.71448L12.1414 6.62869Z" fill="#0F0F0F" />
                        </svg>
                        <span class="bg-transparent" style="color:gray; font-size: 1rem;">Post in the community</span>
                    </button>
                </div>
                <div class="col-lg-3 bg-transparent m-0 bg-transparent" style="position: sticky; z-index: 1000;">
                    <form id="srchForm" class="border shadow" onsubmit="event.preventDefault();" role="search">
                        <label for="search" style=" color:white;">Search for stuff</label>
                        <input id="srchBar" type="search" placeholder="Search..." autofocus required />
                        <button id="btnSrch" type="submit">Go</button>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <!-- ------------------------------------ -->

        <?php foreach ($allpost as $ptr) { ?>

            <div class="card m-2 mr-4 p-2 bg-transparent shadow" style="height: auto;">
                <h5 class="card-header bg-transparent"><?php echo htmlspecialchars($ptr[1]); ?></h5>
                <div class="card-body bg-transparent">
                    <h5 class="card-title bg-transparent"><?php echo htmlspecialchars($ptr[2]); ?></h5>
                    <p class="card-text bg-transparent"><?php echo htmlspecialchars($ptr[3]); ?>
                    </p>
                </div>
            </div>
            <br>
        <?php } ?>

        <!-- ------------------------------------ -->
        <script>
            // Data generation and configuration
            const data = {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Dataset',
                    data: <?php echo json_encode($data); ?>,
                    borderColor: 'red',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: false
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    plugins: {
                        filler: {
                            propagate: false,
                        },
                        title: {
                            display: true,
                            text: (ctx) => 'Fill: ' + ctx.chart.data.datasets[0].fill
                        }
                    },
                    interaction: {
                        intersect: false,
                    }
                },
            };

            // Chart initialization
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, config);
        </script>
    </main>


    <!-------------------------- To Add Any Script, Add Here -------------------------->
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        const clearInput = () => {
            const input = document.getElementsByTagName("input")[0];
            input.value = "";
        }
        const clearBtn = document.getElementById("clear-btn");
        clearBtn.addEventListener("click", clearInput);
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const morningCheckbox = document.getElementById('morningPrayer');
            const eveningCheckbox = document.getElementById('eveningPrayer');
            const progressBar = document.querySelector('.progress-bar');
            morningCheckbox.addEventListener('change', updateProgress);
            eveningCheckbox.addEventListener('change', updateProgress);

            function updateProgress() {
                const progress = (morningCheckbox.checked ? 50 : 0) + (eveningCheckbox.checked ? 50 : 0);

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
    <div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNoteModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editNoteForm" action="DashboardMain.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="noteTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="noteTitle" name="noteTitle">
                        </div>
                        <div class="mb-3">
                            <label for="noteDetails" class="form-label">Details</label>
                            <textarea class="form-control" id="noteDetails" name="noteDetails" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control" id="noteCreatedAt" name="noteCreatedAt" style="color: inherit;" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container">
                            <div class="row align-items-start">
                                <div class="col-5">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="public" name="public">
                                        <p class="form-check-label bg-transparent" for="public">Public</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-7">
                            <button type="submit" class="btn btn-danger" name="deleteNote">Delete Note</button>
                            <button type="submit" class="btn btn-primary" name="saveChanges">Save
                                changes</button>
                        </div>
                    </div>
            </div>
        </div>
        </form>
    </div>
    </div>
    </div>

</body>

</html>