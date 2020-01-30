<?php include("admin/config.php"); 


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
</head>
<style>
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
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="mybet.php">Bet Now</a>
         </li>
        <?php 
        if($user = User::is_logged_in()) { ?>
          <li class="nav-item">
          <a class="nav-link" href="ticket.php">My ticket</a>
        </li>
         <?php 
        }
        if($user = User::is_admin()) {
          echo "<li class='nav-item'><a class='nav-link' href='admin/dashboard.php'>Dashboard</a></li>";
         }
          ?>
      </ul>
      <form class="form-inline mt-2 mt-md-0" id="formOptions" method="post" action="">
        <?php 
          if($user = User::is_logged_in()) {
            $balance = User::getById($user);
            echo "<a href='#' class='btn btn-outline-light disabled'>My balance: {$balance->balance}KM</a>";
          echo "<a href='logout.php' class='btn btn-success mr-sm-2' type='submit' name='logout' data-toggle='modal' data-target='#logoutModal'>Logout</a>";
          } else {
          ?><a href="login.php" class="btn btn-outline-success mr-sm-2">Login</a>
        <a href="register.php" class="btn btn-outline-success my-2 my-sm-0">Register</a><?php
          }
        ?>
      </form>
    </div>
  </nav>
</header>

<main role="main">
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="myCarousel" data-slide-to="1"></li>
      <li data-target="myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" >
      <div class="carousel-item active">
        <img class="bd-placeholder-img" width="100%" height="100%" src="assets/images/1.png" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" >
        <div class="container">
          <div class="carousel-caption text-left">
            <h1>Play & Win today on BETLive!</h1>
            <p>Good to have you with us! There are already over 4 million people worldwide using BETLive.com! It's no wonder because for us, life is a game. The rules are simple: great chances to win, excellent customer service and fair entertainment. Play with us now and open a betting account - it's completely free!</p>
            <p><a class="btn btn-lg btn-primary" href="register.php" role="button">Sign up today</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item" >
        <img class="bd-placeholder-img" width="100%" height="100%" src="assets/images/2.png" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
        <div class="container">
          <div class="carousel-caption">
            <h1>Live games</h1>
            <p>Here you can watch the score of live games</p>
            <p><?php 
            
            ?></p>
            <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="bd-placeholder-img" width="100%" height="100%" src="assets/images/2.png" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" ><rect fill="#777" width="100%" height="100%"/>
        <div class="container">
          <div class="carousel-caption text-right">
            <h1>One more for good measure.</h1>
            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
          </div>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" id="previous" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" id="next" href="#myCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <script>
$(document).ready(function(){
  $('.carousel').carousel();
    
  // Enable Carousel Controls
  $(".left").click(function(){
    $("#myCarousel").carousel("prev");
  });
  $(".right").click(function(){
    $("#myCarousel").carousel("next");
  });
});
</script>
<!-- START THE FEATURETTES -->
<hr class="featurette-divider">
<!-- DROPDOWN BUTTON -->
<div class="d-flex">
  <div class="dropdown m-auto">
    <form method="POST" action="" id="myForm">
       <select class="custom-select" id="selectDate" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="pickDate" onchange="$('#myForm').submit()">
           <option value="-1" <?php if(!isset($_POST['pickDate'])) echo 'selected'; ?>>Pick a date of</option>
            <?php 
            $now = new DateTime();
            $end = new DateTime();
            $end = $end->modify("+7 day"); 

            $interval = new DateInterval("P1D");
            $week = new DatePeriod($now, $interval ,$end);
            $tmpID = "";
             foreach($week as $day){
              $date = $day->format('d.m.Y.');

                              echo "<option value='{$day->format('Y-m-d')}'"; if(isset($_POST['pickDate']) && $_POST['pickDate'] == $day->format('Y-m-d')) echo " selected";  echo ">{$day->format('d.m.Y.')}</option>";

                              }
                              //srediti
                            ?>
<script type="text/javascript">
  var selectedDate = document.getElementById("selectDate").value;
  console.log(selectedDate);
</script>
         </select>
      </form>
        <?php
//var_dump($date);
?>
  </div>
 <hr class="featurette-divider">
</div>
<!-- TABLE -->
    <div class="container">
  <table class="table table-sm table-hover">
  <thead style="background: #04113C; color: white">
    <tr >
      <th scope="col">Number</th>
      <th scope="col">Game</th>
      <th scope="col">Time</th>
      <th scope="col">Date</th>
      <th scope="col">1</th>
      <th scope="col">X</th>
      <th scope="col">2</th>
    </tr>
  </thead>
  <tbody>
    <?php
	if(isset($_POST['pickDate']) && $_POST['pickDate'] != -1)
		$games = OddData::getData('select O.*, m.match_id, m.start_time, m.start_date,t1.name as home, t2.name as away from odds_data O join matches m on o.match_id = m.match_id join teams t1 ON m.home_team = t1.team_id JOIN teams t2 ON m.away_team = t2.team_id WHERE m.start_date = "'.$_POST['pickDate'].'"');
	else
		$games = OddData::getData("select O.*, m.match_id, m.start_time, m.start_date,t1.name as home, t2.name as away from odds_data O join matches m on o.match_id = m.match_id join teams t1 ON m.home_team = t1.team_id JOIN teams t2 ON m.away_team = t2.team_id");
    
	foreach ($games as $game) {
      $oid = $game->odd_id;
      echo "<tr><th scope='row'>".$game->match_id."</th>";
      echo "<td>" .$game->home ." : ".$game->away."</td>";
      echo "<td>" .$game->start_time."</td>";  
      echo "<td>" .$game->start_date."</td>"; 
      echo "<td><a href='mybet.php'>" .$game->home_team_odd."</a></td>"; 
      echo "<td><a href='mybet.php'>" .$game->x_odd."</a></td>"; 
      echo "<td><a href='mybet.php'>" .$game->away_team_odd."</a></td></tr>"; 
  }
    ?>
    
  </tbody>
</table>
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
<script src="js/bootstrap.bundle.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.js"></script>
  
</body>
</html>