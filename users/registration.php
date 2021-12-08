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
			Courriel : <input type="email" name="email1" required><br>
			Confirmation : <input type="email" name="email2" required><br>
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
				$email1=nettoyage($lien,$_REQUEST['email1']);
				$email2=nettoyage($lien,$_REQUEST['email2']);
				$pwd1=$_REQUEST['pwd1'];
				$pwd2=$_REQUEST['pwd2'];
				
				if (($pwd1==$pwd2) and ($email1==$email2))
				{
					$req="SELECT * FROM users WHERE email='$email1'";
					$res=mysqli_query($lien,$req);
					if(!$res)
					{
						echo "Erreur SQL: $req<br>".mysqli_error($lien);
					}
					else
					{
						$existe=mysqli_num_rows($res);
						if (($existe==0) and ($pwd1==$pwd2))
						{
							$pwd=password_hash($pwd1, PASSWORD_DEFAULT);
							$req="INSERT INTO users VALUES(NULL,'$firstname','$lastname','$email1','$pwd',0,0)";
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
					echo "Les mots de passe ou les courriels sont différents<br>";
				}
				mysqli_close($lien);
			}
		?>
		<a href="../">Accueil</a>
	</body>
</html>