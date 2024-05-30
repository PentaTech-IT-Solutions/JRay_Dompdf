<?php 
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
@include('db_con.php');
// Initializing variables to empty strings to be used later                                                                                       
$fullname = $username = $email = $telephone = $password = $confirmpassword = "";
$fullnameErr = $usernameErr = $emailErr = $telephoneErr = $passwordErr = $confirmpasswordErr = "";


// IF THE USER CLICKS ON SIGNUP BUTTON, THEN WE GO AHEAD AND GRAP THE VALUES IN THE INPUT FIELDS
if (isset($_POST['submit'])) {
 $fullname = $_POST['fullname'];
 $username = $_POST['username'];
 $email = $_POST['email'];
 $telephone = $_POST['telephone'];
 $password = $_POST['password'];
 $confirmpassword = $_POST['confirmpassword'];
 
 // FULLNAME VALIDATION
 $fullname = cleanData($fullname);
 if (empty($fullname) || $fullname =="") {
   $fullnameErr = "Name cannot be empty!";
 }elseif (strlen($fullname) < 5) {
   $fullnameErr = "INVALID NAME LENGTH";
 }elseif(!preg_match("/^[a-zA-Z ]*$/", $fullname)){
  $fullnameErr = "INVALID NAME FORMAT";
 }else{
  $fullnameErr ="";
 }
 

 // VALIDATION FOR USERNAME
 $username = cleanData($username);
 if (empty($username) || $username =="") {
   $usernameErr = "Username cannot be empty!";
 }elseif (strlen($username) < 3) {
   $usernameErr = "INVALID USERNAME LENGTH";
 }elseif(!preg_match("/^[a-zA-Z]*$/", $username)){
  $usernameErr = "INVALID USERNAME FORMAT";
 }else{
  $usernameErr ="";
 }


// EMAIL FIELD VALIDATION
 $email = cleanData($email);
 if (empty($email) || $email =="") {
   $emailErr = "Email cannot be empty!";
 }elseif (strlen($email) < 3) {
   $emailErr = "INVALID EMAIL LENGTH";
 }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
  $emailErr = "INVALID EMAIL FORMAT";
 }else{
  $emailErr ="";
 }


 // VALIDATION FOR TELEPHONE NUMBER
 $telephone = cleanData($telephone);
 if (empty($telephone) || $telephone =="") {
   $telephoneErr = "Telephone cannot be empty!";
 }elseif (strlen($telephone) < 10 || strlen($telephone) > 10) {
   $telephoneErr = "Phone number should be only 10 digits";
 }elseif(!preg_match("/^[+0-9]*$/", $telephone)){
  $telephoneErr = "INVALID TELEPHONE FORMAT";
 }else{
  $telephoneErr ="";
 }

 // VALIDATION FOR PASSWORD
 $password = cleanData($password);
 if (empty($password) || $password =="") {
   $passwordErr = "Password cannot be empty!";
 }elseif (strlen($password) < 4 || strlen($password) > 16) {
   $passwordErr = "Password should be between 4 and 16 characters.";
 }elseif(!preg_match("/^[a-zA-Z0-9@#$]*$/", $password)){
  $passwordErr = "INVALID PASSWORD FORMAT";
 }else{
  $passwordErr ="";
 }

 // CONFIRMPASSWORD VALIDATION
 $confirmpassword = cleanData($confirmpassword);
 if (empty($confirmpassword) || $confirmpassword =="") {
   $confirmpasswordErr = "Password cannot be empty!";
 }elseif(!preg_match("/^[a-zA-Z0-9@#]*$/", $confirmpassword)){
  $confirmpasswordErr = "INVALID PASSWORD FORMAT";
 }elseif($confirmpassword !== $password){
  echo "<script>alert('PASSWORD MISMATCH!')</script>";
 }else{
  $confirmpasswordErr ="";
 }

 // IF ERROR EXIST IN ANY OF THE INPUT FIELDS WE ALERT THE USER 

    if(($fullnameErr != "") || ($usernameErr != "") || ($emailErr != "") || ($telephoneErr != "") || ($passwordErr != "") || ($confirmpasswordErr != "")){
        echo "<script>alert('Kindly ensure all fields are accurate.')</script>";

    }else{
try {

  // INCASE NO ERROR HAS BEEN FOUND, WE CHECK THE DATABASE 
  //TO SEE IF THE CURRENT EMAIL OR PASSWORD ALREADY EXIST

  $query = "SELECT username, password FROM pentatech WHERE username = ? OR password = ?";
  $request = $pdo->prepare($query);
  $request->execute([$username, $password]);
  if ($request->rowCount() > 0) {
    echo "<script>alert('Username or Password already exist')</script>";
  }else{
   
    // IF THE CURRENT EMAIL AND PASSWORD DOES NOT EXIST IN THE DATABASE 
    // WE GO AHEAD AND REGISTER THE USER
    
     // $password = md5($password);
     // $confirmpassword = md5($confirmpassword);
    $request = $pdo->prepare("INSERT INTO  pentatech(fullname, username, email, telephone, password, confirmpassword) VALUES(?, ?, ?, ?, ?, ?)");
    $request->execute(array($fullname, $username, $email, $telephone, $password, $confirmpassword));
    $outcome = $request->fetch(PDO::FETCH_ASSOC);
    if ($request->rowCount() > 0) {
      echo "<script>alert('Sign Up was successful!');window.location='signup.php'</script>";
    }else{
      echo "<script>alert('Unsuccessful sign up. Kindly try again!')</script>";
    }
  }
   
  
} catch (Exception $e) {
  echo "Connection failed ".$e->getMessage();
}


 }
}

// THIS FUNCTION WILL VALIDATE AND SANITIZE THE USER DATA
function cleanData($data) {
    $data = trim($data);            
    $data = stripslashes($data);    
    $data = htmlspecialchars($data);
    return $data;
}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Responsive Registration Form | CodingLab</title>
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
      <div class="title">Registration</div>
      <div class="content">
        <form action="signup.php" method="post">
          <div class="user-details">
            <div class="input-box">
              <span class="details">Full Name</span>
              <input type="text" name="fullname" placeholder="Enter your name" required value="<?php echo $fullname ?>" />
              <div class="error-message"><?php echo $fullnameErr; ?></div>
            </div>
            <div class="input-box">
              <span class="details">Username</span>
              <input type="text" name="username" placeholder="Enter your username" required value="<?php echo $username ?>"/>
              <div class="error-message"><?php echo $usernameErr; ?></div>
            </div>
            <div class="input-box">
              <span class="details">Email</span>
              <input type="email" name="email" placeholder="Enter your email" required value="<?php echo $email ?>"/>
              <div class="error-message"><?php echo $emailErr; ?></div>
            </div>
            <div class="input-box">
              <span class="details">Phone Number</span>
              <input type="number" name="telephone" placeholder="Enter your number" required value="<?php echo $telephone ?>"/>
              <div class="error-message"><?php echo $telephoneErr; ?></div>
            </div>
            <div class="input-box">
              <span class="details">Password</span>
              <input type="password" name="password" placeholder="Enter your password" required value="<?php echo $password ?>"/><div class="error-message"><?php echo $passwordErr; ?></div>
            </div>
            <div class="input-box">
              <span class="details">Confirm Password</span>
              <input type="password" name="confirmpassword" placeholder="Confirm your password" required value="<?php echo $confirmpassword ?>"/>
              <div class="error-message"><?php echo $confirmpasswordErr; ?></div>
            </div>
          </div>

          <div class="button">
            <input type="submit" name="submit" value="Register" />
          </div>

          <p>Dont have an accout? <a href="login.php">Signup</a></p>
        </form>
      </div>
    </div>
  </body>
</html>
