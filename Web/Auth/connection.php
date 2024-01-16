<?php
$link=mysqli_connect('localhost', 'root', 'sudo', 'library');
// Check connection
if (mysqli_connect_errno())
{
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
//      die();
}
$connection = new mysqli("localhost","root","sudo","library");
if ($connection->connect_error) {
	die("Connection failed: " . $connection->connect_error);
}
$ip = $_SERVER['SERVER_ADDR'];
?>
