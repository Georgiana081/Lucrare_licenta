 <?php
    require_once "config.php";
    session_start();
    header("Content-type: text/html; charset=UTF-8");
    if(isset($_SESSION["loggedin"]) && $_SESSION['rol'] == "Administrator")
    {
        header("location: CRUD/index.php");
        exit;
    }
    else if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: authenticate.php");
        exit;
    }
    $username = $password = "";
    $username_err = $parola_err = $login_err = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"])))
    {
        $username_err = "Introdu numele de utilizator.";
    } 
    else
    {
        $username = trim($_POST["username"]);
    }
    if(empty(trim($_POST["parola"])))
    {
        $parola_err = "Introdu o parola.";
    }
    else
    {
        $password = trim($_POST["parola"]);
    }
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, rol, parola FROM utilizatori WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $rol, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username; 
                            $_SESSION["rol"] = $rol;                          
                            

                            if($_SESSION['rol'] == "Administrator") 
                                {
                                    header("location: CRUD/index.php");
                                }
                            else
                            {
                                header("location: authenticate.php");
                            }
                                
                        } 
                        else{
                            $login_err = "Parola sau nume de utilizator invalide.";
                        }
                    }
                } 
                else{
                    $login_err = "Parola sau nume de utilizator invalide.";
                }
            } 
            else{
                echo "Oops! Ceva nu a mers bine. Te rog incearca din nou.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="assets/favicon.png">
    <title>GBooks-Autentificare</title>

    <style>
        *{
            margin: 0px;
            padding: 0px;
        }
        body{
            background-image: url(assets/img/back3.jpg);
            background-size: cover;
            background-attachment: fixed;
        }
    </style>

    </head>
    <body">

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3">
        <div class="container">
        <a href="Index.php" class="navbar-brand">GBooks</a>
        
        <button class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navmenu" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a href="Index.php" class="nav-link">Pagină principală</a>
            </li>
            </ul>
        </div>
        </div>
    </nav>
        <section class="container-fluid">
            <div class="row justify-content-center my-5">
                <div class="col-12 col-sm-6 col-md-3">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-container" method="post">
                        <div class="text-center"><h4>Autentificare</h4></div>
                        <img class="img rounded mx-auto d-block" src="assets/ee.png">
                        <div class="mb-3 my-2">
                            <input type="text" class="form-control" name="username" placeholder="Username">
                            <span class="text-danger"><?php if (!empty($username_err[0])) echo $username_err; ?></span>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="parola" placeholder="Parolă"> 
                            <span class="text-danger"><?php if (!empty($parola_err[0])) echo $parola_err ?></span>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-warning">Autentifică-te <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-emoji-laughing" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M12.331 9.5a1 1 0 0 1 0 1A4.998 4.998 0 0 1 8 13a4.998 4.998 0 0 1-4.33-2.5A1 1 0 0 1 4.535 9h6.93a1 1 0 0 1 .866.5zM7 6.5c0 .828-.448 0-1 0s-1 .828-1 0S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 0-1 0s-1 .828-1 0S9.448 5 10 5s1 .672 1 1.5z"/>
                                </svg>
                            </button>
                        
                            <div class="text">
                                <span class="txt1">
                                    Nu ai cont?
                                </span>
                                <a class="txt2" href="register.php">
                                    Înregistrează-te!
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    </body>
    </html>