  <?php 
      include('config.php'); 
      $db = $link;
      $errors_utilizator = array();
      $errors_email = array();
      $errors_pass = array();
      $errors_pass2 = array();
      $errors_pass3 = array();
      $errors_pass4 = array();
      if(isset($_POST['reg_utilizator'])) {
          $username = mysqli_real_escape_string($db, $_POST['username']);
          $email = mysqli_real_escape_string($db, $_POST['email']);
          $parola_1 = mysqli_real_escape_string($db, $_POST['parola_1']);
          $parola_2 = mysqli_real_escape_string($db, $_POST['parola_2']);
      
          if(empty($username)) { array_push($errors_utilizator, "Numele de utilizator este obligatoriu!"); }
          if(empty($email)) { array_push($errors_email, "Email-ul este obligatoriu!"); }
          if(empty($parola_1)) { array_push($errors_pass, "Parola este obligatorie!"); }
          if(empty($parola_2)) { array_push($errors_pass2, "Parola este obligatorie"); }
          if($parola_1 != $parola_2) { array_push($errors_pass3, "Parolele nu corespund!"); }
          if(strlen($parola_1) < 5) { array_push($errors_pass4, "Parola trebuie sa aibă minim 5 caractere!"); }
      
          $utilizator_check_query = "SELECT * FROM utilizatori WHERE username='$username' OR email='$email' LIMIT 1";
          $result = mysqli_query($db, $utilizator_check_query);
          $response=array();
          $utilizator = mysqli_fetch_assoc($result);
          
      if(!preg_match("/^[a-zA-Z0-9 ]+$/",$username)) {
              array_push($errors_utilizator, "Numele de utilizator trebuie să conțină doar litere și cifre!");
          }
      
          if($utilizator) 
          {
              if($utilizator['username'] === $username) {
                  array_push($errors_utilizator, "Numele există deja. Alegeți altul.");
              }
          
              if($utilizator['email'] === $email) {
                  array_push($errors_email, "Această adresă de email a fost deja folosită.");
              }
          }
      
          if(count($errors_utilizator) == 0 && 
            count($errors_email) == 0 && 
            count($errors_pass) == 0 && 
            count($errors_pass2) == 0 && 
            count($errors_pass3) == 0 && 
            count($errors_pass4) == 0
            ) 
          {
              $password = password_hash($parola_1, PASSWORD_DEFAULT);
              $query = "INSERT INTO utilizatori (rol, username, email, parola) VALUES('Client', '$username', '$email', '$password')";
              mysqli_query($db, $query);
              $_SESSION['username'] = $username;
              $_SESSION['success'] = "V-ați logat cu succes!";
              header('location: login.php');
          }
      else{
        header('register.php');
      }
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
    <title>GBooks - Inregistrare</title>

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
  <body>

  <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3">
      <div class="container">
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
              <a href="Index.php" class="nav-link">Pagină principală</a>
            </li>
            <li class="nav-item">
              <a href="#learn" class="nav-link">Despre noi</a>
            </li>
            <li class="nav-item">
              <a href="#learn" class="nav-link">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <section class="container-register">
      <div class="row justify-content-center my-5 mx-1">
        <div class="col-md-3">
          <form class="form-container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="register-form validate-form" id="register-form">
            <div class="form-title text-center"><h4>Înregistrare</h4></div>
            <img class="img rounded mx-auto d-block" src="assets/ee.png">
            <div class="form-group validate-input mb-3  my-2">
              <input type="text" name="username" class="form-control" id="username" value="" maxlength="50" required="" placeholder="Nume utilizator">
              <span class="text-danger"><?php if (isset($errors_utilizator[0])) echo $errors_utilizator[0]; ?></span>
            </div>
            <div class="form-group validate-input mb-3">
              <input type="email" name="email" class="form-control" id="email" value="" maxlength="30" required="" placeholder="Adresă email"> 
              <span class="text-danger"><?php if (isset($errors_email[0])) echo $errors_email[0]; ?></span>
            </div>
            <div class="form-group validate-input mb-3">
              <input type="password" name="parola_1" class="form-control" id="parola_1" value="" maxlength="15" placeholder="Parolă">
              <span class="text-danger"><?php if (isset($errors_pass[0])) echo $errors_pass[0]; ?></span>
            </div>
            <div class="form-group validate-input mb-3">
              <input type="password" name="parola_2" class="form-control" id="parola_2" value="" maxlength="15" placeholder="Repetă parola"> 
              <span class="text-danger"><?php if (isset($errors_pass1q[0])) echo $errors_pass1[0]; ?></span>
            </div>
            <div class="text-center">

              <button class="btn btn-warning text-center" name = "reg_utilizator" type="submit">Înregistrează-te <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-emoji-smile" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                </svg>
              </button><br>
              <span class="text-danger"><?php if (isset($errors_pass3[0])) echo $errors_pass3[0]; ?></span><br>
              <span class="text-danger"><?php if (isset($errors_pass4[0])) echo $errors_pass4[0]; ?></span>
              
              <div class="text-center"> 
                <span class="txt1">
                  Dacă ai deja cont,
                </span>
                <a class="txt2" href="login.php">
                  autentifică-te!
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