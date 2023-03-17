<?php
session_start();
if($_SESSION['rol'] == "Client"){
    header("Location: ../../authenticate.php");
    exit();
}
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require_once "config.php";
    
    $sql = "SELECT * FROM utilizatori WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        $param_id = trim($_GET["id"]);
        
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){

                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                $name = $row["username"];
                $email = $row["email"];
                $password = $row["parola"];
                $create = $row["creat_in"];
            } else{
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt);
    
    mysqli_close($link);
} else{
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Înregistrare</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">Vizualizare Înregistrare</h1>
                    <div class="form-group">
                        <label>Nume utilizator</label>
                        <p><b><?php echo $row["username"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <p><b><?php echo $row["email"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Parola</label>
                        <p><b><?php echo $row["parola"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Creat in</label>
                        <p><b><?php echo $row["creat_in"]; ?></b></p>
                    </div>
                    <p><a href="clienti.php" class="btn btn-warning">Înapoi</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>