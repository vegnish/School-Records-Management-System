<!DOCTYPE html>
<?php 
include("header.php");
require_once '../db_connect.php';
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
                        <div class="col-md-12 d-flex align-items-stretch grid-margin">
                            <div class="row flex-grow">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="page-header clearfix">
                                                <h2 style="float:left">Filter Class</h2>				
                                            </div>
                                            <form class="forms-sample" method="post">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Class ID" name="classID">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Class Name" name="className">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <select class="form-control" id="grade" name="grade">
                                                                <option value="">Select Year Grade</option>
                                                                <option value="Lower">Lower Secondary</option>
                                                                <option value="UpperScience">Upper Secondary Science</option>
                                                                <option value="UpperArt">Upper Secondary Art</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <select class="form-control" id="form" onchange="updateText('form')" name="form">
                                                                <option value="">Select Year Form</option>
                                                                <option value="1" data-temp="Lower">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
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
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="No. of Records" name="count">
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-dark mr-2" name="search">Submit</button>
                                                <button class="btn btn-light" name="cancel" type="reset">Cancel</button>
                                            </form>
                                        </div>
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
                                        <h2 style="float:left">Class Details</h2>
                                        <a href="ClassAdd.php" class="btn btn-dark pull-right" style="float: right">Add New Class</a>
                                    </div>

                                    <?php 
                                    $sql = "SELECT * FROM class ";
                                    $result = $conn->query($sql); 
                                    $rownum = $result->num_rows; 
                                    if (isset($_POST['search'])){ 
                                        $sql = "SELECT * FROM class "; 
                                        $where = ""; 
                                        $limit = "";
                                        if (!empty($_POST["classID"])) 
                                            $where .= "classID LIKE '%{$_POST["classID"]}%' "; 
                                        if (!empty($_POST["className"])){ 
                                            if(!empty($where))
                                                $where .= " AND ";
                                            $where .= "className LIKE '%{$_POST["className"]}%' "; 
                                        }
                                        if (!empty($_POST["form"])){ 
                                            if(!empty($where))
                                                $where .= " AND ";
                                            $where .= "yearForm LIKE '%{$_POST["form"]}%' "; 
                                        }
                                        if (!empty($_POST["grade"])){ 
                                            if(!empty($where))
                                                $where .= " AND ";
                                            $where .= "yearGrade LIKE '%{$_POST["grade"]}%' "; 
                                        }
                                        if (!empty($_POST["count"])) 
                                            $limit .= "LIMIT {$_POST["count"]} "; 
                                        if (!empty($where)) {
                                            $sql .= "WHERE " . $where; 
                                        }
                                        if (!empty($limit)){
                                            $sql .= " " . $limit; 
                                        }
                                        $result = $conn->query($sql); 
                                        $rownum = $result->num_rows; 
                                    ?>

                                    <div class="table-responsive">
                                        <table id="recent-orders" class="table table-hover table-xl mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0">Class ID</th>
                                                    <th class="border-top-0">Class Name</th>   
                                                    <th class="border-top-0">Year Grade</th> 
                                                    <th class="border-top-0">Year Form</th>
                                                    <th class="border-top-0">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php								
                                        while ($row = $result->fetch_assoc())
                                        {
                                            if($row['yearGrade'] == 'UpperScience' || $row['yearGrade'] == 'UpperArt')
                                                continue;
                                            echo 
                                                '<tr>
															<td>'.$row['classID'].'</td>
															<td>'.$row['className'] . '</td>
                                                            <td>Lower Secondary</td>
															<td>'.$row['yearForm'].'</td>

                                                            <td><a href="ClassUpdate.php?id='.$row['classID'].'" title="Update Class" data-toggle="tooltip" class="icon"><i class="fas fa-pen icon"></i></a></td>

															</tr>';
                                        }
                                        mysqli_data_seek($result,0);
                                        while ($row = $result->fetch_assoc())
                                        {
                                            if($row['yearGrade'] == 'Lower' || $row['yearGrade'] == 'UpperArt')
                                                continue;
                                            echo 
                                                '<tr>
															<td>'.$row['classID'].'</td>
															<td>'.$row['className'] . '</td>
                                                            <td>Upper Secondary Science</td>
															<td>'.$row['yearForm'].'</td>

                                                            <td><a href="ClassUpdate.php?id='.$row['classID'].'" title="Update Class" data-toggle="tooltip" class="icon"><i class="fas fa-pen icon"></i></a></td>

															</tr>';
                                        }
                                        mysqli_data_seek($result,0);
                                        while ($row = $result->fetch_assoc())
                                        {
                                            if($row['yearGrade'] == 'UpperScience' || $row['yearGrade'] == 'Lower')
                                                continue;
                                            echo 
                                                '<tr>
															<td>'.$row['classID'].'</td>
															<td>'.$row['className'] . '</td>
                                                            <td>Upper Secondary Art</td>
															<td>'.$row['yearForm'].'</td>

                                                            <td><a href="ClassUpdate.php?id='.$row['classID'].'" title="Update Class" data-toggle="tooltip" class="icon"><i class="fas fa-pen icon"></i></a></td>

															</tr>';
                                        }
                                        echo "<tfoot class='foot'><td colspan='6'><div id='records'>".$rownum. " records found</div></td></tfoot>";
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                                    }
                    ?>
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