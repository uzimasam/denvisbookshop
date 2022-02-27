<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-green layout-top-nav">
<div class="wrapper">
	<?php include 'includes/navbar.php'; ?>	 
  <div class="content-wrapper">
    <div class="container">
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
      <div class="box box-solid box-success direct-chat direct-chat-success" style="height:90%;">
        <div class="box-header with-border">
          <h3 class="box-title">Direct Chat</h3>
          <div class="box-tools pull-right">
            <span data-toggle="tooltip" title="3 New Messages" class="badge bg-green">3</span>
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <!-- In box-tools add this button if you intend to use the contacts pane 
            <button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <!-- Conversations are loaded here -->
          <div class="direct-chat-messages"  style="height: 400px;;">
          <?php 
              $nowa = $user['id']; 
              $conn = $pdo->open();
              try{
                $stmt = $conn->prepare("UPDATE message SET status=:receiverdelete WHERE receiver_id=$nowa");
                $stmt->execute(['receiverdelete'=>1]);
                $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM message WHERE sender_id=$nowa OR receiver_id=$nowa");
                $stmt->execute();
                $trow = $stmt->fetch();
                if($trow['numrows'] > 0){
                  $stmt = $conn->prepare("SELECT * FROM message LEFT JOIN users ON users.id=message.sender_id WHERE sender_id=$nowa OR receiver_id=$nowa ORDER BY message.id DESC");
                  $stmt->execute();
                  foreach($stmt as $row){
                    $bih = $row['sender_id'];
                    $dse = $row['type'];
                    $jdj = $row['photo'];
                    $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/profile.jpg';
                    if ($bih!=$nowa){
                      if ($dse==1) {
                        echo"
                          <div class='row' style='margin-bottom:10px;'>
                            <div class='col-md-1 col-xs-3 pull-left image user'>
                              <img style='width:100%;' src='".$image."' class='img-circle' alt='User Image'>
                            </div>
                            <div class='col-md-10 col-xs-8' style='background-color:lightblue; border-left:5px solid blue;'>
                              <p><u>".$row['firstname'].' '.$row['lastname']." : Management</u></p>
                              <p>".$row['message']."</p>
                              <span style='float:right;'>&nbsp; ".$row['timesent']." &nbsp;<i class='fa fa-trash text-danger'></i></span>
                            </div>
                          </div>
                        <hr>
                        ";
                      } 
                      elseif ($dse==2) {
                        echo"
                        <div class='row' style='margin-bottom:10px;'>
                          <div class='col-md-1 col-xs-3 pull-left image user'>
                            <img style='width:100%;' src='".$image."' class='img-circle' alt='User Image'>
                          </div>
                          <div class='col-md-10 col-xs-8' style='background-color:lightyellow; border-left:5px solid orange;'>
                            <p><u>".$row['firstname'].' '.$row['lastname']." : Support Team</u></p>
                            <p>".$row['message']."</p>
                            <span style='float:right;'>&nbsp; ".$row['timesent']." &nbsp;<i class='fa fa-trash text-danger'></i></span>
                          </div>
                        </div>
                        <hr>
                        ";
                      }
                      elseif ($dse==7) {
                        echo'
                          <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                              <span class="direct-chat-name pull-left">System Bot</span>
                              <span class="direct-chat-timestamp pull-right">'.$row['timesent'].'</span>
                            </div>
                            <img class="direct-chat-img" src="'.$image.'" alt="message user image"><!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                              '.$row['message'].'
                            </div><!-- /.direct-chat-text -->
                          </div><!-- /.direct-chat-msg -->
                        ';
                      }
                      else{
                        echo"
                          <div class='row' style='margin-bottom:10px;'>
                            <div class='col-md-1 col-xs-3 pull-left image user'>
                              <img style='width:100%;' src='".$image."' class='img-circle' alt='User Image'>
                            </div>
                            <div class='col-md-10 col-xs-8' style='background-color:lightgrey; border-left:5px solid grey;'>
                              <p><u>".$row['firstname'].' '.$row['lastname']." : Courier Service</u></p>
                              <p>".$row['message']."</p>
                              <span style='float:right;'>&nbsp; ".$row['timesent']." &nbsp;<i class='fa fa-trash text-danger'></i></span>
                            </div>
                          </div>
                          <hr>
                        ";
                      }
                    }
                    else{
                      echo'
                      <div class="direct-chat-msg right">
                        <div class="direct-chat-info clearfix">
                          <span class="direct-chat-timestamp pull-left">'.$row['timesent'].'</span>
                        </div><!-- /.direct-chat-info -->
                        <img class="direct-chat-img" src="./images/'.$user['photo'].'" alt="message user image"><!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                          '.$row['message'].'
                        </div><!-- /.direct-chat-text -->
                      </div><!-- /.direct-chat-msg -->
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
        <div class="box-footer">
          <div class="input-group">
            <form method="POST" action="contact_add.php">
              <input type="hidden" name="sender_id" value="<?php echo $user['id']?>">
              <input type="hidden" name="sender_name" value="<?php echo $user['firstname'].' '. $user['lastname']?>">
              <input type="hidden" name="sender_email" value="<?php echo $user['email']?>">
              <input type="hidden" name="sender_img" value="<?php echo $user['photo']?>">
              <input type="hidden" name="receiver_id" value="0">
              <input type="hidden" name="receiver_img" value="logo.png">
              <span class="input-group-btn text-center">
                <input type="text" name="message" placeholder="Type Message ..." style="width:100%;" class="form-control">
                <button type="submit" class="btn btn-success btn-flat" name="add"><i class="fa fa-send"></i> Send</button>
              </span>
          </div>
          </form>
        </div><!-- /.box-footer-->
      </div><!--/.direct-chat -->
      </section>
      <script>
  function initFreshChat() {
    window.fcWidget.init({
      token: "722b9b20-4b21-42f7-b335-ba15ed8462c1",
      host: "https://wchat.freshchat.com"
    });
  }
  function initialize(i,t){var e;i.getElementById(t)?initFreshChat():((e=i.createElement("script")).id=t,e.async=!0,e.src="https://wchat.freshchat.com/js/widget.js",e.onload=initFreshChat,i.head.appendChild(e))}function initiateCall(){initialize(document,"Freshchat-js-sdk")}window.addEventListener?window.addEventListener("load",initiateCall,!1):window.attachEvent("load",initiateCall,!1);
</script>
    </div>
  </div>
  <?php $pdo->close(); ?>
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/profile_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
