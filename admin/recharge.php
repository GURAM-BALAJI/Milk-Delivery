<?php
session_start();
if(isset($_SESSION['post'])) {
    if ($_SESSION['post'] == "delivery")
        header("location: ../delivery/");

}else
    header("location: ../index.php");
if(isset($_SESSION['error'])){
$error=$_SESSION['error'];
    unset($_SESSION['error']);
}
if(isset($_SESSION['success'])){
$msg=$_SESSION['success'];
    unset($_SESSION['success']);
}
include('../connect.php');
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

                    <h2 class="page-title">Recharge </h2>
                    <!-- Zero Configuration Table -->
                    <div class="panel panel-default" style="overflow-x:auto;">
                        <div class="panel-heading">Recharge Details</div>
                        <div class="panel-body">
                            <?php if(isset($error)){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                            else if(isset($msg)){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Names</th>
                                    <th>Phones</th>
                                    <th>Address</th>
                                    <th>Liters</th>
                                    <th>Recharged Liters</th>
                                    <th>Updation date</th>
                                    <?php if($_SESSION['post'] == "admin"){ ?>
                                    <th>Action</th>
                                    <?php }?>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $sql = "SELECT * from  customers where c_amount<=5 AND c_amount>=-5 ";
                                $query = $link -> prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0)
                                {
                                    foreach($results as $result)
                                    {	
                                    if($result->c_amount<=0)
                                        $color='red';
                                        else
                                            $color='orange';
                                    ?>
                                        <tr style="background-color:<?php echo $color; ?>">
                                            <td><?php echo htmlentities($result->c_id);?></td>
                                            <td><?php echo htmlentities($result->c_name);?></td>
                                            <td><?php echo htmlentities($result->c_phone);?></td>
                                            <td><?php echo htmlentities($result->c_address);?></td>
                                            <td><?php echo htmlentities($result->c_liters);?></td>
                                            <td><?php echo htmlentities($result->c_amount);?></td>
                                            <td><?php echo htmlentities($result->c_last_updated);?></td>
                                            <?php if($_SESSION['post'] == "admin"){ ?>
                                            <td>
                                            <span class='pull-right'>
                                                <a href='#edit_amount' class='edit_amount' data-toggle='modal' data-id='<?php echo htmlentities($result->c_id);?>'><i class='fa fa-plus'></i>
                                                </a>
                                                </span>
                                            </td>
                                        <?php } ?>
                                        </tr>
                                        <?php }} ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
 <?php include 'customer_modal.php'; ?>

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
    <?php include 'includes/scripts.php'; ?>
<script>
$(function(){

    $(document).on('click', '.edit_amount', function(e){
        e.preventDefault();
        $('#edit_amount').modal('show');
        var id = $(this).data('id');
        getRow(id);
    });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'customer_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.c_id').val(response.c_id);
      $('.name').html(response.c_name);
      $('.c_amount').html(response.c_amount);
    }
  });
}
</script>
</body>
</html>
