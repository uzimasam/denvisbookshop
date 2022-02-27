<?php include 'includes/session.php'; ?>
<?php
	if(!isset($_GET['user'])){
    header('location: contacts.php');
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
<?php 
  $owa = $admin['id'];
  $nowa = $user['id'];
  if($owa==$nowa){
    header('location: contacts.php');
    exit();
  }
  $or = 'OR receiver_id=0 AND sender_id='.$nowa;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Denvis Bookshop | Direct Message</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Chat with <?php echo $user['firstname'].' '.$user['lastname'] ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./home.php">Home</a></li>
              <li class="breadcrumb-item"><a href="./contacts.php">Contacts</a></li>
              <li class="breadcrumb-item"><a href="./sent.php">Contact Center</a></li>
              <li class="breadcrumb-item active"><?php echo $user['firstname'].' '.$user['lastname'] ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
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
    </section>
      
    <!-- Main content -->
    <section class="content">
      <div class="card card-success card-outline direct-chat direct-chat-success">
        <div class="card-body">
          <div id="ala" class="direct-chat-messages" style="height:70vh;">
            <?php
              $bano = $admin['id'];
              $nowa = $user['id']; 
              $conn = $pdo->open();
              try{
                $stmt = $conn->prepare("UPDATE message SET status=1 WHERE sender_id=$nowa AND receiver_id=$bano $or");
                $stmt->execute();
                $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM message WHERE sender_id=$nowa AND receiver_id=$bano OR sender_id=$bano AND receiver_id=$nowa $or");
                $stmt->execute();
                $trow = $stmt->fetch();
                  if($trow['numrows'] > 0){
                    $stmt = $conn->prepare("SELECT *, message.status as mst FROM message LEFT JOIN users ON users.id=message.sender_id WHERE sender_id=$nowa AND receiver_id=$bano OR sender_id=$bano AND receiver_id=$nowa $or ORDER BY message.mid");
                    $stmt->execute();
                    foreach($stmt as $row){
                      $bih = $row['sender_id'];
                      $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                      if ($bih==$nowa){
                        echo "
                          <div class='direct-chat-msg'>
                            <div class='direct-chat-infos clearfix'>
                              <span class='direct-chat-name float-left'>".$row['firstname'].' '.$row['lastname']."</span>
                              <span class='direct-chat-timestamp float-right'> ".date('d M. Y h:ia', strtotime($row['timesent']))."</span>
                            </div>
                            <img class='direct-chat-img' src='".$image."' alt='Message User Image'>
                            <div class='direct-chat-text'>
                              ".$row['message']."
                            </div>
                          </div>
                        ";
                      }
                      elseif($bih==$bano){
                        echo'
                          <div class="direct-chat-msg right">
                            <div class="direct-chat-infos clearfix">
                              <span class="direct-chat-name float-right">'.$row['firstname'].' '.$row['lastname'].'</span>
                              <span class="direct-chat-timestamp float-left">'.date('d M. Y h:ia', strtotime($row['timesent'])).' 
                        ';
                        if($row['mst']==1) {
                          echo '<small class="fas text-info fa-check"></small></span>';
                        }
                        else{
                          echo '<small class="fas fa-check"></small></span>';
                        } 
                        echo'
                            </div>
                            <img class="direct-chat-img" src="'.$image.'" alt="Message User Image">
                            <div class="direct-chat-text">
                              '.$row['message'].'
                            </div>
                          </div>
                        ';
                      }
                    }
                  }
                  else{
                    echo"
                      <p style='background-color:wheat; text-align:center; padding:10px; border:2px solid tan; border-radius:5px;'><b>No message to show in chat.<br>Start conversation</b></p>
                    ";
                  }
                }
                catch(PDOException $e){
                  echo "There is some problem in connection: " . $e->getMessage();
                }
                $pdo->close();
              ?>
							</div><!--/.direct-chat-messages-->
						</div><!-- /.box-body -->
						<div class="card-footer">
          <form method="POST" action="contact_add.php">
            <div class="input-group">
              <input type="hidden" name="sender_id" value="<?php echo $admin['id']?>">
              <input type="hidden" name="receiver_id" value="<?php echo $user['id']?>">
              <input type="text" name="message" placeholder="Type Message ..." class="form-control">
              <span class="input-group-append">
								<button type="submit" class="btn btn-success" name="add">Send</button>
              </span>
            </div>
          </form>
        </div>
        
					</div><!--/.direct-chat -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>
<script>
$("#ala").animate({ scrollTop: $('#ala').height()}, 1000);</script>
</body>
</html>

