<?php
	session_start();
	if(!isset($_SESSION['idu']) or !isset($_SESSION['lastname']) or !isset($_SESSION['firstname']) or !isset($_SESSION['email']))
	{
		header("Location: ../index.php");
	}
?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Ajout d'une actualité</title>
		<link rel="stylesheet" href="../css/style.css">
		<script src=""></script>
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
				if(isset($_REQUEST['ajouter']))
				{
					include('../config/bdd.php');
					include('../config/tools.php');
					$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);				
					$title=nettoyage($lien,$_REQUEST['title']);
					$content=nettoyage($lien,$_REQUEST['content']);
					$author=$_SESSION['idu'];
					$date=date("Y-m-d H:i:s");
					$extensionsvalides=array('gif','jpg','png','jpeg','svg');
					$extension=strtolower(substr(strrchr($_FILES['image']['name'],"."),1));
					if(in_array($extension, $extensionsvalides))
					{
						$destination="../images/".uniqid().".$extension";
						$envoi=move_uploaded_file($_FILES['image']['tmp_name'],$destination);
						if(!$envoi)
						{
							echo "Erreur de transfert<br>";
							$destination="";
						}
					}
					else
					{
						echo "Pas d'image ou image invalide<br>";
						$destination="";
					}
					$req="INSERT INTO news VALUES(NULL,'$title','$content','$author','$date','$destination')";
					$res=mysqli_query($lien,$req);
					
					if(!$res)
					{
						echo "Erreur SQL: $req<br>".mysqli_error($lien);
					}
					else
					{
						echo "Actualité ajoutée<br>";
					}
					
					mysqli_close($lien);
				}
			?>
			<a href="../index.php">Accueil</a>
		</div>
	</body>
</html>