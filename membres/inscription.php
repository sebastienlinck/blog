<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Inscription</title>
		<link rel="stylesheet" href="../css/style.css">
		<script src=""></script>
	</head>
	<body>
		<h1>Inscription</h1>
		<form method="post" enctype="multipart/form-data">
			Nom : <input type="text" name="nom"><br>
			Prénom : <input type="text" name="prenom"><br>
			Email : <input type="email" name="email"><br>
			Mot de passe : <input type="password" name="mdp1"><br>
			Confirmation : <input type="password" name="mdp2"><br>
			<input type="submit" name="inscription" value="Inscription"><br>
		</form>
		<?php
			if(isset($_REQUEST['inscription']))
			{
				include('../config/bdd.php');
				include('../config/outils.php');
				$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);
				$nom=nettoyage($lien,$_REQUEST['nom']);
				$prenom=nettoyage($lien,$_REQUEST['prenom']);
				$email=nettoyage($lien,$_REQUEST['email']);
				$mdp1=md5($_REQUEST['mdp1']);
				$mdp2=md5($_REQUEST['mdp2']);
				
				if($mdp1==$mdp2)
				{
					$req="SELECT * FROM membres WHERE email='$email'";
					$res=mysqli_query($lien,$req);
					if(!$res)
					{
						echo "Erreur SQL: $req<br>".mysqli_error($lien);
					}
					else
					{
						$nb=mysqli_num_rows($res);
						if($nb==0)
						{
							$req="INSERT INTO membres VALUES(NULL,'$email','$nom','$prenom','$mdp1',0,0)";
							$res=mysqli_query($lien,$req);
							if(!$res)
							{
								echo "Erreur SQL: $req<br>".mysqli_error($lien);
							}
							else
							{
								echo "Inscription réussie<br>";
							}
						}
						else 
						{
							echo "Adresse email déjà utilisée<br>";
						}
					}	
				}
				else
				{
					echo "Les mots de passe sont différents<br>";
				}
				mysqli_close($lien);
			}
		?>
		<a href="../index.php">Accueil</a>
	</body>
</html>