<div class="row">
	<div class="box box-success">
	  	<div class="box-header with-border">
	    	<h3 class="box-title"><b>Most Viewed Today</b></h3>
	  	</div>
	  	<div class="box-body">
	  		<ul id="trending">
	  		<?php
	  			$now = date('Y-m-d');
	  			$conn = $pdo->open();

	  			$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter DESC LIMIT 10");
	  			$stmt->execute(['now'=>$now]);
	  			foreach($stmt as $row){
	  				echo "<li><a href='product.php?product=".$row['slug']."'>".$row['name']."</a></li>";
	  			}

	  			$pdo->close();
	  		?>
	    	<ul>
	  	</div>
	</div>
</div>

<!--<div class="row">
	<div class="box box-solid">
	  	<div class="box-header with-border">
	    	<h3 class="box-title"><b>Become a Subscriber</b></h3>
	  	</div>
	  	<div class="box-body">
	    	<p>Get free updates on the latest products and discounts, straight to your inbox.</p>
	    	<form method="POST" action="">
		    	<div class="input-group">
	                <input type="text" class="form-control">
	                <span class="input-group-btn">
	                    <button type="button" class="btn btn-success btn-flat"><i class="fa fa-envelope"></i> </button>
	                </span>
	            </div>
		    </form>
	  	</div>
	</div>
</div>-->

<div class="row">
	<div class="box box-danger">
	  	<div class="box-header with-border">
	    	<h3 class="box-title"><b><i class="fa fa-download"></i> Downloads And Printouts</b></h3>
	  	</div>
	  	<div class="box-body row">
			<a href="downloads/CONFIDENCE.docx" class="btn btn-success btn-flat" style="margin:10px; width:90%;"><i class="fa fa-calendar"></i> Calendar</a>
			<a class="btn btn-flat btn-success" style="margin:10px; width:90%;"><i class="fa fa-newspaper-o"></i> Business Card</a>
			<a class="btn btn-flat btn-success" style="margin:10px; width:90%;"><i class="fa fa-list-alt"></i> Price List</a>
			<a class="btn btn-flat btn-success" style="margin:10px; width:90%;"><i class="fa fa-list-alt"></i> Orange Book</a>
	  	</div>
	</div>
</div>

<div class="row">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title"><b>Contact us now</b></h3>
		</div>
		<div class="box-body">
			<a class="btn btn-flat btn-success" style="width:100%;" href="tel:+254711626548"><i class="fa fa-phone"></i>  +254768415577</a>
		</div>
	</div>
</div>

<div class="row">
	<div class='box box-danger'>
	  	<div class='box-header with-border'>
	    	<h3 class='box-title'><b>Follow us on Social Media</b></h3>
	  	</div>
	  	<div class='box-body'>
	    	<a style="margin-left: 30px; border-radius:5px;" class="btn btn-success btn-flat"><i class="fa fa-facebook"></i></a>
	    	<a style="margin-left: 30px; border-radius:5px;" class="btn btn-success btn-flat"><i class="fa fa-twitter"></i></a>
	    	<a style="margin-left: 30px; border-radius:5px;" class="btn btn-success btn-flat"><i class="fa fa-instagram"></i></a>
	  	</div>
	</div>
</div>


