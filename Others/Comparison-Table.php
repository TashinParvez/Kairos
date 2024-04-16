<?php

include('../Dashboard/connect_db.php'); // database connection

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

    <!-- CSS -->
    <link rel="stylesheet" href="../Includes/style.css">

</head>

<body>


    <div class="container pb-5 mb-2">
        <div class="comparison-table">
            <table class="table table-bordered">
                <tbody id="summary" data-filter="target">
                    <tr class="bg-secondary">
                        <th class="text-uppercase col-1"></th>
                        <td class="text-align-center"><span class="text-dark font-weight-semibold">Apple iPhone Xs Max</span></td>
                        <td><span class="text-dark font-weight-semibold align-content-center">Google Pixel 3 XL</span></td>
                    </tr>
                    <tr>
                        <th>Performance</th>
                        <td>Hexa Core</td>
                        <td>Octa Core</td>

                    </tr>
                    <tr>
                        <th>Display</th>
                        <td>6.5-inch</td>
                        <td>6.3-inch</td>
                    </tr>
                    <tr>
                        <th>Storage</th>
                        <td>64 GB</td>
                        <td>64 GB</td>
                    </tr>
                    <tr>
                        <th>Camera</th>
                        <td>Dual 12-megapixel</td>
                        <td>12.2-megapixel</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


</body>

</html>