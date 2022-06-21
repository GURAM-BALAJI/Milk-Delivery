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
    try {
       // $m_sms=$_POST['m_sms'];
        //$u_sms=$_POST['u_sms'];
        $d_sms=$_POST['d_sms'];
        if(isset($_POST['on_off']))
        $no_off=1;
        else
        $no_off=0;    
        
            //$sql = " update sms set m_sms=:m_sms, u_sms=:u_sms, d_sms=:d_sms where sms_id=1";
        $sql = " update sms set d_sms=:d_sms,sms_on_off=:no_off where sms_id=1";
            $query = $link->prepare($sql);
        //$query->bindParam(':m_sms', $m_sms, PDO::PARAM_STR);
        //$query->bindParam(':u_sms', $u_sms, PDO::PARAM_STR);
        $query->bindParam(':d_sms', $d_sms, PDO::PARAM_STR);
        $query->bindParam(':no_off', $no_off, PDO::PARAM_STR);
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

                    <h2 class="page-title">SMS</h2>

                    <div class="row">
                        <div class="col-md-10">
                            <div class="panel panel-default">
                                <div class="panel-heading">Delivery SMS </div>
                                <div class="panel-body">
                                    <form class="form-group-lg" method="post">
                                        <?php if(isset($error)){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                                        else if(isset($msg)){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

                                        <?php
                                        $ret="select * from sms";
                                        $query= $link -> prepare($ret);
                                        $query-> execute();
                                        $results = $query -> fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        foreach($results as $result)
                                        {
                                        ?>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Milk Delivery SMS :</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control"  name="d_sms" id="d_sms" rows="4" cols="50"><?php echo $result->d_sms;?></textarea>
                                            </div>
                                             <label class="col-sm-4 control-label">SMS ON OR OFF :</label>
                                            <div class="col-sm-8">
                                                <input type="checkbox" name="on_off" <?php if($result->sms_on_off==1) echo 'checked'; ?> >
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="submit" class="form-control-static" name="submit" id="submit" value=" Submit ">
                                        </div>
                                        <?php }?>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

