<?php
	include 'includes/session.php';
	if(isset($_POST['add'])){
		$firstname = $_POST['amail'];

		try{
			$stmt = $conn->prepare("UPDATE users SET type=:aname WHERE id=$firstname");
			$stmt->execute(['aname'=>1]);
			$_SESSION['success'] = 'New Admin added successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up admin form first';
	}

	header('location: staff.php');

?>