<!-- Placing History -->

<div class="modal fade" id="placing">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&nbsp;&nbsp;&times;</span></button>
              <h4 class="modal-title"><b>Placing Order...  </b> <b class="pull-right"><span style="color:tomato;">Denvis</span> Bookshop</b></h4>
            </div>
            <div class="modal-body">
              <p>
                Date: <span id="date"><?php echo $now?></span>
              </p>
              <p>HELLO <b><span>
              <?php
	        			if(isset($_SESSION['user'])){
	        				echo $user['firstname'];
	        			}
	        			else{
	        				echo "
	        					<h4>You need to <a href='login.php'>Login</a> to checkout.</h4>
	        				";
	        			}
	        		?>!
              <?php
                $conn = $pdo->open();
                $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
                $stmt->execute(['id'=>2]);
                $row = $stmt->fetch();
                $Staffname = $row['firstname'];
                $Staffnumber = $row['contact_info'];
              ?>
              </span></b></p>
              <p>After proceeding with the order, you will recieve a call within ten minutes from <b><span style="color:green"><?php echo $Staffname ?></span></b>, phone number, <b><span style="color:tomato"><?php echo $Staffnumber ?></span></b> so as to countercheck your order and confirm order dispatchment details.</p>
              <p>You will then check your website notifications (<i class="fa fa-bell-o"></i>) for further payment details</p>
              <p class="text-info"><span class="text-danger">NOTE</span> Do not empty you cart before you receive the call</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <form method="POST" action="orders.php">
              <input type="hidden" name="id" value="<?php echo $user['id']?>">
                <button type="submit" name="add" class="btn btn-success btn-flat pull-right"><i class="fa fa-check"></i> Proceed</button>
              </form>
            </div>
        </div>
    </div>
</div>
