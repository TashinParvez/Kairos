<?php

include '../Dashboard/connect_db.php'; // database connection

session_start(); // Start the session
// $userHandle = mysqli_real_escape_string($conn, $_SESSION['userHandle']); // after linked all page. it will be uncommented
$userHandle = mysqli_real_escape_string($conn, 'tashin19'); // after linked all page. it will be deleted

$today = date('F j, Y', strtotime('today'));  // today's date
// echo "Today's date is: " . $today;

$goodthing1 = null;
$goodthing2 = $goodthing1;
$badthing1 = $goodthing1;
$badthing2 = $goodthing1;

// --------------- add new Slice --------------------
$errors = ['title&details' => ''];

// --------------- add new Slice by save or newslice button--------------------
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
            header('Location: Personal-Journal.php');
        } else {
            echo 'query error: '.mysqli_error($conn);
        }
    }
    // close connection
    mysqli_close($conn);
}

// --------------- add good and bad things --------------------
$error = '';
$goodthing1 = $goodthing2 = $badthing1 = $badthing2 = '';
if (isset($_POST['add'])) {
    $goodthing1 = mysqli_real_escape_string($conn, $_POST['goodthing1']);
    $goodthing2 = mysqli_real_escape_string($conn, $_POST['goodthing2']);
    $badthing1 = mysqli_real_escape_string($conn, $_POST['badthing1']);
    $badthing2 = mysqli_real_escape_string($conn, $_POST['badthing2']);

    if (empty($goodthing1) && empty($goodthing2) && empty($badthing1) && empty($badthing2)) {
        $error = 'Atleast one good or bad thing must be filled';
    }

    // echo $badthing1;

    if (!array_filter($errors)) {
        // ---------------------------------------    try 1   ------------------------------------
        // $stringArray = array();
        // array_push($stringArray, $goodthing1, $goodthing2, $badthing1, $badthing2);
        // $cnt = 1;

        // foreach ($stringArray as $value) {  // check already in it or not
        //     $sql = "SELECT *
        //             FROM good_and_bad_things
        //             WHERE details ='$value' && userHandle = '$userHandle' && date = CURDATE();";

        //     $result =  mysqli_query($conn, $sql);  // get query result

        //     if (mysqli_num_rows($result) > 0) {  // dont need to push
        //     } else { // Result is empty  -> PUSH
        //         if ($cnt <= 2) {
        //             $sql =  "INSERT INTO `good_and_bad_things` (`title`, `type`, `date`, `details`, `userHandle`)
        //                      VALUES (NULL, b'1', current_timestamp(), '$value', '$userHandle');";
        //         } else { // FOR BAD THING
        //             $sql =  "INSERT INTO `good_and_bad_things` (`title`, `type`, `date`, `details`, `userHandle`)
        //                      VALUES (NULL, b'0', current_timestamp(), '$value', '$userHandle');";
        //         }
        //         mysqli_query($conn, $sql);
        //     }
        //     $cnt += 1;
        // }

        // --------------------------------------- SECOND try  project---------------------------------------
        // echo $badthing1;
        $sql = "INSERT INTO `good_and_bad_things` (`title`, `type`, `date`, `details`, `userHandle`)
                SELECT NULL, b'1', CURRENT_TIMESTAMP(), details, '$userHandle' 
                FROM (
                    SELECT '$goodthing1' AS details 
                    UNION ALL
                    SELECT '$goodthing2' AS details
                ) AS goodthings
                WHERE 
                    COALESCE(details, '') != '' AND
                    NOT EXISTS (
                        SELECT 1
                        FROM `good_and_bad_things`
                        WHERE `details` = goodthings.details AND `userHandle` = '$userHandle' AND `date` = CURRENT_DATE()
                    )

                UNION ALL

                SELECT NULL, b'0', CURRENT_TIMESTAMP(), details, '$userHandle'
                FROM (
                    SELECT '$badthing1' AS details 
                    UNION ALL
                    SELECT '$badthing2' AS details
                ) AS badthings
                WHERE 
                    COALESCE(details, '') != '' AND
                    NOT EXISTS (
                        SELECT 1
                        FROM `good_and_bad_things`
                        WHERE `details` = badthings.details AND `userHandle` = '$userHandle' AND `date` = CURRENT_DATE()
                    );
                ";

        // -------- SECOND END -----

        // save to db and check
        if (mysqli_query($conn, $sql)) {
            // success
            header('Location: #');
        } else {
            echo 'query error: '.mysqli_error($conn);
        }
    }
}

// ----------------- Fetch old gandb things --------------- tashin

$sql = "SELECT * 
        FROM `good_and_bad_things`
        WHERE userHandle = '$userHandle' && date = CURRENT_DATE();";

$resultantLabel = mysqli_query($conn, $sql);
$result = mysqli_fetch_all($resultantLabel);

// print_r($result);

$strArray = ['', '', '', ''];
$cntidx = 0;
$idx = 0;

foreach ($strArray as $ptr) {
    if ($cntidx >= count($result)) {
        // nothing
    } elseif ($result[$cntidx][1] == '0' && $idx <= 1) {
        // nothing
    } elseif ($result[$cntidx][1] == '1' && $idx <= 1) {
        $strArray[$idx] = $result[$cntidx][3];
        ++$cntidx;
    } elseif ($result[$cntidx][1] == '0' && $idx >= 2) {
        $strArray[$idx] = $result[$cntidx][3];
        ++$cntidx;
    }
    ++$idx;
}

// print_r($strArray);

$goodthing1 = $strArray[0];
$goodthing2 = $strArray[1];
$badthing1 = $strArray[2];
$badthing2 = $strArray[3];

// fetch data done

// ----------------- For label of users ---------------

// sql query
$sql = "SELECT l.labelName
        FROM user_info AS uinfo
        INNER JOIN
        label as l
        ON uinfo.userHandle = l.userHandle
        WHERE uinfo.userHandle = '$userHandle'; ";

$resultantLabel = mysqli_query($conn, $sql);  // get query result
$labels = mysqli_fetch_all($resultantLabel); // conver to array
// print_r($labels);

// sql query
$sql = "SELECT p.title, p.details,
                CASE
                    WHEN TIMESTAMPDIFF(HOUR, p.lastUpdate, NOW()) >= 1  THEN CONCAT(TIMESTAMPDIFF(HOUR, created_at, NOW()), ' hour(s) ago')
                    ELSE CONCAT(TIMESTAMPDIFF(MINUTE, p.lastUpdate, NOW()), ' minute(s) ago')
                END AS time_ago 
            FROM personal_journal as p 
            WHERE saved = 1 AND DATE(created_at) = DATE(now()) AND
            userHandle = '$userHandle'
            ORDER BY created_at DESC;";

$resultantLabel = mysqli_query($conn, $sql);  // get query result
$todaysSlices = mysqli_fetch_all($resultantLabel); // conver to array
// print_r($todaysSlices);

// for memory free
mysqli_free_result($resultantLabel);
// close connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Journal</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSS -->
    <!-- <link rel="stylesheet" href="../Includes/style.css"> -->
    <!-- uncomment -->

</head>

<body>
    <?php
    include '../Includes/NavBarSecond.php'; // uncomment
include '../Includes/Sidebar.php'; // uncomment
?>

    <style>
    .second {
        background-color: white;
        color: black;
    }
    </style>


    <!-- ------------------------ Main Segment ------------------------------- -->

    <main class="main shadow bg-white">
        <div class="bg-white">
            <div class="container bg-white">
                <div class="row bg-white">
                    <h2 class="bg-white">Daily Reflection</h2>
                </div>

                <form action="Personal-Journal.php" method="POST">
                    <div class="row bg-white">
                        <!-- Left Column: Item Comparison -->
                        <div class="col-md-6 border-end bg-white">
                                <h3 class="text-center bg-white">Positives Recap</h3>
                                <div class="row align-items-center bg-white">
                                    <label for="goodthing1" class="col-sm-2 col-form-label bg-white">1.</label>
                                    <div class="col-sm-10 bg-white">
                                        <input type="text" class="form-control bg-white" id="goodthing1" name="goodthing1"
                                            value="<?php echo htmlspecialchars($goodthing1); ?>"
                                            <?php if ($goodthing1 != null || strlen($goodthing1) != 0) { ?> readonly
                                            <?php } ?>>
                                    </div>
                                </div>
                                <div class="row align-items-center bg-white">
                                    <label for="goodthing2" class="col-sm-2 col-form-label bg-white">2.</label>
                                    <div class="col-sm-10 bg-white">
                                        <input type="text" class="form-control bg-white" id="goodthing2" name="goodthing2"
                                            value="<?php echo htmlspecialchars($goodthing2); ?>"
                                            <?php if ($goodthing2 != null || strlen($goodthing2) != 0) { ?> readonly
                                            <?php } ?>>
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
                                    <input type="text" class="form-control bg-white" id="badthing1" name="badthing1"
                                        value="<?php echo htmlspecialchars($badthing1); ?>"
                                        <?php if ($badthing1 != null || strlen($badthing1) != 0) { ?> readonly
                                        <?php } ?>>
                                </div>
                            </div>
                            <div class="row align-items-center bg-white">
                                <label for="badthing2" class="col-sm-2 col-form-label bg-white">2.</label>
                                <div class="col-sm-10 bg-white">
                                    <input type="text" class="form-control bg-white" id="badthing2" name="badthing2"
                                        value="<?php echo htmlspecialchars($badthing2); ?>"
                                        <?php if ($badthing2 != null || strlen($badthing2) != 0) { ?> readonly
                                        <?php } ?>>
                                </div>
                            </div>
                            <hr class="d-md-none bg-white">
                        </div>
                    </div>
                    <!-- button for saving good and bad things -->
                    <div class="second bg-white">
                        <button type="submit" class="btn btn-secondary" name="add">ADD</button>
                        <!-- <button type="submit" class="btn btn-primary bg-white" name="add" style="height: 30px; width: 100px; color:darkgrey; text-align: center;">ADD</button> -->
                    </div>
                </form>
            </div>


            <!------------------ New Note Segment ------------------>

            <div class="container pt-3 bg-white">
                <form action="Personal-Journal.php" method="POST">

                    <div class="row justify-content-around bg-white">
                        <div class="col bg-white">
                            <h4 class="bg-white">Today's Slice — <span class="bg-white"
                                    style="color: gray;"><?php echo ''.$today; ?></span></h4>
                        </div>
                        <div class="col bg-white">
                            <button type="button" class="btn btn-outline-secondary"><a class="bg-transparent"
                                    href="#todaysSlices" style="text-decoration: none; color: inherit;">Today's All
                                    Slice</a> </button>
                            <button type="button" class="btn btn-outline-secondary" type="submit" name="newSlice">New
                                Slice</button>
                            <button type="button" class="btn btn-outline-secondary" type="submit"
                                name="save">Save</button>
                        </div>
                    </div>
                    <hr class="m-0">

                    <!-- now123 -->
                    <div class="container bg-white">
                        <div class="row bg-white">
                            <div class="form-floating bg-white">
                                <textarea class="form-control bg-white" placeholder="Leave a comment here"
                                    id="floatingTextarea" name="title"></textarea>


                                <label for="floatingTextarea" class="bg-white">Title</label>
                            </div>
                        </div>
                        <div class="row bg-white">
                            <div class="form-floating bg-white">
                                <textarea class="form-control bg-white" placeholder="Leave a comment here"
                                    id="floatingTextarea2" name="details" style="height: 40vh"></textarea>
                                <label for="floatingTextarea2" class="bg-white">Details</label>
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
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    <?php echo htmlspecialchars($slice[0]); ?>
                                    <span class="align-items-end">
                                        <?php echo htmlspecialchars($slice[2]); ?>
                                    </span>
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
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