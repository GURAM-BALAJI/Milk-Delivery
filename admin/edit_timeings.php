<?php
session_start();
if(isset($_SESSION['post'])){
    if ($_SESSION['post'] == "delivery")
           header("location: ../delivery/");

}else
    header("location: ../index.php");
include('../connect.php');
$t_id=$_GET['id'];
if(isset($_POST['submit']))
{
    $t_in1=$_POST['t_in1'];
    $t_out1=$_POST['t_out1'];
    $t_in2=$_POST['t_in2'];
    $t_out2=$_POST['t_out2'];
    $t_in3=$_POST['t_in3'];
    $t_out3=$_POST['t_out3'];
    $petrol_out_readings=$_POST['petrol_out_readings'];
    $petrol_in_readings=$_POST['petrol_in_readings'];
    $petrol_filled=$_POST['petrol_filled'];
    $petrol_advance=$_POST['petrol_advance'];
        $sql = "UPDATE timeings set t_in1=:t_in1 ,t_in2=:t_in2 ,t_in3=:t_in3 ,t_out1=:t_out1 ,t_out2=:t_out2 ,t_out3=:t_out3, petrol_out_readings=:petrol_out_readings, petrol_in_readings=:petrol_in_readings, petrol_filled=:petrol_filled, petrol_advance=:petrol_advance where t_id=:id";
                $query = $link->prepare($sql);
                $query->bindParam(':t_in1', $t_in1, PDO::PARAM_STR);
                $query->bindParam(':t_in2', $t_in2, PDO::PARAM_STR);
                $query->bindParam(':t_in3', $t_in3, PDO::PARAM_STR);
                $query->bindParam(':t_out1', $t_out1, PDO::PARAM_STR);
                $query->bindParam(':t_out2', $t_out2, PDO::PARAM_STR);
                $query->bindParam(':t_out3', $t_out3, PDO::PARAM_STR);
                $query->bindParam(':petrol_out_readings', $petrol_out_readings, PDO::PARAM_STR);
                $query->bindParam(':petrol_in_readings', $petrol_in_readings, PDO::PARAM_STR);
                $query->bindParam(':petrol_filled', $petrol_filled, PDO::PARAM_STR);
                $query->bindParam(':petrol_advance', $petrol_advance, PDO::PARAM_STR);
                $query->bindParam(':id', $t_id, PDO::PARAM_STR);
                $query->execute();
        $msg = "Timeings Updated Successfully ... ";
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
                    <h2 class="page-title">Add Timeings</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form class="form-group-lg" method="post">
                                    <?php
                                             $sql = "SELECT * FROM timeings where t_id=:id";
                                             $query = $link -> prepare($sql);
                                             $query->bindParam(':id', $t_id, PDO::PARAM_STR);
                                             $query->execute();
                                             $results=$query->fetchAll(PDO::FETCH_OBJ);
                                             if($query->rowCount() > 0)
                                             {
                                             foreach($results as $result)
                                             {
                                    ?>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Timeings 1:</label>
                                            <div class="col-sm-5">
                                               <input type="time" class="form-control"  name="t_in1" value="<?php echo $result->t_in1;?>">
                                                 </div>
                                                 <div class="col-sm-5">
                                                  <input type="time" class="form-control"  name="t_out1"  value="<?php echo $result->t_out1;?>">
                                                  </div>
                                                  <div class="form-group">
                                                   <label class="col-sm-2 control-label">Timeings 2:</label>
                                                  <div class="col-sm-5">
                                               <input type="time"  class="form-control"  name="t_in2" value="<?php echo $result->t_in2;?>">
                                               </div>
                                               <div class="col-sm-5">
                                                 <input type="time"  class="form-control"  name="t_out2"  value="<?php echo $result->t_out2;?>">
                                                                                                </div>
                                                 <div class="form-group">
                                               <label class="col-sm-2 control-label">Timeings 3:</label>
                                                   <div class="col-sm-5">
                                                  <input type="time"  class="form-control"  name="t_in3" value="<?php echo $result->t_in3;?>">
                                         </div>
                                          <div class="col-sm-5">
                                             <input type="time"  class="form-control"  name="t_out3"  value="<?php echo $result->t_out3;?>">
                                        </div>
                                         <div class="form-group">
                                            <label class="col-sm-4 control-label">KM Readings images:</label>
                                              <div class="col-sm-4">
                                                  <img style="height:100px;width:100px;" src="../delivery/img/readings/<?php echo $result->petrol_in_readings_img;?>">
                                             </div>
                                              <div class="col-sm-4">
                                             <img style="height:100px;width:100px;" src="../delivery/img/readings/<?php echo $result->petrol_out_readings_img;?>">
                                        </div> </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">KM Readings :</label>
                                              <div class="col-sm-4">
                                              <input type="text"  class="form-control"  name="petrol_in_readings" placeholder="In Readings" value="<?php echo $result->petrol_in_readings;?>">
                                             </div>
                                              <div class="col-sm-4">
                                             <input type="text"  class="form-control"  name="petrol_out_readings"  placeholder="Out Readings" value="<?php echo $result->petrol_out_readings;?>">
                                        </div> </div>
                                          <div class="form-group">
                                           <label class="col-sm-4 control-label">Petrol Filled In Rs  :</label>
                                            <div class="col-sm-8">
                                              <input type="text" class="form-control"  name="petrol_filled"  value="<?php echo $result->petrol_filled;?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="col-sm-4 control-label">Petrol Advance Amount Given :</label>
                                         <div class="col-sm-8">
                                         <input type="text" class="form-control"  name="petrol_advance"  value="<?php echo $result->petrol_advance;?>">
                                          </div>
                                          </div>
                                        <div class="col-sm-8">
                                            <input type="submit" class="form-control-static" name="submit" id="submit" value=" Submit ">
                                        </div>
                                        <?php }}?>
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
