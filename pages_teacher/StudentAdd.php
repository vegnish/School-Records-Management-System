<!DOCTYPE html>
<?php 
include("header.php");
require_once '../db_connect.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Add Student</title>
        <link rel="stylesheet" href="../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.addons.css">
        <link rel="stylesheet" href="../vendors/icheck/skins/all.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="shortcut icon" href="../images/favicon.png" />
        <?php
        if(isset($_POST['insert'])){
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            else{
                $studentFirstName=isset($_POST['studentFirstName'])?$_POST['studentFirstName']:null;
                $studentLastName=isset($_POST['studentLastName'])?$_POST['studentLastName']:null;
                $studentGender=isset($_POST['studentGender'])?$_POST['studentGender']:null;

                $sql = "INSERT INTO student(firstName, lastName, gender) VALUES ('$studentFirstName', '$studentLastName', '$studentGender');";
                if (mysqli_query($conn, $sql)) {
                    echo "<script> alert('".$studentFirstName." ".$studentLastName." Student Added Successfully!'); location.href='StudentView.php'; </script>";
                } 
                else {
                    echo "Error: ". mysqli_error($conn);
                }	
            }
        }
        if(isset($_POST['cancel'])){
            header('Location:StudentView.php');				
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
                                                <h2 style="float:left">Add Student</h2>				
                                            </div>
                                            <form class="forms-sample" method="post">
                                                <div class="form-group">
                                                    <br/>
                                                    <label for="studentFirstName">Student First Name</label>
                                                    <input type="text" class="form-control" placeholder="" name="studentFirstName" id="studentFirstName" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="studentLastName">Student Last Name</label>
                                                    <input type="text" class="form-control" placeholder="" name="studentLastName" id="studentLastName" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <select class="form-control" name="studentGender" required>
                                                        <option value="" selected disabled hidden>Select One</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
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
        </div>
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <script src="../vendors/js/vendor.bundle.addons.js"></script>
    <script src="../js/off-canvas.js"></script>
    <script src="../js/misc.js"></script>
    </body>

</html>