<!--Insert Your PHP Here-->
<?php
    $servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'kairos';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    exit('Connection failed: '.$conn->connect_error);
}
// $userHandle = $_SESSION['userHandle'];
$userHandle = 'antarsah';
if (isset($_POST['update'])) {
    $morningPrayer = isset($_POST['morningPrayer']) ? 1 : 0;
    $eveningPrayer = isset($_POST['eveningPrayer']) ? 1 : 0;

    $sql = "INSERT INTO puja_c (userHandle, categoryID, morningPrayer, eveningPrayer) 
        VALUES ('$userHandle', (SELECT id FROM category WHERE name=(SELECT religion FROM user_info WHERE userHandle='$userHandle')), $morningPrayer, $eveningPrayer)";
    if ($conn->query($sql) === true) {
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}

$dataPoints = [
    ['y' => 3373.64, 'label' => 'Germany'],
    ['y' => 2435.94, 'label' => 'France'],
    ['y' => 1842.55, 'label' => 'China'],
    ['y' => 1828.55, 'label' => 'Russia'],
    ['y' => 1039.99, 'label' => 'Switzerland'],
    ['y' => 765.215, 'label' => 'Japan'],
    ['y' => 612.453, 'label' => 'Netherlands'],
];
$currentDateTimeObject = new DateTime();
$todaysDate = $currentDateTimeObject->format('d/m/Y'); // today's date

// Data generation functions
function generateLabels()
{
    $count = 7; // Set the desired count

    return array_map(function ($i) {
        return strval($i + 1);
    }, range(0, $count - 1));
}

function generateData()
{
    $min = -100; // Set the desired minimum value
    $max = 100;  // Set the desired maximum value
    $count = 7;  // Set the desired count

    return array_map(function () use ($min, $max) {
        return rand($min, $max);
    }, range(0, $count - 1));
}

$data = generateData();
$labels = generateLabels();
print_r($labels);
print_r($data);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puja</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0"></script>
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
    <?php
        include '../Includes/NavBarSecond.php';
include '../Includes/Sidebar.php';
?>

    <!-- ------------------------ Main Segment ------------------------------- -->

    <main class="main shadow bg-white">

        <!--You Start Writing Content Here-->
        <div class="container bg-white p-1">
            <h1>Puja</h1>
            <div class="progress w-25" role="progressbar" aria-label="Example with label" aria-valuenow="0"
                aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 0%">0%</div>

            </div>
            <form action="Puja.php" method="post">
                <div class="container bg-white">
                    <div class="form-check form-switch bg-white">
                        <input class="form-check-input" type="checkbox" value="morning" id="morningPrayer"
                            name="morningPrayer">
                        <label class="form-check-label bg-white" for="morningPrayer">
                            Today's Morning Prayer
                        </label>
                    </div>
                    <div>
                        <div class="form-check form-switch bg-white">
                            <input class="form-check-input" type="checkbox" value="evening" id="eveningPrayer"
                                name="eveningPrayer">
                            <label class="form-check-label bg-white" for="eveningPrayer">
                                Today's Evening Prayer
                            </label>
                        </div>
                    </div>
                    <button class="btn btn-outline-primary mb-2" type="submit" name="update">Update</button>
                </div>
            </form>
        </div>

        <canvas id="myChart" width="150" height="100"></canvas>
        <script>
        // Data generation and configuration
        const data = {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Dataset',
                data: <?php echo json_encode($data); ?>,
                borderColor: 'red',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                fill: false
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                plugins: {
                    filler: {
                        propagate: false,
                    },
                    title: {
                        display: true,
                        text: (ctx) => 'Fill: ' + ctx.chart.data.datasets[0].fill
                    }
                },
                interaction: {
                    intersect: false,
                }
            },
        };

        // Chart initialization
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, config);
        </script>
    </main>


    <!-------------------------- To Add Any Script, Add Here -------------------------->
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
    const clearInput = () => {
        const input = document.getElementsByTagName("input")[0];
        input.value = "";
    }
    const clearBtn = document.getElementById("clear-btn");
    clearBtn.addEventListener("click", clearInput);
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const morningCheckbox = document.getElementById('morningPrayer');
        const eveningCheckbox = document.getElementById('eveningPrayer');
        const progressBar = document.querySelector('.progress-bar');
        morningCheckbox.addEventListener('change', updateProgress);
        eveningCheckbox.addEventListener('change', updateProgress);

        function updateProgress() {
            const progress = (morningCheckbox.checked ? 50 : 0) + (eveningCheckbox.checked ? 50 : 0);

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

</body>

</html>