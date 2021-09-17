<?php 
session_start();

try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=demineur', 'root', '');
	}

catch(PDOException $fail)
	{
		print 'Erreur : ' . $fail->getMessage();
		die();
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/index.css" />
		<title>Démineur</title>
	</head>

	<body>
		<header>
			<span id="logo">
			</span>
			<h1>
				Démineur
			</h1>
			<nav>
				<ul>
					<?php
						if(isset($_SESSION['mail']))
							{	
								echo '<div>'.$_SESSION['nom'].', '.$_SESSION['prenom'].'</div>';
								echo '<div><li><a href="deconnexion.php">Deconnexion</a></li>';
								echo '<li><a href="">Profil</a></li></div>';
							}

						else
							{	
								echo '<div><li><a href="index.php?page=connect">Connexion</a></li>';
								echo '<li><a href="index.php?page=signin">Inscription</a></li></div>';
							}
					?>
				</ul>
			</nav>
		</header>
			<?php
				if(isset($_GET['page']))
					{	
						if($_GET['page'] == 'signin')
							{	
								include('inscription.php');
							}

						elseif($_GET['page'] == 'connect')
							{
								include('connexion.php');
							}

						
					}

				if(isset($_SESSION['mail']))
					{	
						include('demineur.php');
					}
			?>
		<footer>

		</footer>