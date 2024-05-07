<?php

include('\../Kairos/Dashboard/connect_db.php'); // database connection

session_start(); // Start the session
// $userHandle = mysqli_real_escape_string($conn, $_SESSION['userHandle']); // after linked all page. it will be uncommented
$userHandle = mysqli_real_escape_string($conn, 'bijoy123'); // after linked all page. it will be deleted



$searchData = ""; // catch search bar data

//----------------- retrive data ---------------

//-------------------  from blog   ----------------------
$sql = "SELECT DISTINCT*
        FROM blog
        WHERE topicName LIKE '%$searchData%' OR description LIKE '%$searchData%';";

$result =  mysqli_query($conn, $sql);
$blogs = mysqli_fetch_all($result);

//-------------------  from life_library   ----------------------
$sql = "SELECT DISTINCT *
        FROM life_library
        WHERE bookName LIKE '%$searchData%' OR authorName LIKE '%$searchData%'  OR details LIKE '%$searchData%';";

$result =  mysqli_query($conn, $sql);
$books = mysqli_fetch_all($result);

//-------------------  from  Notes   ----------------------
$sql = "SELECT DISTINCT *
        FROM notes
        WHERE title LIKE '%$searchData%' OR details LIKE '%$searchData%'";

$result =  mysqli_query($conn, $sql);
$notes = mysqli_fetch_all($result);

//-------------------  from  personal journal   ----------------------
$sql = "SELECT DISTINCT *
        FROM personal_journal
        WHERE title LIKE '%$searchData%' OR details LIKE '%$searchData%';";

$result =  mysqli_query($conn, $sql);
$notes = mysqli_fetch_all($result);







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
</head>

<body>

    <?php
    include('../Includes/NavBarSecond.php'); // uncomment
    include('../Includes/Sidebar.php'); // uncomment
    include('../Includes/HappyJar.php'); // uncomment
    ?>
    <main class="main bg-white shadow">


    </main>


</body>

</html>