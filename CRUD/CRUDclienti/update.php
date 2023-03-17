<?php
session_start();
if($_SESSION['rol'] == "Client"){
    header("Location: ../../authenticate.php");
    exit();
}
require_once "config.php";
 
$username = $email = $password = "";
$username_err = $email_err = $password_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    
    $input_username = trim($_POST["username"]);
    if(empty($input_username)){
        $username_err = "Please enter a username.";
    } elseif(!filter_var($input_username, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/[a-zA-Z\s]/")))){
        $username_err = "Please enter a valid name.";
    } else{
        $username = $input_username;
    }

    
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an email.";     
    } else{
        $email = $input_email;
    }

    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Please enter an password.";     
    } else{
        $password = $input_password;
    }
   
    $msg = "";
  
    if(empty($name_err) && empty($author_err) && empty($description_err)){
        $sql = "UPDATE utilizatori SET username=?, email=?, parola=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssi", $param_username, $param_email, $param_password, $param_id);
            
            $param_username = $username;
            $param_email = $email;
            $param_password = $password;
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: clienti.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
                 mysqli_stmt_close($stmt);
    }
        mysqli_close($link);
} else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM utilizatori WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){

                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $username = $row["username"];
                    $email = $row["email"];
                    $password = $row["parola"];
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
    <title>Update Record</title>
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
                    <h2 class="mt-5">Actualizare Înregistrare</h2>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Nume</label>
                            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Parola</label>
                            <input type="text" name="password" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" name="submit" class="btn btn-primary" value="Actualizează">
                        <a href="clienti.php" class="btn btn-secondary ml-2">Renunță</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>