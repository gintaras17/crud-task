<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gintaras's tenders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left"><a href="./index.php" style="text-decoration:none;">Tenders Details</a></h2>
                        <a href="./create.php" class="btn btn-success pull-right">Add New Tender</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "./config.php";

                    $record_per_page = 500;
                    $page = '';
                    if(isset($_GET["page"])) {
                        $page = $_GET["page"];
                    } else {
                    $page = 1;
                    }

                    $start_from = ($page-1) * $record_per_page;

                    $query = "SELECT * FROM tenders ORDER BY id ASC LIMIT $start_from, $record_per_page";
                    $result = mysqli_query($link, $query);

                    // Attempt select query execution
                         if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Title</th>";
                                        echo "<th>Description</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>"; 
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['title'] . "</td>";
                                        echo "<td>" . $row['description'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='./read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='./update.php?id=". $row['id'] ."' title='Edit Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='./delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";

                            $page_query = "SELECT * FROM tenders ORDER BY id ASC";  
                            $page_result = mysqli_query($link, $page_query);   
                            $total_records = mysqli_num_rows($page_result);  
                            $total_pages = ceil($total_records / $record_per_page);

                            $pagLink = "<ul class='pagination justify-content-center'>";  
                            for ($i=1; $i<=$total_pages; $i++) {  
                                        $pagLink .= "<li><a href='index.php?page=".$i."'>".$i."</a></li>";  
                            };  
                            echo $pagLink . "</ul>";

                            // Free result set
                             mysqli_free_result($result);
                         } else{
                             echo "<p class='lead'><em>No records were found.</em></p>";
                         }
 
                    // Close connection
                    mysqli_close($link);
                    ?>

                </div>
            </div>        
        </div>
    </div>
</body>
</html>