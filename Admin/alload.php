<?php
	include 'includes/session.php';

	if(isset($_POST['max'])){
		$id = $_POST['stoid'];
		$name = $_POST['prodid'];

		$conn = $pdo->open();

        $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM allocations WHERE storeid=$id AND prodid=$name");
        $stmt->execute();
        $urow =  $stmt->fetch();
        if($urow['numrows'] > 0){
			$_SESSION['error'] = 'Selected Product already allocated to the selected Branch';
		}
		else{
			try{            
				$stmt = $conn->prepare("INSERT INTO allocations (storeid, prodid) VALUES (:stid, :pid)");
			    $stmt->execute(['stid'=>$id, 'pid'=>$name]);
			    $_SESSION['success'] = 'Product Allocated successfully';
		    }
		    catch(PDOException $e){
			    $_SESSION['error'] = $e->getMessage();
		    }
        }
        $pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up stock reduce form first';
	}

	header('location: allocations.php');
?>