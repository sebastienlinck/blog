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
		<title>Modification d'une actualité</title>
		<link rel="stylesheet" href="../css/style.css">
	</head>
	<body>
		<div id="page">
			<h1>Modification d'une actualité</h1>
			<?php
				include('../config/bdd.php');				
				include('../config/tools.php');
				$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);
				$num=nettoyage($lien,$_REQUEST['num']);
				if(isset($_REQUEST['modifier']))
				{
					$title=nettoyage($lien,$_REQUEST['title']);
					$content=nettoyage($lien,$_REQUEST['content']);
					if($_FILES['image']['name']=="")
					{
						$req="UPDATE news SET title='$title',content='$content' WHERE idn=$num";
					}
					else
					{
						$extensionsvalides=array('gif','jpg','png','jpeg','svg');
						$extension=strtolower(substr(strrchr($_FILES['image']['name'],"."),1));
						if(in_array($extension,$extensionsvalides))
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
						if($destination=="")
						{
							$req="UPDATE news SET title='$title',content='$content' WHERE idn=$num";
						}
						else
						{
							$req="UPDATE news SET title='$title',content='$content',image='$destination' WHERE idn=$num";
						}
					}
					$res=mysqli_query($lien,$req);
					if(!$res)
					{
						echo "Erreur SQL: $req<br>".mysqli_error($lien);
						unlink($destination);
					}
					else
					{
						echo "Actualité modifiée<br>";
						if(($_REQUEST['ancienneimage']!="")and($_FILES['image']['name']!=""))
						{
							unlink($_REQUEST['ancienneimage']);
						}
					}
				}
				$req="SELECT * FROM news WHERE idn=$num";
				$res=mysqli_query($lien,$req);
				if(!$res)
				{
					echo "Erreur SQL: $req<br>".mysqli_error($lien);
				}
				else
				{
					$infos=mysqli_fetch_array($res);
					if(($infos['author']!=$_SESSION['idu'])and($_SESSION['admin']==0))
					{
						mysqli_close($lien);
						header("Location: ../index.php");
						exit;
					}
				?>
				<form method="post" enctype="multipart/form-data">
					<label>Titre : </label><input type="text" name="title" value="<?php echo $infos['title'];?>"><br>
					<label>Contenu : </label><textarea name="content"><?php echo $infos['content'];?></textarea><br>
					<label>Ancienne image : </label><img src="<?php echo $infos['image'];?>"><br>
					<label>Nouvelle image : </label><input type="file" name="image"><br>
					<input type="hidden" name="num" value="<?php echo $num;?>">
					<input type="hidden" name="ancienneimage" value="<?php echo $infos['image'];?>">
					<input type="submit" name="modifier" value="Modifier l'actualité"><br>
				</form>
				<?php
				}
				mysqli_close($lien);
			?>
			<a href="../">Accueil</a>
		</div>
	</body>
</html>	