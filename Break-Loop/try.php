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

// -------------------------------------------------
$userHandle = 'tashin19';
$loopName = 'loop1';

$p1DoThis = null;
$p1WantToDoThis = null;

$p2DoThis = null;
$p2WantToDoThis = null;

$p3DoThis = null;
$p3WantToDoThis = null;

// ---------------------------------------- USer clicked helped btn ----------------------------------
$userHandle = 'tashin19';
$feelings = "happy, sad, excited";
$doing = "facebook, insta";

//----------------------------------------->> r1

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
$output = mysqli_fetch_all($result);

// echo ($sql);

//----------------------------------------->> r2  [when r1 is null == no loop select]
// have to print what can feel

if (!empty($output)) {
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
    $output = mysqli_fetch_all($result);

    if (!empty($output)) { // doctor suggestion on basis of feeling

        $feelingsArray = array_map('trim', explode(',', $feelings)); // for__feelings
        $conditions = [];
        foreach ($feelingsArray as $feeling) {
            $conditions[] = "la.do LIKE '%" . $feeling . "%'";
        }

        $sql = "SELECT loopName, do, canDo
                FROM loopname as ln
                INNER JOIN
                loop_activities as la 
                ON ln.no = la.loopNo
                WHERE ln.no = 6
                AND (";

        $sql .= implode(' OR ', $conditions); // feelings
        $sql .= ')';


        // echo ($sql);

        $result = mysqli_query($conn, $sql);
        $output = mysqli_fetch_all($result);
    }
}
// ----------------------------------------------------------------------------------------------------



$userHandle = 'tashin19'; // need to change

// --------------------------------------------All Loops (fetch  2)--------------------------------------------------------

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

// ----------------------------------------------------------------------------------------------------

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kairos</title>
    <!-- CSS Links -->
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</head>

<body class="bg-custom">

    <main class="main bg-white shadow z-0">

        <!------------------------------ Body Segment ------------------------------>
        <div class="row p-4 p-md-5 mb-4">
            <div class="row justify-content-between">
                <h2 class="col-4">Loops</h2>

                <button type="button" class="btn col-2 btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                    Launch demo modal
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

            <!------------------- ALL loops (cards) (New)  tashin ------------------->
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Doctor Suggestion</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="#" class="btn btn-primary">View/Edit Loop</a>
                            <a href="#" class="btn btn-success">Delete Loop</a>
                        </div>
                    </div>
                </div>

                <?php
                foreach ($structuredData as $loopName => $activities) { ?>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"> <?php echo $loopName; ?></h5>

                                <p class="card-text">
                                    <?php
                                    echo "Do: ";
                                    foreach ($activities['do'] as $doItem) {
                                        echo "$doItem ,";
                                    }
                                    echo "\n";   ?>
                                </p>

                                <p class="card-text">
                                    <?php
                                    echo "Can Do: ";
                                    foreach ($activities['canDo'] as $canDoItem) {
                                        echo "$canDoItem ,";
                                    }
                                    echo "\n";
                                    ?>
                                </p>

                                <!-- card btn -->
                                <a href="#" class="btn btn-primary">View/Edit Loop</a>
                                <a href="#" class="btn btn-success">Delete Loop</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!--------------------------------------------------------------------->

        </div>


    </main>
</body>

</html>