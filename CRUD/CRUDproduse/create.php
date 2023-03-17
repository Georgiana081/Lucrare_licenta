<?php
require_once "config.php";
session_start();
if($_SESSION['rol'] == "Client"){
    header("Location: ../../authenticate.php");
    exit();
}
$name = $author = $category = $description =  $price = $stock = $image = "";
$name_err = $author_err = $category_err = $description_err  = $price_err = $stock_err = $image_err  = "";
$err = 0;

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Introduceți un nume.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Introduceți un nume valid.";
        $err = $err +1;
    } else{
        $name = $input_name;
    }
        
    $input_author = trim($_POST["author"]);
    if(empty($input_author)){
        $author_err = "Introduceți un autor.";
        $err = $err +1;     
    } else{
        $author = $input_author;
    }
    
    $input_category = trim($_POST["category"]);
    if(empty($input_category)){
        $category_err = "Introduceți o categorie.";
        $err = $err +1;     
    } else{
        $category = $input_category;
    }

    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Introduceți o descriere.";
        $err = $err +1;     
    } else{
        $description = $input_description;
    }
    
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Introduceți prețul.";     
    } elseif(!ctype_digit($input_price)){
        $price_err = "Introduceți o valoare intreagă pozitivă.";
        $err = $err +1;
    } else{
        $price = $input_price;
    }
    
    $msg = "";

     $input_stock = trim($_POST["stock"]);
     if(empty($input_stock)){
         $stock_err = "Introduceți stocul.";     
     } elseif(!ctype_digit($input_stock)){
         $stock_err = "Introduceți o valoare intreagă pozitivă.";
         $err = $err +1;
     } else{
         $stock = $input_stock;
     }

    if (isset($_POST['submit'])) {

      $filename = $_FILES["image"]["name"];
      $tempname = $_FILES["image"]["tmp_name"];    
          $folder = "assets/images/".$filename;
            
      $db = $link;
    
    
          if($err == 0)
          {
            $sql = "INSERT INTO produse (nume, autor, categorie, descriere, pret, stoc, imagine) VALUES ('$name', '$author', '$category','$description', $price, $stock, '$filename')";
            mysqli_query($db, $sql);
          }

            
          if (move_uploaded_file($tempname, $folder))  
          {
                $msg = "Produs adăugat cu succes";
                echo $msg;
            }else{
                $msg = "Eșuat";
         }
    }

    mysqli_close($link);
}

 ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Adăugare produs</h2>
                    <p>Introduceți datele aferente si apăsați butonul de adaugă pentru a adăuga produsul pe site.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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
                            <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $description; ?></textarea>
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
                            <input type="file" accept="image/png, image/jpeg, image/jpg" name="image" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $image; ?>">
                            <span class="invalid-feedback"><?php echo $image_err;?></span>
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary" value="Adaugă">
                        <a href="produse.php" class="btn btn-secondary ml-2">Renunță</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>