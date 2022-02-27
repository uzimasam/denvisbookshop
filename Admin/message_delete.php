<?php
	include 'includes/session.php';

	if(isset($_POST['senderdelete'])){
		$id = $_POST['id'];
		$link = $_POST['link'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE message SET senderdelete=:senderdelete WHERE id=:id");
			$stmt->execute(['senderdelete'=>1, 'id'=>$id]);
			$_SESSION['success'] = 'Message deleted successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();

	}
	else{
		$_SESSION['error'] = 'Select message to delete first';
	}

	header('location: contact.php?user='.$link);
?>