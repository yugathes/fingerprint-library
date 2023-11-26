<?php
	include "../Auth/connection.php";
	$name = $_POST["name"];
	$student_id = $_POST["student_id"];
	$email = $_POST["email"];
	$ic_no = $_POST["ic_no"];
	$course_id = $_POST["course_id"];
	$semester_id = $_POST["semester_id"];
	$uID = $_POST["id"];
		
	$queryInsert = "UPDATE student SET
	   name = '".$name."', 
	   ic_no = '".$ic_no."', 
	   student_id = '".$student_id."', 
	   email = '".$email."',
	   course_id = '".$course_id."',
	   semester_id = '".$semester_id."'
	   WHERE id = '$uID'";

	$resultInsert = mysqli_query($link,$queryInsert);
	if (!$resultInsert)
	{
		die ("Error: ".mysqli_error($link));
	}		
	else {
			echo '<script type="text/javascript">
			window.onload = function () 
			{ 
			alert("Student Detail has been Updated...");
			open("Student.php","_top");
			}
			</script>';
	}
?>