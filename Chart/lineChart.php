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
    <title>Chart.js Line Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
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
</body>

</html>