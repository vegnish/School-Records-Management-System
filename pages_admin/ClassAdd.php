<!DOCTYPE html>
<?php 
include("header.php");
require_once '../db_connect.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Add Class</title>
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
                $classID=isset($_POST['classID'])?$_POST['classID']:null;
                $className=isset($_POST['className'])?$_POST['className']:null;
                $grade=isset($_POST['grade'])?$_POST['grade']:null;
                $form=isset($_POST['form'])?$_POST['form']:null;

                // check if classID already exists in database
                $stmt = $conn->prepare("SELECT classID FROM class WHERE classID=?");
                $stmt->bind_param("s", $classID);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                $count = $result->num_rows;

                if($count==0){ // if classID does not exist	
                    $err = true;
                    
                    if($form == 4 || $form == 5){
                        if($grade == 'Lower'){
                            echo "<script> alert('Invalid Combination Entered for Year Grade and Year Formabc! Please try again'); location.href='ClassAdd.php'; </script>";
                            $err = false;
                        }
                    }
                    else if($form == 1 || $form == 2 || $form == 3){
                        if($grade == 'UpperScience' || $grade == 'UpperArt' ){
                            echo "<script> alert('Invalid Combination Entered for Year Grade and Year Form! Please try again'); location.href='ClassAdd.php'; </script>";
                            $err = false;
                        }
                    }

                    if($err){
                        $sql = "INSERT INTO class(classID, className, yearGrade, yearForm) VALUES ('$classID', '$className', '$grade', '$form');";
                        if (mysqli_query($conn, $sql)) {
                            //                        echo $bname." added to table successfully";
                            echo "<script> alert('".$className." Class Added Successfully!'); location.href='ClassView.php'; </script>";
                        } 
                        else {
                            echo "Error: ". mysqli_error($conn);
                        }	
                    }
                }
                else { // if classsID already exists
                    $errMSG = "Class ID already exists!";
                    //                    echo "<script> alert('Class ID Already Exists. Please try again!'); location.href='ClassAdd.php'; </script>";
                }
            }
        }
        if(isset($_POST['cancel'])){
            header('Location:ClassView.php');				
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
                                                <h2 style="float:left">Add Class</h2>				
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
                                                    <label for="exampleInputEmail1">Class ID</label>
                                                    <input type="text" class="form-control" placeholder="" name="classID" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Class Name</label>
                                                    <input type="text" class="form-control" placeholder="" name="className" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Year Grade <span class="badge badge-dark" data-toggle="tooltip" data-placement="right" title="Lower Secondary (Form 1-3) &#013; Upper Secondary (Form 4-5)">?</span></label>
                                                    <select class="form-control" id="grade" name="grade" required>
                                                        <option value="" selected disabled hidden>Select One</option>
                                                        <option value="Lower">Lower Secondary</option>
                                                        <option value="UpperScience">Upper Secondary Science</option>
                                                        <option value="UpperArt">Upper Secondary Art</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Year Form</label>
                                                    <select class="form-control" id="form" onchange="updateText('form')" name="form" required>
                                                        <option value="" selected disabled hidden>Select One</option>
                                                        <option value="1" data-temp="Lower">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                                <script>
                                                    var controllerTypeFunctions = {
                                                        Default:function(){
                                                            $('#form option').prop('disabled',false);   
                                                        },
                                                        Lower: function(){
                                                            $('#form option').filter(function(){
                                                                return this.value == "4" || this.value == "5"
                                                            }).prop('disabled',true);   
                                                        },
                                                        UpperScience: function(){
                                                            $('#form option').filter(function(){
                                                                return this.value == "1" || this.value == "2" || this.value == "3"
                                                            }).prop('disabled',true);   
                                                        },
                                                        UpperArt: function(){
                                                            $('#form option').filter(function(){
                                                                return this.value == "1" || this.value == "2" || this.value == "3"
                                                            }).prop('disabled',true);   
                                                        } 
                                                    }

                                                    $('#grade').on('change',function(){
                                                        controllerTypeFunctions.Default();

                                                        var val = $(this).val();
                                                        controllerTypeFunctions[val]();
                                                    });
                                                    $(document).ready(function(){
                                                        $('[data-toggle="tooltip"]').tooltip();   
                                                    });
                                                </script>
                                                <button type="submit" class="btn btn-dark mr-2" name="insert">Submit</button>
                                                <input type="button" class="btn btn-light" name="cancel" value="Cancel" onclick="window.location.href='ClassView.php'"/>
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