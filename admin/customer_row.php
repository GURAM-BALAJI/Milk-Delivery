<?php 
	include("../connect.php");

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$stmt = $link->prepare("SELECT c_id, c_name, c_amount FROM customers WHERE c_id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();
		echo json_encode($row);
	}
?>