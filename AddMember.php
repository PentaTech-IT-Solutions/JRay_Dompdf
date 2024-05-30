<?php 
 $file = $firstname = $lastname = $job = $department = $description ="";
$fileErr = $firstnameErr = $lastnameErr = $jobErr = $departmentErr = $descriptionErr ="";
@include('db_con.php');

// THESE CODES GET MEMBERS DETAILS FROM THE INPUT FIELD 
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (isset($_GET['file'])) {
		$file = $_POST['file'];
	}
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$job = $_POST['job'];
	$department = $_POST['department'];
	$description = $_POST['description'];

  /// VALIDATION OF INPUT VALUES

      if (strlen($firstname) == 0 || strlen($lastname) == 0 || strlen($job) == 0 || strlen($department) == 0 || strlen($description == 0))  {
        echo "<script>alert('All fields are required!')</script>";
      }
      $firstname = sanitizeInput($firstname);
      $lastname = sanitizeInput($lastname);
      $job = sanitizeInput($job);
      $department = sanitizeInput($department);
      $description = sanitizeInput($description);


    
    // THESE CODES ARE FOR THE IMAGE UPLOAD
	$file = $_FILES['file']['name'];
	$file = str_replace(" ", "_", $file);

	define("FILE_SIZE", 80000);
	$size = number_format(FILE_SIZE/1024, 1)."KB";
	$idealSize = false;

	if ($_FILES['file']['size'] > 0 || $_FILES['file']['size'] <= $size) {
		$idealSize = true;
	}else{
		$fileErr = 'File is too large';
	}

	$idealType = false;
	$filetype = ['image/jpg', 'image/jpeg', 'image/png', 'image/tiff', 'image/gif', 'image/bmp'];
	foreach ($filetype as $type) {
		if ($_FILES['file']['type'] == $type) {
			$idealType = true;
		}
    // else{
		// 	$fileErr = 'Invalid file type';
		// }
	}

	if ($idealSize && $idealType) {
		if ($_FILES['file']['error'] === 0) {
			define("FILE_LOCATION", 'uploads/');
			if (!file_exists(FILE_LOCATION.$file)) {
				 $upload = move_uploaded_file($_FILES['file']['tmp_name'], FILE_LOCATION.$file);
			}else{

				$random = rand(1, 600);
				$file = $file.$random;
                $upload = move_uploaded_file($_FILES['file']['tmp_name'], FILE_LOCATION.$file); 

			}
		}else{
			$fileErr = "Invalid image format";
		}
	}

	/// THIS BLOCK OF CODE INSERT THE DATA IN TO THE DATABASE

   $query = "INSERT INTO team(file, firstname, lastname, job, department, description) VALUES(?, ?, ?, ?, ?, ?)";
   $result = $pdo->prepare($query);
   $result->execute([$file, $firstname, $lastname, $job, $department, $description]);
   if ($result->rowCount() > 0) {
   	echo "<script>alert('Team member added successfully!')</script>";
   }else{
   	echo "<script>alert('Unsuccessful! Kindly try again.')</script>";
   }





}

function sanitizeInput($input){
  $input = stripcslashes($input);
  $input = trim($input);
  $input = htmlspecialchars($input);

  return $input;
}
 
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Create</title>
    <link rel="stylesheet" href="styles/style.css?v= <?php echo time(); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <style type="text/css">
    .error-message{
      color: red;
    }
    body{
      display: flex;
      flex-direction: column;
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

    <div class="container">
      <div class="title">Add Team Member</div>
      <div class="content">
        <form action="AddMember.php" method="post" enctype="multipart/form-data">
          <div class="user-details">
            <div class="input-box">
              <span class="details">Profile Picture</span>
              <input type="file" name="file" placeholder="Select Image" required value="<?php echo $file ?>" />
              <div class="error-message"><?php echo $fileErr; ?></div>
            </div>
            <div class="input-box">
              <span class="details">First Name</span>
              <input type="text" name="firstname" placeholder="First Name" required value="<?php echo $firstname ?>"/>
              <div class="error-message"><?php echo $firstnameErr; ?></div>
            </div>

            <div class="input-box">
              <span class="details">Last Name</span>
              <input type="text" name="lastname" placeholder="Last Name" required value="<?php echo $lastname ?>"/>
              <div class="error-message"><?php echo $lastnameErr; ?></div>
            </div>

            <div class="input-box">
              <span class="details">Job Title</span>
              <input type="text" name="job" placeholder="Job Title" required value="<?php echo $job ?>"/>
              <div class="error-message"><?php echo $jobErr; ?></div>
            </div>
            <div class="input-box">
              <span class="details">Department</span>
              <input type="text" name="department" placeholder="Department" required value="<?php echo $department ?>"/>
              <div class="error-message"><?php echo $departmentErr; ?></div>
            </div>
            <div class="input-box">
              <span class="details">Descriptions</span>
              <input type="text" name="description" placeholder="Description" required value="<?php echo $description ?>"/><div class="error-message"><?php echo $descriptionErr; ?></div>
            </div>

          </div>

          <div class="button">
            <input type="submit" name="submit" value="Add Member" />
          </div>

          <!-- <p>Dont have an accout? <a href="login.php">Signup</a></p> -->
        </form>
      </div>
    </div>
  </body>
</html>

