<?php

include '../Dashboard/connect_db.php'; // Daatabase connection
$currentDateTimeObject = new DateTime();
$todaysDate = $currentDateTimeObject->format('d/m/Y'); // today's date


$labels = '';
if (isset($_POST['weakly'])) {

    $labels = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

    $sql = "SELECT COUNT(*) AS weaklyCount
            FROM user_info
            WHERE DATE_FORMAT(joinDate, '%d/%m/%Y') >= DATE_SUB('todaysDate', INTERVAL 7 DAY)";
}
if (isset($_POST['monthly'])) {
}
if (isset($_POST['yearly'])) {
}

// // Data generation functions
// function generateLabels()
// {
//     $count = 7; // Set the desired count
//     return array_map(function ($i) {
//         return strval($i + 1);
//     }, range(0, $count - 1));
// }

function generateData()
{
    $min = -100; // Set the desired minimum value
    $max = 100;  // Set the desired maximum value
    $count = 8;  // Set the desired count
    return array_map(function () use ($min, $max) {
        return rand($min, $max);
    }, range(0, $count - 1));
}


// print_r($labels);
$data = generateData();
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="/Admin-Panel/">
    <link rel="stylesheet" href="\Includes\style.css">

</head>

<body>
    <?php include('../Admin-Panel/sidebar.php'); ?>

    <!-- Main part -->
    <main>
        <div class="container d-flex p-3 ">
            <form action="lineChartBoundaries.php" method="POST">
                <button class="btn btn-primary" type="submit" id="weakly" name="weakly">Weakly</button>
                <button class="btn btn-primary" type="submit">Monthly</button>
                <button class="btn btn-primary" type="submit">Yearly</button>
            </form>
        </div>
        <canvas id="myChart" width="200" height="100"></canvas>
    </main>


    <!-- JavaScript -->
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

</body>

</html>