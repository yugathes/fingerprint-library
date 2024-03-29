<?php
//call this function to check if session exists or not
session_start();
global $link;
//if session exists
if(isset ($_SESSION["userId"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";
    if(isset($_GET['errorFlask'])){
        $errorServer = $_GET['errorFlask'];
        if($errorServer==1)
            $error = "Imaging error";
        if($errorServer==2)
            $error = "Other error";
        if($errorServer==3)
            $error = "Image too messy";
        if($errorServer==4)
            $error = "Could not identify features";
        if($errorServer==5)
            $error = "Image invalid";
        if($errorServer==6)
            $error = "Other error";
        if($errorServer==7)
            $error = "Prints did not match";
        if($errorServer==8)
            $error = "Bad storage location";
        if($errorServer==9)
            $error = "Flash storage error";

        echo '<script type="text/javascript">
	window.onload = function () 
	{ 
	alert("'.$error.'");
	open("Profile.php","_top");
	}
	</script>';
    }
    if (isset($_SESSION['notification'])) {
        $notification = $_SESSION['notification'];
        unset($_SESSION['notification']); // Clear the notification after displaying it
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <body class="g-sidenav-show dark-version bg-gray-100">

    <main class="main-content position-relative border-radius-lg ">
        <?php include "navbar.php";?>
        <div class="container-fluid py-4">
            <?php if (isset($notification)): ?>
                <div class="alert alert-success alert-dismissible fade show ml-auto alert-sm" role="alert">
                    <?php echo $notification; ?>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
<?php
//	$pID = $_GET["id"];
$lin = mysqli_connect('localhost', 'root', 'sudo', 'library');
	$queryGet = "select * from users where id='".$_SESSION["userId"]."'";

$resultGet = mysqli_query($lin, $queryGet);

	if(!$resultGet)
	{
        die ("Invalid Query - get Register List: " . mysqli_error($lin));
	}
	else
	{?>
                            <h6>User Info</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">User Information</p>
                            <form action="StudentUpdate.php" name="EditForm" method="POST">
                            <?php	while($baris= mysqli_fetch_array($resultGet, MYSQLI_BOTH))	{?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Name</label>
                                        <input class="form-control" type="text" name="name" value="<?php echo $baris['name']; ?>">
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $baris['id']; ?>">
                                <input type="hidden" name="redirect" value="profile">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email" value="<?php echo $baris['email'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Staff/Student ID</label>
                                        <input class="form-control" type="text" name="student_id" value="<?php echo $baris['local_id'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Password</label>
                                        <div class="input-group" style="background-color: white;">
                                            <input class="form-control" type="text" name="password" id="password"
                                                   value="<?php echo $baris['password'] ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" style="height:100%;border: 0;"
                                                        type="button" id="togglePassword">
                                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Maintenance</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Fingerprint Enrollment</label>
                                        <?php if($baris['fingerprint']==0) {?>
                                            <?php	$link = "http://".$ip.":5000/enroll?uid=".$baris['id'];?>
                                           <a class="form-control btn btn-primary btn-sm ms-auto text-uppercase text-lg" href="<?php echo $link;?>">
                                                    Enroll
                                            </a><?php	}
                                         else if($baris['fingerprint']==1){	?>
                                            <input class="form-control text-uppercase text-lg-center text-success font-weight-bold" type="text" name="enrollment" value="Enrolled" >
                                        <?php	}	else{}?>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal light">
                            <div class="row">
                                <button type="submit" class="btn btn-primary btn-lg ms-auto" name="profile">Update</button>
                            </div>

                            <?php	}?>
                            </form>
                        </div>
                        <?php
}?>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#togglePassword').on('click', function () {
                    const passwordInput = $('#password');
                    const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                    passwordInput.attr('type', type);

                    // Toggle eye icon
                    const eyeIcon = $('#togglePassword i');
                    eyeIcon.toggleClass('fa-eye-slash');
                    eyeIcon.toggleClass('fa-eye');
                });
            });
        </script>
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