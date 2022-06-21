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
    <div style="background-color: #001a35;color: #89E6C4;"> SETTINGS </div>
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
    <br>
       <section class="content">
        <div class="modal-content">
            <div class="modal-body">
<center>
   <hr>
    <a href="logout.php"><button style="width:95%;height:50px;font-family:monospace;" ><i class="fa fa-sign-out" aria-hidden="true"></i> LOG_OUT</button></a><hr>
     <a href="developed by/developed_by.html"><button style="width:95%;height:50px;font-family:monospace;" ><i class="fa fa-commenting" aria-hidden="true"></i> Developed By</button></a><hr>
    
                </center>
            </div>
           </div>
    </section>
    <center>
        <br><br><h6>From:</h6>
    <a href="https://www.aahara.co.in/"><p><b>Aahara.co.in</b> </p></a>
        </center>
<br><br><br><br>
<nav class="nav">

    <a href="qr.php" class="nav__link ">
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

    <a href="settings.php" class="nav__link nav__link--active">
        <i class="material-icons nav__icon">settings</i>
        <span class="nav__text">Settings</span>
    </a>

</nav>
<!-- partial -->
</body>
</html>
