<?php
session_start();
if(isset($_SESSION['post'])) {
    if ($_SESSION['post'] == "delivery")
        header("location: ../delivery/");

}else
    header("location: ../index.php");

include('../connect.php');
// Code for change
if(isset($_POST['submit']))
{
    try {
        $username = $_POST['username'];
        $id = $_GET['id'];
        $sql1 = "SELECT * FROM login WHERE username=:username AND login_id!=:id AND login_delete=0";
        $query1 = $link->prepare($sql1);
        $query1->bindParam(':username', $username, PDO::PARAM_STR);
        $query1->bindParam(':id', $id, PDO::PARAM_STR);
        $query1->execute();
        if($query1->rowCount() == 0) {
            $password = $_POST['password'];
            $password = password_hash($password, PASSWORD_BCRYPT);
            $post = $_POST['post'];
            if(!empty($_POST['root']))
                $root = implode(",",$_POST['root']);
            else
                $root ="";
            $sql = " update login set username=:username, password=:password, post=:post, root=:root where login_id=:id";
            $query = $link->prepare($sql);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->bindParam(':post', $post, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->bindParam(':root', $root, PDO::PARAM_STR);
            $query->execute();
            $msg = "Updated successfully";
        }else {
            $error ="Username already taken...!";
        }
    }catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}
?>

<!doctype html>
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
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
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

						<h2 class="page-title">Edit login</h2>

						<div class="row">
							<div class="col-md-10">
								<div class="panel panel-default">
									<div class="panel-heading">login fields</div>
									<div class="panel-body">
										<form method="post" name="chngpwd" class="form-horizontal" onSubmit="return valid();">


  	        	  <?php if(isset($error)){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
				else if(isset($msg)){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

<?php
$id=$_GET['id'];
$ret="select * from login where login_id=:id";
$query= $link -> prepare($ret);
$query->bindParam(':id',$id, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
foreach($results as $result)
{
?>

    <div class="form-group">
        <label class="col-sm-2 control-label">User Name :</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="username" id="username" required value="<?php echo htmlentities($result->username);?>">
        </div></div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Password :</label>
        <div class="col-sm-8">
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Post :</label>
        <div class="col-sm-8">
            <select class="form-control" name="post" required >
                <option value="<?php echo htmlentities($result->post);?>"><?php echo htmlentities($result->post);?> </option>
                <option value="admin">Admin</option>
                <option value="delivery">Delivery</option>
            </select>
        </div></div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Root :</label>
        <div class="col-sm-8">
            <?php
            $root=explode(',',$result->root); ?>
            <?php if(in_array("A",$root)){ ?>
            <input type="checkbox" name="root[]" value="A" checked> A<br>
             <?php }else{?>
    <input type="checkbox" name="root[]" value="A" > A<br>
    <?php } ?>
             <?php if( in_array("B",$root)){ ?>
            <input type="checkbox" name="root[]" value="B" checked> B<br>
             <?php }else{?>
                 <input type="checkbox" name="root[]" value="B" > B<br>
            <?php } ?>
            <?php if( in_array("C",$root)){ ?>
            <input type="checkbox" name="root[]" value="C" checked> C<br>
             <?php }else{?>
                <input type="checkbox" name="root[]" value="C" > C<br>
            <?php } ?>
            <?php if( in_array("D",$root)){ ?>
            <input type="checkbox" name="root[]" value="D" checked> D<br>
            <?php }else{?>
            <input type="checkbox" name="root[]" value="D" > D<br>
            <?php } ?>
            <?php if( in_array("E",$root)){ ?>
            <input type="checkbox" name="root[]" value="E" checked> E<br>
            <?php }else{?>
            <input type="checkbox" name="root[]" value="E" > E<br>
            <?php } ?>
            <?php if( in_array("F",$root)){ ?>
            <input type="checkbox" name="root[]" value="F" checked> F<br>
            <?php }else{?>
            <input type="checkbox" name="root[]" value="F" > F<br>
            <?php } ?>
            <?php if( in_array("AE",$root)){ ?>
            <input type="checkbox" name="root[]" value="AE" checked> AE<br>
            <?php }else{?>
            <input type="checkbox" name="root[]" value="AE" > AE<br>
            <?php } ?>
            <?php if( in_array("BE",$root)){ ?>
            <input type="checkbox" name="root[]" value="BE" checked> BE<br>
            <?php }else{?>
            <input type="checkbox" name="root[]" value="BE" > BE<br>
            <?php } ?>
            <?php if( in_array("CE",$root)){ ?>
            <input type="checkbox" name="root[]" value="CE" checked> CE<br>
            <?php }else{?>
            <input type="checkbox" name="root[]" value="CE" > CE<br>
            <?php } ?>
            <?php if( in_array("DE",$root)){ ?>
            <input type="checkbox" name="root[]" value="DE" checked> DE<br>
            <?php }else{?>
            <input type="checkbox" name="root[]" value="DE" > DE<br>
            <?php } ?>
            <?php if( in_array("FE",$root)){ ?>
            <input type="checkbox" name="root[]" value="FE" checked> FE<br>
            <?php }else{?>
            <input type="checkbox" name="root[]" value="FE" > FE<br>
            <?php } ?>
             <?php if( in_array("AM",$root)){ ?>
            <input type="checkbox" name="root[]" value="AM" checked> AM<br>
            <?php }else{?>
            <input type="checkbox" name="root[]" value="AM" > AM<br>
            <?php } ?>
            <?php if( in_array("BM",$root)){ ?>
            <input type="checkbox" name="root[]" value="BM" checked> BM<br>
            <?php }else{?>
            <input type="checkbox" name="root[]" value="BM" > BM<br>
            <?php } ?>
            <?php if( in_array("CM",$root)){ ?>
            <input type="checkbox" name="root[]" value="CM" checked> CM<br>
            <?php }else{?>
            <input type="checkbox" name="root[]" value="CM" > CM<br>
            <?php } ?>
            <?php if( in_array("DM",$root)){ ?>
            <input type="checkbox" name="root[]" value="DM" checked> DM<br>
            <?php }else{?>
            <input type="checkbox" name="root[]" value="DM" > DM<br>
            <?php } ?>
            <?php if(in_array("FM",$root)){ ?>
            <input type="checkbox" name="root[]" value="FM" checked> FM<br>
            <?php }else{?>
            <input type="checkbox" name="root[]" value="FM" > FM<br>
            <?php } ?>
        </div>
    </div>
    <div class="hr-dashed"></div>
										<?php }} ?>


											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-4">

													<button class="btn btn-primary" name="submit" type="submit">Submit</button>
												</div>
											</div>

										</form>

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

</body>

</html>
