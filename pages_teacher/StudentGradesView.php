<!DOCTYPE html>
<?php 
include("header.php");
require_once '../db_connect.php';
$id = $_GET["id"];
$firstName = $_GET["firstname"];
$lastName = $_GET["lastname"];
$gender = $_GET["gender"];
$yearGrade = $_GET["yeargrade"];
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
                                <div class="col-5">							
                                    <div class="page-header clearfix">
                                        <h2 style="float:left">Student Details</h2>				
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-light table-xl mb-0">
                                            <tbody>
                                                <tr>
                                                    <th width="25%" class="bg-dark" style="color:white">Student ID</th>
                                                    <td width="75%"><?php echo $id; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-dark" style="color:white">Student Name</th>
                                                    <td><?php echo $firstName." ".$lastName; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-dark" style="color:white">Gender</th>
                                                    <td><?php echo $gender; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                                        <h2 style="float:left">Student Results</h2>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-xl mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0">Subject ID</th>
                                                    <th class="border-top-0">Subject Name</th>
                                                    <th class="border-top-0">Marks</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $scoresql = 'SELECT subjectID, subject_score FROM student_subject WHERE studentID="'.$id. '"'; 
                                                $result = $conn->query($scoresql); 
                                                $total_score=0;
                                                $counter=0;
                                                $selective_counter=0;
                                                $grade = '';
                                                while($row = $result->fetch_assoc()) {
                                                    $subjectID = $row['subjectID'];
                                                    $subjectScore = $row['subject_score'];
                                                    $total_score+=$subjectScore;
                                                    $counter++;
                                                    $sub_name = 'SELECT subjectName, subjectType FROM subject WHERE subjectID="'.$subjectID.'"';
                                                    $sub_name_result = $conn->query($sub_name);
                                                    while($sub_name_row = $sub_name_result->fetch_assoc()){
                                                        $subjectName = $sub_name_row['subjectName'];
                                                        $subjectType = $sub_name_row['subjectType'];
                                                    }

                                                    if($grade != 'F'){
                                                        if($yearGrade == 'Lower'){
                                                            if($subjectScore < 60)
                                                                $grade = 'F';
                                                        }
                                                        else if($yearGrade == 'UpperScience'){
                                                            if($subjectType=='Core' && $subjectScore < 60)
                                                                $grade = 'F';
                                                            if($subjectType=='Selective'){
                                                                if($subjectScore < 60)
                                                                    $selective_counter++;
                                                            }
                                                            if($selective_counter == 2)
                                                                $grade = 'F';
                                                        }
                                                        else if($yearGrade == 'UpperArt'){
                                                            if($subjectType=='Core' && $subjectScore < 60)
                                                                $grade = 'F';
                                                            if($subjectType=='Selective'){
                                                                if($subjectScore < 60)
                                                                    $selective_counter++;
                                                            }
                                                            if($selective_counter == 3)
                                                                $grade = 'F';
                                                        }
                                                    }

                                                    echo 
                                                        '<tr>
                                                                <td>'.$subjectID.'</td>
                                                                <td>'.$subjectName.'</td>
                                                                <td>'.$subjectScore.'</td>
                                                            </tr>';
                                                }
                                                $average_score = $total_score/$counter;
                                                if($grade != 'F'){
                                                    if($average_score>=90 && $average_score<=100)
                                                        $grade = 'A';
                                                    else if($average_score>=80 && $average_score<=89)
                                                        $grade = 'B';
                                                    else if($average_score>=70 && $average_score<=79)
                                                        $grade = 'C';
                                                    else if($average_score>=60 && $average_score<=69)
                                                        $grade = 'D';
                                                    else if($average_score<60)
                                                        $grade = 'F';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 d-flex align-items-stretch grid-margin">
                            <div class="row flex-grow">
                                <div class="col-5">							
                                    <div class="page-header clearfix">
                                        <h2 style="float:left">Student Final Grade</h2>				
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-light table-xl mb-0">
                                            <tbody>
                                                <tr>
                                                    <th width="25%" class="bg-dark" style="color:white">Final Grade</th>
                                                    <td width="75%" style="font-size:25px;"><b><?php echo $grade; ?></b></td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-dark" style="color:white">Average Score</th>
                                                    <td><?php echo (round($average_score,2)); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


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