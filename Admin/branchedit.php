<?php
	include 'includes/session.php';
	if(isset($_POST['add'])){
		$mid = $_POST['mid'];
		$maid = $_POST['maid'];
		$stoname = $_POST['stoname'];
		$stoid = $_POST['stoid'];
		$stid = $_POST['stid'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];
		if($password != $repassword){
			$_SESSION['error'] = 'Passwords did not match';
			header('location: branches.php');
		}
		else{
			$conn = $pdo->open();
			$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE email=:email AND id!=$stid");
			$stmt->execute(['email'=>$email]);
			$row = $stmt->fetch();
			if($row['numrows'] > 0){
				$_SESSION['error'] = 'Email already taken';
				header('location: branches.php');
			}
            else{
                $conn = $pdo->open();
                $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM store WHERE manager_id=:id AND store_id!=$stoid");
                $stmt->execute(['id'=>$mid]);
                $row = $stmt->fetch();
                if($row['numrows'] > 0){
                    $_SESSION['error'] = 'Selected manager is not eligible';
                    header('location: branches.php');
                }
                else{
                    $conn = $pdo->open();
                    if($password == $row['password']){
                        $password = $row['password'];
                    }
                    else{
                        $password = password_hash($password, PASSWORD_DEFAULT);
                    }
                    try{
                        $stmt = $conn->prepare("UPDATE store SET manager_id=:type, stomail=:stomail, store_name=:stoname WHERE store_id=:id");
                        $stmt->execute(['type'=>$mid, 'stomail'=>$email, 'stoname'=>$stoname, 'id'=>$stoid]);
                        $stmt = $conn->prepare("UPDATE users SET email=:stomail, password=:pass WHERE id=:id");
                        $stmt->execute(['stomail'=>$email, 'pass'=>$password, 'id'=>$stid]);
                        $stmt = $conn->prepare("UPDATE users SET type=:type WHERE id=:id");
                        $stmt->execute(['type'=>2, 'id'=>$mid]);
                        $stmt = $conn->prepare("UPDATE users SET type=:type WHERE id=:id");
                        $stmt->execute(['type'=>0, 'id'=>$maid]);
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