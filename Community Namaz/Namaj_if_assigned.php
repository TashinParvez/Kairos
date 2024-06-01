<?php 

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

// Generate data for each person
$average = generateRandomData($dataCount, -100, 100);
$previous1 = generateRandomData($dataCount, -100, 100);
$previous2 = generateRandomData($dataCount, -100, 100);
$self = generateRandomData($dataCount, -100, 100);
$after1 = generateRandomData($dataCount, -100, 100);
$after2 = generateRandomData($dataCount, -100, 100);

// Labels for the chart (e.g., months)
$labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];

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
            'borderColor' => 'rgba(0, 128, 0, 0.5)',
            'backgroundColor' => 'rgba(0, 128, 0, 0.5)',
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
                    <form action="Puja.php" method="post">
                        <div class="container bg-white">
                            <div class="form-check form-switch bg-white">
                                <input class="form-check-input" type="checkbox" value="morning" id="Fajr" name="Fajr">
                                Fajr
                            </div>
                            <div>
                                <div class="form-check form-switch bg-white">
                                    <input class="form-check-input" type="checkbox" value="evening" id="Dhuhr" name="Dhuhr">
                                    Dhuhr
                                </div>
                            </div>
                            <div>
                                <div class="form-check form-switch bg-white">
                                    <input class="form-check-input" type="checkbox" value="evening" id="Asr" name="Asr">
                                    Asr
                                </div>
                            </div>
                            <div>
                                <div class="form-check form-switch bg-white">
                                    <input class="form-check-input" type="checkbox" value="evening" id="Maghrib" name="Maghrib">
                                    Maghrib
                                </div>
                            </div>
                            <div>
                                <div class="form-check form-switch bg-white">
                                    <input class="form-check-input" type="checkbox" value="evening" id="Isha" name="Isha">
                                    Isha
                                </div>
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-outline-primary mb-2" type="submit" name="update">Today's Update</button>
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