 <?php
include("admin/config.php");
if(!$user = User::is_logged_in()) {
  User::redirect('login.php'); 
} else {

if (isset($_POST['btnLogout'])) {
  User::logout();
  User::redirect('login.php');
}
	$user_id = Session::get('user_session');
	$user = User::getById($user_id);
  $user_balance = $user->balance;

//$myArray = array();
   
/*if (isset($_POST['proceedBet'])) {
  $bets = isset($_POST['bets']);
  foreach ($bets as $bet) {
    echo $bet;
  }
 print_r($bets); 
echo $bets; }*/
 /*  $bets = json_decode($_POST['bets'], true);
 
  print_r($bets);
  var_dump($bets);
 

 print_r($_POST);


//  User::redirect("ticket.php");

} */


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
  
<script src="js/jquery-3.3.1.slim.min.js"></script>
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
        <li class="nav-item active">
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
      <form class="form-inline mt-2 mt-md-0" id="formOptions" method="POST" action="">
        <?php 
          if($user = User::is_logged_in()) {
           
            echo "<a href='#' class='btn btn-outline-light disabled'>My balance: {$user_balance}KM</a>";
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
  <div class="container"><br><br><br>
    <h1 style="text-align: center; color:lightblue; font-family: sans-serif;font-size: 100px; text-shadow: 2px 2px 8px #FF0000;">BET OFFER</h1>
  <!-- TABLE BET OFFER-->
    <div class="container">
      <table class="table table-sm table-hover">
        <thead style="background: #04113C; color: white">
          <tr>
            <th scope="col">Number</th>
            <th scope="col">Game</th>
            <th scope="col">Time</th>
            <th scope="col">Date</th>
            <th scope="col">1</th>
            <th scope="col">X</th>
            <th scope="col">2</th>
          </tr>
        </thead>
        <tbody id="matches">
          <?php
            $matches = OddData::getData("select O.*, m.match_id, m.start_time,m.start_date, t1.name as home, t2.name as away from odds_data O join matches m on o.match_id = m.match_id join teams t1 ON m.home_team = t1.team_id JOIN teams t2 ON m.away_team = t2.team_id");
          ?>

<script type="text/javascript">
  var tempArray = <?php echo json_encode($matches); ?>;

  console.log(tempArray);

  var bets = [];
  var type;
  var amount;
  var possibleWin;


  function renderBet(x){
    document.getElementById("bets").innerHTML = "<tr class='tdMatches'>"
    for (var i = 0; i < x.length; i++){
      let current_datetime = new Date(x[i].start_date)
      let formatted_date = current_datetime.getDate() + "." + (current_datetime.getMonth() + 1) + "." + current_datetime.getFullYear()
      
      
	  
			document.getElementById("bets").innerHTML += "<th scope='row' class='tdMatches'>" + x[i].match_id + "<td class='tdMatches'>" + x[i].home + " : " + x[i].away + "</td><td class='tdMatches'>" + trimTime(x[i].start_time) + "</td><td class='tdMatches'>" + formatted_date + "</td>" + "</th><td class='tdMatches'><div>" + x[i].odabrano + "</div></td>" + "<td class='tdMatches'>" + x[i].type + "</td><td class='tdMatches'><button class='clearBtn' onclick='deleteRow(this, " + x[i].odd_id + ")'><i class='fa fa-close'></button></td>"; 
	  }
  }

   
   
   
  function deleteRow(o, i) {
	var index = bets.map(x => {
		return x.odd_id;
	}).indexOf(i);

	bets.splice(index, 1);
	
	console.log("bets.length: " + bets.length);
	
	if(bets.length == 0) {
		$("#proceedDiv").hide();
		
	}
	
      var p=o.parentNode.parentNode;
         p.parentNode.removeChild(p);
		 
	renderMatches(tempArray);
	
	getAmount();
  }
  
  function clicked(id, odd){
    console.log("id: ", id);
    console.log(odd);
    console.log(tempArray);
	
	$("#proceedDiv").show();

    var find = tempArray.find(el => el.match_id == id);

    console.log(find);

    var odabrano;
	  var type;
    
    if(odd == 0) {
		type = "X";
		odabrano = find.x_odd;
	} else if(odd == 1) {
		type = 1;
		odabrano = find.home_team_odd;
	} else if(odd == 2) {
		type = 2;
		odabrano = find.away_team_odd;
	}
	
	find.odabrano = odabrano;
	find.type = type;
    
    //let betsEl = {...find, odabrano: odabrano}
	
    bets.push(find);
	
	console.log("bets.length: " + bets.length);
	
	renderBet(bets);
	renderMatches(tempArray);
	
	getAmount();
  }
  
  function renderMatches(x){
    document.getElementById("matches").innerHTML = "<tr class='tdMatches'>"
	
	var choosen;
    for (var i = 0; i < x.length; i++){

      let current_datetime = new Date(x[i].start_date)
      let formatted_date = current_datetime.getDate() + "." + (current_datetime.getMonth() + 1) + "." + current_datetime.getFullYear()
		
		choosen = false;
		
		for(var j = 0; j < bets.length; j++) {
			if(bets[j].odd_id == x[i].odd_id)
				choosen = true;
		}
		
		if(choosen == false)
			document.getElementById("matches").innerHTML += "<th scope='row' class='tdMatches'>" + x[i].match_id + "<td class='tdMatches'>" + x[i].home + " : " + x[i].away + "</td><td class='tdMatches'>" + trimTime(x[i].start_time) + "</td><td class='tdMatches'>" + formatted_date + "</td></th><td><div data-toggle='tooltip' data-placement='top' title='Click on odd to bet' class='tdOdds' onClick='clicked("+ x[i].match_id+", "+ 1 +")'>" + x[i].home_team_odd + "</div></td><td><div class='tdOdds' data-toggle='tooltip' data-placement='top' title='Click on odd to bet' onClick='clicked("+ x[i].match_id+", "+ 0 +")'>" + x[i].x_odd + "</div></td><td><div data-toggle='tooltip' data-placement='top' title='Click on odd to bet' class='tdOdds' onClick='clicked("+ x[i].match_id+", "+ 2 +")'>" + x[i].away_team_odd + "</div></td>"; 
    }  
  }
  
  renderMatches(tempArray);

function getAmount() {
	userBalance = "<?php echo $user_balance; ?>";
	amountN = document.getElementById("amount").value;
	amount = parseInt(amountN).toFixed(2);
	
	console.log("getAmount is called");
	
	if(parseInt(userBalance) < amount) {
		$("#finish_bet").hide();
		document.getElementById("proceedModal").innerHTML = "You don't have enought money to bet.";
	} else {
		$("#finish_bet").show();
		
		possibleWin = 1;
		
		for(var j = 0; j < bets.length; j++) {
			possibleWin *= bets[j].odabrano;
		}
		
		possibleWin = possibleWin * amount;
		
		document.getElementById("proceedModal").innerHTML = "My amount: " + amount + "KM" + "<br>" + "Possible win: " + possibleWin.toFixed(2) + "KM";
	}
}

  function sendValues() {
  if(amount.length > 0 ) {
    $.ajax({ 
       url: "./admin/engine.php", 
       method: "POST", 
       data: {bets: JSON.stringify(bets), amount: amount, possibleWin: possibleWin}, 
       success: function(res) {
       window.location.href = './ticket.php'; 
              console.log(res);
        }
    }); 
  } 
}

hide(document.querySelectorAll('.mybets'));

function hide (elements) {
  elements = elements.length ? elements : [elements];
  for (var index = 0; index < elements.length; index++) {
    elements[index].style.display = 'none';
  }
}
    


function trimTime(x) {
  return x.replace(":00",'');
}
</script>
          </tbody>
        </table>
        <hr class="featurette-divider">
       <!-- TABLE MYBET -->
       <div id="proceedDiv">
        <h1 class="mybet" style="text-align: center; color:Yellow; font-family: sans-serif;font-size: 100px; text-shadow: 2px 2px 8px #FF0000;">MY BET</h1>
        <div class="container mybet">
          <table class="table table-sm table-hover mybet">
          <thead style="background: #04113C; color: white">
            <tr>
              <th scope="col">Number</th>
              <th scope="col">Game</th>
              <th scope="col">Time</th>
              <th scope="col">Date</th>
              <th scope="col">Odd</th>
              <th scope="col">Bet</th>
              <th scope="col">Remove</th>
            </tr>
          </thead>
          <tbody id="bets" class="mybet">
            <script type="text/javascript">
                console.log("tempArray", tempArray)
            </script>
          </tbody>
        </table><br>
      <!-- <form method="post" action=""> -->
	  <div>
       <div class="d-flex justify-content-between">
		<input type="text" class="form-control mybet col-6" id="amount" oninput="getAmount()" placeholder="On how much money you would like to bet?" required />
        <button class='btn btn-success mr-sm-2 mybet btn-block ml-3' name="proceedBet" name='confirm' data-toggle='modal' data-target='#confirmModal'>Proceed</button>
		</div>
	  </div>
	 <!-- </form> -->
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
     <!-- Confirm Bet Modal-->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Are you sure you want to continue your bet?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			  </div>
			  <div class="modal-body">
				<div id="proceedModal"></div>
			  </div>
			  <div class="modal-footer" id="finish_bet">
			  
				<button type="button" class="btn btn-success btn-block" onClick="sendValues()">Bet</button>
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

<script>
	$("#proceedDiv").hide();
	$("#finish_bet").hide();
</script>

<script src="js/bootstrap.bundle.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</body>
</html>
<?php 

}