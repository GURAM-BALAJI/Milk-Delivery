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
        $c_id=$_POST['c_id'];
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
            <?php if($c_id=="0" && $delivery=="0"){?>
            <thead>
		<tr>
    <th>Sl.No </th>
    <th>Names </th>
    <th>Phone </th>
    <?php
    $sl=3;
    for ($i=$starting_date; $i<=$ending_date; $i+=86400){
    echo '<th>'.date("Y/m/d", $i).'</th>';
        $sl++;
     }
    ?>
    <th>Total Liters</th>
            </tr>
            </thead>
            <tbody>
   <?php
   $total1=0;
   $sql = "select * from customers";
   $query = $link->prepare($sql);
   $query ->execute();
   $results=$query->fetchAll(PDO::FETCH_OBJ);
   if($query->rowCount() > 0)
       foreach($results as $result){
   ?>
                          <tr>
                              <td><?php echo $result->c_id; ?></td>
                              <td><?php echo $result->c_name; ?></td>
                              <td><?php echo $result->c_phone; ?></td>
                              <?php
                              $id=$result->c_id;
                              $total=0;
                              for ($i=$starting_date; $i<=$ending_date; $i+=86400) {
                                  $date=date("Y-m-d", $i);
                                  $sql1 = "select * from delivery where d_c_id=:id AND d_date=:date";
                                  $query1 = $link->prepare($sql1);
                                  $query1->bindParam(':date', $date, PDO::PARAM_STR);
                                  $query1->bindParam(':id', $id, PDO::PARAM_STR);
                                  $query1->execute();
                                  $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                  if ($query1->rowCount() > 0) {
                                      foreach ($results1 as $result1) {
                                          $total+=$result1->liters;
                                          if($result1->liters!=0)
                                          echo '<td>' . $result1->liters . '</td>';
                                          else
                                              echo "<td style='color:red;'>Not-Taken</td>";
                                      }
                                  }else
                                      echo '<td> </td>';
                              }
                              $total1+=$total;
                              ?>
                              <td><?php echo $total; ?></td>
                          </tr>
                          <?php } ?>
            <td colspan="<?php echo $sl; ?>">Total</td><td><?php echo $total1; ?></td>
			</tbody>
            <?php }elseif($c_id!="0"){
            $sql = "select * from customers where c_id=:id";
            $query = $link->prepare($sql);
                $query->bindParam(':id', $c_id, PDO::PARAM_STR);
            $query ->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            if($query->rowCount() > 0)
                foreach($results as $result){
                ?>
                <thead>
                <th colspan="5">Name: <?php echo $result->c_name; ?></th>
                <th colspan="2">Phone: <?php echo $result->c_phone; ?></th>
                <th colspan="10">Address: <?php echo $result->c_address; ?></th>
                </thead>
                    <?php } ?>
                <thead>
                <th>Date</th>
                <th>Quantity</th>]
                </thead>
                <tbody>
                <?php
                $total=0;
                for ($i=$starting_date; $i<=$ending_date; $i+=86400) {
                    $date=date("Y-m-d", $i);
                    echo "<tr>";
                    echo '<td>'.$date.'</td>';
                    $sql1 = "select * from delivery where d_c_id=:id AND DATE(d_date)=:date";
                    $query1 = $link->prepare($sql1);
                    $query1->bindParam(':date', $date, PDO::PARAM_STR);
                    $query1->bindParam(':id', $c_id, PDO::PARAM_STR);
                    $query1->execute();
                    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                    if ($query1->rowCount() > 0) {
                        foreach ($results1 as $result1) {
                            $total+=$result1->liters;
                            if($result1->liters!=0)
                                echo '<td>' . $result1->liters . '</td>';
                            else
                                echo "<td style='color:#ff0000;'>Not-Taken</td>";
                        }
                    }else
                        echo '<td> </td>';
                    echo "</tr>";
                }
                ?>
                <thead>
                <tr>
                    <th>Total: </th>
                    <th><?php echo $total; ?></th>
                </tr>
                </thead>
                </tbody>
            <?php }else{ ?>
            <thead>
                <th>Id</th>
            <th>Date</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Delivery By</th>
            <th>Remark</th>
            </thead>
            <tbody>
            <?php
            $total=0;
            for ($i=$starting_date; $i<=$ending_date; $i+=86400) {
                $date=date("Y-m-d", $i);
                $sql1 = "select * from delivery where DATE(d_date)=:date AND add_by=:delivery";
                $query1 = $link->prepare($sql1);
                $query1->bindParam(':date', $date, PDO::PARAM_STR);
                $query1->bindParam(':delivery', $delivery, PDO::PARAM_STR);
                $query1->execute();
                $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                if ($query1->rowCount() > 0) {
                    foreach ($results1 as $result1) {
                        echo "<tr>";
                        $sql2 = "select c_name,c_id from customers where c_id=:delivery";
                        $query2 = $link->prepare($sql2);
                        $query2->bindParam(':delivery', $result1->d_c_id, PDO::PARAM_STR);
                        $query2->execute();
                        $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                        if ($query2->rowCount() > 0)
                            foreach ($results2 as $result2)
                             echo '<td>'.$result2->c_id.'</td>';
                             echo '<td>'.$date.'</td>';
                                echo '<td>'.$result2->c_name.'</td>';
                        $total+=$result1->liters;
                        if($result1->liters!=0)
                            echo '<td>' . $result1->liters . '</td>';
                        else
                            echo "<td style='color:#ff0000;'>Not-Taken</td>";
                        echo '<td>'.$delivery.'</td>';
                         echo '<td>'.$result1->remark.'</td>';
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
            <?php } ?>
		</table>
        <?php }else{
        header("location: ../milk_recored.php");
        } ?>
	</div>

<script src="tableExport/tableExport.js"></script>
<script type="text/javascript" src="tableExport/jquery.base64.js"></script>
<script src="js/export.js"></script>
<div class="insert-post-ads1" style="margin-top:20px;">
</body>
</html>