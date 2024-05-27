<?php
$conn = new mysqli('localhost', 'root', '', 'kairos');

if ($conn->connect_error) {
    exit('Connection failed: '.$conn->connect_error);
}

$sql = 'SELECT COUNT(*) AS total_assigned_users FROM user_info';
$result = $conn->query($sql);
$user = mysqli_fetch_all($result);

$sqli = 'SELECT COUNT(*) AS total_assigned_users FROM category';
$resulti = $conn->query($sqli);
$com = mysqli_fetch_all($resulti);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to Kairos</title>
    <link rel="icon" type="image/x-icon" href="/Images/Picture1.png">
    <link rel="stylesheet" href="style.css" /><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Reddit+Mono:wght@200..900&display=swap");
        * {
            margin: 0;
            padding: 0;
            font-family: "Reddit Mono", sans-serif;
        }
        section {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            scroll-snap-align: start;
        }
        #mainCon {
            scroll-snap-type: y mandatory;
            overflow-y: scroll;
            height: 100vh;
            max-width: 100%;
        }
        #secCon {
            height: 100vh;
            max-width: 100%;
            margin: 0;
        }
        .wrapper{
            display: flex;
        }
        .wrapper .static-txt{
            color: black;
            font-size: 60px;
            font-weight: 400;
        }
        .wrapper .dynamic-txts{
            margin-left: 15px;
            height: 90px;
            line-height: 90px;
            overflow: hidden;
        }
        .dynamic-txts li{
            list-style: none;
            color: #FC6D6D;
            font-size: 65px;
            font-weight: 500;
            position: relative;
            top: 0;
            animation: slide 12s steps(4) infinite;
        }
        @keyframes slide {
        100%{
            top: -360px;
        }
        }
        .dynamic-txts li span{
            position: relative;
            margin: 5px 0;
            line-height: 90px;
        }
        .dynamic-txts li span::after{
            content: "";
            position: absolute;
            left: 0;
            height: 100%;
            width: 100%;
            background: white;
            border-left: 2px solid #FC6D6D;
            animation: typing 3s steps(10) infinite;
        }
        @keyframes typing {
            40%, 60%{
                left: calc(100% + 30px);
            }
            100%{
                left: 0;
            }
        }
        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url(''); /* Set the background image path */
            background-size: cover;
            background-position: center;
            z-index: -1; /* Ensure the background image stays behind other content */
        }
        .one {
            background-image: url('Picture3.svg'); /* Set the background image path */
            background-size: cover; /* Cover the entire section */
            background-size: 80% auto; /* Cover the entire section */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* Do not repeat the background image */
        }
        .two {
            background-image: url('picture2.svg'); /* Set the background image path */
            background-size: cover; /* Cover the entire section */
            background-size: 80% auto; /* Cover the entire section */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* Do not repeat the background image */
        }
    </style>
    <div class="container" id="mainCon">
    <div class="background-image"></div>
        <section class="one">
            <img src="\Images\logo2.png" class="navImg" style="position: absolute; top: 20px; left: 50px; width: 150px; height: 150px;">
            <a href="/Sign Up/SignUp2.php" class="btn btn-outline-secondary" style="position: absolute; top: 20px; right: 50px;">About us</a>
            <a href="/Sign Up/SignUp2.php" class="btn btn-outline-secondary" style="position: absolute; top: 20px; right: 160px;">Sign up</a>
            <div class="wrapper">
                <div class="static-txt">We're your</div>
                <ul class="dynamic-txts">
                    <li><span>Well Wisher</span></li>
                    <li><span>Personal Assisant</span></li>
                    <li><span>Habit Builder</span></li>
                    <li><span>Loop Breaker</span></li>
                </ul>
            </div>
        </section>
        <section class="two">
            <div class="row justify-content-center p-3">
            <div class="card shadow border-0 col mx-3" style="max-width: 14rem;">
                <div class="card-body text-center">
                    <h1><?php echo implode('', $user[0]); ?>+</h1>
                    <p class="card-text">Number of Active users</p>
                </div>
            </div>
            <div class="card shadow border-0 col mx-3" style="max-width: 14rem;">
                <div class="card-body text-center">
                    <h1><?php echo implode('', $com[0]); ?>+</h1>
                    <p class="card-text">Number of Active Communities</p>
                </div>
            </div>
            <div class="card shadow border-0 col mx-3" style="max-width: 14rem;">
                    <div class="card-body text-center">
                        <h1>70%</h1>
                        <p class="card-text">Improvement of time efficiency</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="three">
            <div class="row justify-content-center p-3">
                <div class="card shadow border-0 col mx-3" style="max-width: 14rem;">
                    
                </div>
                <div class="card shadow border-0 col mx-3" style="max-width: 14rem;">
                    <div class="card-body text-center">
                        <h1><?php echo implode('', $com[0]); ?>+</h1>
                        <p class="card-text">Number of Active Communities</p>
                    </div>
                </div>
                <div class="card shadow border-0 col mx-3" style="max-width: 14rem;">
                        <div class="card-body text-center">
                            <h1>70%</h1>
                            <p class="card-text">Improvement of time efficiency</p>
                        </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>