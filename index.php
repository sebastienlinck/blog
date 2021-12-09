<?php
	session_start();
	if(!isset($_SESSION['idu']) or !isset($_SESSION['lastname']) or !isset($_SESSION['firstname']) or !isset($_SESSION['email']))
	{
		$connected=false;
	}
	else
	{
		$connected=true;
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
		<div id="page">
			<h1>Blog d'actualités</h1>
			<?php
				if(!$connected)
				{
					echo '<a href="users/registration.php">S\'inscrire</a><br>';
					echo '<a href="connection.php">Se connecter</a><br>';
				}
				else 
				{
					echo '<a href="news/news-add.php">Ajout d\'une actualité</a><br>';
					echo '<a href="users/disconnection.php">Se déconnecter</a><br>';
					if($_SESSION['admin']==1)
					{
						echo '<a href="users/activation.php">Activation des users</a><br>';
					}
				}
				include('config/bdd.php');
				$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);
				$req="SELECT * FROM news ORDER BY date DESC";
				$res=mysqli_query($lien,$req);
				if(!$res)
				{
					echo "Erreur SQL: $req<br>".mysqli_error($lien);
				}
				else
				{
					echo "<table border=1>";
					while($infos=mysqli_fetch_assoc($res))
					{
						$ligne="<tr>";
						$ligne.="<td>".$infos['date']."</td>";
						$ligne.="<td><a href='news/news-view.php?num=".$infos['idn']."'>".$infos['title']."</a></td>";
						if(($connected) and (($_SESSION['idu']==$infos['author']) or ($_SESSION['admin']==1)))
						{
							$ligne.="<td><a href='news/news-edit.php?num=".$infos['idn']."'>Modifier</a></td>";
							$ligne.="<td><a href='news/news-remove.php?num=".$infos['idn']."'>Supprimer</a></td>";
						}
						$ligne.="</tr>";
						echo $ligne;
					}
					echo "</table>";
				}
				mysqli_close($lien);
			?>
		</div>
	</body>
</html>			