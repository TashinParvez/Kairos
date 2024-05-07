<?php

include('connect_db.php'); // database connection

session_start(); // Start the session
// $userHandle = mysqli_real_escape_string($conn, $_SESSION['userHandle']); // after linked all page. it will be uncommented
$userHandle = mysqli_real_escape_string($conn, 'bijoy123'); // after linked all page. it will be deleted

$noteTitle = $noteDetails = '';
$public = 0;

// Save Notes
if (isset($_POST['saveNote'])) {

    $noteTitle = mysqli_real_escape_string($conn, $_POST['noteTitle']);
    $noteDetails = mysqli_real_escape_string($conn, $_POST['noteDetails']);

    if (isset($_POST['public'])) {
        $public = 1;
    }

    // create sql
    $sql = "INSERT INTO notes(userHandle, title, details, public)
                    VALUES('$userHandle', '$noteTitle', '$noteDetails', '$public')";

    // save to db and check
    if (mysqli_query($conn, $sql)) {
        // success
        header('Location: DashboardMain.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }

    // close connection
    mysqli_close($conn);
}

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
    include('../Includes/NavThird.php'); // uncomment
    include('../Includes/Sidebar.php'); // uncomment
    ?>
    <main class="main bg-white shadow">
        <div class="container bg-white">

            <!-- -------------------------------- First Block ---------------------------------------- -->

            <!-- ------------------------------------ Second Block ------------------------------------- -->


            <div class="row bg-white">
                <!-- Write Your Note Field (70% width) -->
                <div class="col-lg-9 bg-white" style=" position: sticky;    z-index: 1000; ">
                    <input id="openModalInput" class="form-control form-control-lg mt-3 pt-3 pb-3" type="text" placeholder="Write Your Note" aria-label=".form-control-lg example">
                    <!-- <input class="form-control form-control-lg mt-3 pt-3 pb-3" type="text" placeholder="Write Your Note" aria-label=".form-control-lg example"> -->
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

        <div class="block bg-white">
            <!-- Notes Block -->
            <div class="">
                <!---------------------- Note Cards ---------------------->

                <div class="row row-cols-1 row-cols-md-3 g-4 bg-white">

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

    <!-- Modal for creating note -->
    <script>
        // Get the input field element
        var inputField = document.getElementById('openModalInput');

        // Add click event listener to the input field
        inputField.addEventListener('click', function() {
            // Trigger the modal to show
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        });
    </script>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Write Your Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="DashboardMain.php" method="POST">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="noteTitle" class="form-label">Note Title</label>
                            <input type="text" class="form-control" id="noteTitle" name="noteTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="noteDetails" class="form-label">Note Details</label>
                            <textarea class="form-control bg-white" id="noteDetails" name="noteDetails" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container">
                            <div class="row align-items-start">
                                <div class="col-7">
                                    <div class="form-check form-switch">
                                        <label class="form-check-label" for="public">Make it public</label>
                                        <input class="form-check-input" type="checkbox" role="switch" id="public" name="public">
                                    </div>
                                </div>
                                <div class="col-5">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="saveNote">Save Note</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>