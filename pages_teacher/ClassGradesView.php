<!DOCTYPE html>
<?php 
include("header.php");
require_once '../db_connect.php';
$id = $_GET["id"];
$className = $_GET["classname"];
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Class Records</title>
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
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="page-header clearfix">
                                        <h2 style="float:left">Class Scores - <?php echo $className; ?></h2> <!--Put class name instead of name-->
                                    </div>
                                    <div class="table-responsive">
                                        <table id="recent-orders" class="table table-hover table-xl mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0">Student Name</th>
                                                    <?php
                                                    $studentsql = 'SELECT subject.subjectName 
                                                                    FROM class 
                                                                    INNER JOIN student ON class.classID = student.classID
                                                                    INNER JOIN student_subject ON student.studentID = student_subject.studentID
                                                                    INNER JOIN subject ON student_subject.subjectID = subject.subjectID
                                                                    WHERE class.classID="'.$id.'";';

                                                    $result = $conn->query($studentsql);

                                                    $firstSubject = '';
                                                    while ($row = $result->fetch_assoc()){
                                                        if($row['subjectName'] == $firstSubject)
                                                            break;
                                                        if($firstSubject == '')
                                                            $firstSubject = $row['subjectName'];
                                                        
                                                        echo '<th class="border-top-0">'.$row['subjectName'].'</th>';
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $studentsql = 'SELECT subject.subjectName, student.firstName, student.lastName, student_subject.subject_score  
                                                                    FROM class 
                                                                    INNER JOIN student ON class.classID = student.classID
                                                                    INNER JOIN student_subject ON student.studentID = student_subject.studentID
                                                                    INNER JOIN subject ON student_subject.subjectID = subject.subjectID
                                                                    WHERE class.classID="'.$id.'";';

                                                $result = $conn->query($studentsql);
                                                $studentName = '';
                                                $counter = 0;
                                                while ($row = $result->fetch_assoc()){
                                                    if($studentName != $row['firstName']." ".$row['lastName']){
                                                        $studentName = $row['firstName']." ".$row['lastName'];
                                                        if($counter != 0)
                                                            echo '</tr>';
                                                        $counter++;
                                                        echo '<tr>
                                                                <td>'.$studentName.'</td>';
                                                        echo '<td>'.$row['subject_score'].'</td>';
                                                    }
                                                    else{
                                                        echo '<td>'.$row['subject_score'].'</td>';
                                                    }
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