<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("DELETE FROM message WHERE id=:id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'Message deleted for everyone';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();

		header('location: message_out_no1.php');
    }
    else{
		$_SESSION['error'] = 'Select message to delete first';
	}

?>