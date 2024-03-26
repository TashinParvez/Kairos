<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pie Chart Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .pie-chart {
            width: 200px;
            height: 200px;
            position: relative;
            border-radius: 50%;
            overflow: hidden;
        }

        .slice {
            position: absolute;
            width: 100%;
            height: 100%;
            clip: rect(0, 100px, 200px, 0);
            transform: rotate(0deg);
            transform-origin: 50% 50%;
        }

        .slice:nth-child(1) {
            background-color: #FF5733;
        }

        .slice:nth-child(2) {
            background-color: #FFBD33;
        }

        .slice:nth-child(3) {
            background-color: #F0FF33;
        }

        .slice:nth-child(4) {
            background-color: #33FF57;
        }

        .slice:nth-child(5) {
            background-color: #3396FF;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="pie-chart">
                    <?php
                    // Assume you have an array $data containing 5 integer values
                    $data = [20, 30, 15, 10, 25];
                    $total = array_sum($data);
                    $start = 0;
                    foreach ($data as $value) {
                        $percentage = ($value / $total) * 100;
                        echo '<div class="slice" style="transform: rotate(', $start, 'deg);"></div>';
                        $start += $percentage * 3.6;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>