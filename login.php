<?php 
 session_start();
@include("db_con.php");
$username = $password = "";
$usernameErr = $passwordErr =  "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $username = cleanData($username);
  $password = cleanData($password);

  $request = $pdo->prepare("SELECT * FROM pentatech WHERE username = ? AND password = ?");
  $request->execute([$username, $password]);
  $row = $request->fetch(PDO::FETCH_ASSOC);

  if ($request->rowCount() > 0) {
    $_SESSION['time'] = time();
    $_SESSION['username'] = $username;
    $_SESSION['fullname'] = $row['fullname'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['telephone'] = $row['telephone'];
     
    if ($_SESSION['dashboard_redirection'] && $_SESSION['dashboard_redirection'] == true) {
      header("Location: dashboard.php");
    }else{
      header("Location: dashboard.php");
    }
  }else{
    echo "<script>alert('Incorrect Username or Password. Kindly try again!')</script>";
  }
}
 
function cleanData($data){
  $data = htmlspecialchars($data);
  $data = trim($data);
  $data = stripcslashes($data);
  return $data;
}


// $dompdf = new Dompdf([
//     "chroot" => __DIR__
// ]);

?>

 

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Responsive Registration Form | CodingLab</title>
    <link rel="stylesheet" href="./styles/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
      .input-box {
        width: 100% !important;
      }
      .container {
        max-width: 500px;
      }
      .user-details {
        flex-direction: column;
        justify-content: center;
        align-items: center;
      }
    .error-message{
      color: red;
    }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="title">Login <Inp></Inp></div>
      <div class="content">
        <form action="login.php" method="POST">
          <div class="user-details">
            <div class="input-box">
              <span class="details">Username</span>
              <input type="text" name="username" placeholder="Enter your username" required value="<?php echo $username ?>"/>
            </div>
            <div class="error_message"><?php echo $usernameErr ?></div>

            <div class="input-box">
              <span class="details">Password</span>
              <input type="password" name="password" placeholder="Enter your password" required value="<?php echo $password ?>" />
            </div>
            <div><?php echo $passwordErr ?></div>
          </div>

          <div class="button">
            <input type="submit" name="submit" value="Register" />
          </div>
          <p>Dont have an accout? <a href="signup.php">Signup</a></p>
        </form>
      </div>
    </div>
    
  </body>
</html>
 