<?php 
include("config.php");
if(!$user = User::is_admin()){
  User::redirect("../login.php"); 
} else {
  if(isset($_POST['submit'])) {
    User::logout();
    User::redirect('../login.php');
  }
  if (!empty($_GET['delete_uid'])) {
    $uid = $_GET['delete_uid'];
    $admin = Session::get("user_session");
    $user = User::getById($uid);
    if($admin == $user->approved_by || $admin == 2) {
      User::delete($uid);
    } else {

      echo '<script language="javascript">';
      echo 'alert("You do not have right to delete this user")';
      echo '</script>';
    }
   }


  if(!empty($_GET['confirm_delete'])) {
    $uid = User::delete($_GET['confirm_delete']);
  }
  if (!empty($_GET['confirm_user'])) {
    $uid = $_GET['confirm_user'];
    $admin = Session::get("user_session");

    $user = User::getById($uid);
    $user->approved_by = $admin;
    $user->is_approved = 1;
    $user->save();
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

    <title> Admin - Dashboard</title>

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
            <a class="dropdown-item" href="../logout.php" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item active">
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
            <a class="dropdown-item" href="../index.php">Home</a>
            <a class="dropdown-item" href="../login.php">Login</a>
            <a class="dropdown-item" href="../register.php">Register</a>
            <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Other Pages:</h6>
            <a class="dropdown-item" href="../404.html">404 Page</a>
            <a class="dropdown-item" href="blank.html">Blank Page</a>
          </div>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="teams.php">
            <i class="fas fa-futbol"></i>
            <span>Teams</span></a>
        </li>
        <li class="nav-item">
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
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          
          <!-- DataTables Example -->
                    <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
              USERS</div>
            
                </form>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Approved by</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                 
                  <tbody>
                    
                      <?php 
                      $users = User::getData("select u.username as user, u.email, u.status,u.user_id, a.username as admin from users u, users a where u.approved_by = a.user_id");
                      foreach ($users as $user) {
                        $uid = $user->user_id;
                        switch ($user->status) {
                          case 0:
                            $status = "User";
                            break;

                          case 1:
                           $status = "Admin";
                            break;

                            case 2:
                            $status = "SuperAdmin";
                            break;
                         }
                        echo "<tr>
                        <td>
                        <a href='#' class='editable' style='margin-left: 2px;'>".$user->user."</a>
                        </td>";
                         echo "
                        <td>
                        <a href='#' class='editable' style='margin-left: 2px;'>".$user->email."</a>
                        </td>";
                        echo "
                        <td>
                        <a href='#' class='editable' style='margin-left: 2px;'>".$status."</a>
                        </td>";
                         echo "
                        <td>
                        <a href='#' class='editable' style='margin-left: 2px;'>".$user->admin."</a>
                        </td>";
                        echo "<td><a href='dashboard.php?delete_uid={$uid}' class='btn btn-danger btn-sm'>Delete</a>
                        </td>
                        </tr>";
                      }

                      ?>
                      </tbody>
                </table>
                <br>
                   <!-- NEW REQUESTED USERS -->
                    <h4> New requested users</h4> <br>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th>Email</th>
                      <th>Approve</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                    
                      <?php 
                      $users = User::getAll();
                      foreach ($users as $user) {
                        if (!$user->is_approved == 1) {
                          $uid = $user->user_id;
                        echo "<tr>
                        <td>
                        <a href='#' class='editable' style='margin-left: 2px;'>".$user->username."</a><form method='POST' action=''><input type='text' class='editshow form-control col-sm-3' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm' name='edit_users_{$uid}' value='".$user->username."'></form><a href='dashboard.php?save_tid={$uid}' style='margin-left: 2px; margin-top:3px;' class='btn btn-success btn-sm editshow'>Save</a>
                        </td>";
                         echo "
                        <td>
                        <a href='#' class='editable' style='margin-left: 2px;'>".$user->email."</a><form method='POST' action=''><input type='text' class='editshow form-control col-sm-3' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm' name='edit_users_{$uid}' value='".$user->email."'></form><a href='dashboard.php?save_tid={$uid}' style='margin-left: 2px; margin-top:3px;' class='btn btn-success btn-sm editshow'>Save</a>
                        </td>";
                        echo "<td>
                        <a href='dashboard.php?confirm_user={$uid}' class='btn btn-success btn-sm'>Yes</a> | <a href='dashboard.php?confirm_delete={$uid}' class='btn btn-danger btn-sm'>No</a>
                        </td>
                        </tr>";
                        } 
                      }

                      ?>
                      
                   
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>2019 Ajla, IT Academy Assignment.</span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

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

    <script type="text/javascript">
    $(".editshow").hide();
      $(".btnEdit").click(function(){
        let btnEdit = $(this),
        containerEl = btnEdit.closest("tr");
        containerEl.find(".editshow").toggle();
      });
    </script>
  </body>

</html>
<?php
}