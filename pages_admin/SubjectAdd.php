<!DOCTYPE html>
<?php 
include("header.php");
require_once '../db_connect.php';
?>
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
        <?php
        if(isset($_POST['insert'])){
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            else{
                $subjectID=isset($_POST['subjectID'])?$_POST['subjectID']:null;
                $subjectName=isset($_POST['subjectName'])?$_POST['subjectName']:null;
                $subjectType=isset($_POST['subjectType'])?$_POST['subjectType']:null;

                // check if subjectID already exists in database
                $stmt = $conn->prepare("SELECT subjectID FROM subject WHERE subjectID=?");
                $stmt->bind_param("s", $subjectID);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                $count = $result->num_rows;

                if($count==0){ // if subjectID does not exist	
                    $sql = "INSERT INTO subject(subjectID, subjectName, subjectType) VALUES ('$subjectID',     '$subjectName',     '$subjectType');";
                    if (mysqli_query($conn, $sql)) {
//                        echo $bname." added to table successfully";
                        echo "<script> alert('".$subjectName." Subject Added Successfully!'); location.href='SubjectView.php'; </script>";
                    } 
                    else {
                        echo "Error: ". mysqli_error($conn);
                    }	
//                    header('Location:SubjectView.php');				
                }
                else { // if subjectID already exists
                    $errMSG = "Subject ID already exists!";
//                    echo "<script> alert('Subject ID Already Exists. Please try again!'); location.href='SubjectAdd.php'; </script>";
                }
            }
        }
        if(isset($_POST['cancel'])){
            header('Location:SubjectView.php');				
        }
        mysqli_close($conn);
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
                                                <h2 style="float:left">Add Subject</h2>				
                                            </div>
                                            <form class="forms-sample" method="post">
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
                                                    <label for="exampleInputEmail1">Subject ID</label>
                                                    <input type="text" class="form-control" placeholder="" name="subjectID" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Subject Name</label>
                                                    <input type="text" class="form-control" placeholder="" name="subjectName" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Subject Type</label>
                                                    <select class="form-control" name="subjectType" required>
                                                        <option value="Core">Core</option>
                                                        <option value="Selective">Selective</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-dark mr-2" name="insert">Submit</button>
                                                <button class="btn btn-light" name="cancel">Cancel</button>
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
        </div>
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <script src="../vendors/js/vendor.bundle.addons.js"></script>
    <script src="../js/off-canvas.js"></script>
    <script src="../js/misc.js"></script>
    </body>

</html>