<?php
	include "../Auth/connection.php";
	$name = $_POST["name"];
	$noS = $_POST["no"];
	$timeslot = $_POST["timeslot"];
	$timeslot2 = $_POST["timeslot2"];
	$lecturer = $_POST["lecturer"];
	echo $lecturer;
	$cID = $_POST["id"];
	$queryInsert = "UPDATE class SET
	   name = '".$name."', 
	   lecturer = '".$lecturer."',
	   student = '".$noS."', 
	   timeSlot = '".$timeslot."',
	   timeSlot2 = '".$timeslot2."'
	   WHERE cID = '$cID'";
	 
	$resultInsert = mysqli_query($link,$queryInsert);
	if (!$resultInsert)
	{
		die ("Error: ".mysqli_error($link));
	}		
	else {
		echo '<script type="text/javascript">
				window.onload = function () 
				{ 
				alert("Class has been Updated...");
				open("Class.php","_top");
				}
				</script>';

	}
?>
