<?php 
@include('db_con.php');

// if (isset($_GET['id'])) {
$result = $pdo->prepare("SELECT * FROM team WHERE id = ?");
$result->execute([$_GET['id']]);
$member = $result->fetch(PDO::FETCH_ASSOC);
// }
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>Detail Page</title>
    <link rel="stylesheet" href="styles/style.css?v= <?php echo time(); ?>" />
 </head>
 <style>
     body{
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center; justify-content: flex-start;
     }
 </style>
 <body>
  <nav>
    <ul>
      <li><a href="profile.php">Profile</a></li>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="allMembers.php">Team</a></li>
    </ul>
  </nav>


    <div class="member">

        <img src="uploads/<?php echo $member['file'] ; ?>" width="250px" height="250px">
        <div><?php echo $member['firstname']." " .$member['lastname'] ; ?></div>
        <div><?php echo $member['job'] ; ?></div>
        <div><?php echo $member['department'] ; ?></div>
        <div><?php echo $member['description'] ; ?></div>        
        
    </div>

 	
 </body>
 </html>