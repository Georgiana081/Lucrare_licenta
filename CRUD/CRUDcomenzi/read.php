<?php
    require_once "config.php";
    session_start();
    if($_SESSION['rol'] == "Client"){
        header("Location: ../../authenticate.php");
        exit();
    }
    $id = trim($_GET["id"]);
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
                    <h1 class="mt-5 mb-3">Vizualizare Comanda [#<?php echo $id ?>]</h1>
                    <table class="table table-hover cart">
                    <thead style=" text-align:center;">
                        <tr>				
                            <th width="20%">Produs</th>
							<th width="20%">Denumire</th>
                            <th width="15%">Preț</th>
                            <th width="15%">Cantitate</th>

                            <th width="20%">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody style=" text-align:center;">
                    <?php 
                    $sqlQ = "SELECT i.*, p.* FROM produs_comanda as i LEFT JOIN produse as p ON i.id_produs = p.id WHERE i.id_comanda=?"; 
					$db = $link;
                    $stmt = $db->prepare($sqlQ); 
                    $stmt->bind_param("i", $db_id); 
                    $db_id = $id; 
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
                            	<td><?php echo "<img src='assets/images/".$item["imagine"]."'height='60px;''>"; ?></td>
                                <td><?php echo $item["nume"]; ?></td>
                                <td><?php echo $price.' '.CURRENCY; ?></td>
                                <td><?php echo $quantity; ?></td>
                            <td><?php echo $sub_total.' '.CURRENCY; 
							$curent = $item["id_comanda"];?></td>
                        </tr>
                    <?php } } ?>
                    </tbody>
                </table>
                    <p><a href="comenzi.php" class="btn btn-warning">Înapoi</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>