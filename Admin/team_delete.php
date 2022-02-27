<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("DELETE FROM team WHERE id=:id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'Board member removed successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select member to remove first';
	}

	header('location: team.php');
	
?>