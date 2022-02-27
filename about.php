<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-green layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	<div class="content-wrapper">
	    <div class="container">
	        <!-- Main content -->
	        <section class="content">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="breadcrumb-wrap">
                            <div class="container-fluid">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active"><a href="#" style="color:green;">About Us</a></li>
                                    <li class="breadcrumb-item"><a href="#blog">Blog</a></li>
                                    <li class="breadcrumb-item"><a href="#team">Management Team</a></li>
                                    <li class="breadcrumb-item"><a href="#projects">Projects</a></li>
                                    <li class="breadcrumb-item"><a href="#testimony">Testimonials</a></li>
                                </ul>
                            </div>
                        </div>

                        <?php
                            if(isset($_SESSION['error'])){
                                echo "
                                    <div class='alert alert-danger'>
                                        ".$_SESSION['error']."
                                    </div>
                                ";
                                unset($_SESSION['error']);
                            }
                        ?>
                            
                        <div class="box box-solid" id="blog">  
                            <div class="box-body">
                        
                            </div>
                        </div>
                            
                        <div class=" box box-solid row" id="team">
                            <div class="box-header with-border" >
                                <h3 class="box-title" style="text-align:center;"><b>Meet our team</b></h3>
                            </div>
                            <div>
                                <?php
                                    $conn = $pdo->open();
                                    try{
                                        $inc = 3;	
                                        $stmt = $conn->prepare("SELECT * FROM team");
                                        $stmt->execute();
                                        foreach ($stmt as $row) {
                                            $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
                                            $inc = ($inc == 3) ? 1 : $inc + 1;
                                            if($inc == 1) echo "<div class='row'>";
                                            echo "
                                                <div class='col-sm-4'>
                                                    <div class='box box-solid'>
                                                        <div class='box-body prod-body'>
                                                            <img src='".$image."' width='100%' height='230px' class='thumbnail'>
                                                            <h5><a href='teamview.php?team=".$row['email']."'>".$row['name']."</a></h5>
                                                        </div>
                                                        <div class='box-footer'>
                                                            <b>".$row['rank']."</b>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                            if($inc == 3) echo "</div>";
                                        }
                                        if($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>"; 
                                        if($inc == 2) echo "<div class='col-sm-4'></div></div>";
                                    }
                                    catch(PDOException $e){
                                        echo "There is some problem in connection: " . $e->getMessage();
                                    }
                                    $pdo->close();
                                ?> 
                            </div>
                        </div>
                        
                        <div class="box box-solid" id="projects">
                            <div class="box-header with-border">
                                <h3 class="box-title" style="text-align:center;"><b>We value giving back to the community</b></h3>
                            </div>
                            <div class="box-body">
                                
                            </div>
                        </div>
                        
                        <div class="box box-solid" id="testimony">
                            <div class="box-header with-border">
                                <h3 class="box-title" style="text-align:center;"><b>This is what they have to say about us</b></h3>
                            </div>
                            <div class="box-body">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <?php include 'includes/sidebar.php'; ?>
                    </div>
                </div>
            </section>
	    </div>
	</div>
  
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>