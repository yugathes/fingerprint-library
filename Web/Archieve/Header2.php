<head>
<?php 	include "../Auth/connection.php";
		$direct = dirname($_SERVER['PHP_SELF']); $newD = explode("/", $direct);?>

    <title><?php echo end($newD);?> System</title>
    <link rel="stylesheet" type="text/css" href="../CSS/topNav.css">
	<div class="topnav">
        <a <?php if (basename($_SERVER['PHP_SELF']) == "Menu.php") echo "class='active'"?> href="Menu.php">Menu</a>
		<a <?php if (basename($_SERVER['PHP_SELF']) == "Lecturer.php") echo "class='active'"?>href="Lecturer.php">Admins</a>
		<a <?php if (basename($_SERVER['PHP_SELF']) == "Management.php") echo "class='active'"?>href="Management.php">Management</a>
		<a <?php if (basename($_SERVER['PHP_SELF']) == "Student.php") echo "class='active'"?>href=".php">Student</a>
		<a <?php if (basename($_SERVER['PHP_SELF']) == "Exam.php") echo "class='active'"?>href="Exam.php">Exam</a>
		<a <?php if (basename($_SERVER['PHP_SELF']) == "Attendance.php") echo "class='active'"?>href="Attendance.php">Attendance</a>
	        <a <?php if (basename($_SERVER['PHP_SELF']) == "Enroll.php") echo "class='active'"?>href="Enroll.php">Enroll</a>
	</div>
	<div class="auth">
<?php if(isset ($_SESSION["userId"])) //session userid gets value from text field named userid, shown in user.php
    {?>
	    <a style="background-color:#6f7378;" href="../Auth/Logout.php"> Logout </a>
<?php	
	}
	else
	{
	?>
	    <a style="background-color:#6f7378;" href="../Auth/Login.php"> Login </a>
<?php
	}?>
		</div>
</head>
<h4>Hi user, <?php echo $_SESSION["name"];?></h4>
<div class="left-sidebar">
<?php //include 'count.php';?>
</div>

?>
