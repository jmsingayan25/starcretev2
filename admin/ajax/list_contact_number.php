<?php

	include("../../includes/config.php");

	$contact_id = mysqli_real_escape_string($db, $_GET['contact_id']);
	$sql = "SELECT DISTINCT site_contact_no FROM site_contact_number WHERE site_contact_person_id = '".$contact_id."'";
	$result = mysqli_query($db, $sql);

	$contact_number_array = array();
	// echo '<option value = "">Select</option>';
	while ($row = mysqli_fetch_assoc($result)) {
		// echo "<option value = '".$row['contact_number']."'>".$row['contact_number']."</option>";
		$contact_number_array[] = $row['site_contact_no'];
	}

	$numbers = implode(", ", $contact_number_array);
	echo "<input type='text' id='contact_number' name='contact_number' value='".$numbers."' class='form-control' readonly>"
?>