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

    if(isset($_REQUEST['post_client_id'])){
		$_SESSION['client_id'] = $_REQUEST['post_client_id'];
	}

    $user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user_query->bind_param('s', $_SESSION['login_user']);
    $user_query->execute();
    $result = $user_query->get_result();
    $user = $result->fetch_assoc();

    $office = $user['office'];
    $position = $user['position'];

    $client = getClientInfo($db, $_SESSION['client_id']);
    $client_id = $client['client_id'];
    $client_name = $client['client_name'];
    $client_address = $client['address'];

    
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
                    <h3 class="page-header"><i class="fa fa-laptop"></i> <?php echo $client_name; ?></h3>
                    <ol class="breadcrumb">
                        <!-- <li><i class="fa fa-home"></i>Home</li> -->
                        <li><i class="fa fa-address-book"></i><a href="clients.php">Clients</a></li>
                        <li><i class="fa fa-file-text"></i><a href="clients_update_info.php" style="color: blue;">Update Info</a></li>                            
                    </ol>
                </div>
            </div>

            <form class="form-horizontal" role="form" action="clients_update_info.php" id="form" method="post" onsubmit="return confirm('Proceed?');">
				<div class="row">
					<div class="col-md-6">
						<section class="panel">
							<header class="panel-heading">
							Client Info
							</header>
							<div class="panel-body">
								<div class="form-group">
									<label for="update_client_name" class="col-md-4 control-label">Client Name</label>
									<div class="col-md-8">
										<input type="text" id="update_client_name" name="update_client_name" class="form-control" autocomplete="off" value="<?php echo $client_name; ?>" required>
									</div>
								</div>
								<div class="form-group">
									<label for="update_client_address" class="col-md-4 control-label">Client Address</label>
									<div class="col-md-8">
										<input type="text" id="update_client_address" name="update_client_address" class="form-control" autocomplete="off" value="<?php echo $client_address; ?>" required>
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
												<!-- <label for="button"></label> -->
											</td>
										</tr>
<?php

	$sql_contacts = "SELECT client_contact_id, client_contact_name
			    		FROM client_contact_person
			    		WHERE client_id = '$client_id'
			    		GROUP BY client_contact_id";
    		// echo $sql_contacts;
    $sql_result = mysqli_query($db, $sql_contacts);


    $array_contact = array();    
    if(mysqli_num_rows($sql_result) > 0){
    	$hash = 1;
    	while ($sql_row = mysqli_fetch_assoc($sql_result)) {
?>
										<tr id="row<?php echo $hash; ?>" style="text-align: center;">
											<td class="col-md-6">
												<input type="hidden" name="contact_id[]" value="<?php echo $sql_row['client_contact_id']; ?>">
												<!-- <div class="form-group"> -->
													<input type="text" name="update_contact_name[]" class="form-control" autocomplete="off" value="<?php echo $sql_row['client_contact_name']; ?>" required>
												<!-- </div> -->
											</td>
											<td class="col-md-6">
<?php

	$sql_no = "SELECT client_contact_no_id, client_contact_no
				FROM client_contact_number
				WHERE client_contact_id = '".$sql_row['client_contact_id']."'";
	$sql_no_result = mysqli_query($db, $sql_no);

	while ($sql_no_row = mysqli_fetch_assoc($sql_no_result)) {

        $array_contact['contact'][] = array(
                                        'client' => array(
                                            'client_contact_id' => $sql_row['client_contact_id'], 
                                            'contact_no_id' => $sql_no_row['client_contact_no_id']
                                        )
                                    );
        
?>
												<div class="row" style="margin-bottom: 5px;">
                                                    <input type="hidden" name="contact_no_id[]" value="<?php echo $sql_no_row['client_contact_no_id']; ?>">
													<div class="col-md-8">
														<input type="text" name="update_contact_no[]" class="form-control" autocomplete="off" value="<?php echo $sql_no_row['client_contact_no']; ?>" required>
													</div>
													<div class="col-md-1">
														<form action="clients_update_info.php" method="post" onsubmit="return confirm('Remove contact no. <?php echo $sql_no_row['client_contact_no']; ?>?');">
															<input type="hidden" name="hidden_contact_id" value="<?php echo $sql_row['client_contact_id']; ?>">
															<input type="hidden" name="hidden_contact_no_id" value="<?php echo $sql_no_row['client_contact_no_id']; ?>">
															<button type="submit" name="delete_id" class='btn btn-danger btn-md' autocomplete="off">Remove</button>
														</form>
														
													</div>
												</div>
											
											<!-- 
											<td class="col-md-1">
												<div class="form-group">
													<button type="submit" name="delete_id" class='btn btn-danger btn-md' autocomplete="off" value="<?php echo $sql_no_row['client_contact_no_id']; ?>">Remove</button>
												</div>
											</td> -->

<?php
	}

?>
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
		$update_client_name = mysqli_real_escape_string($db, $_POST['update_client_name']);
		$update_address = mysqli_real_escape_string($db, $_POST['update_client_address']);
        $contact_id = $_POST['contact_id'];
       
        $update_client_info = "UPDATE client SET client_name = '$update_client_name', address = '$update_address' WHERE client_id = '$client_id'";
        // echo $update_client_info."<br>";
        mysqli_query($db, $update_client_info);

        // if(isset($update_contact_no)){

            $update_contact_name = $_POST['update_contact_name'];
            $update_contact_no = $_POST['update_contact_no'];
            $contact_encode = json_encode($array_contact);
            $contact_decode = json_decode($contact_encode);

            if(count($contact_decode->contact) > 0){

                for ($i=0; $i < count($contact_decode->contact); $i++) { 

                    $client_contact_id = $contact_decode->contact[$i]->client->client_contact_id;
                    $client_contact_no_id = $contact_decode->contact[$i]->client->contact_no_id;

                    // for ($j=0; $j < count($update_contact_name); $j++) { 
                    //     $update_name = "UPDATE client_contact_person 
                    //                 SET client_contact_name = '$update_contact_name[$j]'
                    //                 WHERE client_contact_id = '$client_contact_id'";

                    //     echo $update_name."<br>";
                    //     // mysqli_query($db, $update_name);
                    // }
                    

                    $update_contact_info = "UPDATE client_contact_number 
                                            SET client_contact_no = '$update_contact_no[$i]' 
                                            WHERE client_contact_id = '$client_contact_id'
                                            AND client_contact_no_id = '$client_contact_no_id'";

                    // echo $update_contact_info."<br>";
                    mysqli_query($db, $update_contact_info); 
                    $count++;      
                }

                for ($j=0; $j < count($contact_id); $j++) { 
                    
                    $update_name = "UPDATE client_contact_person 
                                    SET client_contact_name = '$update_contact_name[$j]'
                                    WHERE client_contact_id = '$contact_id[$j]'";

                    // echo $update_name."<br>";
                    mysqli_query($db, $update_name);
                }
                if($count == count($contact_decode->contact)){
                    echo "<script> 
                            alert('Data updated successfully...');
                            window.location.href='clients.php'
                        </script>";
                }
            }else{
                echo "<script> 
                        alert('Data updated successfully...');
                        window.location.href='clients.php'
                    </script>";
            }
        
		
		

		// if(count($update_contact_name) > 0){
		// 	for ($i=0; $i < count($update_contact_name); $i++) { 

  //               // for ($j=0; $j < count($contact_id); $j++) { 
                    
  //                   $update_name = "UPDATE client_contact_person 
  //                               SET client_contact_name = '$update_contact_name[$i]'
  //                               WHERE client_contact_id = '$contact_id[$i]'";

  //                               echo $update_name."<br>";
  //               // mysqli_query($db, $update_name);


  //               // }
				

		// 		// $explode_id = explode(",", $hidden_contact_no_id[$i]);
		// 		// $explode_no = explode(",", $update_contact_number[$i]);
		// 		for ($j=0; $j < count($update_contact_number); $j++) { 
						
  //                       // for ($k=0; $k < ; $k++) { 
                            
  //                           $update_contact_info = "UPDATE client_contact_number 
  //                                       SET client_contact_no = '$update_contact_number[$j]' 
  //                                       WHERE client_contact_id = '$contact_id[$i]'
  //                                       AND client_contact_no_id = '$contact_no_id[$j]'";

  //                           echo $update_contact_info."<br>";
  //                           // mysqli_query($db, $update_contact_info);         

  //                       // }
							
		// 		}
		// 		$count++;
		// 	}
		
		// 	// if($count == count($update_contact_name)){
		// 	// 	echo "<script> alert('Data updated successfully...');
		// 	// 			window.location.href='clients.php'
		// 	// 			</script>";
		// 	// }
		// }
		// // else{
		// // 	echo "<script> alert('Data updated successfully...');
		// // 				window.location.href='clients.php'
		// // 				</script>";
		// // }
		

	}else if(isset($_POST['delete_id'])){

		$client_contact_id = $_POST['hidden_contact_id'];
		$client_contact_no_id = $_POST['hidden_contact_no_id'];

		// echo $client_contact_id;

		// for ($i=0; $i < count($client_contact_no_id); $i++) { 

			$delete_contact_no = "DELETE FROM client_contact_number WHERE client_contact_no_id = '$client_contact_no_id'";

			if(mysqli_query($db, $delete_contact_no)){
					phpAlert("Contact No. has been deleted...");
					echo "<meta http-equiv='refresh' content='0'>";
			}
			// echo $delete_contact_no."<br>";
		// }
	
		$sql_no_count_query = "SELECT * FROM client_contact_number
								WHERE client_contact_id = '$client_contact_id'";
        // echo $sql_no_count_query;
		$sql_count = mysqli_query($db, $sql_no_count_query);
		if(mysqli_num_rows($sql_count) == 0){

			// for ($j=0; $j < count($client_contact_id); $j++) { 

				$delete_contact_person = "DELETE FROM client_contact_person WHERE client_contact_id = '$client_contact_id'";

				if(mysqli_query($db, $delete_contact_person)){
					phpAlert("Contact has been deleted...");
					echo "<meta http-equiv='refresh' content='0'>";
				}
				// echo $delete_contact_person."<br>";
			// }
		}
		
		

		// echo $delete_contact_no."<br>".$delete_contact_person;
		// if (mysqli_query($db, $delete_contact_no) && mysqli_query($db, $delete_contact_person)) {
		// 	phpAlert("Contact has been deleted...");
		// 	echo "<meta http-equiv='refresh' content='0'>";
		// }
	}

?>