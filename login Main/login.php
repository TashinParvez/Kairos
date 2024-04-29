<?php 

session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$mail = $_POST['mail'];
		$password = $_POST['password'];
		if(!empty($mail) && !empty($password) && !is_numeric($mail))
		{
			$query = "select * from user_info where mail = '$mail' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{
					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{
						echo 'Done';
						$_SESSION['userHandle'] = $user_data['userHandle'];
						header("Location: index.php");
						die;
					}
				}
			}
		}
		else
		{
			echo "wrong username or password!";
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<title>Login</title>
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
	<style type="text/css">
	
	#text{

		height: 25px;
		border-radius: 5px;
		padding: 4px;
		border: solid thin #aaa;
		width: 100%;
	}
	#box{

		background-color: grey;
		margin: auto;
		width: 300px;
		padding: 20px;
	}

	</style>
	
	<div class="container">
	<h1>Log In</h1>
	<form method="post">
			<div class="form-floating mb-3">
				<input type="text" class="form-control" id="floatingInput" name="mail" placeholder="name@example.com">
				<label for="floatingInput">E-mail</label>
			</div>
			<div class="form-floating">
				<input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
				<label for="floatingPassword">Password</label>
			</div><br>
			<input class="btn btn-primary" type="submit" value="Login">
			<a href="signup.php" class="btn btn-secondary">Click to Signup</a><br><br>
		</form>
	</div>
	</div>
</body>
</html>