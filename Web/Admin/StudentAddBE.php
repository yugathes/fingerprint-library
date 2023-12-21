<?php
session_start();
include "../Auth/connection.php";
if (isset($_POST['studentAdd'])) {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $password = 123;
    $email = $_POST['email'];
    $type_user = $_POST['type_user'];
    $enrol_fingerprint = 0;

    $sql = "INSERT INTO users (name, local_id, password, email, fingerprint, type_user) 
				values ('" . $name . "', '" . $student_id . "', '" . $password . "','".$email."', '" . $enrol_fingerprint . "', '".$type_user."')";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        $fail = "Please Check Registration.";
        echo "<script type='text/javascript'>alert('$fail');
			document.location='StudentAdd.php';
			</script>";
        die("Error:" . mysqli_error($link));
    } else {
        $last_id = mysqli_insert_id($link);
        $success = "Registration Success.";
        $_SESSION['notification'] = $success.', '.$name;
        header("Location: UsersEdit.php?id=".$last_id);
        exit();
    }
}
?>