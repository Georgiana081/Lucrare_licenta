<?php
require_once "config.php";
session_start();
if($_SESSION['rol'] == "Client"){
    header("Location: ../../authenticate.php");
    exit();
}
$status = "";
$status_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){

    $id = $_POST["id"];

    $input_status = trim($_POST["status"]);
    if(!empty($input_status)){
        $status = $input_status;
    }
    
    $sql = "UPDATE comanda SET status=? WHERE id=?";
        
    if($stmt = mysqli_prepare($link, $sql))
    {
        mysqli_stmt_bind_param($stmt, "ss", $status, $param_id);

        $param_status = $status;
        $param_id = $id;
        
        if(mysqli_stmt_execute($stmt))
        {

            header("location: comenzi.php");
            exit();
        } 
        else
        {
            echo "Ups! Ceva nu a mers bine. Încearcă din nou.";
        }

        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($link);
} 
else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM comanda WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $status = $row["status"];
                } else{
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Ups! Ceva a mers rău. Încearcă din nou.";
            }
        }
        
        mysqli_stmt_close($stmt);
        
        mysqli_close($link);
    }  else{
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Actualizează status</title>
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
                    <h2 class="mt-5">Actualizare Status Comanda [#<?php echo $id ?>]</h2>
                    <p>--</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <h5>Status</h5>
                            <select name="status" class="form-control">
                                <option value="În procesare" style="text-align:center;">În procesare</option>
                                <option value="Livrat" style="text-align:center;">Livrat</option>
                            </select>
                        </div>  
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" name="submit" class="btn btn-primary" value="Actualizează">
                        <a href="comenzi.php" class="btn btn-secondary ml-2">Renunță</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>