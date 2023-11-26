<?php
//call this function to check if session exists or not
session_start();

//if session exists
if(isset ($_SESSION["userId"])) //session userid gets value from text field named userid, shown in user.php
{
	include "Header.php";?>
<!DOCTYPE html>
<html>
<head>
<style>
.mid{
	margin: auto;
	width: 50%;
	padding: 10px;
	
}
.content2 {
	margin: auto;
	margin-top: 20px;
	width: 100%;
	padding: 20px; 
	border: 1px solid #483235;
	background: white;
	border-radius: 10px 10px 10px 10px;
}
.input-group2 {
  margin: 10px 0px 10px 0px;
}
.input-group2 label {
	display: inline-flex;  
    margin-bottom: 10px;
	text-align: left;
	margin: 3px;
}
.input-group2 input {
	display: inline;
	float: right;
	height: 30px;
	width: 50%;
	padding: 5px 10px;
	font-size: 16px;
	border-radius: 5px;
	border: 1px solid gray;
}
.input-group2 select {
	display: inline;
	float: right;
	height: 30px;
	width: 50%;
	padding: 5px 10px;
	font-size: 16px;
	border-radius: 5px;
	border: 1px solid gray;
}
.input-group2 textarea {
	display: inline;
	float: right;
	width: 50%;
	padding: 5px 10px;
	font-size: 16px;
	border-radius: 5px;
	border: 1px solid gray;
}
.content button{
	display: block;
	float: right;
	
}
</style>
</head>
<body>
	<h1 align="center"> Admins </h1>
	<?php
	$queryGet = "select * from users order by type_user ASC";	
	$resultGet = mysqli_query($link,$queryGet);
	if(!$resultGet)
	{	die ("Invalid Query - get Items List: ". mysqli_error($link));	}
	else
	{	$no=1;?>
        <table id="table" align="center">
            <tr>
				<th>No</th>
				<th>Staff ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Type User</th>
				<th>Action</th>
			</tr>	 
<?php		while($row= mysqli_fetch_array($resultGet, MYSQLI_BOTH))
			{
			?>
			<tr>
				<td><?php echo $no;?></td>
				<td><?php echo $row['staffId']?></td>
				<td><?php echo $row['name']?></td>
				<td><?php echo $row['email'];?></td>
				<td><?php echo $row['type_user'];?></td>
				<td><a href="Edit.php?id=<?php echo $row['id'];?>">
					<img border="0" alt="editB" src="../CSS/btn/editB.png" width="25" height="25"></a>
					<a href="Delete.php?userID=<?php echo $row['id'];?>" onclick="return confirm('Are you sure?')">
					<img border="0" alt="editB" src="../CSS/btn/delB.png" width="25" height="25"></a></a>
				</td>
			</tr>
<?php
	$no++;		}?>
		</table>
<?php
		}?>
		
		<div class="mid">
			<form class="content2" action="Lecturer.php" method="POST">
				<h1 class="header">Staff Registration</h1>
					<div class="input-group2">
						<label>Staff ID*</label>
						<input type="text" name="staffId"><br><br>
						<label>Password*</label>
						<input type="password" name="password"><br><br>
						<label>Name*</label>
						<input type="text" name="name"><br><br>
						<label>Email*</label>
						<input type="email" name="email"><br><br>
						<label>Type of user*</label>
						<select name="type_user">
							<option value=""></option>
							<option value="Lecturer">Lecturer</option>
							<option value="Admin">Admin</option>
						</select><br><br>
						<p style="margin-top: 0px;float: right;color: red;">* is required to fill</p>
					</div> 	
					<br>
					<button type="submit" class="btn" style="margin-top: 10px;" name="reg_user">Register</button>	
			</form>
	</div>
	<br><br><br><br>
<?php 
	if(isset($_POST['reg_user']))
	{
		$staffId = $_POST['staffId'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$type_user = $_POST['type_user'];
		
		$sql = "INSERT INTO users (staffId, password, name, email, type_user) 
				values ('".$staffId."', '".$password."', '".$name."', '".$email."', '".$type_user."')";
		$result = mysqli_query($link, $sql);
		if (!$result)
		{
			die("Error:".mysqli_error($ds));
			$fail = "Please Check Registration.";
			echo "<script type='text/javascript'>alert('$fail');
			document.location='Lecturer.php';
			</script>"; 
		}
		else
		{
			$success = "Registration Success.";
			echo "<script type='text/javascript'>alert('$success');
			document.location='Lecturer.php';
			</script>"; 
		}
	}
}		
else	{
	echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 5 seconds";
	header('Refresh: 5; ../Auth/Login.php');
}

	?>
</body>
</html>
