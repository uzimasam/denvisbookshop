<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$usid = $_POST['name'];
        $conn = $pdo->open();

        try{
            $stmt = $conn->prepare("SELECT *, cart.id AS cartid FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
            $stmt->execute(['user_id'=>$usid]);
            foreach($stmt as $row){
                $usid = $usid;
                $name = $row['name'];
                $qty = $row['quantity'];
                $price = $row['price'];
                $stmt = $conn->prepare('INSERT INTO sales_order (usid, qty, name, price) VALUES (:usid, :qty, :name, :price)');
                $stmt->execute(['usid'=>$usid, 'qty'=>$qty, 'name'=>$name, 'price'=>$price]);
            }
            $stmt = $conn->prepare("DELETE * FROM cart WHERE user_id=:user_id");
            $stmt->execute(['user_id'=>$usid]);
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }

		$_SESSION['success'] = 'Order Counterchecked and payment details sent';
		$pdo->close();
		header('location: orders.php');
	}

?>