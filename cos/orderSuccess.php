<?php 
if(empty($_REQUEST['id'])){ 
    header("Location: ../home.php"); 
} 
$order_id = base64_decode($_REQUEST['id']); 
 
require_once 'dbConnect.php'; 
 
$sqlQ = "SELECT c.*, a.* FROM comanda as c LEFT JOIN detalii_clienti as a ON a.id_client = c.id_client WHERE c.id=?"; 
$stmt = $db->prepare($sqlQ); 
$stmt->bind_param("i", $db_id); 
$db_id = $order_id; 
$stmt->execute(); 
$result = $stmt->get_result(); 
 
if($result->num_rows > 0){ 
    $orderInfo = $result->fetch_assoc(); 
}else{ 
    header("Location: home.php"); 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Status comandă</title>
<meta charset="utf-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.png">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3">
    <div class="container">
      <img class="img" src="../assets/bb.png">
      <div class="navbar-brand">GBooks</div>
      
      <button class="navbar-toggler" 
              type="button" 
              data-bs-toggle="collapse" 
              data-bs-target="#navmenu" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navmenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="../authenticate.php" class="nav-link">Pagină principală</a>
          </li>
          <li class="nav-item">
		  	<a href="../profile.php" class="nav-link bi bi-file-earmark-person">Profil</a>
          </li>
		  <li class="nav-item">
            <a href="../logout.php" class="nav-link bi bi-arrow-bar-right">Deconectare</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<div class="container">
    <h1>Status comandă</h1>
    <div class="col-12">
        <?php if(!empty($orderInfo)){ ?>
            <div class="col-md-12">
                <div class="alert alert-success">Comanda a fost plasată cu succes.</div>
            </div>
			
            <div class="row col-lg-12 ord-addr-info">
                <h4><b><div class="hdr">Date de contact </div></b></h4>
                <p><b>ID Comandă:</b> #<?php echo $orderInfo['id']; ?></p>
                <p><b>Total:</b> <?php echo $orderInfo['total'].' '.CURRENCY; ?></p>
                <p><b>Comandă plasată în:</b> <?php echo $orderInfo['plasata_in']; ?></p>
                <p><b>Nume cumpărător:</b> <?php echo $orderInfo['nume'].' '.$orderInfo['prenume']; ?></p>
                <p><b>Telefon:</b> 0<?php echo $orderInfo['telefon']; ?></p>
            </div>
			
            <div class="row col-lg-12">
                <table class="table table-hover cart">
                    <thead>
                        <tr>
                            <th width="10%"></th>
                            <th width="45%">Produs</th>
                            <th width="15%">Preț</th>
                            <th width="10%">Cantitate</th>
                            <th width="20%">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php 
                    $sqlQ = "SELECT i.*, p.* FROM produs_comanda as i LEFT JOIN produse as p ON i.id_produs = p.id WHERE i.id_comanda=?"; 
                    $stmt = $db->prepare($sqlQ); 
                    $stmt->bind_param("i", $db_id); 
                    $db_id = $order_id; 
                    $stmt->execute(); 
                    $result = $stmt->get_result(); 
                     
                    if($result->num_rows > 0){  
                        while($item = $result->fetch_assoc()){ 
                            $price = $item["pret"]; 
                            $quantity = $item["cantitate"]; 
                            $sub_total = ($price*$quantity); 
                            $image = $item["imagine"]; 
                    ?>
                            <tr>
                            <td><?php echo "<img src='../CRUD/CRUDproduse/assets/images/".$item["imagine"]."'height='170px;''>"; ?></td>
                                <td><?php echo $item["nume"]; ?></td>
                                <td><?php echo $price.' '.CURRENCY; ?></td>
                                <td><?php echo $quantity; ?></td>
                            <td><?php echo $sub_total.' '.CURRENCY; ?></td>
                        </tr>
                    <?php } } ?>
                    </tbody>
                </table>
            </div>
            
            <div class="col mb-2">
                <div class="row">
                    <div class="col-sm-12  col-md-6">
                        <a href="../home.php" class="btn btn-block btn-primary"><i class="ialeft"></i>Continuă cumpărăturile</a>
                    </div>
                </div>
            </div>
        <?php }else{ ?>
        <div class="col-md-12">
            <div class="alert alert-danger">Comanda ta a eșuat!</div>
        </div>
        <?php } ?>
    </div>
</div>
</body>
</html>