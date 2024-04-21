<?php
    $conn = new mysqli('localhost', 'root', '', 'kairos');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT COUNT(*) AS total_assigned_users FROM user_info";
    $result = $conn->query($sql);
    $user = mysqli_fetch_all($result);

    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to Kairos</title>
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
        .container {
            scroll-snap-type: y mandatory;
            overflow-y: scroll;
            height: 100vh;
            max-width: 100%;
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
        .circular{
  height: 100px;
  width: 100px;
  position: relative;
}
.circular .inner, .circular .outer, .circular .circle{
  position: absolute;
  z-index: 6;
  height: 100%;
  width: 100%;
  border-radius: 100%;
  box-shadow: inset 0 1px 0 rgba(0,0,0,0.2);
}
.circular .inner{
  top: 50%;
  left: 50%;
  height: 80px;
  width: 80px;
  margin: -40px 0 0 -40px;
  background-color: #dde6f0;
  border-radius: 100%;
  box-shadow: 0 1px 0 rgba(0,0,0,0.2);
}
.circular .circle{
  z-index: 1;
  box-shadow: none;
}
.circular .numb{
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 10;
  font-size: 18px;
  font-weight: 500;
  color: #4158d0;
}
.circular .bar{
  position: absolute;
  height: 100%;
  width: 100%;
  background: #fff;
  -webkit-border-radius: 100%;
  clip: rect(0px, 100px, 100px, 50px);
}
.circle .bar .progress{
  position: absolute;
  height: 100%;
  width: 100%;
  -webkit-border-radius: 100%;
  clip: rect(0px, 50px, 100px, 0px);
}
.circle .bar .progress, .dot span{
  background: #4158d0;
}
.circle .left .progress{
  z-index: 1;
  animation: left 4s linear both;
}
@keyframes left {
  100%{
    transform: rotate(180deg);
  }
}
.circle .right{
  z-index: 3;
  transform: rotate(180deg);
}
.circle .right .progress{
  animation: right 4s linear both;
  animation-delay: 4s;
}
@keyframes right {
  100%{
    transform: rotate(180deg);
  }
}
.circle .dot{
  z-index: 2;
  position: absolute;
  left: 50%;
  top: 50%;
  width: 50%;
  height: 10px;
  margin-top: -5px;
  animation: dot 8s linear both;
  transform-origin: 0% 50%;
}
.circle .dot span {
  position: absolute;
  right: 0;
  width: 10px;
  height: 10px;
  border-radius: 100%;
}
@keyframes dot{
  0% {
    transform: rotate(-90deg);
  }
  50% {
    transform: rotate(90deg);
    z-index: 4;
  }
  100% {
    transform: rotate(270deg);
    z-index: 4;
  }
}
    </style>
    <div class="container">
        <section class="one">
            <a href="#" class="btn btn-outline-secondary" style="position: absolute; top: 20px; right: 50px;">About us</a>
            <a href="#" class="btn btn-outline-secondary" style="position: absolute; top: 20px; right: 160px;">Sign up</a>
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
    <div class="row align-items-center"> <!-- Align items to top -->
        <!-- Picture on the left side -->
        <div class="col-md-4"> <!-- Adjust the column width as needed -->
            <img src="Picture of Section2.jpg" alt="Your Image" class="img-fluid">
        </div>
        <!-- Text and circular progress bar on the right side -->
        <div class="col-md-8">
            <div class="row align-items-right"> <!-- Align items vertically centered -->
                <div class="col-md-8"> <!-- Adjust the column width as needed -->
                    <h1>Number of users</h1>
                </div>
                <div class="col-md-4">
                    <!-- Add your circular progress bar here -->
                    <div class="circular">
                        <div class="inner"></div>
                        <div class="outer"></div>
                        <div class="numb">0%</div>
                        <div class="circle">
                            <div class="dot"><span></span></div>
                            <div class="bar left"><div class="progress"></div></div>
                            <div class="bar right"><div class="progress"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        <section class="three">
            <h1>Third Page</h1>
        </section>
    </div>
    <script>
            const numb = document.querySelector(".numb");
            let counter = 0;
            setInterval(()=>{
              if(counter == <?php echo implode("", $user[0]);?>){
                clearInterval();
              }else{
                counter+=1;
                numb.textContent = counter;
              }
            }, 80);
    </script>
</body>
</html>