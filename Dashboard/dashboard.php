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

    <title>kairos</title>
    <!-- CSS Links -->
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- Bootstrap and Masonry -->
    <script defer src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>




    <!--  -->
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"></script>
    <!-- // last -->



</head>

<body class="bg-warning p-2 text-dark bg-opacity-10">

    <!-- ------------------------------------------------------------------ -->
    <!-------------------------------- Navbar -------------------------------->
    <!-- ------------------------------------------------------------------ -->

    <?php
    include('navbar.php');
    ?>



    <!-------------------- Body part of dashboard -------------------->

    <div class="container-fluid">
        <div class="row me-0">

            <!-- -------------------------------- First Block ---------------------------------------- -->

            <!------------------ Side Bar ------------------>
            <div class="col-2 pe-0">
                <div class="block" style="height: 200px; ">


                    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light ms-1 rounded border" style=" width: 270px;  height: 83.5vh;">
                        <a href="" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                            <svg class="bi me-2" width="40" height="32">
                            </svg>
                            <span class="fs-4">Sidebar</span>
                        </a>
                        <hr>

                        <ul class="nav nav-pills flex-column mb-auto ">

                            <!--  -->


                            <!--  $labels -->

                            <?php
                            foreach ($labels as $label) { ?>
                                <li class="nav-item mb-2">
                                    <a href="#" class="nav-link list-group-item" aria-current="page">
                                        <img src="../images/label.png" alt="BinFilderlogo" height="16vh" style="padding-left: 19px;">
                                        <?php echo htmlspecialchars($label[0]); ?>
                                    </a>
                                </li>
                            <?php } ?>


                            <!-- For Recycling bin  -->

                            <li>
                                <a href="#" class="nav-link link-dark">
                                    <img src="../images/recycle-bin.png" alt="BinFilderlogo" height="16vh" style="padding-left: 19px;">
                                    Trash
                                </a>
                            </li>


                        </ul>

                        <hr>
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                                <strong>
                                    <?php
                                    echo htmlspecialchars($userHandle);
                                    ?>
                                </strong>
                            </a>
                            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                                <li><a class="dropdown-item" href="#">Edit Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Sign out</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ------------------------------------ Second Block ------------------------------------- -->

            <div class="col-8 secondBlock rounded border">
                <div class="container mb-4">
                    <div class="row">
                        <!-- Write Your Note Field (70% width) -->
                        <div class="col-lg-9 " style=" position: sticky;    z-index: 1000; ">
                            <input class="form-control form-control-lg mt-3 pt-3 pb-3" type="text" placeholder="Write Your Note" aria-label=".form-control-lg example">
                        </div>

                        <!-- Search Field (30% width) -->
                        <div class="col-lg-3" style="      position: sticky;      z-index: 1000;">
                            <div class="input-group mt-3">
                                <input class="form-control form-control-lg pt-3 pb-3" type="text" placeholder="Search notes" aria-label=".form-control-lg example">
                                <button class="btn btn-outline-secondary" type="button">
                                    <img src="../images/Search-icon.png" alt="Search" style="height: 50%;">
                                </button>
                            </div>
                        </div>







                        <!-- ---------- -->


                    </div>
                </div>

                <div class="block " style="height: 83.5vh; overflow-y: auto;">
                    <!-- Notes Block -->
                    <div class="">

                        <!-- Write note + search block -->



                        <!---------------------- Note Cards ---------------------->

                        <div class="row row-cols-1 row-cols-md-3 g-4">

                            <!-- cards creat -->

                            <?php
                            foreach ($Notes as $note) { ?>

                                <div class="col">
                                    <div class="card h-100" >
                                        <img src="/Images/logo.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">
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

            <!----------------------------------------- Third Block ---------------------------------------------->

            <div class="col-2 thirdBlock rounded border ms-0">
                <div class="block" style=" width: 270px;  height: 83.5vh;">

                    <!----------------------------- Happiness Jar Block ---------------------------->

                    <div class="">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem aliquid nam iste quisquam. Atque
                        obcaecati adipisci quod asperiores sint tenetur? Lorem ipsum dolor sit amet consectetur
                        adipisicing elit. Alias illo nulla reiciendis, consequuntur saepe cupiditate accusantium.
                        Dolorem cum esse officiis, modi natus quam. Alias illo nulla reiciendis, consequuntur saepe
                        cupiditate accusantium.
                        Dolorem cum esse officiis, modi natus quam. Alias illo nulla reiciendis, consequuntur saepe
                        cupiditate accusantium.
                        Dolorem cum esse officiis, modi natus quam incidunt sit nostrum consectetur tempore est rem
                        quibusdam autem consequatur eaque culpa
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>