<?php
session_start();
if($_SESSION['rol'] == "Client"){
    header("Location: ../../authenticate.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrare</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/5bec4f1d4c.js" crossorigin="anonymous"></script>
    <style>
        .wrapper{
            width: 1300px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
        .bodyback{
            background-image: url(assets/adminback.jpg);
            object-fit: cover;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body class="bodyback">

     <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3">
            <div class="container">
                <div class="navbar-brand">Sunteți conectat ca și <i><?=$_SESSION['username']?></i></div>
                <button class="navbar-toggler" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#navmenu" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navmenu">
                    <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="../Index.php" class="nav-link" style="margin-left: 35em;">Panou principal</a>
                    </li>
                    <li class="nav-item">
                        <a href="../../logout.php" class="nav-link bi bi-arrow-bar-right" style="color:#B72E10;">Deconectare</a>
                    </li>
                    </ul>
                </div>
            </div>
        </nav>

    <div class="wrapper">
        <div class="container-fluid bg-light mt-4 mb-4 shadow rounded">
            <div class="row">
                <div class="col-sm-4 d-block">
                    <img style="width:140px; padding-top: 20px; position: relative; left: 20px;" src="assets/ee.png"></div>
                    <div class="col-md-15">
                        <div class="mb-5 clearfix">
                            <h2 class="text-center" style="padding-top: 30%; position: relative; left:24%"><b>Produse</b></h2>
                            <img style="width:300px; padding-top: -5%; position: relative; left: 24%;" src="assets/underline.png"></div>
                            <a href="create.php" class="btn btn-warning my-2" style="position: relative; left:210% "><i class="fa fa-plus"></i> Adaugă produs nou</a>
                        </div>
                    <?php
                    require_once "config.php";
                    
                    $sql = "SELECT * FROM produse";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Nume produs</th>";
                                        echo "<th>Autor</th>";
                                        echo "<th>Categorie</th>";
                                        echo "<th>Descriere</th>";
                                        echo "<th>Preț</th>";
                                        echo "<th>Stoc disponibil</th>";
                                        echo "<th>Imagine</th>";
                                        echo "<th>Acțiune</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['nume'] . "</td>";
                                        echo "<td>" . $row['autor'] . "</td>";
                                        echo "<td>" . $row['categorie'] . "</td>";
                                        echo "<td>" . $row['descriere'] . "</td>";
                                        echo "<td>" . $row['pret'] . "</td>";
                                        echo "<td>" . $row['stoc'] . "</td>";
                                        echo "<td><img src='assets/images/" . $row['imagine'] . "' height='180px;''></td>"; 
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $row['id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span style="font-size: 1.3em; color: #B91D01;"><i class="fa-solid fa-eye"></i></span></a>';
                                            echo '<a href="update.php?id='. $row['id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span style="font-size: 1.3em; color: #B91D01;"><i class="fa-solid fa-pencil"></i></span></a>';
                                            echo '<a href="delete.php?id='. $row['id'] .'" title="Delete Record" data-toggle="tooltip"><span style="font-size: 1.3em; color: #B91D01;"><i class="fa-solid fa-trash"></i></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>Nu au fost găsite înregistrări.</em></div>';
                        }
                    } else{
                        echo "Ups! Se pare că ceva nu a mers bine. Încearcă din nou.";
                    }
                     mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>