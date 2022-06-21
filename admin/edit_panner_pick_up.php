<?php
session_start();
if(isset($_SESSION['post'])) {
    if ($_SESSION['post'] == "delivery")
        header("location: ../delivery/");

}else
    header("location: ../index.php");

include('../connect.php');
// Code for change password
if(isset($_POST['submit']))
{
    try {
        $id=$_GET['id'];
        $date=$_POST['date'];
        $name=$_POST['delivery'];
        $qty=$_POST['qty'];
        $sql = " update panner_pick set pp_name=:name,pp_qty=:qty,pp_date=:date where pp_id=:id";
        $query = $link->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':date', $date, PDO::PARAM_STR);
        $query->bindParam(':qty', $qty, PDO::PARAM_STR);
        $query->execute();
        $msg = "Updated successfully";
    }catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
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
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
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

                    <h2 class="page-title">Edit panner Pick_Up</h2>

                    <div class="row">
                        <div class="col-md-10">
                            <div class="panel panel-default">
                                <div class="panel-heading">panner Pick_up fields</div>
                                <div class="panel-body">
                                    <form class="form-group-lg" method="post">

                                        <?php if(isset($error)){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                                        else if(isset($msg)){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

                                        <?php
                                        $id=$_GET['id'];
                                        $ret="select * from panner_pick where pp_id=:id";
                                        $query= $link -> prepare($ret);
                                        $query->bindParam(':id',$id, PDO::PARAM_STR);
                                        $query-> execute();
                                        $results = $query -> fetchAll(PDO::FETCH_OBJ);
                                        if($query -> rowCount() > 0)
                                        {
                                        foreach($results as $result)
                                        {
                                        ?>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Date :</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control"  name="date" id="date" value="<?php echo htmlentities($result->pp_date);?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">NO of Kg's of panner Picked Today :</label>
                                            <div class="col-sm-8">
                                                <input type="text" autocomplete="on" class="form-control"  name="qty" id="qty" value="<?php echo htmlentities($result->pp_qty);?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Picked By Whom:</label>
                                            <div class="col-sm-8">
                                                <select name="delivery" id="delivery" class="form-control-static" required>
                                                    <option value="<?php echo htmlentities($result->pp_name);?>"><?php echo htmlentities($result->pp_name);?></option>
                                                    <?php
                                                    $sql6 ="SELECT * from login";
                                                    $query6 = $link -> prepare($sql6);
                                                    $query6->execute();
                                                    $results6=$query6->fetchAll(PDO::FETCH_OBJ);
                                                    if($query6->rowCount() > 0)
                                                        foreach($results6 as $result)
                                                            if($result->post!="admin")
                                                                echo "<option value='$result->username'>".$result->username."</option>";
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="submit" class="form-control-static" name="submit" id="submit" value=" Submit ">
                                        </div>
                                    </form>
                                    <?php } } ?>
                                </div>
                            </div>
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