<?php
// Generate dynamic chart data using PHP
$labels = generateLabels();
$data = generateData();

// Output data as JSON
echo json_encode([
    'labels' => $labels,
    'data' => $data
]);

// Data generation functions
function generateLabels()
{
    $count = 8; // Set the desired count
    return array_map(function ($i) {
        return strval($i + 1);
    }, range(0, $count - 1));
}

function generateData()
{
    $min = -100; // Set the desired minimum value
    $max = 100;  // Set the desired maximum value
    $count = 8;  // Set the desired count
    return array_map(function () use ($min, $max) {
        return rand($min, $max);
    }, range(0, $count - 1));
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="/Admin-Panel/">

</head>

<body>
    <?php include('sidebar.php'); ?>

    <!-- Main part -->
    <canvas id="myChart" width="400" height="200"></canvas>

    <!-- JavaScript -->
    <script>
        // Data generation and configuration
        const data = {
            labels: [],
            datasets: [{
                label: 'Dataset',
                data: [],
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

        // Data generation functions
        const inputs = {
            min: -100,
            max: 100,
            count: 8,
            decimals: 2,
            continuity: 1
        };

        function generateLabels() {
            return Array.from({
                length: inputs.count
            }, (_, i) => i + 1).map(String);
        }

        function generateData() {
            return Array.from({
                length: inputs.count
            }, () => Math.floor(Math.random() * (inputs.max - inputs.min + 1)) + inputs.min);
        }

        // Fetch data asynchronously
        fetch('chart_data.php')
            .then(response => response.json())
            .then(data => {
                myChart.data.labels = data.labels;
                myChart.data.datasets[0].data = data.data;
                myChart.update();
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>

</body>

</html>