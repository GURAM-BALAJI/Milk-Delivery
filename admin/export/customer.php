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
        <th>#</th>
        <th>Names</th>
        <th>Phones</th>
        <th>Address</th>
        <th>Liters</th>
        <th>Add date</th>
        <th>Updation date</th>
        <th>Deleted</th>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * from  customers ";
        $query = $link -> prepare($sql);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0)
        {
            foreach($results as $result)
            {				?>
                <tr>
                    <td><?php echo htmlentities($result->c_id);?></td>
                    <td><?php echo htmlentities($result->c_name);?></td>
                    <td><?php echo htmlentities($result->c_phone);?></td>
                    <td><?php echo htmlentities($result->c_address);?></td>
                    <td><?php echo htmlentities($result->c_liters);?></td>
                    <td><?php echo htmlentities($result->c_add_date);?></td>
                    <td><?php echo htmlentities($result->c_last_updated);?></td>
                    <td><?php $c_id=$result->c_id; if($result->c_delete)echo '<a href="manage_customer.php?del='.$c_id.'&delete=0">Yes</a>'; else echo '<a href="manage_customer.php?del='.$c_id.'&delete=1">No</a>';?></td>
                     </tr>
            <?php }} ?>
        </tbody>
    </table>
</div>

<script src="tableExport/tableExport.js"></script>
<script type="text/javascript" src="tableExport/jquery.base64.js"></script>
<script src="js/export.js"></script>
<div class="insert-post-ads1" style="margin-top:20px;">
</body>
</html>