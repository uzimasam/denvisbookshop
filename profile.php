<?php include 'includes/session.php'; ?>
<?php
	if(!isset($_SESSION['user'])){
		header('location: index.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" content="Ecommerce Bookshop">
  <meta charset="utf-8">
    <meta name="keywords" content="Denvis Bookshop, Uzima Samuel, Zalego, stationery, vihiga, kenya">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#00A65A">
  <title>Denvis Bookshop | User Dashboard</title>
  <link rel="icon" href="images/logo.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./Admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./Admin/dist/css/adminlte.min.css">
  <style>
  #profileImage {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: #00A65A;
  border-color: #fff;
  border-spacing: 15px;
  font-size: 50px;
  color: #fff;
  text-align: center;
  line-height: 90px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-success navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
	  <li class="nav-item">
	  <span class="navbar-brand logo-mini" style="color: black;"><b style="color:tomato;">Denvis</b>Bookshop</span>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="./" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="./shop-grid.php" class="nav-link">Shop</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="./contactus.php" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form method="POST" class="form-inline" action="search.php">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" name="keyword" placeholder="What do you need?" required aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
	  <?php
		if(isset($_SESSION['user'])){
			$ui = $user['id'];
			$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM message where status=0 and receiver_id=$ui");
			$stmt->execute();
			$urow =  $stmt->fetch();
		}
		if($urow['numrows']>0){
			echo '
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">
						<i class="far fa-comments"></i>
						<span class="badge badge-danger navbar-badge">'.$urow['numrows'].'</span>
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<span class="dropdown-item bg-gradient-success dropdown-header bg-gradient-success">You have '.$urow['numrows'].' unread messages!</span>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item bg-gradient-success dropdown-footer">See All Messages</a>
					</div>
				</li>
			';
		}
	  ?>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-shopping-cart"></i>
          <span class="badge badge-success navbar-badge cart_count"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header bg-gradient-success"> <span class="cart_count"></span>  Products in cart</span>
          <div class="dropdown-divider bg-gradient-success"></div>
          <a href="cart_view.php" class="dropdown-item bg-gradient-success dropdown-footer">Go to Cart</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./logout.php" role="button">
          <i class="fa fa-sign-out-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">User Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <?php
			if(isset($_SESSION['error'])){
				echo "
					<div class='alert alert-danger'>
						".$_SESSION['error']."
					</div>
				";
				unset($_SESSION['error']);
			}

			if(isset($_SESSION['success'])){
				echo "
					<div class='alert alert-dismissable alert-success' role='alert'>
						".$_SESSION['success']."
					</div>
				";
				unset($_SESSION['success']);
			}
		?>
        <div class="container-fluid">
        	<div class="row">
          		<div class="col-md-3">

            		<!-- Profile Image -->
            		<div class="card card-success shadow-lg card-outline">
		              <div class="card-body box-profile">
		                <div class="text-center" style="text-align: center;">
		                  <!--<img class="profile-user-img img-fluid img-circle" src="<#?php echo (!empty($user['photo'])) ? 'images/'.$user['photo'] : 'images/profile.jpg'; ?>" alt="User profile picture" style="height:100px; width: 100px;">-->
						   <div style="border:2px solid #dc3545; border-radius:50%; width: 104px; margin: 0 auto; height: 104px;" class="text-center;"><div id="profileImage"  class="profile-user-img img-fluid img-circle text-center"></div></div>
		                </div>

        		        <h3 class="profile-username text-center"><span id="firstName"><?php echo $user['firstname']?></span> <span id="lastName"><?php echo $user['lastname']?></span></h3>

		                <p class="text-muted text-center">Joined <?php echo date('M d, Y', strtotime($user['created_on'])); ?></p>

        		        <ul class="list-group list-group-unbordered mb-3">
							<li class="list-group-item">
            			        <b>Contact</b> <a class="float-right"><?php echo (!empty($user['contact_info'])) ? $user['contact_info'] : 'N/a'; ?></a>
                  			</li>
							<li class="list-group-item">
            			        <b>Location</b> <a class="float-right"><?php echo (!empty($user['address'])) ? $user['address'] : 'N/a'; ?></a>
                  			</li>
                  			<li class="list-group-item">
                    			<b>Email</b> <a class="float-right"><?php echo $user['email']; ?></a>
                  			</li>
                		</ul>
                		<a href="cart_view.php" class="btn btn-success btn-block"><b><i class="fa fa-shopping-cart"></i> View Cart</b></a>
                		<a href="#edit" class="btn btn-danger btn-block" data-toggle="modal"><b><i class="fa fa-id-card"></i> Edit Profile</b></a>
					  </div>
              			<!-- /.card-body -->
            		</div>
            		<!-- /.card -->
          		</div>
          		<!-- /.col -->
          		<div class="col-md-9">
  				    <div class="card card-success card-outline direct-chat direct-chat-success">
						<div class="card-header with-border">
							<h3 class="card-title nav-pills nav-item"><i class="far fa-comment-dots"></i> <b> My Messages</b></h3>
							<div class="card-tools">
								<button class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
								<!-- In box-tools add this button if you intend to use the contacts pane 
								<button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>
								<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
							</div>
						</div><!-- /.box-header -->
						<div class="card-body">
							<!-- Conversations are loaded here -->
							<div class="direct-chat-messages" id="ala" style="height:50vh;">
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
											$stmt = $conn->prepare("SELECT * FROM message LEFT JOIN users ON users.id=message.sender_id WHERE sender_id=$nowa OR receiver_id=$nowa ORDER BY message.mid");
											$stmt->execute();
											foreach($stmt as $row){
												$bih = $row['sender_id'];
												$dse = $row['type'];
												$jdj = $row['photo'];
												$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/profile.jpg';
												$imag = (!empty($user['photo'])) ? 'images/'.$user['photo'] : 'images/profile.jpg';
												if ($bih!=$nowa){
													if ($dse==1) {
														echo"
														<div class='direct-chat-msg'>
															<div class='direct-chat-infos clearfix'>
																<span class='direct-chat-name float-left'>".$row['firstname'].' '.$row['lastname']." : Management</span>
																<span class='direct-chat-timestamp float-right'> ".$row['timesent']."</span>
															</div>
															<img class='direct-chat-img' src='".$image."' alt='Message User Image'>
															<div class='direct-chat-text'>
																".$row['message']."
															</div>
														</div>
														";
													} 
													elseif ($dse==2) {
														echo"
														<div class='direct-chat-msg'>
															<div class='direct-chat-infos clearfix'>
																<span class='direct-chat-name float-left'>".$row['firstname'].' '.$row['lastname']." : Support Team</span>
																<span class='direct-chat-timestamp float-right'> ".$row['timesent']."</span>
															</div>
															<img class='direct-chat-img' src='".$image."' alt='Message User Image'>
															<div class='direct-chat-text'>
																".$row['message']."
															</div>
														</div>
														";
													}
													elseif ($dse==7) {
														echo"
														<div class='direct-chat-msg'>
															<div class='direct-chat-infos clearfix'>
																<span class='direct-chat-name float-left'>System Bot</span>
																<span class='direct-chat-timestamp float-right'> ".$row['timesent']."</span>
															</div>
															<img class='direct-chat-img' src='".$image."' alt='Message User Image'>
															<div class='direct-chat-text'>
																".$row['message']."
															</div>
														</div>
														";
													}
												}
												else{
													echo'
														<div class="direct-chat-msg right">
                    										<div class="direct-chat-infos clearfix">
                      											<span class="direct-chat-name float-right">'.$user['firstname'].' '.$user['lastname'].'</span>
                      											<span class="direct-chat-timestamp float-left">'.$row['timesent'].'</span>
                    										</div>
										                    <img class="direct-chat-img" src="'.$imag.'" alt="Message User Image">
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
								<input type="hidden" name="sender_id" value="<?php echo $user['id']?>">
								<input type="hidden" name="receiver_id" value="0">
								<input type="text" name="message" placeholder="Type Message ..." class="form-control">
								<span class="input-group-append">
								<button type="submit" class="btn btn-success" name="add">Send</button>
								</span>
							</div>
							</form>
						</div>
					</div><!--/.direct-chat -->
            		<div class="card">
					<div class="card-header with-border">
							<h3 class="card-title nav-pills nav-item"><i class="far fa-calendar-alt"></i> <b> Transaction History</b></h3>
							<div class="card-tools">
								<button class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
								<!-- In box-tools add this button if you intend to use the contacts pane 
								<button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>
								<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
							</div>
						</div><!-- /.card-header -->
              			<div class="card-body">
                			<table class="table table-bordered" style="width:100%;" id="example1">
                  				<thead>
                    				<th class="hidden"></th>
                    				<th>Date</th>
                    				<th>Transaction#</th>
                    				<th>Amount</th>
                    				<th>Full Details</th>
                  				</thead>
                  				<tbody>
                  					<?php
										$no=1;
                    					$conn = $pdo->open();
      
					                    try{
                      						$stmt = $conn->prepare("SELECT * FROM trans WHERE user_id=:user_id ORDER BY date DESC");
                      						$stmt->execute(['user_id'=>$user['id']]);
                      						foreach($stmt as $row){
                        						$stmt2 = $conn->prepare("SELECT * FROM transdet WHERE transid=:transid");
                        						$stmt2->execute(['transid'=>$row['transid']]);
                        						$total = 0;
                        						foreach($stmt2 as $row2){
                          							$subtotal = $row2['price']*$row2['quantity'];
                          							$total += $subtotal;
                        						}
                        						echo "
                          							<tr>
                            							<td>".$no++."</td>
                            							<td>".date('M d, Y', strtotime($row['date']))."</td>
                            							<td>".$row['transid']."</td>
                            							<td>Ksh. ".number_format($total, 2)."</td>
														<td><button class='btn btn-sm btn-flat btn-info transact' data-id='".$row['transid']."'><i class='fa fa-search'></i> View</button></td>
                          							</tr>
                        						";
                      						}
      
					                    }
					                    catch(PDOException $e){
                    	  					echo "There is some problem in connection: " . $e->getMessage();
                    					}
      
                    					$pdo->close();
                  					?>
                  				</tbody>
                			</table>
              			</div><!-- /.card-body -->
            		</div>
            		<!-- /.card -->
          		</div>
          		<!-- /.col -->
        	</div>
        	<!-- /.row -->
      	</div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer bg-success">
    <strong style="color:black;">Copyright &copy; 2021 <a href="https://denvisbookshop.co.ke"  style="color: white;">Denvis Bookshop</a></strong>
    <div class="float-right d-none d-sm-inline-block">
      <b style="color:black;">All rights reserved</b>
    </div>
  </footer>
  <?php include 'includes/profile_modal.php'; ?>
</div>
<!-- ./wrapper -->
<script>
$(document).ready(function(){
  var firstName = $('#firstName').text();
  var lastName = $('#lastName').text();
  var intials = $('#firstName').text().charAt(0) + '' + $('#lastName').text().charAt(0);
  var profileImage = $('#profileImage').text(intials);
});
</script>
<!-- jQuery -->
<script src="./Admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./Admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./Admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./Admin/dist/js/demo.js"></script>
<script>
  $(function(){
    $(document).on('click', '.transact', function(e){
      e.preventDefault();
      $('#transaction').modal('show');
      var id = $(this).data('id');
      $.ajax({
        type: 'POST',
        url: 'transaction.php',
        data: {id:id},
        dataType: 'json',
        success:function(response){
          $('#date').html(response.date);
          $('#transid').html(response.transaction);
          $('#detail').prepend(response.list);
          $('#total').html(response.total);
        }
      });
    });
  
    $("#transaction").on("hidden.bs.modal", function () {
        $('.prepend_items').remove();
    });
  });
  </script>
  <script>
$(function(){
  $('#navbar-search-input').focus(function(){
    $('#searchBtn').show();
  });

  $('#navbar-search-input').focusout(function(){
    $('#searchBtn').hide();
  });

  getCart();

  $('#productForm').submit(function(e){
  	e.preventDefault();
  	var product = $(this).serialize();
  	$.ajax({
  		type: 'POST',
  		url: 'cart_add.php',
  		data: product,
  		dataType: 'json',
  		success: function(response){
  			$('#alert').show();
  			$('.message').html(response.message);
  			if(response.error){
  				$('#alert').removeClass('alert-success').addClass('alert-danger');
  			}
  			else{
				$('#alert').removeClass('alert-danger').addClass('alert-success');
				getCart();
  			}
  		}
  	});
  });

  $(document).on('click', '.close', function(){
  	$('#alert').hide();
  });

});

function getCart(){
	$.ajax({
		type: 'POST',
		url: 'cart_fetch.php',
		dataType: 'json',
		success: function(response){
			$('#cart_menu').html(response.list);
			$('.cart_count').html(response.count);
		}
	});
}
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
<script>
$("#ala").animate({ scrollTop: $('#ala').height()}, 1000);</script>
</body>
</html>
