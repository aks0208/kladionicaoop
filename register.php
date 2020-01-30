 <?php 
include("admin/config.php");
if (!empty($_POST['inputUsername']) && !empty($_POST['inputEmail']) && !empty($_POST['inputPassword'])) {

  $user = new User;
  $user->username=$_POST['inputUsername'];
  $user->email=$_POST['inputEmail'];
  $user->password=$_POST['inputPassword'];
  $user->register($user->username,$user->email,$user->password);
 
} 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BETLive | Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css"  href="css/bootstrap.min.css">
    
    <link href="css/signin.css" rel="stylesheet">
</head>
<body class="text-center">
    <form class="form-signin" id="registerForm" method="POST" action="">
    <a href="index.php">
      <img class="mb-4" src="assets/images/logo.png" alt="" width="72" height="72">
    </a>
  <h1 class="h3 mb-3 font-weight-normal" style="color:white">Please register</h1>
  <label for="inputEmail" class="sr-only">Username</label>
  <input type="text" name="inputUsername" class="form-control" placeholder="Username" required autofocus pattern=".{5,10}" required title="5 characters minimum or 10 characters maximum">
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" name="inputEmail" class="form-control" placeholder="Email address" required>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" name="inputPassword" class="form-control" placeholder="Password" required pattern=".{6}" required title="6 characters minimum">
  
  <button onchange="$('#registerForm').submit()" class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
  <br><span style="color:white">Already have account? <a href="login.php">Sign in</a></span>
  <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
</form>
</body>
</html>