<?php
	ob_start();
	session_start();
?>
<!DOCTYPE html>
<?php

    include("../includes/config.php");
    include("../includes/function.php");

    if(!isset($_SESSION['login_user']) && $_SESSION['login_office'] == 'head') {
        header("location: ../login.php");
    }

     if(!isset($_GET['page']) || $_GET['page'] == ''){
        $_GET['page'] = 0;
    }

    if(!isset($_POST['start_date'])){
        $_POST['start_date'] = '';
    }

    if(!isset($_POST['end_date'])){
        $_POST['end_date'] = '';
    }

    $user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user_query->bind_param('s', $_SESSION['login_user']);
    $user_query->execute();
    $result = $user_query->get_result();
    $user = $result->fetch_assoc();

    $office = $user['office'];
    $position = $user['position'];
    $limit = 20; //how many items to show per page

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>On Delivery - Delivery Order</title>

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

    var timer = null;

    function goAway() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            window.location.reload(true);
        }, 60000);
    }

    window.addEventListener('mousemove', goAway, true);
    window.addEventListener('keypress', goAway, true);

    goAway();


    $(document).ready(function(){
        $('.filterable .btn-filter').click(function(){
            var $panel = $(this).parents('.filterable'),
            $filters = $panel.find('.filters input'),
            $tbody = $panel.find('.table tbody');
            if ($filters.prop('disabled') == true) {
                $filters.prop('disabled', false);
                $filters.first().focus();
            } else {
                $filters.val('').prop('disabled', true);
                $tbody.find('.no-result').remove();
                $tbody.find('tr').show();
            }
        });

        $('.filterable .filters input').keyup(function(e){
            /* Ignore tab key */
            var code = e.keyCode || e.which;
            if (code == '9') return;
            /* Useful DOM data and selectors */
            var $input = $(this),
            inputContent = $input.val().toLowerCase(),
            $panel = $input.parents('.filterable'),
            column = $panel.find('.filters th').index($input.parents('th')),
            $table = $panel.find('.table'),
            $rows = $table.find('tbody tr');
            /* Dirtiest filter function ever ;) */
            var $filteredRows = $rows.filter(function(){
                var value = $(this).find('td').eq(column).text().toLowerCase();
                return value.indexOf(inputContent) === -1;
            });
            /* Clean previous no-result if exist */
            $table.find('tbody .no-result').remove();
            /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
            $rows.show();
            $filteredRows.hide();
            /* Prepend no-result row if all rows are filtered */
            if ($filteredRows.length === $rows.length) {
                 $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="10" style="min-height: 100%;background: white; text-align:center; vertical-align:middle;"><h4><p class="text-muted">No data found</p></h4></td></tr>'));
            }
        });

        $.ajax({
            url: 'purchase_order.php',
            method: get,
            data:{
                var1 : val1
            },
            success: function(response){
                $('#tbody').html(response);     // it will update the html of table body
            }
        });
    });

</script>
<style>
.table_page{
    margin: auto;
    margin-top: -30px;
    width: 50%;
    text-align: center;
}

.filterable .panel-heading .pull-right {
    margin-top: -20px;
}
.filterable .filters input[disabled] {
    background-color: transparent;
    text-align: center;
    border: none;
    cursor: auto;
    box-shadow: none;
    padding: 0;
    height: auto;
}
.filterable .filters input[disabled]::-webkit-input-placeholder {
    color: gray;
    text-align: left;
    font-weight: bold;
}
.filterable .filters input[disabled]::-moz-placeholder {
     color: gray;
     text-align: left;
     font-weight: bold;
}
.filterable .filters input[disabled]:-ms-input-placeholder {
     color: gray;
     text-align: left;
     font-weight: bold;
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
<?php
    if($office == 'delta'){
        echo "<a href='index.php' class='logo'>Quality Star <span class='lite'>Concrete Products, Inc.</span></a>";
    }else{
        echo "<a href='index.php' class='logo'>Starcrete <span class='lite'>Manufacturing Corporation</span></a>";
    }
?>
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
        <!--sidebar start-->
	    <aside>
	        <div id="sidebar"  class="nav-collapse ">
	            <!-- sidebar menu start-->
	            <ul class="sidebar-menu">                
	                <li class="">
	                    <a class="" href="index.php">
	                        <i class="icon_house_alt"></i>
	                        <span>History</span>
	                    </a>
	                </li>
	                <li class="sub-menu">
	                    <a href="javascript:;" class="">
	                        <i class="fa fa-building"></i>
	                        <span>Purchase Order</span>
	                        <span class="menu-arrow arrow_carrot-right"></span>
	                    </a>
	                    <ul class="sub">
	                        <li><a class="" href="plant_purchase_order.php">Pending Order</a></li>                          
	                        <li><a class="" href="plant_cancelled_order.php">Cancelled Order</a></li>
	                    </ul>
	                </li>  
	                <li class="sub-menu">
	                    <a href="javascript:;" class="">
	                        <i class="fa fa-building"></i>
	                        <span>Delivery Order</span>
	                        <span class="menu-arrow arrow_carrot-right"></span>
	                    </a>
	                    <ul class="sub">
	                    	<li><a class="" href="plant_delivery_issue.php">No DR. No. <span class='badge'><?php echo getCountPlantPo($db, $office); ?></span></a></li>       
	                        <li><a class="" href="plant_delivery_order.php">On Delivery Order</a></li>           
	                        <li><a class="" href="plant_delivery_delivered.php">Delivered Order</a></li>
	                        <li><a class="" href="plant_delivery_backloaded.php">Backloaded Order</a></li>
	                    </ul>
	                </li>  
	<!--                 <li class="sub-menu">                       
	                    <a class="" href="plant_purchase_order.php">Purchase Order</a>
	                </li>   --> 
	                <!-- <li class="sub-menu">
	                <a href="javascript:;" class="">
	                <i class="icon_document_alt"></i>
	                <span>Forms</span>
	                <span class="menu-arrow arrow_carrot-right"></span>
	                </a>
	                <ul class="sub">
	                <li><a class="" href="form_component.html">Form Elements</a></li>                          
	                <li><a class="" href="form_validation.html">Form Validation</a></li>
	                </ul>
	                </li>       
	                <li class="sub-menu">
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
	                </ul>
	                </li> -->

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
	                    <h3 class="page-header"><i class="fa fa-laptop"></i> On Delivery Order</h3>
	                    <ol class="breadcrumb">
	                        <li><i class="fa fa-home"></i><a href="plant_delivery_order.php">Delivery Order</a></li>
	                        <li><i class="fa fa-laptop"></i>On Delivery Order</li>						  	
	                    </ol>
	                </div>
	            </div>

	            <div class="row">
	            	<div class="col-md-12">
	                    <section class="panel">
	                        <form action="plant_delivery_order.php" method="post" class="form-inline">
	                        	<header class="panel-heading">
	                                <div class="row" style="margin-bottom: 5px;">
	                                    <div class="col-md-2">
	                                        <div class="form-group">
	                                            <label for="start_date">Start Date:</label><input type="date" name="start_date" class="form-control" value="<?php if(isset($_POST['start_date'])) { echo htmlentities ($_POST['start_date']); }?>">
	                                        </div>
	                                        
	                                    </div>
	                                    <div class="col-md-2">
	                                        <div class="form-group">
	                                            <label for="end_date">End Date:</label><input type="date" name="end_date" class="form-control" value="<?php if(isset($_POST['end_date'])) { echo htmlentities ($_POST['end_date']); }?>">
	                                    </div>
	                                        </div>
	                                        
	                                    <div class="col-md-2" style="margin-top: 39px;">
	                                        <input type="submit" name="search_pending" id="search_pending" value="Search" class="btn btn-primary">
	                                    </div>
	                                </div>
	                            </header>
	                        </form>
	                        <div class="table-responsive filterable">
<?php
	if(isset($_POST['search_pending'])){
        
        $search_plant = $office;
        
        if($_POST['end_date'] == ''){
            $end_date = "";
        }else{
            $end_date = $_POST['end_date'];
        }

        if($_POST['start_date'] == ''){
            $start_date = "";
        }else{
            $start_date = $_POST['start_date'];
        }

        if($_POST['start_date'] == '' && $_POST['end_date'] == ''){
            $string_date = "";
        }else if($_POST['start_date'] == '' && $_POST['end_date'] != ''){
            $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') <= '$end_date'";
        }else if($_POST['start_date'] != '' && $_POST['end_date'] == ''){
            $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') >= '$start_date'";        
        }else{
            $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }
?>
					<table class="table table-striped">
                        <thead>
                            <!-- <tr>
                                <th colspan="11"><h3>On Delivery Orders</h3></th>
                            </tr> -->
                            <tr class="filterable">
                                <th colspan="11">
                                    <button class="btn btn-default btn-xs btn-filter" style="float: right;"><span class="fa fa-filter"> Filter</button>
                                </th>
                            </tr>
                            <tr class="filters">
                            	<th>#</th>
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="DR No." disabled></th>
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="P.O. No." disabled></th>
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="Item" disabled></th>
                                <th class="col-md-1">Quantity</th>
                                <th><input type="text" class="form-control" placeholder="Site Name" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Address" disabled></th>
                                <th>Contact</th>
                                <!-- <th>Contact No.</th> -->
                                <th>Gate Pass</th>
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="Date Issued" disabled></th>
                                <th class="col-md-1">Option</th>
                            </tr>
                        </thead>
                        <tbody>
<?php

    $string = " WHERE office = '$search_plant'";

    $sql = "SELECT * FROM delivery".$string." ".$string_date." AND remarks = 'On Delivery'";
    // echo $sql;
    $sql_result = mysqli_query($db, $sql); 
    $total = mysqli_num_rows($sql_result);

    $adjacents = 3;
    $targetpage = "plant_delivery_order.php"; //your file name
    $page = $_GET['page'];

    if($page){ 
        $start = ($page - 1) * $limit; //first item to display on this page
    }else{
        $start = 0;
    }

    /* Setup page vars for display. */
    if ($page == 0) $page = 1; //if no page var is given, default to 1.
    $prev = $page - 1; //previous page is current page - 1
    $next = $page + 1; //next page is current page + 1
    $lastpage = ceil($total/$limit); //lastpage.
    $lpm1 = $lastpage - 1; //last page minus 1

    /* CREATE THE PAGINATION */
    $counter = 0;
    $pagination = "";
    if($lastpage > 1){ 
        $pagination .= "<div class='pagination1'> <ul class='pagination'>";
        if ($page > $counter+1) {
            $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$prev&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\"><<</a></li>"; 
        }

        if ($lastpage < 7 + ($adjacents * 2)) { 
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                else
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
            }
        }
        elseif($lastpage > 5 + ($adjacents * 2)){ //enough pages to hide some
            //close to beginning; only hide later pages
            if($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                }
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$lpm1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$lastpage</a></li>"; 
            }
            //in middle; hide some front and some back
            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">2</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                }
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$lpm1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$lastpage</a></li>"; 
            }
            //close to end; only hide early pages
            else{
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">2</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                }
            }
        }

        //next button
        if ($page < $counter - 1) 
            $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$next&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">>></a></li>";
        else
            $pagination.= "";
        $pagination.= "</ul></div>\n"; 
    }
 
    // $query = "SELECT delivery_id, delivery_receipt_no, po_no_delivery, item_no, c.client_name, c.site_name, c.address, contact, contact_no, gate_pass, FORMAT(quantity,0) as quantity, DATE_FORMAT(date_delivery,'%m/%d/%y') as date_delivery, office, fk_po_id, remarks
        //      FROM delivery d, client c ".$string." ".$string_date."
        //      AND d.client_id = c.client_id
        //      AND remarks = 'On Delivery' 
        //      ORDER BY delivery_id DESC LIMIT $start, $limit";

    $query = "SELECT d.delivery_id, d.delivery_receipt_no, d.item_no, d.quantity, d.gate_pass, d.po_no_delivery, DATE_FORMAT(d.date_delivery,'%m/%d/%y') as date_delivery , d.office, d.remarks, d.fk_po_id, s.site_name, s.site_address, p.site_contact_name, c.client_name, GROUP_CONCAT(sc.site_contact_no SEPARATOR ', ') as site_contact_no
                FROM delivery d, site s, site_contact_person p, client c, site_contact_number sc
                ".$string." ".$string_date."
                AND s.client_id = c.client_id
                AND p.site_contact_person_id = sc.site_contact_person_id
                AND d.site_id = s.site_id
                AND s.site_id = p.site_id
                AND remarks = 'On Delivery'
                GROUP BY delivery_id 
                ORDER BY delivery_id DESC
                LIMIT $start, $limit";
    // echo $query;
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) > 0){
        $hash = 1;
        while($row = mysqli_fetch_assoc($result)){
?>
                            <tr>
                            	<td><?php echo $hash; ?></td>
                            	<td class="col-md-1"><strong><?php echo $row['delivery_receipt_no']; ?></strong></td>
                            	<td class="col-md-1" style="cursor: pointer;">
                            		<div class="tooltips" data-original-title="Click for more details about P.O. No. <?php echo $row['po_no_delivery'] ?>" data-placement="top" onclick="window.location='delivery_po_order_no_details.php?fk_no=<?php echo $row['fk_po_id']; ?>&po_no_delivery=<?php echo $row['po_no_delivery']; ?>&office=<?php echo $row['office']; ?>'">
                            			<strong><?php echo $row['po_no_delivery']; ?></strong>
                            		</div>
                            	</td>
                                <td class="col-md-1"><strong><?php echo $row['item_no']; ?></strong></td>
                                <td class="col-md-1"><strong><?php echo number_format((float)$row['quantity'])." pcs"; ?></strong></td>
                                <td><strong><?php echo $row['site_name']; ?></strong></td>
                                <td><strong><?php echo $row['site_address']; ?></strong></td>
                                <td><strong><?php echo $row['site_contact_name']; ?></strong></td>
                                <!-- <td><strong><?php echo $row['contact_no']; ?></strong></td> -->
                                <td><strong><?php echo $row['gate_pass']; ?></strong></td>
                                <td class="col-md-1"><strong><?php echo $row['date_delivery']; ?></strong></td>
                                <td class="col-md-1">
                                    <form action="plant_delivery_order.php" method="post">
                                        <!-- <input type="hidden" name="post_delivery_id" value="<?php echo $row['delivery_id']; ?>">
                                        <input type="submit" value="Update" class="btn btn-warning btn-xs" style="margin-bottom: 4px;"> -->
                                        <button type="button" id="update" name="update" value="<?php echo $row['delivery_id']; ?>" class="btn btn-warning btn-xs" style="margin-bottom: 5px;" data-toggle='modal' data-target='#deliveryOrderUpdateRow<?php echo $hash; ?>'>Update</button>

                                        <div class="modal fade" id="deliveryOrderUpdateRow<?php echo $hash;?>" role="dialog">
                                            <div class="modal-dialog modal-sm">

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="row" style="text-align: center;">
                                                            <div class="col-md-12">
                                                                <img src="images/starcrete.png" width="150" height="50">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body" style="text-align: left;">
                                                        <h4 class="modal-title" style="text-align: center">Confirmation Login</h4>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="confirm_password">Password</label>
                                                                    <input type="password" name="confirm_password" class="form-control" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="update" id="update" value="<?php echo $row['delivery_id']; ?>" class="btn btn-primary">Submit</button>
                                                        <button type="button" class="btn" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <button type="submit" class='btn btn-xs btn-success' style="margin-bottom: 3px; width: 85px;" data-toggle='modal' data-target='#deliveryModal<?php echo $hash; ?>'>Delivered</button>
                                    
                                    <form action="plant_delivery_order.php" method="post">
                                    <div class="modal fade" id="deliveryModal<?php echo $hash;?>" role="dialog">
                                        <div class="modal-dialog modal-md">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><!-- DR No. <?php echo $row['delivery_receipt_no'] ?> -->Delivery Details</h4>
                                            </div>
                                            <div class="modal-body" style="text-align: left;">
                                                    <input type="hidden" id="hidden_id" name="hidden_id" value="<?php echo $row['delivery_id']; ?>">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>DR No.:</label>
                                                            <strong><?php echo $row['delivery_receipt_no']; ?></strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Date Issued:</label>
                                                            <strong><?php echo $row['date_delivery']; ?></strong>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>P.O. No.:</label>
                                                            <strong><?php echo $row['po_no_delivery']; ?></strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Date Delivered:</label>
                                                            <!-- <input type="datetime-local" name="option_delivered" required> -->
                                                            <input type="date" name="option_delivered" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Gate Pass:</label>
                                                            <strong><?php echo $row['gate_pass']; ?></strong>
                                                        </div>
                                                    </div>
                                                    <div style="margin: 5px 0px 5px 0px; background-color: #f2f2f2; padding: 0px 15px 0px 15px; border: 1px solid #0884e4;">
                                                        <div class="row" style="padding-bottom: 5px;">
                                                            <div class="col-md-12" style="text-align: center; background-color: #0884e4; color: white; padding: 5px;"><strong>Item Information</strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Item</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong><?php echo $row['item_no']; ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Quantity</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong><?php echo $row['quantity']." pcs"; ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="margin: 5px 0px 5px 0px; background-color: #f2f2f2; padding: 0px 15px 0px 15px; border: 1px solid #0884e4;">
                                                        <div class="row" style="padding-bottom: 5px;">
                                                            <div class="col-md-12" style="text-align: center; background-color: #0884e4; color: white; padding: 5px;"><strong>Client Information</strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Client Name</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong><?php echo $row['client_name']; ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Site Name</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong><?php echo $row['site_name']; ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Site Address</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong><?php echo $row['site_address']; ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="margin: 5px 0px 5px 0px; background-color: #f2f2f2; padding: 0px 15px 0px 15px; border: 1px solid #0884e4;">
                                                        <div class="row" style="padding-bottom: 5px;">
                                                            <div class="col-md-12" style="text-align: center; background-color: #0884e4; color: white; padding: 5px;"><strong>Contact Information</strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Contact</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong><?php echo $row['site_contact_name']; ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Contact No.</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong><?php echo $row['site_contact_no']; ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>                  
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" id="delivered" name="delivered" value="Confirm" class="btn btn-primary">
                                                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                    <form action="plant_delivery_order.php" method="post">
                                    	<button type="submit" id="returned" name="returned" value="<?php echo $row['delivery_id']?>" class='btn btn-xs btn-danger' onclick="return confirm('Confirm DR No. <?php echo $row['delivery_receipt_no']; ?> as backload delivery?')" style=" width: 85px;" >Backload</button>
                                    </form>
                            	</td>                 
                            </tr>
<?php
        $hash++;
        }
    }else{
?>
                            <tr>
                                <td colspan="11" style='min-height: 100%; background: white; text-align:center; 
            vertical-align:middle;'><h4><p class='text-muted'>No data found</p></h4>
                                </td>
                            </tr>
<?php
    }
?>
                        </tbody>
                    </table>
<?php 

    }else{

    	$search_plant = $office;
        
        if($_POST['end_date'] == ''){
            $end_date = "";
        }else{
            $end_date = $_POST['end_date'];
        }

        if($_POST['start_date'] == ''){
            $start_date = "";
        }else{
            $start_date = $_POST['start_date'];
        }

        if($_POST['start_date'] == '' && $_POST['end_date'] == ''){
            $string_date = "";
        }else if($_POST['start_date'] == '' && $_POST['end_date'] != ''){
            $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') <= '$end_date'";
        }else if($_POST['start_date'] != '' && $_POST['end_date'] == ''){
            $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') >= '$start_date'";        
        }else{
            $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }
?>
					<table class="table table-striped">
                        <thead>
                            <!-- <tr>
                                <th colspan="11"><h3>On Delivery Orders</h3></th>
                            </tr> -->
                            <tr class="filterable">
                                <th colspan="11">
                                    <button class="btn btn-default btn-xs btn-filter" style="float: right;"><span class="fa fa-filter"> Filter</button>
                                </th>
                            </tr>
                            <tr class="filters">
                            	<th>#</th>
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="DR No." disabled></th>
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="P.O. No." disabled></th>
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="Item" disabled></th>
                                <th class="col-md-1">Quantity</th>
                                <th><input type="text" class="form-control" placeholder="Site Name" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Address" disabled></th>
                                <th>Contact</th>
                                <!-- <th>Contact No.</th> -->
                                <th>Gate Pass</th>
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="Date Issued" disabled></th>
                                <th class="col-md-1">Option</th>
                            </tr>
                        </thead>
                        <tbody>
<?php

    $string = " WHERE office = '$search_plant'";

    $sql = "SELECT * FROM delivery".$string." ".$string_date." AND remarks = 'On Delivery'";
    // echo $sql;
    $sql_result = mysqli_query($db, $sql); 
    $total = mysqli_num_rows($sql_result);

    $adjacents = 3;
    $targetpage = "plant_delivery_order.php"; //your file name
    $page = $_GET['page'];

    if($page){ 
        $start = ($page - 1) * $limit; //first item to display on this page
    }else{
        $start = 0;
    }

    /* Setup page vars for display. */
    if ($page == 0) $page = 1; //if no page var is given, default to 1.
    $prev = $page - 1; //previous page is current page - 1
    $next = $page + 1; //next page is current page + 1
    $lastpage = ceil($total/$limit); //lastpage.
    $lpm1 = $lastpage - 1; //last page minus 1

    /* CREATE THE PAGINATION */
    $counter = 0;
    $pagination = "";
    if($lastpage > 1){ 
        $pagination .= "<div class='pagination1'> <ul class='pagination'>";
        if ($page > $counter+1) {
            $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$prev&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\"><<</a></li>"; 
        }

        if ($lastpage < 7 + ($adjacents * 2)) { 
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                else
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
            }
        }
        elseif($lastpage > 5 + ($adjacents * 2)){ //enough pages to hide some
            //close to beginning; only hide later pages
            if($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                }
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$lpm1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$lastpage</a></li>"; 
            }
            //in middle; hide some front and some back
            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">2</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                }
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$lpm1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$lastpage</a></li>"; 
            }
            //close to end; only hide early pages
            else{
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">1</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">2</a></li>";
                $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                }
            }
        }

        //next button
        if ($page < $counter - 1) 
            $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$next&radioOffice=$search_plant&start_date=$start_date&end_date=$end_date\">>></a></li>";
        else
            $pagination.= "";
        $pagination.= "</ul></div>\n"; 
    }
 
    // $query = "SELECT delivery_id, delivery_receipt_no, po_no_delivery, item_no, c.client_name, c.site_name, c.address, contact, contact_no, gate_pass, FORMAT(quantity,0) as quantity, DATE_FORMAT(date_delivery,'%m/%d/%y') as date_delivery, office, fk_po_id, remarks
        //      FROM delivery d, client c ".$string." ".$string_date."
        //      AND d.client_id = c.client_id
        //      AND remarks = 'On Delivery' 
        //      ORDER BY delivery_id DESC LIMIT $start, $limit";

    $query = "SELECT d.delivery_id, d.delivery_receipt_no, d.item_no, d.quantity, d.gate_pass, d.po_no_delivery, DATE_FORMAT(d.date_delivery,'%m/%d/%y') as date_delivery , d.office, d.remarks, d.fk_po_id, s.site_name, s.site_address, p.site_contact_name, c.client_name, GROUP_CONCAT(sc.site_contact_no SEPARATOR ', ') as site_contact_no
                FROM delivery d, site s, site_contact_person p, client c, site_contact_number sc
                ".$string." ".$string_date."
                AND s.client_id = c.client_id
                AND p.site_contact_person_id = sc.site_contact_person_id
                AND d.site_id = s.site_id
                AND s.site_id = p.site_id
                AND remarks = 'On Delivery'
                GROUP BY delivery_id 
                ORDER BY delivery_id DESC
                LIMIT $start, $limit";
    // echo $query;
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) > 0){
        $hash = 1;
        while($row = mysqli_fetch_assoc($result)){
?>
                            <tr>
                            	<td><?php echo $hash; ?></td>
                                <td class="col-md-1"><strong><?php echo $row['delivery_receipt_no']; ?></strong></td>
                                <td class="col-md-1" style="cursor: pointer;">
                            		<div class="tooltips" data-original-title="Click for more details about P.O. No. <?php echo $row['po_no_delivery'] ?>" data-placement="top" onclick="window.location='delivery_po_order_no_details.php?fk_no=<?php echo $row['fk_po_id']; ?>&po_no_delivery=<?php echo $row['po_no_delivery']; ?>&office=<?php echo $row['office']; ?>'">
                            			<strong><?php echo $row['po_no_delivery']; ?></strong>
                            		</div>
                            	</td>
                                <td class="col-md-1"><strong><?php echo $row['item_no']; ?></strong></td>
                                <td class="col-md-1"><strong><?php echo number_format((float)$row['quantity'])." pcs"; ?></strong></td>
                                <td><strong><?php echo $row['site_name']; ?></strong></td>
                                <td><strong><?php echo $row['site_address']; ?></strong></td>
                                <td><strong><?php echo $row['site_contact_name']; ?></strong></td>
                                <!-- <td><strong><?php echo $row['contact_no']; ?></strong></td> -->
                                <td><strong><?php echo $row['gate_pass']; ?></strong></td>
                                <td class="col-md-1"><strong><?php echo $row['date_delivery']; ?></strong></td>
                                <td class="col-md-1">
                                    <form action="plant_delivery_order.php" method="post">
                                        <!-- <input type="hidden" name="post_delivery_id" value="<?php echo $row['delivery_id']; ?>">
                                        <input type="submit" value="Update" class="btn btn-warning btn-xs" style="margin-bottom: 4px;"> -->
                                        <button type="button" id="update" name="update" value="<?php echo $row['delivery_id']; ?>" class="btn btn-warning btn-xs" style="margin-bottom: 5px;" data-toggle='modal' data-target='#deliveryOrderUpdateRow<?php echo $hash; ?>'>Update</button>

                                        <div class="modal fade" id="deliveryOrderUpdateRow<?php echo $hash;?>" role="dialog">
                                            <div class="modal-dialog modal-sm">

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="row" style="text-align: center;">
                                                            <div class="col-md-12">
                                                                <img src="images/starcrete.png" width="150" height="50">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body" style="text-align: left;">
                                                        <h4 class="modal-title" style="text-align: center">Confirmation Login</h4>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="confirm_password">Password</label>
                                                                    <input type="password" name="confirm_password" class="form-control" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="update" id="update" value="<?php echo $row['delivery_id']; ?>" class="btn btn-primary">Submit</button>
                                                        <button type="button" class="btn" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <button type="submit" class='btn btn-xs btn-success' style="margin-bottom: 3px; width: 85px;" data-toggle='modal' data-target='#deliveryModal<?php echo $hash; ?>'>Delivered</button>
                                    
                                    <form action="plant_delivery_order.php" method="post">
                                    <div class="modal fade" id="deliveryModal<?php echo $hash;?>" role="dialog">
                                        <div class="modal-dialog modal-md">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><!-- DR No. <?php echo $row['delivery_receipt_no'] ?> -->Delivery Details</h4>
                                            </div>
                                            <div class="modal-body" style="text-align: left;">
                                                    <input type="hidden" id="hidden_id" name="hidden_id" value="<?php echo $row['delivery_id']; ?>">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>DR No.:</label>
                                                            <strong><?php echo $row['delivery_receipt_no']; ?></strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Date Issued:</label>
                                                            <strong><?php echo $row['date_delivery']; ?></strong>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>P.O. No.:</label>
                                                            <strong><?php echo $row['po_no_delivery']; ?></strong>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Date Delivered:</label>
                                                            <!-- <input type="datetime-local" name="option_delivered" required> -->
                                                            <input type="date" name="option_delivered" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Gate Pass:</label>
                                                            <strong><?php echo $row['gate_pass']; ?></strong>
                                                        </div>
                                                    </div>
                                                    <div style="margin: 5px 0px 5px 0px; background-color: #f2f2f2; padding: 0px 15px 0px 15px; border: 1px solid #0884e4;">
                                                        <div class="row" style="padding-bottom: 5px;">
                                                            <div class="col-md-12" style="text-align: center; background-color: #0884e4; color: white; padding: 5px;"><strong>Item Information</strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Item</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong><?php echo $row['item_no']; ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Quantity</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong><?php echo $row['quantity']." pcs"; ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="margin: 5px 0px 5px 0px; background-color: #f2f2f2; padding: 0px 15px 0px 15px; border: 1px solid #0884e4;">
                                                        <div class="row" style="padding-bottom: 5px;">
                                                            <div class="col-md-12" style="text-align: center; background-color: #0884e4; color: white; padding: 5px;"><strong>Client Information</strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Client Name</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong><?php echo $row['client_name']; ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Site Name</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong><?php echo $row['site_name']; ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Site Address</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong><?php echo $row['site_address']; ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="margin: 5px 0px 5px 0px; background-color: #f2f2f2; padding: 0px 15px 0px 15px; border: 1px solid #0884e4;">
                                                        <div class="row" style="padding-bottom: 5px;">
                                                            <div class="col-md-12" style="text-align: center; background-color: #0884e4; color: white; padding: 5px;"><strong>Contact Information</strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Contact</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong><?php echo $row['site_contact_name']; ?></strong>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Contact No.</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong><?php echo $row['site_contact_no']; ?></strong>
                                                            </div>
                                                        </div>
                                                    </div>                  
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" id="delivered" name="delivered" value="Confirm" class="btn btn-primary">
                                                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                    <form action="plant_delivery_order.php" method="post">
                                    	<button type="submit" id="returned" name="returned" value="<?php echo $row['delivery_id']?>" class='btn btn-xs btn-danger' onclick="return confirm('Confirm DR No. <?php echo $row['delivery_receipt_no']; ?> as backload delivery?')" style=" width: 85px;" >Backload</button>
                                    </form>
                            	</td>                 
                            </tr>
<?php
        $hash++;
        }
    }else{
?>
                            <tr>
                                <td colspan="11" style='min-height: 100%; background: white; text-align:center; 
            vertical-align:middle;'><h4><p class='text-muted'>No data found</p></h4>
                                </td>
                            </tr>
<?php
    }
?>
                        </tbody>
                    </table>
<?php
    }
?>
	                        </div>
	                    </section>
	                </div>
	            </div>
	            <div class="row">
	                <div class="col-md-12">
	                    <div class="table_page">
<?php
                        echo $pagination; 
?>      
	                    </div>
	                </div>
	            </div> 
	        </section>
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
	    <!--main content end-->
	    </section>
	    <!-- container section start -->
    </section>
</body>
</html>
<?php

if(isset($_POST['delivered'])){
		$dr_id = $_POST['hidden_id'];
		// $datetime = date("Y-m-d H:i:s");
		$datetime = $_POST['option_delivered']." ".date("H:i:s");
		$datetime = str_replace("T", " ", $datetime);
		// echo $datetime;
		// $select = "SELECT * FROM delivery WHERE delivery_id = '$dr_id'";

		// $result = mysqli_query($db, $select);
		// $row = mysqli_fetch_assoc($result);

		$order = getDeliveryOrderDetails($db, $dr_id);

		$row_office = $order['office'];
		$row_po_no_delivery = $order['po_no_delivery'];
		$row_fk_po_id = $order['fk_po_id'];
		$row_delivery_receipt_no = $order['delivery_receipt_no'];
		$row_quantity = $order['quantity'];
		$row_item_no = $order['item_no'];
		$row_site_id = $order['site_id'];

		$site = getSiteInfo($db, $row_site_id);
		$row_site_name = $site['site_name'];
		// $update_stock = "UPDATE item_stock SET stock = stock - '$row_quantity', last_update = '$datetime' 
		// 					WHERE item_no = '$row_item_no' AND office = '$row_office'";

		// $purchase_order_count_update = "UPDATE purchase_order 
		// 								SET delivered = delivered + '$row_quantity', date_delivered = '$datetime'
		// 								WHERE office = '$row_office' 
		// 								AND purchase_order_no = '$row_po_no_delivery'
		// 								AND purchase_id = '$row_fk_po_id'";

		// mysqli_query($db, $purchase_order_count_update);
		
		$history_query = "INSERT INTO history(table_report,transaction_type,item_no,detail,history_date,office)
							VALUES('Delivery','Delivered Order','$row_item_no','".ucfirst($row_office)." delivered DR No. $row_delivery_receipt_no with P.O. No. $row_po_no_delivery and ".number_format($row_quantity)." pcs of $row_item_no to $row_site_name','$datetime','$row_office')";

		$batch_prod_stock = "INSERT INTO batch_prod_stock(item_no, delivered, office, date_production)
								VALUES('$row_item_no','$row_quantity','$row_office','$datetime')";
		
		// $sql = "SELECT * FROM purchase_order 
		// 		WHERE purchase_order_no = '".$row['po_no_delivery']."' 
		// 		AND office = '".$row['office']."'
		// 		AND purchase_id = '".$row['fk_po_id']."'";

		// $sql_result = mysqli_query($db, $sql);
		// $sql_row = mysqli_fetch_assoc($sql_result);

		if(getDeliveryBalance($db, $row_po_no_delivery, $row_fk_po_id, $row_office) == 0){
			$update_remarks = "UPDATE purchase_order SET remarks = 'Success'
								WHERE purchase_order_no = '$row_po_no_delivery'
								AND office = '$row_office'
								AND purchase_id = '$row_fk_po_id'";

			
			// mysqli_query($db, $update_remarks);
		}

		$update_delivery = "UPDATE delivery SET remarks = 'Delivered', date_delivery = '$datetime'
							WHERE delivery_id = '$dr_id'";

		// echo $update_delivery;
		// echo $update_stock;
		// echo $purchase_order_count_update;
		// echo $history_query;
		// echo $batch_prod_stock;
		// if($row['quantity'] < getStock($db, $row['item_no'], $office)){
		if(mysqli_query($db, $update_delivery) && mysqli_query($db, $batch_prod_stock) && mysqli_query($db, $history_query)){
			phpAlert("Item has been delivered successfully!!!");
			echo "<meta http-equiv='refresh' content='0'>";
		}else{
			phpAlert("Something went wrong!!");
		}
		// }else{
		// 	phpAlert("Quantity exceeded over stock!!");
		// }
	}else if(isset($_POST['returned'])){
		$dr_id = $_POST['returned'];
		$datetime = date("Y-m-d H:i:s");

		// $select = "SELECT * FROM delivery WHERE delivery_id = '$dr_id'";

		// $result = mysqli_query($db, $select);
		// $row = mysqli_fetch_assoc($result);

		// $row_office = $row['office'];
		// $row_po_no_delivery = $row['po_no_delivery'];
		// $row_fk_po_id = $row['fk_po_id'];
		// $row_delivery_receipt_no = $row['delivery_receipt_no'];
		// $row_quantity = $row['quantity'];
		// $row_item_no = $row['item_no'];
		// $row_client_name = $row['client_name'];

		$order = getDeliveryOrderDetails($db, $dr_id);

		$row_office = $order['office'];
		$row_po_no_delivery = $order['po_no_delivery'];
		$row_fk_po_id = $order['fk_po_id'];
		$row_delivery_receipt_no = $order['delivery_receipt_no'];
		$row_quantity = $order['quantity'];
		$row_item_no = $order['item_no'];

		$update_delivery = "UPDATE delivery SET remarks = 'Backload', date_delivery = '$datetime'
							WHERE delivery_id = '$dr_id' 
							AND delivery_receipt_no = '$row_delivery_receipt_no' 
							AND office = '$row_office'";

		// $purchase_order_update = "UPDATE purchase_order SET backload = backload + '".$row['quantity']."'
		// 							WHERE purchase_order_no = '".$row['po_no_delivery']."' 
		// 							AND purchase_id = '".$row['fk_po_id']."'
		// 							AND office = '".$row['office']."'";

		$purchase_order_update = "UPDATE purchase_order SET balance = balance + '$row_quantity'
									WHERE purchase_order_no = '$row_po_no_delivery' 
									AND purchase_id = '$row_fk_po_id'
									AND office = '$row_office'";
		// echo $purchase_order_update;
		// mysqli_query($db, $purchase_order_update);
		// $update_stock = "UPDATE item_stock SET stock = stock + '$row_quantity', last_update = '$datetime' 
		// 				WHERE item_no = '$row_item_no' AND office = '$row_office'";

		$history_query = "INSERT INTO history(table_report, transaction_type, detail, history_date, office) 
							VALUES('Delivery','Backloaded Order','".ucfirst($row_office)." has backload delivery of DR No. $row_delivery_receipt_no with ".number_format($row_quantity)." pcs of $row_item_no under P.O. No. $row_po_no_delivery','$datetime','$row_office')";

		// $sql = "SELECT * FROM purchase_order 
		// 		WHERE purchase_order_no = '".$row['po_no_delivery']."' 
		// 		AND purchase_id = '".$row['fk_po_id']."' 
		// 		AND office = '".$row['office']."'";

		// $sql_result = mysqli_query($db, $sql);
		// $sql_row = mysqli_fetch_assoc($sql_result);

		// if(getDeliveryBalance($db, $row_po_no_delivery, $row_fk_po_id, $row_office) == 0){
		// 	$update_remarks = "UPDATE purchase_order SET remarks = 'Success'
		// 						WHERE purchase_order_no = '$row_po_no_delivery' 
		// 						AND purchase_id = '$row_fk_po_id'
		// 						AND office = '$row_office'";

		// 	// mysqli_query($db, $update_remarks);
		// }
		// echo $update_stock;
		// echo $purchase_order_update;
		// echo $update_delivery;
		// echo $history_query;
		if(mysqli_query($db, $update_delivery) && mysqli_query($db, $history_query) && mysqli_query($db, $purchase_order_update)){
			phpAlert("Item has been backload!!!");
			echo "<meta http-equiv='refresh' content='0'>";
		}else{
			phpAlert("Something went wrong!!");
		}
	}else if(isset($_POST['update'])){

		$username = mysqli_real_escape_string($db, $_SESSION['login_user']);
		$password = mysqli_real_escape_string($db, $_POST['confirm_password']);

		$sql = "SELECT * FROM users 
				WHERE username = '$username' 
				AND password = '$password'
				AND office != 'head' 
				AND position != 'warehouseman'";

		$result = mysqli_query($db, $sql);

		if(mysqli_num_rows($result) > 0){
			$delivery_id = $_POST['update'];
			$_SESSION['post_delivery_id'] = $delivery_id;
			header("location: plant_delivery_update.php");
			// echo $purchase_id;
		}else{
			phpAlert("Invalid username or password of Admin");
			echo "<meta http-equiv='refresh' content='0'>";
		}

	}
?>