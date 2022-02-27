<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	include 'includes/session.php';
	/* */
	$now = 1;
		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT * FROM users WHERE type =8");
		$stmt->execute();
		foreach($stmt as $row){
			$email = $row['email'];
			try{
				$message = "
					<div style='text-align:center'>
						<div style='margin-left:150px; text-align:center; background:#d0d1d4; padding:50px;width:600px; opacity:75%;'>
							<div> 
								<img  style='width: 600px;' src='sad.jpg'>
							</div>
							<table>
								<tr>
									<td style='text-align:center'>
										<div>
											<a href='https://denvisbookshop.co.ke'>
												<img src='logo.png' align='left' style='width:250px;height:250px;' alt='Happy New Year'/>
											</a>
											<p style='color:black; font-family: Allura,cursive,Arial, Helvetica, sans-serif;  padding-top: 15px;'>
												'Hello ".$row['firstname'].", you have been a great customer for our business and on behalf of Denvis Bookshop, I want to wish you a very happy new year 2022. May this year bring lots of hapiness in your life'
											</p>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div style='float:left;'>
											<p style='color:#b1190e;font-family: Arial, Helvetica, sans-serif; font-size:20px; text-align: center;'>
												'Be determined, there's blessings awaiting you,, 2022 comes with positive answers to your prayers,,, DENVIS BOOKSHOP wishes you a happy new year. </p>
												<br>
												<p style='color:#15522b;font-family: Arial, Helvetica, sans-serif; font-size:20px; text-align: center;'>
													May the joy, cheer, Mirth and merriment Of this divine festival Surround you forever......'
											</p>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div style='margin-left:150px; margin-right:150px; text-align: center;'>
							<p>You received this email because you signed up on our website <a href='https://denvisbookshop.co.ke'>www.denvisbookshop.co.ke</a> <br> &copy;<script>document.write(new Date().getFullYear());</script> <b>Denvis Bookshop</b> Your Education Partner</p>
						</div>
					</div>
				";

				//Load phpmailer
				require 'vendor/autoload.php';

				$mail = new PHPMailer(true);                             
				try {
					//Server settings
					$mail->isSMTP();                                     
					$mail->Host = 'smtp.gmail.com';                      
					$mail->SMTPAuth = true;                               
					$mail->Username = 'sirmurila@gmail.com';     
					$mail->Password = 'uzima0768415577';                    
					$mail->SMTPOptions = array(
						'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
						)
					);                         
					$mail->SMTPSecure = 'ssl';                           
					$mail->Port = 465;                                   

					$mail->setFrom('sirmurila@gmail.com', 'Uzo');
					
					//Recipients
					$mail->addAddress($email);              
					$mail->addReplyTo('sirmurila@gmail.com');
				   
					//Content
					$mail->isHTML(true);                                  
					$mail->Subject = 'Denvis Bookshop Account Activation';
					$mail->Body    = $message;

					$mail->send();

					unset($_SESSION['firstname']);
					unset($_SESSION['lastname']);
					unset($_SESSION['email']);

					$_SESSION['success'] = 'Account created. Check your email to activate.';
					header('location: shop-grid.php');
				 
				} 
				catch (Exception $e) {
					$_SESSION['error'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
					echo $now;
				}
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
				header('location: register.php');
			}
		}
		$pdo->close();
?>