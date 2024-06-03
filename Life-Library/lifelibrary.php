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


//----------------------------- For Recently added ---------------------------

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



//--------------------------------- For Alhabetically -------------------------------

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
    <title>Kairos</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    </link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Includes/style.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

</head>

<body>
    <!-- Navbar -->

    <?php
    include '../Includes/NavBarSecond.php'; // uncomment
    include '../Includes/Sidebar.php'; // uncomment
    include '../Includes/HappyJar.php'; // uncomment
    ?>
    <!-- Search bar -->

<main class="main bg-white shadow">
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
    <div class="container bg-white m-0 ">
        <H2 class="bg-white">Most Read</H2>
        <hr class="double">
        <div class="container bg-white">
            <div class="row mt-1 p-2 bg-white">
                <?php
                foreach ($mostRead as $read) { ?>

                    <div class="col card ms-2 me-2 bg-white">
                        <div class="card-body bg-white">
                            <div class="layer bg-white">
                                <h6 class="bg-white"> <?php echo htmlspecialchars($read[0]); ?></h6>
                                <p class="bg-white"> <?php echo htmlspecialchars($read[1]); ?> </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!------------------ Recently added read ------------------>
    <div class="container bg-white m-0">
        <H4 class="bg-white">Recently Added</H4>
        <hr class="double bg-white">
        <div class="container bg-white" style="background: snow;">
            <div class="row mt-1 p-2 bg-white">

                <?php
                foreach ($recentlyAdded as $read) { ?>

                    <div class="col card ms-2 me-2 bg-white">
                        <div class="card-body bg-white">
                            <div class="layer bg-white">
                                <h6 class="bg-white"> <?php echo htmlspecialchars($read[0]); ?></h6>
                                <p class="bg-white"> <?php echo htmlspecialchars($read[1]); ?> </p>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>
    </div>
    <!------------------------- alphabetically listed ------------------------->

    <div class="container bg-white m-0">
        <H4 class="bg-white">All Books</H4>
        <hr class="double bg-white">
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-4 bg-white">
            <?php
            foreach ($ABCDRead as $book) { ?>
                <div class="col bg-white">
                    <div class="card mb-3 bg-white" style="max-width: 540px;">
                    <div id="book-card" class="card-body bg-white">
    <a href="bookRead.php" class="stretched-link"></a>
    <h5 class="card-title bg-white">
        <?php echo htmlspecialchars($book[0]); ?>
    </h5>
    <h6 class="bg-white">
        <?php echo htmlspecialchars($book[1]); ?>
    </h6>
    <p class="card-text bg-white">
        <?php echo htmlspecialchars($book[2]); ?>
    </p>
    <p class="card-text bg-white"><small class="text-muted bg-white">Last updated by
        <?php echo htmlspecialchars($book[3]); ?>
        <?php echo ' '; ?>
        <?php echo htmlspecialchars($book[4]); ?>
    </small></p>

<style>
#book-card {
    position: relative;
}

#book-card a.stretched-link {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}
</style>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    </div>
    </main>
</body>

</html>