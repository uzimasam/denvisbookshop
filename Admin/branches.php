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
  <title>Denvis Bookshop | Branches</title>
  <link rel="stylesheet" href="./plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="./plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

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
  <style> 
#myDIV {
  width: 100%;
  height: 150px;
  background: teal url('smiley.gif') no-repeat top left/5px 5px;
  animation: mymove 5s infinite;
}

@keyframes mymove {
  50% {background: seagreen bottom right/50px 50px;}
}
</style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
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
        <div class="row mb-2">
          <div class="col-sm-5">
                <?php
                    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM store");
                    $stmt->execute();
                    $urow =  $stmt->fetch();

                    echo "<h1>".$urow['numrows']." Branches</h1>";
                ?>
          </div>
          <div class="col-sm-2">
          <a href="#add" data-toggle="modal" class="btn btn-flat btn-block btn-success"><i class="fa fa-store"> </i>  New Branch</a>
          </div>
          <div class="col-sm-5">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./home.php">Home</a></li>
              <li class="breadcrumb-item active">Branches</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- =========================================================== -->
            <div class='row'>
                <?php
                    $stmt = $conn->prepare("SELECT * FROM store LEFT JOIN users ON users.id=store.manager_id");
                    $stmt->execute();
                    foreach ($stmt as $row) {
                        $sed =  (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                        $store = $row['store_id'];
                        $stmt = $conn->prepare("SELECT * FROM transdet LEFT JOIN trans ON trans.transid=transdet.transid WHERE date=:sales_date AND store_id=$store");
                        $stmt->execute(['sales_date'=>$today]);
                        $total = 0;
                        foreach($stmt as $trow){
                        $subtotal = $trow['price']*$trow['quantity'];
                        $total += $subtotal;
                        }
                        echo "
                            <!-- /.col -->
                            <div class='col-md-4'>
                                <!-- Widget: user widget style 1 -->
                                <div class='card card-widget widget-user shadow-lg'>
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class='widget-user-header text-white' id='myDIV'>
                                    <h3 class='widget-user-username text-right'>".$row['store_name']."</h3>
                                    <p class='text-warning widget-user text-right'>".$row['stomail']."</p>
                                    <h5 class='widget-user-desc text-right'>".$row['firstname']."</h5>
                                </div>
                                <div class='widget-user-image'>
                                    <img class='img-circle' src='$sed' style='width:100px; height:100px;' alt='User Avatar'>
                                </div>
                                <div class='card-footer'>
                                    <div class='row'>
                                    <div class='col-sm-4 border-right'>
                                        <div class='description-block'>
                                        <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['store_id']."'><i class='fa fa-edit'></i> Edit</button>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class='col-sm-4 border-right'>
                                        <div class='description-block'>
                                        <h5 class='description-header'>Ksh. ".number_format_short($total, 2)."</h5>
                                        <span class='description-text'>Sales Today</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class='col-sm-4'>
                                        <div class='description-block'>
                                        <a class='btn btn-sm btn-flat btn-success' href='manager.php?bid=".$row['store_id']."'>VISIT</a>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                </div>
                                <!-- /.widget-user -->
                            </div>
                            <!-- /.col -->
                        ";
                    }
                ?>
            </div>
            <div class="row">
                <canvas id="myChart"></canvas>
            </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-success back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<?php include 'includes/users_modal.php'; ?>
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
<?php
  $months = array();
  $mauzo = array();
  for( $m = 1; $m <= 12; $m++ ) {
    try{
      $stmt = $conn->prepare("SELECT * FROM transdet LEFT JOIN trans ON trans.transid=transdet.transid WHERE MONTH(date)=:month AND YEAR(date)=:year AND store_id=1");
      $stmt->execute(['month'=>$m, 'year'=>$year]);
      $total = 0;
      foreach($stmt as $srow){
        $subtotal = $srow['price']*$srow['quantity'];
        $total += $subtotal;    
      }
      array_push($mauzo, round($total, 2));
    }
    catch(PDOException $e){
      echo $e->getMessage();
    }

    $num = str_pad( $m, 2, 0, STR_PAD_LEFT );
    $month =  date('M', mktime(0, 0, 0, $m, 1));
    array_push($months, $month);
  }

  $months = json_encode($months);
  $mauzo = json_encode($mauzo);

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }
  // DropzoneJS Demo Code End
</script>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo $months; ?>,
        datasets: [
          {
            label: 'OVERALL SALES',
            data: <?php echo $sales; ?>,
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
            ],
            borderWidth: 1
          },
          {
            label: '<?php echo strtoupper($sat['store_name'])?> SALES',
            data: <?php echo $mauzo; ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
            ],
            borderWidth: 1
          }
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
<script src="./plugins/select2/js/select2.full.min.js"></script>
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>

<script>
$(function(){

  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#editb').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'branch_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.userid').val(response.id);
      $('.stomail').val(response.email);
      $('.password').val(response.password);
      $('.stoid').val(response.store_id);
      $('.maid').val(response.manager_id);
      $('.stname').val(response.store_name);
    }
  });
}
</script>
</body>
</html>
