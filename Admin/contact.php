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
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $user['firstname'].' '.$user['lastname'].'`s Message Box' ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="contacts.php"><i class="fa fa-tasks"></i> Contacts</a></li>
        <li class="active"><i class="fa fa-comments-o"></i></li>
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
                        ?>!
                    </b> 
                    <b class="pull-right">
                        <span style="color:tomato;">Contact</span> 
                        Center
                    </b>
                </h4>
            </div>
            <div class="box-body">
              <?php 
                $nowa = $admin['id']; 
                $wano = $user['id'];
                $wan = 0;
                $conn = $pdo->open();

                try{
                  $stmt = $conn->prepare("UPDATE message SET status=:receiverdelete WHERE sender_id=$wano AND receiver_id=$nowa OR sender_id=$wano AND receiver_id=$wan");
			            $stmt->execute(['receiverdelete'=>1]);
                  $stmt = $conn->prepare("SELECT * FROM message WHERE sender_id=$nowa AND receiver_id=$wano OR sender_id=$wano AND receiver_id=$nowa OR sender_id=$wano AND receiver_id=$wan");
                  $stmt->execute();
                  foreach($stmt as $row){
                    $imag = (!empty($row['sender_img'])) ? '../images/'.$row['sender_img'] : '../images/profile.jpg';
                    $bih = $row['sender_id'];
                    if ($bih==$wano) {
                      echo"
                      <div class='row'>
                        <div class='col-md-1 col-xs-3 pull-left image user'>
                          <img style='width:100%;' src='".$imag."' class='img-circle' alt='User Image'>
                        </div>
                        <div class='col-md-10 col-xs-8' style='background-color:lightgrey; border-left:5px solid grey;'>
                          <p>".$row['message']."</p>
                          <span style='float:right;'>&nbsp; ".$row['timesent']." &nbsp;</span>
                        </div>
                      </div>
                      <hr>
                      ";
                    } 
                    elseif ($bih=$nowa) {
                      echo"
                        <div class='row'>
                          <div class='col-md-1 col-xs-3 pull-right image user'>
                            <img style='width:100%;' src='".$imag."' class='img-circle' alt='User Image'>
                          </div>
                          <div class='col-md-10 col-xs-8 pull-right' style='background-color:lightgreen; border-right:5px solid green;'>
                            <p>".$row['message']."</p>
                            <span style='float:right;'>&nbsp; ".$row['timesent']." &nbsp;</span>
                            ";
                            if($row['status']==0){
                              echo"
                                <span style='float:right;' data-toggle='toolip' title='Message  not viewed'>&nbsp; <i class='fa fa-eye-slash'></i> &nbsp;</span>
                              ";
                            }
                            else{
                              echo"
                                <span style='float:right;' data-toggle='toolip' title='Message viewed'>&nbsp; <i class='fa fa-eye'></i> &nbsp;</span>
                              ";
                            }
                          echo"
                          </div>
                        </div>
                        <hr>
                      ";
                    }
                    else{ 
                      echo"
                      <div class='row'>
                        <div class='col-md-1 col-xs-3 pull-left image user'>
                          <img style='width:100%;' src='".$imag."' class='img-circle' alt='User Image'>
                        </div>
                        <div class='col-md-10 col-xs-8' style='background-color:lightgrey; border-left:5px solid grey;'>
                          <p>".$row['message']."</p>
                          <span style='float:right;'>&nbsp; ".$row['timesent']." &nbsp;</span>
                        </div>
                      </div>
                      <hr>
                      ";
                    }
                  }
                }
                catch(PDOException $e){
                  echo "There is some problem in connection: " . $e->getMessage();
                }
                $pdo->close();
              ?>
                
            </div>
            <div class="box-footer" style="background-color:lightgrey;">
              <div>
                <form class="form-horizontal" method="POST" action="contact_add.php">
                    <div class="row form-group">
                        <input type="hidden" name="sender_id" value="<?php echo $admin['id']?>">
                        <input type="hidden" name="sender_name" value="<?php echo $admin['firstname'].' '. $admin['lastname']?>">
                        <input type="hidden" name="sender_email" value="<?php echo $admin['email']?>">
                        <input type="hidden" name="sender_img" value="<?php echo $admin['photo']?>"><input type="hidden" name="sender_id" value="<?php echo $admin['id']?>">
                        <input type="hidden" name="receiver_id" value="<?php echo $user['id']?>">
                        <input type="hidden" name="receiver_name" value="<?php echo $user['firstname'].' '. $user['lastname']?>">
                        <input type="hidden" name="receiver_email" value="<?php echo $user['email']?>">
                        <input type="hidden" name="receiver_img" value="<?php echo $user['photo']?>">
                        <div class="col-md-10 col-xs-8">
                            <textarea class="form-control" style="width: 100%; margin-left:15px;" name="message" id="message" required placeholder="Type your message here..."></textarea>
                        </div>
                        <button type="submit" class="col-md-1 col-xs-3 btn btn-success btn-flat" style="padding:16px;" name="add"><i class="fa fa-send"></i> Send</button>
                    </div>
                </form>
              </div>
            </div>
        </div>
      </div>
    </section>
     
  </div>
  	<?php include 'includes/footer.php'; ?>
    <?php include 'includes/contact_modal.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>

</body>
</html>
