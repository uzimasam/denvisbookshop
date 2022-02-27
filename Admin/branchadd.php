<?php
	include 'includes/session.php';
	if(isset($_POST['add'])){
		$mid = $_POST['mid'];
		$stoname = $_POST['stoname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];
		if($password != $repassword){
			$_SESSION['error'] = 'Passwords did not match';
			header('location: branches.php');
		}
		else{
			$conn = $pdo->open();
			$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE email=:email");
			$stmt->execute(['email'=>$email]);
			$row = $stmt->fetch();
			if($row['numrows'] > 0){
				$_SESSION['error'] = 'Email already taken';
				header('location: branches.php');
			}
            else{
                $conn = $pdo->open();
                $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM store WHERE manager_id=:id");
                $stmt->execute(['id'=>$mid]);
                $row = $stmt->fetch();
                if($row['numrows'] > 0){
                    $_SESSION['error'] = 'Selected manager is not eligible';
                    header('location: branches.php');
                }
                else{
                    $conn = $pdo->open();
                    $now = date('Y-m-d');
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $firstname = 'Counter';
                    $lastname = 'Customer';
                    try{
                        $stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, created_on, type, status) VALUES (:email, :password, :firstname, :lastname, :now, :type, :status)");
                        $stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'type'=>3, 'now'=>$now, 'status'=>1]);
                        $stmt = $conn->prepare("INSERT INTO store (stomail, manager_id, store_name) VALUES (:stomail, :manager_id, :store_name)");
                        $stmt->execute(['stomail'=>$email, 'manager_id'=>$mid, 'store_name'=>$stoname]);
                        $stmt = $conn->prepare("UPDATE users SET type=:type WHERE id=:id");
                        $stmt->execute(['type'=>2, 'id'=>$mid]);
                        $_SESSION['success'] = 'Branch created successfully';
                        header('location: branches.php');
                    } 
                    catch(PDOException $e){
                        $_SESSION['error'] = $e->getMessage();
                        header('location: branches.php');
                    }
                    $pdo->close();
                }
            }
	    }
    }
	else{
		$_SESSION['error'] = 'Fill up branch form first';
	}
	header('location: branches.php');
?>