<!--Insert Your PHP Here-->
<?php

include('../Dashboard/connect_db.php'); // database connection

$labels  =  null;
$userHandle = null;
$errors = array('title&details' => '');

// check get request userHandle 
if (isset($_GET['userHandle'])) {

    $userHandle = mysqli_real_escape_string($conn, $_GET['userHandle']);

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



    // for memory free
    mysqli_free_result($resultantLabel);
    mysqli_close($conn);
} else {  // full else remove after adding login 

    $userHandle = mysqli_real_escape_string($conn, 'tashin19');
    $sql = "SELECT p.title, p.details,
                CASE
                    WHEN TIMESTAMPDIFF(HOUR, p.lastUpdate, NOW()) >= 1  THEN CONCAT(TIMESTAMPDIFF(HOUR, created_at, NOW()), ' hour(s) ago')
                    ELSE CONCAT(TIMESTAMPDIFF(MINUTE, p.lastUpdate, NOW()), ' minute(s) ago')
                END AS time_ago 
            FROM personal_journal as p 
            WHERE saved = 1 AND DATE(created_at) = DATE(now()) AND
            userHandle = '$userHandle'
            ORDER BY created_at DESC;";

    $resultantLabel =  mysqli_query($conn, $sql);  // get query result

    $todaysSlices = mysqli_fetch_all($resultantLabel); // conver to array

    // print_r($todaysSlices);


    // foreach ($todaysSlices as $slice) {
    //     print_r($slice);
    //     echo '<br>';
    // }


    // for memory free
    mysqli_free_result($resultantLabel);
}

//--------------- add new Slice --------------------

if (isset($_POST['save']) || isset($_POST['newSlice'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);

    if (empty($title) && empty($details)) {
        $errors['title&details'] = 'At least Have to fill one'; // can't save
    }

    if (!array_filter($errors)) {

        $sql = "INSERT INTO personal_journal(userHandle, title, details, saved)
                VALUES('tashin19','$title', '$details', 1)";

        // save to db and check
        if (mysqli_query($conn, $sql)) {
            header('Location: #');
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
    }
}

$today = date("F j, Y", strtotime("today"));  // today's date
// echo "Today's date is: " . $today;

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kairos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    </link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../Includes/style.css">

</head>

<body>

    <?php
    include('../Includes/NavBar.php');
    include('../Includes/Sidebar.php');
    ?>

    <!-- ------------------------ Main Segment ------------------------------- -->

    <main class="main shadow">
        <div class="container">
        <div class="row bg-white">
            <div class="col-sm-6 bg-white">
                <!--Write Your Page Name Here-->
                <h1>Daily Reflection</h1>
            </div>
            <div class="col-sm-4 bg-transparent"></div>
            <div class="col-sm-auto bg-white">
                <div class="container-fluid bg-white p-2 align-items-right">
                    <form action="">
                        <input type="search" required>
                        <i class="fa fa-search"></i>
                        <span id="search-txt">Search</span>
                        <a-main href="javascript:void(0)" id="clear-btn"></a-main>
                    </form>
                </div>
            </div>
        </div>
        <!--You Start Writing Content Here-->
        <div class="bg-white">

            <div class="container-fluid">
                <div class="row">
                    <h4 class="bg-white text-center"></h4>
                </div>
                <hr class="m-0">

                <div class="row">
                    <!-- Left Column: Item Comparison -->
                    <div class="col-md-6 border-end">
                        <h3 class="text-center">Positives Recap</h3>
                        <div class="row align-items-center">
                            <label for="goodthing1" class="col-sm-2 col-form-label">1.</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="goodthing1">
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <label for="goodthing2" class="col-sm-2 col-form-label">2.</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="goodthing2">
                            </div>
                        </div>
                        <hr class="d-md-none">
                    </div>

                    <!-- Right Column: Item Comparison -->
                    <div class="col-md-6 border-end">
                        <h3 class="text-center">Regrettable Moments</h3>
                        <div class="row align-items-center">
                            <label for="badthing1" class="col-sm-2 col-form-label">1.</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="badthing1">
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <label for="badthing2" class="col-sm-2 col-form-label">2.</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="badthing2">
                            </div>
                        </div>
                        <hr class="d-md-none">
                    </div>
                </div>

            </div>

            <!------------------ New Note Segment ------------------>

            <div class="container pt-3">
                <form action="Personal-Journal.php" method="POST">

                    <div class="row justify-content-around">
                        <div class="col">
                            <h4 class="bg-white">Today's Slice — <span class="" style="color: gray;"><?php echo '@' . $today; ?></span></h4>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-outline-secondary"><a href="#todaysSlices" style="text-decoration: none; color: inherit;">Today's All Slice</a> </button>
                            <button type="button" class="btn btn-outline-secondary" type="submit" name="newSlice">New Slice</button>
                            <button type="button" class="btn btn-outline-secondary" type="submit" name="save">Save</button>
                        </div>
                    </div>
                    <hr class="m-0">

                    <div class="container">
                        <div class="row">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="title"></textarea>
                                <label for="floatingTextarea">Title</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="details" style="height: 40vh"></textarea>
                                <label for="floatingTextarea2">Details</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


            <!------------------ Todays All Note Segment ------------------>

            <div class="container pt-3">
                <div class="row justify-content-around">
                    <div class="col">
                        <h4 class="bg-white" id="todaysSlices"><?php echo $today; ?> Slices</h4>
                    </div>
                </div>
                <hr class="m-0">

                <div class="container">
                    <!-- FOReach Loop -->

                    <?php
                    foreach ($todaysSlices as $slice) { ?>

                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                        <?php echo htmlspecialchars($slice[0]); ?>
                                        <span class="align-items-end">
                                            <?php echo htmlspecialchars($slice[2]); ?>
                                        </span>
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <?php echo htmlspecialchars($slice[1]); ?>
                                        <button type="button" class="btn btn-outline-secondary">Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    <!--  -->
                </div>


            </div>

            <!-- END -->
        </div>
        </div>
    </main>


    <!-------------------------- To Add Any Script, Add Here -------------------------->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        const clearInput = () => {
            const input = document.getElementsByTagName("input")[0];
            input.value = "";
        }
        const clearBtn = document.getElementById("clear-btn");
        clearBtn.addEventListener("click", clearInput);
    </script>
</body>

</html>