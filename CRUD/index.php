    <?php
    session_start();
    if($_SESSION['rol'] == "Client"){
        header("Location: ../authenticate.php");
        exit();
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   

        <style>
            body{
                background-image: url(assets/adminback.jpg);
            }
        </style>
    </head>
    <body>
   
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3">
            <div class="container">
                <img class="img" src="../assets/bb.png">
                <div class="navbar-brand">Bună <i><?=$_SESSION['username']?></i></div>
                <button class="navbar-toggler" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#navmenu" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navmenu">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="../logout.php" class="nav-link bi bi-arrow-bar-right"style="color:#B72E10; margin-left: 50em;">Deconectare</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container align-self-center">
            <ul class="list-group text-align-center mt-5">
                <li class="list-group-item">Modificați secțiunea <a href="CRUDproduse/produse.php">Produse</a></li>
                <li class="list-group-item">Modificați secțiunea <a href="CRUDclienti/clienti.php">Clienți</a></li>
                <li class="list-group-item">Modificați secțiunea <a href="CRUDcomenzi/comenzi.php">Comenzi</a></li>
            </ul>
        </div>
        
        
        
        
    </body>
    </html>