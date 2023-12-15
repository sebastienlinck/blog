<!doctype html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<title>Inscription</title>
	<link rel="stylesheet" href="../css/style.css">
	<script src="../js/scripts.js"></script>
</head>

<body>
	<div id="page">
		<a href="../">Accueil</a>
		<h1>Inscription</h1>
		<form method="post">
			<label>Nom : </label><input type="text" name="lastname" required><br>
			<label>Prénom : </label><input type="text" name="firstname" required><br>
			<label>Courriel : </label><input type="email" name="email1" id="email1" required onkeyup="verif('email1','email2')"><br>
			<label>Confirmation courriel : </label><input type="email" name="email2" id="email2" required onkeyup="verif('email1','email2')"><br>
			<label>Mot de passe : </label><input type="password" name="pwd1" id="pwd1" required onkeyup="verif('pwd1','pwd2')"><br>
			<label>Confirmation mot de passe : </label><input type="password" name="pwd2" id="pwd2" required onkeyup="verif('pwd1','pwd2')"><br>
			<input type="submit" name="inscription" value="Inscription"><br>
		</form>
		<?php
		if (isset($_REQUEST['inscription'])) {
			include('../config/bdd.php');
			include('../config/tools.php');
			$link = mysqli_connect(SERVEUR, LOGIN, MDP, BASE);
			$lastname = nettoyage($link, $_REQUEST['lastname']);
			$firstname = nettoyage($link, $_REQUEST['firstname']);
			$email1 = nettoyage($link, $_REQUEST['email1']);
			$email2 = nettoyage($link, $_REQUEST['email2']);
			$pwd1 = $_REQUEST['pwd1'];
			$pwd2 = $_REQUEST['pwd2'];
			if (($pwd1 == $pwd2) and ($email1 == $email2)) {
				$req = "SELECT * FROM users";
				$res = mysqli_query($link, $req);
				if (!$res) {
					echo "Erreur SQL: $req<br>" . mysqli_error($link);
				} else {
					$first_user = 0;
					if (mysqli_num_rows($res) == 0) {
						$first_user = 1;
					}
				}
				$req = "SELECT * FROM users WHERE email='$email1'";
				$res = mysqli_query($link, $req);
				if (!$res) {
					echo "Erreur SQL: $req<br>" . mysqli_error($link);
				} else {
					$existe = mysqli_num_rows($res);
					if (($existe == 0) and ($pwd1 == $pwd2)) {
						$pwd = password_hash($pwd1, PASSWORD_DEFAULT);
						$req = "INSERT INTO users VALUES(NULL,'$firstname','$lastname','$email1','$pwd',$first_user,$first_user)";
						$res = mysqli_query($link, $req);
						if (!$res) {
							echo "Erreur SQL: $req<br>" . mysqli_error($link);
						} else {
							echo "Inscription réussie<br>";
						}
					} else {
						echo "Adresse email déjà utilisée<br>";
					}
				}
			} else {
				echo "Les mots de passe ou les courriels sont différents<br>";
			}
			mysqli_close($link);
		}
		?>
	</div>
</body>

</html>