<?php
	function phpAlert($msg) {
	    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
	}
/* List of miscellaneous functions */
	// function getSiteContactInfo($db, $)

	function getPurchaseOrderDetails($db, $unique_id){

		$sql = "SELECT * FROM purchase_order
				WHERE purchase_unique_id = '$unique_id'";

		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);

		$po['purchase_order_no'] = $row['purchase_order_no'];		

		return $po;
	}
	function getCountPlantPo($db, $office){

		$sql = "SELECT purchase_order_no 
				FROM purchase_order 
				WHERE balance != 0
				AND office = '$office'";

		$result = mysqli_query($db, $sql);
		$count = mysqli_num_rows($result);

		if($count == 0){
			$count = 0;
		}
		
		return $count;
	}
	function countPendingPo($db, $office){

		$sql = "SELECT purchase_order_no 
				FROM purchase_order 
				WHERE office = '$office'
				AND balance != 0";
		$result = mysqli_query($db, $sql);
		$count = mysqli_num_rows($result);

		if($count == 0){
			$count = 0;
		}
		
		return $count;
	}

	function getSiteInfo($db, $site_id){

		$sql = "SELECT site_id, site_name, site_address
				FROM site
				WHERE site_id = '$site_id'";

		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);
		
		$site['site_id'] = $row['site_id'];
		$site['site_name'] = $row['site_name'];
		$site['site_address'] = $row['site_address'];		

		return $site;
	}

	function getClientInfo($db, $client_id){

		$sql = "SELECT client_id, client_name, address
				FROM client
				WHERE client_id = '$client_id'";

		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);

		$client['client_id'] = $row['client_id'];
		$client['client_name'] = $row['client_name'];
		$client['address'] = $row['address'];

		return $client;
	}

	function getDeliveryOrderDetails($db, $delivery_id){

		// $sql = "SELECT delivery_id, delivery_receipt_no, item_no, quantity, c.client_id, c.client_name, c.site_name, c.address, contact, contact_no, gate_pass, po_no_delivery, date_delivery, office, remarks, fk_po_id, update_code 
		// 		FROM delivery d, client c
		// 		WHERE d.client_id = c.client_id
		// 		AND delivery_id = '".$delivery_id."'";

		// $result = mysqli_query($db, $sql);
		// $row = mysqli_fetch_assoc($result);

		// $order['delivery_id'] = $row['delivery_id'];
		// $order['delivery_receipt_no'] = $row['delivery_receipt_no'];
		// $order['item_no'] = $row['item_no'];
		// $order['quantity'] = $row['quantity'];
		// $order['client_id'] = $row['client_id'];
		// $order['client_name'] = $row['client_name'];
		// $order['site_name'] = $row['site_name'];
		// $order['address'] = $row['address'];
		// $order['contact'] = $row['contact'];
		// $order['contact_no'] = $row['contact_no'];
		// $order['gate_pass'] = $row['gate_pass'];
		// $order['po_no_delivery'] = $row['po_no_delivery'];
		// $order['date_delivery'] = $row['date_delivery'];
		// $order['office'] = $row['office'];
		// $order['remarks'] = $row['remarks'];
		// $order['fk_po_id'] = $row['fk_po_id'];
		// $order['update_code'] = $row['update_code'];

		$sql = "SELECT delivery_id, delivery_receipt_no, item_no, quantity, site_id, site_contact_id, gate_pass, po_no_delivery, date_delivery, office, remarks, fk_po_id
				FROM delivery
				WHERE delivery_id = '$delivery_id'";

		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);

		$order['delivery_id'] = $row['delivery_id'];
		$order['delivery_receipt_no'] = $row['delivery_receipt_no'];
		$order['item_no'] = $row['item_no'];
		$order['quantity'] = $row['quantity'];
		$order['site_id'] = $row['site_id'];
		$order['site_contact_id'] = $row['site_contact_id'];
		$order['gate_pass'] = $row['gate_pass'];
		$order['po_no_delivery'] = $row['po_no_delivery'];
		$order['date_delivery'] = $row['date_delivery'];
		$order['office'] = $row['office'];
		$order['remarks'] = $row['remarks'];
		$order['fk_po_id'] = $row['fk_po_id'];

		return $order;
	}
	function getAddress($db, $client){

		$sql = "SELECT address
				FROM client 
				WHERE client_name = '$client'";

      	$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['address'];
	}

	function getUnit($db, $item_no){

		$sql = "SELECT unit FROM item_list 
		  		WHERE item_no = '".$item_no."'";
		
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);
		return $row['unit'];
	}

	function getTruck($db, $item_no){

		$sql = "SELECT truck FROM item_list 
		  		WHERE item_no = '".$item_no."'";
		
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);
		return $row['truck'];
	}

	function getStock($db, $item_no, $office){

		$sql = "SELECT stock FROM item_stock 
				WHERE item_no = '$item_no' 
				AND office = '$office'";
		// echo $sql;
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);
		if($row['stock'] > 0){
			return $row['stock'];
		}else{
			$row['stock'] = 0;
			return $row['stock'];
		}
	}

	// function getClientInfo($db, $client, $address){

	// 	$sql = "SELECT client_name, address
	// 			FROM client
	// 			WHERE client_name = '$client'
	// 			AND address = '$address'";

	// 	$result = mysqli_query($db, $sql);
	// 	$row = mysqli_fetch_assoc($result);
	// 	if(count($row['client_name']) > 0 || count($row['address']) > 0){
	// 		return 1;
	// 	}else{
	// 		return 0;
	// 	}
	// }
/* End of list of miscellaneous functions */

/* List of functions for Received Page */

	function getPurchaseAggId($db, $po_no, $item_no, $office){

		$sql = "SELECT purchase_order_aggregates_id 
				FROM purchase_order_aggregates
		  		WHERE item_no = '$item_no' 
		  		AND purchase_order_aggregates_no = '$po_no'
		  		AND office = '$office'";
		
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);
		return $row['purchase_order_aggregates_id'];
	}

	function getPurchaseAggQuantity($db, $po_no, $item_no, $office, $fkid){

		$sql = "SELECT quantity 
				FROM purchase_order_aggregates
		  		WHERE item_no = '$item_no' 
		  		AND purchase_order_aggregates_no = '$po_no'
		  		AND office = '$office'
		  		AND purchase_order_aggregates_id = '$fkid'";
		
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);
		return $row['quantity'];
	}

	function getPurchaseAggSupplier($db, $po_no, $item_no, $office, $fkid){

		$sql = "SELECT supplier_name 
				FROM purchase_order_aggregates
		  		WHERE item_no = '$item_no' 
		  		AND purchase_order_aggregates_no = '$po_no'
		  		AND office = '$office'
		  		AND purchase_order_aggregates_id = '$fkid'";
	
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);
		return $row['supplier_name'];
	}

	function getPurchaseAggPlant($db, $po_no, $item_no, $fkid){

		$sql = "SELECT office 
				FROM purchase_order_aggregates
		  		WHERE item_no = '$item_no' 
		  		AND purchase_order_aggregates_no = '$po_no'
		  		AND purchase_order_aggregates_id = '$fkid'";
		
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);
		return $row['office'];
	}

/* End of list of functions for Recevied Page */

/* List of functions for Delivery Page */

	function getPurchasePlant($db, $po_no, $item_no, $office){

		$sql = "SELECT office
				FROM purchase_order 
				WHERE item_no = '$item_no' 
				AND purchase_order_no = '$po_no'
				AND office = '$office'";

      	$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['office'];
	}

	function getPurchaseClient($db, $po_no, $item_no, $office){

		$sql = "SELECT client_name
				FROM purchase_order 
				WHERE item_no = '$item_no' 
				AND purchase_order_no = '$po_no'
				AND office = '$office'
      			ORDER BY date_purchase DESC";

      	$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['client_name'];
	}

/* End of list of functions for Delivery Page */

/* Start of list of functions for Batch Page */

	function getItemNo($db, $machine, $office, $date){
		
		$sql = "SELECT item_no 
				FROM batch 
				WHERE machine_no = '$machine' 
				AND office = '$office' 
				AND DATE_FORMAT(batch_date,'%Y-%m-%d') = '$date'";
	
		$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['item_no'];
	}

	function getCement($db, $machine, $type, $office, $date){

		$sql = "SELECT cement 
				FROM batch 
				WHERE machine_no = '$machine'
				AND item_no = '$type' 
				AND office = '$office' 
				AND DATE_FORMAT(batch_date,'%Y-%m-%d') = '$date'";

		$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['cement'];
		
	}

/* End of list of functions for Batch Page */

/* Start of list of functions for Purchase Order Page */

	function getCountOnDelivery($db){

		$sql = "SELECT count(*) as total
				FROM purchase_order
				WHERE remarks = 'On Delivery'";

		$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['total'];
	}

	function getCountOnDeliveryOffice($db, $office){

		$sql = "SELECT count(*) as total
				FROM purchase_order
				WHERE remarks = 'On Delivery'
				AND office = '$office'";

		$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['total'];
	}

	function getCountPending($db, $office){

		$sql = "SELECT count(*) as total
				FROM purchase_order
				WHERE balance != 0
				AND office = '$office'";

		$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['total'];
	}

	function getCountPendingOffice($db, $office){

		$sql = "SELECT count(*) as total
				FROM purchase_order
				WHERE balance != 0
				AND office = '$office'";

		$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['total'];
	}

/* End of list of functions for Purchase Order Page */

/* Start of list of functions for Delivery Order Page */

	function getDeliveryCountOnDeliveryOffice($db, $office){

		$sql = "SELECT count(*) as total
				FROM delivery
				WHERE remarks = 'On Delivery'
				AND office = '$office'";

		$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['total'];
	}

	function getDeliveryBalance($db, $unique_id){

		$sql = "SELECT SUM(balance) as balance 
				FROM purchase_order 
				WHERE purchase_unique_id = '$unique_id'";
			
		$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['balance'];
	}

	function getDeliveryDelivered($db, $po_no_delivery, $office){

		$sql = "SELECT SUM(quantity) as quantity
				FROM delivery
				WHERE remarks = 'Delivered'
				AND office = '$office'
				AND po_no_delivery = '$po_no_delivery'";
			// echo $sql;
		$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['quantity'];

	}

	function getDeliveryOnDelivery($db, $po_no_delivery, $office){

		$sql = "SELECT SUM(quantity) as quantity
				FROM delivery
				WHERE remarks = 'On Delivery'
				AND office = '$office'
				AND po_no_delivery = '$po_no_delivery'";
			// echo $sql;
		$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['quantity'];

	}
/* End of list of functions for Delivery Order Page */

/* Start of list of functions for Purchase Order Aggegrates Page */



/* End of list of functions for Purchase Order Aggegrates Page */

/* Start of list of functions for Received Page */

	function getAggCountPending($db){

		$sql = "SELECT count(*) as total
				FROM purchase_order_aggregates
				WHERE remarks = 'Pending'";

		$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['total'];
	}

	function getAggCountPendingOffice($db, $office){

		$sql = "SELECT count(*) as total
				FROM purchase_order_aggregates
				WHERE remarks = 'Pending'
				AND office = '$office'";
	
		$result = mysqli_query($db, $sql);
      	$row = mysqli_fetch_assoc($result);

      	return $row['total'];
	}

/* End of list of functions for Purchase Order Page */
?>
