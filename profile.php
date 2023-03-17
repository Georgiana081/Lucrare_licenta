	<?php
		session_start();
		if (!isset($_SESSION['loggedin'])) {
			header('Location: Index.php');
			exit;
		}
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = '';
		$DATABASE_NAME = 'bookstore';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}

		$stmt = $con->prepare('SELECT username, parola, email FROM utilizatori WHERE id = ?');

		$stmt->bind_param('i', $_SESSION['id']);
		$stmt->execute();
		$stmt->bind_result($username, $parola, $email);
		$stmt->fetch();
		$stmt->close();


		$id = $_SESSION['id'];

		$stmt2 = $con->prepare("SELECT judet, oras, strada, numar, apartament
								FROM detalii_clienti
								WHERE id_client = $id");

		$stmt2->execute();
		$stmt2->bind_result($judet, $oras, $strada, $numar, $apartament);
		$stmt2->fetch();
		$stmt2->close();
		include_once 'cos/Cart.class.php'; 

	$cart = new Cart; 
	?>

	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>Profil</title>
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
				<a href="profile.php" class="nav-link"style="color:#2889EA;">Profil</a>
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
			<h2><b>Profil</b></h2>
			<div>
				<p><b>Detaliile contului tău:</b></p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=$username?></td>
					</tr>
					<tr>
						<td>Parola:</td>
						<td><?=$parola?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$email?></td>
					</tr>
				</table><br>
				<?php
						require_once "config.php";
						
						$sql = "SELECT * FROM utilizatori";
						if($result = mysqli_query($link, $sql)){
							if(mysqli_num_rows($result) > 0){
								echo '<a href="updateClient/updateClient.php?id='. $id .'" class="btn btn-warning my-2" style="position: relative; right:0em "></i>Modifică detalii</a>';

								mysqli_free_result($result);
							} else{
								echo '<div class="alert alert-danger"><em>Nu au fost găsite înregistrări.</em></div>';
							}
						} else{
							echo "Ups! Ceva nu a mers bine. Te rugăm îneacră din nou.";
						}

						?>

				<p><b>Adresă:</b></p>
				<table>
					<tr>
						<td>Județ:</td>
						<td><?=$judet?></td>
					</tr>
					<tr>
						<td>Oraș:</td>
						<td><?=$oras?></td>
					</tr>
					<tr>
						<td>Strada:</td>
						<td><?=$strada?></td>
					</tr>
					<tr>
						<td>Număr:</td>
						<td><?=$numar?></td>
					</tr>
					<tr>
						<td>Apartament:</td>
						<td><?=$apartament?></td>
					</tr>
				</table>
				<?php

						require_once "config.php";
						
						
						$sql = "SELECT * FROM detalii_clienti";
						if($result = mysqli_query($link, $sql)){
							if(mysqli_num_rows($result) > 0){
								echo '<a href="updateAdresaClient/updateAdresaClient.php?id='. $id .'" class="btn btn-warning my-2" style="position: relative; right:0em "></i>Modifică adresă</a>';

								mysqli_free_result($result);
							} else{
								echo '<div class="alert alert-danger"><em>Adresa se va salva în urma plasării unei comenzi.</em></div>';
							}
						} else{
							echo "Ups! Ceva nu a mers bine. Te rugăm îneacră din nou.";
						}
	
						mysqli_close($link);
						?>

				
			</div>
		</div>
		
	</body>
	</html>