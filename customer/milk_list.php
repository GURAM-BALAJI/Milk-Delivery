<!DOCTYPE html>
<html>
<head>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <link rel="stylesheet" href="style_nav_bar.css">

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
<body >
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <center>
    <div style="background-color: #333;">
        <table><tr>
                <th>
                    <img src="logo.png" width="100%" height="70px">
                </th>
            </tr></table>
    </div>
    <div style="background-color: #001a35;color: #89E6C4;"> LIST </div>
</center>
  <?php
    session_start();
include('../connect.php');
    if(isset($_POST['submit'])){
        $c_id=$_SESSION['c_id'];
        $starting_date=$_POST['start_date'];
        $ending_date=$_POST['end_date'];
        $starting_date=strtotime($starting_date);
        $ending_date=strtotime($ending_date);
        ?>
	<div class="table-responsive">
		<table id="dataTable" class="table table-striped">
            <?php
            $sql = "select * from customers where c_id=:id";
            $query = $link->prepare($sql);
                $query->bindParam(':id', $c_id, PDO::PARAM_STR);
            $query ->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
        $inc=1;
            if($query->rowCount() > 0)
                foreach($results as $result){
                ?>

                    <?php } ?>
                <thead>
                <th>#</th>
                <th>Date</th>
                <th>Quantity</th>
                </thead>
                <tbody>
                <?php
                $total=0;
                for ($i=$starting_date; $i<=$ending_date; $i+=86400) {
                    $date=date("Y-m-d", $i);
                    echo '<td>'.$inc++.'</td>';
                    echo '<td>'.$date.'</td>';
                    $sql1 = "select * from delivery where d_c_id=:id AND DATE(d_date)=:date";
                    $query1 = $link->prepare($sql1);
                    $query1->bindParam(':date', $date, PDO::PARAM_STR);
                    $query1->bindParam(':id', $c_id, PDO::PARAM_STR);
                    $query1->execute();
                    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                    if ($query1->rowCount() > 0) {
                        foreach ($results1 as $result1) {
                            $total+=$result1->liters;
                            if($result1->liters!=0)
                                echo '<td>' . $result1->liters . '</td>';
                            else
                                echo "<td style='color:#ff0000;'>Not-Taken</td>";
                        }
                    }else
                        echo '<td> </td>';
                    echo "</tr>";
                }
                ?>
                <thead>
                <tr>
                    <th colspan="2">Total: </th>
                    <th><?php echo $total; ?></th>
                </tr>
                </thead>
                </tbody>
		</table>
        <?php }else{
        header("location: account.php");
        } ?>
	</div>
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
</body>
</html>