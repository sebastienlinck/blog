<?php
	session_start();
	if(!isset($_SESSION['idm']) or !isset($_SESSION['nom']) or !isset($_SESSION['prenom']) or !isset($_SESSION['email']) or ($_SESSION['admin']==0))
	{
		header("Location: ../index.php");
		exit;
	}
?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Activation des membres</title>
		<link rel="stylesheet" href="css/style.css">
		<script src=""></script>
	</head>
	<body>
		<h1>Activation des membres</h1>
		<?php
			include('../config/bdd.php');
			include('../config/outils.php');
			$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);
			
			if(isset($_REQUEST['num']))
			{
				$num=nettoyage($lien,$_REQUEST['num']);
				$req="UPDATE membres set actif=1 WHERE idm='$num'";
				$res=mysqli_query($lien,$req);
				if(!$res)
				{
					echo "Erreur SQL: $req<br>".mysqli_error($lien);
				}
			}
			$req="SELECT * FROM membres WHERE actif=0";
			$res=mysqli_query($lien,$req);
			if(!$res)
			{
				echo "Erreur SQL: $req<br>".mysqli_error($lien);
			}
			else
			{
				echo "<table border=1>";
				while($tableau=mysqli_fetch_array($res))
				{
					$ligne="<tr>";
					$ligne.="<td>".$tableau['prenom']."</td>";
					$ligne.="<td>".$tableau['nom']."</td>";
					$ligne.="<td>".$tableau['email']."</td>";
					$ligne.="<td><a href='activation.php?num=".$tableau['idm']."'>Activer</a></td>";
					$ligne.="</tr>";
					echo $ligne;
				}
				echo "</table>";
			}
			mysqli_close($lien);
		?>
		<a href="../index.php">Accueil</a>
	</body>
</html>				