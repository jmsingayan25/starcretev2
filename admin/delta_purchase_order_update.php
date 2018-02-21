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

	if(isset($_SESSION['post_purchase_id'])){
		$_SESSION['purchase_id'] = $_SESSION['post_purchase_id'];
	}

	$user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
	$user_query->bind_param('s', $_SESSION['login_user']);
	$user_query->execute();
	$result = $user_query->get_result();
	$user = $result->fetch_assoc();

	$office = $user['office'];
	$position = $user['position'];

	$purchase_id = $_SESSION['purchase_id'];
	$search_sql = "SELECT *, s.site_id, s.site_address FROM purchase_order p, site s 
					WHERE p.site_id = s.site_id
					AND p.purchase_id = '$purchase_id'";
	$search_result = mysqli_query($db, $search_sql);
	$purchase_row = mysqli_fetch_assoc($search_result);

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Purchase Order Update</title>

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

	$(function() {
        
        // var $form = $( "#form" );
        // var $input = $form.find( "#quantity" );

        // $input.on( "keyup", function( event ) {

	 	var $form = $( "#form" );
        var $input = $form.find( "#update_quantity" );

        $form.on( "keyup", "#update_quantity", function( event ) {
            
            
            // When user select text in the document, also abort.
            var selection = window.getSelection().toString();
            if ( selection !== '' ) {
                return;
            }
            
            // When the arrow keys are pressed, abort.
            if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return;
            }
            
            
            var $this = $( this );
            
            // Get the value.
            var input = $this.val();
            
            var input = input.replace(/[\D\s\._\-]+/g, "");
                    input = input ? parseInt( input, 10 ) : 0;

                    $this.val( function() {
                        return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
                    } );
        } );      
    });

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
                    <li>
                        <a class="" href="index.php">
                            <i class="icon_house"></i>
                            <span>History</span>
                        </a>
                    </li>
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
                    <div class="col-lg-12 page_links">
                        <h3 class="page-header"><i class="fa fa-building"></i> Purchase Order Update</h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-building"></i>Delta</a></li>
                            <li><a href="delta_purchase_order.php"><i class="icon_document"></i>Purchase Order</a></li>
                            <li><i class="fa fa-file-text"></i><a onclick="window.location.href=this" style="cursor: pointer; color: blue;">Update</a></li>					  	
                        </ol>
                    </div>
                </div>

                <!-- Basic Forms & Horizontal Forms-->
              
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<section class="panel">
							<header class="panel-heading">
							Update Form
							</header>
							<div class="panel-body">
								<form class="form-horizontal" role="form" id="form" action="delta_purchase_order_update.php" method="post" onsubmit="return confirm('Proceed?');">
									<div class="form-group">
										<label for="update_po_no" class="col-md-3 control-label">P.O. No.</label>
										<div class="col-md-6">
											<input type="text" id="update_po_no" name="update_po_no" value="<?php echo $purchase_row['purchase_order_no']; ?>" class="form-control" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="update_address" class="col-md-3 control-label">Site Address</label>
										<div class="col-md-6">
											<input type="text" id="update_address" name="update_address" value="<?php echo $purchase_row['site_address']; ?>" class="form-control" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="item_no" class="col-md-3 control-label">Current Item</label>
										<div class="col-md-6">
											<input type="text" id="item_no" name="item_no" value="<?php echo $purchase_row['item_no']; ?>" class="form-control" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="update_item_no" class="col-md-3 control-label">New Item</label>
										<div class="col-md-6">
											<select id="update_item_no" name="update_item_no" class="form-control">
												<option value="">Select</option>
<?php
	$sql = "SELECT item_no FROM batch_list ORDER BY item_no ASC";
	$result = mysqli_query($db, $sql);
	foreach($result as $row){
									echo "<option value='" . $row['item_no'] . "'>" . $row['item_no'] . "</option>";
	}
?>							
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="item_no" class="col-md-3 control-label">Quantity</label>
										<div class="col-md-6">
											<input type="text" id="update_quantity" name="update_quantity" class="form-control" autocomplete="off" value="<?php echo number_format($purchase_row['quantity']); ?>" required>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-offset-8 col-md-4">
											<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary">
											<a href="delta_purchase_order.php" class="btn btn-warning">Cancel</a>
										</div>
									</div>
								</form>
							</div>
						</section>
					</div>
				</div>
				<div class="text-right">
		            <div class="credits">
		                <!-- 
		                All the links in the footer should remain intact. 
		                You can delete the links only if you purchased the pro version.
		                Licensing information: https://bootstrapmade.com/license/
		                Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
		                -->
		                <a href="https://bootstrapmade.com/free-business-bootstrap-themes-website-templates/">Business Bootstrap Themes</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
		            </div>
		        </div>
            </section>
        </section>
    </section>
</body>
</html>
<?php

	if(isset($_POST['submit'])){

		$site_id = $purchase_row['site_id'];
		$update_purchase_order_no = mysqli_real_escape_string($db, $_POST['update_po_no']);
		$_POST['update_quantity'] = mysqli_real_escape_string($db, $_POST['update_quantity']);
		$update_quantity = str_replace(",", "", $_POST['update_quantity']);
		$update_address = mysqli_real_escape_string($db, $_POST['update_address']);

		if(isset($_POST['update_item_no']) && $_POST['update_item_no'] != ''){
			$update_item_no = mysqli_real_escape_string($db, $_POST['update_item_no']);
		}else{
			$update_item_no = mysqli_real_escape_string($db, $_POST['item_no']);
		}

		$datetime = date("Y/m/d H:i:s");
		$plant = ucfirst($purchase_row['office']);

		// $reply = array('post' => $_POST);
		// echo json_encode($reply);

		if($update_quantity < $purchase_row['balance']){

			$update_quantity_balance = "UPDATE purchase_order SET quantity = '$update_quantity', balance = '$update_quantity'
										WHERE purchase_id = '$purchase_id'";
		}else{

			$update_quantity_balance = "UPDATE purchase_order SET quantity = '$update_quantity'
										WHERE purchase_id = '$purchase_id'";
		}

		$address_update = "UPDATE site SET site_address = '$update_address' WHERE site_id = '$site_id'";

		$sql_update = "UPDATE purchase_order SET purchase_order_no = '$update_purchase_order_no', item_no = '$update_item_no'  WHERE purchase_id = '$purchase_id'";

		if($update_purchase_order_no != $purchase_row['purchase_order_no'] && $update_item_no == $purchase_row['item_no'] && $update_quantity == $purchase_row['quantity']){
			// update po no only
			$history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 					VALUES('Purchase Order','Update Purchase Order','Update P.O. No. ".$purchase_row['purchase_order_no']." to $update_purchase_order_no','$datetime','".$purchase_row['office']."')";

		}else if($update_purchase_order_no == $purchase_row['purchase_order_no'] && $update_item_no != $purchase_row['item_no'] && $update_quantity == $purchase_row['quantity']){
			// update item only
			$history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 					VALUES('Purchase Order','Update Purchase Order','Update ".$purchase_row['item_no']." to $update_item_no under P.O. No. ".$purchase_row['purchase_order_no']."','$datetime','".$purchase_row['office']."')";

		}else if($update_purchase_order_no == $purchase_row['purchase_order_no'] && $update_item_no == $purchase_row['item_no'] && $update_quantity != $purchase_row['quantity']){
			// update quantity only
			$history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 					VALUES('Purchase Order','Update Purchase Order','Update ".$purchase_row['item_no']." pcs from ".number_format($purchase_row['quantity'])." pcs to ".number_format($update_quantity)." pcs under P.O. No. ".$purchase_row['purchase_order_no']."','$datetime','".$purchase_row['office']."')";

		}else if($update_purchase_order_no != $purchase_row['purchase_order_no'] && $update_item_no != $purchase_row['item_no'] && $update_quantity == $purchase_row['quantity']){
			// update po no and item only
			$history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 					VALUES('Purchase Order','Update Purchase Order','Update P.O. No. ".$purchase_row['purchase_order_no']." to $update_purchase_order_no and item ".$purchase_row['item_no']." to $update_item_no','$datetime','".$purchase_row['office']."')";

		}else if($update_purchase_order_no != $purchase_row['purchase_order_no'] && $update_item_no == $purchase_row['item_no'] && $update_quantity != $purchase_row['quantity']){
			// update po no and quantity only
			$history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 					VALUES('Purchase Order','Update Purchase Order','Update P.O. No. ".$purchase_row['purchase_order_no']." to $update_purchase_order_no and its quantity to ".number_format($update_quantity)." pcs','$datetime','".$purchase_row['office']."')";

		}else if($update_purchase_order_no == $purchase_row['purchase_order_no'] && $update_item_no != $purchase_row['item_no'] && $update_quantity != $purchase_row['quantity']){
			// update item and quantity only
			$history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 					VALUES('Purchase Order','Update Purchase Order','Update ".$purchase_row['item_no']." to $update_item_no and its quantity to ".number_format($update_quantity)." pcs under P.O. No. ".$purchase_row['purchase_order_no']."','$datetime','".$purchase_row['office']."')";

		}else if($update_purchase_order_no != $purchase_row['purchase_order_no'] && $update_item_no != $purchase_row['item_no'] && $update_quantity != $purchase_row['quantity']){
			// update all fields
			$history = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
		 					VALUES('Purchase Order','Update Purchase Order','Update P.O. No. ".$purchase_row['purchase_order_no']." to $update_purchase_order_no, ".$purchase_row['item_no']." to $update_item_no and its quantity to ".number_format($update_quantity)." pcs','$datetime','".$purchase_row['office']."')";
		}

		// echo $sql_update."<br>";
		// echo $update_quantity_balance."<br>";
		// echo $address_update."<br>";
		// echo $sql_update."<br>";
		// echo $history;
		
		// echo "<script> alert('Purchase Order No. succesfully updated')</script>";
		if(mysqli_query($db, $sql_update) && mysqli_query($db, $update_quantity_balance) && mysqli_query($db, $address_update)){
			if(isset($history)){
				mysqli_query($db, $history);
				echo "<script>alert('P.O. No. $update_purchase_order_no details has been updated'); window.location.href='delta_purchase_order.php'</script>";
				unset($_SESSION['post_purchase_id']);
				// echo $history;
			}else{
				echo "<script> alert('P.O. No. $update_purchase_order_no details has been updated');window.location.href='delta_purchase_order.php'</script>";
				unset($_SESSION['post_purchase_id']);
			}
		}else{
			phpAlert('Something went wrong. Please try again.');
			// phpAlert("Error description: " . mysqli_error($db));
			echo "<meta http-equiv='refresh' content='0'>";
		}

		// $reply = array('post' => $_POST);
		// echo json_encode($reply);
	}

?>