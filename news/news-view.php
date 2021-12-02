<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Actualité</title>
		<link rel="stylesheet" href="../css/style.css">
		<script src=""></script>
	</head>
	<body>
		<?php
			include('../config/bdd.php');
			include('../config/tools.php');			
			$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);
			$num=nettoyage($lien,$_REQUEST['num']);
			$req="SELECT * FROM actus WHERE idn=$num";
			$res=mysqli_query($lien,$req);
			
			if(!$res)
			{
				echo "Erreur SQL: $req<br>".mysqli_error($lien);
			}
			else
			{
				$infos=mysqli_fetch_assoc($res);
				echo "<h1>".$infos['title']."</h1>";
				echo "<h2>".$infos['author']."</h2>";
				echo "<p>".$infos['content']."</p>";
				echo "<img src='".$infos['image']."'><br>";
				echo "<p>".$infos['date']."</p>";
			}
			
			mysqli_close($lien);
		?>
		<a href="../">Retour à l'accueil</a>
	</body>
</html>			