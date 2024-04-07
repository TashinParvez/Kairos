<?php

include('\../Kairos/Dashboard/connect_db.php'); // database connection

$labels  =  null;

$userHandle = mysqli_real_escape_string($conn, 'bijoy123');


//----------------- For Notes - title of users ---------------

// sql query 
$sql = "SELECT title
        FROM user_info AS uinfo
        INNER JOIN
        notes as n
        ON uinfo.userHandle = n.userHandle
        WHERE uinfo.userHandle = '$userHandle'; ";

$resultantNotes =  mysqli_query($conn, $sql);  // get query result

// $Notes = mysqli_fetch_assoc($resultantNotes); // conver to array
$NotesTitle = mysqli_fetch_all($resultantNotes); // conver to array

// print_r($NotesTitle);


echo '<br><br><br>';

//----------------- For Notes - title of users ---------------

// sql query 
$sql = "SELECT details
        FROM user_info AS uinfo
        INNER JOIN
        notes as n
        ON uinfo.userHandle = n.userHandle
        WHERE uinfo.userHandle = '$userHandle'; ";

$resultantNotes =  mysqli_query($conn, $sql);  // get query result

// $Notes = mysqli_fetch_assoc($resultantNotes); // conver to array
$NotesDetails = mysqli_fetch_all($resultantNotes); // conver to array

// print_r($NotesDetails);


// for memory free
mysqli_close($conn);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>

    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


</head>

<body>

    <label for="exampleDataList" class="form-label">Datalist example</label>
    <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
    <datalist id="datalistOptions">
        <?php foreach ($NotesTitle as $title) { ?>
            <option value="<?php echo $title[0]; ?>"><?php echo $title[0]; ?></option>
        <?php } ?>
        <?php foreach ($NotesDetails as $details) { ?>
            <option value="<?php echo $details[0]; ?>"><?php echo $details[0]; ?></option>
        <?php } ?>
    </datalist>

</body>

</html>