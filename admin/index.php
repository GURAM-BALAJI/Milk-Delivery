<?php
session_start();
if(isset($_SESSION['post'])){
    if (isset($_SESSION['post']) && $_SESSION['post'] == "delivery")
        header("location: ../delivery/");
}else
    header("location: ../logout.php");
include("../connect.php");
?>
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
</head>

<body>
<?php include('includes/header.php');?>
<div class="ts-main-content">
    <?php include('includes/leftbar.php');?>
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">

                    <h2 class="page-title">Dashboard</h2>


            <div class="row">
                <div class="col-md-12">


                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="panel panel-default">
                                        <div class="panel-body bk-success text-light">
                                            <div class="stat-panel text-center">
                                                <?php
                                                $query=0;
                                                date_default_timezone_set('Asia/Kolkata');
                                                 $today=date("Y-m-d");
                                                $sql6 ="SELECT liters from delivery where d_date=:today ";
                                                $query6 = $link -> prepare($sql6);
                                                $query6->bindParam(':today', $today, PDO::PARAM_STR);
                                                $query6->execute();
                                                $results6=$query6->fetchAll(PDO::FETCH_OBJ);
                                                if($query6->rowCount() > 0)
                                                foreach($results6 as $result)
                                                $query+=$result->liters;
                                                $milk_compare=$query;
                                                ?>
                                                <div class="stat-panel-number h1 "><?php echo htmlentities($query);?></div>
                                                <div class="stat-panel-title text-uppercase">Total Milk Today</div>
                                            </div>
                                        </div>
                                        <?php if(isset($_SESSION['post']) && $_SESSION['post']=="admin"){ ?>
                                        <a href="edit_delivery.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                                        <?php }?></div>
                                </div>

                                                <?php
                                                $query=0.000;
                                                $one=$half=0;
                                                date_default_timezone_set('Asia/Kolkata');
                                                $today=date("Y-m-d");
                                                $sql6 ="SELECT p_one_liters,p_half_liters from pick where p_date=:today";
                                                $query6 = $link -> prepare($sql6);
                                                $query6->bindParam(':today', $today, PDO::PARAM_STR);
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
                                                <div class="stat-panel-title text-uppercase">Total Milk Picked Today</div>
                                            </div>
                                        </div>
                                        <?php if(isset($_SESSION['post']) && $_SESSION['post'] == "admin"){ ?>
                                        <a href="pick_up.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>

                                    <?php }?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>






                <div class="row">
                    <div class="col-md-12">


                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-success text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $query=0;
                                                    date_default_timezone_set('Asia/Kolkata');
                                                    $today=date("Y-m-d");
                                                    $sql6 ="SELECT gd_qty from gee_delivery where gd_date=:today ";
                                                    $query6 = $link -> prepare($sql6);
                                                    $query6->bindParam(':today', $today, PDO::PARAM_STR);
                                                    $query6->execute();
                                                    $results6=$query6->fetchAll(PDO::FETCH_OBJ);
                                                    if($query6->rowCount() > 0)
                                                        foreach($results6 as $result)
                                                            $query+=$result->gd_qty;
                                                    $milk_compare=$query;
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($query);?></div>
                                                    <div class="stat-panel-title text-uppercase">Total Gee Today</div>
                                                </div>
                                            </div>
                                            <?php if(isset($_SESSION['post']) && $_SESSION['post'] == "admin"){ ?>
                                            <a href="gee_delivery.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>

                                        <?php }?></div>
                                    </div>

                                    <?php
                                    $query=0;
                                    date_default_timezone_set('Asia/Kolkata');
                                    $today=date("Y-m-d");
                                    $sql6 ="SELECT gp_qty from gee_pick where gp_date=:today";
                                    $query6 = $link -> prepare($sql6);
                                    $query6->bindParam(':today', $today, PDO::PARAM_STR);
                                    $query6->execute();
                                    $results6=$query6->fetchAll(PDO::FETCH_OBJ);
                                    if($query6->rowCount() > 0)
                                        foreach($results6 as $result) {
                                            $query+= $result->gp_qty;
                                        }
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
                                                        <div class="stat-panel-title text-uppercase">Total Gee Picked Today</div>
                                                    </div>
                                                    </div>
                                                <?php if(isset($_SESSION['post']) && $_SESSION['post'] == "admin"){ ?>

                                                <a href="gee_pick_up.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>
                                            <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>











                    <div class="row">
                        <div class="col-md-12">


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="panel panel-default">
                                                <div class="panel-body bk-success text-light">
                                                    <div class="stat-panel text-center">
                                                        <?php
                                                        $query=0;
                                                        date_default_timezone_set('Asia/Kolkata');
                                                        $today=date("Y-m-d");
                                                        $sql6 ="SELECT pd_qty from panner_delivery where pd_date=:today ";
                                                        $query6 = $link -> prepare($sql6);
                                                        $query6->bindParam(':today', $today, PDO::PARAM_STR);
                                                        $query6->execute();
                                                        $results6=$query6->fetchAll(PDO::FETCH_OBJ);
                                                        if($query6->rowCount() > 0)
                                                            foreach($results6 as $result)
                                                                $query+=$result->pd_qty;
                                                        $milk_compare=$query;
                                                        ?>
                                                        <div class="stat-panel-number h1 "><?php echo htmlentities($query);?></div>
                                                        <div class="stat-panel-title text-uppercase">Total Panner Today</div>
                                                    </div>
                                                </div>
                                                <?php if(isset($_SESSION['post']) && $_SESSION['post'] == "admin"){ ?>
                                                <a href="panner_delivery.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>

                                            <?php }?></div>
                                        </div>

                                        <?php
                                        $query=0;
                                        date_default_timezone_set('Asia/Kolkata');
                                        $today=date("Y-m-d");
                                        $sql6 ="SELECT pp_qty from panner_pick where pp_date=:today";
                                        $query6 = $link -> prepare($sql6);
                                        $query6->bindParam(':today', $today, PDO::PARAM_STR);
                                        $query6->execute();
                                        $results6=$query6->fetchAll(PDO::FETCH_OBJ);
                                        if($query6->rowCount() > 0)
                                            foreach($results6 as $result) {
                                                $query+= $result->pp_qty;
                                            }
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
                                                            <div class="stat-panel-title text-uppercase">Total Panner Picked Today</div>
                                                        </div>
                                                    </div>
                                                    <?php if(isset($_SESSION['post']) && $_SESSION['post'] == "admin"){ ?>
                                                    <a href="panner_pick_up.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>

                                               <?php }?> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>






                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $sql6 ="SELECT login_id from login Where login_delete=0";
                                                    $query6 = $link -> prepare($sql6);;
                                                    $query6->execute();
                                                    $results6=$query6->fetchAll(PDO::FETCH_OBJ);
                                                    $query=$query6->rowCount();
                                                    ?>
                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($query);?></div>
                                                    <div class="stat-panel-title text-uppercase">Total Login`s</div>
                                                </div>
                                            </div>
                                            <?php if(isset($_SESSION['post']) && $_SESSION['post'] == "admin"){ ?>
                                            <a href="manage_login.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>

                                       <?php }?> </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-info text-light">
                                                <div class="stat-panel text-center">
                                                    <?php
                                                    $sql2 ="SELECT c_id from customers Where c_delete=0";
                                                    $query2= $link -> prepare($sql2);
                                                    $query2->execute();
                                                    $results2=$query2->fetchAll(PDO::FETCH_OBJ);
                                                    $bookings=$query2->rowCount();
                                                    ?>

                                                    <div class="stat-panel-number h1 "><?php echo htmlentities($bookings);?></div>
                                                    <div class="stat-panel-title text-uppercase">Total Customers</div>
                                                </div>
                                            </div>
                                            <?php if(isset($_SESSION['post']) && $_SESSION['post'] == "admin"){ ?>
                                            <a href="manage_customer.php" class="block-anchor panel-footer text-center">Full Detail &nbsp; <i class="fa fa-arrow-right"></i></a>

                                        <?php }?></div>
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

<script>

    window.onload = function(){

        // Line chart from swirlData for dashReport
        var ctx = document.getElementById("dashReport").getContext("2d");
        window.myLine = new Chart(ctx).Line(swirlData, {
            responsive: true,
            scaleShowVerticalLines: false,
            scaleBeginAtZero : true,
            multiTooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
        });

        // Pie Chart from doughutData
        var doctx = document.getElementById("chart-area3").getContext("2d");
        window.myDoughnut = new Chart(doctx).Pie(doughnutData, {responsive : true});

        // Dougnut Chart from doughnutData
        var doctx = document.getElementById("chart-area4").getContext("2d");
        window.myDoughnut = new Chart(doctx).Doughnut(doughnutData, {responsive : true});

    }
</script>
</body>
</html>

