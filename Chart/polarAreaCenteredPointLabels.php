<?php
// Data generation functions
function generateLabels()
{
    $count = 5; // Set the desired count
    return array_map(function ($i) {
        return 'Label ' . ($i + 1);
    }, range(0, $count - 1));
}

function generateData()
{
    $min = 0; // Set the desired minimum value
    $max = 100;  // Set the desired maximum value
    $count = 5;  // Set the desired count
    return array_map(function () use ($min, $max) {
        return rand($min, $max);
    }, range(0, $count - 1));
}

$labels = generateLabels();
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
        <canvas id="myChart" width="200" height="100"></canvas>
    </main>
    

    <!-- JavaScript -->
    <script>
        // PHP block for data
        <?php
        $labels = generateLabels();
        $data = generateData();
        ?>

        // Chart configuration
        const data = {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [
                {
                    label: 'Dataset 1',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                        'rgba(255, 205, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                    ],
                }
            ]
        };

        const config = {
            type: 'polarArea',
            data: data,
            options: {
                responsive: true,
                scales: {
                    r: {
                        pointLabels: {
                            display: true,
                            centerPointLabels: true,
                            font: {
                                size: 18
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Polar Area Chart With Centered Point Labels'
                    }
                }
            },
        };

        // Chart initialization
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, config);
    </script>

</body>

</html>
