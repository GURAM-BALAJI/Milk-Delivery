<?php
session_start();
if(isset($_SESSION['post'])) {
    if ($_SESSION['post'] == "delivery")
        header("location: ../delivery/");
}else
    header("location: ../index.php");

include('../connect.php');
    if(isset($_GET['del']))
    {
        $login_id=$_GET['del'];
        $de=$_GET['delete'];
        $sql = "update login set login_delete=:de where login_id=:login_id";
        $query = $link->prepare($sql);
        $query ->bindParam(':de',$de,PDO::PARAM_STR);
        $query ->bindParam(':login_id',$login_id,PDO::PARAM_STR);
        $query ->execute();
        $msg="Page data updated  successfully ";
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

                        <h2 class="page-title">View logins</h2>
                        <!-- Zero Configuration Table -->
                        <div class="panel panel-default" style="overflow-x:auto;">
                            <div class="panel-heading">login Details</div>
                            <div class="panel-body">
                                <?php if(isset($error)){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                                else if(isset($msg)){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User Type</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Add date</th>
                                        <th>Updation date</th>
                                        <th>Deleted</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>User Type</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Add date</th>
                                        <th>Updation date</th>
                                        <th>Deleted</th>
                                        <th>Action</th>
                                    </tr>
                                    </tr>
                                    </tfoot>
                                    <tbody>

                                    <?php
                                    $sql = "SELECT * from  login ";
                                    $query = $link -> prepare($sql);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0)
                                    {
                                        foreach($results as $result)
                                        {				?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt);?></td>
                                                <td><?php echo htmlentities($result->post);?></td>
                                                <td><?php echo htmlentities($result->username);?></td>
                                                <td><?php echo htmlentities($result->password);?></td>
                                                <td><?php echo htmlentities($result->add_date);?></td>
                                                <td><?php echo htmlentities($result->last_updated);?></td>
                                                <td><?php $login_id=$result->login_id; if($result->login_delete)echo '<a href="manage_login.php?del='.$login_id.'&delete=0">Yes</a>'; else echo '<a href="manage_login.php?del='.$login_id.'&delete=1">No</a>';?></td>
                                                <td><a href="edit_login.php?id=<?php echo $result->login_id;?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                            </tr>
                                            <?php $cnt=$cnt+1; }} ?>

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
