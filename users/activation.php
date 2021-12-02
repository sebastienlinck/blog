<?php
	session_start();
	if(!isset($_SESSION['idu']) or !isset($_SESSION['lastname']) or !isset($_SESSION['firstname']) or !isset($_SESSION['email']) or ($_SESSION['admin']==0))
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
			include('../config/tools.php');
			$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);
			
			if(isset($_REQUEST['num']) and is_numeric($_REQUEST['num']))
			{
				$num=nettoyage($lien,$_REQUEST['num']);
				$req="UPDATE users set active=1 WHERE idu='$num'";
				$res=mysqli_query($lien,$req);
				if(!$res)
				{
					echo "Erreur SQL: $req<br>".mysqli_error($lien);
				}
			}
			$req="SELECT * FROM users WHERE active=0";
			$res=mysqli_query($lien,$req);
			if(!$res)
			{
				echo "Erreur SQL: $req<br>".mysqli_error($lien);
			}
			else
			{
				echo "<table>";
				while($infos=mysqli_fetch_array($res))
				{
					$ligne="<tr>";
					$ligne.="<td>".$infos['firstname']."</td>";
					$ligne.="<td>".$infos['lastname']."</td>";
					$ligne.="<td>".$infos['email']."</td>";
					$ligne.="<td><a href='activation.php?num=".$infos['idu']."'>Activer</a></td>";
					$ligne.="</tr>";
					echo $ligne;
				}
				echo "</table>";
			}
			mysqli_close($lien);
		?>
		<a href="../">Accueil</a>
	</body>
</html>				