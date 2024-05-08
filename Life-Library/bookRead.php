<?php

include '../Dashboard/connect_db.php'; // database connection

$notes = null;

// check get request userHandle
if (isset($_GET['bookName'])) {
    $bName = mysqli_real_escape_string($conn, $_GET['bookName']);

    // ----------------- For Book Notes ---------------

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

    $result = mysqli_query($conn, $sql);

    $notes = mysqli_fetch_all($result);

    // print_r($notes);

    // foreach ($notes as $note) {
    //     print_r($note);
    //     echo '<br>';
    //     echo '<br>';
    // }
} else {  // ------------------  full else remove after liked with lifelibrary
    $bn = 'Atomic Habits';
    $bName = mysqli_real_escape_string($conn, $bn);

    // echo 'Tashin';

    // ----------------- For Book Notes ---------------

    $sql = "SELECT lib.bookName, lib.authorName, lib.details, ntb.userhandle, title, ntb.details, DATE(created_at),
            CASE
                WHEN lastName IS NULL THEN firstName
                ELSE CONCAT(firstName, ' ', lastName)
            END AS fullName
            FROM life_library as lib 
            INNER JOIN
            (
                SELECT n.userHandle, n.title, n.details, n.created_at
                FROM notes as n  
                WHERE public = 1
            ) as ntb 
            ON ntb.title = lib.bookName
            INNER JOIN
            user_info as ui
            ON ui.userHandle = ntb.userHandle
            WHERE lib.bookName =  '$bName'
            ORDER BY created_at DESC;";

    $result = mysqli_query($conn, $sql);

    $notes = mysqli_fetch_all($result);

    // print_r($notes);

    // foreach ($notes as $note) {
    //     print_r($note);
    //     echo '<br>';
    //     echo '<br>';
    // }

    // ------------------------------ For Most Read ----------------------------
    // sql query

    $sql = 'SELECT bookName, authorName, details
            FROM life_library
            ORDER BY clicked DESC
            Limit 3';

    $resultantLabel = mysqli_query($conn, $sql);  // get query result

    $mostRead = mysqli_fetch_all($resultantLabel); // conver to array

    // print_r($mostRead);

    // foreach ($mostRead as $label) {
    //     echo htmlspecialchars($label[0]);
    //     echo '  -->  ';
    //     echo htmlspecialchars($label[1]);
    //     echo '  -->  ';
    //     echo htmlspecialchars($label[2]);
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
    <title>Books</title>
    <link rel="stylesheet" href="editProfile.php">
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    </link>
    <link rel="stylesheet" href="../Dashboard/style.css">
    <link rel="stylesheet" href="library.css">

    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


</head>

<body>
    <!--------------------------------- Navbar --------------------------------->
    <?php
    include '../Includes/NavBarSecond.php'; // uncomment
    include '../Includes/Sidebar.php'; // uncomment
    ?>

    <!--------------------------------- Header --------------------------------->

    <main class="main bg-white shadow">
        <div class="container">
            <!-- <div class="row align-items-center"> -->
            <div class="row card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="/Images/logo2.png" class="img-fluid rounded-start" alt="..." style="width: 24vh;">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h4 class="card-title text-center">
                                <?php echo htmlspecialchars($notes[0][0]); ?>
                            </h4>
                            <h6 class="text-center">
                                <?php echo htmlspecialchars($notes[0][1]); ?>
                            </h6>
                            <p class="card-text">
                                <?php echo htmlspecialchars($notes[0][2]); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
        </div>

        <!-------------------------    Notes Body  ------------------------->

        <div class="container">
            <div class="row ">
                <!-------------------------    Users Notes   ------------------------->
                <div class="col-9">
                    <?php
                    foreach ($notes as $note) { ?>

                        <!--  -->
                        <div class="row card mb-3 ps-3 pt-3 pb-3">
                            <div class="row g-0">
                                <!--  -->
                                <div class="entry col-12 p-3">
                                    <div class="grid-inner row g-0">
                                        <div class="col-auto">
                                            <div class="entry-image">
                                                <a href="#"><img class="rounded-circle" src="/Images/User.jpg" alt="Image" style=" width: 4.5vh;"></a>
                                            </div>
                                        </div>
                                        <div class="col ps-3">
                                            <div class="entry-title">
                                                <h4>
                                                    <?php echo htmlspecialchars($note[7]); ?>
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
                                        <p class="card-text"><small class="text-muted">Uploaded on
                                                <?php echo htmlspecialchars($note[6]); ?>
                                                <?php echo '.'; ?>
                                            </small></p>
                                    </div>

                                </div>
                                <!--  -->
                            </div>
                        </div>
                    <?php } ?>
                </div>


                <!------------------------------- Side Bar ------------------------------->

                <div class="col-3 ps-4">

                    <!------------------------- Carousel ------------------------->
                    <div class="row  bg-white rounded pb-3">
                        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner">

                                <div class="carousel-item active" data-bs-interval="2000">
                                    <img src="../Images/Books/Atomic Habits.jpg" class="d-block w-100" alt="...">
                                    <div class="carousel-caption d-none d-md-block">
                                        <!-- <h5>First slide label</h5>
                                    <p>Some representative placeholder content for the first slide.</p> -->
                                    </div>
                                </div>

                                <div class="carousel-item" data-bs-interval="2000">
                                    <img src="../Images/Books/Eat That Frog!.jpg" class="d-block w-100" alt="...">
                                    <div class="carousel-caption d-none d-md-block">
                                        <!-- <h5>Second slide label</h5>
                                    <p>Some representative placeholder content for the second slide.</p> -->
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <img src="../Images/Books/The 4-Hour Work Week.jpg" class="d-block w-100" alt="...">
                                    <div class="carousel-caption d-none d-md-block">
                                        <!-- <h5>Third slide label</h5>
                                    <p>Some representative placeholder content for the third slide.</p> -->
                                    </div>
                                </div>
                            </div>
                            <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button> -->
                        </div>
                    </div>
                    <!--  -->


                    <!-------------------------- Most read -------------------------->
                    <div class="row  bg-white rounded pb-3 mt-3">
                        <?php
                        foreach ($mostRead as $read) { ?>

                            <div class="col mt-3">
                                <div class="card mostreadbooks" style="width: 18rem; transition: transform 0.3s;">
                                    <style>
                                        .card:hover {
                                            transform: translateY(-5px);
                                        }
                                    </style>
                                    <img src="../Images/logo2.png" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <h6> <?php echo htmlspecialchars($read[0]); ?></h6>
                                        </h5>
                                        <p class="card-text">
                                        <h6> <?php echo htmlspecialchars($read[2]); ?></h6>
                                        </p>
                                        <a href="#" class="card-link">Read Now</a>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                    </div>


                    <!-- ---------------------- -->


                </div>
            </div>
        </div>
    </main>


</body>

</html>