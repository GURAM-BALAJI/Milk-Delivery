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
        <table>
            <tr>
                <th>
                    <img src="logo.png" width="100%" height="70px">
                </th>
            </tr>
        </table>
    </div>
    <div style="background-color: #001a35;color: #89E6C4;"> ACCOUNT </div>
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
    <div class="col-md-12">
<?php
    $id=$_SESSION['c_id'];
    $stmt = $link->prepare("SELECT c_amount,c_id FROM customers WHERE c_delete = '0' AND c_id = :id ");
    $stmt->bindParam(':id',$id, PDO::PARAM_STR);
    $stmt->execute();
    $stmt = $stmt -> fetchAll(PDO::FETCH_OBJ);
    foreach($stmt as $row){?>
        <br>
       <section class="content">
        <div class="modal-content">
            <div class="modal-body">
<center><h2>Your Balance Liters:</h2><h1 style="color:green;"><?php echo htmlentities($row->c_amount); ?></h1>
   </center> </div></div>
           </section>
   <hr>
    

                    <center><h4 class="page-title">Delivery List</h4></center>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"></div>
                                <div class="panel-body">
                    <form class="form-group-lg" action="milk_list.php" method="post">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Starting Date :</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control"  name="start_date" id="start_date" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Ending Date :</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="end_date" id="end_date" required>
                            </div>
                        </div>
                            <div class="col-sm-8">
                        <input type="submit" class="form-control-static" name="submit" id="submit" value=" Submit ">
                            </div>
                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php } ?>
   
<br><br><br><br>
<nav class="nav">

    <a href="qr.php" class="nav__link ">
        <i class="material-icons nav__icon">qr_code_scanner</i>
        <span class="nav__text">QR</span>
    </a>

    <a href="account.php" class="nav__link nav__link--active">
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
