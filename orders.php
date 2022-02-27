<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$id = $_POST['id'];

        $conn = $pdo->open();

        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id'=>$id]);
        $row = $stmt->fetch();
        date_default_timezone_set('Africa/Nairobi');
        $now = date('Y-m-d H:i:s');
        $orderid = "DB".strtoupper(uniqid());
        if($row['orderstatus']==0){
            try{
                $stmt = $conn->prepare("UPDATE users SET orderstatus=:initiate, ordertime=:tim, orderid=:orderid, notif=:orderid WHERE id=:id");
                $stmt->execute(['initiate'=>1, 'id'=>$id, 'tim'=>$now, 'orderid'=>$orderid, 'notif'=>0]);
                $message = 'Hello, Thankyou for choosing Denvis Bookshop, we have received your order. Do not modify your cart until the transaction is complete. Meanwhile, stay close to your phone, and check you website notifications frequently.';
                $message0 = 'ORDER STATUS : <span class="badge badge-success">Waiting to be Processed</span>';
                $stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, message) VALUES (:sender_id, :receiverid, :message)");
                $stmt->execute(['sender_id'=>2, 'receiverid'=>$id, 'message'=>$message]);
                $stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, message) VALUES (:sender_id, :receiverid, :message)");
                $stmt->execute(['sender_id'=>2, 'receiverid'=>$id, 'message'=>$message0]);
                $_SESSION['success'] = 'Order Placed. You will be contacted soon';
            }
            catch(PDOException $e){
              echo $e->getMessage();
            }
        }
        else{
            $_SESSION['error'] = 'You already have an order being processed. Wait for the current order to be complete';
        }

		$pdo->close();

		header('location: profile.php');
	}

?>