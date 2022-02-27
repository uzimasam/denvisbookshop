<?php include 'includes/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Denvis Bookshop | Staff</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="./plugins/select2/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
              <h1>Staff</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./home.php">Home</a></li>
              <li class="breadcrumb-item active">Staff</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        $conn = $pdo->open();

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
      <div class="container-fluid">
        <div class="card">
          <div class="card-header bg-success">
            <i class="fa fa-user-cog"></i> Customer Care Cresentials
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <form action="mmm.php" method="POST">
                <div class="row">
                    <?php 
                        $stmt = $conn->prepare("SELECT * FROM users WHERE type=7");
                        $stmt->execute();
                        $urow =  $stmt->fetch();
                    ?>
                    <div class="col-md-10 offset-md-1">
                        <div class="form-group">
                          <label>Full Name:</label>                                  
                          <input type="text" class="form-control form-control-lg" placeholder="Customer Care's Name Here..." value="<?php echo $urow['firstname']?>" name="firstname">
                        </div>
                        <div class="row">
                          <div class="col-6">
                              <div class="form-group">
                                  <label>Phone No:</label>                                  
                                  <input type="text" class="form-control form-control-lg" placeholder="Customer Care's Phone Number Here..." value="<?php echo $urow['contact_info']?>" name="contact">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                  <label>M-Pesa Paybill No:</label>
                                  <input type="text" class="form-control float-right form-control-lg" placeholder="M-Pesa Pay-Bill Number Here..." value="<?php echo $urow['orderid']?>" name="orderid">
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
          </div>
          <div class="card-footer">
            <button type="submit" name="sab" class="float-right btn btn-flat btn-large btn-info"><i class="fa fa-save"></i> Update</button>
          </div>
          </form>
        </div>
        <hr>
        <div class="card bg-light">
          <div class="card-header bg-success">
            <i class="fa fa-user-tie"></i>
            <?php 
                $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE type=1 AND id!=1");
                $stmt->execute();
                $urow =  $stmt->fetch();

                echo $urow['numrows'];
            ?>
             Adminstrators
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="maximize">
                <i class="fas fa-expand"></i>
              </button>
            </div>
          </div>
          <div class="card-body row" style='margin:5px;'>
            <?php
                $conn = $pdo->open();

                try{
                    $stmt = $conn->prepare("SELECT * FROM users WHERE type=1 AND id!=1");
                    $stmt->execute();
                    foreach($stmt as $row){
                        $loci = (!empty($row['address'])) ? $row['address'] : 'N/A';
                        $phon = (!empty($row['contact_info'])) ? $row['contact_info'] : 'N/A';
                        $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                        $status = ($row['status']) ? '<span class="badge badge-success">active</span>': '<span class="badge badge-danger">Blocked</span>';
                        $active = (!$row['status']) ? '<span class="float-right"><a href="#activate" class="status" data-toggle="modal" data-id="'.$row['id'].'"><i class="far fa-check-circle"></i></a></span>' : '<span class="float-right"><a href="#deactivate" class="status" data-toggle="modal" data-id="'.$row['id'].'"><i class="fa fa-gavel"></i></a></span>';
                        echo "
                            <div class='col-sm-6 col-md-4'>
                                <div class='card card-outline shadow-lg card-primary'>
                                    <div class='card-body box-profile'>
                                        <div class='text-center text-danger'>
                                            <img style='height:80px; width:80px;' class='profile-user-img profile-user-img-success img-fluid img-circle'
                                                src='".$image."'
                                                alt='User profile picture'>
                                        </div>
                                        <h3 class='profile-username text-center'>".$row['firstname'].' '.$row['lastname']."</h3>
                                        <p class='text-muted text-center'>".$row['email']."</p>
                                        <p class='text-center'>
                                        <a data-id='".$row['id']."' class='edit'><i class='fas fa-pencil-alt float-left'></i></a>
                                        <span>".$status."</span>
                                            <span>".$active."</span>
                                        </p>
                                        <ul class='list-group list-group-unbordered mb-3'>
                                            <li class='list-group-item'>
                                                <b>Phone No:</b> <a class='float-right'>".$phon."</a>
                                            </li>
                                            <li class='list-group-item'>
                                                <b>Location:</b> <a class='float-right'>".$loci."</a>
                                            </li>
                                            <li class='list-group-item'>
                                                <a href='message.php?user=".$row['id']."' class='btn btn-success  btn-block'><b><i class='fa fa-comment-dots'></i> Message</b></a>
                                            </li>
                                        </ul>
                                        <button href='#' class='btn btn-danger remove btn-block' data-id='".$row['id']."'><b><i class='fa fa-trash'></i> Remove</b></button>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        ";
                    }
                }
                catch(PDOException $e){
                echo $e->getMessage();
                }

                $pdo->close();
           ?>
          </div>
          <div class="card-footer">
            <button type="submit" class="float-right addadmin btn btn-flat btn-large btn-info">
              <i class="fa fa-user-plus"></i> Add Admin
            </button>
          </div>
        </div>
        <hr>
        <div class="card bg-light">
          <div class="card-header bg-success">
            <i class="fa fa-user-cog"></i>
            <?php 
                $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE type=2");
                $stmt->execute();
                $urow =  $stmt->fetch();

                echo $urow['numrows'];
            ?>
            Staff
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="maximize">
                <i class="fas fa-expand"></i>
              </button>
            </div>
          </div>
          <div class="card-body row" style='margin:5px;'>
            <?php
                $conn = $pdo->open();

                try{
                    $stmt = $conn->prepare("SELECT * FROM users LEFT JOIN store ON store.manager_id=users.id WHERE type=2 ORDER BY store_name");
                    $stmt->execute();
                    foreach($stmt as $row){
                        $loci = (!empty($row['address'])) ? $row['address'] : 'N/A';
                        $phon = (!empty($row['contact_info'])) ? $row['contact_info'] : 'N/A';
                        $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                        $status = ($row['status']) ? '<span class="badge badge-success">active</span>': '<span class="badge badge-danger">Blocked</span>';
                        $active = (!$row['status']) ? '<span class="float-right"><a href="#activate" class="status" data-toggle="modal" data-id="'.$row['id'].'"><i class="far fa-check-circle"></i></a></span>' : '<span class="float-right"><a href="#deactivate" class="status" data-toggle="modal" data-id="'.$row['id'].'"><i class="fa fa-gavel"></i></a></span>';
                        echo "
                            <div class='col-sm-6 col-md-4'>
                                <div class='card card-outline shadow-lg card-primary'>
                                    <div class='card-body box-profile'>
                                        <div class='text-center text-danger'>
                                            <img style='height:80px; width:80px;' class='profile-user-img profile-user-img-success img-fluid img-circle'
                                                src='".$image."'
                                                alt='User profile picture'>
                                        </div>
                                        <h3 class='profile-username text-center'>".$row['firstname'].' '.$row['lastname']."</h3>
                                        <p class='text-muted text-center'>".$row['email']."</p>
                                        <p class='text-center'>
                                            <a data-id='".$row['id']."' class='edit'><i class='fas fa-pencil-alt float-left'></i></a>
                                            <span>".$status."</span>
                                            <span>".$active."</span>
                                        </p>
                                        <ul class='list-group list-group-unbordered mb-3'>
                                            <li class='list-group-item'>
                                                <b>Phone No:</b> <a class='float-right'>".$phon."</a>
                                            </li>
                                            <li class='list-group-item'>
                                                <b>Location:</b> <a class='float-right'>".$loci."</a>
                                            </li>
                                            <li class='list-group-item'>
                                              <b>Branch:</b> <a class='float-right'>".$row['store_name']."</a>
                                            </li>
                                            <li class='list-group-item'>
                                                <a href='message.php?user=".$row['id']."' class='btn btn-success  btn-block'><b><i class='fa fa-comment-dots'></i> Message</b></a>
                                            </li>
                                        </ul>
                                        <button href='#' data-id='".$row['id']."' class='btn remove btn-danger btn-block'><b><i class='fa fa-trash'></i> Remove</b></button>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        ";
                    }
                }
                catch(PDOException $e){
                echo $e->getMessage();
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
    <a id="back-to-top" href="#" class="btn btn-success back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
<!-- jQuery --><?php include 'includes/users_modal.php'; ?>
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="./plugins/select2/js/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>
<script>
    $(function () {
      $('.select2').select2()
    });
</script>
<script>
$(function(){

  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.addadmin', function(e){
    e.preventDefault();
    $('#addadmin').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.remove', function(e){
    e.preventDefault();
    $('#remove').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.photo', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.status', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'users_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.userid').val(response.id);
      $('#edit_email').val(response.email);
      $('#edit_password').val(response.password);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#edit_address').val(response.address);
      $('#edit_contact').val(response.contact_info);
      $('.fullname').html(response.firstname+' '+response.lastname);
    }
  });
}
</script>
</body>
</html>
