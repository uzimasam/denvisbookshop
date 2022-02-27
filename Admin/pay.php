<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$usid = $_POST['usid'];
        $met = $_POST['met'];
        $cashier_name = $_POST['cashier_name'];
        $timeorder = $_POST['timeorder'];
        $tcode = $_POST['tcode'];
        $total = $_POST['total'];
        $paid = $_POST['paid'];
        $answere = $total - $paid;
        $conn = $pdo->open();

        $message1 = 'ORDER STATUS : <span class="label label-success">Payment Received</span>';
        $message2 = 'ORDER STATUS : <span class="label label-success">Order Complete</span>';
        $message3 = 'Partial payment received, ensure that you complete your payment as soon as possible. Your balance is <strong style="color:tomato"> '.$answere.'</strong>. Regards.';
        $message5 = 'Excess payment received, ensure that you reach out your balance as soon as possible. Your balance is <strong style="color:tomato"> '.$answere.'</strong>. Regards.';
        if($answere == 0){
            try{
                $stmt = $conn->prepare("SELECT * FROM users WHERE id=:usid");
                $stmt->execute(['usid'=>$usid]); 
                foreach($stmt as $row){
                    $stmt = $conn->prepare("UPDATE users SET orderstatus=:intiate WHERE id=:id");
                    $stmt->execute(['intiate'=>0, 'id'=>$usid]);
                    $transid = $row['orderid'];
                    $stmt = $conn->prepare('INSERT INTO trans (transid, operator_name, user_id, method, transcode, time, paid) VALUES (:transid, :operator_name, :user_id, :method, :transcode, :time, :paid)');
                    $stmt->execute(['transid'=>$transid, 'operator_name'=>$cashier_name, 'user_id'=>$usid, 'method'=>$met, 'transcode'=>$tcode, 'time'=>$timeorder, 'paid'=>$paid]);
                    $stmt = $conn->prepare("SELECT * FROM sales_order WHERE usid=:user_id");
                    $stmt->execute(['user_id'=>$usid]);
                    foreach($stmt as $row){
                        $quantity = $row['qty'];
                        $price = $row['price'];
                        $pname = $row['name'];
                        $stmt = $conn->prepare('INSERT INTO transdet (quantity, price, transid, pname) VALUES (:quantity, :price, :transid, :pname)');
                        $stmt->execute(['quantity'=>$quantity, 'price'=>$price, 'transid'=>$transid, 'pname'=>$pname]);
                    }
                    $stmt = $conn->prepare("DELETE FROM sales_order WHERE usid=:user_id");
                    $stmt->execute(['user_id'=>$usid]);
                    $message4 = "Hello, Your transaction has been completed successfully. To finish the order, Reach out our support team via the chatbot for a soft copy of your receipt, order number <strong style='color:tomato'> ".$transid."</strong>. It has been nice working with you. Regards.";
            		$stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
	            	$stmt->execute(['sender_id'=>2, 'receiver_id'=>$usid, 'message'=>$message1]);
                    $stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
	            	$stmt->execute(['sender_id'=>2, 'receiver_id'=>$usid, 'message'=>$message4]);
                    $stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
	            	$stmt->execute(['sender_id'=>2, 'receiver_id'=>$usid, 'message'=>$message2]);
                }
                $_SESSION['success'] = 'Order transaction successful';
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        elseif($answere < 0){
            try{
                $stmt = $conn->prepare("SELECT * FROM users WHERE id=:user_id");
                $stmt->execute(['user_id'=>$usid]); 
                foreach($stmt as $row){
                    $stmt = $conn->prepare("UPDATE users SET orderstatus=:intiate WHERE id=:id");
                    $stmt->execute(['intiate'=>0, 'id'=>$usid]);
                    $transid = $row['orderid'];
                    $stmt = $conn->prepare('INSERT INTO trans (transid, operator_name, user_id, method, transcode, time, paid) VALUES (:transid, :operator_name, :user_id, :method, :transcode, :time, :paid)');
                    $stmt->execute(['transid'=>$transid, 'operator_name'=>$cashier_name, 'user_id'=>$usid, 'method'=>$met, 'transcode'=>$tcode, 'time'=>$timeorder, 'paid'=>$paid]);
                    $stmt = $conn->prepare("SELECT * FROM sales_order WHERE usid=:user_id");
                    $stmt->execute(['user_id'=>$usid]);
                    foreach($stmt as $row){
                        $quantity = $row['qty'];
                        $price = $row['price'];
                        $pname = $row['name'];
                        $stmt = $conn->prepare('INSERT INTO transdet (quantity, price, transid, pname) VALUES (:quantity, :price, :transid, :pname)');
                        $stmt->execute(['quantity'=>$quantity, 'price'=>$price, 'transid'=>$transid, 'pname'=>$pname]);
                    }
                    $stmt = $conn->prepare("DELETE FROM sales_order WHERE usid=:user_id");
                    $stmt->execute(['user_id'=>$usid]);
                    $message4 = "Hello, Your transaction has been completed successfully. To finish the order, Reach out our support team via the chatbot for a soft copy of your receipt, order number <strong style='color:tomato'> ".$transid."</strong>. It has been nice working with you. Regards.";
            		$stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
	            	$stmt->execute(['sender_id'=>2, 'receiver_id'=>$usid, 'message'=>$message1]);
                    $stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
	            	$stmt->execute(['sender_id'=>2, 'receiver_id'=>$usid, 'message'=>$message5]);
                    $stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
	            	$stmt->execute(['sender_id'=>2, 'receiver_id'=>$usid, 'message'=>$message4]);
                    $stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
	            	$stmt->execute(['sender_id'=>2, 'receiver_id'=>$usid, 'message'=>$message2]);
                }
                $_SESSION['success'] = 'Order transaction successful';
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
        elseif($answere > 0){
            try{
                $_SESSION['error'] = 'Payment not made, The system does not receive less payment';
                $stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
                $stmt->execute(['sender_id'=>2, 'receiver_id'=>$usid, 'message'=>$message3]);
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }
		$pdo->close();
		header('location: orders.php');
	}

?>