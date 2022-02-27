<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$rank = $_POST['rank'];
		$contact = $_POST['contact'];
		$location = $_POST['location'];
		$message = $_POST['message'];
		$filename = $_FILES['photo']['name'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM team WHERE email=:email");
		$stmt->execute(['email'=>$email]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Email already taken';
		}
		else{
			if(!empty($filename)){
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$new_filename = $email.'.'.$ext;
				move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$new_filename);	
			}
			else{
				$new_filename = '';
			}

			try{
				$stmt = $conn->prepare("INSERT INTO team (rank, name, message, email, location, photo, contact) VALUES (:rank, :name, :message, :email, :location, :photo, :contact)");
				$stmt->execute(['rank'=>$rank, 'name'=>$name, 'message'=>$message, 'email'=>$email, 'location'=>$location, 'photo'=>$new_filename, 'contact'=>$contact]);
				$_SESSION['success'] = 'Board Member added successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up team form first';
	}

	header('location: team.php');

?>