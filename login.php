<?php 
include("admin/config.php");
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

if (!empty($_POST['inputEmail']) && !empty($_POST['inputPassword'])) {
  
  $email = $_POST['inputEmail'];
  $password = $_POST['inputPassword'];
  
  $user = User::login($email, $password);
  if(!$user) {
    alert('User does not exist'); 
  } else if ($user->is_approved($user->user_id)) {
   header("Location: index.php");
  } else {
    alert('You have to wait for admin approval'); 
  }

  }
  
 

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BETLive | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css"  href="css/bootstrap.min.css">
    <link href="css/signin.css" rel="stylesheet">
</head>
<body class="text-center">
  <p id="msg"></p>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    
    <form class="form-signin" id="loginForm" method="POST" action="">
    <a href="index.php">
      <img class="mb-4" src="assets/images/logo.png" alt="" width="72" height="72">
    </a>
  <h1 class="h3 mb-3 font-weight-normal text-white">Please sign in</h1>
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" name="inputPassword" class="form-control" placeholder="Password" required>
  <button class="btn btn-lg btn-primary btn-block" type="submit" onchange="$('#loginForm').submit()">Login</button>
  <br><span style="color:white">You don't have account? <a href="register.php">Sign up</a></span>
  <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
</form>

</body>
</html>