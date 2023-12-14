<!doctype html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<title>Actualité</title>
	<link rel="stylesheet" href="../css/style.css">
</head>

<body>
	<div id="page">
		<?php
		include('../config/bdd.php');
		include('../config/tools.php');
		$lien = mysqli_connect(SERVEUR, LOGIN, MDP, BASE);
		$num = nettoyage($lien, $_REQUEST['num']);
		$req = "SELECT * FROM news INNER JOIN users ON news.author=users.idu WHERE idn=$num ";
		$res = mysqli_query($lien, $req);
		if (!$res) {
			echo "Erreur SQL: $req<br>" . mysqli_error($lien);
		} else {
			$infos = mysqli_fetch_assoc($res);
			$html = "<h1>" . $infos['title'] . "</h1>";
			$html .= "<h2>" . $infos['firstname'] . " " . $infos['firstname'] . "</h2>";
			$html .= "<p>" . $infos['content'] . "</p>";
			$html .= "<img src='" . $infos['image'] . "'><br>";
			$html .= "<p>" . $infos['date'] . "</p>";
			echo $html;
		}
		mysqli_close($lien);
		?>
		<a href="../">Retour à l'accueil</a>
	</div>
</body>

</html>