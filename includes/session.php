<?php
	include 'includes/conn.php';
	session_start();

	if(isset($_SESSION['admin'])){
		header('location: Admin/');
	}
	if(isset($_SESSION['branch'])){
		header('location: branch/');
	}

	if(isset($_SESSION['user'])){
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
			$stmt->execute(['id'=>$_SESSION['user']]);
			$user = $stmt->fetch();
		}
		catch(PDOException $e){
			echo "There is some problem in connection: " . $e->getMessage();
		}

		$pdo->close();
	}
?>