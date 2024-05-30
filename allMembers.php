<?php 
@include('db_con.php');

try {
	$result = $pdo->prepare("SELECT * FROM team");
	$result->execute(array());

	
} catch (Exception $e) {
	
}

 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>Team Members</title>
 	  <link rel="stylesheet" href="styles/style.css?v= <?php echo time(); ?>" />
 </head>
 <body>
  <nav>
    <ul>
      <li><a href="profile.php">Profile</a></li>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="allMembers.php">Team</a></li>
    </ul>
  </nav>

 	<div class="team">
 <?php foreach ($result as $member) { ?>
 	<a href="dompdf.php?id=<?php echo $member['id'] ?>">
 		<img src="uploads/<?php echo $member['file'] ; ?>" width="250px" height="250px">
 		<div><?php echo $member['firstname']." " .$member['lastname'] ; ?></div>
 		<div><?php echo $member['job'] ; ?></div>
 	</a>
 <?php } ?>
   </div>


 <style>
 	body{
 		display: flex;
 		flex-direction: column;
 		width: 100%;
    justify-content: flex-start;
 	}
 	.team{
 		display: flex;
 		gap: 20px;
    flex-wrap: wrap;
    padding: 40px;
 	}
    .team a{
    	color: #000;
    	text-decoration: none;
    }
 	
 </style>
 </body>
 </html>