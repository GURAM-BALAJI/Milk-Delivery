<?php
session_start();
if(isset($_SESSION['post'])) {
    if ($_SESSION['post'] == "delivery")
        header("location: ../delivery/");

}else
    header("location: ../index.php");
$t_id=$_GET['id'];
include('../connect.php');
?>
<html>
<head>
      <link rel="shortcut icon" href="assets/images/favicon-icon/logo.png">
    <title>AaharaMilk</title>
    </head>
    <body>
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
        <img src="../delivery/img/readings/<?php echo $result->petrol_in_readings_img;?>">
 <img src="../delivery/img/readings/<?php echo $result->petrol_out_readings_img;?>">
        <?php }} ?>
    </body>
</html>