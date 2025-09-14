<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    
    session_start();
    include('../includes/dbconn.php');
    include('../includes/check-login.php');
    check_login();

    if(isset($_POST['submit'])){
        $roomno = $_POST['roomno'];
        $seater = $_POST['seater'];
        $stayfrom = $_POST['stayfrom'];
        $duration = $_POST['duration'];
        $course = $_POST['course'];
        $regno = $_POST['regno'];
        $firstName = $_POST['firstName'];
        $middleName = $_POST['middleName'];
        $lastName = $_POST['lastName'];
        $gender = $_POST['gender'];
        $contactno = $_POST['contactno'] ?? null;
	$emailid = $_POST['emailid'] ?? null;
	$egycontactno = $_POST['egycontactno'] ?? null;
	$guardianName = $_POST['guardianName'] ?? null;
	$guardianRelation = $_POST['guardianRelation'] ?? null;
	$guardianContactno = $_POST['guardianContactno'] ?? null;
	$corresAddress = $_POST['corresAddress'] ?? null;
	$corresCity = $_POST['corresCity'] ?? null;
	$corresState = $_POST['corresState'] ?? null;
	$corresPincode = $_POST['corresPincode'] ?? null;


        $sql="SELECT regno FROM registration WHERE regno=?";
        $stmt1 = $mysqli->prepare($sql);
        $stmt1->bind_param('s', $regno);
        $stmt1->execute();
        $stmt1->store_result();
        $row_cnt = $stmt1->num_rows;
        
        if($row_cnt > 0){
            echo "<script>alert('Student already exists!');</script>";
        } else {
            $query = "INSERT INTO registration (roomno, seater, stayfrom, duration, course, regno, firstName, middleName, lastName, gender, contactno, emailid, egycontactno, guardianName, guardianRelation, guardianContactno, corresAddress, corresCity, corresState, corresPincode) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            
            if($stmt === false){
               die("Error in SQL query: " . $mysqli->error);
            }
            
            $stmt->bind_param('sisissssssisississsi', $roomno, $seater, $stayfrom, $duration, $course, $regno, $firstName, $middleName, $lastName, $gender, $contactno, $emailid, $egycontactno, $guardianName, $guardianRelation, $guardianContactno, $corresAddress, $corresCity, $corresState, $corresPincode);
            
            $stmt->execute();
            echo "<script>alert('Student has been added');</script>";
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Vinodini Hostel Management System</title>
    
    <!-- Custom CSS -->
    <link href="../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet">
    
</head>
<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <?php include 'includes/navigation.php'?>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <?php include 'includes/sidebar.php'?>
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                    <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Add Student</h4>
                        <div class="d-flex align-items-center">
                            <!-- <nav aria-label="breadcrumb">
                                
                            </nav> -->
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <?php if(isset($_POST['submit']))
            { ?>
           
            <?php } ?>
            
            <div class="container-fluid">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Room Number</label>
                            <input type="text" name="roomno" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Seater</label>
                            <input type="number" name="seater" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Stay From</label>
                            <input type="date" name="stayfrom" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Duration (months)</label>
                            <input type="number" name="duration" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Course</label>
                            <input type="text" name="course" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Registration Number</label>
                            <input type="text" name="regno" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>First Name</label>
                            <input type="text" name="firstName" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Middle Name</label>
                            <input type="text" name="middleName" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Last Name</label>
                            <input type="text" name="lastName" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Gender</label>
                            <select name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="Female">Female</option>
                                <option value="Others">Others</option>
                                
                            </select>
                        </div>
                    </div>
                    
                    
                       
                       
                       <div class="form-actions mt-4">
                            <div class="text-center">
                                <button type="submit" name="submit" class="btn btn-success">Insert</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                       
                </form>
            </div>
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="../dist/js/app-style-switcher.js"></script>
    <script src="../dist/js/feather.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <script src="../assets/extra-libs/c3/d3.min.js"></script>
    <script src="../assets/extra-libs/c3/c3.min.js"></script>
    <script src="../assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="../dist/js/pages/dashboards/dashboard1.min.js"></script>
</body>
</html>

