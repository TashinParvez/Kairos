<?php

include('../Kairos/Dashboard/connect_db.php'); // database connection

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

</head>

<body>

    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">

            <div class="carousel-item active">
                <div class="row justify-content-between">
                    <div class="col-2">

                        <div class="card mb-3">
                            <!-- Card 1 --> <?php include('/Kairos/Others/CarouselCard/try2.php'); ?>
                        </div>

                    </div>
                    <div class="col-2">
                        <div class="card mb-3">
                            <!-- Card 2 --> <?php include('/Kairos/Others/CarouselCard/try2.php'); ?>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="card mb-3">
                            <!-- Card 3 --> <?php include('/Kairos/Others/CarouselCard/try2.php'); ?>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="card mb-3">
                            <!-- Card 3 --> <?php include('/Kairos/Others/CarouselCard/try2.php'); ?>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="card mb-3">
                            <!-- Card 3 --> <?php include('/Kairos/Others/CarouselCard/try2.php'); ?>
                        </div>
                    </div>

                </div>
            </div>

            <!--------------------- Add more carousel items with 3 cards each --------------------->

            <div class="carousel-item ">
                <div class="row">
                    <div class="col">

                        <div class="card mb-3">
                            <!-- Card 1 --> <?php include('/Kairos/Others/CarouselCard/try2.php'); ?>
                        </div>

                    </div>
                    <div class="col">
                        <div class="card mb-3">
                            <!-- Card 2 --> <?php include('/Kairos/Others/CarouselCard/try2.php'); ?>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-3">
                            <!-- Card 3 --> <?php include('/Kairos/Others/CarouselCard/try2.php'); ?>
                        </div>
                    </div>

                </div>
            </div>



            <!-- ------------------------------------------ -->
        </div>

        <!-- Carousel control buttons -->
        <button class="carousel-control-prev btn btn-outline-primary" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next btn btn-outline-primary" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>





</body>

</html>