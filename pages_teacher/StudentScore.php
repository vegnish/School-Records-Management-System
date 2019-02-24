<!DOCTYPE html>
<?php 
include("header.php");
require_once '../db_connect.php';
$id = $_GET["id"];
$firstName = $_GET["firstname"];
$lastName = $_GET["lastname"];
?>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Student Score</title>
        <link rel="stylesheet" href="../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.addons.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="shortcut icon" href="../images/favicon.png" />
        <?php
        if(isset($_POST['insert'])){
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            else{
                $scoresql = 'SELECT subjectID FROM student_subject WHERE studentID="'.$id. '"'; 
                $result = $conn->query($scoresql); 
                while($row = $result->fetch_assoc()){
                    $subjectID = $row['subjectID'];
                    $subjectScore=isset($_POST[$subjectID])?$_POST[$subjectID]:null;
                    $sql = 'UPDATE student_subject SET subject_score="'.$subjectScore.'" WHERE subjectID="'.$subjectID.'" AND studentID="'.$id.'";';
                    (mysqli_query($conn, $sql));
                }

                echo "<script> alert('Student ".$firstName." ".$lastName." Scores Added Successfully!'); location.href='StudentView.php'; </script>";
            }
        }
        if(isset($_POST['cancel'])){
            header('Location:StudentView.php');				
        }
        ?>
    </head>

    <body>
        <div class="container-scroller">
            <?php 
            include("nav.php"); 
            ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 d-flex align-items-stretch grid-margin">
                            <div class="row flex-grow">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="page-header clearfix">
                                                <h2 style="float:left">Add/Modify Student Scores - <?php echo $firstName." ".$lastName." - (".$id.")" ?></h2>				
                                            </div>
                                            </br>
                                        <form class="forms-sample" method="post">
                                            <table id="recent-orders" class="table table-hover table-xl mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="border-top-0">Subject ID</th>
                                                        <th class="border-top-0">Subject Name</th>   
                                                        <th class="border-top-0">Score</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    $scoresql = 'SELECT subjectID, subject_score FROM student_subject WHERE studentID="'.$id. '"'; 
                                                    $result = $conn->query($scoresql); 
                                                    while($row = $result->fetch_assoc()) {
                                                        $subjectID = $row['subjectID'];
                                                        $subjectScore = $row['subject_score'];

                                                        $sub_name = 'SELECT subjectName FROM subject WHERE subjectID="'.$subjectID.'"';
                                                        $sub_name_result = $conn->query($sub_name);
                                                        while($sub_name_row = $sub_name_result->fetch_assoc())
                                                            $subjectName = $sub_name_row['subjectName'];

                                                        echo 
                                                            '<tr>
                                                                <td>'.$subjectID.'</td>
                                                                <td>'.$subjectName.'</td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="number" min="0" max="100" class="form-control" name="'.$subjectID.'" value="'.$subjectScore.'" required>
                                                                    </div>
                                                                </td>
                                                            </tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <button type="submit" class="btn btn-dark mr-2" name="insert">Submit</button>
                                            <input type="button" class="btn btn-light" name="cancel" value="Cancel" onclick="window.location.href='StudentView.php'"/>
                                        </form>									
                                    </div>
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
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <script src="../vendors/js/vendor.bundle.addons.js"></script>
    <script src="../js/off-canvas.js"></script>
    <script src="../js/misc.js"></script>
    </body>
</html>