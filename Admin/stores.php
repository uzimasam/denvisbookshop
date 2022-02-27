<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/format.php'; ?>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product List
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Products</li>
        <li class="active">Product List</li>
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
            <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat" id="addproduct"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Branch Name</th>
                  <th>Branch Photo</th>
                  <th>Manager</th>
                  <th>Photo</th>
                  <th>Since</th>
                  <th>Total Sales</th>
                  <th>Low Stock Products</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();
                    
    
                    try{
                        $total = 0;
                        $stmt = $conn->prepare("SELECT * FROM store LEFT JOIN users ON users.id=store.manager_id");
                        $stmt->execute();
                        foreach($stmt as $row){
                            $stid = $row['store_id'];
                            $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM allocations WHERE stock<minstock AND storeid=$stid");
                            $stmt->execute();
                            $prow =  $stmt->fetch();
                            $stmt = $conn->prepare("SELECT * FROM transdet LEFT JOIN trans ON trans.transid=transdet.transid WHERE store_id=$stid");
                            $stmt->execute();
                            $total = 0;
                            foreach($stmt as $srow){
                            $subtotal = $srow['price']*$srow['quantity'];
                            $total += $subtotal;
                            }
                            $image = (!empty($row['storephoto'])) ? '../images/'.$row['storephoto'] : '../images/banner.png';
                            $imag = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                            echo "
                          <tr>
                            <td>".$row['store_name']."</td>
                            <td>
                              <img src='".$image."' height='30px' width='150px'>
                            </td>
                            <td>".$row['firstname'].' '.$row['lastname']."</td>
                            <td>
                                <img src='".$imag."' height='30px' width='30px'>
                            </td>
                            <td>".$row['established']."</td>
                            <td>".number_format_short($total, 2)."</td>
                            <td>".$prow['numrows']."</td>
                            <td>
                              <button class='btn btn-info btn-sm btn-flat' data-id='".$row['id']."'><i class='fa fa-eye'></i> Visit</button>
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
          </div>
        </div>
      </div>
    </section>
     
  </div>
  	<?php include 'includes/footer.php'; ?>
    <?php include 'includes/products_modal.php'; ?>
    <?php include 'includes/products_modal2.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.photo', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.stock', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.desc', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

  $('#addproduct').click(function(e){
    e.preventDefault();
    getCategory();
  });

  $("#addnew").on("hidden.bs.modal", function () {
      $('.append_items').remove();
  });

  $("#edit").on("hidden.bs.modal", function () {
      $('.append_items').remove();
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'products_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#desc').html(response.description);
      $('.name').html(response.prodname);
      $('.prodid').val(response.prodid);
      $('#edit_name').val(response.prodname);
      $('#edit_price').val(response.price);
      $('#edit_barcode').val(response.barcode);
      $('#edit_stock').val(response.stock);
      CKEDITOR.instances["editor2"].setData(response.description);
      getCategory();
    }
  });
}
function getCategory(){
  $.ajax({
    type: 'POST',
    url: 'category_fetch.php',
    dataType: 'json',
    success:function(response){
      $('#category').append(response);
      $('#edit_category').append(response);
    }
  });
}
</script>
</body>
</html>

