<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	if(isset($_POST['edit'])){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$rank = $_POST['rank'];
		$contact = $_POST['contact'];
		$location = $_POST['location'];
		$message = $_POST['message'];

		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE team SET name=:name, email=:email, rank=:rank, contact=:contact, location=:location, message=:message WHERE id=:id");
			$stmt->execute(['name'=>$name, 'email'=>$email, 'rank'=>$rank, 'contact'=>$contact, 'location'=>$location, 'message'=>$message, 'id'=>$id]);
			$_SESSION['success'] = 'Board member updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit team member form first';
	}

	header('location: team.php');

?>