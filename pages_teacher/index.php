<!DOCTYPE html>
<?php
include("header.php");
require_once '../db_connect.php';
?>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Taylor's School Management System</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.addons.css">
        <!-- endinject -->
        <!-- plugin css for this page -->
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="../css/style.css">
        <!-- endinject -->
        <link rel="shortcut icon" href="../images/favicon.png" />
        <?php
        $result = $conn->query('SELECT COUNT(subjectID) FROM subject;'); 
        $row = $result->fetch_assoc();
        $num_of_subjects = $row['COUNT(subjectID)'];
        $result = $conn->query('SELECT COUNT(classID) FROM class;'); 
        $row = $result->fetch_assoc();
        $num_of_class = $row['COUNT(classID)'];
        $result = $conn->query('SELECT COUNT(studentID) FROM student;'); 
        $row = $result->fetch_assoc();
        $num_of_student = $row['COUNT(studentID)'];

        $result = $conn->query('SELECT subjectID FROM subject;'); 
        $subjectIDarr = array();
        while($row = $result->fetch_assoc())
            array_push($subjectIDarr, $row['subjectID']);
        ?>
    </head>

    <body>
        <div class="container-scroller">
            <?php 
            include("nav.php"); 
            ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <i class="mdi mdi-book text-danger icon-lg"></i>
                                        </div>
                                        <div class="float-right">
                                            <p class="mb-0 text-right">Total Subjects</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0"><?php echo $num_of_subjects; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <i class="mdi mdi-bulletin-board text-warning icon-lg"></i>
                                        </div>
                                        <div class="float-right">
                                            <p class="mb-0 text-right">Total Classes</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0"><?php echo $num_of_class; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <i class="mdi mdi-face text-info icon-lg"></i>
                                        </div>
                                        <div class="float-right">
                                            <p class="mb-0 text-right">Total Students</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0"><?php echo $num_of_student; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h3 style="float:left">Top Scorers by Subjects</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                    <th>
                                                        Subject Name
                                                    </th>
                                                    <th>
                                                        Score
                                                    </th>
                                                    <th>
                                                        Student Name
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $counter=0;

                                                $sql = 'select s1.*
                                                        from student_subject s1
                                                        left outer join student_subject s2
                                                        on (s1.subjectID = s2.subjectID and s1.subject_score < s2.subject_score)
                                                        where s2.subjectID is null
                                                        group by subjectID';

                                                $result = $conn->query($sql); 

                                                while($row = $result->fetch_assoc()){
                                                    $counter++;


                                                    $score = $row['subject_score'];
                                                    $studentID = $row['studentID'];
                                                    $subjectID = $row['subjectID'];

                                                    $namesql = 'SELECT subjectName FROM subject WHERE subjectID="'.$subjectID.'";';
                                                    $res = $conn->query($namesql);
                                                    $row = $res->fetch_assoc();
                                                    $subjectName = $row['subjectName'];

                                                    $namesql = 'SELECT firstName, lastName FROM student WHERE studentID="'.$studentID.'";';
                                                    $res = $conn->query($namesql);
                                                    $row = $res->fetch_assoc();
                                                    $studentName = $row['firstName']." ".$row['lastName'];

                                                    echo '<tr>
                                                            <td class="font-weight-medium">
                                                                '.$counter.'
                                                            </td>
                                                            <td><b>
                                                                '.$subjectName.'
                                                            </b></td>
                                                            <td>
                                                                '.$score.'
                                                            </td>
                                                            <td>
                                                                '.$studentName.'
                                                            </td>
                                                        </tr>';
                                                }

                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <?php 
                include("../footer.php"); 
                ?>
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
        </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <script src="../vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="../js/off-canvas.js"></script>
    <script src="../js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="../js/dashboard.js"></script>
    <!-- End custom js for this page-->
    </body>

</html>