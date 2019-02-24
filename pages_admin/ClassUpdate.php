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
        <title>Update Class Records</title>
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
                                                <h2 style="float:left">Update Class</h2>				
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
                                                    <label for="classID">Class ID</label>
                                                    <input type="text" class="form-control" placeholder="" name="classID" id="classID" value="<?php echo $id; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="className">Class Name</label>
                                                    <input type="text" class="form-control" placeholder="" name="className" id="className" value="<?php $namesql = 'SELECT className FROM class WHERE classID="'.$id. '"'; 
                                                           $result = $conn->query($namesql); 
                                                           while($row = $result->fetch_assoc()) {echo $row['className'];}?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Year Grade <span class="badge badge-dark" data-toggle="tooltip" data-placement="right" title="Lower Secondary (Form 1-3) &#013; Upper Secondary (Form 4-5)">?</span></label>

                                                    <select name="grade" id="grade" class="form-control" required>
                                                        <?php 
                                                        $typesql = 'SELECT yearGrade FROM class WHERE classID="'.$id.'"'; 
                                                        $result = $conn->query($typesql); 

                                                        while($row = $result->fetch_assoc()) {		
                                                            $arr = array (
                                                                array('Lower', 'Lower Secondary'),
                                                                array('UpperScience', 'Upper Secondary Science'),
                                                                array('UpperArt', 'Upper Secondary Art')
                                                            );  

                                                            for($a=0; $a < count($arr); $a++){
                                                                if($row['yearGrade'] == $arr[$a][0])
                                                                    echo '<option value="'.$arr[$a][0].'" selected>'.$arr[$a][1].'</option>';
                                                                else
                                                                    echo '<option value="'.$arr[$a][0].'">'.$arr[$a][1].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php var_dump($row['yearGrade']); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label>Year Form</label>
                                                    <select name="form" id="form" onchange="updateText(\'form\')" class="form-control" required>
                                                        <?php 
                                                        $typesql = 'SELECT yearForm FROM class WHERE classID="'.$id. '"'; 
                                                        $result = $conn->query($typesql); 
                                                        while($row = $result->fetch_assoc()) {

                                                            $arr = array(1,2,3,4,5);
                                                            foreach($arr as $value){
                                                                if($row['yearForm'] == $value)
                                                                    echo '<option value="'.$value.'" selected>'.$value.'</option>';
                                                                else
                                                                    echo '<option value="'.$value.'">'.$value.'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php
                                                echo "

                                                <script>
                                                    var controllerTypeFunctions = {
                                                    Default:function(){
                                                        $('#form option').prop('disabled',false);   
                                                    },
                                                    Lower: function(){
                                                        $('#form option').filter(function(){
                                                            return this.value == \"4\" || this.value == \"5\"
                                                        }).prop('disabled',true);   
                                                    },
                                                    UpperScience: function(){
                                                        $('#form option').filter(function(){
                                                            return this.value == \"1\" || this.value == \"2\" || this.value == \"3\"
                                                        }).prop('disabled',true);   
                                                    },
                                                    UpperArt: function(){
                                                        $('#form option').filter(function(){
                                                            return this.value == \"1\" || this.value == \"2\" || this.value == \"3\"
                                                        }).prop('disabled',true);   
                                                    } 
                                                }

                                                $('#grade').on('change',function(){
                                                    controllerTypeFunctions.Default();

                                                    var val = $(this).val();
                                                    controllerTypeFunctions[val]();
                                                });
                                                $(document).ready(function(){
                                                    $('[data-toggle=\"tooltip\"]').tooltip();   
                                                });
                                                </script> ";

                                                ?>
                                                <button type="submit" class="btn btn-dark mr-2" name="update">Update</button>
                                                <button class="btn btn-light" name="Delete">Delete</button>
                                                <?php 
                                                if (isset($_POST['update'])){ 
                                                    $classID = trim($_POST['classID']);
                                                    $className = trim($_POST['className']);
                                                    $grade = trim($_POST['grade']);
                                                    $form = trim($_POST['form']);

                                                    $classID = str_replace( "'", "'", $classID); 
                                                    $className = str_replace( "'", "'", $className); 
                                                    $grade = str_replace( "'", "'", $grade); 
                                                    $form = str_replace( "'", "'", $form); 

                                                    $err = true;


                                                    if($form == 4 || $form == 5){
                                                        if($grade == 'Lower'){
                                                            echo "<script> alert('Invalid Combination Entered for Year Grade and Year Formabc! Please try again'); location.href='ClassUpdate.php?id=".$id."'; </script>";
                                                            $err = false;
                                                        }
                                                    }
                                                    else if($form == 1 || $form == 2 || $form == 3){
                                                        if($grade == 'UpperScience' || $grade == 'UpperArt' ){
                                                            echo "<script> alert('Invalid Combination Entered for Year Grade and Year Form! Please try again'); location.href='ClassUpdate.php?id=".$id."'; </script>";
                                                            $err = false;
                                                        }
                                                    }

                                                    if($err){
                                                        $sql = 'UPDATE class SET
														classID = "'.$classID.'",
														className = "'.$className.'",
														yearGrade = "'.$grade.'",
                                                        yearForm = "'.$form.'"
														WHERE classID ="'.$id.'";';

                                                        if ($result = $conn->query($sql)) {
                                                            $scMSG = "Updated successfully";
                                                            echo "<script> alert('Class Updated Successfully!'); location.href='ClassView.php'; </script>";
                                                        } 
                                                        else {
                                                            $errMSG = mysqli_error($conn);
                                                        }	
                                                    }
                                                }
                                                if (isset($_POST['Delete'])){ 
                                                    $dsql = 'DELETE FROM class WHERE classID = "'.$id. '"'; 
                                                    if ($result = $conn->query($dsql)) {
                                                        $scMSG = "Deleted successfully";
                                                        echo "<script> alert('Class Deleted Successfully!'); location.href='ClassView.php'; </script>";
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