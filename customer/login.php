<?php
	//Start session
	session_start();
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	include("../connect.php");
// Check connection
if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}	

	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysqli_real_escape_string($str);
	}
	
	//Sanitize the POST values
	$login = $_POST['phone'];
	$password = $_POST['password'];
	
	//Input Validations
	if($login == '') {
		$errmsg_arr[] = 'Phone number missing';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}

	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: index.php");
		exit();
	}
	
	//Create query
$sql = "SELECT * FROM customers WHERE c_phone=:login AND c_delete=0";
$query = $link -> prepare($sql);
$query -> bindParam(':login',$login, PDO::PARAM_STR);
$query->execute();
$result=$query->fetchAll(PDO::FETCH_OBJ);

	//Check whether the query was successful or not
	if($query){
        if($query->rowCount() > 0)
        {
        foreach($result as $results) {
            if(password_verify($password, $results->password)){
            //Login Successful
            $_SESSION['c_id'] = $results->c_id;
            session_write_close();
            header("location: index.php");
            exit();
        }else{
                $errmsg_arr[] = 'Password is Wrong.';
                $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
                session_write_close();
                header("location: index.php");
                exit();
            }
        }
		}else {
            $errmsg_arr[] = 'Phone number is Wrong.';
            $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
            session_write_close();
			//Login failed
			header("location: index.php");
			exit();
		}
	}else {
		die("Query failed");
	}
?>