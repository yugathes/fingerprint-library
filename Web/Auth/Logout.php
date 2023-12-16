<?php
session_start();
if (isset($_SESSION["userId"]))
{
	session_destroy();
	header('location: Login.php');
}
else
	echo " No session exists or session is expired. Please log in again <a href='Login.php'> here </a>";
?>

