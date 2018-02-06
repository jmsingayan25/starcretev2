<?php

	include("../../includes/config.php");

	$site_id = mysqli_real_escape_string($db, $_GET['site_id']);
	$query = "SELECT site_contact_name, site_contact_person_id FROM site_contact_person WHERE site_id = '".$site_id."'";
	$result = mysqli_query($db, $query);
	echo $query;
	if(mysqli_num_rows($result) > 0){
		echo '<option value="">Select</option>';
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<option value='".$row['site_contact_person_id']."'>".$row['site_contact_name']."</option>";
		}
	}else{
		echo '<option value="">Select</option>';
	}
	

?>