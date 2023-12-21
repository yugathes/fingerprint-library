<?php
    session_start();
	include "../Auth/connection.php";
	$name = $_POST["name"];
	$student_id = $_POST["student_id"];
	$email = $_POST["email"];
	$uID = $_POST["id"];
	$redirect = $_POST["redirect"];
	if($redirect == "profile")
    {
        $password = $_POST["password"];
        $queryInsert = "UPDATE users SET
                       name = '".$name."',
                       password = '".$password."',
                       local_id = '".$student_id."',
                       email = '".$email."'
                       WHERE id = '$uID'";
    }
    else {
        $queryInsert = "UPDATE users SET
                        name = '" . $name . "',
                       local_id = '" . $student_id . "',
                       email = '" . $email . "'
                       WHERE id = '$uID'";
    }
	$resultInsert = mysqli_query($link,$queryInsert);
	if (!$resultInsert)
	{
		die ("Error: ".mysqli_error($link));
	}
	else {
        if($redirect == "profile"){
            $success = "Your profile has been Updated";
            $redirectLink = "Profile.php";
        }
        else{
            $success = "User Detail has been Updated";
            $redirectLink = "Users.php";
        }

        $_SESSION['notification'] = $success;
        header("Location:".$redirectLink);
        exit();
	}
?>