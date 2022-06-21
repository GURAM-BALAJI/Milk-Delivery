<?php
session_start();
if (isset($_SESSION['post'])) {
    if ($_SESSION['post'] == "delivery")
        header("location: ../delivery/");
} else
    header("location: ../index.php");
include('../connect.php');
if (isset($_GET['date']))
    $_SESSION['date'] = $_GET['date'];
if (isset($_GET['id'])) {
    $today = $_GET['date'];
    $c_id = $_GET['id'];

    $sql2 = "select d_id from delivery where d_date=:today AND d_c_id=:c_id";
    $query2 = $link->prepare($sql2);
    $query2->bindParam(':today', $today, PDO::PARAM_STR);
    $query2->bindParam(':c_id', $c_id, PDO::PARAM_STR);
    $query2->execute();
    $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
    if ($query2->rowCount() == 0) {
        $num = $_GET['num'];
        $li = floatval($_GET['li']);
        $c_name = $_GET['name'];
        $c_phone = $_GET['phone'];
        $liters = 'liters' . $num;
        $liters = floatval($_POST[$liters]);
        $remark = 'remark' . $num;
        $remark = $_POST[$remark];
        $cb = 'cb' . $num;
        $update_by = $_SESSION['name'];
        if (isset($_POST[$cb])) {
            $cb = $_POST[$cb];
            $liters = floatval($li) + floatval($liters);
        }

        $sql2 = "select * from customers where c_id=:c_id";
        $query2 = $link->prepare($sql2);
        $query2->bindParam(':c_id', $c_id, PDO::PARAM_STR);
        $query2->execute();
        $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
        if ($query2->rowCount() != 0) {
            foreach ($results2 as $row) {
                $c_amount = $row->c_amount;
                $c_amount = floatval($c_amount) - floatval($liters);
                $stmt = $link->prepare("UPDATE customers SET c_amount=:c_amount WHERE c_id=:id");
                $stmt->execute(['c_amount' => $c_amount, 'id' => $c_id]);
            }
        }

        $sql = "insert into delivery(liters,d_c_id,d_date,add_by,remark) value (:liters,:id,:today,:add_by,:remark)";
        $query = $link->prepare($sql);
        $query->bindParam(':liters', $liters, PDO::PARAM_STR);
        $query->bindParam(':id', $c_id, PDO::PARAM_STR);
        $query->bindParam(':add_by', $update_by, PDO::PARAM_STR);
        $query->bindParam(':today', $today, PDO::PARAM_STR);
        $query->bindParam(':remark', $remark, PDO::PARAM_STR);
        $query->execute();
        $msg = "Delivered successfully.. ";
    } else
        $error = "Alredy added..!";
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
                loadingImage: 'src/loading.gif',
                closeImage: 'src/closelabel.png'
            })
        })
    </script>

    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px sollogin_id #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px sollogin_id #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
    </style>

</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <h2 class="page-title">Not Delivery list</h2>
                        <!-- Zero Configuration Table -->
                        <div class="panel panel-default" style="overflow-x:auto;">
                            <div class="panel-heading">customers Details</div>
                            <form method="get">
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name="date" id="date" required>
                                    </div>

                                    <div class="col-sm-4">
                                        <input type="submit" class="form-control-static" name="submit" id="submit" value=" Submit ">
                                    </div>
                                </div>
                            </form>
                            <div class="panel-body">
                                <?php if (isset($error)) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } else if (isset($msg)) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Liters</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $results11[] = "";
                                        if (isset($_SESSION['date']))
                                            $today = $_SESSION['date'];
                                        else
                                            $today = date("Y-m-d");
                                        $sql1 = "SELECT d_c_id from delivery where date(d_date)=:today";
                                        $query1 = $link->prepare($sql1);
                                        $query1->bindParam(':today', $today, PDO::PARAM_STR);
                                        $query1->execute();
                                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                        if ($query1->rowCount() > 0)
                                            foreach ($results1 as $result1)
                                                $results11[] = $result1->d_c_id;
                                        $sql = "SELECT * from customers WHERE c_delete=0";
                                        $query = $link->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                                if (!in_array($result->c_id, $results11)) { ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($result->c_id); ?></td>
                                                        <td><?php echo htmlentities($result->c_name); ?></td>
                                                        <td><?php echo htmlentities($result->c_phone); ?></td>
                                                        <td><?php echo htmlentities($result->c_address); ?></td>
                                                        <td>
                                                            <form method="post" action="not_deliveried.php?id=<?php echo $result->c_id; ?>&num=<?php echo $cnt; ?>&li=<?php echo $result->c_liters; ?>&phone=<?php echo $result->c_phone; ?>&name=<?php echo $result->c_name; ?>&date=<?php echo $today; ?>">
                                                                <input type="checkbox" name="cb<?php echo $cnt; ?>" id="cb<?php echo $cnt; ?>">
                                                                <?php echo htmlentities($result->c_liters) . '+'; ?>
                                                                <input type="text" name="liters<?php echo $cnt; ?>" id="liters<?php echo $cnt; ?>" size="3">
                                                                <input type="text" name="remark<?php echo $cnt; ?>" id="remark<?php echo $cnt; ?>" placeholder="Remarks..">
                                                                <input type="submit" name="submit" value="submit">
                                                            </form>
                                                        </td>
                                                    </tr>
                                        <?php $cnt = $cnt + 1;
                                                }
                                            }
                                        } ?>

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