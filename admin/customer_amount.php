<?php
include("../connect.php");
session_start();
	if(isset($_POST['add'])){
		$id = $_POST['id'];
		$add_amount = $_POST['add_amount'];
		$stmt = $link->prepare("SELECT * FROM customers WHERE c_id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();

        $amount=$row['c_amount'];
        $by=$_SESSION['login_id'];
        $amount=intval($add_amount)+intval($amount);
		try{
			$stmt = $link->prepare("UPDATE customers SET c_amount=:amount, updated_by_id=:by WHERE c_id=:id");
			$stmt->execute(['amount'=>$amount, 'by'=>$by, 'id'=>$id]);
			$_SESSION['success'] = $add_amount.' Liters updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
	}
	else{
		$_SESSION['error'] = 'Fill up liters customer form first';
	}

	header('location: manage_customer.php');

?>