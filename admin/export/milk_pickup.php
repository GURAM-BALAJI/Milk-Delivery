<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- jQuery -->

</head>
<body >
<?php
include('../../connect.php');
if(isset($_POST['submit'])){
$delivery=$_POST['delivery'];
$starting_date=$_POST['start_date'];
$ending_date=$_POST['end_date'];
$starting_date=strtotime($starting_date);
$ending_date=strtotime($ending_date);
?>
<div class="table-responsive">
    <div class="top-panel">
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown">Export <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
                <li><a class="dataExport" data-type="excel">Excel</a></li>
                <li><a class="dataExport" data-type="csv">CSV</a></li>
                <li><a class="dataExport" data-type="txt">Text</a></li>
            </ul>
        </div>
    </div>
    <table id="dataTable" class="table table-striped">
        <thead>
        <th>Id</th>
        <th>Item</th>
        <th>Date</th>
        <th>Full</th>
        <th>half</th>
        <th>Total</th>
        <th>Delivery By</th>
        </thead>
        <tbody>
        <?php
        $cont=1;$total=0;
        for ($i=$starting_date; $i<=$ending_date; $i+=86400) {
            $date=date("Y-m-d", $i);
            if($delivery!='0')
                $sql1 = "select * from pick where DATE(p_date)=:date AND p_name=:delivery";
            else
                $sql1 = "select * from pick where DATE(p_date)=:date";
            $query1 = $link->prepare($sql1);
            $query1->bindParam(':date', $date, PDO::PARAM_STR);
            if($delivery!='0')
                $query1->bindParam(':delivery', $delivery, PDO::PARAM_STR);
            $query1->execute();
            $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
            if ($query1->rowCount() > 0) {
                foreach ($results1 as $result1){
                    echo "<tr>";
                    echo '<td>'.$cont++.'</td>';
                    echo '<td>Milk</td>';
                    echo '<td>'.$date.'</td>';
                    echo '<td>'.$result1->p_one_liters.'</td>';
                    echo '<td>'.$result1->p_half_liters.'</td>';
                    $half=$result1->p_half_liters/2;
                    $tol=$half+$result1->p_one_liters;
                    $total+=$tol;
                        echo '<td>' . $tol . '</td>';
                        echo '<td>'.$result1->p_name.'</td>';
                    echo "</tr>";
                }
            }

        }
        ?>
        <thead>
        <tr>
            <th>Total: </th>
            <th><?php echo $total; ?></th>
        </tr>
        </thead>
        </tbody>
    </table>
    <?php }else{
        header("location: ../milk_pick_up_recored.php");
    } ?>
</div>

<script src="tableExport/tableExport.js"></script>
<script type="text/javascript" src="tableExport/jquery.base64.js"></script>
<script src="js/export.js"></script>
<div class="insert-post-ads1" style="margin-top:20px;">
</body>
</html>