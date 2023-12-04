<?php
session_start();

//if session exists
if(isset ($_SESSION["username"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
	$pID = $_GET["id"];
	$queryGet = "select * from class where cID='".$pID."'";

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
			<form class = "content" style="position: relative; width: 60%; margin:auto;left:0" action="ClassUpdate.php" name="EditForm" method="POST">
				<h1 class="header">Edit Class Detail</h1>
				<?php	while($baris= mysqli_fetch_array($resultGet, MYSQLI_BOTH))	{?>
					<div class="input-group">
						<label>Name</label>
						<input type="text" name="name" value="<?php echo $baris['name']; ?>"><br><br>
						<input type="hidden" name="id" value="<?php echo $baris['cID']; ?>">
						<label>No Student</label>
						<input type="number" name="no" value="<?php echo $baris['student'] ?>"><br><br>
						<label>Time Slot</label>
						<input type="time" name="timeslot" value="<?php echo $baris['timeSlot'] ?>"><br><br>
						<label>Time Slot 2</label>
						<input type="time" name="timeslot2" value="<?php echo $baris['timeSlot2'] ?>"><br><br>
						<label>Lecturer</label>
						<?php						
						$queryGet1 = "select * from users where type_user='Lecturer'";
						$resultGet1 = mysqli_query($link,$queryGet1);
						if(!$resultGet)
						{
							die ("Invalid Query - get Register List: ". mysqli_error($link));
						}
						else 
						{	?>
						<select id="service" name="lecturer">
				<?php	while($row= mysqli_fetch_array($resultGet1, MYSQLI_BOTH))	{ ?>
						<option value="<?php echo $row['username'];?>" <?php if($row['username']==$baris['lecturer'])	echo "selected";?> ><?php echo $row['username'];?></option>
				<?php	}
						}
						?></select><br><br>
						<button style="position: relative;left: 80%"; type="submit" class="btn" name="class">Update</button>
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
