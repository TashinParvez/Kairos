<?php

include('../Dashboard/connect_db.php');

// session_start(); // Start the session
// $userHandle = mysqli_real_escape_string($conn, $_SESSION['userHandle']); // after linked all page. it will be uncommented
$userHandle = mysqli_real_escape_string($conn, 'abcdefgh'); // after linked all page. it will be deleted


//---------------------------- Graph Code ----------------------------------------
// avg prev him after
$sql = "SELECT * 
        FROM (SELECT j.userHandle, nc.date, AVG(nc.fajar+nc.dhuhr+nc.asr+nc.magrib+nc.isha) as total_namaz
              FROM user_joined_category as j
              INNER JOIN
              namaz_c as nc 
              ON nc.userHandle = j.userHandle
                WHERE j.cat_id = 2
                GROUP BY nc.date
            ) as AVG

        UNION ALL

        SELECT * 
        FROM (SELECT j.userHandle, nc.date, nc.fajar+nc.dhuhr+nc.asr+nc.magrib+nc.isha as total_namaz
              FROM user_joined_category as j 
              INNER JOIN
              namaz_c as nc 
              ON nc.userHandle = j.userHandle
              WHERE joined_date <
                    (    SELECT joined_date
                   		 FROM user_joined_category
                  		 WHERE userHandle = 'tashin19' && cat_id = 2
                    ) && nc.date BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) AND CURRENT_DATE
                    && j.cat_id = 2
                ORDER BY joined_date DESC
                LIMIT 2
            ) as earlier_entries

        UNION ALL

        SELECT * 
        FROM (SELECT j.userHandle, nc.date, (nc.fajar+nc.dhuhr+nc.asr+nc.magrib+nc.isha) as total_namaz
              FROM user_joined_category as j
              INNER JOIN
              namaz_c as nc
              ON nc.userHandle = j.userHandle
              WHERE j.userHandle = 'tashin19' && j.cat_id = 2
            ) as himself

        UNION ALL

        SELECT * 
        FROM (SELECT j.userHandle, nc.date, nc.fajar+nc.dhuhr+nc.asr+nc.magrib+nc.isha as total_namaz
              FROM user_joined_category as j 
              INNER JOIN
              namaz_c as nc 
              ON nc.userHandle = j.userHandle
                WHERE joined_date >
                    (   SELECT joined_date
                   		FROM user_joined_category
                  		WHERE userHandle = 'tashin19' && cat_id = 2
                    ) && nc.date BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) AND CURRENT_DATE
                    && j.cat_id = 2
                ORDER BY joined_date DESC
                LIMIT 2
            ) as later_entries;";

// Sample data generation
function generateRandomData($count, $min, $max)
{
    $data = [];
    for ($i = 0; $i < $count; $i++) {
        $data[] = rand($min, $max);
    }
    return $data;
}

// Number of data points
$dataCount = 7;


$average = array(2, 2.5, 4, 5, 2.9, 2, 4);
$previous1 = array(1, 3, 3, 2, 1, 5, 2);
$previous2 = array(2, 1, 1, 3, 4, 4, 3);
$self = array(1, 2, 1, 3, 2, 5, 2);
$after1 = array(1, 1, 5, 4, 2, 4, 3);
$after2 = array(1, 3, 2, 2, 1, 2, 3);

// Labels for the chart (e.g., months)
$labels = ['02/06/2024', '01/06/2024', '31/05/2024', '30/05/2024', '29/05/2024', '28/05/2024', '27/05/2024'];

// Prepare data in the format required by Chart.js
$chartData = [
    'labels' => $labels,
    'datasets' => [
        [
            'label' => 'Average',
            'data' => $average,
            'borderColor' => 'rgb(255, 99, 132)',
            'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
        ],
        [
            'label' => 'Previous-1',
            'data' => $previous1,
            'borderColor' => 'rgba(128, 128, 128, 0.5)',
            'backgroundColor' => 'rgba(128, 128, 128, 0.5)',
        ],
        [
            'label' => 'Previous-2',
            'data' => $previous2,
            'borderColor' => 'rgba(128, 128, 128, 0.5)',
            'backgroundColor' => 'rgba(128, 128, 128, 0.5)',
        ],
        [
            'label' => 'Self',
            'data' => $self,
            'borderColor' => 'rgba(0, 128, 0, 0.7)',
            'backgroundColor' => 'rgba(0, 128, 0, 0.7)',
        ],
        [
            'label' => 'After 1',
            'data' => $after1,
            'borderColor' => 'rgba(128, 128, 128, 0.2)',
            'backgroundColor' => 'rgba(128, 128, 128, 0.2)',
        ],
        [
            'label' => 'After 2',
            'data' => $after2,
            'borderColor' => 'rgba(128, 128, 128, 0.2)',
            'backgroundColor' => 'rgba(128, 128, 128, 0.2)',
        ]
    ]
];

// Convert PHP array to JSON
$chartDataJson = json_encode($chartData);
// $result = mysqli_query($conn, $sql);
// $graphsdata = mysqli_fetch_all($result);

// ...........Namaz main page work ................

if (isset($_POST['update'])) {
    $Fajr = isset($_POST['Fajr']) ? 1 : 0;
    $Dhuhr = isset($_POST['Dhuhr']) ? 1 : 0;
    $Asr = isset($_POST['Asr']) ? 1 : 0;
    $Maghrib = isset($_POST['Maghrib']) ? 1 : 0;
    $Isha = isset($_POST['Isha']) ? 1 : 0;

    $sql = "INSERT INTO namaz_c(userHandle, fajar, dhuhr, asr, magrib, isha)
            VALUES ('$userHandle', $Fajr, $Dhuhr, $Asr, $Maghrib, $Isha)";

    // save to db and check
    if (mysqli_query($conn, $sql)) {
        // success
        header('Location: Namaj_main.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }

    // close connection
    mysqli_close($conn);
}

//................................


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namaz</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puja</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    </link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Noman -->
    <!-- CSS -->
    <link rel="stylesheet" href="../Includes/style.css">
    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Gold Reserves"
                },
                axisY: {
                    title: "Gold Reserves (in tonnes)"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.## tonnes",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
</head>

<body>

    <!-- ------------------------ Main Segment ------------------------------- -->

    <main class="main bg-transparent">
        <div class="container bg-white">
            <div class="row bg-white">
                <div class="col-8 bg-white">
                    <!-- <canvas class="rounded" id="myChart" width="150" height="100"></canvas> -->

                    <!--.......................... Noman ...........................-->
                    <canvas id="myChart"></canvas>

                    <script>
                        // Fetch chart data from PHP
                        const chartData = <?php echo $chartDataJson; ?>;

                        // Define the configuration for the chart
                        const config = {
                            type: 'line',
                            data: chartData,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Chart.js Line Chart'
                                    }
                                }
                            },
                        };

                        // Render the chart
                        window.onload = function() {
                            const ctx = document.getElementById('myChart').getContext('2d');
                            window.myChart = new Chart(ctx, config);
                        };
                    </script>
                    <!-- ...................................... -->
                </div>
                <div class="col-4 bg-white">
                    <div class="progress w-100 z-2" role="progressbar" aria-label="Example with label" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 0%">0%</div>

                    </div>
                    <form action="\Community Namaz\Namaj_if_assigned.php" method="post" class="bg-white">
                        <div class="container bg-white">
                            <div class="form-check form-switch bg-white">
                                <input class="form-check-input" type="checkbox" id="Fajr" name="Fajr">
                                Fajr
                            </div>
                            <div>
                                <div class="form-check form-switch bg-white">
                                    <input class="form-check-input" type="checkbox" id="Dhuhr" name="Dhuhr">
                                    Dhuhr
                                </div>
                            </div>
                            <div>
                                <div class="form-check form-switch bg-white">
                                    <input class="form-check-input" type="checkbox" id="Asr" name="Asr">
                                    Asr
                                </div>
                            </div>
                            <div>
                                <div class="form-check form-switch bg-white">
                                    <input class="form-check-input" type="checkbox" id="Maghrib" name="Maghrib">
                                    Maghrib
                                </div>
                            </div>
                            <div>
                                <div class="form-check form-switch bg-white">
                                    <input class="form-check-input" type="checkbox" id="Isha" name="Isha">
                                    Isha
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary mb-2 " type="submit" name="update">Today's Update</button>
                    </form>
                </div>
            </div>

        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const FajrCheckbox = document.getElementById('Fajr');
                const DhuhrCheckbox = document.getElementById('Dhuhr');
                const AsrCheckbox = document.getElementById('Asr');
                const MaghribCheckbox = document.getElementById('Maghrib');
                const IshaCheckbox = document.getElementById('Isha');
                const progressBar = document.querySelector('.progress-bar');
                FajrCheckbox.addEventListener('change', updateProgress);
                DhuhrCheckbox.addEventListener('change', updateProgress);
                AsrCheckbox.addEventListener('change', updateProgress);
                MaghribCheckbox.addEventListener('change', updateProgress);
                IshaCheckbox.addEventListener('change', updateProgress);

                function updateProgress() {
                    const progress = (FajrCheckbox.checked ? 20 : 0) + (DhuhrCheckbox.checked ? 20 : 0) + (AsrCheckbox.checked ? 20 : 0) + (MaghribCheckbox.checked ? 20 : 0) + (IshaCheckbox.checked ? 20 : 0);

                    progressBar.style.width = progress + '%';
                    progressBar.innerText = progress + '%';

                    fetch('save_progress.php', {
                            method: 'POST',
                            body: JSON.stringify({
                                progress: progress
                            }),
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log(data);
                        })
                        .catch(error => {
                            console.error('There was a problem with the fetch operation:', error);
                        });
                }
            });
        </script>
    </main>
</body>

</html>