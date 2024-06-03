<?php
// connect database
$servername = 'localhost';
$username = 'root';
$password = '';
$databasename = 'Kairos';

$conn = mysqli_connect($servername, $username, $password, $databasename);

// check connection
if (!$conn) {
    exit('Sorry failed to connect: ' . mysqli_connect_error());
}

// ---------------------------------------- USer clicked helped btn ----------------------------------
$userHandle = 'tashin19';

if (isset($_POST['help'])) {

    $feelings = mysqli_real_escape_string($conn, $_POST['feeling']);
    $doing = mysqli_real_escape_string($conn, $_POST['doing']);
    // echo $feelings;
    // echo $doing;

    // ----------------------------------------->> r1

    $feelingsArray = array_map('trim', explode(',', $feelings)); // for__feelings
    $conditions = [];
    foreach ($feelingsArray as $feeling) {
        $conditions[] = "feelings LIKE '%" . $feeling . "%'";
    }

    $doingsArray = array_map('trim', explode(',', $doing));  // for__doings
    $doing_conditions = [];
    foreach ($doingsArray as $ptr) {
        $doing_conditions[] = "la.do LIKE '%" . $ptr . "%'";
    }

    $sql = "SELECT DISTINCT *
        FROM loopname as ln 
        INNER JOIN 
        loop_activities as la 
        ON ln.no = la.loopNo
        WHERE userHandle = '$userHandle' AND  (";

    $sql .= implode(' OR ', $conditions);
    $sql .= ') AND (';

    $sql .= implode(' OR ', $doing_conditions);
    $sql .= ')';

    $result = mysqli_query($conn, $sql);
    $outputs = mysqli_fetch_all($result);

    // echo ($sql);

    // ----------------------------------------->> r2  [when r1 is null == no loop select]
    // have to print what can feel

    if (!empty($outputs)) {
        $sql = "SELECT DISTINCT *
            FROM loopname as ln
            INNER JOIN
            loop_activities as la
            ON ln.no = la.loopNo
            WHERE userHandle = '$userHandle' AND  (";

        $sql .= implode(' OR ', $doing_conditions); // only doing conditions
        $sql .= ')';
        // echo ($sql);

        $result = mysqli_query($conn, $sql);
        $outputs = mysqli_fetch_all($result);
    }
    // doctor

    $feelingsArray = array_map('trim', explode(',', $feelings)); // for__feelings
    $conditions = [];
    foreach ($feelingsArray as $feeling) {
        $conditions[] = "la.do LIKE '%" . $feeling . "%'";
    }

    $sql = 'SELECT loopName, do, canDo
            FROM loopname as ln
            INNER JOIN
            loop_activities as la 
            ON ln.no = la.loopNo
            WHERE ln.no = 6
            AND (';

    $sql .= implode(' OR ', $conditions); // feelings
    $sql .= ')';

    // echo ($sql);

    $result = mysqli_query($conn, $sql);
    $output_doctor = mysqli_fetch_all($result);
    // print_r($output_doctor);
}

// ----------------------------------------------------------------------------------------------------



$userHandle = 'tashin19'; // need to change

// --------------------------------------------All Loops (fetch)--------------------------------------------------------

$sql = "SELECT ln.loopName, la.do, la.canDo
        FROM loopname as ln
        INNER JOIN loop_activities as la
        ON ln.no = la.loopNo
        WHERE userHandle = 'tashin19'
        ORDER BY ln.loopName";

$result = mysqli_query($conn, $sql);
$allloops = mysqli_fetch_all($result, MYSQLI_ASSOC);

$structuredData = [];

foreach ($allloops as $row) {
    $loopName = $row['loopName'];
    $do = $row['do'];
    $canDo = $row['canDo'];

    if (!isset($structuredData[$loopName])) {
        $structuredData[$loopName] = ['do' => [], 'canDo' => []];
    }

    $structuredData[$loopName]['do'][] = $do;
    $structuredData[$loopName]['canDo'][] = $canDo;
}

// echo '<pre>';
// print_r($structuredData);
// echo '</pre>';

// ------------------------Noman---------------- New Loop Create ----------------------------------
if (isset($_POST['createLoop'])) {

    $loopName = mysqli_real_escape_string($conn, $_POST['loopName']);

    $p1DoThis = mysqli_real_escape_string($conn, $_POST['p1DoThis']);
    $p1WantToDoThis = mysqli_real_escape_string($conn, $_POST['p1WantToDoThis']);

    $p2DoThis = mysqli_real_escape_string($conn, $_POST['p2DoThis']);
    $p2WantToDoThis = mysqli_real_escape_string($conn, $_POST['p2WantToDoThis']);

    $p3DoThis = mysqli_real_escape_string($conn, $_POST['p3DoThis']);
    $p3WantToDoThis = mysqli_real_escape_string($conn, $_POST['p3WantToDoThis']);

    // insert
    $sql = "INSERT INTO loopname (no, loopName, userHandle) 
        VALUES (NULL, '$loopName', '$userHandle');";

    mysqli_query($conn, $sql);  // insert Done

    // get loopNo
    $sql = "SELECT no
        FROM loopname
        WHERE loopName = '$loopName' && userHandle = '$userHandle'";

    $result = mysqli_query($conn, $sql);  // insert Done

    $loop = mysqli_fetch_all($result);
    // print_r($loop);

    $loopNo = $loop[0][0]; // main
    // $loopNo = 0;  // remove

    // push loop info
    $sql = "INSERT INTO loop_activities (do, canDo, loopNo) 
        VALUES ('$p1DoThis', '$p1WantToDoThis', '$loopNo'),
               ('$p2DoThis', '$p2WantToDoThis', '$loopNo'),
               ('$p3DoThis', '$p3WantToDoThis', '$loopNo');";

    mysqli_query($conn, $sql);  // insert Done
}


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


/// -------------------- doctor suggestion loop code 
$sql = "SELECT ln.loopName, la.do, la.canDo
        FROM loopname as ln
        INNER JOIN loop_activities as la
        ON ln.no = la.loopNo
        WHERE userHandle = 'doctor1'
        ORDER BY ln.loopName";




$result = mysqli_query($conn, $sql);
$output_doctor_sugg = mysqli_fetch_all($result);

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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBdP7rK64KtK3LQN1z7l5/3pLVKz8Y7D2DdmW/z73aXPx0bB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12qEbdw+Tph2t4z3Ib6WTMC2COBvN1n6QpgYtTL2Awr9dcyB" crossorigin="anonymous">
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
                <div class="col-1 bg-transparent"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">YES</button></div>
                <div class="col-1 bg-transparent"><button type="button" class="btn btn-secondary">NO</button></div>

            </div>
        </div>
        <!------------------------------ Body Segment ------------------------------>

        <div class="row rounded p-4 p-md-5 mb-4 bg-transparent">
            <div class="row justify-content-between bg-transparent">
                <h2 class="col-4 bg-transparent">Loops</h2>


                <button type="button" class="btn col-2 btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal2">

                    Create New loop
                </button>
            </div>
            <hr class="mt-2">

            <!-------------------------------- All Loops view (prev)-------------------------------->
            <!-- <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 bg-transparent">
                <?php
                foreach ($allloops as $loop) {
                    echo '
                    <div class="col bg-transparent">
                        <div class="card shadow-sm bg-transparent">
                            <div class="card-header bg-transparent">' . $loop[0] . '</div>
                            <div class="card-body bg-transparent">
                                <p class="card-text bg-transparent">' . $loop[1] . '</p>
                                <p class="card-text bg-transparent">' . $loop[2] . '</p>
                                <button class="btn btn-danger">Delete Loop</button>
                            </div>
                        </div>
                    </div>
                    ';
                }
                ?>
            </div> -->
            <!-- ------------------------------------ -->

            <!------------------- ALL loops (cards) (New)  tashin ------------------->
            <div class="row bg-white">
                <div class="col-sm-6 bg-white">
                    <div class="card bg-transparent">
                        <div class="card-body bg-transparent">
                            <h5 class="card-title bg-transparent">Doctor Suggestion</h5>
                            <p class="card-text bg-transparent">Feeling : confused, lonely, lonely, tired, unfocused
                                Can DO: take a break, Call a friend or family member, Join a social group or online community, Take a short nap, Go for a walk</p>
                            <a href="#" class="btn btn-primary" style="display: none;">View/Edit Loop</a>
                            <a href="#" class="btn btn-success">Delete Loop</a>
                        </div>
                    </div>
                </div>

                <?php
                foreach ($structuredData as $loopName => $activities) { ?>
                    <div class="col-sm-6 bg-transparent">
                        <div class="card bg-transparent">
                            <div class="card-body bg-transparent">
                                <h5 class="card-title bg-transparent"> <?php echo $loopName; ?></h5>
                                <p class="card-text bg-transparent">
                                    <?php
                                    echo 'Do: ';
                                    foreach ($activities['do'] as $doItem) {
                                        echo "$doItem ,";
                                    }
                                    echo "\n"; ?>
                                </p>

                                <p class="card-text bg-transparent">
                                    <?php
                                    echo 'Can Do: ';
                                    foreach ($activities['canDo'] as $canDoItem) {
                                        echo "$canDoItem ,";
                                    }
                                    echo "\n";
                                    ?>
                                </p>

                                <!-- card btn -->
                                <a href="#" class="btn btn-primary" style="display: none;">View/Edit Loop</a>
                                <a href="#" class="btn btn-success">Delete Loop</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- ------------------------------------------------------------------- -->



        </div>
    </main>

    <!------------------------------ Modal (YES -> Are you procrastinating? wasting time?) ------------------------------>

    <div class="modal fade z-10" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered z-1000">
            <div class="modal-content z-1000">
                <div class="modal-header z-1000">
                    <h1 class="modal-title fs-5 z-1000 bg-transparent" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="break-loop.php" method="post">
                    <div class="modal-body" style="z-index:100">

                        <div class="row mb-3">
                            <label for="input1" class="col-sm-6 col-form-label">What are you feeling?</label>
                            <div class="col-sm-6">
                                <input type="text" name="feeling" id="feeling" class="form-control" id="input1">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input2" class="col-sm-6 col-form-label">Are you doing something?</label>
                            <div class="col-sm-6">
                                <input type="text" name="doing" id="doing" class="form-control" id="input2">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="help" name="help" class="btn btn-primary">Help</button>
                        <!-- <button type="button" id="help" name="help" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal3" onchange="this.form.submit()">Help</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade z-10" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <!-------------- New loop Modal -------------->
        <!---------Noman------------------------------------------>

        <div class="modal-dialog bg-transparent">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 bg-transparent" id="exampleModalLabel2">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="break-loop.php" method="post">
                        <div class="row mb-3">
                            <label for="inputLoopName" class="col-sm-6 col-form-label">Loop Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="inputLoopName" name="loopName">
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">

                            <label class="form-label">Problem-1</label>

                            <div class="row justify-content-center">
                                <div class="form-text">You do this</div>
                                <input type="text" class="col-6 form-control" name="p1DoThis">
                                <div class="form-text">You want to do this</div>
                                <input type="text" class="col-6 form-control" name="p1WantToDoThis">
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">

                            <label class="form-label">Problem-2</label>
                            <div class="row justify-content-center">
                                <div class="form-text">You do this</div>
                                <input type="text" class="col-6 form-control" name="p2DoThis">
                                <div class="form-text">You want to do this</div>
                                <input type="text" class="col-6 form-control" name="p2WantToDoThis">
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3">

                            <label class="form-label">Problem-3</label>
                            <div class="row justify-content-center">
                                <div class="form-text">You do this</div>
                                <input type="text" class="col-6 form-control" name="p3DoThis">
                                <div class="form-text">You want to do this</div>
                                <input type="text" class="col-6 form-control" name="p3WantToDoThis">
                            </div>
                        </div>
                        <hr>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="createLoop" id="createLoop">Create Loop</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade z-10" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-centered z-1000">
            <div class="modal-content z-1000">
                <div class="modal-header z-1000">
                    <h1 class="modal-title fs-5 z-1000 bg-transparent" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>



                <div class="modal-body" style="z-index:100">
                    <?php if (!empty($outputs)) { ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Loop Name</th>
                                    <th scope="col">Feelings</th>
                                    <th scope="col">Do</th>
                                    <th scope="col">Can Do</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                $cnt = 1;
                                foreach ($outputs as $output) { ?>

                                    <tr>
                                        <th scope="row">
                                            <?php echo $cnt; ?>
                                        </th>
                                        <td>
                                            <?php echo htmlspecialchars($output[1]); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($output[3]); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($output[4]); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($output[5]); ?>
                                        </td>
                                    </tr>

                                    <?php ++$cnt; ?>
                                <?php }
                                ?>

                            </tbody>
                        </table>
                    <?php } ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Do</th>
                                <th scope="col">Can Do</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php
                            $cnt = 1;
                            foreach ($output_doctor as $output) { ?>

                                <tr>
                                    <th scope="row">
                                        <?php echo $cnt; ?>
                                    </th>
                                    <td>
                                        <?php echo htmlspecialchars($output[1]); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($output[2]); ?>
                                    </td>
                                </tr>

                                <?php ++$cnt; ?>
                            <?php }
                            ?>

                        </tbody>
                    </table>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Help</button>
                </div> -->
            </div>
        </div>
        <?php if (!empty($output_doctor) || !empty($outputs)) { ?>

            <!-- JavaScript to Open Modal Automatically -->
            <script>
                // Use window.onload to execute code when the page finishes loading
                window.onload = function() {
                    // Select the modal element by its ID
                    var modal = document.getElementById("exampleModal3");
                    // Create a new Bootstrap modal instance
                    var modalInstance = new bootstrap.Modal(modal);
                    // Open the modal
                    modalInstance.show();
                };
            </script>

        <?php } ?>


    </div>

</body>

</html>