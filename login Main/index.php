<?php
session_start();
include("connection.php");
include("functions.php");
    
$user_data = check_login($con);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Index</title>
    <style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f4;
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
		}
		.container {
			text-align: center;
			background-color: #fff;
			border-radius: 8px;
			padding: 20px;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
			max-width: 300px;
			width: 90%;
		}
		h1 {
			color: #333;
		}
	</style>
</head>
<body>
    <div class="container">
    <h1>Welcome to the Index!</h1>
    <p>You have loged in successfully</p>
    <a href="logout.php" class="btn btn-primary">Logout</a>
    </div>
</body>
</html>