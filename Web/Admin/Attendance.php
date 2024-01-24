<?php
//call this function to check if session exists or not
session_start();

//if session exists
if(isset ($_SESSION["userId"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <body class="g-sidenav-show dark-version bg-gray-100">

    <main class="main-content position-relative border-radius-lg ">
        <?php include "navbar.php";?>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <h6>Attendance table</h6>
<!--                               TODO: Search-->
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
<?php
	$lin = mysqli_connect('localhost', 'root', 'sudo', 'library');
	$queryGet = "SELECT attendance.*, users.name, users.local_id FROM `attendance` INNER JOIN users ON attendance.user_id = users.id";
	$resultGet = mysqli_query($lin,$queryGet);
	if(!$resultGet)
	{
		die ("Invalid Query - get Items List: ". mysqli_error($link));
	}
	else
	{?>
                                <table class="table align-items-center mb-0">
                                    <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Time</th>
                                        <th class="text-secondary opacity-7">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
<?php	while($row= mysqli_fetch_array($resultGet, MYSQLI_BOTH))
		{	
			$date = date('d-m-Y', strtotime($row['date']));
			$time = date('g:i A', strtotime($row['time']));
			?>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?php echo $row['name']?></h6>
                                                    <p class="text-xs text-secondary mb-0"><?php echo $row['local_id']; ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
										   <p class="text-xs font-weight-bold mb-0"><?php echo $date;?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?php echo $time;?></p>
                                        </td>
                                        <td class="align-middle">
                                            <div class="ms-auto text-middle">
                                                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="Delete.php?attendanceID=<?php echo $row['id'];?>" onclick="return confirm('Are you sure?')"><i class="far fa-trash-alt me-2"></i>Delete</a>
                                            </div>
                                        </td>
                                    </tr>
<?php	}?>
                                    </tbody>
                                </table>
                                <?php

}
?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php include "footer.php";?>
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