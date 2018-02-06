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

     if(!isset($_GET['page']) || $_GET['page'] == ''){
        $_GET['page'] = 0;
    }

    if(!isset($_GET['start_date'])){
        $_GET['start_date'] = '';
    }

    if(!isset($_GET['end_date'])){
        $_GET['end_date'] = '';
    }

    $user_query = $db->prepare("SELECT * FROM users WHERE username = ?");
    $user_query->bind_param('s', $_SESSION['login_user']);
    $user_query->execute();
    $result = $user_query->get_result();
    $user = $result->fetch_assoc();

    $office = $user['office'];
    $position = $user['position'];
    $limit = 20; //how many items to show per page
    $search_plant = 'bravo';

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Delivered Order - Delivery Order</title>

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
                <div class="col-lg-12">
                    <h3 class="page-header"><a href="bravo_delivery_success.php"><i class="fa fa-laptop"></i> Bravo Delivered Order</a></h3>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-building"></i>Bravo</li>
                        <li><a href="bravo_delivery_order.php"><i class="icon_document_alt"></i>Delivery Order</a></li>
                        <li><a href="bravo_delivery_issue.php"><i class="fa fa-info-circle"></i>No DR. No. <span class='badge'><?php echo countPendingPo($db, 'bravo'); ?></span></a></li>
                        <li><i class="fa fa-truck"></i>Delivered</li>
                        <li><a href="bravo_delivery_backload.php"><i class="fa fa-reply"></i>Backload</a></li>                             
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <form action="bravo_delivery_success.php" method="get" class="form-inline">
                            <header class="panel-heading">
                                <div class="row" style="margin-bottom: 5px;">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="start_date">Start Date:</label><input type="date" name="start_date" class="form-control" value="<?php if(isset($_GET['start_date'])) { echo htmlentities ($_GET['start_date']); }?>">
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="end_date">End Date:</label><input type="date" name="end_date" class="form-control" value="<?php if(isset($_GET['end_date'])) { echo htmlentities ($_GET['end_date']); }?>">
                                    </div>
                                        </div>
                                        
                                    <div class="col-md-2" style="margin-top: 39px;">
                                        <input type="submit" name="search_table" id="search_table" value="Search" class="btn btn-primary">
                                    </div>
                                    <!-- <div class="col-md-2"> -->
                                </div>
                            </header>
                        </form>
                        <div class="table-responsive filterable">
<?php
    if(isset($_GET['search_table'])){
        
        if($_GET['end_date'] == ''){
            $end_date = "";
        }else{
            $end_date = $_GET['end_date'];
        }

        if($_GET['start_date'] == ''){
            $start_date = "";
        }else{
            $start_date = $_GET['start_date'];
        }

        if($_GET['start_date'] == '' && $_GET['end_date'] == ''){
            $string_date = "";
        }else if($_GET['start_date'] == '' && $_GET['end_date'] != ''){
            $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') <= '$end_date'";
        }else if($_GET['start_date'] != '' && $_GET['end_date'] == ''){
            $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') >= '$start_date'";        
        }else{
            $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }
?>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <!-- <tr>
                                <th colspan="11"><h3>Delivered Orders</h3></th>
                            </tr> -->
                            <tr class="filterable">
                                <th colspan="8">
                                    <button class="btn btn-default btn-xs btn-filter" style="float: right;"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                                </th>
                            </tr>
                            <tr class="filters">
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="DR No." disabled></th>
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="P.O. No." disabled></th>
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="Item" disabled></th>
                                <th class="col-md-1">Quantity</th>
                                <th class="col-md-2"><input type="text" class="form-control" placeholder="Site Name" disabled></th>
                                <th class="col-md-2">Address</th>
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="Date Delivered" disabled></th>
                                <th class="col-md-1">Status</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
        if($office == 'head'){
            $string = " WHERE office = '$search_plant'";
        }else{
            $string = " WHERE office = '$office'";
        }

        $sql = "SELECT * FROM delivery".$string." ".$string_date." AND remarks = 'Delivered'";

        $sql_result = mysqli_query($db, $sql); 
        $total = mysqli_num_rows($sql_result);

        $adjacents = 3;
        $targetpage = "bravo_delivery_success.php"; //your file name
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
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$prev&start_date=$start_date&end_date=$end_date\"><<</a></li>"; 
            }

            if ($lastpage < 7 + ($adjacents * 2)) { 
                for ($counter = 1; $counter <= $lastpage; $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                }
            }
            elseif($lastpage > 5 + ($adjacents * 2)){ //enough pages to hide some
                //close to beginning; only hide later pages
                if($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                        if ($counter == $page)
                        $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                        else
                        $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                    }
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&start_date=$start_date&end_date=$end_date\">$lpm1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&start_date=$start_date&end_date=$end_date\">$lastpage</a></li>"; 
                }
                //in middle; hide some front and some back
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&start_date=$start_date&end_date=$end_date\">1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&start_date=$start_date&end_date=$end_date\">2</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
                        if ($counter == $page)
                        $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                        else
                        $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                    }
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&start_date=$start_date&end_date=$end_date\">$lpm1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&start_date=$start_date&end_date=$end_date\">$lastpage</a></li>"; 
                }
                //close to end; only hide early pages
                else{
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&start_date=$start_date&end_date=$end_date\">1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&start_date=$start_date&end_date=$end_date\">2</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
                        if ($counter == $page)
                        $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                        else
                        $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                    }
                }
            }

            //next button
            if ($page < $counter - 1) 
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$next&start_date=$start_date&end_date=$end_date\">>></a></li>";
            else
                $pagination.= "";
            $pagination.= "</ul></div>\n"; 
        }

        // $query = "SELECT delivery_id, delivery_receipt_no, po_no_delivery, fk_po_id, item_no, quantity, c.site_name, c.address, contact, contact_no, gate_pass, office, remarks, FORMAT(quantity,0) as quantity, DATE_FORMAT(date_delivery,'%m/%d/%y') as date_delivery1
        //      FROM delivery d, client c ".$string." ".$string_date."
        //      AND d.client_id = c.client_id
        //      AND remarks = 'Delivered' 
        //      ORDER BY date_delivery DESC
        //      LIMIT $start, $limit";

        $query = "SELECT d.delivery_id, d.delivery_receipt_no, d.item_no, d.quantity, d.gate_pass, d.po_no_delivery, DATE_FORMAT(d.date_delivery,'%m/%d/%y') as date_delivery1 , d.office, d.remarks, d.fk_po_id, s.site_name, s.site_address, p.site_contact_name, c.client_name, GROUP_CONCAT(sc.site_contact_no SEPARATOR ', ') as site_contact_no
                FROM delivery d, site s, site_contact_person p, client c, site_contact_number sc
                ".$string." ".$string_date."
                AND s.client_id = c.client_id
                AND p.site_contact_person_id = sc.site_contact_person_id
                AND d.site_id = s.site_id
                AND s.site_id = p.site_id
                AND remarks = 'Delivered' 
                GROUP BY delivery_id 
                ORDER BY delivery_id DESC
                LIMIT $start, $limit";
                    // echo $query;
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                // $date = date_create($row['date_delivery']);
?>  
                            <tr>
                                <td class='col-md-1'><strong><?php echo $row['delivery_receipt_no']; ?></strong></td>
                                <td class='col-md-1' style="cursor: pointer;" title="Click here to view transactions under P.O. No. <?php echo $row['po_no_delivery'] ?>" onclick="window.location='delivery_po_order_no_details.php?fk_no=<?php echo $row['fk_po_id']; ?>&po_no_delivery=<?php echo $row['po_no_delivery'] ?>&office=<?php echo $row['office']; ?>'"><strong><?php echo $row['po_no_delivery']; ?></strong></td>
                                <td class='col-md-1'><strong><?php echo $row['item_no']; ?></strong></td>
                                <td class='col-md-1'><strong><?php echo number_format((float)$row['quantity'])." pcs"; ?></strong></td>
                                <td class='col-md-2'><strong><?php echo $row['site_name']; ?></strong></td>
                                <td class='col-md-2'><strong><?php echo $row['site_address']; ?></strong></td>
                                <td class='col-md-1'><strong><?php echo $row['date_delivery1']; ?></strong></td>
                                <td class='col-md-1' style="background-color: green; color: white"><strong><?php echo $row['remarks']; ?></strong></td>
                            </tr>
<?php
            }
        }else{
?>
                            <tr>        
                                <td colspan="8" style='height: 100%; background: white; border: none; text-align:center; 
    vertical-align:middle;'><h4><p class='text-muted'>No data found</p></h4></td>
                            </tr>
<?php
        }
?>
                        </tbody>
                    </table>
<?php
    }else{

        if($_GET['end_date'] == ''){
            $end_date = "";
        }else{
            $end_date = $_GET['end_date'];
        }

        if($_GET['start_date'] == ''){
            $start_date = "";
        }else{
            $start_date = $_GET['start_date'];
        }

        if($_GET['start_date'] == '' && $_GET['end_date'] == ''){
            $string_date = "";
        }else if($_GET['start_date'] == '' && $_GET['end_date'] != ''){
            $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') <= '$end_date'";
        }else if($_GET['start_date'] != '' && $_GET['end_date'] == ''){
            $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') >= '$start_date'";        
        }else{
            $string_date = "AND DATE_FORMAT(date_delivery,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'";
        }
?>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <!-- <tr>
                                <th colspan="11"><h3>Delivered Orders</h3></th>
                            </tr> -->
                            <tr class="filterable">
                                <th colspan="8">
                                    <button class="btn btn-default btn-xs btn-filter" style="float: right;"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                                </th>
                            </tr>
                            <tr class="filters">
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="DR No." disabled></th>
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="P.O. No." disabled></th>
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="Item" disabled></th>
                                <th class="col-md-1">Quantity</th>
                                <th class="col-md-2"><input type="text" class="form-control" placeholder="Site Name" disabled></th>
                                <th class="col-md-2">Address</th>
                                <th class="col-md-1"><input type="text" class="form-control" placeholder="Date Delivered" disabled></th>
                                <th class="col-md-1">Status</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
        if($office == 'head'){
            $string = " WHERE office = '$search_plant'";
        }else{
            $string = " WHERE office = '$office'";
        }

        $sql = "select * from delivery".$string." ".$string_date." AND remarks = 'Delivered'";
        // echo $sql;
        $sql_result = mysqli_query($db, $sql); 
        $total = mysqli_num_rows($sql_result);

        $adjacents = 3;
        $targetpage = "bravo_delivery_success.php"; //your file name
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
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$prev&start_date=$start_date&end_date=$end_date\"><<</a></li>"; 
            }

            if ($lastpage < 7 + ($adjacents * 2)) { 
                for ($counter = 1; $counter <= $lastpage; $counter++){
                    if ($counter == $page)
                    $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                    else
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                }
            }
            elseif($lastpage > 5 + ($adjacents * 2)){ //enough pages to hide some
                //close to beginning; only hide later pages
                if($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                        if ($counter == $page)
                        $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                        else
                        $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                    }
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&start_date=$start_date&end_date=$end_date\">$lpm1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&start_date=$start_date&end_date=$end_date\">$lastpage</a></li>"; 
                }
                //in middle; hide some front and some back
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&start_date=$start_date&end_date=$end_date\">1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&start_date=$start_date&end_date=$end_date\">2</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
                        if ($counter == $page)
                        $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                        else
                        $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                    }
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lpm1&start_date=$start_date&end_date=$end_date\">$lpm1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$lastpage&start_date=$start_date&end_date=$end_date\">$lastpage</a></li>"; 
                }
                //close to end; only hide early pages
                else{
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=1&start_date=$start_date&end_date=$end_date\">1</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=2&start_date=$start_date&end_date=$end_date\">2</a></li>";
                    $pagination.= "<li class='page-item'><a class='page-link' href='#'>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
                        if ($counter == $page)
                        $pagination.= "<li class='page-item active'><a class='page-link' href='#'>$counter</a></li>";
                        else
                        $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$counter&start_date=$start_date&end_date=$end_date\">$counter</a></li>"; 
                    }
                }
            }

            //next button
            if ($page < $counter - 1) 
                $pagination.= "<li class='page-item'><a class='page-link' href=\"$targetpage?page=$next&start_date=$start_date&end_date=$end_date\">>></a></li>";
            else
                $pagination.= "";
            $pagination.= "</ul></div>\n"; 
        }

        // $query = "SELECT delivery_id, delivery_receipt_no, po_no_delivery, fk_po_id, item_no, quantity, c.site_name, c.address, contact, contact_no, gate_pass, office, remarks, FORMAT(quantity,0) as quantity, DATE_FORMAT(date_delivery,'%m/%d/%y') as date_delivery1
        //      FROM delivery d, client c ".$string." ".$string_date."
        //      AND d.client_id = c.client_id
        //      AND remarks = 'Delivered' 
        //      ORDER BY date_delivery DESC
        //      LIMIT $start, $limit";

        $query = "SELECT d.delivery_id, d.delivery_receipt_no, d.item_no, d.quantity, d.gate_pass, d.po_no_delivery, DATE_FORMAT(d.date_delivery,'%m/%d/%y') as date_delivery1 , d.office, d.remarks, d.fk_po_id, s.site_name, s.site_address, p.site_contact_name, c.client_name, GROUP_CONCAT(sc.site_contact_no SEPARATOR ', ') as site_contact_no
                FROM delivery d, site s, site_contact_person p, client c, site_contact_number sc
                ".$string." ".$string_date."
                AND s.client_id = c.client_id
                AND p.site_contact_person_id = sc.site_contact_person_id
                AND d.site_id = s.site_id
                AND s.site_id = p.site_id
                AND remarks = 'Delivered' 
                GROUP BY delivery_id 
                ORDER BY delivery_id DESC
                LIMIT $start, $limit";
                    // echo $query;
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                // $date = date_create($row['date_delivery']);
?>  
                            <tr>
                                <td class='col-md-1'><strong><?php echo $row['delivery_receipt_no']; ?></strong></td>
                                <td class='col-md-1' style="cursor: pointer;" title="Click here to view transactions under P.O. No. <?php echo $row['po_no_delivery'] ?>" onclick="window.location='delivery_po_order_no_details.php?fk_no=<?php echo $row['fk_po_id']; ?>&po_no_delivery=<?php echo $row['po_no_delivery'] ?>&office=<?php echo $row['office']; ?>'"><strong><?php echo $row['po_no_delivery']; ?></strong></td>
                                <td class='col-md-1'><strong><?php echo $row['item_no']; ?></strong></td>
                                <td class='col-md-1'><strong><?php echo number_format((float)$row['quantity'])." pcs"; ?></strong></td>
                                <td class='col-md-2'><strong><?php echo $row['site_name']; ?></strong></td>
                                <td class='col-md-2'><strong><?php echo $row['site_address']; ?></strong></td>
                                <td class='col-md-1'><strong><?php echo $row['date_delivery1']; ?></strong></td>
                                <td class='col-md-1' style="background-color: green; color: white"><strong><?php echo $row['remarks']; ?></strong></td>
                            </tr>
<?php
            }
        }else{
?>
                            <tr>        
                                <td colspan="8" style='height: 100%; background: white; text-align:center; 
    vertical-align:middle;'><h4><p class='text-muted'>No data found</p></h4></td>
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
            </div><!--/.row-->      
            <div class="row">
                <div class="col-md-12">
                    <div class="table_page">
<?php
                        echo $pagination; 
?>      
                    </div>
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
    <!--main content end-->
    </section>
    <!-- container section start -->

</body>
</html>
