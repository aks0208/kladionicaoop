<?php
include("admin/config.php");
if(!$user = User::is_logged_in()) {
  User::redirect('login.php'); 
} else {

if (isset($_POST['btnLogout'])) {
  User::logout();
  User::redirect('login.php');
}


//$myArray = "";

  //if (isset($_POST['arrBet'])) {
  
 // }

  
  //var_dump($myArray);
// proslijediti niz odabranih vrijednosti iz js u php.  

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>BETLive - Sports betting</title>
  
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css"  href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/mystyle.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<style>
    body {
        background-color: #04113C;
    }
.heading {
  @include text-hide;
}
</style>
<body>
    <header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color: #04113C";>
    <a class="navbar-brand" href="index.php">BETLive</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mybet.php">Bet Now</a>
        </li>
        <?php 
        if($user = User::is_logged_in()) { ?>
          <li class="nav-item active">
          <a class="nav-link" href="ticket.php">My ticket</a>
        </li>
         <?php 
        }
        if($user = User::is_admin()) {
          echo "<li class='nav-item'><a class='nav-link' href='admin/dashboard.php'>Dashboard</a></li>";
         }
          ?>
         
      </ul>
      <form class="form-inline mt-2 mt-md-0" id="formOptions" method="POST" action="">
        <?php 
          if($user = User::is_logged_in()) {
            $balance = User::getById($user);
            echo "<a href='#' class='btn btn-outline-light disabled'>My balance: {$balance->balance}KM</a>";
          echo "<a href='logout.php' class='btn btn-success mr-sm-2' type='submit' name='logout' data-toggle='modal' data-target='#logoutModal'>Logout</a>";
          } else {
          ?><a href="login.php" class="btn btn-outline-success mr-sm-2">Login</a>
        <a href="register.php" class="btn btn-outline-success my-2 my-sm-0">Register</a>
        <?php
          }
        ?>
        
      </form>
    </div>
  </nav>
</header>

<main role="main">

  <div class="container"><br><br><br>
    <h2 style="text-align: center; color:blue">MY TICKET</h2>
  <!-- TABLE BET OFFER-->
    <div class="container">

    <?php
  $tickets = Ticket::getAll(" where user_id = {$user}");
    $odds = array();
    $odd = "";

  foreach ($tickets as $ticket) {
    $json = json_decode($ticket->bet);
	
	
	echo '
		<table class="table table-sm table-hover text-white">
		  <thead style="background: #04113C; color: white">
			<tr >
			  
			  <th scope="col">Game</th>
			  <th scope="col">Time</th>
			  <th scope="col">Date</th>
			  <th scope="col">Type</th>
			  <th scope="col">Odd</th>
			</tr>
		  </thead>
	  <tbody>
	';
    foreach ($json as $bet) {
      
      

      if($bet->type == 1) $odd = $bet->home_odd; 
      else if ($bet->type == 2) $odd = $bet->away_odd; 
      else $odd = $bet->x_odd;

     
      
      echo "<tr><td style='border: transparent' class='text-white'>" .$bet->home_team ." : " .$bet->away_team."</td>";
      echo "<td style='border: transparent'>" .$bet->start_time."</td>";  
      echo "<td style='border: transparent'>" .$bet->start_date."</td>"; 
      echo "<td style='border: transparent'><a href='mybet.php'>" .$bet->type."</a></td>";
      echo "<td style='border: transparent'><a href='mybet.php'>" .$odd ."</a></td>";

      var_dump($bet);
      
  }
	

  echo '
		<br><br><br></tbody>
	</table> 
  ';
  echo "<p class='mt-2 mb-5 text-white border-bottom border-white'>Ticket number: ".$ticket->ticket_id ."<br>My amount: ".$ticket->amount." KM<br>Possible win: ".$ticket->possible_win." KM". "</p>";
}
    ?>
   
  

<div class="container">



</div>
</div>
 <hr class="featurette-divider">
 <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <form action="logout.php" method="post"><button class="btn btn-primary" name="logout">Logout</button></form>
          </div>
        </div>
      </div>
    </div>
  <!-- FOOTER -->
  <footer class="container">
    <p class="float-right"><a href="#">Back to top</a></p>
    <p>&copy; 2019 Ajla, IT Academy Assignment. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
  </footer>
</main>
<script src="js/jquery-3.3.1.slim.min.js"></script>
 <script src="js/jquery-slim.min.js"></script>

 <script src="js/bootstrap.bundle.js"></script>
<script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap.js"></script>
  
 
</body>
</html>
<?php 
}