<?php
    ob_start();
    session_start();
?>
<!DOCTYPE html>
<?php

    include("../includes/config.php");
    include("../includes/function.php");

    if(!isset($_SESSION['login_user']) || $_SESSION['login_office'] != 'head') {
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

    <title>New Site Name</title>

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

	function add_row(){
		$rowno=$("#item_table tr").length;
		$rowno=$rowno+1;
		$("#item_table tr:last").after("<tr id='row"+$rowno+"' style='text-align: center;'><td class='col-md-4'><div class='form-group'><input type='type' name='contact_name[]' class='form-control' autocomplete='off' required></div></td><td class='col-md-4'><div class='form-group'><input type='type' name='contact_no[]' class='form-control' autocomplete='off' required></div></td><td class='col-md-4'><div class='form-group'><input type='button' value='Remove' class='btn btn-primary btn-md' onclick=delete_row('row"+$rowno+"')></div></td></tr>");
	}

	function delete_row(rowno){
		$('#'+rowno).remove();
	}

</script>
</head>
<body>
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
	                <li>
	                    <a class="" href="index.php">
	                        <i class="icon_house"></i>
	                        <span>History</span>
	                    </a>
	                </li>
	<!--                 <li class="sub-menu">                       
	                    <a class="" href="form_validation.html">Form Validation</a>
	                </li>   --> 
	                <li>
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
	                <div class="col-lg-12">
	                    <h3 class="page-header"><i class="fa fa-laptop"></i> New Site Contacts</h3>
	                    <ol class="breadcrumb">
	                        <li><i class="fa fa-building"></i>Home</a></li>
	                        <li><a href="clients.php"><i class="icon_document_alt"></i>Client</a></li>
	                        <li><a href="client_sites.php"><i class="icon_document_alt"></i>Sites</a></li>
	                        <li><i class="icon_document_alt"></i>New Contact Person</li>						  	
	                    </ol>
	                </div>
	            </div>
             	<form class="form-horizontal" role="form" action="add_site_contact.php" id="form" method="post" onsubmit="return confirm('Proceed?');">
	            	<div class="row">
	            		<!-- Start column for client and site info -->
	            		<div class="col-md-6">
	            			<div class="row">
								<div class="col-md-12">
									<section class="panel">
										<header class="panel-heading">
										Site Info
										</header>
										<div class="panel-body">
											<div class="form-group">
												<label for="site_name" class="col-md-4 control-label">Site Name: </label>
												<div class="col-md-8">
													<label class="control-label"><?php echo $site_name; ?></label>
												</div>
											</div>
											<div class="form-group">
												<label for="site_address" class="col-md-4 control-label">Site Address: </label>
												<div class="col-md-8">
													<label class="control-label"><?php echo $site_address; ?></label>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-offset-8 col-md-4">
													<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary">
													<!-- <a href="delivery_transaction.php" class="btn btn-warning">Cancel</a> -->
													<input type="reset" name="reset" id="reset" value="Reset" class="btn btn-warning">
												</div>
											</div>
										</div>
									</section>
								</div>
							</div>
						</div>
						<div class="col-md-6">
	            			<div class="row">
								<div class="col-md-12">
									<section class="panel">
										<header class="panel-heading">
										Site Contact
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
															<label for="button"></label>
														</td>
													</tr>
													<tr id="row1" style="text-align: center;">
														<td class="col-md-3">
															<div class="form-group">
																<input type="type" name="contact_name[]" class="form-control" autocomplete="off" required>
															</div>
														</td>
														<td class="col-md-5">
															<div class="form-group" >
																<input type="type" name="contact_no[]" class="form-control" autocomplete="off" required>
															</div>
														</td>
														<td class="col-md-4">
															<div class="form-group">
																<input type="button" onclick="add_row();" class='btn btn-primary btn-md' autocomplete="off" value="Add Item">
															</div>
														</td>
													</tr>
												</table>
											</div>
										</div>
									</section>
								</div>
							</div>
	            		</div>
					</div>
				</form>
			</section>
		</section>
	</section>
</body>
</html>
<?php

	if(isset($_POST['submit'])){

		$count = 0;
		$contact_name = $_POST['contact_name'];
		$contact_no = $_POST['contact_no'];

		for ($i=0; $i < count($contact_name); $i++) { 
			
			$insert_contact_person = "INSERT INTO site_contact_person(site_contact_name, site_id)
										VALUES('$contact_name[$i]','$site_id')";

			if(mysqli_query($db, $insert_contact_person)){
				$explode_no = explode(",",$contact_no[$i]);
				for ($j=0; $j < count($explode_no); $j++) { 
					
					$sql = "SELECT MAX(site_contact_person_id) as site_contact_person_id FROM site_contact_person
							WHERE site_contact_name = '$contact_name[$i]' AND site_id = '$site_id'";

					$result = mysqli_query($db, $sql);
					$row = mysqli_fetch_assoc($result);
					$site_contact_person_id = $row['site_contact_person_id'];

					$insert_contact_no = "INSERT INTO site_contact_number(site_contact_no, site_contact_person_id)
											VALUES('$explode_no[$j]','$site_contact_person_id')";

					mysqli_query($db, $insert_contact_no);
				}
				$count++;
			}
		}

		if($count == count($contact_name)){
			phpAlert("New contacts added successfully.");
			echo "<meta http-equiv='refresh' content='0'>";
		}
	}



?>