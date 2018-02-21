<?php

	include("../../includes/config.php");

	$site_id = mysqli_real_escape_string($db, $_GET['site_id']);
	$query = "SELECT site_contact_name, site_contact_person_id 
				FROM site_contact_person 
				WHERE site_id = '".$site_id."'
				ORDER BY site_contact_name ASC";
	$result = mysqli_query($db, $query);
	// echo $query;
	// if(mysqli_num_rows($result) > 0){
		// echo '<option value="">Select</option>';
		while ($row = mysqli_fetch_assoc($result)) {

			$number = "SELECT GROUP_CONCAT(site_contact_no SEPARATOR ', ') as site_contact_no
						FROM site_contact_number
						WHERE site_contact_person_id = '".$row['site_contact_person_id']."'";

			$num_result = mysqli_query($db, $number);
			$num_row = mysqli_fetch_assoc($num_result);

			$row['site_contact_no'] = $num_row['site_contact_no'];
			// echo "<option value='".$row['site_contact_person_id']."'>".$row['site_contact_name']."</option>";
			echo "<input type='hidden' name='contact_name[]' value='".$row['site_contact_person_id']."'> ".$row['site_contact_name']." (".$row['site_contact_no'].")<br>";
		}
	// }else{
	// 	// echo '<option value="">Select</option>';
	// }
	

?>