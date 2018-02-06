<?php

	include("../../includes/config.php");

	$client_id = mysqli_real_escape_string($db, $_GET['client']);
	$query = "SELECT site_id, site_name, site_address FROM site WHERE client_id = '".$client_id."'";
	$result = mysqli_query($db, $query);
	echo $query;
	if(mysqli_num_rows($result) > 0){
		echo '<option value="">Select</option>';
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<option value='".$row['site_id']."'>".$row['site_name']." / ".$row['site_address']."</option>";
		}
	}else{
		echo '<option value="">Select</option>';
	}
	
	// echo "<option value='add_site'>Add New Site</option>";
?>