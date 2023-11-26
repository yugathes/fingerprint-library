<?php
	include "../Auth/connection.php";
	error_reporting(0);
	$uID = $_GET['id'];
	$sID = $_GET['sid'];
	$courseID = $_GET['courseID'];
	$semesterID = $_GET['semesterID'];
	
	if(isset($courseID)){
		$queryDelete = "DELETE FROM course WHERE id = '".$courseID."'";
		$resultDelete = mysqli_query($link,$queryDelete);
		if (!$resultDelete)
		{
			die ("Error: ".mysqli_error($link));
		}		
		else {
			header("Location: Management.php");
		}
	}
	if(isset($semesterID)){
		$queryDelete = "DELETE FROM semester WHERE id = '".$semesterID."'";
		$resultDelete = mysqli_query($link,$queryDelete);
		if (!$resultDelete)
		{
			die ("Error: ".mysqli_error($link));
		}		
		else {
			header("Location: Management.php");
		}
	}
	if(isset($uID)){
		$queryDelete = "DELETE FROM users WHERE username = '".$uID."'";
		$resultDelete = mysqli_query($link,$queryDelete);
		if (!$resultDelete)
		{
			die ("Error: ".mysqli_error($link));
		}		
		else {
			header("Location: Lecturer.php");
		}
	}
	if(isset($sID)){
		$queryDelete = "DELETE FROM users WHERE uid = '".$sID."'";
		$resultDelete = mysqli_query($link,$queryDelete);
		if (!$resultDelete)
		{
			die ("Error: ".mysqli_error($link));
		}		
		else {
			$link = "http://".$ip.":5000/delete?uid=".$sID;
			header("Location: ".$link."");
		}
	}
?>
