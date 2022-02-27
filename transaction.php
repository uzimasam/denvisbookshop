<?php
	include 'includes/session.php';

	$id = $_POST['id'];

	$conn = $pdo->open();

	$output = array('list'=>'');

	$stmt = $conn->prepare("SELECT * FROM transdet LEFT JOIN trans ON trans.transid=transdet.transid WHERE transdet.transid=:id");
	$stmt->execute(['id'=>$id]);

	$total = 0;
	foreach($stmt as $row){
		$output['transaction'] = $row['transid'];
		$output['date'] = date('M d, Y', strtotime($row['date']));
		$subtotal = $row['price']*$row['quantity'];
		$total += $subtotal;
		$output['list'] .= "
			<tr class='prepend_items'>
				<td>".$row['pname']."</td>
				<td>Ksh. ".number_format($row['price'], 2)."</td>
				<td>".$row['quantity']."</td>
				<td>Ksh. ".number_format($subtotal, 2)."</td>
			</tr>
		";
	}
	
	$output['total'] = '<b>Ksh. '.number_format($total, 2).'<b>';
	$pdo->close();
	echo json_encode($output);

?>