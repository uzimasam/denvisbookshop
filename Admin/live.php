<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<title>Denvis Bookshop | Admin</title>
  	<!-- Tell the browser to be responsive to screen width -->
  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<!-- Bootstrap 3.3.7 -->
  	<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  	<!-- Font Awesome -->
  	<link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../bower_components/select2/dist/css/select2.min.css">
  	<!-- Theme style -->
  	<link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  	<!-- DataTables -->
    <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="../plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  	<!--[if lt IE 9]>
  	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  	<![endif]-->

  	<!-- Google Font -->
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  	<style type="text/css">
  		.mt20{
  			margin-top:20px;
  		}
      .bold{
        font-weight:bold;
      }

      /*chart style*/
      #legend ul {
        list-style: none;
      }

      #legend ul li {
        display: inline;
        padding-left: 30px;
        position: relative;
        margin-bottom: 4px;
       /* border-radius: 5px;*/
        padding: 2px 8px 2px 28px;
        font-size: 14px;
        cursor: default;
        -webkit-transition: background-color 200ms ease-in-out;
        -moz-transition: background-color 200ms ease-in-out;
        -o-transition: background-color 200ms ease-in-out;
        transition: background-color 200ms ease-in-out;
      }

      #legend li span {
        display: block;
        position: absolute;
        left: 0;
        top: 0;
        width: 20px;
        height: 100%;
       /* border-radius: 5px;*/
      }
  	</style>
</head>
<?php include 'includes/session.php'; ?>
<?php
  if(!isset($_GET['user'])){
    header('location: users.php');
    exit();
  }
  else{
    $conn = $pdo->open();

    $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->execute(['id'=>$_GET['user']]);
    $user = $stmt->fetch();

    $pdo->close();
  }

?>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $user['firstname'].' '.$user['lastname'].'`s Message Box' ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Users</li>
        <li class="active">Messages</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
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
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
                <h4 class="modal-title">
                    <b>
                        Welcome 
                        <?php
                            if(isset($_SESSION['admin'])){
                                echo $admin['firstname'];
                            }
                            else{
                            echo "
                                <h4>You need to <a href='login.php'>Login</a> to start messaging.</h4>
                            ";
                            }
                        ?>
                        !
                    </b> 
                    <b class="pull-right">
                        <span style="color:tomato;">Contact</span> 
                        Center
                    </b>
                </h4>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-1 col-xs-3 pull-left image user">
                        <img style="width:100%;" src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
                        <h6>10:38AM</h6>
                    </div>
                    <div class="col-md-10 col-xs-8" style="padding:12px; background-color:lightgrey; border-left:5px solid grey;">
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Saepe eveniet enim ipsa debitis voluptates consequuntur, dignissimos voluptatibus totam minus provident, ipsum necessitatibus dicta alias, vel aut sunt. Aspernatur, facilis magnam.</p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-1 col-xs-3 pull-right image user">
                        <img style="width:100%;" src="<?php echo (!empty($admin['photo'])) ? '../images/'.$admin['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
                        <h6><i class="fa fa-eye-slash">10:38AM</i></h6>
                    </div>

                    <div class="col-md-10 col-xs-8 pull-right" style="padding:12px; background-color:lightgreen; border-right:5px solid green;">
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Saepe eveniet enim ipsa debitis voluptates consequuntur, dignissimos voluptatibus totam minus provident, ipsum necessitatibus dicta alias, vel aut sunt. Aspernatur, facilis magnam.</p>
                    </div>
                </div>
            </div>
            <div class="box-footer" style="background-color:lightgrey;">
                <div>
                        <form class="form-horizontal" method="POST" action="contact_add.php">
                            <input type="hidden" class="userid" name="id"></input>
                            <div class="row form-group">
                                <div class="col-md-10 col-xs-8">
                                    <textarea class="form-control" style="width: 100%; margin-left:15px;" name="message" id="message" required placeholder="Type your message here..."></textarea>
                                </div>
                                <button type="submit" class="col-md-1 col-xs-3 btn btn-success btn-flat" style="padding:16px; name="add"><i class="fa fa-send"></i> Send</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
      </div>
    </section>
     
  </div>
  	<?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
</body>
</html>
