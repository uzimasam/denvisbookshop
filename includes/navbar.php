<header class="main-header">
  <nav class="navbar navbar-fixed-top">
      <div class="navbar-header">
        <span class="navbar-brand logo-mini" style="color: black;"><b style="color:tomato;">Denvis</b>Bookshop</span>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
          <i class="fa fa-bars"></i>
        </button>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a href="index.php">HOME</a></li>
          <li><a href="shop-grid.php">SHOP</a></li>
          <li class="dropdown">
            <a href="" class="dropdown-toggle" data-toggle="dropdown">CATEGORY <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
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
          </li>
        </ul>
        <form method="POST" class="navbar-form navbar-left" action="search.php">
          <div class="input-group">
              <input type="text" class="form-control" id="navbar-search-input" name="keyword" placeholder="Search for Product and hit enter" required>
              <span class="input-group-btn" id="searchBtn" style="display:none;">
              </span>
          </div>
        </form>
      </div>
      <!-- /.navbar-collapse -->
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <?php
                if(isset($_SESSION['user'])){
                    $ui = $user['id'];
                    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM message where status=0 and receiver_id=$ui");
                    $stmt->execute();
                    $urow =  $stmt->fetch();
                  if($urow['numrows'] > 0){
                    echo "
                      <li class='dropdown messages-menu'>
                      <!-- Menu toggle button -->
                      <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                        <i class='fa fa-bell-o'></i>
                        <span class='label label-danger'>".$urow['numrows']."</span>
                      </a>
                      <ul class='dropdown-menu'>
                        <li class='header'>You have <span>".$urow['numrows']."</span> unread message(s)</li>
                        <li>
                          <ul class='menu' id='message_menu'>
                          </ul>
                        </li>
                        <li class='footer'><a href='profile.php'><i class='fa fa-paper-plane'></i>View your messages</a></li>
                      </ul>
                    </li>
                    ";
                  }
              }
          ?>
          <li class="dropdown messages-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-shopping-cart"></i>
              <span class="label label-success cart_count"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <span class="cart_count"></span> item(s) in cart</li>
              <li>
                <ul class="menu" id="cart_menu">
                </ul>
              </li>
              <li class="footer"><a href="cart_view.php">Go to Cart</a></li>
            </ul>
          </li>
          <?php
            if(isset($_SESSION['user'])){
              $image = (!empty($user['photo'])) ? 'images/'.$user['photo'] : 'images/profile.jpg';
              echo '
                <li class="dropdown user user-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="'.$image.'" class="user-image" alt="User Image">
                    <span class="hidden-xs">'.$user['firstname'].' '.$user['lastname'].'</span>
                  </a>
                  <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                      <img src="'.$image.'" class="img-circle" alt="User Image">

                      <p>
                        '.$user['firstname'].' '.$user['lastname'].'
                        <small>Member since '.date('M. Y', strtotime($user['created_on'])).'</small>
                      </p>
                    </li>
                    <li class="user-footer">
                      <div class="pull-left">
                        <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                      </div>
                      <div class="pull-right">
                        <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                      </div>
                    </li>
                  </ul>
                </li>
              ';
            }
            else{
              echo "
                <li><a href='login.php'>LOGIN</a></li>
              ";
            }
          ?>
        </ul>
      </div>
    </div>
  </nav>
  <div style="padding-top:50px;"></div>
</header>