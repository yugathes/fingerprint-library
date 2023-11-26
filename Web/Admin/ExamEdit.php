<?php
session_start();

//if session exists
if(isset ($_SESSION["userId"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";?>
<!DOCTYPE html>
<html>
<head>
<style>
.checkbox {
	display: inline-flex; /* Use a flex container for horizontal alignment */
	align-items: center; /* Vertically center the elements */
}
        
.checkbox input[type="checkbox"] {
	margin-right: 10px; /* Add some space between the checkbox and input */
}
</style>
</head>
<body>
<?php
	$pID = $_GET["id"];
	$queryGet = "select * from exam where id='".$pID."'";

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
			<form class = "content" style="position: relative; width: 60%; margin:auto;left:0" action="ExamEdit.php" name="EditForm" method="POST">
				<h1 class="header">Edit Class Detail</h1>
				<?php	while($baris= mysqli_fetch_array($resultGet, MYSQLI_BOTH))	{?>
					<div class="input-group">
						<label>Name</label>
						<input type="text" name="name" value="<?php echo $baris['name']; ?>"><br><br>
						<input type="hidden" name="id" value="<?php echo $baris['id']; ?>">
						<label>Student</label>
						<?php						
						$queryGet1 = "select * from student";
						$resultGet1 = mysqli_query($link,$queryGet1);
						if(!$resultGet1)
						{
							die ("Invalid Query - get Register List: ". mysqli_error($link));
						}
						else 
						{
							$i = 0;
						while($row= mysqli_fetch_array($resultGet1, MYSQLI_BOTH))	{ 
							?>
						<div class="checkbox">
						<label for="student<?php echo $i?>"><?php echo $row['name']?>
							<input type="checkbox" id="student<?php echo $i?>" name="student[<?php echo $i?>]" value="<?php echo $row['id']?>">
						</label><br>
						</div>
				<?php	
						$i++;
						}
						}
						?><br><br>
						<button style="position: relative;left: 80%"; type="submit" class="btn" name="exam_update">Update</button>
					</div> <?php	}?>
			</form>
			</div>
		</div>
	</div>
	<?php
	}
	if(isset($_POST['exam_update']))
	{
		$classID = $_POST['id'];
		$students = $_POST['student'];
		$noStudents = count($students);
		$no = 0;
		foreach($students as $student){
			$sql = "INSERT INTO student_has_exam (student_id, exam_id, attendance, attendance_date_time) 
				values ('".$student."', '".$classID."', 0, NULL)";
			$result[$no] = mysqli_query($link, $sql);
		}
		
		if (!$result)
		{
			die("Error:".mysqli_error($ds));
			$fail = "Please Check Registration.";
			echo "<script type='text/javascript'>alert('$fail');
			document.location='Exam.php';
			</script>"; 
		}
		else
		{
			$success = "Registration Success.";
			echo "<script type='text/javascript'>alert('$success');
			document.location='Exam.php';
			</script>"; 
		}
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
