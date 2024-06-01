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

// ------------------------------------- inner Page search -----------------------------
$search_text = '';

if (isset($_POST['btnSrch'])) {
    $search_text = $_POST['srchBar'];

    $sql = "SELECT distinct title, details, created_at, public
            FROM notes
            WHERE userHandle ='$userHandle' &&
            ( title LIKE '%" . $search_text . "%' || details LIKE '%" . $search_text . "%' );";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $Notes = mysqli_fetch_all($result);
    } else {
        $Notes = 'Empty result!';
    }
} else {
    // ----------------- For Notes of users ---------------

    // sql query
    $sql = "SELECT title, details, created_at, public
        FROM user_info AS uinfo
        INNER JOIN
        notes as n
        ON uinfo.userHandle = n.userHandle
        WHERE uinfo.userHandle = '$userHandle'
        ORDER BY created_at DESC;";

    $resultantNotes = mysqli_query($conn, $sql);  // get query result

    $Notes = mysqli_fetch_all($resultantNotes); // conver to array
    // print_r($Notes);
}

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
// $Notes = mysqli_fetch_all($resultantNotes); // conver to array





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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
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
            outline: white;
        }

        .card {
            outline: none;
            outline: white;
        }

        .card-text {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* Number of lines to show */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: 4.5em;
            align-items: normal;
            /* Assuming a line height of 1.5em */
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
            outline-color: white;
        }

        .card-body {
            flex: 1 1 auto;
        }

        .card-footer {
            flex-shrink: 0;
        }

        button:focus {
            outline: none;
        }

        button {
            outline: none;
        }

        #card-btn {
            align-items: start;
        }

        :root {
            --rad: .7rem;
            --dur: .3s;
            --color-dark: #2f2f2f;
            --color-light: #fff;
            --color-brand: #57bd84;
            --font-fam: 'Lato', sans-serif;
            --height: 5rem;
            --btn-width: 6rem;
            --bez: cubic-bezier(0, 0, 0.43, 1.49);
        }

        #srchForm {
            position: relative;
            max-width: 30rem;
            background: var(--color-brand);
            border-radius: var(--rad);
        }

        #srchBar,
        #btnSrch {
            height: var(--height);
            font-family: var(--font-fam);
            border: 0;
            color: var(--color-dark);
            font-size: 1.8rem;
        }

        #srchBar[type="search"] {
            outline: 0;
            width: 100%;
            background: var(--color-light);
            padding: 0 1.6rem;
            border-radius: var(--rad);
            appearance: none;
            transition: all var(--dur) var(--bez);
            transition-property: width, border-radius;
            z-index: 1;
            position: relative;
        }

        #btnSrch {
            display: none;
            position: absolute;
            top: 0;
            right: 0;
            width: var(--btn-width);
            font-weight: bold;
            background: var(--color-brand);
            border-radius: 0 var(--rad) var(--rad) 0;
        }

        #srchBar:not(:placeholder-shown) {
            border-radius: var(--rad) 0 0 var(--rad);
            width: calc(100% - var(--btn-width));

            +button {
                display: block;
            }
        }

        label {
            position: absolute;
            clip: rect(1px, 1px, 1px, 1px);
            padding: 0;
            border: 0;
            height: 1px;
            width: 1px;
            overflow: hidden;
        }

        #srchBar[type="search"] {
            width: 100%;
            /* Ensure it takes full width within form */
        }

        #srchBar:not(:placeholder-shown) {
            width: calc(100% - var(--btn-width));
            /* Adjusted width calculation */
            border-radius: var(--rad) 0 0 var(--rad);

            +button {
                display: block;
            }

        }

        #srchForm {
            position: relative;
            max-width: 30rem;
            background: var(--color-brand);
            border-radius: var(--rad);
        }

        #srchBar,
        #btnSrch {
            height: 47px;
            /* Adjust the height to 48px */
            font-family: var(--font-fam);
            border: 0;
            color: var(--color-dark);
            font-size: 1rem;
        }

        #srchBar[type="search"] {
            width: 100%;
        }

        #srchBar:not(:placeholder-shown) {
            width: calc(100% - var(--btn-width));
            border-radius: var(--rad) 0 0 var(--rad);

            +button {
                display: block;
            }
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
            <h2 class="bg-transparent">Your Notes</h2>
            <div class="row bg-white mt-3">
                <div class="col-lg-auto bg-white" style="      position: sticky;      z-index: 1000;">
                    <a id="all" style="text-decoration:none;" href="" class="hover-underline-animation active">All</a>
                </div>

                <?php foreach ($labels as $label) { ?>
                    <div class="second col-sm-auto" style="position: sticky; z-index: 1000;">
                        <a style="text-decoration:none;" href="" class="hover-underline-animation"><?php echo htmlspecialchars($label[0]); ?></a>
                    </div>
                <?php } ?>
            </div>
            <div class="container m-0 bg-transparent p-0 mt-2" style="outline:none;">
                <div class="row bg-white m-0 mb-2" style="display: flex; align-items: flex-end;">
                    <!-- Write Your Note Field (70% width) -->
                    <div class="col-lg-9 bg-white m-0 p-0" style="position: sticky; z-index: 1000;">
                        <button id="openModalInput" style="outline:none;" class="form-control form-control-lg mt-3 pt-3 pb-3 d-flex align-items-center shadow" type="button" placeholder="Write Your Note" aria-label=".form-control-lg example">
                            <svg class="bg-white me-2" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 22C1 21.4477 1.44772 21 2 21H22C22.5523 21 23 21.4477 23 22C23 22.5523 22.5523 23 22 23H2C1.44772 23 1 22.5523 1 22Z" fill="#0F0F0F" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.3056 1.87868C17.1341 0.707107 15.2346 0.707107 14.063 1.87868L3.38904 12.5526C2.9856 12.9561 2.70557 13.4662 2.5818 14.0232L2.04903 16.4206C1.73147 17.8496 3.00627 19.1244 4.43526 18.8069L6.83272 18.2741C7.38969 18.1503 7.89981 17.8703 8.30325 17.4669L18.9772 6.79289C20.1488 5.62132 20.1488 3.72183 18.9772 2.55025L18.3056 1.87868ZM15.4772 3.29289C15.8677 2.90237 16.5009 2.90237 16.8914 3.29289L17.563 3.96447C17.9535 4.35499 17.9535 4.98816 17.563 5.37868L15.6414 7.30026L13.5556 5.21448L15.4772 3.29289ZM12.1414 6.62869L4.80325 13.9669C4.66877 14.1013 4.57543 14.2714 4.53417 14.457L4.0014 16.8545L6.39886 16.3217C6.58452 16.2805 6.75456 16.1871 6.88904 16.0526L14.2272 8.71448L12.1414 6.62869Z" fill="#0F0F0F" />
                            </svg>
                            <span class="bg-transparent" style="color:gray; font-size: 1rem;">Write Your Note</span>
                        </button>
                    </div>
                    <div class="col-lg-3 bg-transparent m-0 bg-transparent" style="position: sticky; z-index: 1000;">
                        <form action="DashboardMain.php" method="POST" id="srchForm" class="border shadow" role="search" >
                            <label for="search" style=" color:white;">Search for stuff</label>
                            <input id="srchBar" name="srchBar" type="search" placeholder="Search..." autofocus required />
                            <button id="btnSrch" name="btnSrch" type="submit">Go</button>
                        </form>
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
                                <div class="card h-100 card-hover shadow <?php echo $randomClass; ?>" style="outline-color:white;">
                                    <button type="button" id="card-btn" class="card-link btn btn-link p-0 m-0 " data-bs-toggle="modal" data-bs-target="#editNoteModal" data-note-title="<?php echo htmlspecialchars($note[0]); ?>" data-note-details="<?php echo htmlspecialchars($note[1]); ?>" data-note-createdAt="<?php echo htmlspecialchars($note[2]); ?>" data-note-public="<?php echo htmlspecialchars($note[3]); ?>" style="text-decoration: none; color: inherit;">
                                        <div class="card-body bg-transparent text-start">
                                            <h4 class="card-title bg-transparent">
                                                <?php echo htmlspecialchars($note[0]); ?>
                                            </h4>
                                            <p class="card-text bg-transparent">
                                                <?php echo htmlspecialchars($note[1]); ?>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-transparent text-end" style="align-items: end; border-top: none;">
                                            <span class="bg-transparent">
                                                <svg class="bg-transparent" width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C22 6.34315 22 8.22876 22 12V14C22 17.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V12Z" stroke="#1C274C" stroke-width="1.5" />
                                                    <path d="M7 4V2.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                                    <path d="M17 4V2.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                                    <path d="M2.5 9H21.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                                    <path d="M18 17C18 17.5523 17.5523 18 17 18C16.4477 18 16 17.5523 16 17C16 16.4477 16.4477 16 17 16C17.5523 16 18 16.4477 18 17Z" fill="#1C274C" />
                                                    <path d="M18 13C18 13.5523 17.5523 14 17 14C16.4477 14 16 13.5523 16 13C16 12.4477 16.4477 12 17 12C17.5523 12 18 12.4477 18 13Z" fill="#1C274C" />
                                                    <path d="M13 17C13 17.5523 12.5523 18 12 18C11.4477 18 11 17.5523 11 17C11 16.4477 11.4477 16 12 16C12.5523 16 13 16.4477 13 17Z" fill="#1C274C" />
                                                    <path d="M13 13C13 13.5523 12.5523 14 12 14C11.4477 14 11 13.5523 11 13C11 12.4477 11.4477 12 12 12C12.5523 12 13 12.4477 13 13Z" fill="#1C274C" />
                                                    <path d="M8 17C8 17.5523 7.55228 18 7 18C6.44772 18 6 17.5523 6 17C6 16.4477 6.44772 16 7 16C7.55228 16 8 16.4477 8 17Z" fill="#1C274C" />
                                                    <path d="M8 13C8 13.5523 7.55228 14 7 14C6.44772 14 6 13.5523 6 13C6 12.4477 6.44772 12 7 12C7.55228 12 8 12.4477 8 13Z" fill="#1C274C" />
                                                </svg>
                                                <small class="text-muted bg-transparent">
                                                    <?php echo htmlspecialchars($note[2]); ?>
                                                </small>
                                            </span>
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
    <div class=" modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Write
                        Your Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="DashboardMain.php" method="POST">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="noteTitle" class="form-label">Note
                                Title</label>
                            <input type="text" class="form-control" id="noteTitle" name="noteTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="noteDetails" class="form-label">Note
                                Details</label>
                            <textarea class="form-control bg-white" id="noteDetails" name="noteDetails" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container">
                            <div class="row align-items-start">
                                <div class="col-7">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="public" name="public">
                                        <p class="form-check-label bg-transparent" for="public">Make it
                                            public</p>
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
                var noteDetails = button.getAttribute(
                    'data-note-details');
                var noteCreatedAt = button.getAttribute(
                    'data-note-createdAt');
                var notepublic = button.getAttribute(
                    'data-note-public');

                var modalTitleInput = editNoteModal.querySelector(
                    '#noteTitle');
                var modalDetailsTextarea = editNoteModal.querySelector(
                    '#noteDetails');
                var modalCreatedAtInput = editNoteModal.querySelector(
                    '#noteCreatedAt');
                var modalPublicCheckbox = editNoteModal.querySelector(
                    '#public');

                modalTitleInput.value = noteTitle;
                modalDetailsTextarea.value = noteDetails;
                modalCreatedAtInput.value = noteCreatedAt;
                modalPublicCheckbox.checked = (notePublic == 1);
            });

            document.getElementById('button').addEventListener('click',
                function() {
                    var newNoteModal = new bootstrap.Modal(document
                        .getElementById('editNoteModal'));
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
                                        <input class="form-check-input" type="checkbox" role="switch" id="public" name="public">
                                        <p class="form-check-label bg-transparent" for="public">Public</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-7">
                            <button type="submit" class="btn btn-danger" name="deleteNote">Delete Note</button>
                            <button type="submit" class="btn btn-primary" name="saveChanges">Save
                                changes</button>
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
    <script>
        function truncateText(element, wordLimit) {
            const originalText = element.innerHTML;
            const words = originalText.split(' ');

            if (words.length > wordLimit) {
                const truncatedText = words.slice(0, wordLimit).join(' ') + '...';
                element.innerHTML = truncatedText;
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const messageElement = document.getElementById('message');
            truncateText(messageElement, 20); // Adjust the word limit as needed
        });
    </script>
</body>

</html>