<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$usid = $_POST['name'];
        $conn = $pdo->open();
        $message1 = 'ORDER STATUS : <span class="label label-success">Waiting for payment</span>';
        $stmt = $conn->prepare("SELECT * FROM users where id=:id");
        $stmt->execute(['id'=>2]);
        foreach($stmt as $row){
            $till = $row['orderid'];
        }
        try{
            $stmt = $conn->prepare("SELECT *, cart.id AS cartid FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
            $stmt->execute(['user_id'=>$usid]);
            foreach($stmt as $row){
                $name = $row['name'];
                $qty = $row['quantity'];
                $price = $row['price'];
                $stmt = $conn->prepare('INSERT INTO sales_order (usid, qty, name, price) VALUES (:usid, :qty, :name, :price)');
                $stmt->execute(['usid'=>$usid, 'qty'=>$qty, 'name'=>$name, 'price'=>$price]);
            }
            $stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
            $stmt->execute(['user_id'=>$usid]);
            $stmt = $conn->prepare("SELECT * FROM sales_order where usid=:usid");
            $stmt->execute(['usid'=>$usid]);
            $total = 0;
            foreach($stmt as $srow){
                $subtotal = $srow['price']*$srow['qty'];
                $total += $subtotal;    
            }
            $message = "Hello, Your order worth <strong style='color:tomato;'> Ksh. ".$total."</strong> has been counterchecked successfully. To finish the order, hand deliver your cash or bank cheque to our Serem Shop, or pay via m-pesa pay-bill no <strong style='color:green'> ".$till." </strong> as soon as possible";
    		$stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
	    	$stmt->execute(['sender_id'=>2, 'receiver_id'=>$usid, 'message'=>$message]);
            $stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
	    	$stmt->execute(['sender_id'=>2, 'receiver_id'=>$usid, 'message'=>$message1]);
            $stmt = $conn->prepare("UPDATE users SET orderstatus=:intiate WHERE id=:id");
            $stmt->execute(['intiate'=>3, 'id'=>$usid]);
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }

		$_SESSION['success'] = 'Order Counterchecked and payment details sent';
		$pdo->close();
		header('location: orders.php');
	}

?>