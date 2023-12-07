<?php
	include "../Auth/connection.php";
	error_reporting(0);
	$uID = $_GET['userID'];
	$sID = $_GET['sid'];
	$eID = $_GET['eid'];
	$courseID = $_GET['courseID'];
	$semesterID = $_GET['semesterID'];
        $examID = $_GET['examID'];

        if(isset($examID)){
		echo $examID;
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
		$queryDelete = "DELETE FROM users WHERE id = '".$uID."'";
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
		$queryDelete = "DELETE FROM student WHERE id = '".$sID."'";
		$resultDelete = mysqli_query($link,$queryDelete);
		if (!$resultDelete)
		{
			die ("Error: ".mysqli_error($link));
		}		
		else {
			$link = "http://".$ip.":5000/delete?uid=".$sID;
			header("Location: Student.php");
		}
	}
?>
