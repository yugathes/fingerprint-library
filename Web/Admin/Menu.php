<?php
//call this function to check if session exists or not
session_start();

//if session exists
if(isset ($_SESSION["userId"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";?>
<!DOCTYPE html>
<html lang="en">

<body class="g-sidenav-show dark-version bg-gray-100">
<?php

$studentsQuery = "SELECT * FROM users WHERE type_user = 'Student'";
$studentsRow = mysqli_query($link,$studentsQuery);
$students = mysqli_num_rows($studentsRow);

$lecturesQuery = "SELECT * FROM users WHERE type_user = 'Lecturer'";
$lecturesRow = mysqli_query($link,$lecturesQuery);
$lectures = mysqli_num_rows($lecturesRow);

$adminsQuery = "SELECT * FROM users WHERE type_user = 'Admin'";
$adminsRow = mysqli_query($link,$adminsQuery);
$admins = mysqli_num_rows($adminsRow);

$todayAttn = 0;
$todayDate = date("Y-m-d");
$todayAttnQuery = "SELECT * FROM attendance WHERE date = '$todayDate'";
$todayAttnRow = mysqli_query($link,$todayAttnQuery);
$todayAttn = mysqli_num_rows($todayAttnRow);

?>
<main class="main-content position-relative border-radius-lg ">
    <?php include "navbar.php";?>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Student</p>
                                    <h5 class="font-weight-bolder">
                                        <?php echo $students; ?>
                                    </h5>
<!--                                    <p class="mb-0">-->
<!--                                        <span class="text-success text-sm font-weight-bolder">+55%</span>-->
<!--                                        since yesterday-->
<!--                                    </p>-->
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Lecturer</p>
                                    <h5 class="font-weight-bolder">
                                        <?php echo $lectures; ?>
                                    </h5>
<!--                                    <p class="mb-0">-->
<!--                                        <span class="text-success text-sm font-weight-bolder">+3%</span>-->
<!--                                        since last week-->
<!--                                    </p>-->
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Admin</p>
                                    <h5 class="font-weight-bolder">
                                        <?php echo $admins; ?>
                                    </h5>
<!--                                    <p class="mb-0">-->
<!--                                        <span class="text-danger text-sm font-weight-bolder">-2%</span>-->
<!--                                        since last quarter-->
<!--                                    </p>-->
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Entries</p>
                                    <h5 class="font-weight-bolder">
                                        <?php echo $todayAttn; ?>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
            </div>
    </div>
</main>
<?php include "footer.php";?>>
</body>

</html>
<?php
}

else	{
    echo "No session exists or session has expired. Please log in again ";
    echo "Page will be redirect in 5 seconds";
    header('Refresh: 5; ../Auth/Login.php');
}
?>