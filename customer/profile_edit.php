<?php
	include 'includes/session.php';


	if(isset($_POST['edit'])){
		$curr_password = $_POST['curr_password'];
		$password = $_POST['password'];
		$name = $_POST['name'];
        $address = $_POST['address'];
		$phone = $_POST['contact'];
		$photo = $_FILES['photo']['name'];
    $id=$_SESSION['c_id'];
    $stmt = $link->prepare("SELECT password,c_id,c_photo FROM customers WHERE c_delete = '0' AND c_id = :id ");
    $stmt->bindParam(':id',$id, PDO::PARAM_STR);
    $stmt->execute();
    $stmt = $stmt -> fetchAll(PDO::FETCH_OBJ);
    foreach($stmt as $user){
		if(password_verify($curr_password, $user->password)){
			if(!empty($photo)){
				move_uploaded_file($_FILES['photo']['tmp_name'], 'images/'.$photo);
				$filename = $photo;	
			}
			else{
				$filename = $user->c_photo;
			}

			if($password == $user->password){
				$password = $user->password;
			}
			else{
				$password = password_hash($password, PASSWORD_DEFAULT);
			}

			try{
				$stmt = $link->prepare("UPDATE customers SET password=:password, c_name=:name, c_photo=:photo, c_address=:address, c_phone=:phone WHERE c_id=:id");
				$stmt->execute(['password'=>$password, 'name'=>$name, 'photo'=>$filename, 'address'=>$address, 'phone'=>$phone, 'id'=>$id]);

				$_SESSION['success'] = 'Account updated successfully';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
			
		}
		else{
			$_SESSION['error'] = 'Incorrect password';
		}}
	}
	else{
		$_SESSION['error'] = 'Fill up required details first';
	}

	header('location:profile.php');

?>