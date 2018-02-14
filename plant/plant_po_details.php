<?php
	ob_start();
	session_start();
?>
<!DOCTYPE html>
<?php

    include("../includes/config.php");
    include("../includes/function.php");

    if(!isset($_SESSION['login_user']) && !isset($_SESSION['login_office']) || $_SESSION['login_office'] == 'head') {
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

    if (isset($_REQUEST['fk_po_id']) && isset($_REQUEST['po_no_delivery'])) {
        $_POST['fk_po_id'] = $_REQUEST['fk_po_id'];
        $_POST['po_no_delivery'] = $_REQUEST['po_no_delivery'];
    }

    $fk_po_id = $_POST['fk_po_id'];
    $po_no_delivery = $_POST['po_no_delivery'];

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

    <title>Purchase Order</title>

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
                            <i class="icon_house"></i>
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
                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">            
                <!--overview start-->
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><i class="fa fa-laptop"></i> P.O. No. <?php echo $po_no_delivery; ?></h3>
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="plant_delivery_order.php">Delivery Order</a></li>
                            <li><i class="fa fa-laptop"></i>Details</li>                          
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <form action="delta_po_details.php" method="get" class="form-inline">
                                <header class="panel-heading">

                                </header>
                            </form>
                            <div class="table-responsive filterable">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="filterable">
                                            <th colspan="2" style="text-align: left;">Balance: <?php echo number_format(getDeliveryBalance($db, $po_no_delivery, $fk_po_id)); ?> pcs</th>
                                            <th colspan="2">Delivered: <?php echo number_format(getDeliveryDelivered($db, $po_no_delivery, $office)); ?> pcs</th>
                                            <th colspan="2">On Delivery: <?php echo number_format(getDeliveryOnDelivery($db, $po_no_delivery, $office)); ?> pcs</th>
                                            <th colspan="4">
                                                <button class="btn btn-default btn-xs btn-filter" style="float: right;"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                                            </th>
                                        </tr>
                                        <tr class="filters">
                                            <th class="col-md-1">P.O. No.</th>
                                            <th class="col-md-1"><input type="text" class="form-control" placeholder="DR No." disabled></th>
                                            <th class="col-md-1"><input type="text" class="form-control" placeholder="Item" disabled></th>
                                            <th class="col-md-1">Quantity</th>
                                            <th class="col-md-2"><input type="text" class="form-control" placeholder="Site Name" disabled></th>
                                            <th class="col-md-2"><input type="text" class="form-control" placeholder="Address" disabled></th>
                                            <th class="col-md-1">Contact</th>
                                            <th class="col-md-1">Date Transaction</th>
                                            <th class="col-md-1">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
    // $sql = "SELECT *, s.site_name, s.site_address, DATE_FORMAT(date_delivery,'%m/%d/%y') as date_delivery1
    //      FROM delivery d, site s
    //      WHERE po_no_delivery = '$po_no_delivery'
    //      AND d.site_id = s.site_id
    //      AND office = 'delta'
    //      ORDER BY date_delivery DESC";

    $sql = "SELECT *, s.site_name, s.site_address, DATE_FORMAT(date_delivery,'%m/%d/%y') as date_delivery1, GROUP_CONCAT(DISTINCT p.site_contact_name ORDER BY p.site_contact_name ASC SEPARATOR ', ') as site_contact_name
            FROM delivery d, site s, purchase_order_contact c, site_contact_person p
            WHERE po_no_delivery = '$po_no_delivery'
            AND d.fk_po_id = c.purchase_id
            AND c.site_contact_id = p.site_contact_person_id
            AND d.site_id = s.site_id
            AND office = '$office'
            GROUP BY delivery_id
            ORDER BY date_delivery DESC";
    $result = mysqli_query($db, $sql);
    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)) {
        // $date = date_create($row['date_delivery']);
?>
                            <tr>
                                <td class="col-md-1"><strong><?php echo $row['po_no_delivery']; ?></strong></td>
                                <td class="col-md-1"><strong><?php echo $row['delivery_receipt_no']; ?></strong></td>
                                <td class="col-md-1"><strong><?php echo $row['item_no']; ?></strong></td>
                                <td class="col-md-1"><strong><?php echo number_format($row['quantity']); ?> pcs</strong></td>
                                <td class="col-md-2"><strong><?php echo $row['site_name']; ?></strong></td>
                                <td class="col-md-2"><strong><?php echo $row['site_address']; ?></strong></td>
                                <td class="col-md-1"><strong><?php echo $row['site_contact_name']; ?></strong></td>
                                <td class='col-md-1'><strong><?php echo $row['date_delivery1']; ?></strong></td>
<?php
            if($row['remarks'] == 'Delivered'){
?>
                                <td class="col-md-1" style="background-color: green; color: white;"><strong><?php echo $row['remarks']; ?></strong></td>
<?php
            }else if($row['remarks'] == 'Backload'){
?>
                                <td class="col-md-1" style="background-color: #e60000; color: white;"><strong><?php echo $row['remarks']; ?></strong></td>
<?php
            }else if($row['remarks'] == 'On Delivery'){
?>
                                <td class="col-md-1" style="background-color: #ffcc00;"><strong><?php echo $row['remarks']; ?></strong></td>
<?php
            }
?>
                            </tr>
<?php
        }
    }else{
?>
                            <tr>
                                <td colspan="10" style='min-height: 100%; background: white; text-align:center; vertical-align: middle;'><h4><p class='text-muted'>No data found</p></h4>
                                </td>
                            </tr>
<?php
    }
?>
                                    </tbody>
                                </table>
                            </div>  
                        </section> 
                    </div>
                </div>
            </section>
        </section>
    </section>  
</body>
</html>
