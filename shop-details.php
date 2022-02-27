<?php include 'includes/session.php';
date_default_timezone_set('Africa/Nairobi');?>
<?php
	$conn = $pdo->open();

	$slug = $_GET['product'];

	try{
		 		
	    $stmt = $conn->prepare("SELECT *, products.name AS prodname, products.photo AS prodphoto, products.photoalt1 AS prodphotoalt1, products.photoalt2 AS prodphotoalt2, products.photoalt3 AS prodphotoalt3, products.category_id AS catid, category.name AS catname, products.id AS prodid FROM products LEFT JOIN category ON category.id=products.category_id WHERE slug = :slug");
	    $stmt->execute(['slug' => $slug]);
	    $product = $stmt->fetch();
        $catid = $product['catid'];
		
	}
	catch(PDOException $e){
		echo "There is some problem in connection: " . $e->getMessage();
	}

	//page view
	$now = date('Y-m-d');
	if($product['date_view'] == $now){
		$stmt = $conn->prepare("UPDATE products SET counter=counter+1 WHERE id=:id");
		$stmt->execute(['id'=>$product['prodid']]);
	}
	else{
		$stmt = $conn->prepare("UPDATE products SET counter=1, date_view=:now WHERE id=:id");
		$stmt->execute(['id'=>$product['prodid'], 'now'=>$now]);
	}
    $pid = '3';
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
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ecommerce Bookshop">
    <meta name="keywords" content="Denvis Bookshop, Uzima Samuel, Zalego, stationery, vihiga, kenya">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#00A65A">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Denvis Bookshop | <?php echo $product['prodname'];?></title>

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
    <link href="ratekit/css/ratekit.min.css" type="text/css" rel="stylesheet">
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

<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v11.0" nonce="Lesv31RO"></script>    
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
                    <li><a href="./">Home</a></li>
                    <li><a style="color:#00A65A;" href="./shop-grid">Shop</a></li>
                    <li><a href="./contactus">Contact</a></li>
                </ul>
            </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="humberger__menu__contact">
            <ul>
                <li><a href="mailto:info@denvisbookshop.co.ke"><i class="fa fa-envelope"></i> info@denvisbookshop.co.ke</a></li>
                <li><a href="https://wa.link/8lqn61"><i class="fa fa-whatsapp"></i> Whatsapp Us</a></li>
                <li>Proud To Be Your Education Partner</li>
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
                                <li>Proud To Be Your Education Partner</li>
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
                            <li><a href="./">Home</a></li>
                            <li class="active"><a href="./shop-grid">Shop</a></li>
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
							<li><a href="cart_view"><i class="fa fa-shopping-cart"></i> <span style="background-color:light-green;" class="cart_count">1</span></a></li>
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
                            <span>Today's Top</span>
                        </div>
                        <ul id="trending">
							<?php
								$now = date('Y-m-d');
								$conn = $pdo->open();
								$stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter DESC LIMIT 10");
								$stmt->execute(['now'=>$now]);
								foreach($stmt as $row){
									echo "<li><a href='shop-details?product=".$row['slug']."'><i class='fa fa-check-square-o'></i>  ".$row['name']."</a></li>";
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
    <section id="sejt" class="breadcrumb-section set-bg" data-setbg="img/kuj.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                <div class="breadcrumb__text" style="background-color: rgba(102, 255, 153, 0.4); padding: 40px; border-radius:20px; text-align: center;">
                        <h2 style="color:black;"><span style="color:tomato;">Denvis</span> Bookshop</h2>
                        <div class="breadcrumb__option">
                            <a href="./">Home</a>
                            <a href="shop-grid">Shop</a>
                            <span style="text-transform: lowercase;"><?php echo $product['prodname'];?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container" id="view">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img src="<?php echo (!empty($product['prodphoto'])) ? 'images/'.$product['prodphoto'] : 'images/noimage.jpg'; ?>" width="100%" class="product__details__pic__item--large" data-magnify-src="images/large-<?php echo $product['photo']; ?>">
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            <img data-imgbigurl="<?php echo 'images/'.$product['prodphoto']?>" src="<?php echo 'images/'.$product['prodphoto']?>" alt="">
                            <img data-imgbigurl="<?php echo 'images/'.$product['prodphotoalt1']?>" src="<?php echo 'images/'.$product['prodphotoalt1']?>" alt="">
                            <img data-imgbigurl="<?php echo 'images/'.$product['prodphotoalt2']?>" src="<?php echo 'images/'.$product['prodphotoalt2']?>" alt="">
                            <img data-imgbigurl="<?php echo 'images/'.$product['prodphotoalt3']?>" src="<?php echo 'images/'.$product['prodphotoalt3']?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3><?php echo $product['prodname']; ?></h3>
                        <div class="product__details__price">
                            Ksh. <?php echo number_format($product['price'], 2); ?>
                        </div>
                        <div class="product__details__quantity">
                            <form class="form-inline" id="productForm">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" name="quantity" id="quantity" value="1">
                                    </div>
                                    <input type="hidden" value="<?php echo $product['prodid']; ?>" name="id">
                                </div>
                                <button type="submit" class="btn primary-btn"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
                            </form>
                        </div>
                        <ul>
                            <li><b>Category:</b> <span><a style="color:green;" href="category?category=<?php echo $product['name']; ?>"><?php echo $product['catname']; ?></a></span></li>
                            <div style="padding:2px;"></div>
                        </ul>
                        <input id="<?php echo $product['slug']; ?>" class="rating" data-size="sm" data-show-label="true">
                        <div class="callout" id="callout" style="display:none; padding:20px; text-align:center;">
                            <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                            <span class="alert alert-info message"></span>
                        </div>
                    </div>
                    <div class="product__details__tab" style="padding:0px;">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                    aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                    aria-selected="false">Comments</a>
                            </li>
                        </ul>
                        <div class="tab-content" style="margin-left:10px;">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Description</h6>
                                    <p><?php echo $product['description']; ?></p>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Product's Comments And Reviews</h6>
                                    <div class="fb-comments" data-href="http://localhost/denvisbookshop/shop-details?product=<?php echo $slug; ?>;" data-width="" data-numposts="5"></div>                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Related Products</h2>
                    </div>
                        <div class="product__details__pic__slider owl-carousel">
                        <?php
                                        $conn = $pdo->open();
                                        try{
                                            $stmt = $conn->prepare("SELECT * FROM products WHERE category_id=$catid ORDER BY id");
                                            $stmt->execute();
                                            foreach ($stmt as $row) {
                                                $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
                                                echo "
                                                    <a href='shop-details?product=".$row['slug']."' class='latest-product__item'>
                                                        <div class='latest-product__item__pic'>
                                                            <img src='".$image."' style='width: 110px; height: 110px;'>
                                                        </div>
                                                        <div class='latest-product__item__text'>
                                                            <h6>".$row['name']."</h6>
                                                            <span>Ksh. ".number_format($row['price'], 2)."</span>
                                                        </div>
                                                    </a>
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
    <!-- Related Product Section End -->

    <?php $pdo->close(); ?>

    <div>
        <img src="./img/hu.jpg">
    </div>
<!-- Footer Section Begin -->
<footer>
    <div class="footer text-center">
        <p style="color: black;"><b>&copy;<script>document.write(new Date().getFullYear());</script>  | <a style="color: white;" href="https://denvisbookshop.co.ke" target="_blank">Denvis Bookshop</a>  |  All rights reserved</b></p>
    </div>
</footer>
<!-- Footer Section End -->

    <!-- Js Plugins -->
    <?php include 'includes/scripts.php'; ?>
    <script>
    $(function(){
        $('#add').click(function(e){
            e.preventDefault();
            var quantity = $('#quantity').val();
            quantity++;
            $('#quantity').val(quantity);
        });
        $('#minus').click(function(e){
            e.preventDefault();
            var quantity = $('#quantity').val();
            if(quantity > 1){
                quantity--;
            }
            $('#quantity').val(quantity);
        });

    });
    </script>
    <script src="js/jquery-3.3.1.min.js"></script>
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