<?php 
require_once 'config.php'; 
session_start();
if (!isset($_SESSION['loggedin'])) {
header('Location: login.php');
exit;
}
include_once 'Cart.class.php'; 

$cart = new Cart; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Coș de cumpărături</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/favicon.png">



    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

    <script src="js/jquery.min.js"></script>

    <script>
    function updateCartItem(obj,id){
        $.get("cartAction.php", {action:"updateCartItem", id:id, qty:obj.value}, function(data){
            if(data == 'ok'){
                location.reload();
            }else{
                alert('Cart update failed, please try again.');
            }
        });
    }
    </script>
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
            <a href="../authenticate.php" class="nav-link">Acasă</a>
          </li>
          <li class="nav-item">
		  	<a href="../profile.php" class="nav-link">Profil</a>
          </li>

          <li class="nav-item">
            <a href="../home.php" class="nav-link">Magazin</a>
          </li>   

		  <li class="nav-item">
        <a href="" title="View Cart" class = "nav-link bi bi-cart" style="color:#2889EA;">Coș  
        (<?php
        echo ($cart->total_items() > 0)?$cart->total_items().' Produse':0; ?>)</a>          
      </li>
      <li class="nav-item">
            <a href="../comenzi.php" class="nav-link">Comenzi</a>
          </li>  
      <li class="nav-item">
            <a href="../authenticate.php#contact" class="nav-link">Contact</a>
          </li>
		  <li class="nav-item">
            <a href="../logout.php" class="nav-link bi bi-arrow-bar-right"style="color:#B72E10;">Deconectare</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<div class="container">
    <br>
    <h1>Coș de cumpărături</h1>
    <div class="row">
        <div class="cart">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped cart">
                        <thead>
                            <tr>
                                <th width="10%"></th>
                                <th width="35%">Produs</th>
                                <th width="15%">Preț</th>
                                <th width="15%">Cantitate</th>
                                <th width="15%"></th>
                                <th width="20%">Șterge</th>
                                <th width="5%"> </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if($cart->total_items() > 0){ 
                            $cartItems = $cart->contents(); 
                            foreach($cartItems as $item){ 
                                
                        ?>
                            <tr>
                                <td><?php echo "<img src='../CRUD/CRUDproduse/assets/images/".$item["imagine"]."'height='150px;''>"; ?></td>
                                <td><?php echo $item["nume"]; ?></td>
                                <td><?php echo $item["pret"].' '.CURRENCY; ?></td>
                                <td><input class="form-control" type="number" value="<?php echo $item["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $item['rowid']; ?>')"/></td>
                                <td></td>
                                <td><a class="btn btn-sm btn-danger" href='cartAction.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>'><i class="itrash"></i>X</a></td>
                            </tr>
                        <?php } }else{ ?>
                            <tr><td colspan="6"><p>Coșul tău este gol...</p></td>
                        <?php } ?>
                        <?php if($cart->total_items() > 0){ ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>Total coș</strong></td>
                                <td><strong><?php echo $cart->total().' '.CURRENCY; ?></strong></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col mb-2">
                <div class="row">
                    <div class="col-sm-12  col-md-6">
                        <a href="../home.php" class="btn btn-block btn-warning"><i class="ialeft"></i>Continuă cumpărăturile</a>
                    </div>
                    <div class="col-sm-12 col-md-6 text-right"><br>
                        <?php if($cart->total_items() > 0){ ?>
                        <a href="checkout.php" class="btn btn-block btn-primary" style = "float:right;">Finalizează comanda<i class="iaright"></i></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

</body>
</html>