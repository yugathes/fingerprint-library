<?php
//call this function to check if session exists or not
session_start();

//if session exists
if(isset ($_SESSION["userId"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";
	?>
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
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<?php	
	$examID = $_GET["id"];
	$takeAtt = "http://".$ip.":5000/attendance?cID=".$examID;
    $getExamNameQ = "SELECT name FROM exam WHERE id = '".$examID."'";
    $getExamNameR = mysqli_query($link,$getExamNameQ);
    if(!$getExamNameR)
    {
        die ("Invalid Query - get Items List: ". mysqli_error($link));
    }
    else
    {
        $getExamNameRow = mysqli_fetch_array($getExamNameR, MYSQLI_BOTH);
        $getExamName = $getExamNameRow['name'];
    }?>
	<a style="float:right;margin-right:10px;background-color:black;" href="<?php echo $takeAtt?>" class="btn">Take Attendance</a><br><br>
	<h1 align="center">Attendance <br> <?php echo $getExamName;?></h1>
<?php
    
	$queryGet = "SELECT
                    s.name,
                    she.id,
                    she.attendance,
                    she.attendance_date_time
                FROM
                    student_has_exam she
                INNER JOIN
                    student s ON she.student_id = s.id
                WHERE she.exam_id = '".$examID."'";
	$resultGet = mysqli_query($link,$queryGet);
	if(!$resultGet)
	{
		die ("Invalid Query - get Items List: ". mysqli_error($link));
	}
	else
	{?>
	<table id="table" border="1" align="center">
		<tr>
			<th>No</th>
			<th>Name</th>
			<th>Attendance</th>
			<th colspan=2>Attendance Date Time</th>
<!--			<th>Action</th>-->
		</tr>	 
		<form>
<?php	$no=1;
		if(mysqli_num_rows($resultGet)>0){
		while($row= mysqli_fetch_array($resultGet, MYSQLI_BOTH))
		{	
			if($row['attendance_date_time']){
			$datetimeObject = new DateTime($row['attendance_date_time']);

			// Get separate date and time variables
			$date = $datetimeObject->format('Y-m-d');
			$time = $datetimeObject->format('H:i:s');
			}
			else{
				$date = "NULL";
				$time = "NULL";
			}
			?>
			<tr>
				<td><?php echo $no;?></td>
				<td><?php echo $row['name']?></td>
				<td id="attendanceList<?php echo $no?>"><?php if($row['attendance']==1) echo "Present"; else echo "Not attended"?></td>
				<script>
		$(document).ready(function(){
            function checkUpdates<?php echo $no?>() {
                $.ajax({
                    type: 'POST',
                    url: 'get_attendance.php', // PHP script to handle the request
                    data: { id: <?php echo $row['id']; ?> }, // Send student ID to the server
                    success: function(response){
						console.log(response);
                        $('#attendanceList<?php echo $no?>').html(response);
                    },
                    complete: function(){
                        // Schedule the next check after a certain interval (e.g., 1 second)
                        setTimeout(checkUpdates<?php echo $no?>, 1000);
                    }
                });
            }

            // Start checking for updates
            checkUpdates<?php echo $no?>();
        });
</script>
				<td><?php echo $date?></td>
				<td><?php echo $time?></td>
<!--				<td><a href="ExamEdit.php?id=--><?php //echo $row['id'];?><!--">-->
<!--					<img border="0" alt="editB" src="../CSS/btn/editB.png" width="25" height="25"></a>-->
<!--					<a href="Delete.php?examID=--><?php //echo $row['id'];?><!--" onclick="return confirm('Are you sure?')">-->
<!--					<img border="0" alt="editB" src="../CSS/btn/delB.png" width="25" height="25"></a></a>-->
<!--				</td>-->
			</tr>
		<?php	$no++;}}
		else{
?>
			<tr>
				<td colspan="6">No Data</td>
			</tr>
		<?php	}?>
		</form>	
	</table>
	<br><br><br><br>
<?php
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
