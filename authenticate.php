<?php
  session_start();
  if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
  }

  include_once 'cos/Cart.class.php'; 

  $cart = new Cart; 
  
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
    <title>GBooks</title>

    <style>
      @import url(http://fonts.googleapis.com/css?family=Raleway:400,700);

      #aa{
        background-image: url("assets/img/aas.jpg");
      }
      .fa-stack{
        -ms-transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg); 
        transform: rotate(-45deg);
        margin: -1em;
      }
      .fa-tag{
        color:#f03232;
      }
      .fa-inverse{
        font-size:11px;
        font-weight:600;
        -ms-transform: rotate(45deg);
        -webkit-transform: rotate(45deg); 
        transform: rotate(45deg);
      }

    </style>
  </head>

  <body class="mainbody">

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3">
      <div class="container">
        <img class="img" src="assets/bb.png">
        <div class="navbar-brand">Bună <i><?php echo $_SESSION['username'] . ',';?> </i>bine ai venit la <span class="text-warning">GBooks!</span>
      </div>
        
        <button class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navmenu" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navmenu">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a href="authenticate.php" class="nav-link"style="color:#2889EA;">Acasă</a>
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
              <a href="comenzi.php" class="nav-link">Comenzi</a>
            </li>   

          <li class="nav-item">
              <a href="#contact" class="nav-link">Contact</a>
            </li>
        
        <li class="nav-item">
              <a href="logout.php" class="nav-link bi bi-arrow-bar-right"style="color:#B72E10;">Deconectare</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="assets/img/afis1.jpg" class="d-block w-100">
        </div>
        <div class="carousel-item">
          <img src="assets/img/afis2.jpg" class="d-block w-100">
        </div>
        <div class="carousel-item">
          <img src="assets/img/afis4.jpg" class="d-block w-100">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>


    <div class="container">
    <a class="btn btn-warning btn-lg" style = "margin-top: 35px" href="home.php" role="button">Vezi toate produsele <i class="bi bi-arrow-right"></i></a>
        <div class = "row my-3">
          <h1 class="text-center"></h1>
        </div>
        <h4>Nu rata cele mai recent apărute cărți pe site-ul nostru!</h4>
            <div class="row g-6 my-3">
              <?php
                    function get_product_details()
                    {
                        include("config.php");
                        $ret = array();
                        $sql = "SELECT * FROM produse ORDER BY id DESC LIMIT 4";
                        $res = mysqli_query($link, $sql);

                        while($ar = mysqli_fetch_assoc($res))
                        {
                            $ret[] = $ar;
                        }
                        return $ret;
                    }
                        $products = get_product_details();
                        foreach($products as $ap)
                        {
                            $id = $ap['id'];
                            $name = $ap['nume'];
                            $author = $ap['autor'];
                            $description = $ap['descriere'];
                            $price = $ap['pret'];
                            $image = $ap['imagine'];
                        ?>
                  <div class="col product-item mx-auto ">
                  <div class="product-img d-flex justify-content-center">
                    
                      <?php echo "<td><img src='CRUD/CRUDproduse/assets/images/".$image."' height='250px;''></td>"; ?>
                      
                    <div class="product-info p-2">
                      
                    <span class="fa-stack fa-lg">
                      <i class="fa fa-tag fa-stack-2x"></i>
                      <i class="fa fa-stack-1x fa-inverse">NOU!</i>
                    </span><br>
                        <span><b><?php echo $author; ?></b></span>
                        <span class="d-block text-dark text-decoration-none py-2 product-name"><?php echo $name; ?></span>
                        <span style = "font-weight: bold; color: red"><?php echo $price; ?>  lei</span>

                    </div>
                    
                </div>
                <p><a href="cos/cartAction.php?action=addToCart&id=<?php echo $id; ?>" class="btn btn-primary" role="button" style = "margin: -10px 0 0 11em;">Cumpără</a></p>

                </div>
                <?php
                }
                ?>

            </div>
      </div>
        </div>

      <section class="p-5 justify-content-center" id="contact">
        <div class="container justify-content-center">
          <div class="row g-4">
            <div class="col-md">
              <h2 class="text-center mb-4">Contact</h2>
              <ul class="list-group list-group-flush lead">
                <li class="list-group-item text-center">
                  <span class="fw-bold">Adresă:</span> Bistrița, Subcetate nr. 7
                </li>
                <li class="list-group-item text-center">
                  <span class="fw-bold">Număr de telefon:</span> 0742564875
                </li>
                <li class="list-group-item text-center">
                  <span class="fw-bold">Email:</span> libraria.gbooks@yahoo.com
                </li>
              </ul>
            </div>
            <div class="col-md my-3">
            <div class="mapouter"><div class="gmap_canvas"><iframe width="450" height="356" id="gmap_canvas" src="https://maps.google.com/maps?q=Subcetate%20nr%207&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://123movies-to.org"></a><br><style>.mapouter{position:relative;text-align:right;height:396px;width:475px;}</style><a href="https://www.embedgooglemap.net"></a><style>.gmap_canvas {overflow:hidden;background:none!important;height:396px;width:475px;}</style></div></div>  </body>
            </div>
          </div>
        </div>
      </section>
      
      <footer class="p-4 bg-dark text-white text-center position-relative">
        <div class="container">
          <p class="lead">Copyright &copy; 2022 GBooks</p>
          </a>
        </div>
      </footer>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    
  </body>
  </html>





    
