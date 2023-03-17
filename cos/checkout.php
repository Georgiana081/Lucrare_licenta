<?php 
require_once 'config.php'; 
 
include_once 'Cart.class.php'; 
$cart = new Cart; 
 
if($cart->total_items() <= 0){ 
    header("Location: home.php"); 
} 
 
$postData = !empty($_SESSION['postData'])?$_SESSION['postData']:array(); 
unset($_SESSION['postData']); 
 
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:''; 
if(!empty($sessData['status']['msg'])){ 
    $statusMsg = $sessData['status']['msg']; 
    $statusMsgType = $sessData['status']['type']; 
    unset($_SESSION['sessData']['status']); 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Finalizare comandă</title>
<meta charset="utf-8">

<link href="css/bootstrap.min.css" rel="stylesheet">

<link href="css/style.css" rel="stylesheet">
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
      <a href="#" class="navbar-brand">GBooks</a>
      
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
    <h1>Finalizare comandă</h1>
    <div class="col-12">
        <div class="checkout">
            <div class="row">
                <?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
                <div class="col-md-12">
                    <div class="alert alert-success"><?php echo $statusMsg; ?></div>
                </div>
                <?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
                <div class="col-md-12">
                    <div class="alert alert-danger"><?php echo $statusMsg; ?></div>
                </div>
                <?php } ?>
				
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Coșul tău</span>
                        <span class="badge badge-secondary badge-pill"><?php echo $cart->total_items(); ?></span>
                    </h4>
                    <ul class="list-group mb-3">
                    <?php 
                    if($cart->total_items() > 0){ 
                        $cartItems = $cart->contents(); 
                        foreach($cartItems as $item){ 
                    ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0"><?php echo $item["nume"]; ?></h6>
                                <small class="text-muted"><?php echo $item["pret"]; ?>(<?php echo $item["qty"]; ?>)</small>
                            </div>
                            <span class="text-muted"><?php echo $item["subtotal"]; ?></span>
                        </li>
                    <?php } } ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (<?php echo CURRENCY; ?>)</span>
                            <strong><?php echo $cart->total(); ?></strong>
                        </li>
                    </ul>
                    <a href="../home.php" class="btn btn-sm btn-info">+ adaugă produse</a>
                </div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Detalii contact</h4>
                    <form method="post" action="cartAction.php">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nume">Nume</label>
                                <input type="text" class="form-control" name="nume" value="<?php echo !empty($postData['nume'])?$postData['nume']:''; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prenume">Prenume</label>
                                <input type="text" class="form-control" name="prenume" value="<?php echo !empty($postData['prenume'])?$postData['prenume']:''; ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="telefon">Telefon</label>
                            <input type="number" class="form-control" name="telefon" value="<?php echo !empty($postData['telefon'])?$postData['telefon']:''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="judet">Județ</label>
                            <input type="text" class="form-control" name="judet" value="<?php echo !empty($postData['judet'])?$postData['judet']:''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="oras">Oraș</label>
                            <input type="text" class="form-control" name="oras" value="<?php echo !empty($postData['oras'])?$postData['oras']:''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="strada">Stradă</label>
                            <input type="text" class="form-control" name="strada" value="<?php echo !empty($postData['strada'])?$postData['strada']:''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="numar">Număr</label>
                            <input type="number" class="form-control" name="numar" value="<?php echo !empty($postData['numar'])?$postData['numar']:''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="apartament">Apartament</label>
                            <input type="number" class="form-control" name="apartament" value="<?php echo !empty($postData['apartament'])?$postData['apartament']:''; ?>" required>
                        </div>
                        <input type="hidden" name="action" value="placeOrder"/>
                        <input class="btn btn-success btn-block" type="submit" name="checkoutSubmit" value="Plasează comandă">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>