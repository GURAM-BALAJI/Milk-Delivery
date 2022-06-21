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
{
    $c_id=$_GET['id'];
    $num=$_GET['num']; 
    $remark='remark'.$num;
    $remark=$_POST[$remark]; 
    $update_by=$_SESSION['name'];
    $liters='liters'.$num;
    $liters=$_POST[$liters];
    if($liters!="") {
        $sql = "update delivery set liters=:liters, add_by=:add_by, remark=:remark where d_id=:id";
        $query = $link->prepare($sql);
        $query->bindParam(':liters', $liters, PDO::PARAM_STR);
        $query->bindParam(':add_by', $update_by, PDO::PARAM_STR);
        $query->bindParam(':id', $c_id, PDO::PARAM_STR);
        $query->bindParam(':remark', $remark, PDO::PARAM_STR);
        $query->execute();
        $msg = "Delivery updated successfully.. ";
    }else{
        $error="Liters should not be empty, but give has 0 if they didnt take milk.";
    }
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

                    <h2 class="page-title">Edit deliery</h2>
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
                                    <th>Address</th>
                                    <th>Deliveried By</th>
                                    <th>Liters</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                 date_default_timezone_set('Asia/Kolkata');
                                    if(isset($_GET['submit']))
                                    $today=$_GET['date'];
                                else
                                    $today=date("Y-m-d");
                                $sql = "SELECT customers.c_id,customers.c_address,delivery.remark,delivery.add_by,customers.c_phone,customers.c_name,delivery.liters,delivery.d_id,delivery.d_c_id from customers join delivery on delivery.d_c_id=customers.c_id where delivery.d_date=:today";
                                $query = $link -> prepare($sql);
                                $query->bindParam(':today', $today, PDO::PARAM_STR);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0)
                                {
                                    $cnt=1;
                                    foreach($results as $result)
                                    {?>
                                            <tr>
                                                <td><?php echo htmlentities($result->c_id);?></td>
                                                <td><?php echo htmlentities($result->c_name);?></td>
                                                <td><?php echo htmlentities($result->c_phone);?></td>
                                                <td><?php echo htmlentities($result->c_address);?></td>
                                                <td><?php echo htmlentities($result->add_by);?></td>
                                                <td><form method="post" action="edit_delivery.php?id=<?php echo $result->d_id;?>&num=<?php echo $cnt;?>" >
                                                        <input type="text" name="liters<?php echo $cnt; ?>" id="liters<?php echo $cnt; ?>" size="3" value="<?php echo $result->liters;?>">
                                                        <input type="text" name="remark<?php echo $cnt; ?>" id="remark<?php echo $cnt; ?>" value="<?php echo $result->remark;?>" placeholder="remarks..">
                                                        <input type="submit" name="submit" value="submit">
                                                    </form></td>
                                            </tr>
                                            <?php $cnt++; }} ?>

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
