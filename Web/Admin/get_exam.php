<?php
include "../Auth/connection.php";

// Get the selected value from the first select
$selectedValue = $_POST['selectedValue'];
echo $_POST['selectedValue'];
$sql = "SELECT e.id, e.name
        FROM exam e
        WHERE e.id NOT IN (
            SELECT she.exam_id
            FROM student_has_exam she
            WHERE she.student_id = $selectedValue
        )";
$result = mysqli_query($link,$sql);
$options = '';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
        $options .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
}
echo $options;

?>