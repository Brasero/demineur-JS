<?php

if(isset($_POST['mail']) && $_POST['mdp'] == $_POST['mdp_confirm'])
	{	
		$create = $bdd->query("CREATE TABLE IF NOT EXISTS demineur.user (ID INT NOT NULL AUTO_INCREMENT , nom VARCHAR(100) NOT NULL , prenom VARCHAR(100) NOT NULL , mail VARCHAR(100) NOT NULL , mdp VARCHAR(100) NOT NULL , PRIMARY KEY(ID)) ENGINE = InnoDB");

		$inser = $bdd->prepare("INSERT INTO user (nom, prenom, mail, mdp) VALUES (:nom, :prenom, :mail, :mdp)", array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

		$inser->execute(array(
							':nom' => $_POST['nom'],
							':prenom' => $_POST['prenom'],
							':mail' => $_POST['mail'],
							':mdp' => $_POST['mdp']));

		$inser->closeCursor();

		echo '<div>Enregistrement reussi !</div>';
	}


?>


<form method="post" action="index.php?page=signin">
	<input type="text" name="nom" id="nom" placeholder="Nom" />
	<input type="text" name="prenom" id="prenom" placeholder="Prenom" />
	<input type="e-mail" name="mail" id="mail" placeholder="E-mail" />
	<input type="password" name="mdp" id="mdp" placeholder="Mot de passe" />
	<input type="password" name="mdp_confirm" id="mdp_confirm" placeholder="Confirmez le mot de passe" />
	<input type="submit" name="submit" value="Inscription" />
</form>