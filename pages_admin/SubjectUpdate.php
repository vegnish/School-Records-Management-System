<?php 
include("header.php");
require_once '../db_connect.php';
$id = $_GET["id"];
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Add Subject</title>
        <link rel="stylesheet" href="../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.addons.css">
        <link rel="stylesheet" href="../vendors/icheck/skins/all.css">
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
                                                <h2 style="float:left">Update Subject</h2>				
                                            </div>
                                            <form class="forms-sample" method="post" action="#">
                                                <?php
                                                if (isset($errMSG)) {
                                                ?>
                                                <div class="form-group">
                                                    <div class="alert alert-danger alert-icon-left alert-arrow-left alert-info mb-2" role="alert">
                                                        <span class="alert-icon"><i class="fas fa-info"></i></span> <?php echo $errMSG; ?>
                                                    </div>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                                <div class="form-group">
                                                    <br/>
                                                    <label for="subjectID">Subject ID</label>
                                                    <input type="text" class="form-control" placeholder="" name="subjectID" id="subjectID" value="<?php echo $id; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="subjectName">Subject Name</label>
                                                    <input type="text" class="form-control" placeholder="" name="subjectName" id="subjectName" value="<?php $namesql = 'SELECT subjectName FROM subject WHERE subjectID="'.$id. '"'; 
                                                           $result = $conn->query($namesql); 
                                                           while($row = $result->fetch_assoc()) {echo $row['subjectName'];}?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Subject Type</label>
                                                    <?php 
                                                    $typesql = 'SELECT subjectType FROM subject WHERE subjectID="'.$id. '"'; 
                                                    $result = $conn->query($typesql); 
                                                    while($row = $result->fetch_assoc()) {									
                                                        if($row['subjectType']=='Core'){
                                                            echo '<select name="subjectType" class="form-control">';
                                                            echo '<option value="Core" selected>Core</option>';
                                                            echo '<option value="Selective">Selective</option></select>';
                                                        }
                                                        else{
                                                            echo '<select name="subjectType" class="form-control">';
                                                            echo '<option value="Core">Core</option>';
                                                            echo '<option value="Selective" selected>Selective</option></select>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <button type="submit" class="btn btn-dark mr-2" name="Update">Update</button>
                                                <button class="btn btn-light" name="Delete">Delete</button>
                                                <?php 
                                                if (isset($_POST['Update'])){ 
                                                    $subjectID = trim($_POST['subjectID']);
                                                    $subjectName = trim($_POST['subjectName']);
                                                    $subjectType = trim($_POST['subjectType']);

                                                    $subjectID = str_replace( "'", "'", $subjectID); 
                                                    $subjectName = str_replace( "'", "'", $subjectName); 
                                                    $subjectType = str_replace( "'", "'", $subjectType); 

                                                    $sql = 'UPDATE subject SET
														subjectID = "'.$subjectID.'",
														subjectName = "'.$subjectName.'",
														subjectType = "'.$subjectType.'"
														WHERE subjectID ="'.$id.'";';

                                                    if ($result = $conn->query($sql)) {
                                                        $scMSG = "Updated successfully";
                                                        echo "<script> alert('Subject Updated Successfully!'); location.href='SubjectView.php'; </script>";
                                                    } 
                                                    else {
                                                        $errMSG = mysqli_error($conn);
                                                    }	
                                                }
                                                if (isset($_POST['Delete'])){ 
                                                    $dsql = 'DELETE FROM subject WHERE subjectID = "'.$id. '"'; 
                                                    if ($result = $conn->query($dsql)) {
                                                        $scMSG = "Deleted successfully";
                                                        echo "<script> alert('Subject Deleted Successfully!'); location.href='SubjectView.php'; </script>";
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