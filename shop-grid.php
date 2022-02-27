<?php include 'includes/session.php'; ?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ecommerce Bookshop">
    <meta name="keywords" content="Denvis Bookshop, Uzima Samuel, Zalego, stationery, vihiga, kenya">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#00A65A">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Denvis Bookshop | Shop</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <script type="text/javascript">
        var _smartsupp = _smartsupp || {};
        _smartsupp.key = '40a347f748de3a2abbfa56032636fb1f1e2f275b';
        window.smartsupp||(function(d) {
        var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
        s=d.getElementsByTagName('script')[0];c=d.createElement('script');
        c.type='text/javascript';c.charset='utf-8';c.async=true;
        c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
        })(document);
    </script>
</head>
<?php
  $where = '';
  if(isset($_GET['category'])){
    $catid = $_GET['category'];
    $where = 'WHERE category_id ='.$catid;
  }

?>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <h3 class="header-logo" style="color: black;"><b style="color:tomato;">Denvis</b>Bookshop</h3>

        <div class="humberger__menu__cart">
            <ul>
                <?php
                    if(isset($_SESSION['user'])){
                        $ui = $user['id'];
                        $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM message where status=0 and receiver_id=$ui");
                        $stmt->execute();
                        $urow =  $stmt->fetch();
                        if($urow['numrows'] > 0){
                        echo '
                            <li><a href="profile.php"><i class="fa fa-bell-o"></i> <span style="background-color:red;">'.$urow["numrows"].'</span></a></li>
                        ';
                        }
                    }
                ?>
                <li><a href="cart_view.php"><i class="fa fa-shopping-cart"></i> <span style="background-color:light-green;" class="cart_count"></span></a></li>
            </ul>
        </div>
            <nav class="humberger__menu__nav mobile-menu">
                <ul>
                    <?php
                        if(isset($_SESSION['user'])){
                            $image = (!empty($user['photo'])) ? 'images/'.$user['photo'] : 'images/profile.jpg';
                            echo '
                                <li><a href="profile.php" class="text-center">
                                    <img src="'.$image.'" style="height:60px; width:60px; border-radius: 50%;" alt="User Image">
                                </a></li>
                                <li style="color:black;"  class="text-center"><a>'.$user['firstname'].' '.$user['lastname'].'</a></li>
                                <li style="color:black;"  class="text-center"><a>Member since '.date('M. Y', strtotime($user['created_on'])).'</a></li>
                                <li><a href="./logout.php">Sign Out</a></li>
                            ';
                        }
                        else{
                            echo '
                            <li><a href="./login.php">Sign In</a></li>
                            <li><a href="./signup.php">Register</a></li>
                            ';
                        }
                    ?>
                    <li><a href="./">Home</a></li>
                    <li><a style="color:#00A65A;" href="./shop-grid.php">Shop</a></li>
                    <li><a href="./contactus.php">Contact</a></li>
                </ul>
            </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-whatsapp"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><a href="mailto:dennisluyali@gmail.com"><i class="fa fa-envelope"></i> info@denvisbookshop.co.ke</a></li>
                <li>Proud To Be Your Education Patner</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><a style="color: #ffffff;" href="mailto:dennisluyali@gmail.com"><i class="fa fa-envelope"></i> info@denvisbookshop.co.ke</a></li>
                                <li>Proud To Be Your Education Patner</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-whatsapp"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                            <div class="header__top__right__social">
								<?php
									if(isset($_SESSION['user'])){
									$image = (!empty($user['photo'])) ? 'images/'.$user['photo'] : 'images/profile.jpg';
									echo '
										<div class="header__top__right__language">
											<a href="profile.php">
												<img src="'.$image.'" style="height:25px; width:25px; border-radius: 50%;" alt="User Image">
												<span class="hidden-xs">'.$user['firstname'].' '.$user['lastname'].'</span>
											</a>
										</div>
										<div class="header__top__right__auth">
											<a style="color:white;"	>Member since '.date('M. Y', strtotime($user['created_on'])).'</a>
										</div>
									';
									}
									else{
									echo "
										<div class='header__top__right__language'>
											<a href='signup.php'><i class='fa fa-user'></i> Signup</a>
										</div>
										<div class='header__top__right__auth'>
											<a href='login.php'><i class='fa fa-user'></i> Login</a>
										</div>
										";
									}
								?>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <h3 class="header-logo" style="padding-top:25px; color: black;"><b style="color:tomato;">Denvis</b>Bookshop</h3>
                </div>
                <div class="col-lg-7">
                    <nav class="header__menu">
                        <ul>
                            <li><a style="font-size: 16px;" href="./">Home</a></li>
                            <li class="active"><a style="font-size: 16px;" href="./shop-grid.php">Shop</a></li>
                            <li><a style="font-size: 16px;" href="./contactus.php">Contact</a></li>
							<?php
								if(isset($_SESSION['user'])){
								$image = (!empty($user['photo'])) ? 'images/'.$user['photo'] : 'images/profile.jpg';
								echo '
									<li><a style="font-size: 16px;" href="profile.php">Profile</a></li>
									<li><a style="font-size: 16px;" href="logout.php">Signout</a></li>
								';
								}
							?>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-2">
                    <div class="header__cart">
                        <ul>
							<?php
								if(isset($_SESSION['user'])){
									$ui = $user['id'];
									$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM message where status=0 and receiver_id=$ui");
									$stmt->execute();
									$urow =  $stmt->fetch();
									if($urow['numrows'] > 0){
									echo '
										<li><a href="profile.php"><i class="fa fa-bell-o"></i> <span style="background-color:red;">'.$urow["numrows"].'</span></a></li>
									';
									}
								}
							?>
							<li><a href="cart_view.php"><i class="fa fa-shopping-cart"></i> <span style="background-color:light-green;" class="cart_count"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <section class="hero hero-normal">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>All Categories</span>
                        </div>
                        <ul id="trending">
                            <?php
                                $conn = $pdo->open();
                                try{
                                    $stmt = $conn->prepare("SELECT * FROM category ORDER BY name");
                                    $stmt->execute();
                                    foreach($stmt as $row){
                                        echo "
                                            <li><a href='category.php?category=".$row['name']."'>".$row['name']."</a></li>
                                        ";                  
                                    }
                                }
                                catch(PDOException $e){
                                    echo "There is some problem in connection: " . $e->getMessage();
                                }
                                $pdo->close();
                            ?>
						</ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
							<form method="POST" action="search.php">
                                <input type="text" name="keyword" placeholder="What do yo u need?">
                                <button type="submit" class="site-btn">SEARCH</button>
                            </form>
                        </div>
                        <a href="tel:+25471162548">
                            <div class="hero__search__phone">
                                <div class="hero__search__phone__icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="hero__search__phone__text">
                                    <h5>+25471162548</h5>
                                    <span>support 24/7 time</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Breadcrumb Section Begin -->
    <section id="sejt" class="breadcrumb-section set-bg" data-setbg="img/der.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text" style="background-color: rgba(102, 255, 153, 0.4); padding: 20px; text-align: center;">
                        <h2 style="color:black;"><span style="color:tomato;">Denvis</span> Bookshop</h2>
                        <div class="breadcrumb__option">
                            <a href="./">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>Most Viewed Today</h4>
                            <ul>
							<?php
								$now = date('Y-m-d');
								$conn = $pdo->open();
								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter DESC LIMIT 10");
								$stmt->execute(['now'=>$now]);
								foreach($stmt as $row){
									echo "<li><a href='shop-details.php?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
								}
								$pdo->close();
							?>
                            </ul>
                        </div>
                        <div class="sidebar__item">
                            <div class="latest-product__text">
                                <h4>Latest Products</h4>
                                <div class="latest-product__slider owl-carousel">
                                    <?php
                                        $conn = $pdo->open();
                                        try{
                                            $inc = 5;	
                                            $stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 20");
                                            $stmt->execute();
                                            foreach ($stmt as $row) {
                                                $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
                                                $inc = ($inc == 5) ? 1 : $inc + 1;
                                                if($inc == 1) echo "<div class='latest-prdouct__slider__item'>";
                                                echo "
                                                    <a href='shop-details.php?product=".$row['slug']."' class='latest-product__item'>
                                                        <div class='latest-product__item__pic'>
                                                            <img src='".$image."' style='width: 110px; height: 110px;'>
                                                        </div>
                                                        <div class='latest-product__item__text'>
                                                            <h6>".$row['name']."</h6>
                                                            <span>Ksh. ".number_format($row['price'], 2)."</span>
                                                        </div>
                                                    </a>
                                                ";
                                                if($inc == 5) echo "</div>";
                                            }
                                            if($inc == 1) echo "<div class='latest-prdouct__slider__item'></div><div class='latest-prdouct__slider__item'></div></div>"; 
                                            if($inc == 2) echo "<div class='latest-prdouct__slider__item'></div>";
                                        }
                                        catch(PDOException $e){
                                            echo "There is some problem in connection: " . $e->getMessage();
                                        }
                                        $pdo->close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="product__discount">
                        <div class="section-title product__discount__title">
                            <h2>This Month's Top Selling Items</h2>
                        </div>
                        <div class="row">
                            <div class="product__discount__slider owl-carousel">
                                <?php
                                    $month = date('m');
                                    $conn = $pdo->open();
                                    try{
                                        $inc = 3;	
                                        $stmt = $conn->prepare("SELECT *, SUM(quantity) AS total_qty FROM transdet LEFT JOIN trans ON trans.transid=transdet.transid LEFT JOIN products ON products.name=transdet.pname WHERE MONTH(date) = '$month' GROUP BY transdet.pname ORDER BY total_qty DESC LIMIT 10");
                                        $stmt->execute();
                                        foreach ($stmt as $row) {
                                            $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
                                            echo "
                                                <div class='col-lg-4'>
                                                    <div class='product__discount__item'>
                                                        <div class='product__discount__item__pic set-bg' data-setbg='".$image."'>
                                                        </div>
                                                        <div class='product__discount__item__text'>
                                                            <h5><a href='shop-details.php?product=".$row['slug']."'>".$row['name']."</a></h5>
                                                            <div class='product__item__price'>Ksh. ".number_format($row['price'], 2)."</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                                        }
                                    }
                                    catch(PDOException $e){
                                        echo "There is some problem in connection: " . $e->getMessage();
                                    }
                                    $pdo->close();
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="filter__item" id="alab">
                        <div class="section-title product__discount__title">
                            <h2>All Products</h2>
                        </div>
                        
                        <div class="filter__found">
                            <?php
                                $conn = $pdo->open();
                                $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM products");
                                $stmt->execute();
                                $row = $stmt->fetch();
                                $pro = $row['numrows'];
                            ?>
                            <h6 style="color: green;"><span><?php echo $pro?></span> Products found</h6>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                            $conn = $pdo->open();
							try{
                                if (isset($_GET['page_no']) && $_GET['page_no']!="") {
                                    $page_no = $_GET['page_no'];
                                    } else {
                                        $page_no = 1;
                                        }

                                    $total_records_per_page = 6;
                                    $offset = ($page_no-1) * $total_records_per_page;
                                    $previous_page = $page_no - 1;
                                    $next_page = $page_no + 1;
                                    $adjacents = "2"; 

                                    $conn = $pdo->open();
                                    $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM products");
                                    $stmt->execute();
                                    $row = $stmt->fetch();
                                    $total_records = $row['numrows'];
                                    $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                    $second_last = $total_no_of_pages - 1; // total page minus 1

                                    $stmt = $conn->prepare("SELECT * FROM products ORDER BY name DESC LIMIT $offset, $total_records_per_page");
								    $stmt->execute();
                                    foreach ($stmt as $row) {
                                        $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
                                        echo "
                                            <div class='col-lg-4 col-md-6 col-sm-6'>
                                                <div class='product__item'>
                                                    <div class='product__item__pic set-bg' data-setbg='".$image."'>
                                                    </div>
                                                    <div class='product__item__text'>
                                                        <h6><a href='shop-details.php?product=".$row['slug']."'>".$row['name']."</a></h6>
                                                        <h5>Ksh. ".number_format($row['price'], 2)."</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                    }
                            }
                            catch(PDOException $e){
                                echo "There is some problem in connection: " . $e->getMessage();
                            }
                            $pdo->close();
                        ?>
                    </div>
                    <div class="product__pagination text-center">
	                    <?php if($page_no > 1){ echo "<a href='?page_no=1#alab'><i class='fa fa-angle-double-left'></i></a>"; } ?>
	                    <a <?php if($page_no <= 1){ echo "class='disabled'"; } ?> <?php if($page_no > 1){ echo "href='?page_no=$previous_page#alab'"; } ?>><i class="fa fa-long-arrow-left"></i></a>
                        <?php 
                            if ($total_no_of_pages <= 10){  	 
                                for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                                    if ($counter == $page_no) {
                                        echo "<a class='active'>$counter</a>";	
                                    }
                                    else{
                                        echo "<a href='?page_no=$counter#alab'>$counter</a>";
                                    }
                                }
                            }
                            elseif($total_no_of_pages > 10){
                                if($page_no <= 4) {			
                                    for ($counter = 1; $counter < 8; $counter++){		 
                                        if ($counter == $page_no) {
                                            echo "<a class='active'>$counter</a>";	
                                        }
                                        else{
                                        echo "<a href='?page_no=$counter#alab'>$counter</a>";
                                        }
                                    }
                                    echo "<a>...</a>";
                                    echo "<a href='?page_no=$second_last#alab'>$second_last</a>";
                                    echo "<a href='?page_no=$total_no_of_pages#alab'>$total_no_of_pages</a>";
                                }
    	                        elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
                                    echo "<a href='?page_no=1#alab'>1</a>";
                                    echo "<a href='?page_no=2#alab'>2</a>";
                                    echo "<a>...</a>";
                                    for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
                                        if ($counter == $page_no) {
                                            echo "<a class='active'>$counter</a>";	
                                        }
                                        else{
                                            echo "<a href='?page_no=$counter#alab'>$counter</a>";
                                        }                  
                                    }
                                    echo "<a>...</a>";
                                    echo "<a href='?page_no=$second_last#alab'>$second_last</a>";
                                    echo "<a href='?page_no=$total_no_of_pages#alab'>$total_no_of_pages</a>";      
                                }
                                else {
                                    echo "<a href='?page_no=1#alab'>1</a>";
                                    echo "<a href='?page_no=2#alab'>2</a>";
                                    echo "<a>...</a>";
                                    for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                        if ($counter == $page_no) {
                                            echo "<a class='active'>$counter</a>";	
                                        }
                                        else{
                                            echo "<a href='?page_no=$counter#alab'>$counter</a>";
                                        }                   
                                    }
                                }
                            }
                        ?>
                    	<a <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?> <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page#alab'"; } ?>><i class='fa fa-long-arrow-right'></i></a>
                        <?php   
                            if($page_no < $total_no_of_pages){
                                echo "<a href='?page_no=$total_no_of_pages#alab'><i class='fa fa-angle-double-right'></i></a>";
                            } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
	<?php include 'includes/scripts.php'; ?>
    <!-- Footer Section Begin -->
    <footer>
        <div class="footer text-center">
            <p style="color: black;"><b>&copy;<script>document.write(new Date().getFullYear());</script>  | <a style="color: white;" href="https://muse.co.ke" target="_blank">The Muse</a>  |  All rights reserved</b></p>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>



</body>

</html>