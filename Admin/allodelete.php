<?php
	include 'includes/session.php';

	if(isset($_POST['max'])){
		$id = $_POST['stoid'];
		$name = $_POST['prodid'];

		$conn = $pdo->open();

		try{
            $stmt = $conn->prepare("DELETE FROM allocations WHERE storeid=:id AND prodid=:name");
            $stmt->execute(['id'=>$id, 'name'=>$name]);
			$_SESSION['success'] = 'Product deleted from store successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill select product to delete first';
	}

	header('location: allocations.php');

?>