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
        <th>Date</th>
        <th>In-1</th>
         <th>Out-1</th>
         <th>In-2</th>
         <th>Out-2</th>
         <th>In-3</th>
         <th>Out-3</th>
        <th>IN-Readings</th>
        <th>OUT-readings</th>
        <th>petrol-Filled</th>
        <th>Advance</th>
        <th>Add By</th>
        </thead>
        <tbody>
        <?php
        $total=0;
        for ($i=$starting_date; $i<=$ending_date; $i+=86400) {
            $date=date("Y-m-d", $i);
            if($delivery!='0')
                $sql1 = "select * from timeings where DATE(t_date)=:date AND t_add_by=:delivery";
            else
                $sql1 = "select * from timeings where DATE(t_date)=:date";
            $query1 = $link->prepare($sql1);
            $query1->bindParam(':date', $date, PDO::PARAM_STR);
            if($delivery!='0')
                $query1->bindParam(':delivery', $delivery, PDO::PARAM_STR);
            $query1->execute();
            $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
            if ($query1->rowCount() > 0) {
            $c=0;
                foreach ($results1 as $result1){
                $c++;
                    echo "<tr>";
                    echo '<td>'.$c.'</td>';
                    echo '<td>'.$date.'</td>';
                    echo '<td>'.$result1->t_in1.'</td>';
                    echo '<td>'.$result1->t_out1.'</td>';
                    echo '<td>'.$result1->t_in2.'</td>';
                    echo '<td>'.$result1->t_out2.'</td>';
                    echo '<td>'.$result1->t_in3.'</td>';
                    echo '<td>'.$result1->t_out3.'</td>';
                    echo '<td>'.$result1->petrol_in_readings . '</td>';
                    echo '<td>'.$result1->petrol_out_readings.'</td>';
                    echo '<td>'.$result1->petrol_filled.'</td>';
                    echo '<td>'.$result1->petrol_advance.'</td>';
                    if($delivery!=0)
                        echo '<td>'.$delivery.'</td>';
                    else
                        echo '<td>'.$result1->t_add_by.'</td>';
                                        echo "</tr>";
                }
            }

        }
        ?>
        </tbody>
    </table>
    <?php }else{
        header("location: ../timeings_recored.php");
    } ?>
</div>

<script src="tableExport/tableExport.js"></script>
<script type="text/javascript" src="tableExport/jquery.base64.js"></script>
<script src="js/export.js"></script>
<div class="insert-post-ads1" style="margin-top:20px;">
</body>
</html>