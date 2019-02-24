<!DOCTYPE html>
<?php 
include("header.php");
require_once '../db_connect.php';
$id = $_GET["id"];
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
                                                <h2 style="float:left">Update Student - <?php echo $id; ?></h2>				
                                            </div>
                                            <form class="forms-sample" method="post">
                                                <?php
                                                $namesql = 'SELECT * FROM student WHERE studentID="'.$id. '"'; 
                                                $result = $conn->query($namesql); 
                                                while($row = $result->fetch_assoc()) {
                                                    $firstName = $row['firstName'];
                                                    $lastName = $row['lastName'];
                                                    $gender = $row['gender'];
                                                    $classID = $row['classID'];
                                                }
                                                ?>

                                                <div class="form-group">
                                                    <br/>
                                                    <label for="studentFirstName">Student First Name</label>
                                                    <input type="text" class="form-control" placeholder="" name="studentFirstName" id="studentFirstName" value="<?php echo $firstName; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="studentLastName">Student Last Name</label>
                                                    <input type="text" class="form-control" placeholder="" name="studentLastName" id="studentLastName" value="<?php echo $lastName; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <select class="form-control" name="studentGender">
                                                        <?php
                                                        $arr = array('Male','Female');
                                                        foreach($arr as $value){
                                                            if($gender == $value)
                                                                echo '<option value="'.$value.'" selected>'.$value.'</option>';
                                                            else
                                                                echo '<option value="'.$value.'">'.$value.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>	
                                                <div class="form-group">
                                                    <label>Class Name</label>
                                                    <select class="form-control" name="className">
                                                        <?php
                                                        $classSql = 'SELECT classID, className FROM class'; 
                                                        $result = $conn->query($classSql); 
                                                        while($row = $result->fetch_assoc()) {
                                                            $className = $row['className'];
                                                            if($classID == $row['classID']){
                                                                echo '<option value="'.$className.'" selected>'.$className.'</option>';
                                                                $classNameOld = $className;
                                                            }
                                                            else
                                                                echo '<option value="'.$className.'">'.$className.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>			
                                                <button type="submit" class="btn btn-dark mr-2" name="update">Update</button>
                                                <button class="btn btn-light" name="Delete">Delete</button>		
                                                <?php 
                                                if (isset($_POST['update'])){ 
                                                    $studentFirstName = trim($_POST['studentFirstName']);
                                                    $studentLastName = trim($_POST['studentLastName']);
                                                    $studentGender = trim($_POST['studentGender']);
                                                    $className = trim($_POST['className']);

                                                    $studentFirstName = str_replace( "'", "'", $studentFirstName); 
                                                    $studentLastName = str_replace( "'", "'", $studentLastName); 
                                                    $studentGender = str_replace( "'", "'", $studentGender); 
                                                    $className = str_replace( "'", "'", $className); 

                                                    //If Class Is Updated
                                                    if($classNameOld != $className){
                                                        $class_detail_sql = "SELECT classID, yearGrade FROM class WHERE className='".$className."';";
                                                        $class_detail = $conn->query($class_detail_sql);
                                                        $class_detail_row = $class_detail->fetch_assoc();

                                                        $classID = $class_detail_row['classID'];
                                                        $yearGrade = $class_detail_row['yearGrade'];

                                                        $deletesql = 'DELETE FROM student_subject WHERE studentID="'.$id.'";';
                                                        if (mysqli_query($conn, $deletesql)){
                                                            $sql = 'UPDATE student SET
                                                                    firstName = "'.$studentFirstName.'",
                                                                    lastName = "'.$studentLastName.'",
                                                                    gender = "'.$studentGender.'",
                                                                    classID = "'.$classID.'"
                                                                    WHERE studentID ="'.$id.'";';
                                                            if(mysqli_query($conn, $sql)){
                                                                $core_subject = $conn->query("SELECT subjectID FROM subject WHERE subjectType='Core';");
                                                                while($core_subject_row = $core_subject->fetch_assoc()){
                                                                    $sub_id = $core_subject_row['subjectID'];
                                                                    $sql = "INSERT INTO student_subject(studentID, subjectID) VALUES ('$id', '$sub_id');";
                                                                    (mysqli_query($conn, $sql));
                                                                }
                                                                if($yearGrade != 'Core'){
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
                                                            }
                                                            echo "<script> alert('Student ".$studentFirstName." ".$studentLastName." Record Updated Successfully!'); location.href='StudentView.php'; </script>";
                                                        }
                                                    }

                                                    //If Class is NOT Updated
                                                    else{
                                                        $sql = 'UPDATE student SET
                                                                firstName = "'.$studentFirstName.'",
                                                                lastName = "'.$studentLastName.'",
                                                                gender = "'.$studentGender.'"
                                                                WHERE studentID ="'.$id.'";';

                                                        if ($result = $conn->query($sql)) {
                                                            $scMSG = "Updated successfully";
                                                            echo "<script> alert('Student ".$studentFirstName." ".$studentLastName." Record Updated Successfully!'); location.href='StudentView.php'; </script>";
                                                        } 
                                                        else {
                                                            $errMSG = mysqli_error($conn);
                                                        }
                                                    }
                                                }

                                                if (isset($_POST['Delete'])){ 
                                                    $dsql = 'DELETE FROM student WHERE studentID = "'.$id. '"'; 
                                                    $namesql = 'SELECT firstName, lastName FROM student WHERE studentID="'.$id. '"'; 
                                                    $result = $conn->query($namesql); 
                                                    while($row = $result->fetch_assoc()) {
                                                        $firstName = $row['firstName'];
                                                        $lastName = $row['lastName'];
                                                    }
                                                    if ($result = $conn->query($dsql)) {
                                                        $scMSG = "Deleted successfully";
                                                        echo "<script> alert('Student ".$firstName." ".$lastName." Record Deleted Successfully!'); location.href='StudentView.php'; </script>";
                                                    } 
                                                    else {
                                                        $errMSG = mysqli_error($conn);
                                                    }	
                                                }
                                                echo '<br/><br/>';

                                                if (isset($errMSG)) {
                                                ?>
                                                <div class="form-group">
                                                    <div class="alert alert-danger alert-icon-left alert-arrow-left alert-info mb-2" role="alert">
                                                        <span class="alert-icon"><i class="fas fa-info"></i></span> <?php echo $errMSG; ?>
                                                    </div>
                                                </div>
                                                <?php
                                                }

                                                if (isset($scMSG)) {

                                                ?>
                                                <div class="form-group">
                                                    <div class="alert alert-success alert-icon-left alert-arrow-left alert-info mb-2" role="alert">
                                                        <span class="alert-icon"><i class="fas fa-info"></i></span> <?php echo $scMSG; ?>
                                                    </div>
                                                </div>
                                                <?php
                                                }
                                                ?>
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