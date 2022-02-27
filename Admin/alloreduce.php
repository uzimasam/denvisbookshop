<?php
	include 'includes/session.php';

	if(isset($_POST['min'])){
		$id = $_POST['stoid'];
		$name = $_POST['prodid'];
		$mins = $_POST['mins'];

		$conn = $pdo->open();

		try{
            $stmt = $conn->prepare("SELECT * FROM allocations WHERE storeid=$id AND prodid=$name");
            $stmt->execute();
            $urow =  $stmt->fetch();
            $origi = $urow['stock'];
            $news = $origi-$mins;
			$stmt = $conn->prepare("UPDATE allocations SET stock=:ns WHERE storeid=$id AND prodid=$name");
			$stmt->execute(['ns'=>$news]);
			$_SESSION['success'] = 'Stock reduced successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up stock reduce form first';
	}

	header('location: allocations.php');

?>