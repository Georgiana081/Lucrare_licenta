    <?php
        session_start();
        if (!isset($_SESSION['loggedin'])) {
            header('Location: Index.php');
            exit;
        }
        require_once('config.php');

        $id = $_SESSION['id'];
        include_once 'cos/Cart.class.php'; 
        $cart = new Cart; 
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Profil</title>
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body class="loggedin">
        
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3">
        <div class="container">
        <img class="img" src="assets/bb.png">
        <a href="authenticate.php" class="navbar-brand">GBooks</a>
        
        <button class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navmenu" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navmenu">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a href="authenticate.php" class="nav-link">Acasă</a>
            </li>
            <li class="nav-item">
                <a href="profile.php" class="nav-link">Profil</a>
            </li>

            <li class="nav-item">
                <a href="home.php" class="nav-link">Magazin</a>
            </li>   

            <li class="nav-item">
            <a href="cos/viewCart.php" title="View Cart" class = "nav-link bi bi-cart">Coș  
            (<?php
            echo ($cart->total_items() > 0)?$cart->total_items().' Produse':0; ?>)</a>          
        </li>
        <li class="nav-item">
                <a href="comenzi.php" class="nav-link"style="color:#2889EA;">Comenzi</a>
            </li>  
        <li class="nav-item">
                <a href="authenticate.php#contact" class="nav-link">Contact</a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link bi bi-arrow-bar-right"style="color:#B72E10;">Deconectare</a>
            </li>
            </ul>
        </div>
        </div>
    </nav>


        
        <div class="content">
            <h2><b>Comenzi</b></h2>
            <div>
                <p><b>Comenzi în desfășurare:</b></p>
                <table class="table table-hover cart">
                        <thead style=" text-align:center;">
                            <tr>
                                <th width="15%">Id comandă</th>					
                                <th width="20%">Total</th>
                                <th width="15%">Data plasării</th>
                                <th width="15%">Status</th>
                            </tr>
                        </thead>
                            <tbody style=" text-align:center;">
                        <?php 
                        $sqlQ = "SELECT * FROM comanda WHERE id_client = '$id' AND status = 'În procesare'"; 
                        $db = $link;
                        $stmt = $db->prepare($sqlQ); 
                        $db_id = $_SESSION["id"]; 
                        $stmt->execute(); 
                        $result = $stmt->get_result(); 
                        $cnt = 0;
                        $curent = 0;
                        if($result->num_rows > 0){  
                            while($item = $result->fetch_assoc()){ ?>
                                <tr>
                                    <td><?php echo $item["id"]; ?></td>
                                    <td><?php echo $item["total"].' '.CURRENCY; ?></td>
                                    <td><?php echo $item["plasata_in"]; ?></td>
                                    <td><?php echo $item["status"]; ?></td>
                                </tr>
                        <?php } } ?>
                        </tbody>
                    </table>
                <p><b>Istoric comenzi:</b></p>
                <table class="table table-hover cart">
                        <thead style=" text-align:center;">
                            <tr>
                                <th width="15%">Id comandă</th>					
                                <th width="20%">Produs</th>
                                <th width="20%">Denumire</th>
                                <th width="15%">Preț</th>
                                <th width="15%">Cantitate</th>

                                <th width="20%">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody style=" text-align:center;">
                        <?php 
                        $sqlQ = "SELECT i.*, p.* FROM produs_comanda as i LEFT JOIN produse as p ON i.id_produs = p.id WHERE i.id=?"; 
                        $db = $link;
                        $stmt = $db->prepare($sqlQ); 
                        $stmt->bind_param("i", $db_id); 
                        $db_id = $_SESSION["id"]; 
                        $stmt->execute(); 
                        $result = $stmt->get_result(); 
                        $cnt = 0;
                        $curent = 0;
                        if($result->num_rows > 0){  
                            while($item = $result->fetch_assoc()){ 
                                $price = $item["pret"]; 
                                $quantity = $item["cantitate"]; 
                                $sub_total = ($price*$quantity); 
                                $image = $item["imagine"]; 
                        ?>
                                <tr>
                                    <td style="padding-top:2%; text-align:center;"><?php 
                                        if($curent != $item["id_comanda"])
                                            $cnt = 0;
                                    $cnt++;
                                    if($cnt == 1)
                                        echo $item["id_comanda"]; 
                                    else echo "-"; ?></td>
                                    
                                    <td><?php echo "<img src='CRUD/CRUDproduse/assets/images/".$item["imagine"]."'height='60px;''>"; ?></td>
                                    <td><?php echo $item["nume"]; ?></td>
                                    <td><?php echo $price.' '.CURRENCY; ?></td>
                                    <td><?php echo $quantity; ?></td>
                                <td><?php echo $sub_total.' '.CURRENCY; 
                                $curent = $item["id_comanda"];?></td>
                            </tr>
                        <?php } } ?>
                        </tbody>
                    </table>
            </div>
        </div>
        
    </body>
    </html>