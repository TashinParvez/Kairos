<?php

include('../Dashboard/connect_db.php'); // database connection


$notes  =  null;

// check get request userHandle 
if (isset($_GET['bookName'])) {

    $bName = mysqli_real_escape_string($conn, $_GET['bookName']);


    //----------------- For Book Notes ---------------

    $sql = "SELECT lib.bookName, lib.authorName, lib.details, ntb.userhandle, title, ntb.details, created_at
            FROM life_library as lib 
            INNER JOIN
            (
                SELECT n.userHandle, n.title, n.details, n.created_at
                FROM notes as n  
                WHERE public = 1
            ) as ntb 
            ON ntb.title = lib.bookName
            WHERE lib.bookName =  '$bName'";

    $result =  mysqli_query($conn, $sql);

    $notes = mysqli_fetch_all($result);

    // print_r($notes);


    // foreach ($notes as $note) {
    //     print_r($note);
    //     echo '<br>';
    //     echo '<br>';
    // }



} else {  //------------------  full else remove after liked with lifelibrary 

    $bn = 'Atomic Habits';
    $bName = mysqli_real_escape_string($conn, $bn);

    // echo 'Tashin';

    //----------------- For Book Notes ---------------

    $sql = "SELECT lib.bookName, lib.authorName, lib.details, ntb.userhandle, title, ntb.details, created_at
            FROM life_library as lib 
            INNER JOIN
            (
                SELECT n.userHandle, n.title, n.details, n.created_at
                FROM notes as n  
                WHERE public = 1
            ) as ntb 
            ON ntb.title = lib.bookName
            WHERE lib.bookName =  '$bName'";

    $result =  mysqli_query($conn, $sql);

    $notes = mysqli_fetch_all($result);

    // print_r($notes);


    // foreach ($notes as $note) {
    //     print_r($note);
    //     echo '<br>';
    //     echo '<br>';
    // }
}


// for memory free
mysqli_free_result($result);
mysqli_close($conn);



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="editProfile.php">
    <link rel="stylesheet" href="../Dashboard/style.css">
    <link rel="stylesheet" href="library.css">

    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


</head>

<body>
    <!-- Navbar -->
    <?php include('/Kairos/Dashboard/navbar.php'); ?>

    <!-- Header -->


    <div class="container">
        <!-- <div class="row align-items-center"> -->
        <div class="row card mb-3">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/Images/logo2.png" class="img-fluid rounded-start" alt="..." style="width: 24vh;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($note[0]); ?>
                        </h5>
                        <h6>
                            <?php echo htmlspecialchars($note[1]); ?>
                        </h6>
                        <p class="card-text">
                            <?php echo htmlspecialchars($note[2]); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- </div> -->
    </div>

    <div class="container">
        <div class="row ">
            <div class="col-10">

                <!-- SELECT lib.bookName, lib.authorName, lib.details, ntb.userhandle, title, ntb.details, created_at -->
                <!-- $notes -->

                <?php
                foreach ($notes as $note) { ?>

                    <!--  -->
                    <div class="row card mb-3">
                        <div class="row g-0">
                            <!--  -->
                            <div class="entry col-12">
                                <div class="grid-inner row g-0">
                                    <div class="col-auto">
                                        <div class="entry-image">
                                            <a href="#"><img class="rounded-circle" src="/Images/User.jpg" alt="Image" style=" width: 4.5vh;"></a>
                                        </div>
                                    </div>
                                    <div class="col ps-3">
                                        <div class="entry-title">
                                            <h4>
                                                <?php echo htmlspecialchars($note[3]); ?>
                                            </h4>
                                        </div>
                                        <div class="entry-meta">
                                            <ul>
                                                <li><i class="uil uil-comments-alt"></i> 35 Comments</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <?php echo htmlspecialchars($note[5]); ?>
                                    </p>
                                    <p class="card-text"><small class="text-muted">Last updated
                                            <?php echo htmlspecialchars($note[6]); ?>
                                            mins ago</small></p>
                                </div>

                            </div>
                            <!--  -->
                        </div>
                    </div>
                <?php } ?>
            </div>


            <div class="col-2">
                <div class="row card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="..." class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Book Name</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>