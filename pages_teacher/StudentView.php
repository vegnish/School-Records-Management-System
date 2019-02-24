<!DOCTYPE html>
<?php 
include("header.php");
require_once '../db_connect.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Student Records</title>
        <link rel="stylesheet" href="../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.addons.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="shortcut icon" href="../images/favicon.png" />
        <style>
            .icon{
                color: #e24826;
            }
            .icon:hover{
                color: #d3323a;
            }
        </style>
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
                        <div class="col-md-12 d-flex align-items-stretch grid-margin">
                            <div class="row flex-grow">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="page-header clearfix">
                                                <h2 style="float:left">Filter Student</h2>				
                                            </div>
                                            <form class="forms-sample" method="post">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Student ID" name="studentID">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Full Name" name="studentName">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <select class="form-control" name="studentGender">
                                                                <option value="">Gender</option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="No. of Records" name="count">
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-dark mr-2" name="search">Submit</button>
                                                <button class="btn btn-light" name="cancel" type="reset">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>		
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="page-header clearfix">
                                        <h2 style="float:left">Student Details</h2>
                                        <a href="StudentAdd.php" class="btn btn-dark pull-right" style="float: right">Add New Student</a>
                                    </div>
                                    <?php 
                                    $sql = "SELECT * FROM student ";
                                    $result = $conn->query($sql); 
                                    $rownum = $result->num_rows; 
                                    if (isset($_POST['search'])){ 
                                        $sql = "SELECT * FROM student "; 
                                        $where = ""; 
                                        $limit = "";
                                        if (!empty($_POST["studentID"])) 
                                            $where .= "studentID LIKE '%{$_POST["studentID"]}%' "; 
                                        if (!empty($_POST["studentName"])){ 
                                            if(!empty($where))
                                                $where .= " AND ";
                                            $where .= "firstName LIKE '%{$_POST["studentName"]}%' OR lastName LIKE '%{$_POST["studentName"]}%' "; 
                                        }
                                        if (!empty($_POST["studentGender"])){ 
                                            if(!empty($where))
                                                $where .= " AND ";
                                            $where .= "gender LIKE '%{$_POST["studentGender"]}%' "; 
                                        }
                                        if (!empty($_POST["count"])) 
                                            $limit .= "LIMIT {$_POST["count"]} "; 
                                        if (!empty($where)) {
                                            $sql .= "WHERE " . $where; 
                                        }
                                        if (!empty($limit)){
                                            $sql .= " " . $limit; 
                                        }
                                        $result = $conn->query($sql); 
                                        $rownum = $result->num_rows; 
                                    ?>
                                    <div class="table-responsive">
                                        <table id="recent-orders" class="table table-hover table-xl mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0">Student ID</th>
                                                    <th class="border-top-0">Student Name</th>   
                                                    <th class="border-top-0">Gender</th> 
                                                    <th class="border-top-0">Class</th>
                                                    <th class="border-top-0">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php								
                                        while ($row = $result->fetch_assoc())
                                        {
                                            $class_name_sql = "SELECT className FROM class WHERE classID='".$row['classID']."';";
                                            $class_name = $conn->query($class_name_sql);
                                            $class_name_row = $class_name->fetch_assoc();
                                            echo 
                                                '<tr>
															<td>'.$row['studentID'].'</td>
															<td>'.$row['firstName'].' '.$row['lastName'].'</td>
															<td>'.$row['gender'].'</td>
                                                            <td>'.$class_name_row['className'].'</td>

                                                            <td>
                                                                <a href="StudentUpdate.php?id='.$row['studentID'].'" title="Update Student" data-toggle="tooltip" class="icon"><i class="fas fa-pen"></i></a>&nbsp;
                                                                <a href="StudentScore.php?id='.$row['studentID'].'&firstname='.$row['firstName'].'&lastname='.$row['lastName'].'" title="Student Scoring" data-toggle="tooltip" class="icon"><i class="fas fa-calculator"></i></a>&nbsp;
                                                            </td>
															</tr>';
                                        }
                                        echo "<tfoot class='foot'><td colspan='6'><div id='records'>".$rownum. " records found</div></td></tfoot>";
                                                
//                                        <a href="StudentScoreUpdate.php?id='. $row['studentID'] .'" title="Student Scoring Update" data-toggle="tooltip" class="icon"><i class="fas fa-asterisk"></i></a>        
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                                    }
                    ?>
                </div>
                <?php 
                include("../footer.php"); 
                ?>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();   
            });
        </script>
        <script src="../vendors/js/vendor.bundle.base.js"></script>
        <script src="../vendors/js/vendor.bundle.addons.js"></script>
        <script src="../js/off-canvas.js"></script>
        <script src="../js/misc.js"></script>
    </body>
</html>