<?php

include('../Dashboard/connect_db.php'); // database connection

$labels  =  null;
$userHandle = null;
$errors = array('title&details' => '');

// check get request userHandle 
if (isset($_GET['userHandle'])) {

    $userHandle = mysqli_real_escape_string($conn, $_GET['userHandle']);

    //----------------- For label of users ---------------

    // sql query

    $sql = "SELECT l.labelName
        FROM user_info AS uinfo
        INNER JOIN
        label as l
        ON uinfo.userHandle = l.userHandle
        WHERE uinfo.userHandle = '$userHandle'; ";

    $resultantLabel =  mysqli_query($conn, $sql);  // get query result

    $labels = mysqli_fetch_all($resultantLabel); // conver to array

    // print_r($labels);



    // for memory free
    mysqli_free_result($resultantLabel);
    mysqli_close($conn);
} else {  // full else remove after adding login 

    $userHandle = mysqli_real_escape_string($conn, 'tashin19');
    $sql = "SELECT p.title, p.details,
                CASE
                    WHEN TIMESTAMPDIFF(HOUR, p.lastUpdate, NOW()) >= 1  THEN CONCAT(TIMESTAMPDIFF(HOUR, created_at, NOW()), ' hour(s) ago')
                    ELSE CONCAT(TIMESTAMPDIFF(MINUTE, p.lastUpdate, NOW()), ' minute(s) ago')
                END AS time_ago 
            FROM personal_journal as p 
            WHERE saved = 1 AND DATE(created_at) = DATE(now()) AND
            userHandle = '$userHandle'
            ORDER BY created_at DESC;";

    $resultantLabel =  mysqli_query($conn, $sql);  // get query result

    $todaysSlices = mysqli_fetch_all($resultantLabel); // conver to array

    // print_r($todaysSlices);


    // foreach ($todaysSlices as $slice) {
    //     print_r($slice);
    //     echo '<br>';
    // }


    // for memory free
    mysqli_free_result($resultantLabel);
}

//--------------- add new Slice --------------------

if (isset($_POST['save']) || isset($_POST['newSlice'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);

    if (empty($title) && empty($details)) {
        $errors['title&details'] = 'At least Have to fill one'; // can't save
    }

    if (!array_filter($errors)) {

        $sql = "INSERT INTO personal_journal(userHandle, title, details, saved)
                VALUES('tashin19','$title', '$details', 1)";

        // save to db and check
        if (mysqli_query($conn, $sql)) {
            header('Location: #');
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
    }
}

$today = date("F j, Y", strtotime("today"));  // today's date
// echo "Today's date is: " . $today;

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- CSS -->
    <!-- <link rel="stylesheet" href="../Includes/style.css"> -->
    <!-- uncomment -->

</head>

<body>
    <?php
    // include('../Includes/NavBar.php'); // uncomment
    // include('../Includes/Sidebar.php'); // uncomment
    ?>

    <!-- ------------------------ Main Segment ------------------------------- -->

    <main class="main bg-white shadow">

        <div class="bg-white">

            <div class="container bg-white">
                <div class="row bg-white">
                    <h4 class="bg-white text-center">Daily Reflection</h4>
                </div>
                <hr class="m-0">

                <div class="row bg-white">
                    <!-- Left Column: Item Comparison -->
                    <div class="col-md-6 border-end bg-white">
                        <h3 class="text-center bg-white">Positives Recap</h3>
                        <div class="row align-items-center bg-white">
                            <label for="goodthing1" class="col-sm-2 col-form-label bg-white">1.</label>
                            <div class="col-sm-10 bg-white">
                                <input type="text" class="form-control bg-white" id="goodthing1">
                            </div>
                        </div>
                        <div class="row align-items-center bg-white">
                            <label for="goodthing2" class="col-sm-2 col-form-label bg-white">2.</label>
                            <div class="col-sm-10 bg-white">
                                <input type="text" class="form-control bg-white" id="goodthing2">
                            </div>
                        </div>
                        <hr class="d-md-none bg-white">
                    </div>

                    <!-- Right Column: Item Comparison -->
                    <div class="col-md-6 border-end bg-white">
                        <h3 class="text-center bg-white">Regrettable Moments</h3>
                        <div class="row align-items-center bg-white">
                            <label for="badthing1" class="col-sm-2 col-form-label bg-white">1.</label>
                            <div class="col-sm-10 bg-white">
                                <input type="text" class="form-control bg-white" id="badthing1">
                            </div>
                        </div>
                        <div class="row align-items-center bg-white">
                            <label for="badthing2" class="col-sm-2 col-form-label bg-white">2.</label>
                            <div class="col-sm-10 bg-white">
                                <input type="text" class="form-control bg-white" id="badthing2">
                            </div>
                        </div>
                        <hr class="d-md-none bg-white">
                    </div>
                </div>

            </div>

            <!------------------ New Note Segment ------------------>

            <div class="container pt-3 bg-white">
                <form action="Personal-Journal.php" method="POST">

                    <div class="row justify-content-around bg-white">
                        <div class="col bg-white">
                            <h4 class="bg-white">Today's Slice — <span class="bg-white" style="color: gray;"><?php echo '@' . $today; ?></span></h4>
                        </div>
                        <div class="col bg-white">
                            <button type="button" class="btn btn-outline-secondary"><a class="bg-white" href="#todaysSlices" style="text-decoration: none; color: inherit;">Today's All Slice</a> </button>
                            <button type="button" class="btn btn-outline-secondary" type="submit" name="newSlice">New Slice</button>
                            <button type="button" class="btn btn-outline-secondary" type="submit" name="save">Save</button>
                        </div>
                    </div>
                    <hr class="m-0">

                    <div class="container bg-white">
                        <div class="row bg-white">
                            <div class="form-floating bg-white">
                                <textarea class="form-control bg-white" placeholder="Leave a comment here" id="floatingTextarea" name="title"></textarea>
                                <label for="floatingTextarea">Title</label>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="form-floating bg-white">
                                <textarea class="form-control bg-white" placeholder="Leave a comment here" id="floatingTextarea2" name="details" style="height: 40vh"></textarea>
                                <label for="floatingTextarea2">Details</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


            <!------------------ Todays All Note Segment ------------------>

            <div class="container pt-3 bg-white">
                <div class="row justify-content-around bg-white">
                    <div class="col bg-white">
                        <h4 class="bg-white" id="todaysSlices"><?php echo $today; ?> Slices</h4>
                    </div>
                </div>
                <hr class="m-0">
                <div class="container bg-white">
                    <!-- FOReach Loop -->

                    <?php
                    foreach ($todaysSlices as $slice) { ?>

                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                        <?php echo htmlspecialchars($slice[0]); ?>
                                        <span class="align-items-end">
                                            <?php echo htmlspecialchars($slice[2]); ?>
                                        </span>
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <?php echo htmlspecialchars($slice[1]); ?>
                                        <button type="button" class="btn btn-outline-secondary">Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    <!--  -->
                </div>


            </div>

            <!-- END -->
        </div>
    </main>

</body>

</html>