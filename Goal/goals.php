<?php

include('../Dashboard/connect_db.php'); // Daatabase connection
$currentDateTimeObject = new DateTime();
$todaysDate = $currentDateTimeObject->format('d/m/Y'); // today's date
// echo "Today's date is: " . $todaysDate;
$time = $currentDateTimeObject->format('H:i:s');

//.......*** Create Goal ***...........
$goalName = $startDate = $endDate = '';
$errors = array('goalName' => '', 'endDate' => '');

if (isset($_POST['createGoal'])) {

    //................ Retrieve all data from input field & escape sql chars ...............
    $userHandle = mysqli_real_escape_string($conn, $_GET['userHandle']);
    $goalName = mysqli_real_escape_string($conn, $_POST['goalName']);
    $endDate = mysqli_real_escape_string($conn, $_POST['startDate']);  // need to read 

    //.............. All input field validation checking ...................
    // check goal name
    if (empty($goalName)) {
        $errors['goalName'] = 'This field cannot be empty!';
    }


    // check end date
    if (empty($endDate)) {
        $errors['endDate'] = 'This field cannot be empty!';
    }

    if (!array_filter($errors)) {

        // create sql 
        $sql = "INSERT INTO `goals` (`userHandle`, `goalName`, `startDate`, `endDate`) 
                VALUES ('$userHandle', '$goalName', current_timestamp(), STR_TO_DATE('$endDate', '%d/%m/%Y'));";

        // save to db and check
        if (mysqli_query($conn, $sql)) {
            header('Location: goals.php');
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
    }
}

//.......*** If a goal completed button clicked ***...........

if (isset($_POST['completed'])) {

    //................ Retrieve all data from input field & escape sql chars ...............
    $userHandle = mysqli_real_escape_string($conn, $_GET['userHandle']);
    $goalName = mysqli_real_escape_string($conn, $_POST['goalName']);

    // create sql
    $sql = "UPDATE goals 
            SET status = 1
            WHERE userHandle = '$userHandle' AND goalName = '$goalName'";

    // save to db and check
    if (mysqli_query($conn, $sql)) {
        // success
        header('Location: goals.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }
}


//.......*** Page counter ***...........
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
}


//.......*** Generally work for Goal page ***...........

$goalsThatTimeRemains = "";

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
        }
    }



    //  For 3 types of table 

    //.......... Finished Goals  .......
    $sql = "SELECT goalName, DATE_FORMAT(startDate, '%d/%m/%Y'), DATE_FORMAT(endDate, '%d/%m/%Y'), DATE_FORMAT(completedDate, '%d/%m/%Y')
            FROM goals
            WHERE userHandle = '$userHandle' AND status = 1";

    $result =  mysqli_query($conn, $sql);  // get query result
    $finishedGoals = mysqli_fetch_all($result); // conver to array

    /*
        UPDATE goals
        SET status = 1, completedDate = current_timestamp()
        WHERE userHandle = 'tashin19' && goalName = 'Build CV'
    */

    //.......... Goals exceeded deadline .......
    $sql = "SELECT goalName, 
            DATE_FORMAT(startDate, '%d/%m/%Y') AS formatted_StartDate, 
            DATE_FORMAT(endDate, '%d/%m/%Y') AS formatted_EndDate,
            DATEDIFF(CURRENT_DATE(), endDate) AS Overdue
            FROM goals
            WHERE userHandle = '$userHandle' AND status = 0 AND endDate < current_timestamp()
            ORDER BY Overdue DESC";

    $result =  mysqli_query($conn, $sql);
    $goalsExceededDeadline = mysqli_fetch_all($result); // conver to array


    //.......... Goals within deadline / Goals in hand .........

    $sql = "SELECT goalName, 
                   DATE_FORMAT(startDate, '%d/%m/%Y') AS formatted_StartDate, 
                   DATE_FORMAT(endDate, '%d/%m/%Y') AS formatted_EndDate,
                   DATEDIFF(endDate, CURRENT_DATE()) AS daysRemaining
            FROM goals
            WHERE userHandle = '$userHandle'
                  AND status = 0 
                  AND endDate >= CURRENT_DATE()
            ORDER BY DATEDIFF(endDate, CURRENT_DATE());";

    $result =  mysqli_query($conn, $sql);
    $goalsThatTimeRemains = mysqli_fetch_all($result); // conver to array


    mysqli_free_result($result);
} else {

    $userHandle = 'tashin19';
    // $userHandle = 'liza';


    //  For 3 types of table 

    //.......... Finished Goals  .......
    $sql = "SELECT goalName, DATE_FORMAT(startDate, '%d/%m/%Y'), DATE_FORMAT(endDate, '%d/%m/%Y'), DATE_FORMAT(completedDate, '%d/%m/%Y')
            FROM goals
            WHERE userHandle = '$userHandle' AND status = 1";

    $result =  mysqli_query($conn, $sql);  // get query result
    $finishedGoals = mysqli_fetch_all($result); // conver to array

    /*
        UPDATE goals
        SET status = 1, completedDate = current_timestamp()
        WHERE userHandle = 'tashin19' && goalName = 'Build CV'
    */

    //.......... Goals exceeded deadline .......
    $sql = "SELECT goalName, 
            DATE_FORMAT(startDate, '%d/%m/%Y') AS formatted_StartDate, 
            DATE_FORMAT(endDate, '%d/%m/%Y') AS formatted_EndDate,
            DATEDIFF(CURRENT_DATE(), endDate) AS Overdue
            FROM goals
            WHERE userHandle = '$userHandle' AND status = 0 AND endDate < current_timestamp()
            ORDER BY Overdue DESC";

    $result =  mysqli_query($conn, $sql);
    $goalsExceededDeadline = mysqli_fetch_all($result); // conver to array


    //.......... Goals within deadline / Goals in hand .........

    $sql = "SELECT goalName, 
                   DATE_FORMAT(startDate, '%d/%m/%Y') AS formatted_StartDate, 
                   DATE_FORMAT(endDate, '%d/%m/%Y') AS formatted_EndDate,
                   DATEDIFF(endDate, CURRENT_DATE()) AS daysRemaining
            FROM goals
            WHERE userHandle = '$userHandle'
                  AND status = 0 
                  AND endDate >= CURRENT_DATE()
            ORDER BY DATEDIFF(endDate, CURRENT_DATE());";

    $result =  mysqli_query($conn, $sql);
    $goalsThatTimeRemains = mysqli_fetch_all($result); // conver to array



    //--------------------------------     FOR Life progress bar     --------------------------------

    // year
    $currentDayOfYear = date('z') + 1;
    $totalDaysOfYear = date('L') ? 366 : 365;
    $percentagePassed = floor(($currentDayOfYear / $totalDaysOfYear) * 100);
    // echo "Percentage of year passed: " . $percentagePassed . "% <br>";

    // month
    $currentDayOfMonth = date('j');
    $totalDaysOfMonth = date('t');
    $percentagePassedMonth = floor(($currentDayOfMonth / $totalDaysOfMonth) * 100);
    // echo "Percentage of month passed: " . $percentagePassedMonth . "% <br>";

    // week
    $currentDayOfWeek = date('w');
    $totalDaysOfWeek = 7;
    $percentagePassedWeek = floor(($currentDayOfWeek / $totalDaysOfWeek) * 100);
    // echo "Percentage of week passed: " . $percentagePassedWeek . "%<br>";

    // day 
    $currentHourOfDay = date('G');
    $totalHoursOfDay = 24;
    $percentagePassedDay = floor(($currentHourOfDay / $totalHoursOfDay) * 100);
    // echo "Percentage of day passed: " . $percentagePassedDay . "%<br>";

    // change code dob in place of join date [Tashin]
    $sql = "SELECT joinDate,
            TIMESTAMPDIFF(YEAR, joinDate, CURDATE()) AS age,
            FLOOR((TIMESTAMPDIFF(YEAR, joinDate, CURDATE()) / 73) * 100) AS percentage_lived
            FROM  user_info
            WHERE userHandle = '$userHandle';";

    $result =  mysqli_query($conn, $sql);
    $life = mysqli_fetch_all($result);


    mysqli_free_result($result);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goals</title>


    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->

    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />

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
        <div class="stat">
            <!-- Some Charts here -->
        </div>

        <div class="row">
            <div class="col-8">
                <div class="container">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                                    Finished
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">

                                    <?php
                                    if (empty($finishedGoals)) {
                                        echo "You Haven't finished your any Goal";
                                    } else { ?>

                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Goal</th>
                                                    <th scope="col">Completed Date</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-group-divider">
                                                <?php
                                                $cnt = 1;
                                                foreach ($finishedGoals as $goal) { ?>
                                                    <tr>
                                                        <th scope="row">
                                                            <?php echo  $cnt; ?>
                                                        </th>
                                                        <td>
                                                            <?php echo htmlspecialchars($goal[0]); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlspecialchars($goal[3]); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo "Finished"; ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $cnt++;
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
                                    Overdue Tasks
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body">

                                    <?php
                                    if (empty($goalsThatTimeRemains)) {
                                        echo "You don't have any Goals remain";
                                    } else { ?>

                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Goal</th>
                                                    <th scope="col">Date to finished</th>
                                                    <th scope="col">Overdue</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-group-divider">
                                                <?php
                                                $cnt = 1;
                                                foreach ($goalsExceededDeadline as $goal) { ?>
                                                    <tr>
                                                        <th scope="row">
                                                            <?php echo  $cnt; ?>
                                                        </th>
                                                        <td>
                                                            <?php echo htmlspecialchars($goal[0]); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlspecialchars($goal[2]); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlspecialchars($goal[3]); ?>
                                                        </td>
                                                        <td>
                                                            <button type="button">
                                                                <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php $cnt++; ?>
                                                <?php }
                                                ?>

                                            </tbody>
                                        </table>

                                    <?php }
                                    ?>

                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <!-- Have time -->
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true" aria-controls="panelsStayOpen-collapseThree">
                                    Scheduled Tasks
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body">

                                    <?php
                                    if (empty($goalsThatTimeRemains)) {
                                        echo "You don't have any Goals remain";
                                    } else { ?>

                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Goal</th>
                                                    <th scope="col">Date to finished</th>
                                                    <th scope="col">Remaining Days</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-group-divider">
                                                <?php
                                                $cnt = 1;
                                                foreach ($goalsThatTimeRemains as $goal) { ?>
                                                    <tr>
                                                        <th scope="row">
                                                            <?php echo  $cnt; ?>
                                                        </th>
                                                        <td>
                                                            <?php echo htmlspecialchars($goal[0]); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlspecialchars($goal[2]); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlspecialchars($goal[3]); ?>
                                                        </td>
                                                        <td>
                                                            <button type="button">
                                                                <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php $cnt++; ?>
                                                <?php }
                                                ?>

                                            </tbody>
                                        </table>

                                    <?php }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add new Task
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">New Task</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Task Info</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                    </div>

                                    <input id="datepicker" width="462" placeholder="With in the date you want to finishe" />
                                    <script>
                                        $('#datepicker').datepicker({
                                            uiLibrary: 'bootstrap5'
                                        });
                                    </script>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-3 bg-success">


                <!---------------- Life Progress bars ---------------->
                <div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        <!--  YEAR -->
                    </div>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        <!--  Month -->
                    </div>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        <!-- Week -->
                    </div>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        <!-- Day -->
                    </div>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        <!-- Life -->
                    </div>

                    <!-- example of life progress Bar -->
                    <iframe src="https://indify.co/widgets/live/progressBar/1k2RuBJJRsOo3Lo02len" width="100%" height="300px" frameborder="0"></iframe>

                </div>




                <!-- Book Page read counter -->
                <div>
                    <!-- example of life progress Bar -->
                    <iframe src="https://indify.co/widgets/live/counter/y2ZzVIgNb0qDCpQyOYDl" width="100%" height="300px" frameborder="0"></iframe>
                </div>


            </div>
        </div>

        <!-- Upto this Tashin -->



    </main>

    <!-- Plus icon for creating a goal -->
    <div id="goalButton" class="position-fixed bottom-0 end-0 mb-4 me-4"> <!-- Position the button at the bottom right with some margin -->
        <button class="btn btn-primary rounded-circle shadow" type="button">
            <i class="fas fa-plus"></i>
        </button>
    </div>
</body>

</html>