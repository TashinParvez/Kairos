<?php

include('../Dashboard/connect_db.php'); // database connection

$labels  =  null;
$userHandle = null;
$errors = array('title&details' => '');
$year = 0;
$month = 0;
$day = 0;

// check get request userHandle 
if (isset($_GET['userHandle'])) {

    $userHandle = mysqli_real_escape_string($conn, $_GET['userHandle']);

    //----------------- For label of users ---------------


} else {  // full else remove after adding login 

    $userHandle = mysqli_real_escape_string($conn, 'tashin19');

    $sql = "SELECT title, details, YEAR(created_at), MONTH(created_at), DAY(created_at), lastUpdate, created_at
            FROM personal_journal
            WHERE userHandle = '$userHandle' AND saved = 1
            ORDER BY DATE(created_at) DESC, TIME(created_at) ASC;";

    $resultantLabel =  mysqli_query($conn, $sql);  // get query result

    $allSlices = mysqli_fetch_all($resultantLabel); // conver to array

    // print_r($allSlices);


    // foreach ($allSlices as $slice) {
    //     if ($year != $slice[2] || $month != $slice[3] || $day != $slice[4]) {
    //     }
    //     print_r($slice);
    //     echo '<br>';
    // }

    // for memory free
    mysqli_free_result($resultantLabel);
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


    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="../Includes/style.css">
    <!-- uncomment -->

</head>

<body>
    <?php
    include('../Includes/NavBar.php'); // uncomment
    include('../Includes/Sidebar.php'); // uncomment
    ?>

    <!-- ------------------------ Main Segment ------------------------------- -->
    <main class="main shadow">
        <div class="bg-white">
            <!-- for each -->

            <?php foreach ($allSlices as $slice) { ?>

                <!-- Condition -->
                <?php if ($year != $slice[2] || $month != $slice[3] || $day != $slice[4]) { ?>
                    <h2>
                        <?php echo htmlspecialchars('@' . $slice[4] . '-' . $slice[3] . '-' . $slice[2]);   ?>
                    </h2>
                    <?php
                    $year = $slice[2];
                    $month = $slice[3];
                    $day = $slice[4];
                    ?>
                    <hr style=" border: 10px solid black;border-radius: 5px;">
                <?php } ?>

                <h3>
                    <div class="">
                        <!-- Title -->
                        <?php echo htmlspecialchars($slice[0]); ?>
                        <button type="button" class="btn btn-outline-secondary">Edit</button>
                    </div>
                </h3>
                <hr style=" border-top: 1px dashed black;">

                <h4>
                    <!-- details -->
                    <?php echo htmlspecialchars($slice[1]); ?>
                </h4>
                <p>Last update on <?php echo htmlspecialchars($slice[5]); ?> </p>
                <hr style="  border: 1px solid black;">

            <?php } ?>


        </div>
    </main>

</body>

</html>