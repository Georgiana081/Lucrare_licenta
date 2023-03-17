<?php
session_start();
if($_SESSION['rol'] == "Client"){
    header("Location: ../../authenticate.php");
    exit();
}
if(isset($_POST["id"]) && !empty($_POST["id"])){
    require_once "config.php";
    
    $sql = "DELETE FROM utilizatori WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        $param_id = trim($_POST["id"]);
        
        if(mysqli_stmt_execute($stmt)){
            header("location: clienti.php");
            exit();
        } else{
            echo "Ups! Ceva nu a mers bine. Încearcă din nou.";
        }
    }
     
    mysqli_stmt_close($stmt);
    
    mysqli_close($link);
} else{
    if(empty(trim($_GET["id"]))){
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ștergere</title>
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
                    <h2 class="mt-5 mb-3">Ștergere</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Sigur dorești să ștergi acest client?</p>
                            <p>
                                <input type="submit" value="Da" class="btn btn-danger">
                                <a href="clienti.php" class="btn btn-secondary">Nu</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>