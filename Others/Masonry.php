<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .container {
            width: 1400px;
            margin: 20px auto;
            columns: 4;
            column-gap: 40px;
        }

        .container.box {
            width: 100%;
            margin-bottom: 10px;
            break-inside: avoid;
        }

        .box img {
            max-width: 100%;
            border-radius: 15px;

        }

        @media (max-width: 268px) {
            .container {
                width: calc(100% 40px);
                columns: 2;
            }
        } 
        
        @media (max-width: 268px) {
            .container {
                width: calc(100% 40px);
                columns: 2;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="box"> <img src="/Images/logo.png" alt=""> </div>
        <div class="box"> <img src="/Images/logo.png" alt=""> </div>
        <div class="box"> <img src="/Images/logo.png" alt=""> </div>
        <div class="box"> <img src="/Images/logo.png" alt=""> </div>
        <div class="box"> <img src="/Images/logo.png" alt=""> </div>
        <div class="box"> <img src="/Images/logo.png" alt=""> </div>
        <div class="box"> <img src="/Images/logo.png" alt=""> </div>
        <div class="box"> <img src="/Images/logo.png" alt=""> </div>
    </div>
</body>

</html>