<?php $navName = pathinfo(basename($_SERVER['PHP_SELF']), PATHINFO_FILENAME);?>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?php echo $navName;?></li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0"><?php echo $navName;?></h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <ul class="navbar-nav  justify-content-end">
                    <?php	$link = "http://".$ip.":5000/attendance";?>
                    <li class="nav-item d-flex align-items-center">
                    <a href="<?php echo $link;?>" class="nav-link text-white font-weight-bold px-0">
                        <i class="fa fa-calendar-check-o me-sm-1"></i>
                        <span class="d-sm-inline d-none">Take Log Entries</span>
                    </a>
                    </li>
                </ul>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="../Auth/Logout.php" class="nav-link text-white font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">Logout</span>
                    </a>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->