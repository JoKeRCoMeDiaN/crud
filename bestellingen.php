<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
<nav class="navbar navbar-default">
                <div class="container-fluid">
                    <ul class="nav navbar-nav">
                        <li><a href="homepagina.html">Home</a></li>
                        <li class="active"><a href="reserveren.php">Reserveren</a></li>
                        <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="Serveren.html">Serveren
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="kok.php">Voor kok</a></li>
                            <li><a href="#">Voor barman</a></li>
                            <li><a href="#">Voor ober</a></li>
                        </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="gegevens.html">Gegevens
                            <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                            <li><a href="#"></a></li>
                            <li><a href="#">leeg</a></li>
                            <li><a href="#">leeg</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Bestellingen</h2>
                        <a href="create.php" class="btn btn-success pull-right">Add New Employee</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT menuitems.naam, bestellingen.aantal, menuitems.prijs,cast(menuitems.prijs*bestellingen.aantal AS decimal(10,2)) 'totaal'
                    FROM menuitems, bestellingen, reserveringen
                    WHERE menuitems.idmenuitems = bestellingen.menuitems_idmenuitems AND bestellingen.reserveringen_idreserveringen = reserveringen.idreserveringen AND reserveringen.tafel = {$_GET['id']} ";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Naam</th>";
                                        echo "<th>Aantal</th>";
                                        echo "<th>Prijs</th>";
                                        echo "<th>Totaal</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['naam'] . "</td>";
                                        echo "<td>" . $row['aantal'] . "</td>";
                                        echo "<td>" . $row['prijs'] . "</td>";
                                        echo "<td>" . $row['totaal'] . "</td>";
                                        echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    $sql = "SELECT menuitems.naam, bestellingen.aantal, menuitems.prijs,cast(menuitems.prijs*bestellingen.aantal AS decimal(10,2)) 'totaal', SUM(menuitems.prijs*bestellingen.aantal) AS'totaalbedrag' 
                    FROM menuitems, bestellingen, reserveringen
                    WHERE menuitems.idmenuitems = bestellingen.menuitems_idmenuitems AND bestellingen.reserveringen_idreserveringen = reserveringen.idreserveringen AND reserveringen.tafel =  {$_GET['id']} ";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Totaal bedrag</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        
                                        echo "<td>" . $row['totaalbedrag'] . "</td>";
                                        
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>

</body>
</html>