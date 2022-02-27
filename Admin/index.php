<?php 
  include 'includes/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Denvis Bookshop | Management</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="icon" href="../images/logo.png">
  <meta name="theme-color" content="#00A65A">
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse" data-panel-auto-height-mode="height">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark" style="background-color: #00a65a;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="home" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="./branches" class="nav-link">Branches</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link" role="button">
        <p>Member since <?php echo date('M. Y', strtotime($admin['created_on'])); ?></p>
        </a>
      </li>
      <li class="nav-item user-menu d-none d-sm-inline-block">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <img src="<?php echo (!empty($admin['photo'])) ? '../images/'.$admin['photo'] : '../images/profile.jpg'; ?>" class="user-image" alt="User Image">
        </a>
      </li>
      <?php
        if(!$sock = @fsockopen('www.google.com', 80)){
            echo '
                <li class="nav-item"><a class="nav-link" href="#" role="button"><i class="fa fa-wifi text-danger"></i></a></li>    
            ';
        }
        else{
            echo '
                <li class="nav-item"><a class="nav-link" href="#" role="button"><i class="fa fa-wifi"></i></a></li>    
            ';
        } 
      ?>
      <li class="nav-item">
        
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-success elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="padding: 0; margin: 0;">
        <div class="image" style="padding: 0; margin: 0;">
          <img src="<?php echo (!empty($admin['photo'])) ? '../images/'.$admin['photo'] : '../images/profile.jpg'; ?>" style="padding-top: 10px;" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="pull-left info">
          <p style="padding: 0; margin: 0; color: white;"><?php echo $admin['firstname'].' '.$admin['lastname']; ?></p>
          <?php
            if(!$sock = @fsockopen('www.google.com', 80)){
                echo '
                <a style="padding: 0; margin: 0; color: white;"><i class="fa fa-wifi fa-spin text-warning"></i> Offline</a>
                ';
            }
            else{
                echo '
                    <a style="padding: 0; margin: 0; color: white;"><i class="fa fa-wifi text-success"></i> Online</a>
                ';
            } 
          ?>
      </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="./home" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="branches" class="nav-link">
              <i class="nav-icon fas fa-store-alt"></i>
              <p>Branches</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="tra" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>Transactions</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="clients" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Clients</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="orders" class="nav-link">
              <i class="nav-icon fas fa-cart-plus"></i>
              <p>Orders</p>
            </a>
          </li>
              <li class="nav-item">
                <a href="data2" class="nav-link">
                  <i class="fa fa-balance-scale nav-icon"></i>
                  <p>Product Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="data" class="nav-link">
                  <i class="fas fa-shopping-basket nav-icon"></i>
                  <p>Product List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="allocations" class="nav-link">
                  <i class="fas fa-dolly nav-icon"></i>
                  <p>Product Allocations</p>
                </a>
              </li>
          <li class="nav-item">
            <a href="staff" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Staff
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="contacts" class="nav-link">
              <i class="nav-icon fas fa-address-book"></i>
              <p>
                Contact List
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./sent" class="nav-link">
              <i class="nav-icon fas fa-comment-dots"></i>
              <p>
                Contact Center
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
    <div class="nav navbar navbar-expand navbar-white navbar-light border-bottom p-0">
      <div class="nav-item dropdown">
        <a class="nav-link bg-danger dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Close</a>
        <div class="dropdown-menu mt-0">
          <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all">Close All</a>
          <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all-other">Close All Other</a>
        </div>
      </div>
      <a class="nav-link bg-light" href="#" data-widget="iframe-scrollleft"><i class="fas fa-angle-double-left"></i></a>
      <ul class="navbar-nav overflow-hidden" role="tablist"></ul>
      <a class="nav-link bg-light" href="#" data-widget="iframe-scrollright"><i class="fas fa-angle-double-right"></i></a>
      <a class="bg-light" href="../logout" role="button"  style="padding: 7px;"><b> Signout</b></a>
      <a class="nav-link bg-light" href="#" data-widget="iframe-fullscreen"><i class="fas fa-expand"></i></a>
    </div>
    <div class="tab-content">
      <div class="tab-empty text-center" style="background-image: url(./dist/img/bjg.jpg); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">
        <h2 id="wesa" class="display-4"></h2>
      </div>
      <div class="tab-loading">
        <div>
          <img class="animation__shake" src="../images/logo.png" alt="AdminLTELogo" height="100" width="100">
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer" style="background-color: #00a65a;">
    <strong style="color:black;">Copyright &copy; 2021 <a href="https://denvisbookshop.co.ke"  style="color: white;">Denvis Bookshop</a></strong>
    <div class="float-right d-none d-sm-inline-block">
      <b style="color:black;">All rights reserved</b>
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
  var i = 0;
  var txt = 'Welcome <?php echo $admin['firstname']; ?>!';
  var speed = 150;
  
  function typeWriter() {
    if (i < txt.length) {
      document.getElementById("wesa").innerHTML += txt.charAt(i);
      i++;
      setTimeout(typeWriter, speed);
    }
  }
  function InitMove() {
          typeWriter()
      }
      window.onload = InitMove;
      if (document.addEventListener) {
  document.addEventListener('contextmenu', function(e) {
    alert("For security reasons, Right click is not allowed!"); //here you draw your own menu
    e.preventDefault();
  }, false);
} else {
  document.attachEvent('oncontextmenu', function() {
    alert("You've tried to open congtext menu");
    window.event.returnValue = false;
  });
}
  </script>
</body>
</html>
