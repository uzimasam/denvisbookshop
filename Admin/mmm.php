<?php
	include 'includes/session.php';
	if(isset($_POST['sab'])){
		$firstname = $_POST['firstname'];
		$contact = $_POST['contact'];
		$orderid = $_POST['orderid'];

		try{
			$stmt = $conn->prepare("UPDATE users SET firstname=:aname, contact_info=:contact, orderid=:order WHERE type=7");
			$stmt->execute(['aname'=>$firstname, 'contact'=>$contact, 'order'=>$orderid]);
			$_SESSION['success'] = 'Customer Care updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up customer care form first';
	}

	header('location: staff.php');

?>