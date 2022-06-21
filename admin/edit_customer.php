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
        $phone = $_POST['phone'];
        $id = $_GET['id'];
        $sql1 = "SELECT * FROM customers WHERE c_phone=:phone AND c_id!=:id  AND c_delete=0";
        $query1 = $link->prepare($sql1);
        $query1->bindParam(':phone', $phone, PDO::PARAM_STR);
        $query1->bindParam(':id', $id, PDO::PARAM_STR);
        $query1->execute();
        if($query1->rowCount() == 0) {
            $name = $_POST['name'];
            $nid = strtoupper($_POST['id']);
            $liters = floatval($_POST['liters']);
            $address = $_POST['address'];
            $password = $_POST['password'];
            $password = password_hash($password, PASSWORD_BCRYPT);
            $sql = " update customers set password=:password, c_name=:name, c_phone=:phone, c_liters=:liters, c_address=:address ,c_id=:nid where c_id=:id";
            $query = $link->prepare($sql);
            $query->bindParam(':name', $name, PDO::PARAM_STR);
            $query->bindParam(':phone', $phone, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->bindParam(':nid', $nid, PDO::PARAM_STR);
            $query->bindParam(':address', $address, PDO::PARAM_STR);
            $query->bindParam(':liters', $liters, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->execute();
            $msg = "Updated successfully";
            $id = $_GET['id']=$nid;
            header("location:edit_customer.php?id=$id");
        }else {
            $error ="Phone number already taken...!";
        }
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

                    <h2 class="page-title">Edit customer</h2>

                    <div class="row">
                        <div class="col-md-10">
                            <div class="panel panel-default">
                                <div class="panel-heading">customer fields</div>
                                <div class="panel-body">
                                    <form method="post" name="chngpwd" class="form-horizontal" onSubmit="return valid();">
                                        <?php if(isset($error)){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                                        else if(isset($msg)){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

                                        <?php
                                        $id=$_GET['id'];
                                        $ret="select * from customers where c_id=:id";
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
                                                    <label class="col-sm-2 control-label">Customer Id :</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="id" id="id" required value="<?php echo htmlentities($result->c_id);?>">
                                                    </div></div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Customer Name :</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="name" id="name" required value="<?php echo htmlentities($result->c_name);?>">
                                                    </div></div>
                                           <div class="form-group">
                                                    <label class="col-sm-2 control-label">Password :</label>
                                                    <div class="col-sm-8">
                                                        <input type="password" class="form-control" name="password" id="password" required value="<?php echo htmlentities($result->password);?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Phone :</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="phone" id="phone" required value="<?php echo htmlentities($result->c_phone);?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Customer Address :</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="address" id="address" required value="<?php echo htmlentities($result->c_address);?>">
                                                    </div></div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Liters :</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="liters" id="liters" required value="<?php echo htmlentities($result->c_liters);?>">
                                                    </div></div>
                                                <div class="hr-dashed"></div>
                                            <?php }} ?>
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-4">

                                                <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </div></div>

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
