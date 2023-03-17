    <?php

    require_once "config.php";

    $judet = $oras = $strada = $numar = $apartament = "";
    $judet_err = $oras_err = $strada_err =  $numar_err = $apartament_err ="";
    

    if(isset($_POST["id"]) && !empty($_POST["id"])){

        $id = $_POST["id"];

        $input_judet = trim($_POST["judet"]);
        if(empty($input_judet)){
            $judet_err = "Introduceți județul.";
        } else{
            $judet = $input_judet;
        }
        
        $input_oras = trim($_POST["oras"]);
        if(empty($input_oras)){
            $oras_err = "Introduceți un oraș.";     
        } else{
            $oras = $input_oras;
        }

        $input_strada = trim($_POST["strada"]);
        if(empty($input_strada)){
            $strada_err = "Introduceți o stradă.";     
        } else{
            $strada = $input_strada;
        }
    
        $input_numar = trim($_POST["numar"]);
        if(empty($input_numar)){
            $numar_err = "Introduceți un număr.";     
        } else{
            $numar = $input_numar;
        }
    
        $input_apartament = trim($_POST["apartament"]);
        if(empty($input_apartament)){
            $apartament_err = "Introduceți un număr de apartament.";     
        } else{
            $apartament = $input_apartament;
        }
        
        $msg = "";
    

        if(empty($judet_err) && empty($oras_err) && empty($strada_err) && empty($numar_err) && empty($apartament_err)){
            $sql = "UPDATE detalii_clienti SET judet=?, oras=?, strada=?, numar=?, apartament=? WHERE id_client=?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "sssiii", $param_judet, $param_oras, $param_strada, $param_numar, $param_apartament, $param_id);
                
                $param_judet = $judet;
                $param_oras = $oras;
                $param_strada = $strada;
                $param_numar = $numar;
                $param_apartament = $apartament;
                $param_id = $id;
                
                if(mysqli_stmt_execute($stmt))
                {
                    header("location: ../profile.php");
                    exit();
                } 
                else{
                    echo "Ceva nu a mers bine. Incearca alta data.";
                }
            }
            
            mysqli_stmt_close($stmt);
        }
        
        mysqli_close($link);
    } 
    else{

        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

            $id =  trim($_GET["id"]);
            
            $sql = "SELECT * FROM detalii_clienti WHERE id_client = ?";
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "i", $param_id);
                
                $param_id = $id;
                
                if(mysqli_stmt_execute($stmt)){
                    $result = mysqli_stmt_get_result($stmt);
        
                    if(mysqli_num_rows($result) == 1)
                    {
                    
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        
                        $judet = $row["judet"];
                        $oras = $row["oras"];
                        $strada = $row["strada"];
                        $numar = $row["numar"];
                        $apartament = $row["apartament"];
                    } 
                    else{
                        //header("location: error.php");
                        //exit();
                    }
                    
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            
            
            mysqli_stmt_close($stmt);
            mysqli_close($link);
        }  
        else
        {
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
        <img class="img" src="../assets/bb.png">
        <a href="../authenticate.php" class="navbar-brand">GBooks</a>
        
        <button class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navmenu" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navmenu">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a href="../profile.php" class="nav-link bi bi-file-earmark-person">Înapoi</a>
            </li>
            <li class="nav-item">
                <a href="../logout.php" class="nav-link bi bi-arrow-bar-right">Deconectare</a>
            </li>
            </ul>
        </div>
        </div>
    </nav>

        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="mt-5">Actualizare date cont</h2>
                        <p>--</p>
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Judet</label>
                                <input type="text" name="judet" class="form-control <?php echo (!empty($judet_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $judet; ?>">
                                <span class="invalid-feedback"><?php echo $judet_err;?></span>
                            </div>
                            <div class="form-group">
                                <label>Oras</label>
                                <input type="text" name="oras" class="form-control <?php echo (!empty($oras_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $oras; ?>">
                                <span class="invalid-feedback"><?php echo $oras_err;?></span>
                            </div>
                            <div class="form-group">
                                <label>Strada</label>
                                <input type="text" name="strada" class="form-control <?php echo (!empty($strada_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $strada; ?>">
                                <span class="invalid-feedback"><?php echo $strada_err;?></span>
                            </div>
                            <div class="form-group">
                                <label>Numar</label>
                                <input type="number" name="numar" class="form-control <?php echo (!empty($numar_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $numar; ?>">
                                <span class="invalid-feedback"><?php echo $numar_err;?></span>
                            </div>
                            <div class="form-group">
                                <label>Apartament</label>
                                <input type="number" name="apartament" class="form-control <?php echo (!empty($apartament_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $apartament; ?>">
                                <span class="invalid-feedback"><?php echo $apartament_err;?></span>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                            <input type="submit" name="submit" class="btn btn-primary" value="Actualizează">
                            <a href="../profile.php" class="btn btn-secondary ml-2">Renunță</a>
                        </form>
                    </div>
                </div>        
            </div>
        </div>
    </body>
    </html>