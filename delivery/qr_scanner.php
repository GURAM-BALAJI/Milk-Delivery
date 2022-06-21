<?php
session_start();
if(isset($_SESSION['post'])){
    if ($_SESSION['post'] == "admin")
        header("location: ../admin/");
    elseif($_SESSION['post'] != "delivery")
        header("location: ../index.php");
}else
    header("location: ../index.php");
include('../connect.php');
if(isset($_POST['submit']))
{
    $c_id=$_POST['c_id'];
     $sql7="select c_amount from customers where c_id=:c_id AND c_amount>=-5";
        $query7=$link->prepare($sql7);
        $query7->bindParam(':c_id', $c_id, PDO::PARAM_STR);
        $query7->execute();
        if($query7->rowCount() != 0){
    $today=date("Y-m-d");   
    $sql2="select d_id from delivery where d_date=:today AND d_c_id=:c_id";
        $query2=$link->prepare($sql2);
        $query2->bindParam(':today', $today, PDO::PARAM_STR);
        $query2->bindParam(':c_id', $c_id, PDO::PARAM_STR);
        $query2->execute();
        if($query2->rowCount() == 0){
  $c_phone=$_POST['phone'];
            $c_name=$_POST['name'];
    $extra=floatval($_POST['extra']);
    $liters=floatval($_POST['liters']);
    $remark=$_POST['remark'];
    $update_by=$_SESSION['name'];
   $liters = floatval($extra)+floatval($liters);
        $sql = "insert into delivery(liters,d_c_id,d_date,add_by,remark) value (:liters,:id,:today,:add_by,:remark)";
        $query = $link->prepare($sql);
        $query->bindParam(':liters', $liters, PDO::PARAM_STR);
        $query->bindParam(':id', $c_id, PDO::PARAM_STR);
         $query->bindParam(':add_by', $update_by, PDO::PARAM_STR);
        $query->bindParam(':today', $today, PDO::PARAM_STR);
        $query->bindParam(':remark', $remark, PDO::PARAM_STR);
        $query->execute();
            
        $sql2="select * from customers where c_id=:c_id";
        $query2=$link->prepare($sql2);
        $query2->bindParam(':c_id', $c_id, PDO::PARAM_STR);
        $query2->execute();
        $results2=$query2->fetchAll(PDO::FETCH_OBJ);
        if($query2->rowCount() != 0){
             foreach($results2 as $row){
                 $c_amount=$row->c_amount;
                 $c_amount=floatval($c_amount)-floatval($liters);
             $stmt=$link->prepare("UPDATE customers SET c_amount=:c_amount WHERE c_id=:id");
				$stmt->execute(['c_amount'=>$c_amount, 'id'=>$c_id]);
             }
        }
            
        $sql1="select d_sms from sms where sms_id=1";
        $query6= $link -> prepare($sql1);
        $query6->execute();
        $results6=$query6->fetchAll(PDO::FETCH_OBJ);
        if($query6->rowCount() > 0)
        foreach($results6 as $result)
            $sms=$result->d_sms;
    $sms=str_replace('$name',$c_name,$sms);
    $sms=str_replace('$liters',$liters,$sms);
    $msg = urlencode('www.tools4noobs.com/dsaf');
 $sms = urlencode(htmlspecialchars($sms));
 $username ="aahara"; //use your sms api username
 $pass = "aahara123"; //enter your password
 $senderid ="AAHARA";//BTOYOU use your sms api sender id
 $priority ="ndnd";//BTOYOU use your sms api sender id
 $stype = "normal";//BTOYOU use your sms api sender id
        $sms_url =sprintf("http://bhashsms.com/api/sendmsg.php?user=%s&pass=%s&sender=%s&phone=%u&text=%s&priority=%s&stype=%s",$username,$pass,$senderid,$c_phone,$sms,$priority,$stype);
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$sms_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_TIMEOUT, '3');
    $content = trim(curl_exec($ch));
    curl_close($ch);
    $msg = "Delivered successfully.. ";
}else
$error="Alredy added..!";
}else{
$error="You have not recharged!";   
        }}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="wlogin_idth=device-wlogin_idth, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <link rel="shortcut icon" href="assets/images/favicon-icon/logo.png">
    <title>AaharaMilk</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('a[rel*=facebox]').facebox({
                loadingImage : 'src/loading.gif',
                closeImage   : 'src/closelabel.png'
            })
        })
    </script>

    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px sollogin_id #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px sollogin_id #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>

</head>

<body>
<?php include('includes/header.php');?>
<div class="ts-main-content">
    <?php include('includes/leftbar.php');?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Zero Configuration Table -->
                    <div class="panel panel-default" style="overflow-x:auto;">
                        <div class="panel-heading">customers Details</div>
                        <div class="panel-body">
                            <?php if(isset($error)){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                            else if(isset($msg)){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                            <form method="post" name="chngpwd" class="form-horizontal" >
                                  <?php
                                if(isset($_GET['qr_code'])){
                                        $qr=$_GET['qr_code'];
                                        $ret="select * from qr_scan_data left join customers on c_id=qr_c_id where qr_id=:qr";
                                        $query= $link -> prepare($ret);
                                        $query->bindParam(':qr',$qr, PDO::PARAM_STR);
                                        $query-> execute();
                                        $results = $query -> fetchAll(PDO::FETCH_OBJ);
                                        if($query -> rowCount() > 0)
                                        {
                                            foreach($results as $result)
                                            {
                                                ?>
                <input type="hidden" class="form-control" name="c_id" id="c_id"  value="<?php echo htmlentities($result->c_id);?>">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Customer Name :</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="name" id="name" required value="<?php echo htmlentities($result->c_name);?>" onfocus="this.blur()">
                                                    </div></div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Phone :</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="phone" id="phone" required value="<?php echo htmlentities($result->c_phone);?>" onfocus="this.blur()">
                                                    </div>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Liters :</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="liters" id="liters" required value="<?php echo htmlentities($result->c_liters);?>" onfocus="this.blur()">
                                                    </div></div>
                                  <div class="form-group">
                                                    <label class="col-sm-2 control-label">Extra Liters :</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="extra" id="extra">
                                                    </div></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Remark :</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="remark" id="remark">
                                                    </div></div>
                                                <div class="hr-dashed"></div>
                                             
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-4">
                                                <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                            </div>
                                        </div>
                                 <?php } }else{?>
                               <h1>Qr Code You have scanned is Wrong !</h1>
                            <?php } ?>
                                    </form>
                           <?php }else{?>
                               <h1> You didn't scanned " QR CODE " !</h1>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Loading Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/Chart.min.js"></script>
<script src="js/fileinput.js"></script>
<script src="js/chartData.js"></script>
<script src="js/main.js"></script>
</body>
</html>
