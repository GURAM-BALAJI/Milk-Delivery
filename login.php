<?php
//Start session
session_start();

//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;
include("connect.php");
// Check connection
if (!$link) {
	die("Connection failed: " . mysqli_connect_error());
}

//Function to sanitize values received from the form. Prevents SQL injection
function clean($str)
{
	$str = @trim($str);
	if (get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	return mysqli_real_escape_string($str);
}

//Sanitize the POST values
if (isset($_POST['username']))
	$login = $_POST['username'];
if (isset($_POST['password']))
	$password = $_POST['password'];

//Input Validations
if (isset($_POST['username']))
if ($login == '') {
	$errmsg_arr[] = 'Username missing';
	$errflag = true;
}
if (isset($_POST['password']))
if ($password == '') {
	$errmsg_arr[] = 'Password missing';
	$errflag = true;
}

//If there are input validations, redirect back to the login form
if ($errflag) {
	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
	session_write_close();
	header("location: index.php");
	exit();
}

//Create query
$sql = "SELECT * FROM login WHERE username=:login AND login_delete=0";
$query = $link->prepare($sql);
$query->bindParam(':login', $login, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_OBJ);

//Check whether the query was successful or not
if ($query) {
	if ($query->rowCount() > 0) {
		foreach ($result as $results) {
			if (password_verify($password, $results->password)) {
				//Login Successful
				$_SESSION['name'] = $results->username;
				$id = $_SESSION['login_id'] = $results->login_id;
				$_SESSION['post'] = $results->post;
				$_SESSION['root'] = $results->root;
				if ($_SESSION['post'] == "delivery") {
					date_default_timezone_set('Asia/Kolkata');
					$now = date('d-m-Y h:i:s a');
					$today = date("Y-m-d");
					$sql = "insert into login_timeings(lt_date,lt_time,lt_login_id) value (:lt_date,:lt_time,:lt_login_id)";
					$query = $link->prepare($sql);
					$query->bindParam(':lt_date', $today, PDO::PARAM_STR);
					$query->bindParam(':lt_time', $now, PDO::PARAM_STR);
					$query->bindParam(':lt_login_id', $id, PDO::PARAM_STR);
					$query->execute();
				}
				session_write_close();
				header("location: index.php");
				exit();
			} else {
				$errmsg_arr[] = 'Password is Wrong.';
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
				session_write_close();
				header("location: index.php");
				exit();
			}
		}
	} else {
		$errmsg_arr[] = 'Username is Wrong.';
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		//Login failed
		header("location: index.php");
		exit();
	}
} else {
	die("Query failed");
}
