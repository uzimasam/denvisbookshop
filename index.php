<?php include 'includes/session.php';
date_default_timezone_set('Africa/Nairobi');?>
<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ecommerce Bookshop">
    <meta name="keywords" content="Denvis Bookshop, Uzima Samuel, Zalego, stationery, vihiga, kenya">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#00A65A">
    <title>Denvis Bookshop | Home</title>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2430917478928033"
     crossorigin="anonymous"></script>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="icon" href="./images/logo.png">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link href="ratekit/css/ratekit.min.css" type="text/css" rel="stylesheet">
    <!-- Smartsupp Live Chat script -->
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
    $pid = '1';
    $naw = date('Y-m-d');
    $conn = $pdo->open();
    $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM visit WHERE vd=:naw AND pid=:pid");
    $stmt->execute(['naw'=>$naw, 'pid'=>$pid]);
    $vro = $stmt->fetch();
    if($vro['numrows'] != 1){
    $stmt = $conn->prepare("INSERT INTO visit (vd, pid, visits) VALUES (:naw, :pid, :visits)");
    $stmt->execute(['naw'=>$naw, 'pid'=>$pid, 'visits'=>1]);
    }
    else{
        try{
            $stmt = $conn->prepare("SELECT * FROM visit WHERE vd=:naw AND pid=:pid");
            $stmt->execute(['naw'=>$naw, 'pid'=>$pid]);
            foreach($stmt as $vro){
                $stmt = $conn->prepare("UPDATE visit SET visits=visits+1 WHERE vid=:vid");
                $stmt->execute(['vid'=>$vro['vid']]);    
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
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
        <h1 class="header-logo" style="color: black;"><b style="color:tomato;">Denvis</b>Bookshop</h1>

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
                            <li><a href="profile"><i class="fa fa-bell-o"></i> <span style="background-color:red;">'.$urow["numrows"].'</span></a></li>
                        ';
                        }
                    }
                ?>
                <li><a href="cart_view"><i class="fa fa-shopping-cart"></i> <span style="background-color:light-green;" class="cart_count"></span></a></li>
            </ul>
        </div>
            <nav class="humberger__menu__nav mobile-menu">
                <ul>
                    <?php
                        if(isset($_SESSION['user'])){
                            $image = (!empty($user['photo'])) ? 'images/'.$user['photo'] : 'images/profile.jpg';
                            echo '
                                <li><a href="profile" class="text-center">
                                    <img src="'.$image.'" style="height:60px; width:60px; border-radius: 50%;" alt="User Image">
                                </a></li>
                                <li style="color:black;"  class="text-center"><a>'.$user['firstname'].' '.$user['lastname'].'</a></li>
                                <li style="color:black;"  class="text-center"><a>Member since '.date('M. Y', strtotime($user['created_on'])).'</a></li>
                                <li><a href="./logout">Sign Out</a></li>
                            ';
                        }
                        else{
                            echo '
                            <li><a href="./login">Sign In</a></li>
                            <li><a href="./signup">Register</a></li>
                            ';
                        }
                    ?>
                    <li><a style="color:#00A65A;" href="./">Home</a></li>
                    <li><a href="./shop-grid">Shop</a></li>
                    <li><a href="./contactus">Contact</a></li>
                </ul>
            </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="https://wa.link/8lqn61"><i class="fa fa-whatsapp"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><a href="mailto:info@denvisbookshop.co.ke"><i class="fa fa-envelope"></i> info@denvisbookshop.co.ke</a></li>
                <li><a href="https://wa.link/8lqn61"><i class="fa fa-whatsapp"></i> Whatsapp Us</a></li>
                <li>Proud To Be Your Education partner</li>
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
                                <li><a style="color: #ffffff;" href="mailto:info@denvisbookshop.co.ke"><i class="fa fa-envelope"></i> info@denvisbookshop.co.ke</a></li>
                                <li>Proud To Be Your Education partner</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="https://wa.link/8lqn61"><i class="fa fa-whatsapp"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                            <div class="header__top__right__social">
								<?php
									if(isset($_SESSION['user'])){
									$image = (!empty($user['photo'])) ? 'images/'.$user['photo'] : 'images/profile.jpg';
									echo '
										<div class="header__top__right__language">
											<a href="profile">
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
											<a href='signup'><i class='fa fa-user'></i> Signup</a>
										</div>
										<div class='header__top__right__auth'>
											<a href='login'><i class='fa fa-user'></i> Login</a>
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
                    <h1 class="header-logo" style="color: black;"><b style="color:tomato;">Denvis</b>Bookshop</h1>
                </div>
                <div class="col-lg-7">
                    <nav class="header__menu">
                        <ul class="text-center">
                            <li class="active"><a href="./">Home</a></li>
                            <li><a href="./shop-grid">Shop</a></li>
                            <li><a href="./contactus">Contact</a></li>
							<?php
								if(isset($_SESSION['user'])){
								$image = (!empty($user['photo'])) ? 'images/'.$user['photo'] : 'images/profile.jpg';
								echo '
									<li><a href="profile">Profile</a></li>
									<li><a href="logout">Signout</a></li>
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
										<li><a href="profile"><i class="fa fa-bell-o"></i> <span style="background-color:red;">'.$urow["numrows"].'</span></a></li>
									';
									}
								}
							?>
							<li><a href="cart_view"><i class="fa fa-shopping-cart"></i> <span style="background-color:light-green;" class="cart_count"></span></a></li>
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
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Today's Top</span>
                        </div>
                        <ul id="trending">
							<?php
								$now = date('Y-m-d');
								$conn = $pdo->open();
				                $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM products WHERE date_view=:now");
                        		$stmt->execute(['now'=>$now]);
                        		$pro = $stmt->fetch();
                        		if($pro['numrows'] == 1){
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view!=:now ORDER BY RAND() LIMIT 9");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
                        		}
								elseif($pro['numrows'] == 2){
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view!=:now ORDER BY RAND() LIMIT 8");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
                        		}
								elseif($pro['numrows'] == 3){
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view!=:now ORDER BY RAND() LIMIT 7");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
                        		}
								elseif($pro['numrows'] == 4){
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view!=:now ORDER BY RAND() LIMIT 6");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
                        		}
								elseif($pro['numrows'] == 5){
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view!=:now ORDER BY RAND() LIMIT 5");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
                        		}
								elseif($pro['numrows'] == 6){
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view!=:now ORDER BY RAND() LIMIT 4");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
                        		}
								elseif($pro['numrows'] == 7){
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view!=:now ORDER BY RAND() LIMIT 3");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
                        		}
								elseif($pro['numrows'] == 8){
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view!=:now ORDER BY RAND() LIMIT 2");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
                        		}
								elseif($pro['numrows'] == 9){
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view!=:now ORDER BY RAND() LIMIT 1");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
                        		}
								elseif($pro['numrows'] > 9){
    								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter DESC LIMIT 10");
    								$stmt->execute(['now'=>$now]);
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
                        		}
								else{
								    $stmt = $conn->prepare("SELECT * FROM products ORDER BY counter DESC LIMIT 10");
    								$stmt->execute();
    								foreach($stmt as $row){
    									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
    								}
								}
								$pdo->close();
							?>
						</ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
							<form method="POST" action="search">
                                <input type="text" name="keyword" placeholder="What do you need?" required>
                                <button type="submit" class="site-btn">SEARCH</button>
                            </form>
                        </div>
                        <a href="tel:+254711625648">
                            <div class="hero__search__phone">
                                <div class="hero__search__phone__icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="hero__search__phone__text">
                                    <h5>+254711626548</h5>
                                    <span>support 24/7 time</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div id="carousel-example-generic" data-ride="carousel" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active" style="background-color: #f3f6fa;">
                                <div class="row">
                                    <div class="hero__text text-center col-md-5" style="padding-top: 5%;">
                                        <span class="badge" style="color:red;">BONAFIDE MEMBER OF THE</span>
                                        <h2>Kenya Booksellers <br/> Association</h2>
                                        <p style="color:red;">We Are Denvisbookshop</p>
                                        <a href="./shop-grid" class="jumbotron primary-btn">SHOP NOW</a>
                                    </div>
                                    <div class="col-md-5" style="padding-top: 5%; width:100%; text-align:center;">
                                        <img src="img/hero/Untitled.jpg">
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item" style="background-color: #f3f6fa;">
                                <div class="row">
                                    <div class="hero__text text-center col-md-5" style="padding-top: 5%;">
                                        <span class="badge ">EDUCATION PARTNER</span>
                                        <h2>A Brand <br />For Kenya</h2>
                                        <p>Free Pickup and Delivery Available</p>
                                        <a href="./shop-grid" class="jumbotron primary-btn " style="background-color:red;">SHOP NOW</a>
                                    </div>
                                    <div class="col-md-5" style="padding-top: 5%; text-align:center; width:100%;">
                                        <img src="img/hero/ke.jpeg">
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item" style="background-color: #f3f6fa;">
                                <div class="row">
                                    <div class="hero__text text-center col-md-5" style="padding-top: 5%;">
                                        <span class="badge ">EDUCATION PARTNER</span>
                                        <h2 style="color:red;">All Stationery <br />100% Quality</h2>
                                        <p>Free Pickup and Delivery Available</p>
                                        <a href="./shop-grid" class="jumbotron primary-btn" style="background-color:black; color:white;">SHOP NOW</a>
                                    </div>
                                    <div class="col-md-5" style="padding-top: 5%; text-align:center; width:100%;">
                                        <img src="img/hero/Untitled.jpg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                    <div class="row">
                        <div class="col-md-2" style="padding-top:30px;">
                            <h4>Rate Us:</h4>
                        </div>
                        <div class="col-md-3">
                            <input id="fed" class="rating pull-right" data-size="sm" data-show-label="true">
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

	<!--==========================
      Facts Section
    ============================-->
    
	<!-- Featured Section Begin -->
	<section id="set" class="featured spad  set-bg" data-setbg="images/banner.png">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>About Us</h2>
                    </div>
					<div class="text-center">
						<p style="color: #0f0f0f;;">Hello <?php if(isset($_SESSION['user'])){
 																echo $user['firstname'];}?>
                            <br>Denvis Bookshop, a bonafide member of the Kenya Booksellers Association, sells a variety of school supplies, including office equipment, books, lab equipment, sportswear, uniforms, computer accessories, exams, and printing services, to name a few. Our corporate headquarters are located in Serem-Vihiga County. Other branches are in Bungoma town, Shamakhokho shopping center, Cheptul Market-Kaimosi, and Vihiga town. We are proud of our many satisfied clients in Kenya's western region, which include public and private institutions, schools, and individuals. We are grateful for the opportunity to be a part of your educational journey.</p>
                </div>
            </div>
        </div>
    </section>
    <section id="clients" class="spad featured" style="padding-top:80px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>Products Covered</h2>
                    </div>
                </div>
                <div class="col-lg-12">
					<div class="categories__slider owl-carousel">
                        <?php
                            $conn = $pdo->open();
                            try{
                                $stmt = $conn->prepare("SELECT * FROM products ORDER BY RAND()");
                                $stmt->execute();
                                foreach ($stmt as $row) {
                                    $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
                                     echo "
                                        <div class='latest-prdouct__slider__item'>
                                            <a href='shop-details?product=".$row['slug']."' class='latest-product__item'>
                                                <div class='latest-product__item__pic'>
                                                    <img src='".$image."' style='width: 110px; height: 110px;'>
                                                </div>
                                                <div class='latest-product__item__text'>
                                                    <h6>".$row['name']."</h6>
                                                    <span>Ksh. ".number_format($row['price'], 2)."</span>
                                                </div>
                                            </a>
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
        </div>
    </section>
    <!-- Featured Section End -->
	<?php
		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM products");
		$stmt->execute();
		$row = $stmt->fetch();
		$pro = $row['numrows'];
	?>
	<?php
		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users");
		$stmt->execute();
		$row = $stmt->fetch();
		$clro = $row['numrows'];
	?>
	<?php
		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM store");
		$stmt->execute();
		$row = $stmt->fetch();
		$tro = $row['numrows'];
	?>
	<?php
		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM category");
		$stmt->execute();
		$row = $stmt->fetch();
		$cro = $row['numrows'];
	?>
	<section id="facts"  class="wow fadeIn set-bg" data-setbg="images/bg.jpg" style="padding-bottom:30px;">
        <div class="container">
	  		<div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>Fan Facts</h2>
                    </div>
                </div>
            </div>
        	<div class="row counters">
  				<div class="col-lg-3 col-6 text-center">
            		<span class="counter-count"><?php echo $clro?></span>
            		<p>Happy Users</p>
  				</div>
          		<div class="col-lg-3 col-6 text-center">
            		<span class="counter-count"><?php echo $pro?></span>
            		<p>Available Products</p>
  				</div>
          		<div class="col-lg-3 col-6 text-center">
            		<span class="counter-count"><?php echo $cro?></span>
            		<p>Product Categories</p>
  				</div>
          		<div class="col-lg-3 col-6 text-center">
            		<span class="counter-count"><?php echo $tro?></span>
            		<p>Branches</p>
  				</div>
  			</div>
      	</div>
    </section><!-- #facts -->

    <!-- Footer Section Begin -->
    <footer>
        <div class="footer text-center">
            <p style="color: black;"><b>&copy;<script>document.write(new Date().getFullYear());</script>  | <a style="color: white;" href="https://denvisbookshop.co.ke">Denvis Bookshop</a>  |  All rights reserved</b></p>
        </div>
    </footer>
    <!-- Footer Section End -->
	<?php include 'includes/scripts.php'; ?>

	<script>
		$('.counter-count').each(function () {
			$(this).prop('Counter',0).animate({
				Counter: $(this).text()
			}, {
				duration: 5000,
				easing: 'swing',
				step: function (now) {
					$(this).text(Math.ceil(now));
				}
			});
		});
	</script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="ratekit/js/ratekit.min.js"></script>

</body>
</html>