<?php 
  include 'includes/session.php';
  $nowa = $admin['id'];
  $where = 'receiver_id=0 OR receiver_id='.$nowa;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Denvis Bookshop | Contact Center</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../Admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="../Admin/plugins/ekko-lightbox/ekko-lightbox.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../Admin/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../Admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper kanban">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h1>Contact Center</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-block">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active">Contact Center</li>
              </ol>
            </div>
          </div>
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
        </div>
      </section>      
      <section class="content pb-3">
        <div class="container-fluid h-100">
          <div class="card card-row card-danger">
            <div class="card-header">
              <h3 class="card-title">
                Inbox #Unread
              </h3>
              <div class="card-tools">
                <a href="#" class="btn btn-tool" data-toggle="toolip" title="Mark all as read!">
                  <i class="far fa-eye"></i>
                </a>
                <a href="#" class="btn btn-tool" data-toggle="toolip" title="Delete All Unread!">
                  <i class="far fa-trash-alt"></i>
                </a>
              </div>
            </div>
            <div class="card-body">
              <?php
                $conn = $pdo->open();
                try{
                  $stmt = $conn->prepare("SELECT * FROM message LEFT JOIN users ON users.id=message.sender_id WHERE message.status=0 and $where");
                  $stmt->execute();
                  foreach($stmt as $row){
                    $bih = $row['id'];
                    $si = $row['sender_id'];
                    $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                    echo'
                      <div class="card card-danger card-outline">
                        <div class="card-header">
                          <img src="'.$image.'" class="img-circle elevation-2 float-left" style="width:25px; height:25px;">
                          <h5 class="card-title"> &nbsp;&nbsp;'.$row['firstname'].' '.$row['lastname'].'</h5>
                          <div class="card-tools">
                            <a href="#" class="btn btn-tool" data-toggle="toolip" title="Mark as Read">
                              <i class="far fa-eye"></i>
                            </a>
                          </div>
                        </div>
                        <a href="message.php?user='.$bih.'" data-toggle="toolip" title="View message">
                          <div class="card-body">
                            '.substr($row['message'], 0, 30).'...
                          </div>
                        </a>
                        <div class="card-footer">
                          <small class="text-muted float-left">'.date('d M. Y h:ia', strtotime($row['timesent'])).'</small>
                          <a href="#" class="btn btn-tool float-right" data-toggle="toolip" title="Delete for me" style="padding-top:12px;">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </div>
                    ';
                  }
                }
                catch(PDOException $e){
                  echo "There is some problem in connection: " . $e->getMessage();
                }
                $pdo->close();
              ?>
            </div>
          </div>
          <div class="card card-row card-success">
            <div class="card-header">
              <h3 class="card-title">
                Inbox #Read
              </h3>
              <div class="card-tools">
                <a href="#" class="btn btn-tool" data-toggle="toolip" title="Mark All As Unread!">
                  <i class="far fa-eye-slash"></i>
                </a>
                <a href="#" class="btn btn-tool" data-toggle="toolip" title="Delete All Read!">
                  <i class="far fa-trash-alt"></i>
                </a>
              </div>
            </div>
            <div class="card-body">
              <?php
                $conn = $pdo->open();

                try{
                  $stmt = $conn->prepare("SELECT * FROM message LEFT JOIN users ON users.id=message.sender_id WHERE message.status=11 AND receiver_id=$nowa");
                  $stmt->execute();
                  foreach($stmt as $row){
                    $bih = $row['id'];
                    $si = $row['sender_id'];
                    $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                    echo'
                      <div class="card card-success card-outline">
                        <div class="card-header">
                          <img src="'.$image.'" class="img-circle elevation-2 float-left" style="width:25px; height:25px;">
                          <h5 class="card-title"> &nbsp;&nbsp;'.$row['firstname'].' '.$row['lastname'].'</h5>
                          <div class="card-tools">
                            <a href="#" class="btn btn-tool" data-toggle="toolip" title="Mark as Unread">
                              <i class="far fa-eye-slash"></i>
                            </a>
                    
                          </div>
                        </div>
                        <a href="message.php?user='.$bih.'" data-toggle="toolip" title="View message">
                          <div class="card-body">
                            '.substr($row['message'], 0, 30).'...
                          </div>
                        </a>
                        <div class="card-footer">
                          <small class="text-muted float-left">'.date('d M. Y h:ia', strtotime($row['timesent'])).'</small>
                          <a href="#" class="btn btn-tool float-right" data-toggle="toolip" title="Delete for me" style="padding-top:12px;">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </div>
                    ';
                  }
                }
                catch(PDOException $e){
                  echo "There is some problem in connection: " . $e->getMessage();
                }
                $pdo->close();
              ?>
            </div>
          </div>
          <div class="card card-row card-warning">
            <div class="card-header">
              <h3 class="card-title">
                Sent #Unread
              </h3>
              <div class="card-tools">
                <a href="#" class="btn btn-tool" data-toggle="toolip" title="Delete All For Everyone!">
                  <i class="far fa-trash-alt"></i>
                </a>
              </div>
            </div>
            <div class="card-body">
              <?php
                $conn = $pdo->open();

                try{
                  $stmt = $conn->prepare("SELECT * FROM message LEFT JOIN users ON users.id=message.receiver_id WHERE message.status=0 and sender_id=$nowa");
                  $stmt->execute();
                  foreach($stmt as $row){
                    $bih = $row['id'];
                    $si = $row['sender_id'];
                    $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                    echo'
                      <div class="card card-warning card-outline">
                        <div class="card-header">
                          <img src="'.$image.'" class="img-circle elevation-2 float-left" style="width:25px; height:25px;">
                          <h5 class="card-title"> &nbsp;&nbsp;'.$row['firstname'].' '.$row['lastname'].'</h5>
                        </div>
                        <a href="message.php?user='.$bih.'" data-toggle="toolip" title="View message">
                          <div class="card-body">
                            '.substr($row['message'], 0, 30).'...
                          </div>
                        </a>
                        <div class="card-footer">
                          <small class="text-muted float-left">'.date('d M. Y h:ia', strtotime($row['timesent'])).'</small>
                          <a href="#" class="btn btn-tool float-right" data-toggle="toolip" title="Delete for everyone" style="padding-top:12px;">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </div>
                    ';
                  }
                }
                catch(PDOException $e){
                  echo "There is some problem in connection: " . $e->getMessage();
                }
                $pdo->close();
              ?>
            </div>
          </div>
          <div class="card card-row card-info">
            <div class="card-header">
              <h3 class="card-title">
                Sent #Read
              </h3>
              <div class="card-tools">
                <a href="#" class="btn btn-tool" data-toggle="toolip" title="Delete All For Me!">
                  <i class="far fa-trash-alt"></i>
                </a>
              </div>
            </div>
            <div class="card-body">
              <?php
                $conn = $pdo->open();

                try{
                  $stmt = $conn->prepare("SELECT * FROM message LEFT JOIN users ON users.id=message.receiver_id WHERE message.status=1 and sender_id=$nowa");
                  $stmt->execute();
                  foreach($stmt as $row){
                    $bih = $row['id'];
                    $si = $row['sender_id'];
                    $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                    echo'
                      <div class="card card-info card-outline">
                        <div class="card-header">
                          <img src="'.$image.'" class="img-circle elevation-2 float-left" style="width:25px; height:25px;">
                          <h5 class="card-title"> &nbsp;&nbsp;'.$row['firstname'].' '.$row['lastname'].'</h5>
                        </div>
                        <a href="message.php?user='.$bih.'" data-toggle="toolip" title="View message">
                          <div class="card-body">
                            '.substr($row['message'], 0, 30).'...
                          </div>
                        </a>
                        <div class="card-footer">
                          <small class="text-muted float-left">'.date('d M. Y h:ia', strtotime($row['timesent'])).'</small>
                          <a href="#" class="btn btn-tool float-right" data-toggle="toolip" title="Delete for me" style="padding-top:12px;">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </div>
                    ';
                  }
                }
                catch(PDOException $e){
                  echo "There is some problem in connection: " . $e->getMessage();
                }
                $pdo->close();
              ?>
            </div>
          </div>
          <div class="card card-row card-danger">
            <div class="card-header">
              <h3 class="card-title">
                System #Unread
              </h3>
            </div>
            <div class="card-body">
              <?php
                $conn = $pdo->open();
                  try{
                    $stmt = $conn->prepare("SELECT * FROM message LEFT JOIN users ON users.id=message.receiver_id WHERE message.status=0 and sender_id=2");
                    $stmt->execute();
                    foreach($stmt as $row){
                      $bih = $row['id'];
                      $si = $row['sender_id'];
                      $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                      echo'
                        <div class="card card-danger card-outline">
                          <div class="card-header">
                            <img src="'.$image.'" class="img-circle elevation-2 float-left" style="width:25px; height:25px;">
                            <h5 class="card-title"> &nbsp;&nbsp;'.$row['firstname'].' '.$row['lastname'].'</h5>
                          </div>
                          <a href="message.php?user='.$bih.'" data-toggle="toolip" title="View message">
                            <div class="card-body">
                              '.substr($row['message'], 0, 30).'...
                            </div>
                          </a>
                          <div class="card-footer">
                            <small class="text-muted float-left">'.date('d M. Y h:ia', strtotime($row['timesent'])).'</small>
                          </div>
                        </div>
                      ';
                    }
                  }
                  catch(PDOException $e){
                    echo "There is some problem in connection: " . $e->getMessage();
                  }
                $pdo->close();
              ?>                  
            </div>
          </div>
          <div class="card card-row card-success">
            <div class="card-header">
              <h3 class="card-title">
                System #Read
              </h3>
            </div>
            <div class="card-body">
              <?php
                $conn = $pdo->open();  
                try{
                  $stmt = $conn->prepare("SELECT * FROM message LEFT JOIN users ON users.id=message.receiver_id WHERE message.status=1 and sender_id=2");
                  $stmt->execute();
                  foreach($stmt as $row){
                    $bih = $row['id'];
                    $si = $row['sender_id'];
                    $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                    echo'
                      <div class="card card-danger card-outline">
                        <div class="card-header">
                          <img src="'.$image.'" class="img-circle elevation-2 float-left" style="width:25px; height:25px;">
                          <h5 class="card-title"> &nbsp;&nbsp;'.$row['firstname'].' '.$row['lastname'].'</h5>
                        </div>
                        <a href="message.php?user='.$bih.'" data-toggle="toolip" title="View message">
                          <div class="card-body">
                            '.substr($row['message'], 0, 30).'...
                          </div>
                        </a>
                        <div class="card-footer">
                          <small class="text-muted float-left">'.date('d M. Y h:ia', strtotime($row['timesent'])).'</small>
                        </div>
                      </div>
                    ';
                  }
                }
                catch(PDOException $e){
                  echo "There is some problem in connection: " . $e->getMessage();
                }
                $pdo->close();
              ?>
            </div>
          </div>
        </div>
    </section>
  </div>

  
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../Admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../Admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Ekko Lightbox -->
<script src="../Admin/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<!-- overlayScrollbars -->
<script src="../Admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../Admin/dist/js/adminlte.min.js"></script>
<!-- Filterizr-->
<script src="../Admin/plugins/filterizr/jquery.filterizr.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../Admin/dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {

  })
</script>
</body>
</html>
