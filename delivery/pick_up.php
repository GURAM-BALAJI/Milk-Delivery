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
    $today=date("Y-m-d");
    if(isset($_SESSION['name']))
    $name=$_SESSION['name'];
    else
    header("location: ../logout.php");
    $one_milk=$_POST['one_milk'];
    $half_milk=$_POST['half_milk'];
    $sql2="select p_id from pick where p_date=:today AND p_name=:name";
    $query2=$link->prepare($sql2);
    $query2->bindParam(':today', $today, PDO::PARAM_STR);
    $query2->bindParam(':name', $name, PDO::PARAM_STR);
    $query2->execute();
    $results2=$query2->fetchAll(PDO::FETCH_OBJ);
    if($query2->rowCount() < 2)
    {
        $sql="INSERT INTO pick(p_date,p_one_liters,p_half_liters,p_name) value(:today,:one_milk,:half_milk,:name)";
        $query=$link->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':today', $today, PDO::PARAM_STR);
        $query->bindParam(':one_milk', $one_milk, PDO::PARAM_STR);
        $query->bindParam(':half_milk', $half_milk, PDO::PARAM_STR);
        $query->execute();
        $msg = "Picked Add Successfully ... ";
    }else{
        $error="You have already entered...";
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
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>

</head>

<body>
<body>
<?php include('includes/header.php');?>
<div class="ts-main-content">
    <?php include('includes/leftbar.php');?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php if(isset($error)){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                    else if(isset($msg)){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                    <h2 class="page-title">Add Milk Picked</h2>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form class="form-group-lg" method="post">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">NO of One Liters Milk Bottles Picked Today :</label>
                                            <div class="col-sm-8">
                                                <input type="text" autocomplete="on" class="form-control"  name="one_milk" id="one_milk" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">NO of Half Liters Milk Bottles Picked Today :</label>
                                            <div class="col-sm-8">
                                                <input type="text" autocomplete="on" class="form-control"  name="half_milk" id="half_milk" required>
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
            </div>
        </div>
    </div>

<center>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-primary text-light">
                                            <div class="stat-panel text-center">
                                                <?php
                                                $query=0;
                                                date_default_timezone_set('Asia/Kolkata');
                                                $today=date("Y-m-d");
                                                $name=$_SESSION['name'];
                                                $sql6 ="SELECT liters from delivery where d_date=:today AND add_by=:name";
                                                $query6 = $link -> prepare($sql6);
                                                $query6->bindParam(':today', $today, PDO::PARAM_STR);
                                                $query6->bindParam(':name', $name, PDO::PARAM_STR);
                                                $query6->execute();
                                                $results6=$query6->fetchAll(PDO::FETCH_OBJ);
                                                if($query6->rowCount() > 0)
                                                    foreach($results6 as $result)
                                                        $query+=$result->liters;
                                                $milk_compare=$query;
                                                ?>
                                                <div class="stat-panel-number h1 "><?php echo htmlentities($query);?></div>
                                                <div class="stat-panel-title text-uppercase">Total Liters deliveried Today</div>
                                            </div>
                                        </div>
                                        <a href="edit_delivery.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                                                <?php
                                                $query=0.000;
                                                $one=$half=0;
                                                date_default_timezone_set('Asia/Kolkata');
                                                $today=date("Y-m-d");
                                                $name=$_SESSION['name'];
                                                $sql6 ="SELECT p_one_liters,p_half_liters from pick where p_date=:today AND p_name=:name";
                                                $query6 = $link -> prepare($sql6);
                                                $query6->bindParam(':today', $today, PDO::PARAM_STR);
                                                $query6->bindParam(':name', $name, PDO::PARAM_STR);
                                                $query6->execute();
                                                $results6=$query6->fetchAll(PDO::FETCH_OBJ);
                                                if($query6->rowCount() > 0)
                                                    foreach($results6 as $result) {
                                                        $one+= $result->p_one_liters;
                                                        $half+= $result->p_half_liters;
                                                    }
                                                $half=$half/2;
                                                $query=$one+$half;
                                                ?>
                                <div class="col-md-3">
                                    <div class="panel panel-default">
                                        <?php if($milk_compare==$query){ ?>
                                        <div class="panel-body bk-success text-light">
                                            <?php }else{?>
                                            <div class="panel-body bk-danger text-light">
                                                <?php } ?>
                                                <div class="stat-panel text-center">
                                                <div class="stat-panel-number h1 "><?php echo htmlentities($query);?></div>
                                                <div class="stat-panel-title text-uppercase">Total Liters Picked Today</div>
                                            </div>
                                        </div>
                                        <a class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</center>
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
