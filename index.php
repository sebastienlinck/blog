<?php
	session_start();
	if(!isset($_SESSION['idm']) or !isset($_SESSION['nom']) or !isset($_SESSION['prenom']) or !isset($_SESSION['email']))
	{
		$connecte=false;
	}
	else
	{
		$connecte=true;
	}
?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Blog d'actualités</title>
		<link rel="stylesheet" href="css/style.css">
		<script src=""></script>
	</head>
	<body>
		<h1>Blog d'actualités</h1>
		<?php
			if($connecte==false)
			{
				echo '<a href="membres/inscription.php">S\'inscrire</a><br>';
				echo '<a href="login.php">Se connecter</a><br>';
			}
			else 
			{
				echo '<a href="actus/ajout-actus.php">Ajout d\'une actualité</a><br>';
				echo '<a href="membres/deconnexion.php">Se déconnecter</a><br>';
				if($_SESSION['admin']==1)
				{
					echo '<a href="membres/activation.php">Activation des membres</a><br>';
				}
			}
			include('config/bdd.php');
			$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);
			$req="SELECT * FROM actus ORDER BY date DESC";
			$res=mysqli_query($lien,$req);
			if(!$res)
			{
				echo "Erreur SQL: $req<br>".mysqli_error($lien);
			}
			else
			{
				echo "<table border=1>";
				while($tableau=mysqli_fetch_assoc($res))
				{
					$ligne="<tr>";
					$ligne.="<td>".$tableau['date']."</td>";
					$ligne.="<td><a href='actus/details-actus.php?num=".$tableau['ida']."'>".$tableau['titre']."</a></td>";
					if(($connecte==true)and(($_SESSION['idm']==$tableau['auteur'])or($_SESSION['admin']==1)))
					{
						$ligne.="<td><a href='actus/modif-actus.php?num=".$tableau['ida']."'>Modifier</a></td>";
						$ligne.="<td><a href='actus/suppr-actus.php?num=".$tableau['ida']."'>Supprimer</a></td>";
					}
					$ligne.="</tr>";
					echo $ligne;
				}
				echo "</table>";
			}
			mysqli_close($lien);
		?>
	</body>
</html>			