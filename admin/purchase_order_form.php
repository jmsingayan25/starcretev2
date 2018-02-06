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

    <title>Purchase Order Form</title>

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
        var $input = $form.find( "#quantity" );

        $form.on( "keyup", "#quantity", function( event ) {
            
            
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

	function add_row(){
        $count = $count + 1;                      
	 $rowno=$("#item_table tr").length;
	 $rowno=$rowno+1;
	 $("#item_table tr:last").after("<tr id='row"+$rowno+"' style='text-align: center;'><td class='col-md-4'><div class='form-group'><select id='item_no' name='item_no[]' class='form-control' required><option value=''>Select</option><?php
	$sql = "SELECT item_no FROM batch_list ORDER BY item_no ASC";
	$result = mysqli_query($db, $sql);
	foreach($result as $row){
		echo "<option value='" . $row['item_no'] . "'>" . $row['item_no'] . "</option>";
	}
?></select></div></td><td class='col-md-4'><div class='form-group'><input type='text' id='quantity' name='quantity[]' class='form-control' required></div></td><td class='col-md-4'><div class='form-group'><input type='button' value='Remove' class='btn btn-primary btn-md' onclick=delete_row('row"+$rowno+"')></div></td></tr>");
	}

	function delete_row(rowno){
	 $('#'+rowno).remove();
	}

    function add_contact_row(){
     $rowno=$("#contact_table tr").length;
     $rowno=$rowno+1;
     $("#contact_table tr:last").after("<tr id='row_contact_"+$rowno+"'><td class='col-md-8'><select id='contact_name[]' name='contact_name[]' class='form-control' required> <option value=''>Select</option></select></td><td><input type='button' value='Remove' class='btn btn-primary btn-md' onclick=delete_contact_row('row_contact_"+$rowno+"')></td></tr>");
    }

    function delete_contact_row(rowno){
     $('#'+rowno).remove();
    }

	// function displaySiteName(value){
	// 	var a = document.getElementById("site_name_field");
	// 	var b = document.getElementById("contact_field");
	// 	var site_name = document.getElementById("site_name");
	// 	var contact_name = document.getElementById("contact_name");
	// 	var contact_no = document.getElementById("contact_number");

	// 	if(value == ''){
	// 		a.style.display = 'none';
	// 		site_name.value = '';
	// 	}else{
	// 		a.style.display = 'block';
	// 	}

	// 	if(a.style.display == 'none'){
	// 		b.style.display = 'none';
	// 		contact_name.value = '';
	// 		contact_no.value = '';
	// 	}
	// }

	function resetList(value){

		var a = document.getElementById("contact_name");
		var b = document.getElementById("site_id");

		if(value == ''){
			a.options[0].selected="selected";
			b.options[0].selected="selected";
		}
	}

	function displayContactNumber(value){
		var a = document.getElementById("site_contact_field");

		if(value == ''){
			a.style.display = 'none';
		}else{
			a.style.display = 'block';
		}
	}

	function siteName(str) {
	    // if (str == "") {
	    //     document.getElementById("site_id").innerHTML = "";
	    //     return;
	    // } else { 

	        if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                document.getElementById("site_id").innerHTML = this.responseText;
	            }
	        };
	        xmlhttp.open("GET","ajax/list_site_name.php?client="+str,true);
	        xmlhttp.send();
	    // }
	}

	function contactPerson(str) {
	    // if (str == "") {
	    //     document.getElementById("contact_name").innerHTML = "";
	    //     return;
	    // } else { 
	    	
	        if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                document.getElementById("contact_name[]").innerHTML = this.responseText;
	            }
	        };
	        xmlhttp.open("GET","ajax/list_contact_names.php?site_id="+str,true);
	        xmlhttp.send();
	    // }
	}

	function contactNumber(str) {
	    if (str == "") {
	        document.getElementById("contact_number").innerHTML = "";
	        return;
	    } else { 
	        if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                document.getElementById("contact_number").innerHTML = this.responseText;
	            }
	        };
	        xmlhttp.open("GET","ajax/list_contact_number.php?contact_id="+str,true);
	        xmlhttp.send();
	    }
	}
</script>
</head>
<body onload="siteName(''); contactPerson('');">
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

                    <!-- alert notification start-->
                    <li id="alert_notificatoin_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-bell-l"></i>
                            <span class="badge bg-important">7</span>
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <div class="notify-arrow notify-arrow-blue"></div>
                            <li>
                                <p class="blue">You have 4 new notifications</p>
                            </li>
                            <li>
                                <a href="#"><span class="label label-primary"><i class="icon_profile"></i></span>Friend Request<span class="small italic pull-right">5 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="label label-warning"><i class="icon_pin"></i></span>John location.<span class="small italic pull-right">50 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="label label-danger"><i class="icon_book_alt"></i></span>Project 3 Completed.<span class="small italic pull-right">1 hr</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <span class="label label-success"><i class="icon_like"></i></span>Mick appreciated your work.<span class="small italic pull-right"> Today</span>
                                </a>
                            </li>                            
                            <li>
                                <a href="#">See all notifications</a>
                            </li>
                        </ul>
                    </li>
                    <!-- alert notification end-->
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
                <div class="col-lg-12">
                    <h3 class="page-header"><i class="fa fa-laptop"></i> Purchase Order Form</h3>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-building"></i>Home</a></li>
                        <li><i class="icon_document_alt"></i>Purchase Order Form</li>						  	
                    </ol>
                </div>
            </div>
            <!-- Basic Forms & Horizontal Forms-->
            <form class="form-horizontal" role="form" action="purchase_order_form.php" id="form" method="post" onsubmit="return confirm('Proceed?');">
				<div class="row">
					<div class="col-md-6">
						<section class="panel">
							<header class="panel-heading">
							Issue Form
							</header>
							<div class="panel-body">
								<div class="form-group">
									<label for="plant" class="col-md-4 control-label">Plant</label>
									<div class="col-lg-8">
										<label class="radio-inline">
											<input type="radio" id="plant" name="plant" value="bravo" checked> Bravo
										</label>
										<label class="radio-inline">
											<input type="radio" id="plant" name="plant" value="bravo"> Delta
										</label>
									</div>
								</div>
								<div class="form-group">
									<label for="po_no" class="col-md-4 control-label">P.O. No.</label>
									<div class="col-md-8">
										<input type="text" id="po_no" name="po_no" class="form-control" autocomplete="off" required>
									</div>
								</div>
								<div class="form-group">
									<label for="client" class="col-md-4 control-label">Client Name</label>
									<div class="col-md-8">
										<select id="client" name="client" class="form-control" style="width: 100%;" onchange="siteName(this.value); resetList(this.value);" required>
											<option value="">Select</option>
<?php
$sql = "SELECT client_name, client_id FROM client GROUP BY client_name ORDER BY client_name ASC";
$result = mysqli_query($db, $sql);
while ($row = mysqli_fetch_assoc($result)) {
	echo "<option value='".$row['client_id']."'>".$row['client_name']."</option>";
}
?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="site_id" class="col-md-4 control-label">Site Name / Site Address</label>
									<div class="col-md-8">
										<select id="site_id" name="site_id" class="form-control" onchange="contactPerson(this.value);" required>
											<option value="">Select</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="contact_name" class="col-md-4 control-label">Contact Person</label>
                                    <table id="contact_table">
                                        <tr id="row_contact_1">
                                            <td class="col-md-8">
                                                <select id="contact_name[]" name="contact_name[]" class="form-control" required>
                                                    <option value="">Select</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="button" onclick="add_contact_row();" class='btn btn-primary btn-md' autocomplete="off" value="Add Contact">
                                            </td>
                                        </tr>
                                    </table>
									<!-- <div class="col-md-8">
										<select id="contact_name" name="contact_name" class="form-control" onchange="contactNumber(this.value); displayContactNumber(this.value);" required>
											<option value="">Select</option>
										</select>
									</div> -->
								</div>
								<!-- <div class="form-group" id="site_contact_field" style="display: none;">
									<label for="contact_number" class="col-md-4 control-label">Contact Number</label>
									<div class="col-md-8">
										<div id="contact_number" name="contact_number"></div>
									</div>
								</div> -->
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
							Items
							</header>
							<div class="panel-body">
								<div class="row">
									<table id="item_table" align="center">
										<tr>
											<td class="col-md-4">
												<label for="item_no">Item</label>
											</td>
											<td class="col-md-4">
												<label for="quantity">Quantity</label>
											</td>
											<td class="col-md-4">
												<label for="button"></label>
											</td>
										</tr>
										<tr id="row1" style="text-align: center;">
											<td class="col-md-4">
												<div class="form-group">
													<select id="item_no" name="item_no[]" class="form-control" required>
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
											</td>
											<td class="col-md-4">
												<div class="form-group">
													<input type="text" id="quantity" name="quantity[]" class="form-control" autocomplete="off" placeholder="Quantity" required>
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
</body>
</html>
<?php
	if(isset($_POST['submit'])){

		$max = "SELECT MAX(purchase_unique_id) as id
				FROM purchase_order";

		$max_result = mysqli_query($db, $max);
		if(mysqli_num_rows($max_result) > 0){
			$row = mysqli_fetch_assoc($max_result);
			$purchase_unique_id = $row['id'] + 1;
		}else{
			$purchase_unique_id = 1;
		}

		$client_id = $_POST['client'];
		$client = getClientInfo($db, $client_id);
		$client_name = $client['client_name'];

		$site_id = $_POST['site_id'];
		$site = getSiteInfo($db, $site_id);
		$site_name = $site['site_name'];

		$po_no = mysqli_real_escape_string($db, $_POST['po_no']);
		$item = $_POST['item_no'];
		$quantity = str_replace( ',', '', $_POST['quantity']);
		$datetime = date("Y/m/d H:i:s");
		
		$contact_person = mysqli_real_escape_string($db, $_POST['contact_name']);
		// $contact_no = mysqli_real_escape_string($db, $_POST['contact_number']);
		$plant = $_POST['plant'];

		$count = 0;
		for($i = 0; $i < count($item); $i++){
			if($item[$i] != "" && $quantity[$i] != ""){
				$insert_purchase_order = "INSERT INTO purchase_order(purchase_unique_id, purchase_order_no, site_id, item_no, quantity, balance, contact_person_id, date_purchase, office, remarks) VALUES('$purchase_unique_id','$po_no','$site_id','$item[$i]','$quantity[$i]','$quantity[$i]','$contact_person','$datetime','$plant','Pending')";

				$history_query = "INSERT INTO history(table_report, transaction_type, item_no, detail, history_date, office) VALUES('Purchase Order','Issued P.O. No.','$item[$i]','$client_name ordered ".number_format($quantity[$i])." pcs of $item[$i] with P.O. No. $po_no from ".ucfirst($plant)." to be delivered to $site_name','$datetime','$plant')";

				// echo $insert_purchase_order."<br>";
				// echo $history_query."<br>";

				if(mysqli_query($db, $insert_purchase_order) && mysqli_query($db, $history_query)){
					$count++;
				}
			}
		}

		if($count == count($item)){
			phpAlert("Transaction complete. You can view the order on ".ucfirst($plant)." Purchase Order page.");
			echo "<meta http-equiv='refresh' content='0'>";
		}else{
			phpAlert('Something went wrong. Please try again.');
		}

		// $reply = array('post' => $_POST);
		// echo json_encode($reply);
	}
?>