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
        <title>Update Student Records</title>
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
                $className=isset($_POST['className'])?$_POST['className']:null;

                $class_detail_sql = "SELECT classID, yearGrade FROM class WHERE className='".$className."';";
                $class_detail = $conn->query($class_detail_sql);
                $class_detail_row = $class_detail->fetch_assoc();

                $classID = $class_detail_row['classID'];
                $yearGrade = $class_detail_row['yearGrade'];

                //                $sql = 'UPDATE student SET classID=(SELECT classID FROM class WHERE className="'.$className.'") WHERE studentID ="'.$id.'";';
                $sql = 'UPDATE student SET classID="'.$classID.'" WHERE studentID ="'.$id.'";';
                if (mysqli_query($conn, $sql)) {
                    $core_subject = $conn->query("SELECT subjectID FROM subject WHERE subjectType='Core';");
                    while($core_subject_row = $core_subject->fetch_assoc()){
                        $sub_id = $core_subject_row['subjectID'];
                        $sql = "INSERT INTO student_subject(studentID, subjectID) VALUES ('$id', '$sub_id');";
                        (mysqli_query($conn, $sql));
                    }
                    if($yearGrade != 'Lower'){
                        $selective_subject = $conn->query("SELECT subjectID, subjectName FROM subject WHERE subjectType='Selective';");
                        while($selective_subject_row = $selective_subject->fetch_assoc()){
                            if($yearGrade == 'UpperScience'){
                                if($selective_subject_row['subjectName'] == 'Biology' || $selective_subject_row['subjectName'] == 'Chemistry' || $selective_subject_row['subjectName'] == 'Physics'){
                                    $sub_id = $selective_subject_row['subjectID'];
                                    $sql = "INSERT INTO student_subject(studentID, subjectID) VALUES ('$id', '$sub_id');";
                                    (mysqli_query($conn, $sql));        
                                }
                            }
                            if($yearGrade == 'UpperArt'){
                                if($selective_subject_row['subjectName'] == 'Art' || $selective_subject_row['subjectName'] == 'Commerce' || $selective_subject_row['subjectName'] == 'Economics'){
                                    $sub_id = $selective_subject_row['subjectID'];
                                    $sql = "INSERT INTO student_subject(studentID, subjectID) VALUES ('$id', '$sub_id');";
                                    (mysqli_query($conn, $sql));        
                                }
                            }
                        }
                    }

                    echo "<script> alert('Student ".$firstName." ".$lastName." Registered to Class ".$className." Successfully!'); location.href='StudentView.php'; </script>";
                } 
                else {
                    echo "Error: ". mysqli_error($conn);
                }
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
                                                <h2 style="float:left">Register Student - <?php echo $firstName." ".$lastName." - (".$id.")" ?></h2>				
                                            </div>
                                            <br/>
                                            <form class="forms-sample" method="post">
                                                <div class="form-group">
                                                    <label>Class Name</label>
                                                    <select class="form-control" name="className">
                                                        <option value="" selected disabled hidden>Select One</option>
                                                        <?php
    $all_class = 'SELECT className FROM class;'; 
                                                    $result = $conn->query($all_class);
                                                    while($row = $result->fetch_assoc()) {	
                                                        echo '<option value="'.$row['className'].'">'.$row['className'].'</option>';
                                                    }
                                                        ?>
                                                    </select>
                                                </div>	


                                                <!--
<div class="form-group">
<label>Pick Subject</label>
<div class="form-check form-check-flat">
<label class="form-check-label">
<input type="checkbox" class="form-check-input"> English
</label>
</div>
<div class="form-check form-check-flat">
<label class="form-check-label">
<input type="checkbox" class="form-check-input"> Math
</label>
</div>
</div>	
-->


                                                <br/>												
                                                <button type="submit" class="btn btn-dark mr-2" name="insert">Submit</button>
                                                <button class="btn btn-light" name="Delete">Delete</button>	
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