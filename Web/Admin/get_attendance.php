<?php
include "../Auth/connection.php";

// Get the selected value from the first select
$studentId = $_POST['id'];

// Query to get the latest attendance information for the specific student
$query = "SELECT attendance, attendance_date_time FROM student_has_exam WHERE id = '$studentId'";
$result = mysqli_query($link, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result, MYSQLI_BOTH);
	$attendance = $row['attendance'];
    $attendanceDateTime = $row['attendance_date_time'];
	if($attendance==1)
		echo "Present";
	if($attendance==0)
		echo "NULL";
}
else {
    echo "Error: " . mysqli_error($link);
}

?>