<?php
session_start();
if (!isset($_SESSION['idu']) or !isset($_SESSION['lastname']) or !isset($_SESSION['firstname']) or !isset($_SESSION['email']) or ($_SESSION['admin'] == 0)) {
	header("Location: ../index.php");
	exit;
}
?>
<!doctype html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<title>Activation des membres</title>
	<link rel="stylesheet" href="../css/style.css">
</head>

<body>
	<div id="page">
		<h1>Activation des membres</h1>
		<?php
		include('../config/bdd.php');
		include('../config/tools.php');
		$link = mysqli_connect(SERVEUR, LOGIN, MDP, BASE);
		if (isset($_REQUEST['num']) and is_numeric($_REQUEST['num'])) {
			$num = nettoyage($link, $_REQUEST['num']);
			if (isset($_GET['ac']) and (($_GET['ac'] == 1) or ($_GET['ac'] == 0))) {
				$ac = $_GET['ac'];
			}
			if (isset($_GET['ad']) and (($_GET['ad'] == 1) or ($_GET['ad'] == 0))) {
				$ad = $_GET['ad'];
			}
			if (isset($ac) and isset($ad)) {
				$req = "UPDATE users set active=$ac,admin=$ad WHERE idu=$num";
			} else if (isset($ac)) {
				$req = "UPDATE users set active=$ac WHERE idu=$num";
			} else if (isset($ad)) {
				$req = "UPDATE users set admin=$ad WHERE idu=$num";
			}
			$res = mysqli_query($link, $req);
			if (!$res) {
				echo "Erreur SQL: $req<br>" . mysqli_error($link);
			}
		}
		$req = "SELECT * FROM users";
		$res = mysqli_query($link, $req);
		if (!$res) {
			echo "Erreur SQL: $req<br>" . mysqli_error($link);
		} else {
			echo "<table>";
			while ($infos = mysqli_fetch_array($res)) {
				$ligne = "<tr>";
				$ligne .= "<td>" . $infos['firstname'] . "</td>";
				$ligne .= "<td>" . $infos['lastname'] . "</td>";
				$ligne .= "<td>" . $infos['email'] . "</td>";
				$ligne .= "<td>" . $infos['active'] . "</td>";
				if ($infos['active'] == 0) {
					$ligne .= "<td class='shorttd'><a href='activation.php?num=" . $infos['idu'] . "&ac=1'>Inactif</a></td>";
				} else {
					$ligne .= "<td class='shorttd'><a href='activation.php?num=" . $infos['idu'] . "&ac=0'>Actif</a></td>";
				}
				if ($infos['admin'] == 0) {
					$ligne .= "<td class='shorttd'><a href='activation.php?num=" . $infos['idu'] . "&ad=1'>Rédacteur</a></td>";
				} else {
					$ligne .= "<td class='shorttd'><a href='activation.php?num=" . $infos['idu'] . "&ad=0'>Administrateur</a></td>";
				}
				$ligne .= "</tr>";
				echo $ligne;
			}
			echo "</table>";
		}
		mysqli_close($link);
		?>
		<a href="../">Accueil</a>
	</div>
</body>

</html>