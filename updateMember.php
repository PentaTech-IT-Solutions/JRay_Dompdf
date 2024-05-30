<?php 
@include('db_con.php');

$id = $file = $firstname = $lastname = $job = $department = $description = ""; 
$fileErr = $firstnameErr = $lastnameErr = $jobErr = $departmentErr = $descriptionErr = ""; 

if (isset($_GET['id'])) {
	$result = $pdo->prepare("SELECT id, file, firstname, lastname, job, department, description FROM team WHERE id = ?");
	$result->execute(array($_GET['id']));
    if ($result->rowCount() > 0) {
      $fetched = $result->fetch(PDO::FETCH_ASSOC);

    	/// STORING THE FETCHED DATA IN VARIABLES
      $id = $fetched['id'];
    	$file = $fetched['file'];
    	$firstname = $fetched['firstname'];
    	$lastname = $fetched['lastname'];
    	$job = $fetched['job'];
    	$department = $fetched['department'];
    	$description = $fetched['description'];
    }
  }


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
      
      $firstname = sanitazeInput($firstname);
      $lastname = sanitazeInput($lastname);
      $job = sanitazeInput($job);
      $department = sanitazeInput($department);
      $description = sanitazeInput($description);


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
		}else{
			$fileErr = 'Invalid file type';
		}
	}

	if ($idealSize && $idealType) {
		switch ($_FILES['file']['error']) {
			case 0:
			define("FILE_LOCATION", 'uploads/');
			if (!file_exists(FILE_LOCATION.$file)) {
				 $upload = move_uploaded_file($_FILES['file']['tmp_name'], FILE_LOCATION.$file);
			}else{

				$random = rand(1, 600);
				$file = $file.$random;
                $upload = move_uploaded_file($_FILES['file']['tmp_name'], FILE_LOCATION.$file); 

			}
				 
				break;
			
			default:
			    $fileErr = 'Invalid image format';
				break;
		}
 	}


      // THIS CODES UPDATE THE USER PROFILE ACCORDING TO THE NEW VALUES IN THE INPUT FIELDS
    	$query = "UPDATE team SET file = ?, firstname = ?, lastname = ?, job = ?, department = ?, description = ? WHERE id = ?";
    	$result = $pdo->prepare($query);
    	$result->execute([$file, $firstname, $lastname, $job, $department, $description, $id]);
    	if ($result->rowCount() > 0) {
    		echo "<script>alert('Record updated successfully.');window.location='dashboard.php'</script>";
    	}else{
        echo "<script>alert('Unsuccessful. Try again.')</script>";
      }
    }

     function sanitazeInput($input){
      $input = trim($input);
      $input = htmlspecialchars($input);
      $input = stripcslashes($input);
      return $input;
    }

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Update</title>
    <link rel="stylesheet" href="./styles/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <style type="text/css">
    .error-message{
      color: red;
    }
  </style>
  <body>
    <div class="container">
      <div class="title">Update Team Member</div>
      <div class="content">
        <form action="updateMember.php?id=<?php echo $id  ?>" method="post" enctype="multipart/form-data">
          <div class="user-details">
            <div class="input-box">
              <span class="details">Profile Picture</span>
              <img src="uploads/<?php echo $file ?>" width = "80px">
              <input type="file" name="file" placeholder="Select Image" required />
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
            <input type="submit" name="submit" value="Update Record" />
          </div>

        </form>
      </div>
    </div>
  </body>
</html>

