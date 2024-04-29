<?php

include('../Dashboard/connect_db.php'); // Daatabase connection
$currentDateTimeObject = new DateTime();
$todaysDate = $currentDateTimeObject->format('d/m/Y'); // today's date
// echo "Today's date is: " . $todaysDate;
$time = $currentDateTimeObject->format('H:i:s');

//.......*** Create Goal ***...........
$goalName = $startDate = $endDate = '';
$errors = array('goalName' => '', 'startDate' => '', 'endDate' => '');

if (isset($_POST['createGoal'])) {

    //................ Retrieve all data from input field & escape sql chars ...............
    $userHandle = mysqli_real_escape_string($conn, $_GET['userHandle']);
    $goalName = mysqli_real_escape_string($conn, $_POST['goalName']);
    $startDate = mysqli_real_escape_string($conn, $_POST['startDate']);
    $endDate = mysqli_real_escape_string($conn, $_POST['startDate']);

    //.............. All input field validation checking ...................
    // check goal name
    if (empty($goalName)) {
        $errors['goalName'] = 'This field cannot be empty!';
    }

    // check start date
    if (empty($startDate)) {
        $errors['startDate'] = 'This field cannot be empty!';
    }
    // check end date
    if (empty($endDate)) {
        $errors['endDate'] = 'This field cannot be empty!';
    }

    if (!array_filter($errors)) {

        // create sql
        $sql = "INSERT INTO goals(userHandle, goalName, startDate, endDate)
                VALUES('$userHandle', '$goalName', STR_TO_DATE('$startDate', '%d/%m/%Y'), STR_TO_DATE('$endDate', '%d/%m/%Y'))";

        // save to db and check
        if (mysqli_query($conn, $sql)) {
            // success
            header('Location: goals.php');
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }

        // close connection
        mysqli_close($conn);
    }
}

//.......*** If a goal is completed ***...........
if (isset($_POST['completed'])) {

    //................ Retrieve all data from input field & escape sql chars ...............
    $userHandle = mysqli_real_escape_string($conn, $_GET['userHandle']);
    $goalName = mysqli_real_escape_string($conn, $_POST['goalName']);

    // create sql
    $sql = "UPDATE goals SET status = 1
    WHERE userHandle = '$userHandle' AND goalName = '$goalName'";

    // save to db and check
    if (mysqli_query($conn, $sql)) {
        // success
        header('Location: goals.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }

    // close connection
    mysqli_close($conn);
}


//.......*** Page count ***...........
if (isset($_POST['counterPlus'])) {

    $userHandle = mysqli_real_escape_string($conn, $_GET['userHandle']);

    $sql = "UPDATE page_count
            SET dailyCount = dailyCount+1
            WHERE userHandle = '$userHandle'";

    // save to db and check
    if (mysqli_query($conn, $sql)) {
        // success
        header('Location: goals.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }

    // close connection
    mysqli_close($conn);
}

if (isset($_POST['counterMinus'])) {

    $userHandle = mysqli_real_escape_string($conn, $_GET['userHandle']);

    $sql = "UPDATE page_count
            SET dailyCount = dailyCount-1
            WHERE userHandle = '$userHandle'";

    // save to db and check
    if (mysqli_query($conn, $sql)) {
        // success
        header('Location: goals.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }

    // close connection
    mysqli_close($conn);
}


//.......*** Generally work for Goal page ***...........
if (isset($_GET['userHandle'])) {

    $userHandle = mysqli_real_escape_string($conn, $_GET['userHandle']);

    //............. Page count reset ............
    if ($time > '06:00:00') {
        $sql = "SELECT DATE_FORMAT(todaysDate, '%d/%m/%Y') AS todaysDate
                FROM page_count
                WHERE userHandle = '$userHandle'";

        $result =  mysqli_query($conn, $sql);  // get query result
        $tempDate = mysqli_fetch_assoc($result); // conver to array

        if ($todaysDate !== $tempDate['todaysDate']) {
            $sql = "UPDATE page_count
                    SET todaysDate = '$todaysDate', totalCount = totalCount + dailyCount, dailyCount = 0
                    WHERE userHandle = '$userHandle'";

            // save to db and check
            if (mysqli_query($conn, $sql)) {
                // success
                header('Location: goals.php');
            } else {
                echo 'query error: ' . mysqli_error($conn);
            }

            // close connection
            mysqli_close($conn);
        }
    }


    //.......... Goals exceeded deadline .......
    $sql = "SELECT goalName, DATE_FORMAT(startDate, '%d/%m/%Y'), DATE_FORMAT(endDate, '%d/%m/%Y')
            FROM goals
            WHERE userHandle = '$userHandle' AND status = 0 AND endDate < '$todaysDate'";

    $result =  mysqli_query($conn, $sql);  // get query result
    $goalsExceededDeadline = mysqli_fetch_all($result); // conver to array

    //.......... Goals within deadline .........
    $sql = "SELECT goalName, DATE_FORMAT(startDate, '%d/%m/%Y'), DATE_FORMAT(endDate, '%d/%m/%Y')
            FROM goals
            WHERE userHandle = '$userHandle' AND status = 0 AND endDate > '$todaysDate'";

    $result =  mysqli_query($conn, $sql);  // get query result
    $goals = mysqli_fetch_all($result); // conver to array

    mysqli_free_result($result); // for memory free
    mysqli_close($conn); // close connection
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSS -->
    <style>
        .btn-primary {
            position-fixed:
        }
    </style>

    <!-- JD -->
    <script>
        window.addEventListener('scroll', function() {
            console.log('Scrolling...');
            var goalButton = document.getElementById('goalButton');
            console.log('Scroll Y:', window.scrollY);
            if (window.scrollY > 100) {
                goalButton.style.display = 'none';
            } else {
                goalButton.style.display = 'block';
            }
        });
    </script>

    <!-- <link rel="stylesheet" href="../Includes/style.css"> -->
    <!-- uncomment -->

</head>

<body>
    <?php
    include('../Includes/NavBar.php'); // uncomment
    include('../Includes/Sidebar.php'); // uncomment
    ?>


    <!-- ------------------------ Main Segment ------------------------------- -->

    <main class="main shadow">

        <div class="container text-center">
            <div class="row align-items-stretch">
                <div class="col-9">
                    1 of 2
                    1 of 2
                    1 of 2
                    1 of 2
                    1 of 2
                    1 of 2
                    1 of 2
                    1 of 2


                </div>
                <div class="col" style="height: 15vh; overflow-y: auto;">
                    2 of 2
                    2 of 2
                    2 of 2
                </div>
            </div>

            <div class="container text-center">
                <div class="row align-items-end">
                    <!-- time exceded goals -->
                    <?php
                    // loop starts here
                    foreach ($goals as $goal) {
                    ?>
                        <div class="card mb-1" style="background: snow;">
                            <div class="card-body">
                                <!-- each goal -->

                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="row align-items-end">
                    <div class="row align-items-end">
                        <!-- create -->
                    </div>

                    <div class="row align-items-end">
                        <!-- show goals -->
                        <?php
                        // loop starts here
                        foreach ($goals as $goal) {
                        ?>
                            <div class="card mb-1" style="background: snow;">
                                <div class="card-body">
                                    <!-- each goal -->

                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Plus icon for creating a goal -->
    <div id="goalButton" class="position-fixed bottom-0 end-0 mb-4 me-4"> <!-- Position the button at the bottom right with some margin -->
        <button class="btn btn-primary rounded-circle shadow" type="button">
            <i class="fas fa-plus"></i>
        </button>
    </div>





</body>

</html>