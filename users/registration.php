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
		<form method="post">
			Nom : <input type="text" name="lastname" required><br>
			Prénom : <input type="text" name="firstname" required><br>
			Email : <input type="email" name="email" required><br>
			Mot de passe : <input type="password" name="pwd1" required><br>
			Confirmation : <input type="password" name="pwd2" required><br>
			<input type="submit" name="inscription" value="Inscription"><br>
		</form>
		<?php
			if(isset($_REQUEST['inscription']))
			{
				include('../config/bdd.php');
				include('../config/tools.php');
				$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);
				$lastname=nettoyage($lien,$_REQUEST['lastname']);
				$firstname=nettoyage($lien,$_REQUEST['firstname']);
				$email=nettoyage($lien,$_REQUEST['email']);
				$pwd1=password_hash($_REQUEST['pwd1'],PASWORD_DEFAULT);
				$pwd2=password_hash($_REQUEST['pwd2'],PASWORD_DEFAULT);
				
				if($pwd1==$pwd2)
				{
					$req="SELECT * FROM users WHERE email='$email'";
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
							$req="INSERT INTO users VALUES(NULL,'$email','$lastname','$firstname','$pwd1',0,0)";
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
		<a href="../">Accueil</a>
	</body>
</html>