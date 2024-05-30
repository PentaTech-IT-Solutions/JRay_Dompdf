<?php 
session_start();
if (!isset($_SESSION['username'])) {
	echo "<script>alert('Ilegal access! Login first.');window.location='login.php'</script>";
}

$current = time();
$timelimit = 5 * 60;
if ($current > $_SESSION['time'] + $timelimit) {
	header("Location: login.php");
}
 
 ?>

 

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Profile</title>
    <link rel="stylesheet" href="styles/style.css?v= <?php echo time(); ?>" />

	<style>
		*{
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		body{
			width: 100%;
			display: flex;
			flex-direction: column;
		}
		.large-container{
			width: 100%;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			padding: 80px;
		}
		.card-container{
			height: ;
			display: flex;
			flex-direction: column;
			background: #fff;
			justify-content: center;
			align-items: flex-start;
			padding: 25px;
			gap: 10px;
			border-bottom: 7px solid #00f;
			border-radius: 30px;
			position: relative;
		}
 
		.email, .telephone{
			background: #00f;
			padding: 10px 20px;
			color: #fff;
			border-radius: 6px;
		}
	 
		#logout{			
			background: #00f;
			font-size: 16px;
			font-weight: normal;
			border-radius: 6px;
			boder: none;
			outline: none;
			padding: 10px;		
			color: #fff;	
		}

		#logout a{
			color: #fff;
			text-decoration: none;
		}
		.dash a{
 			position: absolute; top: 12px; left: 10px; 
			text-decoration: none;
			font-size: 16px;
			color: #fff;
			background: #00f;
			padding: 6px;
			border-radius: 3px;
			margin: 10px;

		}
	</style>
</head>
<body>
	<nav>
		<ul>
			<li><a href="profile.php">Profile</a></li>
			<li><a href="dashboard.php">Dashboard</a></li>
			<li><a href="allMembers.php">Team</a></li>
		</ul>
	</nav>
 
	<div class="large-container">
			<div class="card-container">

				<br>
            
			<h2>Name: <?php echo $_SESSION['fullname']; ?></h2>
			<h3>Username: <?php echo $_SESSION['username']; ?></h3>
			<p>Telephone: <?php echo $_SESSION['telephone']; ?></p>
			<div class="email">Email: <?php echo $_SESSION['email']; ?></div>

				<div class="dash">
					<a href="dashboard.php">Dashboard</a>
				</div>		 
			 
				<a href="logout.php"><button id="logout">Logout</button></a>

				 
			 
      </div>

  
	</div>
 
</body>
</html>