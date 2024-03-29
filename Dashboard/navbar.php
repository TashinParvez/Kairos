<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>kairos</title>
    <!-- CSS Links -->
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- Bootstrap and Masonry -->
    <script defer src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>

</head>
<body class="bg-warning p-2 text-dark bg-opacity-10">

    <!-- ------------------------------------------------------------------ -->
    <!-------------------------------- Navbar -------------------------------->
    <!-- ------------------------------------------------------------------ -->

    <nav class="navbar navbar-expand-lg bg-light m-3 border rounded">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../images/logo2.png" alt="Bootstrap" height="55" style="
                padding-left: 19px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll mx-auto" style="--bs-scroll-height: 100px;">


                    <li class="nav-item tashin">
                        <a class="nav-link active fw-bold" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item tashin ps-4">
                        <a class="nav-link active fw-bold" aria-current="page" href="#">Community</a>
                    </li>
                    <li class="nav-item tashin ps-4">
                        <a class="nav-link active fw-bold" aria-current="page" href="#">Goals</a>
                    </li>
                    <li class="nav-item tashin ps-4">
                        <a class="nav-link active fw-bold" aria-current="page" href="#">Loops</a>
                    </li>
                    <li class="nav-item tashin ps-4">
                        <a class="nav-link active fw-bold" aria-current="page" href="#">Blogs</a>
                    </li>


                    <li class="nav-item dropdown ps-4">
                        <a class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Link__TASHIN
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Exersise</a></li>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="#">Diet</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
</body>