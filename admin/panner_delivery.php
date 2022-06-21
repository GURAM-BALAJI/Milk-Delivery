<?php
session_start();
if(isset($_SESSION['post'])) {
    if ($_SESSION['post'] == "delivery")
        header("location: ../delivery/");

}else
    header("location: ../index.php");

include('../connect.php');
if(isset($_POST['submit']))
{
    if(isset($_GET['id']))
        $c_id=$_GET['id'];
    else
        $today=date("Y-m-d");
    $num=$_GET['num'];
    $update_by=$_SESSION['name'];
    $qty='qty'.$num;
    $qty=$_POST[$qty];
    $remark='remark'.$num;
    $remark=$_POST[$remark];
    $phone='phone'.$num;
    $phone=$_POST[$phone];
    $address='address'.$num;
    $address=$_POST[$address];
    $name='name'.$num;
    $name=$_POST[$name];
    if($qty!="") {
        if(isset($c_id))
            $sql = "update panner_delivery set pd_name=:name , pd_phone=:phone , pd_address=:address , pd_qty=:qty , panner_add_by=:add_by, pd_remark=:remark where pd_id=:id";
        else
            $sql = "insert into panner_delivery(pd_name,pd_phone,pd_address,pd_qty,panner_add_by,pd_remark,pd_date) value (:name,:phone,:address,:qty,:add_by,:remark,:today)";
        $query = $link->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':phone', $phone, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':qty', $qty, PDO::PARAM_STR);
        $query->bindParam(':remark', $remark, PDO::PARAM_STR);
        $query->bindParam(':add_by', $update_by, PDO::PARAM_STR);
        if(!isset($c_id))
            $query->bindParam(':today', $today, PDO::PARAM_STR);
        else
            $query->bindParam(':id', $c_id, PDO::PARAM_STR);
        $query->execute();
        if(isset($c_id))
            $msg = "Delivery updated successfully.. ";
        else
            $msg = "Delivery Add successfully.. ";
    }else{
        $error="Qty should not be empty, but give has 0 , if they didnt take panner.";
    }
}
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

                    <h2 class="page-title">panner deliery</h2>
                    <!-- Zero Configuration Table -->
                    <div class="panel panel-default" style="overflow-x:auto;">
                        <div class="panel-heading">delivery Details</div>
                        <form method="get">
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <input type="date" class="form-control"  name="date" id="date" required>
                                </div>

                                <div class="col-sm-4">
                                    <input type="submit" class="form-control-static" name="submit" id="submit" value=" Submit ">
                                </div>
                            </div>
                        </form>
                        <div class="panel-body">
                            <?php if(isset($error)){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                            else if(isset($msg)){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <td>Address</td>
                                    <th>Kg's</th>
                                    <th>Remark</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                date_default_timezone_set('Asia/Kolkata');
                                if(isset($_GET['submit']))
                                    $today=$_GET['date'];
                                else
                                    $today=date("Y-m-d");
                                $sql = "SELECT * from panner_delivery where pd_date=:today";
                                $query = $link -> prepare($sql);
                                $query->bindParam(':today', $today, PDO::PARAM_STR);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $cnt=1;
                                if($query->rowCount() > 0)
                                {
                                    foreach($results as $result)
                                    {
                                        ?>
                                        <tr>
                                            <form method="post" action="panner_delivery.php?id=<?php echo $result->pd_id;?>&num=<?php echo $cnt;?>" >
                                                <td><?php echo $cnt; ?></td>
                                                <td><input type="text" name="name<?php echo $cnt; ?>" id="name<?php echo $cnt; ?>" value="<?php echo $result->pd_name;?>"></td>
                                                <td><input type="text" name="phone<?php echo $cnt; ?>" id="phone<?php echo $cnt; ?>" value="<?php echo $result->pd_phone;?>"></td>
                                                <td><input type="text" name="address<?php echo $cnt; ?>" id="address<?php echo $cnt; ?>" value="<?php echo $result->pd_address;?>"></td>
                                                <td><input type="text" name="qty<?php echo $cnt; ?>" id="qty<?php echo $cnt; ?>" size="3" value="<?php echo $result->pd_qty;?>"></td>
                                                <td><input type="text" name="remark<?php echo $cnt; ?>" id="remark<?php echo $cnt; ?>" value="<?php echo $result->pd_remark;?>"></td>
                                                <td><input type="submit" name="submit" value="submit"></td>
                                            </form>
                                        </tr>
                                        <?php $cnt=$cnt+1; }} ?>
                                <tr>
                                    <form method="post" action="panner_delivery.php?num=<?php echo $cnt;?>" >
                                        <td><?php echo $cnt; ?></td>
                                        <td><input type="text" name="name<?php echo $cnt; ?>" id="name<?php echo $cnt; ?>"></td>
                                        <td><input type="text" name="phone<?php echo $cnt; ?>" id="phone<?php echo $cnt; ?>"></td>
                                        <td><input type="text" name="address<?php echo $cnt; ?>" id="address<?php echo $cnt; ?>"></td>
                                        <td><input type="text" name="qty<?php echo $cnt; ?>" id="qty<?php echo $cnt; ?>" size="3"></td>
                                        <td><input type="text" name="remark<?php echo $cnt; ?>" id="remark<?php echo $cnt; ?>"></td>
                                        <td><input type="submit" name="submit" value="submit"></td>
                                    </form>
                                </tr>
                                </tbody>
                            </table>
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
