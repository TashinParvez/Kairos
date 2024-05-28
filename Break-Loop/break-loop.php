<?php
// connect database
$servername = 'localhost';
$username = 'root';
$password = '';
$databasename = 'Kairos';

$conn = mysqli_connect($servername, $username, $password, $databasename);

// check connection
if (!$conn) {
    exit('Sorry failed to connect: '.mysqli_connect_error());
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

// ---------------------------------------- New Loop Create ----------------------------------

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../Includes/style.css">
</head>

<body class="bg-custom">
    <?php
    include '../Includes/NavBarSecond.php'; // uncomment
include '../Includes/Sidebar.php'; // uncomment
include '../Includes/HappyJar.php'; // uncomment
?>
    <style>
    * {

        background-color: ;
    }

    .bg-custom {
        background-color: #f1f4fb;
    }

    @import url("https://fonts.googleapis.com/css2?family=Reddit+Mono:wght@200..900&display=swap");

    .wrapper {
        display: flex;
    }

    .wrapper .static-txt {
        color: black;
        font-size: 60px;
        font-weight: 400;
    }

    .wrapper .dynamic-txts {
        margin-left: 5px;
        height: 90px;
        line-height: 90px;
        overflow: hidden;
    }

    .dynamic-txts li {
        list-style: none;
        color: #FC6D6D;
        font-size: 65px;
        font-weight: 500;
        position: relative;
        top: 0;
        animation: slide 12s steps(4) infinite;
    }

    @keyframes slide {
        100% {
            top: -360px;
        }
    }

    .dynamic-txts li span {
        position: relative;
        margin: 5px 0;
        line-height: 90px;
    }

    .dynamic-txts li span::after {
        content: "";
        position: absolute;
        left: 0;
        height: 150%;
        width: 100%;
        background: white;
        border-left: 2px solid #FC6D6D;
        animation: typing 3s steps(10) infinite;
    }

    @keyframes typing {

        40%,
        60% {
            left: calc(100% + 30px);
        }

        100% {
            left: 0;
        }
    }

    .main {
        z-index: 1;
        /* Ensure the main content is at a lower z-index */
    }

    .modal-backdrop {
        z-index: 1050;
        /* Ensure the backdrop is at a high z-index */
    }

    .modal {
        z-index: 1060;
        /* Ensure the modal itself is higher */
    }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9gybBdP7rK64KtK3LQN1z7l5/3pLVKz8Y7D2DdmW/z73aXPx0bB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12qEbdw+Tph2t4z3Ib6WTMC2COBvN1n6QpgYtTL2Awr9dcyB" crossorigin="anonymous">
    </script>
    <main class="main bg-white shadow">
        <!------------------------------ head Segment ------------------------------>
        <div class="row p-4 p-md-5 mb-4 rounded text-bg-secondary justify-content-center z-8 bg-transparent">
            <div class="wrapper bg-transparent">
                <div class="static-txt bg-transparent">Are you</div>
                <ul class="dynamic-txts bg-transparent">
                    <li class="bg-transparent"><span class="bg-transparent">procrastinating?</span></li>
                    <li class="bg-transparent"><span class="bg-transparent">wasting time?</span></li>
                    <li class="bg-transparent"><span class="bg-transparent">in a loop?</span></li>
                    <li class="bg-transparent"><span class="bg-transparent">getting distracted?</span></li>
                </ul>
            </div>
            <div class="row bg-transparent">
                <div class="col-1 bg-transparent"><button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">YES</button></div>
                <div class="col-1 bg-transparent"><button type="button" class="btn btn-secondary">NO</button></div>

            </div>
        </div>
        <!------------------------------ Body Segment ------------------------------>

        <div class="row rounded p-4 p-md-5 mb-4 bg-transparent">
            <div class="row justify-content-between bg-transparent">
                <h2 class="col-4 bg-transparent">Loops</h2>

                <button type="button" class="btn col-2 btn-secondary" data-bs-toggle="modal"
                    data-bs-target="#exampleModal2">
                    Create New loop
                </button>
            </div>
            <hr class="mt-2">
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 bg-transparent">
                <?php
            foreach ($allloops as $loop) {
                echo '
                    <div class="col bg-transparent">
                        <div class="card shadow-sm bg-transparent">
                            <div class="card-header bg-transparent">'.$loop[0].'</div>
                            <div class="card-body bg-transparent">
                                <p class="card-text bg-transparent">'.$loop[1].'</p>
                                <p class="card-text bg-transparent">'.$loop[2].'</p>
                                <button class="btn btn-danger">Delete Loop</button>
                            </div>
                        </div>
                    </div>
                    ';
            }
?>
            </div>
        </div>

    </main>
    <!------------------------------ Modal (YES) ------------------------------>
    <div class="modal fade z-10" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered z-1000">
            <div class="modal-content z-1000">
                <div class="modal-header z-1000">
                    <h1 class="modal-title fs-5 z-1000 bg-transparent" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="z-index:100">
                    <form>
                        <div class="row mb-3">
                            <label for="input1" class="col-sm-6 col-form-label">What are you feeling?</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="input1">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input2" class="col-sm-6 col-form-label">Are you doing something?</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="input2">
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
    <div class="modal fade z-10" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2"
        aria-hidden="true">
        <!-------------- New loop Modal -------------->
        <!--------------------------------------------------->
        <div class="modal-dialog bg-transparent">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 bg-transparent" id="exampleModalLabel2">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <label for="inputLoopName" class="col-sm-6 col-form-label">Loop Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="inputLoopName">
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Problem-1</label>
                            <div class="row justify-content-center">
                                <div class="form-text">You do this</div>
                                <input type="text" class="col-6 form-control">
                                <div class="form-text">You want to do this</div>
                                <input type="text" class="col-6 form-control">
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Problem-2</label>
                            <div class="row justify-content-center">
                                <div class="form-text">You do this</div>
                                <input type="text" class="col-6 form-control">
                                <div class="form-text">You want to do this</div>
                                <input type="text" class="col-6 form-control">
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Problem-3</label>
                            <div class="row justify-content-center">
                                <div class="form-text">You do this</div>
                                <input type="text" class="col-6 form-control">
                                <div class="form-text">You want to do this</div>
                                <input type="text" class="col-6 form-control">
                            </div>
                        </div>
                        <hr>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create Loop</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>