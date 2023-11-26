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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
	width: 70%;
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
	<div class="mid">
		<form class="content2" action="EnrollAdd.php" method="POST">
			<h1 class="header" style="background-color:red;">Enroll Exam</h1>
				<div class="input-group2">
					<label>Student Name*</label>
					<select name="student" id="student">
                        <option value="">Please choose one student</option>
                        <?php
                        $queryGet = "SELECT student.name as studentName, student.id as studentId,student_has_exam.exam_id
                                    FROM student 
                                    LEFT JOIN student_has_exam ON student.id = student_has_exam.student_id;";
                        $resultGet = mysqli_query($link,$queryGet);
                        if(!$resultGet)
                        {	die ("Invalid Query - get Items List: ". mysqli_error($link));	}
                        else{
                        while($row= mysqli_fetch_array($resultGet, MYSQLI_BOTH))
                        { ?>
                        <option value="<?php echo $row['studentId']?>"><?php echo $row['studentName']?></option>
                        <?php } }?>
                    </select><br><br>
                    <label>Exam*</label>
                    <select name="exam" id="exam">
                        <option value="">Choose student first</option>

                    </select>
					<p style="margin-top: 0px;float: right;color: red;">* is required to fill</p>
				</div> 	
				<br>
				<button type="submit" class="btn" style="margin-top: 10px;" name="reg_semester">Register</button>	
		</form>
	</div>
    <script>
        $(document).ready(function(){
            // On change of the first select
            $('#student').change(function(){
                // Get the selected value
                var selectedValue = $(this).val();
                console.log(selectedValue);

                // Make an AJAX request to the server
                $.ajax({
                    type: 'POST',
                    url: 'get_exam.php', // PHP script to handle the request
                    data: { selectedValue: selectedValue },
                    success: function(response){
                        // Update the content of the second select with the received options
                        $('#exam').html(response);
                    }
                });
            });
        });
    </script>
	<br><br><br><br>
<?php
	if(isset($_POST['reg_semester']))
	{
		$name = $_POST['name'];
		$name = preg_replace("/'/", "\&#39;", $name);
		
		$sql = "INSERT INTO semester (name) 
				values ('".$name."')";
		$result = mysqli_query($link, $sql);
		if (!$result)
		{
			die("Error:".mysqli_error($ds));
			$fail = "Please Check Registration.";
			echo "<script type='text/javascript'>alert('$fail');
			document.location='Management.php';
			</script>"; 
		}
		else
		{
			$success = "Registration Success.";
			echo "<script type='text/javascript'>alert('$success');
			document.location='Management.php';
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
