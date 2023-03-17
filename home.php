<?php
  require_once "config.php";
  error_reporting(0);
  session_start();
  if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
  }
  include_once 'cos/Cart.class.php'; 

  $cart = new Cart; 
  $sortare_alege = '';
  $sortare_ascdesc = 'ASC';
  if(isset($_POST['sortare_tabel'])){
    $sortare_alege =  mysqli_real_escape_string($link, $_POST['sortare_alege']);
    $sortare_ascdesc =  mysqli_real_escape_string($link, $_POST['sortare_ascdesc']);
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/x-icon" href="assets/favicon.png">
  <title>Produse</title>

  <style>

    #aa{
      background-image: url("assets/img/11.jpg");
    }
    body{
		{font-family: Arial, Helvetica, sans-serif;}
	}

    #cancel {
    width: auto;
    padding: 7px 17px;
    margin-top:15px;
    background-color: #f44336;
    }

    .imgcontainer {
    text-align: center;
    margin: 4% 20px 12px 0;
    position: relative;
    }

    .poza {
    width: 40%;
    border-radius: 50%;
    }

    span.psw {
    float: right;
    padding-top: 16px;
    }

    .modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto;
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4); 
    padding-top: 60px;
    }

    .modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; 
    border: 1px solid #888;
    width: 80%; 
    height: 70%;
    }
    .products{
        float: right;
        width: 50%;
        position: absolute;
        top: 7%;
        right: 15%;
    }

    .close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
    }
    .close:hover{
      color:red;
    }

    .animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
    }

    @-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)} 
    to {-webkit-transform: scale(1)}
    }
    
    @keyframes animatezoom {
    from {transform: scale(0)} 
    to {transform: scale(1)}
    }

    @media screen and (max-width: 300px) {
    span.psw {
        display: block;
        float: none;
    }
    }

    .btn-primary{
     z-index: 30 !important; 
    }


    .filter{
      padding-top:5px; padding-bottom: 5px;
    }
  </style>
</head>

<body class="mainbody">

  <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3">
    <div class="container">
      <img class="img" src="assets/bb.png">
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
            <a href="authenticate.php" class="nav-link">Acasă</a>
          </li>
          <li class="nav-item">
		  	<a href="profile.php" class="nav-link">Profil</a>
          </li>

          <li class="nav-item">
            <a href="home.php" class="nav-link"style="color:#2889EA;">Magazin</a>
          </li>   

		  <li class="nav-item">
        <a href="cos/viewCart.php" title="View Cart" class = "nav-link bi bi-cart">Coș  
        (<?php
        echo ($cart->total_items() > 0)?$cart->total_items().' Produse':0; ?>)</a>          
      </li>
      <li class="nav-item">
            <a href="comenzi.php" class="nav-link">Comenzi</a>
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

   <section class="text-light p-5 text-center text-sm-start" id="aa">
    <div class="container">
      <div class="d-sm-flex my-5">
      </div>
    </div>
  </section>

   <div style="background: rgba(247, 202, 24, 0.9)">
   <div class="container">
      <form action="" method="post" id="sortare">
        <div class="row justify-content-end">
          <div class="col-sm-3 filter">
              <div class="form-group">
                <select class="form-control" form="sortare" name="sortare_alege">
                    <option value="" <?php if($sortare_alege == ""){ echo " selected"; }?>>Toate categoriile</option> 
                    <option value="dezvoltare personala" <?php if($sortare_alege == "dezvoltare personala"){ echo " selected"; }?>>Dezvoltare personala</option>                             
                    <option value="dragoste" <?php if($sortare_alege == "dragoste"){ echo " selected"; }?>>Dragoste</option>
                    <option value="psihologie" <?php if($sortare_alege == "psihologie"){ echo " selected"; }?>>Psihologie</option>
                </select>
              </div>
          </div>
          <div class="col-sm-3  filter">
              <div class="form-group">
                <select class="form-control" form="sortare" name="sortare_ascdesc">  
                    <option value="alfabetic1" <?php if($sortare_ascdesc == "alfabetic1"){ echo " selected"; }?>>A-Z</option>    
                    <option value="alfabetic2" <?php if($sortare_ascdesc == "alfabetic2"){ echo " selected"; }?>>Z-A</option>                                        
                    <option value="ASC" <?php if($sortare_ascdesc == "ASC"){ echo " selected"; }?>>Preț Crescător</option>
                    <option value="DESC" <?php if($sortare_ascdesc == "DESC"){ echo " selected"; }?>>Preț Descrescător</option>
                </select>  
              </div>
          </div>
            <div class="col-sm-3  filter" style="padding-top: 8px;">
                <input type = "submit" value = "Aplică" name="sortare_tabel">
            </div>
        </div>
      </form>
  </div>

</div>

    <div class="container">
      <div class = "row my-3">
        <h1 class="text-center">Produse</h1>
        <p class="fw-light w-75 mx-auto text-center">Aici poți vizualiza toate produsele comercializate de către librăria noastră.</p>
      </div>
          <div class="row g-6 my-3">
              <?php
              include 'config.php';
                $ret = array();
                if($sortare_alege == '' && $sortare_ascdesc == 'alfabetic1')
                  $sql = "SELECT * FROM produse ORDER BY nume ASC";
                else if($sortare_alege == '' && $sortare_ascdesc == 'alfabetic2')
                  $sql = "SELECT * FROM produse ORDER BY nume DESC";   
                else if($sortare_alege == '')
                  $sql = "SELECT * FROM produse ORDER BY pret $sortare_ascdesc";
                else
                {
                  if($sortare_ascdesc == 'alfabetic1')
                    $sql = "SELECT * FROM produse WHERE categorie = '$sortare_alege' ORDER BY nume ASC";
                  else if($sortare_ascdesc == 'alfabetic2')
                    $sql = "SELECT * FROM produse WHERE categorie = '$sortare_alege' ORDER BY nume DESC";     
                  else
                    $sql = "SELECT * FROM produse WHERE categorie = '$sortare_alege' ORDER BY pret $sortare_ascdesc";
                }
                $res = mysqli_query($link, $sql);

                while($ar = mysqli_fetch_assoc($res))
                {
                    $ret[] = $ar;
                }
                $products = $ret;
                $nr = 0;
                foreach($products as $ap)
                {
                    $id = $ap['id'];
                    $name = $ap['nume'];
                    $author = $ap['autor'];
                    $price = $ap['pret'];
                    $image = $ap['imagine'];
                    $description = $ap['descriere'];
                    $stock = $ap['stoc'];
                    $nr++;
                  
                ?>
                <div class="col product-item mx-auto">
                  <div class="product-img">
                      <?php echo "<td><img src='CRUD/CRUDproduse/assets/images/".$image."'height='250px;''></td>"; ?>
                      <div>
                          <div class="row btns w-100 mx-auto text center">
                          <?php
                                  if ($stock == 0)
                                  {
                                    echo '';
                                  }
                                  else
                                  {?><span>
                            <p><a href="cos/cartAction.php?action=addToCart&id=<?php echo $id; ?>" class="btn btn-primary" role="button"><i class="fa fa-cart-plus"></i>Adaugă în coș</a></p>
                                <?php
                                }?>
                            <p type="button" class="btn btn-primary" onclick="document.getElementById('produs-<?php echo $nr ?>').style.display='block'" style="width:auto;"><i class="fa fa-binoculars"></i>Detalii</p>
                              </span></div>
                      </div>
                      <div class="product-info p-2">
                          <span class="product-type"><?php echo $author; ?></span>
                          <a href="#" class="d-block text-dark text-decoration-none py-2 product-name"><?php echo $name; ?></a>
                          <span class="product-price">
                          <?php
                          if ($stock == 0)
                          {
                            echo '<span style="color:red;">Stoc indisponibil</span>';
                          }
                          else
                          {
                          echo $price.' lei'; 
                          }?>
                        </span>
                      </div>
                  </div>
                </div>
                
                <div id="produs-<?php echo $nr ?>" class="modal">
                    <form class="modal-content animate">
                        <div class="imgcontainer">
                          <span onclick="document.getElementById('produs-<?php echo $nr ?>').style.display='none'" class="close" title="Închide">&times;</span>
                          <div class="poza">
                            <?php echo "<td><img src='CRUD/CRUDproduse/assets/images/".$image."'height='300px;'' style='box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.9), 0 6px 20px 0 rgba(0, 0, 0, 0.7);'></td>"; ?>
                          </div>
                        </div>
                        
                        <div class="products">
                                <span><h1><i><b><?php echo $name; ?></b></i></h1></span>
                                <span><b><?php echo $author; ?></b></span>
                                <span><h3><?php echo $price; ?>  lei</h3></span>
                                <div><?php echo $description; ?></div>
                                <?php
                                  if ($stock == 0)
                                  {
                                    echo '<span style="color:red;">Stoc indisponibil</span>';
                                  }
                                  else
                                  {?>
                                    <p><a href="cos/cartAction.php?action=addToCart&id=<?php echo $id; ?>" class="btn btn-primary" style="margin-top:5%; margin-left: 75%;" role="button"><i class="fa fa-cart-plus"></i>Adaugă în coș</a></p>
                                <?php
                                }?>
                        </div>
                        
                    </form>
                </div>
              <?php
              }
              ?>

          </div>
    </div>


    <footer class="p-4 bg-dark text-white text-center position-relative">
        <p class="lead">Copyright &copy; 2022 GBooks</p>

       <a href="#" class="position-absolute float-right bottom-0 end-0 mx-5 my-4">
          <i class="bi bi-arrow-up-circle h1"></i>
       </a>
    </footer>

    <script>

var modal = document.getElementById('produs');

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>