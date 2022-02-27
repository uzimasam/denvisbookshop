<?php
	include 'includes/session.php';

	if(isset($_POST['receiverdelete'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE message SET receiverdelete=:receiverdelete WHERE id=:id");
			$stmt->execute(['receiverdelete'=>1, 'id'=>$id]);
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

	header('location: message.php');
?>