<?php

include('../Dashboard/connect_db.php'); // database connection

$currentDateTimeObject = new DateTime();
$todaysDate = $currentDateTimeObject->format('d/m/Y'); // today's date


// $labels = $data = '';
$sql = '';

// Set default value for order if not provided
$duration = isset($_POST['duration']) ? $_POST['duration'] : 'weakly';

switch ($duration) {
    case 'weakly':

        $sql = "SELECT week_range , COUNT(*), week_ll,weel__rr
                FROM(
                    SELECT DISTINCT  *,  
                    STR_TO_DATE(SUBSTRING_INDEX(SUBSTRING_INDEX(week_range, ' to ', 1), ' ', -1), '%m/%d/%y')  AS week_ll,
                    STR_TO_DATE(SUBSTRING_INDEX(SUBSTRING_INDEX(week_range, ' to ', -1), ' ', -1), '%m/%d/%y')  AS weel__rr
                FROM
                (	SELECT 
                    CONCAT(
                        DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL (week_num - 1) * 7 DAY), '%m/%d/%y'), 
                        ' to ', 
                        DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL week_num * 7 - 1 DAY), '%m/%d/%y')
                            ) AS week_range
                    FROM 
                    (SELECT 1 AS week_num UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 
                    UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10) AS weeks
                    ORDER BY  week_num
                ) as ntb
                LEFT JOIN
                user_info as uf
                ON 
                STR_TO_DATE(DATE_FORMAT(joinDate,'%m/%d/%y'), '%m/%d/%y')
                
                BETWEEN STR_TO_DATE(SUBSTRING_INDEX(SUBSTRING_INDEX(week_range, ' to ', -1), ' ', -1), '%m/%d/%y') 
                    AND STR_TO_DATE(SUBSTRING_INDEX(SUBSTRING_INDEX(week_range, ' to ', 1), ' ', -1), '%m/%d/%y')
                
                ORDER BY joinDate DESC) as cnt_ntb
                GROUP BY cnt_ntb.week_range
                ORDER BY cnt_ntb.week_ll";
        break;
    case 'monthly':
        $orderByClause = "ORDER BY l.clicked DESC";
        break;
    case 'yearly':
        $orderByClause = "ORDER BY n.title";
        break;
}

$result = mysqli_query($conn, $sql);
$weeklyData = mysqli_fetch_all($result);
// print_r($data);

$labels = array();
$labels[0] = $weeklyData[0][3];
for ($i = 0; $i < count($weeklyData); $i++) {
    $labels[$i+1] = $weeklyData[$i][2];
}
// print_r($labels);

$data = array();
$data[0] = 0;
for ($i = 0; $i < count($weeklyData); $i++) {
    $data[$i+1] = $weeklyData[$i][1];
}
// print_r($data);



// // Data generation functions
// function generateLabels()
// {
//     $count = 7; // Set the desired count
//     return array_map(function ($i) {
//         return strval($i + 1);
//     }, range(0, $count - 1));
// }

// function generateData()
// {
//     $min = -100; // Set the desired minimum value
//     $max = 100;  // Set the desired maximum value
//     $count = 8;  // Set the desired count
//     return array_map(function () use ($min, $max) {
//         return rand($min, $max);
//     }, range(0, $count - 1));
// }


// print_r($labels);
// $data = generateData();


// In my project there is a page where I need to show a line chart to show that signup count weekly. like, 29-05-2024 to 23-05-2024 10 people signup and 23-05-2024 to 17-05-2024 15 people signup. just like similar more weeks. which chart should I implement?
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kairos</title>

    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="/Admin-Panel/">
    <!-- <link rel="stylesheet" href="/Includes/style.css"> -->



</head>

<body>
    <?php include('sidebar.php'); ?>

    <!-- Main part -->
    <main>
        <div class="container d-flex p-3 ">

            <!-- Filtered by -->
            <script>
                function submitForm(duration) {
                    document.getElementById('durationInput').value = duration;
                    document.getElementById('durationForm').submit();
                }
            </script>

            <form id="durationForm" action="notes-approve.php" method="post">
                <input type="hidden" name="duration" id="durationInput">
            </form>
            <button class="btn btn-primary" type="button" onclick="submitForm('weakly')" id="weakly" name="weakly">Weakly</button>
            <button class="btn btn-primary" type="button" onclick="submitForm('monthly')" id="monthly" name="monthly">Monthly</button>
            <button class="btn btn-primary" type="button" onclick="submitForm('yearly')" id="yearly" name="yearly">Yearly</button>

            <!-- ............... -->
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