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
			include('../config/outils.php');			
			$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);
			$num=nettoyage($lien,$_REQUEST['num']);
			$req="SELECT * FROM actus WHERE ida=$num";
			$res=mysqli_query($lien,$req);
			
			if(!$res)
			{
				echo "Erreur SQL: $req<br>".mysqli_error($lien);
			}
			else
			{
				$tableau=mysqli_fetch_assoc($res);
				echo "<h1>".$tableau['titre']."</h1>";
				echo "<h2>".$tableau['auteur']."</h2>";
				echo "<p>".$tableau['contenu']."</p>";
				echo "<img src='".$tableau['image']."'><br>";
				echo "<p>".$tableau['date']."</p>";
			}
			
			mysqli_close($lien);
		?>
		<a href="../index.php">Retour à l'accueil</a>
	</body>
</html>			