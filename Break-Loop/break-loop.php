<?php
// connect database
$servername = 'localhost';
$username = 'root';
$password = '';
$databasename = 'Kairos';


$conn = mysqli_connect($servername, $username, $password, $databasename);

// check connection
if (!$conn) {
    die("Sorry failed to connect: " . mysqli_connect_error());
}

$userHandle = 'tashin19'; // need to change

// ---------------------------------------- All Loops (fetch) ----------------------------------

$sql = "SELECT ln.loopName, la.do, la.canDo
        FROM loopname as ln
        INNER JOIN
        loop_activities as la
        ON ln.no = la.loopNo
        WHERE userHandle = '$userHandle'
        ORDER BY ln.loopName;";

$result = mysqli_query($conn, $sql);  // insert Done
$allloops = mysqli_fetch_all($result);

// foreach ($loop as $ptr) {
//     print_r($ptr);
//     echo "\r\n";
// }



// ---------------------------------------- New Loop Creat ----------------------------------


$loopName = 'loop1';

$p1DoThis = null;
$p1WantToDoThis = null;

$p2DoThis = null;
$p2WantToDoThis = null;

$p3DoThis = null;
$p3WantToDoThis = null;

// insert 
$sql = "INSERT INTO loopname (no, loopName, userHandle) 
        VALUES (NULL, '$loopName', '$userHandle');";

// mysqli_query($conn, $sql);  // insert Done

// get loopNo
$sql = "SELECT no
        FROM loopname
        WHERE loopName = '$loopName' && userHandle = '$userHandle'";

// $result = mysqli_query($conn, $sql);  // insert Done

// $loop = mysqli_fetch_all($result);
// print_r($loop);

// $loopNo = $loop[0][0]; // main
$loopNo = 0;  // remove

// push loop info
$sql = "INSERT INTO loop_activities (do, canDo, loopNo) 
        VALUES ('$p1DoThis', '$p1WantToDoThis', '$loopNo'),
               ('$p2DoThis', '$p2WantToDoThis', '$loopNo'),
               ('$p3DoThis', '$p3WantToDoThis', '$loopNo');";

// mysqli_query($conn, $sql);  // insert Done



// ---------------------------------------- DELETE Loops ----------------------------------
// get loop no
$sql = "SELECT NO
        FROM loopname
        WHERE userHandle ='$userHandle' && loopName ='$loopName';";

// $result = mysqli_query($conn, $sql);  // insert Done

// $loop = mysqli_fetch_all($result);
// $loopNo = $loop[0][0]; // main
$loopNo = 4; // delete

$sql = "DELETE FROM loop_activities
        WHERE loopNo = $loopNo";

// mysqli_query($conn, $sql);  // delete do/canDo

$sql = "DELETE FROM loopname
        WHERE no = $loopNo && userHandle = '$userHandle'";

// mysqli_query($conn, $sql);  // delete loop name



?>

<!--===========================================================-->
<!--======================= PHP END ===========================-->
<!--===========================================================-->

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

<body class="bg-custom">
    <?php
    include('../Includes/NavBarSecond.php'); // uncomment
    include('../Includes/Sidebar.php'); // uncomment
    include('../Includes/HappyJar.php'); // uncomment
    ?>


    <main class="main bg-white shadow z-0">
        <!------------------------------ head Segment ------------------------------>
        <div class="row p-4 p-md-5 mb-4 rounded text-bg-secondary justify-content-center">
            <div class="col-10 text-bg-secondary d-flex flex-column ">
                <h1 class="display-6 fst-italic text-bg-secondary">
                    Are you <b class="text-bg-secondary">Procrastinating</b> ? <br>
                    wasting your <b class="text-bg-secondary">Time</b> ?<br>
                    are you in a <b class="text-bg-secondary">Loop</b> ?
                </h1>
            </div>
            <div class="tashin col-2 text-bg-secondary d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#exampleModal">YES</button>
                <button type="button" class="btn btn-success">NO</button>
            </div>


        </div>
        <!------------------------------ Modal (YES) ------------------------------>
        <div class="modal fade modal-dialog modal-dialog-centered modal-dialog-scrollable" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row mb-3">
                                <label for="input1" class="col-sm-6 col-form-label">What are you feeling?</label>
                                <div class="col-sm-6">
                                    <input type="" class="form-control" id="input1">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="input2" class="col-sm-6 col-form-label">Are you doing something?</label>
                                <div class="col-sm-6">
                                    <input type="" class="form-control" id="input2">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Help</button>
                    </div>
                </div>
            </div>
        </div>

        <!------------------------------ Body Segment ------------------------------>
        <div class="row rounded p-4 p-md-5 mb-4">
            <div class="row justify-content-between">
                <h2 class="col-4">Loops</h2>

                <button type="button" class="btn col-2 btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                    Create New loop
                </button>

                <!-------------- New loop Modal -------------->
                <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel2">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row mb-3">
                                        <label for="input1" class="col-sm-6 col-form-label">Loop Name</label>
                                        <div class="col-sm-6">
                                            <input type="" class="form-control" id="input1">
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- ------------------ -->
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Problem-1</label>
                                        <div class="row justify-content-center">

                                            <div id="emailHelp" class="form-text">You do this</div>
                                            <input type="text" class="col-6 form-control" id="" aria-describedby="">

                                            <div id="emailHelp" class="form-text">You want to do this</div>
                                            <input type="text" class="col-6 form-control" id="" aria-describedby="">

                                        </div>
                                    </div>
                                    <hr>
                                    <!-- ------------------ -->

                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Problem-2</label>
                                        <div class="row justify-content-center">

                                            <div id="emailHelp" class="form-text">You do this</div>
                                            <input type="text" class="col-6 form-control" id="" aria-describedby="">

                                            <div id="emailHelp" class="form-text">You want to do this</div>
                                            <input type="text" class="col-6 form-control" id="" aria-describedby="">

                                        </div>
                                    </div>
                                    <hr>
                                    <!-- ------------------ -->

                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Problem-2</label>
                                        <div class="row justify-content-center">

                                            <div id="emailHelp" class="form-text">You do this</div>
                                            <input type="text" class="col-6 form-control" id="" aria-describedby="">

                                            <div id="emailHelp" class="form-text">You want to do this</div>
                                            <input type="text" class="col-6 form-control" id="" aria-describedby="">

                                        </div>
                                    </div>
                                    <!-- ------------------ -->

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <hr>

            <!------------------- cards ------------------->
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Doctor Suggestion</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>

                            <div class="row justify-content-center">
                                <button type="button" class="col-4 me-2 btn btn-primary">View/Update</button>
                                <button type="button" class="col-4 btn btn-success">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Loop-1</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>

                            <div class="row justify-content-center">
                                <button type="button" class="col-4 me-2 btn btn-primary">View/Update</button>
                                <button type="button" class="col-4 btn btn-success">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ------------------------------------------------------------------- -->
    </main>
</body>

</html>