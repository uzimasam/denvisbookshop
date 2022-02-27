<?php 
  include 'includes/session.php';
  include 'includes/format.php'; 
?>
<?php 
  $today = date('Y-m-d');
  $yesterday = date('Y-m-d',strtotime("-1 days"));
  $year = date('Y');
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }

  $conn = $pdo->open();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="refresh" content="100">

  <title>Denvis Bookshop | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
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
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
              <a href='sent' class="info-box-icon bg-info"><i class="far fa-envelope"></i></a>

              <div class="info-box-content">
                <span class="info-box-text">Unread Messages</span>
                <!--<?php $nowa = $admin['id']; ?>-->
                <?php
                    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM message WHERE status=0 and receiver_id=$nowa or receiver_id=0 and status=0");
                    $stmt->execute();
                    $urow =  $stmt->fetch();
                    echo "<span class='info-box-number'>".$urow['numrows']."</span>";
                ?>
                <div class="progress">
                  <div class="progress-bar bg-gradient-info" style="width: 70%"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
              <span class="info-box-icon bg-success"><i class="far fa-money-bill-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Sales Today</span>
                <?php
                    $stmt = $conn->prepare("SELECT * FROM transdet LEFT JOIN trans ON trans.transid=transdet.transid WHERE date=:sales_date");
                    $stmt->execute(['sales_date'=>$yesterday]);
                    $otal = 1;
                    foreach($stmt as $yrow){
                    $subtotal = $yrow['price']*$yrow['quantity'];
                    $otal += $subtotal;
                    }
                    $stmt = $conn->prepare("SELECT * FROM transdet LEFT JOIN trans ON trans.transid=transdet.transid WHERE date=:sales_date");
                    $stmt->execute(['sales_date'=>$today]);
                    $total = 0;
                    foreach($stmt as $trow){
                    $subtotal = $trow['price']*$trow['quantity'];
                    $total += $subtotal;
                    $per = $total/$otal*100;
                    }
                    echo "<span class='info-box-number'>Ksh. ".number_format_short($total, 2)."</span>";
                ?>
                <div class="progress">
                  <div class="progress-bar bg-gradient-success" style="width:<?php echo $per?>%"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
              <span class="info-box-icon bg-warning"><i class="fas fa-spinner fa-spin"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"> Orders processing</span>
                <?php
                  $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE orderstatus=3 OR orderstatus=2");
                  $stmt->execute();
                  $urow =  $stmt->fetch();

                  echo "<span class='info-box-number'>".$urow['numrows']."</span>";
                ?>
                <div class="progress">
                  <div class="progress-bar bg-gradient-warning" style="width: 70%"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
                <?php
                    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM allocations WHERE stock<minstock");
                    $stmt->execute();
                    $urow =  $stmt->fetch();
                    echo '<a href="allocationslow" class="info-box-icon bg-danger"><b>'.$urow['numrows'].'</b></a>';
                ?>
              <div class="info-box-content">
                <span class="info-box-text">Products</span>
                <span class="info-box-number">With Low Stock</span>
                <div class="progress">
                  <div class="progress-bar bg-gradient-danger" style="width: 70%"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <?php
                    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM trans");
                    $stmt->execute();
                    $urow =  $stmt->fetch();

                    echo "<h3>".$urow['numrows']."</h3>";
                ?>
                <p>Total Transactions</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a href="tra" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          
          <!-- ./col -->
          <div class="col-md-3 col-sm-6 col-12">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <?php
                    $stmt = $conn->prepare("SELECT * FROM transdet");
                    $stmt->execute();
                    $total = 0;
                    foreach($stmt as $srow){
                    $subtotal = $srow['price']*$srow['quantity'];
                    $total += $subtotal;
                    }
                    echo "<h3>Ksh. ".number_format_short($total, 2)."</h3>";
                ?>
                <p>Total Sales</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-line"></i>
              </div>
              <a href="tra" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-md-3 col-sm-6 col-12">
            <!-- small card -->
            <div class="small-box bg-warning">
              <div class="inner">
                <?php
                    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE orderstatus=:initiate");
                    $stmt->execute(['initiate'=>1]);
                    $stmt->execute();
                    $urow =  $stmt->fetch();

                    echo "<h3>".$urow['numrows']."</h3>";
                ?>
                <p>Orders Placed</p>
              </div>
              <div class="icon">
                <i class="fas fa-cart-plus"></i>
              </div>
              <a href="orders" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-md-3 col-sm-6 col-12">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
                <?php
                    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM products");
                    $stmt->execute();
                    $prow =  $stmt->fetch();
                    echo "<h3>".$prow['numrows']."</h3>";
                ?>
                <p>Products </p>
              </div>
              <div class="icon">
                <i class="fa fa-shopping-basket"></i>
              </div>
              <a href="data" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <?php
                    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM store");
                    $stmt->execute();
                    $urow =  $stmt->fetch();

                    echo "<h3>".$urow['numrows']."</h3>";
                ?>
                <p>Branches</p>
              </div>
              <div class="icon">
                <i class="fas fa-store-alt"></i>
              </div>
              <a href="branches" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-md-3 col-sm-6 col-12">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <?php
                    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE type=0");
                    $stmt->execute();
                    $urow =  $stmt->fetch();

                    echo "<h3>".$urow['numrows']."</h3>";
                ?>
                <p>Clients</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="clients" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-md-3 col-sm-6 col-12">
            <!-- small card -->
            <div class="small-box bg-warning">
              <div class="inner">
              <?php
                $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE created_on=:created_on AND type=0");
                $stmt->execute(['created_on'=>$today]);
                $stmt->execute();
                $urow =  $stmt->fetch();

                echo "<h3>".$urow['numrows']."</h3>";
              ?>
                <p>New Clients Today</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="clients" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-md-3 col-sm-6 col-12">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
              <?php
                $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE type=2 AND id!=1");
                $stmt->execute();
                $urow =  $stmt->fetch();

                echo "<h3>".$urow['numrows']."</h3>";
              ?>
                <p>Members Of Staff</p>
              </div>
              <div class="icon">
                <i class="fa fa-users-cog"></i>
              </div>
              <a href="./staff" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row" style="padding-bottom:15px;">
          <div class="col-sm-4"></div>
          <div class="col-sm-4">
          <div class="form-control shadow-lg bg-danger">
              <form style="padding-bottom:15px;">
                <label>Select Year To Generate Reports: </label>
                <select class="bg-danger input-sm" id="select_year">
                  <?php
                    for($i=2021; $i<=2065; $i++){
                      $selected = ($i==$year)?'selected':'';
                      echo "
                        <option value='".$i."' ".$selected.">".$i."</option>
                      ";
                    }
                  ?>
                </select>
              </form>
            </div>
            </div>
          <div class="col-sm-4"></div>
        </div>
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Overall Anual Sales for <?php echo $year?>
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <canvas id="myChart"></canvas>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
            

            <!-- Calendar -->
            <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">  
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">
            <div style="display: none;" id="sparkline-1"></div>

            <div style="display: none;" id="sparkline-2"></div>

            <div style="display: none;" id="sparkline-3"></div>
            <!-- /.card -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Sales Per Shop for <?php echo $year?>
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <canvas id="myChart1" ></canvas>
                  
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- visits chart -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-eye mr-1"></i>
                  Site Visits for <?php echo $year?>
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <canvas id="myChartv"></canvas>
              </div><!-- /.card-body -->
            </div>
          </section>
          <!-- right col -->
        </div>
        <a id="back-to-top" href="#" class="btn btn-success back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<?php
  $months = array();
  $sales = array();
  for( $m = 1; $m <= 12; $m++ ) {
    try{
      $stmt = $conn->prepare("SELECT * FROM transdet LEFT JOIN trans ON trans.transid=transdet.transid WHERE MONTH(date)=:month AND YEAR(date)=:year");
      $stmt->execute(['month'=>$m, 'year'=>$year]);
      $total = 0;
      foreach($stmt as $srow){
        $subtotal = $srow['price']*$srow['quantity'];
        $total += $subtotal;    
      }
      array_push($sales, round($total, 2));
    }
    catch(PDOException $e){
      echo $e->getMessage();
    }

    $num = str_pad( $m, 2, 0, STR_PAD_LEFT );
    $month =  date('M', mktime(0, 0, 0, $m, 1));
    array_push($months, $month);
  }

  $months = json_encode($months);
  $sales = json_encode($sales);

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo $months; ?>,
        datasets: [
          {
            label: 'TOTAL SALES',
            data: <?php echo $sales; ?>,
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
            ],
            borderWidth: 1
          },
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<?php
  $months = array();
  $visito = array();
  for( $m = 1; $m <= 12; $m++ ) {
    try{
      $stmt = $conn->prepare("SELECT * FROM visit WHERE MONTH(vd)=:month AND YEAR(vd)=:year");
      $stmt->execute(['month'=>$m, 'year'=>$year]);
      $total = 0;
      foreach($stmt as $srow){
        $subtotal = $srow['visits'];
        $total += $subtotal;    
      }
      array_push($visito, round($total, 2));
    }
    catch(PDOException $e){
      echo $e->getMessage();
    }

    $num = str_pad( $m, 2, 0, STR_PAD_LEFT );
    $month =  date('M', mktime(0, 0, 0, $m, 1));
    array_push($months, $month);
  }

  $months = json_encode($months);
  $visito = json_encode($visito);

?>
<script>
var ctx = document.getElementById('myChartv').getContext('2d');
var myChartv = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo $months; ?>,
        datasets: [
          {
            label: 'TOTAL VISITS',
            data: <?php echo $sales; ?>,
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
            ],
            borderWidth: 1
          },
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<?php 
  $shops = array();
  $sales = array();
  $stmt = $conn->prepare("SELECT * FROM store LIMIT 6");
  $stmt->execute();
  foreach($stmt as $srow){
    $catid = $srow['store_id'];
    $shop = $srow['store_name'];
    array_push($shops, $shop);
    
    try{
      $stmt = $conn->prepare("SELECT * FROM transdet LEFT JOIN trans ON trans.transid=transdet.transid WHERE YEAR(date)=:year AND store_id=$catid");
      $stmt->execute(['year'=>$year]);
      $totdal = 0;
      foreach($stmt as $srow){
        $subtotal = $srow['price']*$srow['quantity'];
        $totdal += $subtotal;    
      }
      array_push($sales, round($totdal, 2));
    }
    catch(PDOException $e){
      echo $e->getMessage();
    }
  }
  $sales = json_encode($sales);
  $shops = json_encode($shops);
?>
<script>
var ctx = document.getElementById('myChart1').getContext('2d');
var myChart1 = new Chart(ctx, {
    type: 'pie',
        data: {
            labels: <?php echo $shops?>,
            datasets: [{
                data: <?php echo $sales?>,
                backgroundColor: [
                  'rgba(255, 50, 50, 0.2)',
                  'rgba(50, 255, 255, 0.2)',
                  'rgba(50, 50, 255, 0.2)',
                  'rgba(255, 124,50, 0.2)',
                  'rgba(238, 130, 238, 0.2)',
                  'rgba(99, 255, 132, 0.2)',
                  'rgba(255, 50, 50, 0.2)',
                  'rgba(50, 255, 255, 0.2)',
                  'rgba(50, 50, 255, 0.2)',
                  'rgba(255, 124,50, 0.2)',
                  'rgba(238, 130, 238, 0.2)',
                  'rgba(99, 255, 132, 0.2)'
                ],
                borderColor: [
                  'rgba(255, 50, 50, 1)',
                  'rgba(50, 255, 255, 1)',
                  'rgba(50, 50, 255, 1)',
                  'rgba(255, 124, 50, 1)',
                  'rgba(238, 130, 238, 1)',
                  'rgba(99, 255, 132, 1)',
                  'rgba(255, 50, 50, 1)',
                  'rgba(50, 255, 255, 1)',
                  'rgba(50, 50, 255, 1)',
                  'rgba(255, 124, 50, 1)',
                  'rgba(238, 130, 238, 1)',
                  'rgba(99, 255, 132, 1)'
                ],
                hoverOffset: 40,
                borderWidth: 1
            }]
        }
        });
</script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script>
$(function(){
  $('#select_year').change(function(){
    window.location.href = 'home?year='+$(this).val();
  });
});
</script><script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>
