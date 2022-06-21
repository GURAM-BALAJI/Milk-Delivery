<!DOCTYPE html>
<?php
include 'includes/session.php';
include 'includes/header.php';
if(!isset($_SESSION['c_id']))
     header("location: index.php");
?>
<html lang="en" >
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="./style_nav_bar.css">

</head>
<style>
    body{
        background-color: #cfcfd2;
    }

    hr{
        display: block;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
        margin-left: auto;
        margin-right: auto;
        border-style: dot-dot-dash;
        border-width: 2px;
        color: #0E2231;
        width: 98%;
    }
    h3{
        margin-left:10px;
    }
    .hr_last {
        border-style: dot-dash;
        border-width: 4px;
        color: #181914;
        width: 98%;
    }
    div.scrollmenu {
        background-color: #333;
        overflow: auto;
        white-space: nowrap;
    }

    div.scrollmenu a {
        display: inline-block;
        text-align: center;
        padding: 14px;
        color: white;
        text-decoration: none;
        text-decoration-color: snow;
    }
    .back_ground{
        background-color: #777;
    }
    div.scrollmenu a:hover {
        background-color: #777;
        
    }
    	.qr-code { 
	width: 98%; 
    margin-top: 15%; 
	}
</style>
<body>
<!-- partial:index.partial.html -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<center>
    <div style="background-color: #333;">
        <table><tr>
                <th>
                    <img src="logo.png" width="100%" height="70px">
                </th>
            </tr></table>
    </div>
    <div style="background-color: #001a35;color: #89E6C4;"> QR CODE </div>
</center>
    <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
<div class="container-fluid"> 
	<div class="text-center"> 
<h4><u>Scan QR Code</u></h4>
        <?php 
        $url='http://www.aaharamilk.com/delivery/qr_scanner.php?qr_code=';
        $id=$_SESSION['c_id'];
    while(1){
    $qr=uniqid();
    $stmt1 = $link->prepare("SELECT * FROM qr_scan_data WHERE qr_id = :qr ");
    $stmt1->bindParam(':qr',$qr, PDO::PARAM_STR);
    $stmt1->execute();
    if($stmt1->rowCount() > 0){
    continue;
    }else{
    break; 
    }
    }
    $stmt = $link->prepare("SELECT * FROM qr_scan_data WHERE qr_c_id = :id ");
    $stmt->bindParam(':id',$id, PDO::PARAM_STR);
    $stmt->execute();
    if($stmt->rowCount() > 0)
    {
       // $stmt = $link->prepare("UPDATE qr_scan_data SET qr_id=:qr_id WHERE qr_c_id=:id");
			//	$stmt->execute(['qr_id'=>$qr, 'id'=>$id]);
    }else{
        $sql = "INSERT INTO qr_scan_data(qr_c_id,qr_id) VALUES(:qr_c_id,:qr_id)";
            $query = $link->prepare($sql);
            $query->bindParam(':qr_c_id', $id, PDO::PARAM_STR);
            $query->bindParam(':qr_id', $qr, PDO::PARAM_STR);
            $query->execute();
    }
        $url=$url.$qr;
        ?>
	<img src= "https://chart.googleapis.com/chart?cht=qr&chl=<?php echo $url;?>&chs=160x160&chld=L|0"
		class="qr-code img-thumbnail img-responsive" /> 
	</div> 
</div> 
<br><br><br><br>
<nav class="nav">

    <a href="qr.php" class="nav__link nav__link--active">
        <i class="material-icons nav__icon">qr_code_scanner</i>
        <span class="nav__text">QR</span>
    </a>

    <a href="account.php" class="nav__link ">
        <i class="material-icons nav__icon">account_balance_wallet</i>
        <span class="nav__text">Wallet</span>
    </a>

    <a href="profile.php" class="nav__link ">
        <i class="material-icons nav__icon">person</i>
        <span class="nav__text">Profile</span>
    </a>

    <a href="settings.php" class="nav__link">
        <i class="material-icons nav__icon">settings</i>
        <span class="nav__text">Settings</span>
    </a>

</nav>
<!-- partial -->
 <?php include 'includes/scripts.php'; ?>
    <script>
$(function(){
  $(document).on('click', '.withdraw', function(e){
    e.preventDefault();
    $('#withdraw').modal('show');
  });
});
</script>
</body>
</html>
