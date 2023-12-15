<?php
session_start();
if (!isset($_SESSION['idu']) or !isset($_SESSION['lastname']) or !isset($_SESSION['firstname']) or !isset($_SESSION['email'])) {
	header("Location: ../index.php");
}
?>
<!doctype html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<title>Ajout d'une actualité</title>
	<link rel="stylesheet" href="../css/style.css">
</head>

<body>
	<div id="page">
		<h1>Ajout d'une actualité</h1>
		<form method="post" enctype="multipart/form-data">
			<label>Titre : </label><input type="text" name="title" required><br>
			<label>Contenu : </label><textarea name="content" required></textarea><br>
			<label>Image : </label><input type="file" name="image"><br>
			<input type="submit" name="ajouter" value="Ajouter l'actualité"><br>
		</form>
		<?php
		if (isset($_REQUEST['ajouter'])) {
			include('../config/bdd.php');
			include('../config/tools.php');
			$link = mysqli_connect(SERVEUR, LOGIN, MDP, BASE);
			$title = nettoyage($link, $_REQUEST['title']);
			$content = nettoyage($link, $_REQUEST['content']);
			$author = $_SESSION['idu'];
			$date = date("Y-m-d H:i:s");
			$fichier = $_FILES['image']['name'];
			$imageType = exif_imagetype($_FILES["image"]["tmp_name"]);
			$allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF];
			if (in_array($fichier, $allowedTypes)) {
				$destination = "../images/" . uniqid() . "-" . $fichier;
				$envoi = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
				if (!$envoi) {
					echo "Erreur de transfert<br>";
					$destination = "";
				}
			} else {
				echo "Pas d'image ou image invalide<br>";
				$destination = "";
			}
			$req = "INSERT INTO news VALUES(NULL,'$title','$content','$author','$date','$destination')";
			$res = mysqli_query($link, $req);
			if (!$res) {
				echo "Erreur SQL: $req<br>" . mysqli_error($link);
			} else {
				echo "Actualité ajoutée<br>";
			}
			mysqli_close($link);
		}
		?>
		<a href="../index.php">Accueil</a>
	</div>
</body>

</html>