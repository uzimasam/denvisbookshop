<?php 
  include 'includes/session.php';
  include 'includes/format.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Denvis Bookshop | Orders</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <?php
              $conn = $pdo->open();
              $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE orderstatus!=0");
              $stmt->execute();
              $urow =  $stmt->fetch();

              echo "<h1>".$urow['numrows']." Orders</h1>";
            ?>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Orders</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
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
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Date Placed</th>
                    <th>Order Status</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Location</th>
                    <th>Email</th>
                    <th>User Status</th>
                    <th>Photo</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT * FROM users oder WHERE orderstatus!=:type ORDER BY ordertime");
                      $stmt->execute(['type'=>0]);
                      foreach($stmt as $row){
                        $de = $row['id'];
                        $not = $row['notif'];
                        $imag= $row['photo'];
                        $orderstatus = $row['orderstatus'];
                        $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                        $status = ($row['status']) ? '<span class="badge badge-success">active</span>': '<span class="badge badge-danger">Blocked</span>';
                        $active = (!$row['status']) ? '<span class="pull-right"><a href="#activate" class="status" data-toggle="modal" data-id="'.$row['id'].'"><i class="fa fa-check-square-o"></i></a></span>' : ' ';
                        $contact = (!empty($row['contact_info'])) ? $row['contact_info'] : 'N/a';
                        $location = (!empty($row['address'])) ? $row['address'] : 'N/a';
                        $message = 'Hello, we are processing your order, kindly update your physical address to your current location and your contact info to a valid phone number <a href="#edit" data-toggle="modal">Here</a>';
                        $message1 = 'Hello, we are processing your order, kindly update your physical address to your current location <a href="#edit" data-toggle="modal">Here</a>';
                        $message2 = 'Hello, we are processing your order, kindly update your contact info to a valid phone number <a href="#edit" data-toggle="modal">Here</a>';
                        $message0 = 'ORDER STATUS : <span class="badge badge-success">Waiting to be counterchecked</span>';
                        if($orderstatus == 1){
                          $stmt = $conn->prepare("UPDATE users SET orderstatus=:intiate WHERE id=:id");
                          $stmt->execute(['intiate'=>2, 'id'=>$de]);
                          $label = '<span class="badge badge-success">Newly Placed</span>';
                          $button = "<a href='cart.php?user=".$de."' class='btn btn-round btn-primary btn-sm btn-flat'><i class='fa fa-shopping-cart'></i>  Go to Cart</a>";
                        }
                        elseif($orderstatus == 2){
                          $label = '<span class="badge badge-primary">Waiting</span>';
                          $button = "<a href='cart.php?user=".$de."' class='btn btn-round btn-info btn-sm btn-flat'><i class='fa fa-phone'></i>  Countercheck</a>";
                        }
                        elseif($orderstatus == 3){
                          $label = '<span class="badge badge-info">Counterchecked</span>';
                          $button = "<a href='pos.php?user=".$de."' class='btn btn-round btn-warning btn-sm btn-flat'><i class='fa fa-money'></i>  Payment</a>";
                        }
                        elseif($orderstatus == 4){
                          $label = '<span class="badge badge-warning">Payed</span>';
                          $button = "<a href='cart.php?user=".$de."' class='btn btn-round btn-success btn-sm btn-flat'><i class='fa fa-recycle'></i>  Complete</a>";
                        }
                        else{
                          $label = '<span class="badge badge-danger">Error</span>';
                          $button = "<a href='cart.php?user=".$de."' class='btn btn-round btn-danger btn-sm btn-flat'><i class='fa fa-trash'></i>  Delete</a>";
                        }
                        if($not == 0){
                          if($location == 'N/a'){
                            $stmt = $conn->prepare("UPDATE users SET notif=:initiate WHERE id=:id");
                            $stmt->execute(['initiate'=>1, 'id'=>$de]);
                            if($contact == 'N/a'){
                              $stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, receiver_img, message) VALUES (:sender_id, :receiver_id,  :receiver_img, :message)");
                              $stmt->execute(['sender_id'=>2, 'receiver_id'=>$de, 'receiver_img'=>$imag, 'message'=>$message]);
                              $stmt = $conn->prepare("UPDATE users SET notif=:initiate WHERE id=:id");
                              $stmt->execute(['initiate'=>1, 'id'=>$de]);
                            }
                            else{
                              $stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, receiver_img, message) VALUES (:sender_id, :receiver_id,  :receiver_img, :message)");
	  	                        $stmt->execute(['sender_id'=>2, 'receiver_id'=>$de, 'receiver_img'=>$imag, 'message'=>$message1]);
                            }
                          }
                          elseif($contact == 'N/a'){
                            $stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, receiver_img, message) VALUES (:sender_id, :receiver_id,  :receiver_img, :message)");
		                        $stmt->execute(['sender_id'=>2, 'receiver_id'=>$de, 'receiver_img'=>$imag, 'message'=>$message2]);
                            $stmt = $conn->prepare("UPDATE users SET notif=:initiate WHERE id=:id");
                            $stmt->execute(['initiate'=>1, 'id'=>$de]);
                          }
                          else{
                            $stmt = $conn->prepare("UPDATE users SET notif=:initiate WHERE id=:id");
                            $stmt->execute(['initiate'=>1, 'id'=>$de]);
                          }
                        }
                        elseif($not == 1){
                          $stmt = $conn->prepare("UPDATE users SET notif=:initiate WHERE id=:id");
                          $stmt->execute(['initiate'=>2, 'id'=>$de]);
                          $stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, receiver_img, message) VALUES (:sender_id, :receiver_id,  :receiver_img, :message)");
                          $stmt->execute(['sender_id'=>2, 'receiver_id'=>$de, 'receiver_img'=>$imag, 'message'=>$message0]);
                        }
                        echo "
                          <tr>
                            <td>".date('D d-M-Y h:i:sA', strtotime($row['ordertime']))."</td>
                            <td>".$label."</td>
                            <td>".$row['firstname'].' '.$row['lastname']."</td>
                            <td>".$contact."</td>
                            <td>".$location."</td>
                            <td>".$row['email']."</td>
                            <td>
                              ".$status."
                              ".$active."
                            </td>
                            <td>
                              <img src='".$image."' style='height:30px; width:30px; border-radius:50%;'>
                            </td>
                          </tr>
                        ";
                      }
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }

                    $pdo->close();
                  ?> 
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<a id="back-to-top" href="#" class="btn btn-success back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="./plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="./plugins/jszip/jszip.min.js"></script>
<script src="./plugins/pdfmake/pdfmake.min.js"></script>
<script src="./plugins/pdfmake/vfs_fonts.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
