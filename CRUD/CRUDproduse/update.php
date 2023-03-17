<?php
require_once "config.php";
session_start();
if($_SESSION['rol'] == "Client"){
    header("Location: ../../authenticate.php");
    exit();
}
$name = $author = $category = $description = $price = $stock = $image ="";
$name_err = $author_err = $category_err = $description_err = $price_err = $stock_err = $image_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Introduceți un nume";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Introduceți un nume valid.";
    } else{
        $name = $input_name;
    }
    
    $input_author = trim($_POST["author"]);
    if(empty($input_author)){
        $author_err = "Please enter an address.";     
    } else{
        $author = $input_author;
    }

    $input_category = trim($_POST["category"]);
    if(empty($input_category)){
        $category_err = "Introduceți o categorie.";     
    } else{
        $category = $input_category;
    }
    
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Introduceți o descriere.";     
    } else{
        $description = $input_description;
    }

    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Introduceți valoarea prețului";     
    } elseif(!ctype_digit($input_price)){
        $price_err = "Introduceți o valoare întreagă pozitivă.";
    } else{
        $price = $input_price;
    }
    
    $input_stock = trim($_POST["stock"]);
    if(empty($input_stock)){
        $stock_err = "Introduceți id-ul stocului.";     
    } elseif(!ctype_digit($input_stock)){
        $stock_err = "Introduceți o valoare întreagă pozitivă.";
    } else{
        $stock = $input_stock;
    }
    

    $msg = "";
    
    if (isset($_POST['submit'])) {
        
      $filename = $_FILES["image"]["name"];
            
      $db = $link;
    
        if($filename == "")
        {        
            $sql = "SELECT imagine FROM produse WHERE id=$id";

            $result2 = mysqli_query($db, $sql); 
            $xd = mysqli_fetch_assoc($result2);
            $filename = $xd['imagine'];
        }
    }

    if(empty($name_err) && empty($author_err) && empty($description_err)){
        $sql = "UPDATE produse SET nume=?, autor=?, descriere=?, pret=? , stoc=?, imagine=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssiisi", $param_name, $param_author, $param_description, $param_price, $param_stock, $param_image, $param_id);
            
            $param_name = $name;
            $param_author = $author;
            $param_category = $category;
            $param_description = $description;
            $param_price = $price;
            $param_stock = $stock;
            $param_image = $filename;
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: produse.php");
                exit();
            } else{
                echo "Ups! Ceva nu a mers bine. Încearcă din nou.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($link);
} else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM produse WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $name = $row["nume"];
                    $author = $row["autor"];
                    $category = $row["categorie"];
                    $description = $row["descriere"];
                    $price = $row["pret"];
                    $stock = $row["stoc"];
                    $image = $row["imagine"];
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
                    <p>--</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Nume</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Autor</label>
                            <input type="text" name="author" class="form-control <?php echo (!empty($author_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $author; ?>">
                            <span class="invalid-feedback"><?php echo $author_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Categorie</label>
                            <input type="text" name="category" class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $category; ?>">
                            <span class="invalid-feedback"><?php echo $category_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Descriere</label>
                            <input type="text" name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $description; ?>">
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Preț</label>
                            <input type="number" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Stoc</label>
                            <input type="number" name="stock" class="form-control <?php echo (!empty($stock_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $stock; ?>">
                            <span class="invalid-feedback"><?php echo $stock_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Imagine</label>
                            <input type="file" accept="image/png, image/jpeg, image/jpg" name="image" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $image_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" name="submit" class="btn btn-primary" value="Actualizează">
                        <a href="produse.php" class="btn btn-secondary ml-2">Renunță</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>