<?php
	include "../Auth/connection.php";
	error_reporting(1);
	$uID = $_GET['uid'];
	$sID = $_GET['sid'];
	$eID = $_GET['eid'];

	if(isset($examID)){
		$queryDelete = "DELETE FROM exam WHERE id = '".$examID."'";
		$resultDelete = mysqli_query($link,$queryDelete);
		if (!$resultDelete)
		{
			die ("Error: ".mysqli_error($link));
		}
		else {
			header("Location: Exam.php");
		}
	}
	if(isset($eID)){
		$queryDelete = "DELETE FROM student_has_exam WHERE id = '".$eID."'";
		$resultDelete = mysqli_query($link,$queryDelete);
		if (!$resultDelete)
		{
			die ("Error: ".mysqli_error($link));
		}
		else {
			header("Location: Enroll.php");
		}
	}

	if(isset($uID)){
		echo $uID;
		$queryDelete = "DELETE FROM users WHERE id = '".$uID."'";
		$resultDelete = mysqli_query($link,$queryDelete);
		if (!$resultDelete)
		{
			die ("Error: ".mysqli_error($link));
		}		
		else {
			header("Location: Users.php");
		}
	}
	if(isset($sID)){
		$queryDelete = "DELETE FROM student WHERE id = '".$sID."'";
//		$queryFKDelete = "DELETE FROM student_has_exam WHERE student_id = '".$sID."'";
//		$resultFKDelte = mysqli_query($link,$queryFKDelete);
		$resultDelete = mysqli_query($link,$queryDelete);
		if (!$resultDelete)
		{
			die ("Error: ".mysqli_error($link));
		}		
		else {
				$link = "http://".$ip.":5000/delete?uid=".$sID;
				header("Location: $link");
		}
	}
?>
