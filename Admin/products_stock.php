<?php
	include 'includes/session.php';

	if(isset($_POST['upload'])){
		$id = $_POST['id'];
		$stock = $_POST['stock'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT * FROM products WHERE id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();
		
		try{
			$stmt = $conn->prepare("UPDATE products SET stock=:stock WHERE id=:id");
			$stmt->execute(['stock'=>$stock, 'id'=>$id]);
			$_SESSION['success'] = 'Product stock updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();

	}
	else{
		$_SESSION['error'] = 'Select product to update stock first';
	}

	header('location: products.php');
?>