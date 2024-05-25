<?php
include('../Dashboard/connect_db.php'); // database connection

// session_start(); // Start the session
// $userHandle = mysqli_real_escape_string($conn, $_SESSION['userHandle']); // after linked all page. it will be uncommented
// $userHandle = mysqli_real_escape_string($conn, 'munna'); // after linked all page. it will be deleted

$userHandle = null;

function fetchRandomGoodThing()
{
    global $conn;
    $sql = "SELECT *
            FROM ( SELECT FLOOR(RAND() * 
                                ((SELECT COUNT(*)
                                  FROM good_and_bad_things
                                  WHERE userHandle = 'munna' AND type = 1 ))) AS idx) AS random_idx
            LEFT JOIN
            (   SELECT ROW_NUMBER() OVER () -1 AS index_number, gbt.*
                FROM good_and_bad_things AS gbt
                WHERE userHandle = 'munna' AND type = 1) as ntb
            ON random_idx.idx = ntb.index_number;";

    $result = mysqli_query($conn, $sql);
    $oneGdThing = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $oneGdThing;
}

$oneGdThing = fetchRandomGoodThing();

// print_r($oneGdThing);
// echo "\n";

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kairos</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    </link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <style>
        #goalButton .btn {
            width: 50px;
            height: 50px;
            padding: 0;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        #goalButton .btn i {
            font-size: 1.5rem;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>


    <!-- tashin -->

    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Jar of Happiness 1</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo htmlspecialchars($oneGdThing['details']); ?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="amazeMeMore">Amaze Me More</button>
                </div>
            </div>
        </div>
    </div>

    <div id="goalButton" class="position-fixed bottom-0 end-0 mb-4 me-4 bg-transparent z-3">
        <button class="btn btn-secondary shadow" type="button" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
            <i class="far fa-frown bg-transparent"></i>
            <i class="fas fa-grin-alt bg-transparent" style="visibility: hidden;"></i>
        </button>
    </div>

    <script>
        document.getElementById('amazeMeMore').addEventListener('click', function() {

            fetch('../Includes/fetch_random_good_thing.php')
                .then(response => response.text())
                .then(data => {
                    document.querySelector('.modal-body').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
    <!-- tashin -->


    <script>
        // JavaScript to handle icon change on hover
        document.querySelector('#goalButton .btn').addEventListener('mouseover', function() {
            this.querySelector('.far').style.visibility = 'hidden'; // Hide frown icon
            this.querySelector('.fas').style.visibility = 'visible'; // Show grin-alt icon
        });

        document.querySelector('#goalButton .btn').addEventListener('mouseout', function() {
            this.querySelector('.far').style.visibility = 'visible'; // Show frown icon
            this.querySelector('.fas').style.visibility = 'hidden'; // Hide grin-alt icon
        });
    </script>
</body>

</html>