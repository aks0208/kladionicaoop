<?php include("config.php"); 


if (isset($_POST['submit'])) {
  $match = new Match();

  if (isset($_POST['selHomeTeam'])) {
    $match->home_team = intval($_POST['selHomeTeam']);
  }

  if (isset($_POST['selAwayTeam'])) {
    $match->away_team = intval($_POST['selAwayTeam']);
  }

  $date = $_POST['txtDate'];
  $time = $_POST['txtTime'];

  $match->start_time = $time;
  $match->start_date = $date;
  $match->insert();
}

  if (!empty($_GET['delete_mid'])) {
  $mid = Match::delete($_GET['delete_mid']);
  }

  if (isset($_POST['update-match'])) {
  $match_id = $_POST['match_id'];
  $match = Match::getById($match_id);
  
  if($match != null) {
    $match->match_id = $_POST['match_id'];
    $match->start_date = $_POST['start_date'];
    $match->start_time = $_POST['start_time'];
    $match->home_score = $_POST['home_score'];
    $match->away_score = $_POST['away_score'];
    
    $match->save();
  }
  
  //var_dump($odd);
}
    
 
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Tables</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="../index.php">BETLive</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">Settings</a>
            <a class="dropdown-item" href="#">Activity Log</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <h6 class="dropdown-header">Login Screens:</h6>
            <a class="dropdown-item" href="../login.php">Login</a>
            <a class="dropdown-item" href="../register.php">Register</a>
            <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Other Pages:</h6>
            <a class="dropdown-item" href="404.html">404 Page</a>
            <a class="dropdown-item" href="blank.html">Blank Page</a>
          </div>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="teams.php">
            <i class="fas fa-futbol"></i>
            <span>Teams</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="matches.php">
            <i class="fas fa-columns"></i>
            <span>Matches</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="odds.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Odds</span></a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="balance.php">
            <i class="fas fa-money-check-alt"></i>
            <span>Add users balance</span></a>
        </li>
      </ul>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Match</li>
          </ol>

          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
             Add new match</div>
            <div class="card-body">
              <div class="table-responsive">
                <!-- Data Add New -->
                
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th><i class="fas fa-futbol"></i> Home team</th>
                      <th><i class="fas fa-futbol"></i> Away team</th>
                      <th><i class="fas fa-calendar-alt"></i> Date</th> 
                      <th><i class="fas fa-clock"> Time</th>
                      <th>Action</th>
                      
                    </tr>
                  </thead>
                 
                  <tbody>
                  <tr><td>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                      </div>
                      <form method="POST" action="" enctype="multipart/form-data">
                      <select class="custom-select-sm" id="inputGroupSelect01" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="selHomeTeam">
                        <option value="-1">Choose...</option>
                        <?php 
                          $teams = Team::getAll();
                          foreach ($teams as $team) {
                           echo "<option value='{$team->team_id}'>{$team->name}</option>";
                          }
                        ?>
                    </select> <?php 
                       ?>
                    </div>
                    </td>
                  <td>
                    <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                      </div>
                      <select class="custom-select-sm" id="inputGroupSelect01" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="selAwayTeam">
                        <option value="-1">Choose...</option>
                        <?php 
                          $teams = Team::getAll();
                          foreach ($teams as $team) {
                           echo "<option value='{$team->team_id}'>{$team->name}</option>";
                          }
                        ?>
                        </select>
                    </div>
                   </td>
                   <td>
                     <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                       <input type="date" class="form-control-sm" placeholder="dd/MM/YYYY" name="txtDate" >  
                      </div>
                    </td>
                   <td>
                     <div class="input-group input-group-sm mb-3">
                      <div class="input-group-prepend">
                        <input type="time" class="form-control-sm" placeholder="H:m" name="txtTime" >
                         </div>
                      </td>
                    <td>
                   <input class="btn btn-primary" value="Add" type="submit" name="submit">
                   </td>
                   </tr>
                   
                  </tbody>
                </table><br>
                <br><br><br>
                  </form>
                  </div>
              <!-- /.container-fluid -->



      </div>
      <!-- /.content-wrapper -->
<!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
             All matches</div>
            <div class="card-body">
              <div class="table-responsive">
                <!-- Data Add New -->
                
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th><i class="fas fa-futbol"></i> Home team</th>
                      <th><i class="fas fa-futbol"></i> Away team</th>
                      <th><i class="fas fa-calendar-alt"></i> Date</th> 
                      <th><i class="fas fa-clock"> Time</th>
                      <th>Home score</th>
                      <th>Away score</th>
                      <th>Action</th>
                      <?php 
                       $matches = new Match;
                       $matches = Match::getData("select *, t1.name as home, t2.name as away FROM matches m JOIN teams t1 ON m.home_team = t1.team_id JOIN teams t2 ON m.away_team = t2.team_id");
                     
                          foreach ($matches as $match) {
                            $mid = $match->match_id;
                          echo "<tr><form method='POST' action=''>
                        <td>
              <a href='#' class='editable' style='margin-left: 2px;'>". $match->home ."</a>
              
                
                        </td>";
                         echo "
                        <td>
              <a href='#' class='editable' style='margin-left: 2px;'>".$match->away."</a>
              
                
                        </td>";

                         echo "
                        <td>
              <a href='#' class='editable' style='margin-left: 2px;'>".$match->start_date."</a>
              <input type='date' class='editshow aria-label='Default' name='start_date' value='".$match->start_date."'>
                        </td>";

                        echo "
                        <td>
              <a href='#' class='editable' style='margin-left: 2px;'>".$match->start_time."</a>
              <input type='time' class='editshow form-control col-3' aria-label='Default' aria-describedby='inputGroup-sizing-default' name='start_time' value='".$match->start_time."'>
                        </td>";
                        
                        echo "
                        <td>
              <a href='#' class='editable' style='margin-left: 2px;'>".$match->home_score."</a>
              <input type='number' class='editshow form-control col-3' aria-label='Default' name='home_score' value='".$match->home_score."'>
                        </td>";

                         echo "
                        <td>
              <a href='#' class='editable' style='margin-left: 2px;'>".$match->away_score."</a>
              <input type='number' class='editshow form-control col-3' aria-label='Default' name='away_score' value='".$match->away_score."'>
                        </td>";

                         echo "<td>
              <button type='button' class='btn btn-primary btn-sm btnEdit'".$mid."'>Edit</button> | <a href='matches.php?delete_mid={$mid}' class='btn btn-danger btn-sm'>Delete</a>
              <input type='hidden' name='match_id' value='{$mid}' />
              <input type='submit' name='update-match' class='btn btn-sm btn-success editshow' value='Save' />
            </td>
                        </form></tr>";
                       
                      }
                      ?>
                    </tr>
                  </thead>
                 
                    </tbody>
                </table>

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

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
            <form action="../logout.php" method="post"><button class="btn btn-primary" name="logout">Logout</button></form>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    
    
   

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="js/demo/datatables-demo.js"></script>
                      
    <script type="text/javascript">
   
   $(".editshow").hide();
    $(".btnEdit").click(function(){
      let btnEdit = $(this),
      containerEl = btnEdit.closest("tr");
      containerEl.find(".editshow").toggle();
     // containerEl.find(".editable").setTimeout(2000);
    });
    </script>
  </body>

</html>
