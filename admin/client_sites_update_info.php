<?php
    ob_start();
    session_start();
?>
<!DOCTYPE html>
<?php

    include("../includes/config.php");
    include("../includes/function.php");

    if(!isset($_SESSION['login_user']) && !isset($_SESSION['login_office']) || $_SESSION['login_office'] != 'head') {
        header("location: ../login.php");
    }

    if(isset($_REQUEST['post_site_id'])){
		$_SESSION['site_id'] = $_REQUEST['post_site_id'];
	}

    $user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user_query->bind_param('s', $_SESSION['login_user']);
    $user_query->execute();
    $result = $user_query->get_result();
    $user = $result->fetch_assoc();

    $office = $user['office'];
    $position = $user['position'];

    $info = getSiteInfo($db, $_SESSION['site_id']);
    $site_id = $info['site_id'];
    $site_name = $info['site_name'];
    $site_address = $info['site_address'];

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Clients Update Info</title>

    <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- owl carousel -->
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
    <link href="css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <!-- Custom styles -->
    <link rel="stylesheet" href="css/fullcalendar.css">
    <link href="css/widgets.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <link href="css/xcharts.min.css" rel=" stylesheet"> 
    <link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">

    <!-- javascripts -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui-1.10.4.min.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <!-- bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <!-- charts scripts -->
    <script src="assets/jquery-knob/js/jquery.knob.js"></script>
    <script src="js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="js/owl.carousel.js" ></script>
    <!-- jQuery full calendar -->
    <script src="js/fullcalendar.min.js"></script> <!-- Full Google Calendar - Calendar -->
    <script src="assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
    <!--script for this page only-->
    <script src="js/calendar-custom.js"></script>
    <script src="js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="js/jquery.customSelect.min.js" ></script>
    <script src="assets/chart-master/Chart.js"></script>

    <!--custome script for all page-->
    <script src="js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="js/sparkline-chart.js"></script>
    <script src="js/easy-pie-chart.js"></script>
    <script src="js/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="js/jquery-jvectormap-world-mill-en.js"></script>
    <script src="js/xcharts.min.js"></script>
    <script src="js/jquery.autosize.min.js"></script>
    <script src="js/jquery.placeholder.min.js"></script>
    <script src="js/gdp-data.js"></script>  
    <script src="js/morris.min.js"></script>
    <script src="js/sparklines.js"></script>    
    <script src="js/charts.js"></script>
    <script src="js/jquery.slimscroll.min.js"></script>

    <!-- =======================================================
    Theme Name: NiceAdmin
    Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    Author: BootstrapMade
    Author URL: https://bootstrapmade.com
    ======================================================= -->
<script>
</script>
<style>
.page_links a{
    color: inherit;
}
</style>
</head>
<body>
<!-- container section start -->
    <section id="container" class="">
        <header class="header dark-bg">
            <div class="toggle-nav">
            <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
            </div>

            <!--logo start-->

            <!--logo end-->
            <a href='index.php' class='logo'>Starcrete <span class='lite'>Manufacturing Corporation</span></a>
            <div class="top-nav notification-row">                
                <!-- notificatoin dropdown start-->
                <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <!--  <span class="profile-ava">
                        <img alt="" src="img/avatar1_small.jpg">
                        </span> -->
                            <span class="username"><?php echo ucfirst($user['firstname']); ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li>
                                <a href="logout.php"><i class="icon_key_alt"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!-- notificatoin dropdown end-->
            </div>
        </header>      
    <!--header end-->

    <!--sidebar start-->
    <aside>
        <div id="sidebar"  class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu">                
                <li class="">
                    <a class="" href="index.php">
                        <i class="icon_house"></i>
                        <span>History</span>
                    </a>
                </li>
                <li class="active">
                    <a class="" href="clients.php">
                        <i class="fa fa-address-book"></i>
                        <span>Clients</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="fa fa-building"></i>
                        <span>Bravo</span>
                        <span class="menu-arrow arrow_carrot-right"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="" href="bravo_purchase_order.php">Purchase Order</a></li>                          
                        <li><a class="" href="bravo_delivery_order.php">Delivery Page</a></li>
                    </ul>
                </li>  
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="fa fa-building"></i>
                        <span>Delta</span>
                        <span class="menu-arrow arrow_carrot-right"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="" href="delta_purchase_order.php">Purchase Order</a></li>                          
                        <li><a class="" href="delta_delivery_order.php">Delivery Page</a></li>
                    </ul>
                </li>  
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="fa fa-file"></i>
                        <span>Forms</span>
                        <span class="menu-arrow arrow_carrot-right"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="" href="purchase_order_form.php">Purchase Order Form</a></li>                          
                    </ul>
                </li>     
            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">            
            <!--overview start-->
            <div class="row">
                <div class="col-md-12 page_links">
                    <h3 class="page-header"><i class="fa fa-laptop"></i> <?php echo $site_name; ?></h3>
                    <ol class="breadcrumb">
                        <!-- <li><i class="fa fa-home"></i>Home</li> -->
                        <li><i class="fa fa-laptop"></i><a href="clients.php">Clients</a></li>
                        <li><i class="fa fa-laptop"></i><a href="client_sites.php">Sites</a></li>
                        <li><i class="fa fa-laptop"></i><a href="client_sites_update_info.php" style="color: blue;">Update Info</a></li>                            
                    </ol>
                </div>
            </div>

            <form class="form-horizontal" role="form" action="client_sites_update_info.php" id="form" method="post" onsubmit="return confirm('Proceed?');">
				<div class="row">
					<div class="col-md-6">
						<section class="panel">
							<header class="panel-heading">
							Site Info
							</header>
							<div class="panel-body">
								<div class="form-group">
									<label for="update_site_name" class="col-md-4 control-label">Site Name</label>
									<div class="col-md-8">
										<input type="text" id="update_site_name" name="update_site_name" class="form-control" autocomplete="off" value="<?php echo $site_name; ?>" required>
									</div>
								</div>
								<div class="form-group">
									<label for="update_site_address" class="col-md-4 control-label">Site Address</label>
									<div class="col-md-8">
										<input type="text" id="update_site_address" name="update_site_address" class="form-control" autocomplete="off" value="<?php echo $site_address; ?>" required>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-8 col-md-4">
										<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary">
										<input type="reset" name="reset" id="reset" value="Reset" class="btn btn-warning">
									</div>
								</div>
							</div>
						</section>
					</div>
					<div class="col-md-6">
						<section class="panel">
							<header class="panel-heading">
							Contact
							</header>
							<div class="panel-body">
								<div class="row">
									<table id="item_table" align="center">
										<tr>
											<td class="col-md-4">
												<label for="item_no">Name</label>
											</td>
											<td class="col-md-4">
												<label for="quantity">Number</label>
											</td>
											<td class="col-md-4">
												<!-- <label for="button"></label> -->
											</td>
										</tr>
<?php

	$sql_contacts = "SELECT p.site_contact_person_id, p.site_contact_name, GROUP_CONCAT(n.site_contact_no SEPARATOR ', ') as site_contact_no
			FROM site_contact_person p, site_contact_number n
			WHERE p.site_contact_person_id = n.site_contact_person_id
			AND site_id = '$site_id'
			GROUP BY p.site_contact_person_id";

	$sql_result = mysqli_query($db, $sql_contacts);
    if(mysqli_num_rows($sql_result) > 0){
    	$hash = 1;
    	while ($sql_row = mysqli_fetch_assoc($sql_result)) {
?>
										<tr id="row<?php echo $hash; ?>" style="text-align: center;">
											<td class="col-md-3">
												<input type="hidden" name="contact_id[]" value="<?php echo $sql_row['site_contact_person_id']; ?>">
												<div class="form-group">
													<input type="text" name="contact_name[]" class="form-control" autocomplete="off" value="<?php echo $sql_row['site_contact_name']; ?>" required>
												</div>
											</td>
											<td class="col-md-5">
												<div class="form-group" >
													<input type="text" name="contact_no[]" class="form-control" autocomplete="off" value="<?php echo $sql_row['site_contact_no']; ?>" required>
												</div>
											</td>
										</tr>

<?php
    		$hash++;
    	}
    }
?>
									</table>
								</div>
							</div>
						</section>
					</div>
				</div>
			</form>
		</section>
	</section>
</section>
</body>
</html>
<?php

	if (isset($_POST['submit'])) {
		
		$count = 0;
		$update_site_name = mysqli_real_escape_string($db, $_POST['update_site_name']);
		$update_site_address = mysqli_real_escape_string($db, $_POST['update_site_address']);
		$update_contact_name = $_POST['contact_name'];
		$update_contact_no = $_POST['contact_no'];
		$hidden_contact_id = $_POST['contact_id'];

		$update_site = "UPDATE site 
						SET site_name = '$update_site_name', site_address = '$update_site_address'
						WHERE site_id = '$site_id'";

		echo $update_site."<br>";
		// mysqli_query($db, $update_site);

		for ($i=0; $i < count($update_contact_name); $i++) { 
			
			$update_contact = "UPDATE site_contact_person p, site_contact_number n 
								SET p.site_contact_name = '$update_contact_name[$i]', n.site_contact_no = '$update_contact_no[$i]'
								WHERE p.site_id = $site_id 
								AND p.site_contact_person_id = '$hidden_contact_id[$i]'
								AND n.site_contact_person_id = '$hidden_contact_id[$i]'";

			echo $update_contact."<br>";
			// mysqli_query($db, $update_contact);
			$count++;
		}

		if($count == count($update_contact_name)){
			echo "<script> alert('Data updated successfully...');
					window.location.href='client_sites.php'
					</script>";
		}

	}


?>