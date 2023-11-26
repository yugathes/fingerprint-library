<?php
session_start();

//if session exists
if(isset ($_SESSION["userId"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
	$userID = $_GET["id"];
	$queryGet = "select * from users where id='".$userID."'";

	$resultGet = mysqli_query($link,$queryGet);

	if(!$resultGet)
	{
		die ("Invalid Query - get Register List: ". mysqli_error($link));
	}
	else 
	{?>
	<div class="wrapper">
		<div class="middle">
			<div class="contentnew" style="margin-bottom: 50px;">
			<form class = "content" style="position: relative; width: 60%; margin:auto;left:0" action="Update.php" name="EditForm" method="POST">
				<h1 class="header">Edit Admin Detail</h1>
				<?php	while($baris= mysqli_fetch_array($resultGet, MYSQLI_BOTH))	{?>
					<div class="input-group">
						<label>Staff ID</label>
						<input type="text" name="staffId" value="<?php echo $baris['staffId']; ?>"><br><br>
						<input type="hidden" name="id" value="<?php echo $baris['id']; ?>">
						<label>Name</label>
						<input type="text" name="name" value="<?php echo $baris['name'] ?>"><br><br>
						<label>Email</label>
						<input type="email" name="email" value="<?php echo $baris['email'] ?>"><br><br>
						<label>Type of user*</label>
						<select name="type_user">
							<option value="">Choose One</option>
							<option value="Lecturer" <?php if($baris['type_user']=='Lecturer') echo 'selected'?>>Lecturer</option>
							<option value="Admin" <?php if($baris['type_user']=='Admin') echo 'selected'?>>Admin</option>
						</select><br><br>
						<button style="position: relative;left: 80%"; type="submit" class="btn" name="staff">Update</button>
					</div> <?php	}?>
			</form>
			</div>
		</div>
	</div>
	<?php
		}
}
else {
	echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 5 seconds";
	header('Refresh: 5; ../Admin/Login.php');
}
	?>

</body>
</html>