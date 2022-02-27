<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$sender_id = $_POST['sender_id'];
		$receiver_id = $_POST['receiver_id'];
		$message = $_POST['message'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("INSERT INTO message (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
		$stmt->execute(['sender_id'=>$sender_id, 'receiver_id'=>$receiver_id, 'message'=>$message]);

		$pdo->close();

		header('location: profile.php');
	}

?>