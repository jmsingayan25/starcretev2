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

    $user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user_query->bind_param('s', $_SESSION['login_user']);
    $user_query->execute();
    $result = $user_query->get_result();
    $user = $result->fetch_assoc();

    $office = $user['office'];
    $position = $user['position'];

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>New Client</title>

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
	                <!-- <li class="sub-menu">
	                <a href="javascript:;" class="">
	                <i class="icon_desktop"></i>
	                <span>UI Fitures</span>
	                <span class="menu-arrow arrow_carrot-right"></span>
	                </a>
	                <ul class="sub">
	                <li><a class="" href="general.html">Elements</a></li>
	                <li><a class="" href="buttons.html">Buttons</a></li>
	                <li><a class="" href="grids.html">Grids</a></li>
	                </ul>
	                </li>                         
	                <li class="sub-menu">
	                <a href="javascript:;" class="">
	                <i class="icon_table"></i>
	                <span>Tables</span>
	                <span class="menu-arrow arrow_carrot-right"></span>
	                </a>
	                <ul class="sub">
	                <li><a class="" href="basic_table.html">Basic Table</a></li>
	                </ul>
	                </li>

	                <li class="sub-menu">
	                <a href="javascript:;" class="">
	                <i class="icon_documents_alt"></i>
	                <span>Pages</span>
	                <span class="menu-arrow arrow_carrot-right"></span>
	                </a>
	                <ul class="sub">                          
	                <li><a class="" href="profile.html">Profile</a></li>
	                <li><a class="" href="login.html"><span>Login Page</span></a></li>
	                <li><a class="" href="blank.html">Blank Page</a></li>
	                <li><a class="" href="404.html">404 Error</a></li>
	                </ul> -->
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
	                    <h3 class="page-header"><i class="fa fa-laptop"></i> New Client</h3>
	                    <ol class="breadcrumb">
	                        <li><i class="fa fa-building"></i>Home</a></li>
	                        <li><a href="clients.php"><i class="icon_document_alt"></i>Client</a></li>						  	
	                        <li><i class="icon_document_alt"></i>Form</li>						  	
	                    </ol>
	                </div>
	            </div>
	            <!-- Basic Forms & Horizontal Forms-->
	            <form class="form-horizontal" role="form" action="add_client.php" id="form" method="post" onsubmit="return confirm('Proceed?');">
					<div class="row">
						<div class="col-md-6">
							<section class="panel">
								<header class="panel-heading">
								Client Info
								</header>
								<div class="panel-body">
									<div class="form-group">
										<label for="client_name" class="col-md-4 control-label">Client Name</label>
										<div class="col-md-8">
											<input type="text" id="client_name" name="client_name" class="form-control" autocomplete="off" required>
										</div>
									</div>
									<div class="form-group">
										<label for="client_address" class="col-md-4 control-label">Client Address</label>
										<div class="col-md-8">
											<input type="text" id="client_address" name="client_address" class="form-control" autocomplete="off" required>
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
				</form>
			</section>
		</section>
	</section>
</body>
</html>
<?php

	if(isset($_POST['submit'])){

		$count = 0;
		$array_contact_name = array();
		$client_name = $_POST['client_name'];
		$address = $_POST['client_address'];
		$contact_name = $_POST['contact_name'];
		$contact_no = $_POST['contact_no'];

		$insert_client = "INSERT INTO client(client_name, address) VALUES('$client_name','$address')";

		if(mysqli_query($db, $insert_client)){

			$sql = "SELECT MAX(client_id) as client_id FROM client";
			$result = mysqli_query($db, $sql);
			$row = mysqli_fetch_assoc($result);
			$client = $row['client_id'];

			for($i = 0; $i < count($contact_name); $i++){
				$array_contact_name[] = $contact_name[$i];

				$insert_contact_person = "INSERT INTO client_contact_person(client_contact_name, client_id) 
									VALUES('$contact_name[$i]','$client')";

				// echo $insert_contact_person."<br>";
				mysqli_query($db, $insert_contact_person);
			}

			for ($j=0; $j < count($array_contact_name); $j++) { 
				
				// echo $array_contact_name[$j]." ".$contact_no[$j]."<br>";
				$sql_contact_id = "SELECT client_contact_id FROM client_contact_person
						WHERE client_contact_name = '$array_contact_name[$j]'
						AND client_id = '$client'";

				$result_contact_id = mysqli_query($db, $sql_contact_id);
				$row_id = mysqli_fetch_assoc($result_contact_id);

				$explode_no = explode(",", $contact_no[$j]);
				for ($k=0; $k < count($explode_no); $k++) { 
					
					// echo $row_id['client_contact_id']." ".$explode_no[$k]."<br>";

					$insert_contact_number = "INSERT INTO client_contact_number(client_contact_no, client_contact_id) 
												VALUES('$explode_no[$k]','".$row_id['client_contact_id']."')";

					mysqli_query($db, $insert_contact_number);
				}

				$count++;
			}
			if($count == count($array_contact_name)){
				phpAlert("New client added successfully.");
				echo "<meta http-equiv='refresh' content='0'>";
			}
			


			// $insert_contact_no = "INSERT INTO client_contact_number(client_contact_no, client_contact_id) 
			// 					VALUES('$contact_no','$client_contact_id')";

			
		}
		

		// for($i = 0; $i < count($client_name); $i++){

		// 	$insert_client = "INSERT INTO client(client_name) VALUES('$client_name[$i]')";

		// 	if(mysqli_query($db, $insert_client)){
		// 		// $count++;
		// 		$sql = "SELECT client_id FROM client WHERE client_name = '".$client_name."'";
		// 		$result = mysqli_result($db, $sql);
		// 		$row = mysqli_fetch_assoc($result);

		// 		$_SESSION['post_client_id'] = $row['client_id'];
		// 		header("location: purchase_order_form.php");
		// 	}
		// }

		$reply = array('post' => $_POST);

		// echo json_encode($reply);

		// if($count == count($client_name)){
		// 	phpAlert("All client successfully added!!");
		// 	header("location: purchase_order_form.php");
		// }
	}

?>