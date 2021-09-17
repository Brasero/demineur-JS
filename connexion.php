<?php

if(isset($_POST['mail']) && isset($_POST['mdp']))
	{	
		$user_query = $bdd->query('SELECT * FROM user');
		$user = $user_query->fetch();

		while($user != null)
			{	
				if ($_POST['mail'] == $user['mail'] && $_POST['mdp'] == $user['mdp'])
					{	
						$_SESSION['mail'] = $user['mail'];
						$_SESSION['mdp'] = $user['mdp'];
						$_SESSION['nom'] = $user['nom'];
						$_SESSION['prenom'] = $user['prenom'];
						$verif = true;
						break;
					}

				else
					{	
						$verif = false;
						$user = $user_query->fetch();
					}
			}

			if($verif == false)
				{	
					echo '<div>Votre mail ou mot de passe sont inconnus</div>';
				}

			elseif($verif == true)
				{	
					echo '<div>Connexion reussie</div>';
					header('location:index.php');
				}
	}

?>



<form method="post" action="index.php?page=connect">
	<input type="e-mail" name="mail" id="mail" placeholder="Adresse mail" />
	<input type="password" name="mdp" id="mdp" placeholder="Mot de passe" />
	<input type="submit" id="submit" value="Connexion" />
</form>