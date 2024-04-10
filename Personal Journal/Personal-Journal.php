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
    <?php
    include('../Includes/NavBar.php');
    include('../Includes/Sidebar.php');
    ?>

    <!-- ------------------------ Main Segment ------------------------------- -->

    <main class="main shadow">
        <div class="row bg-white">
            <div class="col-sm-6 bg-white">
                <!--Write Your Page Name Here-->
                <h1>Demo Name</h1>
            </div>
            <div class="col-sm-4 bg-transparent"></div>
            <div class="col-sm-auto bg-white">
                <div class="container-fluid bg-white p-2 align-items-right">
                    <form action="">
                        <input type="search" required>
                        <i class="fa fa-search"></i>
                        <span id="search-txt">Search</span>
                        <a-main href="javascript:void(0)" id="clear-btn"></a-main>
                    </form>
                </div>
            </div>
        </div>
        <!--You Start Writing Content Here-->
    </main>


    <!-------------------------- To Add Any Script, Add Here -------------------------->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        const clearInput = () => {
            const input = document.getElementsByTagName("input")[0];
            input.value = "";
        }
        const clearBtn = document.getElementById("clear-btn");
        clearBtn.addEventListener("click", clearInput);
    </script>
</body>

</html>