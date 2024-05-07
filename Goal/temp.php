<!-- <script>
        // Wait for the DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Select all checkboxes with the class 'goal-checkbox'
            var checkboxes = document.querySelectorAll('.goal-checkbox');

            // Loop through each checkbox
            checkboxes.forEach(function(checkbox) {
                // Add a click event listener to each checkbox
                checkbox.addEventListener('click', function() {
                    // Check if the checkbox is checked
                    if (this.checked) {
                        // Retrieve the data attributes associated with this checkbox
                        var goalName = this.getAttribute('goalName');
                        var startDate = this.getAttribute('startDate');
                        var endDate = this.getAttribute('endDate');
                        // You can now use these values to update the database or perform any other action
                        console.log('Goal checked:', goalName);
                        console.log('Start date:', startDate);
                        console.log('End date:', endDate);
                        // You can also make an AJAX request to update the database
                    }
                });
            });
        });
    </script> -->

<?php

include '../Dashboard/connect_db.php'; // Daatabase connection
$currentDateTimeObject = new DateTime();
$todaysDate = $currentDateTimeObject->format('d/m/Y'); // today's date
// echo "Today's date is: " . $todaysDate;
$time = $currentDateTimeObject->format('H:i:s');
// echo "Time is: " . $time;

session_start(); // Start the session
// $userHandle = mysqli_real_escape_string($conn, $_SESSION['userHandle']); // after linked all page. it will be uncommented
$userHandle = mysqli_real_escape_string($conn, 'tashin19'); // after linked all page. it will be deleted

// .......*** Create Goal ***...........
$goalName = $startDate = $endDate = '';
$errors = ['goalName' => '', 'endDate' => ''];

if (isset($_POST['createGoal'])) {
    // ................ Retrieve all data from input field & escape sql chars ...............
    $goalName = mysqli_real_escape_string($conn, $_POST['goalName']);
    $endDate = mysqli_real_escape_string($conn, $_POST['startDate']);  // need to read

    // .............. All input field validation checking ...................
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

// After checked a goal
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['goal_checkbox'])) {
        // Retrieve the values sent via POST
        $goalName = $_POST['goalName'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        // Sample SQL update query
        $sql = "UPDATE goals SET status = 1
                WHERE userHandle = '$userHandle' AND goalName = '$goalName' AND startDate = '$startDate' AND endDate = '$endDate'";

        if (mysqli_query($conn, $sql)) {
            // success
            header('Location: goals.php');
        } else {
            // Database update failed
            echo "Error updating goal: " . mysqli_error($conn);
        }
    } else {
        // Checkbox not checked
        echo "Checkbox not checked.";
    }
}

// .......*** Generally work for Goal page ***...........

$goalsThatTimeRemains = '';

// ............. Page count reset ............

// if ($time > '06:00:00') {
//     $sql = "SELECT DATE_FORMAT(todaysDate, '%d/%m/%Y') AS todaysDate
//                 FROM page_count
//                 WHERE userHandle = '$userHandle'";

//     $result = mysqli_query($conn, $sql);  // get query result
//     $tempDate = mysqli_fetch_assoc($result); // conver to array

//     if ($todaysDate !== $tempDate['todaysDate']) {
//         $sql = "UPDATE page_count
//                     SET todaysDate = '$todaysDate', totalCount = totalCount + dailyCount, dailyCount = 0
//                     WHERE userHandle = '$userHandle'";

//         // save to db and check
//         if (mysqli_query($conn, $sql)) {
//             // success
//             header('Location: goals.php');
//         } else {
//             echo 'query error: ' . mysqli_error($conn);
//         }
//     }

//     // close connection
//     mysqli_close($conn);
// }

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
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
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
    include '../Includes/NavBar.php'; // uncomment
    include '../Includes/Sidebar.php'; // uncomment
    ?>

    <!-- ------------------------ Main Segment ------------------------------- -->

    <main class="main bg-white shadow">
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
                                                                <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                                            </button>
                                                        </td>
                                                    </tr>
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
                                                                <input class="form-check-input mt-0 goal-checkbox" goalName="<?php echo htmlspecialchars($goal[0]); ?>" startDate="<?php echo htmlspecialchars($goal[1]); ?>" endDate="<?php echo htmlspecialchars($goal[2]); ?>" type="checkbox" value="" aria-label="Checkbox for following text input">

                                                                <!-- <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input"> -->
                                                            </button>
                                                        </td>
                                                    </tr>
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
                    <div class="row bg-white">
                        <div class="col-2 bg-white">
                            <button type="button" class="btn btn-light shadow" style="height:40px; width:40px;">-</button>
                        </div>
                        <div class="col-2 bg-white" style="justify-content:center; align-items:center">
                            <div class="container bg-white" style="height:40px; width:40px; justify-content:center; align-items:center; font-size:1.8rem">
                                <p class="pCount bg-white">0</p>
                            </div>
                        </div>
                        <div class="col-2 bg-white">
                            <button type="button" class="btn btn-light shadow" style="height:40px; width:40px;">+</button>
                        </div>
                        <div class="col-3 bg-white">
                            <button type="button" class="btn btn-secondary shadow">Reset</button>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <!-- Upto this Tashin -->



    </main>

    <!-- Plus icon for creating a goal -->
    <div id="goalButton" class="position-fixed bottom-0 end-0 mb-4 me-4 bg-transparent"> <!-- Position the button at the bottom right with some margin -->
        <button class="btn btn-primary rounded-circle shadow" type="button">
            <i class="fas fa-plus bg-transparent"></i>
        </button>
    </div>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JavaScript Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>