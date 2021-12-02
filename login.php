<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Page de connexion</title>
		<link rel="stylesheet" href="./css/style.css">
		<script src=""></script>
	</head>
	<body>
		<h1>Page de connexion</h1>
		<form method="post">
			Email : <input type="email" name="email"><br>
			Mot de passe : <input type="password" name="pwd"><br>
			<input type="submit" name="connexion" value="Connexion"><br>
		</form>
		<?php
			if(isset($_REQUEST['connexion']))
			{
				include('./config/bdd.php');
				include('./config/tools.php');
				$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);
				$email=nettoyage($lien,$_REQUEST['email']);
				$pwd=password_hash($_REQUEST['pwd'],PASWORD_DEFAULT);
				$req="SELECT * FROM users WHERE email='$email' AND pwd='$pwd'";
				$res=mysqli_query($lien,$req);
				if(!$res)
				{
					echo "Erreur SQL: $req<br>".mysqli_error($lien);
				}
				else
				{
					$nb=mysqli_num_rows($res);
					$infos=mysqli_fetch_array($res);
					if(($nb==1)and($infos['active']==1))
					{
						session_start();
						$_SESSION['idu']=$infos['idu'];
						$_SESSION['lastname']=$infos['lastname'];
						$_SESSION['firstname']=$infos['firstname'];
						$_SESSION['email']=$infos['email'];
						$_SESSION['admin']=$infos['admin'];
						mysqli_close($lien);
						header("Location: ./index.php");
					}
					else
					{
						echo "Informations incorrectes";
					}
				}
				mysqli_close($lien);
			}
		?>
		<a href="./">Accueil</a>
	</body>
</html>		