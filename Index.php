  <?php
include 'config.php';
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="assets/favicon.png">
    <title>GBooks</title>

    <style>

      #aa{
        background-image: url("assets/img/aas.jpg");
        font-family: Arial, Helvetica, sans-serif;
      }
      #cancel {
      width: auto;
      padding: 7px 17px;
      }

      .imgcontainer {
      text-align: center;
      margin: 7% 20% 6% 0;
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
      height: 75%;
      }
      .products{
          float: right;
          width: 50%;
          position: absolute;
          top: 5%;
          right: 20%;
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
        <a href="Index.php" class="navbar-brand">GBooks</a>
        <button class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navmenu" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navmenu">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a href="login.php" class="nav-link"><i class="bi bi-person-circle"></i> Intră în cont</a>
            </li>
            <li class="nav-item">
              <a href="#despre" class="nav-link">Despre noi</a>
            </li>
            <li class="nav-item">
              <a href="#contact" class="nav-link bi bi-telephone">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

  <div>
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="assets/img/afis3.jpg" class="d-block w-100">
        </div>
        <div class="carousel-item">
          <img src="assets/img/afis1.jpg" class="d-block w-100">
        </div>
        <div class="carousel-item">
          <img src="assets/img/afis2.jpg" class="d-block w-100">
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
    <div style="background: rgba(247, 202, 24, 0.9); padding: 8px" >
    <div class="container">
        <form action="" method="post" id="sortare">
          <div class="row d-flex justify-content-end">
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
            <div class="row g-6 my-5">
                <?php

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
                      $nr++;
                    
                  ?>
                  <div class="col product-item mx-auto">
                    <div class="product-img">
                        <?php echo "<td><img src='CRUD/CRUDproduse/assets/images/".$image."'height='250px;''></td>"; ?>
                        <div>
                            <div class="row btns w-100 mx-auto text center">
                              <p type="button" class="btn btn-primary" onclick="document.getElementById('produs-<?php echo $nr ?>').style.display='block'" style="width:auto;"><i class="fa fa-binoculars"></i>Detalii</p>
                            </div>
                        </div>
                        <div class="product-info p-2">
                            <span class="product-type"><?php echo $author; ?></span>
                            <a href="#" class="d-block text-dark text-decoration-none py-2 product-name"><?php echo $name; ?></a>
                            <span class="product-price"><?php echo $price; ?>  lei</span>
                            
                        </div>
                    </div>
                  </div>
                  
                  <div id="produs-<?php echo $nr ?>" class="modal">
                      <form class="modal-content animate">
                          <div class="imgcontainer">
                            <div class="poza">
                              <?php echo "<td><img src='CRUD/CRUDproduse/assets/images/".$image."'height='300px;'' style='box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.9), 0 6px 20px 0 rgba(0, 0, 0, 0.7);'></td>"; ?>
                            </div>
                          </div>
                          
                          <div class="products">
                                  <span><h1><i><b><?php echo $name; ?></b></i></h1></span><br>
                                  <span><b><?php echo $author; ?></b></span><br>
                                  <span><h3><?php echo $price; ?>  lei</h3></span>
                                  <div><?php echo $description; ?></div>
                          </div>

                          <div class="container">
                            <p type="button" onclick="document.getElementById('produs-<?php echo $nr ?>').style.display='none'" class="btn btn-primary" id = "cancel">Închide</p>
                          </div>
                      </form>
                  </div>
                <?php
                }
                ?>

            </div>
      </div>

      <section id="despre" class="p-5 bg-dark text-light">
        <div class="container">
          <div class="row align-items-center justify-content-between">
            <div class="col-md p-5">
              <h2>Despre noi</h2>
              <p class="lead">
                Bine ai venit pe site-ul librăriei <span style="color:yellow;">GBooks!</span>
                Ne bucurăm să te vedem aici.<br>
                Compania noastră a fost înființată în anul 2022, cu scopul de a oferi spre vânzare o varietate de cărți pentru orice categorie de vârstă.
              </p>
              <p>
                Pagina noastră se află în continuă dezvoltare, dar încercăm să venim cu actualizări cât de frecvent posibil.<br>
                Te așteptăm cu comenzi deoarece știm că vei găsi ceea ce cauți pe site-ul nostru!
             </p>
            </div>
            <div class="col-md">
              <img src="assets/img/info.jpg" class="imd-fluid" style = "width: 300px, width: 20px">
            </div>
          </div>
        </div>
      </section>

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
        <script>
          var modal = document.getElementsByClassName('modal');
              window.onclick = function(event) {
                  if (event.target == modal) {
                      modal.style.display = "none";
                  }
              }
        </script>
      <footer class="p-4 bg-dark text-white text-center position-relative">
        <div class="container">
          <p class="lead">Copyright &copy; 2022 GBooks</p>

          </a>
        </div>
      </footer>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
  </html>