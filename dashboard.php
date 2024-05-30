<?php 
//session_start();

require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;


require_once __DIR__ . '/vendor/autoload.php'; // Adjust the path as needed

$options = new Options;
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf([
    "chroot" => __DIR__,
]);
 // $dompdf->set_option('isHtml5ParserEnabled', true);


session_start();

// THIS BLOCK OF CODES CHECK SESSION SECURITIES

//IF A USER TRYS TO ACCESS THE DASHBOARD WITHOUT LOGGING INN
// WE REDIRECT THEM TO THE LOGIN PAE
ini_set("date.timezone", "Africa/Accra");

// if (!isset($_SESSION['username'])) {
// 	echo "<script>alert('Ilegal access! Login first.');window.location='login.php'</script>";
// }

// IF THE USER IS LOGGED IN FOR MORE THAN THE DEFINED TIME 
// WE SEND THEM BACK TO THE LOGIN PAGE
// $currentTime = time();
// $allowedTime = 5 * 60;
// if ($currentTime > $_SESSION['time'] + $allowedTime) {
// 	echo "<script>alert('Your login has expired.');window.location='login.php'</script>";
// }

$_SESSION['dashboard_redirection'] = true;
 @include('db_con.php');


$id = $file = $firstname = $lastname = $job = $department = $description ="";

try {   /// IF USER CLICKS ON SEARCH BUTTON THEN WE SELECT ONLY THE SEARCHED DATA
	if (isset($_GET['search'])) {
	   $searchedItem = htmlspecialchars($_GET['search']);
	   $result = $pdo->prepare("SELECT * FROM team WHERE firstname LIKE ? OR lastname LIKE ?");
	   $result->execute(["%$searchedItem%", "%$searchedItem%"]); //$_GET['search'], $_GET['search']

	   // IF THERE IS NO SEARCH THEN WE SELECT ALL THE DATA AND DISPLAY ONLY 10
	}else{
	   $result = $pdo->prepare("SELECT * FROM team LIMIT 10");
	   $result->execute([]);
	}

	
} catch (Exception $e) {
	echo "Error occurred " .$e->getMessage();
}

 

 $html = '

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Dashboard</title>
	 
   
	<style>
		*{
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			text-decoration: none;
		}

		.nav{
			width: 100%;
			height: 80px;
			background: #fff;
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 0 40px;
		}
		.logo{
			font-size: 35px;
			color: #0000ff;
		}
		 #input{
		 	font-size: 20px;
		 	padding: 10px;
		 	border: 1px solid #0000ff;
		 	outline: none;
		 }
		 #search-button{
		 	padding: 10px 15px;
		 	font-size: 20px;
		 	color: #fff;
		 	background: #0000ff;
		 	border: 1px solid #0000FF;
		 	outline: none;
		 	cursor: pointer;
		 }
		 .add-button{
		 	padding: 10px 15px;
		 	font-size: 20px;
		 	color: #fff;
		 	background: #0000ff;
		 	border: 1px solid #0000FF;
		 	outline: none;		
		 	cursor: pointer; 	
		 }

		.large-container{
			width: 100%;
			height: 100vh;
			padding: 40px 0;
			background: #eee;
			display: flex;
			justify-content: space-between;
			position: relative;
		}
	    nav{
	    	width: 200px;
	    	height: 100vh;
	    	background: #fff;
	    	display: flex;
	    	flex-direction: column;
/*	    	align-items: center;*/
	    	padding: 40px 15px;
	    	position: absolute;
	    	top: 0;
	    	gap: 40px;
	    	 
	    }
	    nav ul{
	    	display: flex;
	    	flex-direction: column;
	    	gap: 30px;
	    	list-style-type: none;
	    }	
	    nav ul li a{
	    	font-size: 25px;
	    	color: #000;
	    }
	    .dashboard{
	    	background: #0000ff;
	    	color: #fff;
	    	border: none;
	    	outline: none;
	    	padding: 10px 15px;
	    	font-size: 25px;
	    }
	    .display-col{
	    	display: flex;
	    	flex-direction: column;
	    	gap: 40px;
	    	width: ;
	    	position: absolute;
	    	right: 20px; 
	    	align-items: center;
	    	 
	    	 
	    }
	    table p{
	     	width: 100px;
	     	white-space: nowrap;
	     	overflow: hidden;
	     	text-overflow: ellipsis;
	     }

	     td button{
	     	background: #0000ff;
	     	color: #fff;
	     	padding: 6px;
	     	border: none;
	     	outline: none;
	    	font-size: 18px;
	     	cursor: pointer;
	     }
	     .delete{background: #ff0000}

	     table img{
	     	height: 60px;
	     	width: 80px;
	     }



	   //  table{
	   //  	width: 100%;
	   //  	display: flex;
	   //  	white-space: nowrap;
	   //  	overflow-x: auto;
	   //  	justify-content: center;
	   //  }
	  
	   //  td button{
	   //  	background: #0000ff;
	   //  	color: #fff;
	   //  	padding: 6px;
	   //  	border: none;
	   //  	outline: none;
	   //  	font-size: 18px;
	   //  	cursor: pointer;
	   //  }
	   //  .delete{background: #ff0000}

	   // table p{
	   //  	width: 100px;
	   //  	white-space: nowrap;
	   //  	overflow: hidden;
	   //  	text-overflow: ellipsis;
	   //  }
	   //  table img{
	   //  	height: 60px;
	   //  	width: 80px;
	   //  }
         @media screen and (max-width: 1166px) {
	    	table p{
	    		width: 80px;
	    	}
	    }

	</style>	


</head>
<body>
<div class="nav">
    <!--	<h3 class="logo">Logo</h3>
	<form>
		<input type="text" name="search" placeholder="Search here..." id="input">
		<button type="submit" name="" id="search-button">Search</button>
	</form>
	<a href="AddMember.php"><button class="add-button">Add Member</button></a>
	>
 
</div>
<div class="large-container">
    <!---	<nav>
		<button class="dashboard">Dashboard</button>
		<ul>
			<li><a href="profile.php">Profile</a></li>
			<li><a href="signup.php">Register</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
	</nav> --->


	<div class="display-col">
 

 <table border="3" cellspacing="2" cellpadding="10">
 	<tr>
 		<th><p>Picture</p></th>
 		<th><p>First Name</p></th>
 		<th><p>Last Name</p></th>
 		<th><p>Job Title</p></th>
 		<th><p>Department</p></th>
 		<th><p>Description</p></th>
 		<th><p>Update</p></th>
 		<th><p>Delete</p></th>
 	</tr>';



 	
 	 
 	 if(isset($result)) {

 		  foreach ($result as $value) {

          $html .= '
            <tr>
 		<td><img src="uploads/' . $value['file'] . '" hight="50px" width="50px"></td>
 		<td><p>' . $value['firstname'] . '</p></td>
 		<td><p>' . $value['lastname'] . '</p></td>
 		<td><p>' . $value['job'] . '</p></td>
 		<td><p>' . $value['department'] . '</p></td>
 		<td><p>' . $value['description'] . '</p></td>
 	    <td><button><a style="color: white;" href="updateMember.php?id=' . $value['id'] . '" >Update</a></button></td>	
 	     <td><button class="delete" onclick="return confirm("Delete?")"><a href="deleteMember.php?id=' . $value['id'] . '" style="color: white;">Delete</a></button></td>	
 		 		 		
 	   </tr>';	
 	   }
} else {
    // Display a message if $result is not set
    $html .= '<tr><td colspan="8">No data available</td></tr>';
}

$html .= '

 </table>

	</div>


</div>

<script>
    // JavaScript code to handle downloading the PDF
    document.getElementById("download-pdf-button").addEventListener("click", function() {
        // Send a request to the server to generate and download the PDF
        window.location.href = "generate_pdf.php";
    });
</script>
</body>
</html>
';


$dompdf->loadHtml($html);

// Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render PDF (optional: increase rendering time and quality)
$dompdf->render();

//$dompdf->set_option('isHtml5ParserEnabled', true);

// Output PDF to browser
$dompdf->stream("members.pdf", array("Attachment" => false));
