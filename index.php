<?php
	//Start session
	session_start();
	if(isset($_SESSION['post'])) {
        if($_SESSION['post'] == "admin" || $_SESSION['post'] == "manager")
            header("location: admin/");
        elseif($_SESSION['post'] == "delivery")
            header("location: delivery/");
    }
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon-icon/logo.png">
    <title>AaharaMilk</title>
<style>
body{
  background-image: url(bg2.jpg);
  height: 100vh;
  background-size: cover;
  background-position: center;
}
.login-page{
  width: 360px;
  padding: 10% 0 0;
  margin: auto;
}
.form{
  position: relative;
  z-index: 1;
  background: rgba(7, 40, 195, 0.8);
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
}
.form input{
  font-family: "Roboto", sans-serif;
  outline: 1;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button{
  font-family: "Roboto", sans-serif;
text-transform: uppercase;
outline: 0;
background: #4CAF50;
width: 100%;
border: 0;
padding: 15px;
color: #FFFFFF;
font-size: 14px;
cursor: pointer;
}
    .submit:hover,.submit:active{
  background: #43A047;
}
.form .message{
  margin: 15px 0 0;
  color: aliceblue;
  font-size: 12px;
}
.form .message a{
  color: #4CAF50;
  text-decoration: none;
}
</style>
</head>
<body>
<div class="login-page">
    
  <div class="form">
      <h3>Admin Login</h3>
<form class="login-form" method="post" action="login.php" >
  <input type="text" placeholder="username" name="username"/>
  <input type="password" placeholder="password" name="password"/>
  <input class="submit" type="submit" name="submit" value="Login"/>
    <?php if(isset($_SESSION['ERRMSG_ARR'])){
        $error=$_SESSION['ERRMSG_ARR'];
        echo "<h4 style='color:red;font-family: \"Roboto\", sans-serif;'>";
    echo implode(', ', $error);
    echo "</h4>";
    } ?>
</form>
<?php $conn=null; unset($_SESSION['ERRMSG_ARR']); ?>
</div>
</div>
    <div id="header" style="color:white;text-align: right;  font-size: 20px; margin: 0px 0;"><b>Developed By:</b>G.Balaji<br>
        Gurmabalaji2000@gmail.com
</div>
</body>
</html>
