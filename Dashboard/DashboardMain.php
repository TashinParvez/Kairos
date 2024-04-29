<?php

include('connect_db.php'); // database connection



$labels  =  null;

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


    //----------------- For Notes of users ---------------

    // sql query 
    $sql = "SELECT title, details, created_at
        FROM user_info AS uinfo
        INNER JOIN
        notes as n
        ON uinfo.userHandle = n.userHandle
        WHERE uinfo.userHandle = '$userHandle'; ";

    $resultantNotes =  mysqli_query($conn, $sql);  // get query result

    // $Notes = mysqli_fetch_assoc($resultantNotes); // conver to array
    $Notes = mysqli_fetch_all($resultantNotes); // conver to array

    // for memory free
    mysqli_free_result($resultantLabel);
    mysqli_free_result($resultantNotes);
    mysqli_close($conn);
} else {  // full else remove after adding login 


    $userHandle = mysqli_real_escape_string($conn, 'bijoy123');

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


    //----------------- For Notes of users ---------------

    // sql query 
    $sql = "SELECT title, details, created_at
        FROM user_info AS uinfo
        INNER JOIN
        notes as n
        ON uinfo.userHandle = n.userHandle
        WHERE uinfo.userHandle = '$userHandle'; ";

    $resultantNotes =  mysqli_query($conn, $sql);  // get query result

    // $Notes = mysqli_fetch_assoc($resultantNotes); // conver to array 
    $Notes = mysqli_fetch_all($resultantNotes); // conver to array

    // print_r($Notes);

    // for memory free
    mysqli_free_result($resultantLabel);
    mysqli_free_result($resultantNotes);
    mysqli_close($conn);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kairos</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png"></link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Includes/style.css">
</head>
<body>
    <?php
        include('../Includes/NavBarSecond.php'); // uncomment
        include('../Includes/Sidebar.php'); // uncomment
    ?>
    <main class="main bg-white shadow">
        <div class="container bg-white">

<!-- -------------------------------- First Block ---------------------------------------- -->

<!-- ------------------------------------ Second Block ------------------------------------- -->


        <div class="row bg-white">
            <!-- Write Your Note Field (70% width) -->
            <div class="col-lg-9 bg-white" style=" position: sticky;    z-index: 1000; ">
                <input class="form-control form-control-lg mt-3 pt-3 pb-3" type="text" placeholder="Write Your Note" aria-label=".form-control-lg example">
            </div>

            <!-- Search Field (30% width) -->
            <div class="col-lg-3 bg-white" style="      position: sticky;      z-index: 1000;">
                <div class="input-group mt-3">
                    <input class="form-control form-control-lg pt-3 pb-3 bg-white" type="text" placeholder="Search notes" aria-label=".form-control-lg example">
                    <button class="btn btn-outline-secondary" type="button">
                        <img src="../images/Search-icon.png" alt="Search" style="height: 50%;">
                    </button>
                </div>
            </div>
        </div>

    </div>

    <div class="block " style="height: 83.5vh; overflow-y: auto;">
        <!-- Notes Block -->
        <div class="">
            <!---------------------- Note Cards ---------------------->

            <div class="row row-cols-1 row-cols-md-3 g-4">

                <!-- cards creat -->

                <?php
                foreach ($Notes as $note) { ?>

                    <div class="col bg-white">
                        <div class="card h-100 bg-white">
                            <img src="/Images/logo.png" class="card-img-top" alt="...">
                            <div class="card-body bg-white">
                                <h5 class="card-title bg-white">
                                    <?php
                                    echo htmlspecialchars($note[0]);
                                    ?>
                                </h5>
                                <p class="card-text">
                                    <?php
                                    echo htmlspecialchars($note[1]);
                                    ?>
                                </p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Created
                                    <?php
                                    echo htmlspecialchars($note[2]);
                                    ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>

            <!-- ----------------------------------- -->

        </div>

    </div>
</div>

    </main>
</body>
</html>