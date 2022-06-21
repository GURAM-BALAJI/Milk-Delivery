	<nav class="ts-sidebar">
			<ul class="ts-sidebar-menu">
			
				<li class="ts-label">Main</li>
				<li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#"><i class="fa fa-file-excel-o"></i>Delivery Records</a>
                <ul>
                    <li><a href="milk_recored.php">Milk Records</a></li>
                    <li><a href="gee_recored.php">Gee Records</a></li>
                    <li><a href="panner_recored.php">Panner Records</a></li>
                </ul></li>
                         <li><a href="#"><i class="fa fa-file-word-o"></i>Pick Up Records</a>
                    <ul>
                        <li><a href="milk_pick_up_recored.php">Milk Records</a></li>
                        <li><a href="gee_pick_up_recored.php">Gee Records</a></li>
                        <li><a href="panner_pick_up_recored.php">Panner Records</a></li>
                    </ul></li>
                    <li><a href="#"><i class="fa fa-sitemap"></i> Timeings</a>
                    					<ul>
                    						<li><a href="timeings.php"> Timeings</a></li>
                    						<li><a href="timeings_recorded.php"> Timeings Records</a></li>
                                            <li><a href="login_timeings.php"> Login Timeings</a></li>
                                            <li><a href="login_timeings_recorded.php"> Login Timeings Records</a></li>
                    					</ul>
                    				</li>
            <li><a href="recharge.php"><i class="fa fa-chain-broken"></i> Recharge List</a></li>
           <?php if(isset($_SESSION['post']) && $_SESSION['post'] == "admin"){ ?>
<li><a href="#"><i class="fa fa-sitemap"></i> Users</a>
					<ul>
						<li><a href="add_login.php"> Add Users</a></li>
						<li><a href="manage_login.php"> Manage Users</a></li>
					</ul>
				</li>
			<li><a href="#"><i class="fa fa-users"></i> Customers</a>
            					<ul>
            					<li><a href="add_customer.php"> Add Customer</a></li>
            						<li><a href="manage_customer.php"> Manage Customer</a></li>
            					</ul>
            				</li>
                <li><a href="#"><i class="fa fa-windows"></i> Delivery</a>
                    <ul>
                <li><a href="edit_delivery.php">Milk Delivery List</a>
                <li><a href="gee_delivery.php">Gee Delivery List</a></li>
                <li><a href="panner_delivery.php">Panner Delivery List</a></li>
                    </ul>
                    <?php } ?>

                <li><a href="not_deliveried.php"><i class="fa fa-cart-arrow-down"></i>Milk Not Deliveried List</a></li>
                               <li><a href="#"><i class="fa fa-sitemap"></i> Milk Pick</a>
                    <ul>
                     <?php if(isset($_SESSION['post']) && $_SESSION['post'] == "admin"){ ?>
                <li><a href="pick_up.php">Milk Picked</a></li>
                <?php } ?>
                        <li><a href="manage_pick_up.php">Manage Milk Pick Up</a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="fa fa-sitemap"></i> Gee Pick</a>
                    <ul>
                     <?php if(isset($_SESSION['post']) && $_SESSION['post'] == "admin"){ ?>
                        <li><a href="gee_pick_up.php">Gee Picked</a></li>
                        <?php } ?>
                        <li><a href="manage_gee_pick_up.php">Manage Gee Pick Up</a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="fa fa-sitemap"></i> panner Pick</a>
                    <ul>
                     <?php if(isset($_SESSION['post']) && $_SESSION['post'] == "admin"){ ?>
                        <li><a href="panner_pick_up.php">panner Picked</a></li>
                        <?php } ?>
                        <li><a href="manage_panner_pick_up.php">Manage panner Pick Up</a></li>
                    </ul>
                </li>
                     <?php if(isset($_SESSION['post']) && $_SESSION['post'] == "admin"){ ?>
                <li><a href="#"><i class="fa fa-whatsapp"></i> SMS</a>
                    <ul>
                <li><a href="sms.php">Delivery SMS </a></li>
                        <li><a href="bulk_sms.php">Bulk SMS </a></li>
                    </ul>
                </li>
                <?php } ?>
			<li><a href="#"><i class="fa fa-cogs"></i> Account</a>
            					<ul>
            						<li><a href="change-password.php"> Change Password</a></li>
                                     <li><a href="../logout.php"> Logout</a></li>
            					</ul>
            				</li>
            				</ul>
		</nav>