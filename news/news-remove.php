<?php
session_start();
if (!isset($_SESSION['idu']) or !isset($_SESSION['lastname']) or !isset($_SESSION['firstname']) or !isset($_SESSION['email'])) {
	header("Location: ../index.php");
	exit;
} else {
	include('../config/bdd.php');
	include('../config/tools.php');
	$link = mysqli_connect(SERVEUR, LOGIN, MDP, BASE);
	$num = nettoyage($link, $_REQUEST['num']);
	$req = "SELECT * FROM news WHERE idn=$num";
	$res = mysqli_query($link, $req);
	if (!$res) {
		echo "Erreur SQL: $req<br>" . mysqli_error($link);
	} else {
		$infos = mysqli_fetch_array($res);
		if (($infos['author'] != $_SESSION['idu']) and ($_SESSION['admin'] == 0)) {
			mysqli_close($link);
			header("Location: ../index.php");
			exit;
		}
		if ($infos['image'] != "") {
			unlink($infos['image']);
		}
		$req = "DELETE FROM news WHERE idn=$num";
		$res = mysqli_query($link, $req);
		if (!$res) {
			echo "Erreur SQL: $req<br>" . mysqli_error($link);
		} else {
			mysqli_close($link);
			header("Location: ../index.php");
			exit;
		}
	}
}
