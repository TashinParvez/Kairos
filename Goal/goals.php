<?php

include '../Dashboard/connect_db.php'; // Daatabase connection
$currentDateTimeObject = new DateTime();
$todaysDate = $currentDateTimeObject->format('Y-m-d'); // today's date
// echo "Today's date is: " . $todaysDate;
$time = $currentDateTimeObject->format('H:i:s');
// echo "Time is: " . $time;

session_start(); // Start the session
// $userHandle = mysqli_real_escape_string($conn, $_SESSION['userHandle']); // after linked all page. it will be uncommented
$userHandle = mysqli_real_escape_string($conn, 'tashin19'); // after linked all page. it will be deleted

// .......*** Create Goal ***...........
$task = $finishDate = '';
$errors = ['task' => '', 'finishDate' => ''];

if (isset($_POST['addTask'])) {
    // ................ Retrieve all data from input field & escape sql chars ...............
    $task = mysqli_real_escape_string($conn, $_POST['task']);
    $finishDate = mysqli_real_escape_string($conn, $_POST['finishDate']);  // need to read

    // .............. All input field validation checking ...................
    // check goal name
    if (empty($task)) {
        $errors['task'] = 'This field cannot be empty!';
    }

    // check end date
    if (empty($finishDate)) {
        $errors['finishDate'] = 'This field cannot be empty!';
    }

    if (!array_filter($errors)) {
        // create sql
        $sql = "INSERT INTO goals (userHandle, goalName, endDate) 
                VALUES ('$userHandle', '$task', '$finishDate');";

        // save to db and check
        if (mysqli_query($conn, $sql)) {
            header('Location: goals.php');
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
    }

    // close connection
    mysqli_close($conn);
}

// .......*** If a goal completed button clicked ***...........

if (isset($_POST['completed'])) {
    // ................ Retrieve all data from input field & escape sql chars ...............
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

    // close connection
    mysqli_close($conn);
}

// .......*** Page counter ***...........
if (isset($_POST['counterPlus'])) {
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


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Access the checked checkbox, if any
    if (isset($_POST["checkedItem"])) {
        $checkedItem = $_POST["checkedItem"];

        // Sample SQL update query
        $sql = "UPDATE goals SET status = 1, completedDate = current_timestamp()
                WHERE userHandle = '$userHandle' AND goalName = '$checkedItem'";

        if (mysqli_query($conn, $sql)) {
            // success
            header('Location: goals.php');
        } else {
            // Database update failed
            echo 'Error updating goal: ' . mysqli_error($conn);
        }
    } else {
        echo "No checkboxes are checked.";
    }
}



// After checked a goal
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     if (isset($_POST['goal_checkbox'])) {
//         // Retrieve the values sent via POST
//         $goalName = $_POST['goalName'];
//         $startDate = $_POST['startDate'];
//         $endDate = $_POST['endDate'];

//         // Sample SQL update query
//         $sql = "UPDATE goals SET status = 1
//                 WHERE userHandle = '$userHandle' AND goalName = '$goalName' AND startDate = '$startDate' AND endDate = '$endDate'";

//         if (mysqli_query($conn, $sql)) {
//             // success
//             header('Location: goals.php');
//         } else {
//             // Database update failed
//             echo 'Error updating goal: ' . mysqli_error($conn);
//         }
//     } else {
//         // Checkbox not checked
//         echo 'Checkbox not checked.';
//     }
// }

// Only one time execute...

$sql = "SELECT userHandle FROM page_count WHERE userHandle = '$userHandle'";
$result = mysqli_query($conn, $sql);
if (!(mysqli_num_rows($result) > 0)) {
    $sql = "INSERT INTO page_count (userHandle, todaysDate) 
            VALUES ('$userHandle', DATE_FORMAT(CURRENT_DATE, '%Y-%m-%d'));";
    mysqli_query($conn, $sql);
}


// .......*** Generally work for Goal page ***...........

$goalsThatTimeRemains = '';



// ............. Page count reset ............

$sql = "SELECT DATEDIFF(CURRENT_DATE, DATE_FORMAT(todaysDate, '%Y-%m-%d')) AS dateDifference
        FROM page_count
        WHERE userHandle = '$userHandle';";


$result = mysqli_fetch_assoc(mysqli_query($conn, $sql));  // Execute query

if ($result['dateDifference'] != 0) {
    // Prepare SQL query to update the database
    $sql = "UPDATE page_count
                SET todaysDate = current_timestamp(), 
                    totalCount = totalCount + dailyCount, 
                    dailyCount = 0
                WHERE userHandle = '$userHandle'";

    // Execute update query and check for success
    if (mysqli_query($conn, $sql)) {
        // Redirect to goals.php on success
        header('Location: goals.php');
    } else {
        // Print error message if query fails
        echo 'Query error: ' . mysqli_error($conn);
    }
    // Close the database connection
    mysqli_close($conn);
}





//  For 3 types of table

// .......... Finished Goals  .......
$sql = "SELECT goalName, DATE_FORMAT(startDate, '%d/%m/%Y'), DATE_FORMAT(endDate, '%d/%m/%Y'), DATE_FORMAT(completedDate, '%d/%m/%Y')
            FROM goals
            WHERE userHandle = '$userHandle' AND status = 1";

$result = mysqli_query($conn, $sql);  // get query result
$finishedGoals = mysqli_fetch_all($result); // conver to array

/*
        UPDATE goals
        SET status = 1, completedDate = current_timestamp()
        WHERE userHandle = 'tashin19' && goalName = 'Build CV'
    */

// .......... Goals exceeded deadline .......
$sql = "SELECT goalName, 
            DATE_FORMAT(startDate, '%d/%m/%Y') AS formatted_StartDate, 
            DATE_FORMAT(endDate, '%d/%m/%Y') AS formatted_EndDate,
            DATEDIFF(CURRENT_DATE(), endDate) AS Overdue
            FROM goals
            WHERE userHandle = '$userHandle' AND status = 0 AND endDate < current_timestamp()
            ORDER BY Overdue DESC";

$result = mysqli_query($conn, $sql);
$goalsExceededDeadline = mysqli_fetch_all($result); // conver to array

// .......... Goals within deadline / Goals in hand .........

$sql = "SELECT goalName, 
                   DATE_FORMAT(startDate, '%d/%m/%Y') AS formatted_StartDate, 
                   DATE_FORMAT(endDate, '%d/%m/%Y') AS formatted_EndDate,
                   DATEDIFF(endDate, CURRENT_DATE()) AS daysRemaining
            FROM goals
            WHERE userHandle = '$userHandle'
                  AND status = 0 
                  AND endDate >= CURRENT_DATE()
            ORDER BY DATEDIFF(endDate, CURRENT_DATE())";

$result = mysqli_query($conn, $sql);
$goalsThatTimeRemains = mysqli_fetch_all($result); // conver to array

// --------------------------------     FOR Life progress bar     --------------------------------

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

$result = mysqli_query($conn, $sql);
$life = mysqli_fetch_all($result);

$sql = "SELECT dailyCount, totalCount
FROM page_count
WHERE userHandle = '$userHandle';";

$result = mysqli_query($conn, $sql);
$count = mysqli_fetch_assoc($result);


// for memory free
mysqli_free_result($result);
// close connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goals</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- CSS -->
    <style>
        body.modal-open .supreme-container {
            -webkit-filter: blur(1px);
            -moz-filter: blur(1px);
            -o-filter: blur(1px);
            -ms-filter: blur(1px);
            filter: blur(1px);
        }
    </style>

    <!-- JS -->
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

    <script>
        $(document).ready(function() {
            $('.goal-checkbox').on('change', function() {
                if ($(this).is(':checked')) {
                    var goalName = $(this).data('goalName');
                    var startDate = $(this).data('startDate');
                    var endDate = $(this).data('endDate');

                    // Send AJAX request to update goal status
                    $.ajax({
                        url: 'goals.php',
                        method: 'POST',
                        data: {
                            goalName: goalName,
                            startDate: startDate,
                            endDate: endDate
                        },
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>


    <!-- <link rel="stylesheet" href="../Includes/style.css"> -->
    <!-- uncomment -->

</head>

<body>
    <?php
    include '../Includes/NavBarSecond.php'; // uncomment
    include '../Includes/Sidebar.php'; // uncomment
    ?>

    <!-- ------------------------ Main Segment ------------------------------- -->

    <main class="main bg-white shadow z-2">
        <div class="stat bg-white">
            <!-- Some Charts here -->
        </div>

        <div class="row bg-white">
            <div class="col-8 bg-white">
                <div class="container bg-white" style="margin:0; padding:0">
                    <div class="accordion" style="margin:0; padding:0" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item" style="margin:0; padding:0">
                            <h2 class="accordion-header" style="margin:0; padding:0" id="panelsStayOpen-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                                    Finished
                                </button>

                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body" style="margin:0; padding:0">

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
                                                            <?php echo $cnt; ?>
                                                        </th>
                                                        <td>
                                                            <?php echo htmlspecialchars($goal[0]); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlspecialchars($goal[3]); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo 'Finished'; ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    ++$cnt;
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
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
                                    Overdue Tasks
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body" style="margin:0; padding:0">

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
                                                    <form action="goals.php" method="post">
                                                        <tr>
                                                            <th scope="row">
                                                                <?php echo $cnt; ?>
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
                                                                <!-- <button type="button" class="border-0 bg-transparent">
                                                                <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                                            </button> -->
                                                                <button type="button" class="border-0 bg-transparent">
                                                                    <input class="form-check-input mt-0" type="checkbox" value="<?php echo $goal[0]; ?>" name="checkedItem" aria-label="Checkbox for following text input" onchange="this.form.submit()">
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </form>
                                                    <?php ++$cnt; ?>
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
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true" aria-controls="panelsStayOpen-collapseThree">
                                    Scheduled Tasks
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body" style="margin:0; padding:0">

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
                                                    <form action="goals.php" method="post">
                                                        <tr>
                                                            <th scope="row">
                                                                <?php echo $cnt; ?>
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
                                                                <button type="button" class="border-0 bg-transparent">
                                                                    <input class="form-check-input mt-0" type="checkbox" value="<?php echo $goal[0]; ?>" name="checkedItem" aria-label="Checkbox for following text input" onchange="this.form.submit()">
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </form>
                                                    <?php ++$cnt; ?>
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

                </div>
            </div>
            <div class="col-3 bg-white">


                <!-------------- Life Progress bars -------------->
                <div class="bg-white">
                    Yearly
                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 0%">0%</div>
                    </div>
                    Monthly
                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 25%">25%</div>
                    </div>
                    Weekly
                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 50%">50%</div>
                    </div>
                    Daily
                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 75%">75%</div>
                    </div>
                    Over-all
                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 100%">100%</div>
                    </div>

                    <!-- example of life progress Bar -->
                    <!-- <iframe src="https://indify.co/widgets/live/progressBar/1k2RuBJJRsOo3Lo02len" width="100%" height="300px" frameborder="0"></iframe> -->

                </div>




                <!-- Book Page read counter -->
                <div class="bg-white p-3">

                    <!-- example of life progress Bar -->
                    <!-- <iframe src="https://indify.co/widgets/live/counter/y2ZzVIgNb0qDCpQyOYDl" width="100%" height="300px" frameborder="0"></iframe> -->
                    <form action="goals.php" method="POST">
                        <div class="row bg-white">
                            <label for="bookPageCounter" class="label-control">Today's Read Pages</label>
                            <div class="col-2 bg-transparent">
                                <button type="submit" class="btn btn-light shadow" name="counterMinus" id="counterMinus" style="height:40px; width:40px;">-</button>
                            </div>
                            <div class="col-2 bg-transparent" style="justify-content:center; align-items:center">
                                <div class="container bg-white" style="height:40px; width:40px; justify-content:center; align-items:center; font-size:1.8rem">
                                    <p class="pCount bg-white"><?php echo $count['dailyCount']; ?></p>
                                </div>
                            </div>
                            <div class="col-2 bg-transparent">
                                <button type="submit" class="btn btn-light shadow" name="counterPlus" id="counterPlus" style="height:40px; width:40px;">+</button>
                            </div>
                            <div class="col-3 bg-transparent">
                                <button type="button" class="btn btn-secondary shadow" style="display: none;">Reset</button>
                            </div>
                            <label for="totalreadpages" class="label-control">Total Read Pages: <?php echo $count['totalCount']; ?></label>
                        </div>
                    </form>
                </div>


            </div>
        </div>

        <!-- Upto this Tashin -->



    </main>

    <!-- Plus icon for creating a goal -->
    <div id="goalButton" class="position-fixed bottom-0 end-0 mb-4 me-4 bg-transparent">
        <!-- Position the button at the bottom right with some margin -->
        <button class="btn btn-primary rounded-circle shadow" type="button">
            <i class="fas fa-plus bg-transparent"></i>
        </button>
    </div>

    <div class="modal fade z-10" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 bg-transparent" id="exampleModalLabel">New Task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="goals.php" method="POST">
                    <div class="modal-body">

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">Task Info</span>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="task" id="task">
                        </div>

                        <input id="finishDate" name="finishDate" type="date" width="462" placeholder="With in the date you want to finish" />
                        <!-- <script>
                            $('#finishDate').datepicker({
                                uiLibrary: 'bootstrap5'
                            });
                        </script> -->

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="addTask" id="addTask">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>