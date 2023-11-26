<?php
	include "../Auth/connection.php";
	if(isset($_POST['staff'])){
		$name = $_POST["name"];
		$id = $_POST["id"];
		$email = $_POST["email"];
		$staffId = $_POST["staffId"];
		$type_user = $_POST["type_user"];
		$queryInsert = "UPDATE users SET
		   name = '".$name."', 
		   staffId = '".$staffId."', 
		   type_user = '".$type_user."', 
		   email = '".$email."'
		   WHERE id = '$id'";
		 
		$resultInsert = mysqli_query($link,$queryInsert);
		if (!$resultInsert)
		{
			die ("Error: ".mysqli_error($link));
		}		
		else {
			echo '<script type="text/javascript">
					window.onload = function () 
					{ 
					alert("Staff Detail has been Updated...");
					open("Lecturer.php","_top");
					}
					</script>';

		}
	}
	if(isset($_POST['semester'])){
		$name = $_POST["name"];
		$id = $_POST["id"];
		
		$queryInsert = "UPDATE semester SET
		   name = '".$name."'
		   WHERE id = '$id'";
		 
		$resultInsert = mysqli_query($link,$queryInsert);
		if (!$resultInsert)
		{
			die ("Error: ".mysqli_error($link));
		}		
		else {
			echo '<script type="text/javascript">
					window.onload = function () 
					{ 
					alert("Information has been Updated...");
					open("Management.php","_top");
					}
					</script>';

		}
	}
	if(isset($_POST['course'])){
		$name = $_POST["name"];
		$id = $_POST["id"];
		
		$queryInsert = "UPDATE course SET
		   name = '".$name."'
		   WHERE id = '$id'";
		 
		$resultInsert = mysqli_query($link,$queryInsert);
		if (!$resultInsert)
		{
			die ("Error: ".mysqli_error($link));
		}		
		else {
			echo '<script type="text/javascript">
					window.onload = function () 
					{ 
					alert("Information has been Updated...");
					open("Management.php","_top");
					}
					</script>';

		}
	}
	
?>