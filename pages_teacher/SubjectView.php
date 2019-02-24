<!DOCTYPE html>
<?php 
include("header.php");
require_once '../db_connect.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Subject Records</title>
        <link rel="stylesheet" href="../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.addons.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
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
                                                <h2 style="float:left">Filter Subject</h2>				
                                            </div>
                                            <form class="forms-sample" method="post">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Subject ID" name="subjectID">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Subject Name" name="subjectName">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <select class="form-control" name="subjectType">
                                                                <option value="">Subject Type</option>
                                                                <option value="Core">Core</option>
                                                                <option value="Selective">Selective</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
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
                                        <h2 style="float:left">Subject Details</h2>
                                    </div>					
                                    <?php 
                                    $sql = "SELECT * FROM subject ";
                                    $result = $conn->query($sql); 
                                    $rownum = $result->num_rows; 
                                    if (isset($_POST['search'])){ 
                                        $sql = "SELECT * FROM subject "; 
                                        $where = ""; 
                                        $limit = "";
                                        if (!empty($_POST["subjectID"])) 
                                            $where .= "subjectID LIKE '%{$_POST["subjectID"]}%' "; 
                                        if (!empty($_POST["subjectName"])){ 
                                            if(!empty($where))
                                                $where .= " AND ";
                                            $where .= "subjectName LIKE '%{$_POST["subjectName"]}%' "; 
                                        }
                                        if (!empty($_POST["subjectType"])){ 
                                            if(!empty($where))
                                                $where .= " AND ";
                                            $where .= "subjectType LIKE '%{$_POST["subjectType"]}%' "; 
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
                                                    <th class="border-top-0">Subject ID</th>
                                                    <th class="border-top-0">Subject Name</th>   
                                                    <th class="border-top-0">Subject Type</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php								
                                        while ($row = $result->fetch_assoc())
                                        {
                                            if($row['subjectType'] == 'Selective')
                                                continue;
                                            echo 
                                                '<tr>
															<td>'.$row['subjectID'].'</td>
															<td>'.$row['subjectName'] . '</td>
															<td>'.$row['subjectType'].'</td>
															</tr>';
                                        }
                                        mysqli_data_seek($result,0);
                                        while ($row = $result->fetch_assoc())
                                        {
                                            if($row['subjectType'] == 'Core')
                                                continue;
                                            echo 
                                                '<tr>
															<td>'.$row['subjectID'].'</td>
															<td>'.$row['subjectName'] . '</td>
															<td>'.$row['subjectType'].'</td>
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