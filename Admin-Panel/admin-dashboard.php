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



    //     $sql = "SELECT 
    //     CONCAT(
    //         DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL (week_num - 1) * 7 DAY), '%d/%m/%y'), 
    //         ' to ', 
    //         DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL week_num * 7 - 1 DAY), '%d/%m/%y')
    //     ) AS week_range,
    //     COUNT(uf.userHandle) AS signup_count
    // FROM 
    //     (SELECT 1 AS week_num UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 
    //      UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10) AS weeks
    // LEFT JOIN user_info AS uf
    // ON uf.joinDate BETWEEN 
    //     DATE_SUB(CURRENT_DATE(), INTERVAL week_num * 7 DAY) 
    //     AND DATE_SUB(CURRENT_DATE(), INTERVAL (week_num - 1) * 7 DAY)
    // GROUP BY week_range
    // ORDER BY DATE_SUB(CURRENT_DATE(), INTERVAL week_num * 7 DAY);";
    
        //.........

        $sql = "SELECT duration_range , COUNT(*), duration_ll, duration__rr
                FROM(
                    SELECT DISTINCT  *,  
                    STR_TO_DATE(SUBSTRING_INDEX(SUBSTRING_INDEX(duration_range, ' to ', 1), ' ', -1), '%m/%d/%y')  AS duration_ll,
                    STR_TO_DATE(SUBSTRING_INDEX(SUBSTRING_INDEX(duration_range, ' to ', -1), ' ', -1), '%m/%d/%y')  AS duration__rr
                FROM
                (	SELECT 
                    CONCAT(
                        DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL (duration_num - 1) * 7 DAY), '%m/%d/%y'), 
                        ' to ', 
                        DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL duration_num * 7 - 1 DAY), '%m/%d/%y')
                            ) AS duration_range
                    FROM 
                    (SELECT 1 AS duration_num UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 
                    UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10) AS durations
                    ORDER BY  duration_num
                ) as ntb
                LEFT JOIN
                user_info as uf
                ON 
                STR_TO_DATE(DATE_FORMAT(joinDate,'%m/%d/%y'), '%m/%d/%y')
                
                BETWEEN STR_TO_DATE(SUBSTRING_INDEX(SUBSTRING_INDEX(duration_range, ' to ', -1), ' ', -1), '%m/%d/%y') 
                    AND STR_TO_DATE(SUBSTRING_INDEX(SUBSTRING_INDEX(duration_range, ' to ', 1), ' ', -1), '%m/%d/%y')
                
                ORDER BY joinDate DESC) as cnt_ntb
                GROUP BY cnt_ntb.duration_range
                ORDER BY cnt_ntb.duration_ll";

        $result = mysqli_query($conn, $sql);
        $weeklyData = mysqli_fetch_all($result);
        // print_r($weeklyData);

        $labels = array();
        $labels[0] = $weeklyData[0][3];
        for ($i = 0; $i < count($weeklyData); $i++) {
            $labels[$i + 1] = $weeklyData[$i][2];
        }
        // print_r($labels);

        $data = array();
        $data[0] = 0;
        for ($i = 0; $i < count($weeklyData); $i++) {
            $data[$i + 1] = $weeklyData[$i][1];
        }
        break;
    case 'monthly':

        /* $sql = "SELECT duration_range , COUNT(*), duration_ll, duration__rr
                FROM(
                    SELECT DISTINCT  *,  
                    STR_TO_DATE(SUBSTRING_INDEX(SUBSTRING_INDEX(duration_range, ' to ', 1), ' ', -1), '%m/%d/%y')  AS duration_ll,
                    STR_TO_DATE(SUBSTRING_INDEX(SUBSTRING_INDEX(duration_range, ' to ', -1), ' ', -1), '%m/%d/%y')  AS duration__rr
                FROM
                (	SELECT 
                    CONCAT(
                        DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL (duration_num - 1) * 30 DAY), '%m/%d/%y'), 
                        ' to ', 
                        DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL duration_num * 30 - 1 DAY), '%m/%d/%y')
                            ) AS duration_range
                    FROM 
                    (SELECT 1 AS duration_num UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 
                    UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10) AS durations
                    ORDER BY  duration_num
                ) as ntb
                LEFT JOIN
                user_info as uf
                ON 
                STR_TO_DATE(DATE_FORMAT(joinDate,'%m/%d/%y'), '%m/%d/%y')
                
                BETWEEN STR_TO_DATE(SUBSTRING_INDEX(SUBSTRING_INDEX(duration_range, ' to ', -1), ' ', -1), '%m/%d/%y') 
                    AND STR_TO_DATE(SUBSTRING_INDEX(SUBSTRING_INDEX(duration_range, ' to ', 1), ' ', -1), '%m/%d/%y')
                
                ORDER BY joinDate DESC) as cnt_ntb
                GROUP BY cnt_ntb.duration_range
                ORDER BY cnt_ntb.duration_ll";*/

        ////////................

        $sql = "SELECT 
                    DATE_FORMAT(LAST_DAY(DATE_SUB(CURRENT_DATE(), INTERVAL (duration_num - 1) MONTH)), '%M-%y') AS month_year,
                    COUNT(uf.userHandle) AS signup_count
                FROM 
                    (SELECT 1 AS duration_num UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 
                    UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10) AS durations
                LEFT JOIN user_info AS uf
                ON uf.joinDate BETWEEN 
                    DATE_SUB(LAST_DAY(DATE_SUB(CURRENT_DATE(), INTERVAL (duration_num - 1) MONTH)), INTERVAL (DAY(LAST_DAY(DATE_SUB(CURRENT_DATE(), INTERVAL (duration_num - 1) MONTH))) - 1) DAY)
                    AND IF(duration_num = 1, CURRENT_DATE(), LAST_DAY(DATE_SUB(CURRENT_DATE(), INTERVAL (duration_num - 1) MONTH)))
                GROUP BY month_year
                ORDER BY LAST_DAY(DATE_SUB(CURRENT_DATE(), INTERVAL (duration_num - 1) MONTH))";

        $result = mysqli_query($conn, $sql);
        $monthlyData = mysqli_fetch_all($result);

        $labels = array();
        // $labels[0] = $weeklyData[0][3];
        for ($i = 0; $i < count($monthlyData); $i++) {
            $labels[$i] = $monthlyData[$i][0];
        }
        // print_r($labels);

        $data = array();
        // $data[0] = 0;
        for ($i = 0; $i < count($monthlyData); $i++) {
            $data[$i] = $monthlyData[$i][1];
        }
        // print_r($labels);
        // print_r($data);
        //..........
        break;
    case 'yearly':
        ////////................

        $sql = "SELECT 
                    DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL (year_num - 1) YEAR), '%Y') AS year,
                    COUNT(uf.userHandle) AS signup_count
                FROM 
                    (SELECT 1 AS year_num UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 
                    UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10) AS years
                LEFT JOIN user_info AS uf
                ON uf.joinDate BETWEEN 
                    DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL (year_num - 1) YEAR), '%Y-01-01')
                    AND IF(year_num = 1, CURRENT_DATE(), DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL (year_num - 1) YEAR), '%Y-12-31'))
                GROUP BY year
                ORDER BY year";

        $result = mysqli_query($conn, $sql);
        $monthlyData = mysqli_fetch_all($result);

        $labels = array();
        // $labels[0] = $weeklyData[0][3];
        for ($i = 0; $i < count($monthlyData); $i++) {
            $labels[$i] = $monthlyData[$i][0];
        }
        // print_r($labels);

        $data = array();
        // $data[0] = 0;
        for ($i = 0; $i < count($monthlyData); $i++) {
            $data[$i] = $monthlyData[$i][1];
        }
        // print_r($labels);
        // print_r($data);
        //..........
        break;
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
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="\Admin-Panel\Kairos-removebg-preview.png">
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
    <main class="main-content">
        <div class="container d-flex p-3 ">
            <h1>User Count</h1>
            <hr>
            <!-- Filtered by -->
            <script>
                function submitForm(duration) {
                    document.getElementById('durationInput').value = duration;
                    document.getElementById('durationForm').submit();
                }
            </script>

            <form id="durationForm" action="admin-dashboard.php" method="post">
                <input type="hidden" name="duration" id="durationInput">
            </form>
            <button class="btn btn-primary m-2" type="button" onclick="submitForm('weakly')" id="weakly" name="weakly">Weakly</button>
            
            <button class="btn btn-primary m-2" type="button" onclick="submitForm('monthly')" id="monthly" name="monthly">Monthly</button>
            
            <button class="btn btn-primary m-2" type="button" onclick="submitForm('yearly')" id="yearly" name="yearly">Yearly</button>

            <!-- ............... -->
        </div>
        <div class="main">
        <div class="container h-25 w-50 p-1 m-1 b-2">
            <div class="row">
                <div class="col-4 p-2 m-2">
                    <h1>Pending approvals:</h1>
                    <div class="row p-2 m-2">
                        Book Approval: 10
                    </div>
                    <div class="row p-2 m-2">
                        Notes Approval: 10
                    </div>
                    <div class="row p-2 m-2">
                        Mail Sent: Yes
                    </div>
                </div>
                <div class="col-7">
                    <canvas id="myChart" width="100" height="70"></canvas>
                </div>
            </div>
        </div>
        </div>
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
