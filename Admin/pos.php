<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<body class="hold-transition skin-green sidebar-mini">
  <div class="wrapper">
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php';
    date_default_timezone_set('Africa/Nairobi');  ?>
    <?php
      if(!isset($_GET['user'])){
        header('location: orders.php');
        exit();
      }
      else{
        $conn = $pdo->open();
        $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(['id'=>$_GET['user']]);
        $user = $stmt->fetch();
        $pdo->close();
      }
      $conn = $pdo->open();
      $usid = $user['id'];
      $stmt = $conn->prepare("SELECT * FROM sales_order where usid=:usid");
      $stmt->execute(['usid'=>$usid]);
      $total = 0;
      foreach($stmt as $srow){
        $subtotal = $srow['price']*$srow['qty'];
        $total += $subtotal;    
      }
      $pdo->close();
    ?>  
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          Point Of Sale
        </h1>
        <ol class="breadcrumb">
          <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Point Of Sale</li>
        </ol>
      </section>
      <section class="content container-fluid">
        <div class="box box-success">
          <form action="pay.php" method="POST">
            <div class="row box-body">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Operator's Name</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <input type="hidden" name="usid" value="<?php echo $usid?>">
                    <input type="text" class="form-control pull-right" name="cashier_name" value="<?php echo $admin['firstname'].' '.$admin['lastname']; ?>" readonly>
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Transaction Date</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="orderdate" value="<?php echo date("d-m-Y");?>" readonly
                    data-date-format="yyyy-mm-dd">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Transaction Time</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="timeorder" value="<?php echo date('h:i:s A') ?>" readonly>
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
            </div>
            <div class="box-body row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="category">Payment Method</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <select class="form-control" name="met" required placeholder="Select..">
                      <option>M-PESA</option>
                      <option>Cash</option>
                      <option>Bank Cheque</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="category">Transaction Code</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-qrcode"></i>
                    </div>
                    <input type="text" class="form-control" name="tcode" value="#####" placeholder="Enter Code">
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
            </div>
            <div class="box-body">
              <div class="col-md-offset-1 col-md-10">
                <div class="form-group">
                  <label>Order Total</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span>Ksh</span>
                    </div>
                    <input type="text" class="form-control pull-right sub" value="<?php echo $total ?>" name="total" id="total" required readonly>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Amount Paid</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span>Ksh</span>
                    </div>
                    <input type="number" oninput="calculate();" step="5" min="10" class="form-control pull-right sub" name="paid" id="paid" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Balance Due </label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <span>Ksh</span>
                    </div>
                    <input type="text" class="form-control pull-right" name="due" id="answere" required readonly>
                  <!-- /.input group -->
                </div>
              </div>
            </div>
            <div class="box-footer" align="center">
              <button type="submit" name="add" class="btn btn-success">Confirm Payment</button>
            </div>
          </form>
        </div>
      </section>
    </div>
    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/products_modal.php'; ?>
    <?php include 'includes/products_modal2.php'; ?>
  </div>
  <?php include 'includes/scripts.php'; ?>
  <script>
    function calculate(){
      var totalValue = document.getElementById('total').value;
      var paidValue = document.getElementById('paid').value;
      var answere = parseInt(totalValue) - parseInt(paidValue);
      document.getElementById('answere').value = answere;    
    }
  </script>
</body>
</html>