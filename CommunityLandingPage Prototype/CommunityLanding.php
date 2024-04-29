<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kairos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png"></link>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        include '../Includes/NavBarSecond.php'; // uncomment
    include '../Includes/Sidebar.php'; // uncomment
    ?>
    <main class="main shadow">
        <div class="row bg-white">
            <div class="col-sm-6 bg-white">
                <h1>Communities</h1>
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
            <div class="bg-white">
                <div class="row bg-white">
                    <div class="col-sm-auto bg-white">
                        <div class="card bg-white" style="width: 18rem;">
                            <img src="/Images/Community/PersonalGrowth.jpg" class="card-img-top" alt="...">
                            <div class="card-body bg-white">
                              <h5 class="card-title bg-white">Reflective Growth Bubble</h5>
                              <p class="card-text">Forum to Discuss about Personal problems and solutions</p>
                              <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-auto bg-white">
                        <div class="card bg-white" style="width: 18rem;">
                            <img src="/Images/Community/Namaz.jpg" class="card-img-top" alt="...">
                            <div class="card-body bg-white">
                              <h5 class="card-title bg-white">Salah</h5>
                              <p class="card-text">Forum where we keep track of your Namaz</p>
                              <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-auto bg-white">
                        <div class="card bg-white" style="width: 18rem;">
                            <img src="/Images/Community/Books.jpg" class="card-img-top" alt="...">
                            <div class="card-body bg-white">
                              <h5 class="card-title bg-white">Bookworms</h5>
                              <p class="card-text">Where book lovers gather to explore diverse literary worlds, share insights, and foster a community of passionate readers.</p>
                              <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h4 class="bg-white">Recommended for you</h4>
                <div class="row bg-white">
                    <div class="col-sm-auto bg-white">
                        <div class="card bg-white" style="width: 18rem;">
                            <img src="/Images/Community/PersonalGrowth.jpg" class="card-img-top" alt="...">
                            <div class="card-body bg-white">
                              <h5 class="card-title bg-white">Reflective Growth Bubble</h5>
                              <p class="card-text">Forum to Discuss about Personal problems and solutions</p>
                              <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-auto bg-white">
                        <div class="card bg-white" style="width: 18rem;">
                            <img src="/Images/Community/Namaz.jpg" class="card-img-top" alt="...">
                            <div class="card-body bg-white">
                              <h5 class="card-title bg-white">Salah</h5>
                              <p class="card-text">Forum where we keep track of your Namaz</p>
                              <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-auto bg-white">
                        <div class="card bg-white" style="width: 18rem;">
                            <img src="/Images/Community/Books.jpg" class="card-img-top" alt="...">
                            <div class="card-body bg-white">
                              <h5 class="card-title bg-white">Bookworms</h5>
                              <p class="card-text">Where book lovers gather to explore diverse literary worlds, share insights, and foster a community of passionate readers.</p>
                              <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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