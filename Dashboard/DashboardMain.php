<?php

// connect database
$servername = 'localhost';
$username = 'root';
$password = '';
$databasename = 'Kairos';

// connection obj
$conn = mysqli_connect($servername, $username, $password, $databasename);

// check connection
if (!$conn) {
    exit('Sorry failed to connect: ' . mysqli_connect_error());
}

session_start(); // Start the session
// $userHandle = mysqli_real_escape_string($conn, $_SESSION['userHandle']); // after linked all page. it will be uncommented
$userHandle = mysqli_real_escape_string($conn, 'bijoy123'); // after linked all page. it will be deleted

$noteTitle = $noteDetails = $noteCreatedAt = '';
$public = 0; // public = 0 means private

// Save Notes
if (isset($_POST['saveNote'])) {
    if (isset($_POST['public'])) {
        $public = 1;
    }

    $noteTitle = mysqli_real_escape_string($conn, $_POST['noteTitle']);
    $noteDetails = mysqli_real_escape_string($conn, $_POST['noteDetails']);
    $public = mysqli_real_escape_string($conn, $public);

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

// Changes Note or Delete Note
if (isset($_POST['saveChanges']) || isset($_POST['deleteNote'])) {
    $noteCreatedAt = mysqli_real_escape_string($conn, $_POST['noteCreatedAt']);
    $sql = '';

    if (isset($_POST['saveChanges'])) {
        if (isset($_POST['public'])) {
            $public = 1;
        }

        $noteTitle = mysqli_real_escape_string($conn, $_POST['noteTitle']);
        $noteDetails = mysqli_real_escape_string($conn, $_POST['noteDetails']);
        $public = mysqli_real_escape_string($conn, $public);

        $sql = "UPDATE notes SET title = '$noteTitle', details = '$noteDetails', public = '$public'
                WHERE userHandle = '$userHandle' AND created_at = '$noteCreatedAt'";
    }

    // .....****** If we don't want to store deleted Notes in database, then it will be deleted *******...............
    if (isset($_POST['deleteNote'])) {

        // print($noteCreatedAt);
        $sql = "DELETE FROM notes
                WHERE userHandle = '$userHandle' AND created_at = '$noteCreatedAt'";

        /*
                DELETE FROM notes
                WHERE userHandle = 'tashin19' AND created_at = '2024-05-28 23:07:20';


                */
    }

    // .....****** If we want to store deleted Notes in database, then it will be uncommented *******...............
    // if (isset($_POST['deleteNote'])) {
    //     $sql = "UPDATE notes SET deleteStatus = 1
    //             WHERE userHandle = '$userHandle' AND created_at = '$noteCreatedAt'";
    // }

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

// ----------------- For label of users ---------------

// sql query

$sql = "SELECT l.labelName
        FROM user_info AS uinfo
        INNER JOIN
        label as l
        ON uinfo.userHandle = l.userHandle
        WHERE uinfo.userHandle = '$userHandle'; ";

$resultantLabel = mysqli_query($conn, $sql);  // get query result

$labels = mysqli_fetch_all($resultantLabel); // conver to array

// print_r($labels);

// ----------------- For Notes of users ---------------

// sql query
$sql = "SELECT title, details, created_at, public
        FROM user_info AS uinfo
        INNER JOIN
        notes as n
        ON uinfo.userHandle = n.userHandle
        WHERE uinfo.userHandle = '$userHandle'; ";

$resultantNotes = mysqli_query($conn, $sql);  // get query result

// $Notes = mysqli_fetch_assoc($resultantNotes); // conver to array
$Notes = mysqli_fetch_all($resultantNotes); // conver to array
// print_r($Notes);

// ----------------- For Notes of #label 1 clicked (From brooks) ---------------

// sql query
$sql = "SELECT title, details, created_at, l.labelName
        FROM user_info AS uinfo
        INNER JOIN
        notes as n
        ON uinfo.userHandle = n.userHandle
        INNER JOIN
        label as l
        ON l.userHandle = uinfo.userHandle
        WHERE uinfo.userHandle = 'bijoy123' AND l.labelName = 'Books';";

$resultantNotes = mysqli_query($conn, $sql);  // get query result

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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <style>
        .second {
            background-color: white;
            color: black;
            border-color: transparent;
        }

        * {
            background-color: #f1f4fb;
            font-family: "Ubuntu", sans-serif;
        }

        .bg-custom {
            background-color: #f1f4fb;
        }

        .card-hover {
            transition: transform 0.3s, background-color 0.3s;
            background-color: white;
            outline: none;
        }

        .card {
            outline: none;
        }

        /* .card-hover:hover {
            transform: translateY(-5px);
            background-color: #aed6f1;
        } */

        /* -------------------------------------- */
        .card-hover {
            transition: transform 0.3s, background-color 0.3s, outline-width 0.3s;
            outline-style: solid;
            outline-width: 0px;
            /* Initial outline width */
        }

        .card-hover:hover {
            outline-width: none;
            /* Width of the outline when hovered */
        }

        .card-hover-1:hover {
            transform: translateY(-5px);
            background-color: #aed6f1;
            /* Light blue */
        }

        .card-hover-2:hover {
            transform: translateY(-5px);
            background-color: #a9dfbf;
            /* Soft Green */
        }

        .card-hover-3:hover {
            transform: translateY(-5px);
            background-color: #f5b7b1;
            /* Soft Pink */
        }

        .card-hover-4:hover {
            transform: translateY(-5px);
            background-color: #f7cac9;
            /* Soft Orange */
        }

        .card-hover-5:hover {
            transform: translateY(-5px);
            background-color: #d2b4de;
            /* Soft Purple */
        }

        .card-hover-6:hover {
            transform: translateY(-5px);
            background-color: #f9e79f;
            /* Soft Yellow */
        }

        .card-hover-7:hover {
            transform: translateY(-5px);
            background-color: #f1948a;
            /* Soft Red */
        }

        .card-hover-8:hover {
            transform: translateY(-5px);
            background-color: #a2d9ce;
            /* Soft Teal */
        }

        .card-hover-9:hover {
            transform: translateY(-5px);
            background-color: #d7bde2;
            /* Soft Brown */
        }

        .card-hover-10:hover {
            transform: translateY(-5px);
            background-color: #d5dbdb;
            /* Soft Gray */
        }

        /* -------------------------------------- */

        .card-hover .card-body,
        .card-hover .card-footer {
            background-color: inherit;
        }

        .hover-underline-animation {
            display: inline-block;
            position: relative;
            color: gray;
            cursor: pointer;
        }

        .hover-underline-animation::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: gray;
            transform-origin: bottom right;
            transition: transform 0.25s ease-out;
        }

        .hover-underline-animation:hover {
            color: gray;
        }

        .hover-underline-animation:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        .hover-underline-animation.active::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        .card {
            display: flex;
            flex-direction: column;
        }

        .card-body {
            flex: 1 1 auto;
        }

        .card-footer {
            flex-shrink: 0;
        }
    </style>
</head>

<body class="bg-custom">
    <?php
    include '../Includes/NavBarSecond.php'; // uncomment
    include '../Includes/Sidebar.php'; // uncomment
    include '../Includes/HappyJar.php'; // uncomment
    ?>


    <main class="main bg-white shadow z-0">
        <div class="container bg-white m-0">

            <div class="row bg-white">
                <div class="col-lg-auto bg-white" style="      position: sticky;      z-index: 1000;">
                    <a id="all" style="text-decoration:none;" href="" class="hover-underline-animation active">All</a>
                </div>

                <?php foreach ($labels as $label) { ?>
                    <div class="second col-sm-auto" style="position: sticky; z-index: 1000;">
                        <a style="text-decoration:none;" href="" class="hover-underline-animation"><?php echo htmlspecialchars($label[0]); ?></a>
                    </div>
                <?php } ?>
            </div>
            <div class="container m-0 bg-transparent p-0">
                <div class="row bg-white m-0 mb-2">
                    <!-- Write Your Note Field (70% width) -->
                    <div class="col-lg-9 bg-white m-0 p-0" style=" position: sticky;    z-index: 1000; ">
                        <input id="openModalInput" class="form-control form-control-lg mt-3 pt-3 pb-3" type="text" placeholder="Write Your Note" aria-label=".form-control-lg example">
                        <!-- <input class="form-control form-control-lg mt-3 pt-3 pb-3" type="text" placeholder="Write Your Note" aria-label=".form-control-lg example"> -->
                    </div>

                    <!-- Search Field (30% width) -->
                    <div class="col-lg-3 bg-white m-0" style="      position: sticky;      z-index: 1000;">
                        <div class="input-group mt-3">
                            <input class="form-control form-control-lg pt-3 pb-3 bg-white" type="text" placeholder="Search notes" aria-label=".form-control-lg example">
                            <button class="btn btn-outline-secondary" type="button">
                                <img src="../images/Search-icon.png" class="bg-transparent" alt="Search" style="height: 50%;">
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <br>
            <div class="block bg-white">
                <!-- Notes Block -->
                <div class="bg-transparent">
                    <!---------------------- ALL Note Cards Show ---------------------->

                    <div class="row row-cols-1 row-cols-md-3 g-4 bg-transparent">
                        <!-- cards create -->
                        <?php
                        $hoverClasses = [
                            'card-hover-1',
                            'card-hover-2',
                            'card-hover-3',
                            'card-hover-4',
                            'card-hover-5',
                            'card-hover-6',
                            'card-hover-7',
                            'card-hover-8',
                            'card-hover-9',
                            'card-hover-10',
                        ];

                        foreach ($Notes as $index => $note) {
                            $randomClass = $hoverClasses[array_rand($hoverClasses)];
                        ?>
                            <div class="col bg-transparent">
                                <div class="card h-100 card-hover shadow <?php echo $randomClass; ?>">
                                    <button type="button" class="card-link btn btn-link p-0 m-0 border-0" data-bs-toggle="modal" data-bs-target="#editNoteModal" data-note-title="<?php echo htmlspecialchars($note[0]); ?>" data-note-details="<?php echo htmlspecialchars($note[1]); ?>" data-note-createdAt="<?php echo htmlspecialchars($note[2]); ?>" data-note-public="<?php echo htmlspecialchars($note[3]); ?>" style="text-decoration: none; color: inherit;">
                                        <div class="card-body bg-transparent">
                                            <h5 class="card-title bg-transparent">
                                                <?php echo htmlspecialchars($note[0]); ?>
                                            </h5>
                                            <p class="card-text bg-transparent">
                                                <?php echo htmlspecialchars($note[1]); ?>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <small class="text-muted bg-transparent">Created
                                                <?php echo htmlspecialchars($note[2]); ?>
                                            </small>
                                        </div>
                                    </button>
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
        <div class="modal-dialog modal-dialog">
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
                                        <input class="form-check-input" type="checkbox" role="switch" id="public" name="public">
                                        <label class="form-check-label" for="public">Make it public</label>
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

    <!-- Modal for editing notes -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editNoteModal = document.getElementById('editNoteModal');
            editNoteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var noteTitle = button.getAttribute('data-note-title');
                var noteDetails = button.getAttribute('data-note-details');
                var noteCreatedAt = button.getAttribute('data-note-createdAt');
                var notepublic = button.getAttribute('data-note-public');

                var modalTitleInput = editNoteModal.querySelector('#noteTitle');
                var modalDetailsTextarea = editNoteModal.querySelector('#noteDetails');
                var modalCreatedAtInput = editNoteModal.querySelector('#noteCreatedAt');
                var modalPublicCheckbox = editNoteModal.querySelector('#public');

                modalTitleInput.value = noteTitle;
                modalDetailsTextarea.value = noteDetails;
                modalCreatedAtInput.value = noteCreatedAt;
                modalPublicCheckbox.checked = (notePublic == 1);
            });

            document.getElementById('button').addEventListener('click', function() {
                var newNoteModal = new bootstrap.Modal(document.getElementById('editNoteModal'));
                newNoteModal.show();
            });
        });
    </script>

    <div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNoteModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editNoteForm" action="DashboardMain.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="noteTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="noteTitle" name="noteTitle">
                        </div>
                        <div class="mb-3">
                            <label for="noteDetails" class="form-label">Details</label>
                            <textarea class="form-control" id="noteDetails" name="noteDetails" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control" id="noteCreatedAt" name="noteCreatedAt" style="color: inherit;" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container">
                            <div class="row align-items-start">
                                <div class="col-5">
                                    <div class="form-check form-switch">
                                        <div class="row align-items-start">
                                            <div class="col-">
                                                <label class="form-check-label" for="public">Public</label>
                                            </div>
                                            <div class="col-">
                                                <input class="form-check-input" type="checkbox" role="switch" id="public" name="public">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <button type="submit" class="btn btn-danger" name="deleteNote">Delete Note</button>
                                    <button type="submit" class="btn btn-primary" name="saveChanges">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const links = document.querySelectorAll('.hover-underline-animation');

            links.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    // Remove the active class from all links
                    links.forEach(l => l.classList.remove('active'));

                    // Add the active class to the clicked link
                    this.classList.add('active');
                });
            });

            // Set the "All" button as active by default
            document.getElementById('all').classList.add('active');
        });
    </script>
</body>

</html>