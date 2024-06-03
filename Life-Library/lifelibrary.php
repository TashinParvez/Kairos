<?php

include('../Dashboard/connect_db.php'); // database connection


// ------------------------------ For Most Read ----------------------------
// sql query

$sql = "SELECT bookName, authorName
        FROM life_library
        ORDER BY clicked DESC
        Limit 8";

$resultantLabel =  mysqli_query($conn, $sql);  // get query result

$mostRead = mysqli_fetch_all($resultantLabel); // conver to array

// print_r($mostRead);

// echo '<br>';

// foreach ($mostRead as $label) {
//     echo htmlspecialchars($label[0]);
//     echo '<br>';
//     echo htmlspecialchars($label[1]);
//     echo '<br>';
// }


//----------------------------- For Recently added __Project---------------------------

$sql = "SELECT life_library.bookName, life_library.authorName
        FROM notes AS t
        INNER JOIN (
                    SELECT title, MAX(created_at) AS latest_created_at
                    FROM notes
                    WHERE public = 1
                    GROUP BY title
                    ) AS latest 
        ON t.title = latest.title AND t.created_at = latest.latest_created_at
        INNER JOIN
        life_library 
        ON t.title = life_library.bookName
        ORDER BY created_at DESC
        LIMIT 8";

$result =  mysqli_query($conn, $sql);

$recentlyAdded = mysqli_fetch_all($result); // conver to array

// print_r($recentlyAdded);


// foreach ($recentlyAdded as $book) {
//     print_r($book);
//     echo '<br>';
// }



//--------------------------------- For Alhabetically  __Project-------------------------------

$sql = "SELECT lf.bookName, lf.authorName, CONCAT(LEFT(lf.details, 68), '...') AS 'lf.details',
        CASE
                WHEN lastName IS NULL THEN firstName
                ELSE CONCAT(firstName, ' ', lastName)
        END AS fullName,
        CASE
                WHEN TIMESTAMPDIFF(YEAR, ntb.created_at, NOW()) >= 1  THEN CONCAT(TIMESTAMPDIFF(YEAR, created_at, NOW()), ' year(s) ago')
                WHEN TIMESTAMPDIFF(MONTH, ntb.created_at, NOW()) >= 1 THEN CONCAT(TIMESTAMPDIFF(MONTH, created_at, NOW()), ' month(s) ago')
                WHEN TIMESTAMPDIFF(DAY, ntb.created_at, NOW()) >= 1   THEN CONCAT(TIMESTAMPDIFF(DAY, created_at, NOW()), ' day(s) ago')
                WHEN TIMESTAMPDIFF(HOUR, ntb.created_at, NOW()) >= 1  THEN CONCAT(TIMESTAMPDIFF(HOUR, created_at, NOW()), ' hour(s) ago')
                ELSE CONCAT(TIMESTAMPDIFF(MINUTE, ntb.created_at, NOW()), ' minute(s) ago')
        END AS time_ago 

        FROM life_library AS lf

        LEFT JOIN 
        (
            SELECT n.title, ui.firstName , ui.lastName, n.created_at
            FROM (
                    SELECT t.*
                    FROM notes AS t
                    INNER JOIN (
                                SELECT title, MAX(created_at) AS latest_created_at
                                FROM notes
                                WHERE public = 1
                                GROUP BY title
                            ) AS latest 
                    ON t.title = latest.title AND t.created_at = latest.latest_created_at 
            ) as n 
            INNER JOIN
            user_info as ui
            ON n.userHandle = ui.userHandle
            ORDER BY n.created_at
        ) AS ntb
        ON bookName =  ntb.title
        
        ORDER BY lf.bookName, ntb.created_at DESC";


$result =  mysqli_query($conn, $sql);  // get query result

$ABCDRead = mysqli_fetch_all($result); // conver to array


// print_r($ABCDRead);



// for memory free
mysqli_free_result($resultantLabel);
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
    <!-- Search bar -->


    <div class="container-fluid">
        <div class="row m-0">
            <div class="row justify-content-center mt-3" style="overflow-x: hidden;">
                <div class="col-lg-6">
                    <div class="input-group">
                        <input type="search" class="form-control rounded" placeholder="Which one you are looking for..." aria-label="Search" aria-describedby="search-addon" />
                        <button type="button" class="btn btn-outline-primary" data-mdb-ripple-init>Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialization for ES Users
        import {
            Ripple,
            initMDB
        } from "mdb-ui-kit";

        initMDB({
            Ripple
        });
    </script>


    <!-- ------------------------MOST READ------------------- -->

    <div class="container">
        <H4>Most Read</H4>
        <hr class="double">

        <div class="container" style="background: snow;">

            <div class="row mt-1 p-2">

                <?php
                foreach ($mostRead as $read) { ?>

                    <div class="col card ms-2 me-2 "><img src="../Images/logo2.png">
                        <div class="card-body">
                            <div class="layer">

                                <h6> <?php echo htmlspecialchars($read[0]); ?></h6>
                                <p> <?php echo htmlspecialchars($read[1]); ?> </p>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>
    </div>


    <!------------------ Recently added read ------------------>


    <div class="container">
        <H4>Recently Added</H4>
        <hr class="double">
        <div class="container" style="background: snow;">
            <div class="row mt-1 p-2">

                <?php
                foreach ($recentlyAdded as $read) { ?>

                    <div class="col card ms-2 me-2 "><img src="../Images/logo2.png">
                        <div class="card-body">
                            <div class="layer">
                                <h6> <?php echo htmlspecialchars($read[0]); ?></h6>
                                <p> <?php echo htmlspecialchars($read[1]); ?> </p>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>
    </div>


    <!------------------------- alphabetically listed ------------------------->

    <div class="container">

        <H4>ALL BOOKS</H4>
        <hr class="double">

        <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">

            <?php
            foreach ($ABCDRead as $book) { ?>
                <div class="col">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="../Images/logo2.png" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php echo htmlspecialchars($book[0]); ?>
                                    </h5>
                                    <h6>
                                        <?php echo htmlspecialchars($book[1]); ?>
                                    </h6>
                                    <p class="card-text">
                                        <?php echo htmlspecialchars($book[2]); ?>
                                    </p>
                                    <p class="card-text"><small class="text-muted">Last updated by
                                            <?php echo htmlspecialchars($book[3]); ?>
                                            <?php echo ' '; ?>
                                            <?php echo htmlspecialchars($book[4]); ?>
                                        </small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    </div>

</body>

</html>