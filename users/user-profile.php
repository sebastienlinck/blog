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
		<script src="../js/scripts.js"></script>
	</head>
	<body>
		<div id="page">
			<h1>Mon profil utilisateur</h1>
			<?php
				include('../config/bdd.php');				
				include('../config/tools.php');
				$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);
				$idu=$_SESSION['idu'];
				if(isset($_REQUEST['modifier']))
				{
					$lastname= nettoyage($lien, $_REQUEST['lastname']);
					$firstname= nettoyage($lien, $_REQUEST['firstname']);
					$email1= nettoyage($lien, $_REQUEST['email1']);
					$email2= nettoyage($lien, $_REQUEST['email2']);
					$pwd1= $_REQUEST['pwd1'];
					$pwd2= $_REQUEST['pwd2'];
					
					if (($email1==$email2) and ($pwd1==$pwd2))
					{
						$req="SELECT * FROM users WHERE email='$email1'";
						$res=mysqli_query($lien,$req);
						if(!$res)
						{
							echo "Erreur SQL: $req<br>".mysqli_error($lien);
						}
						else
						{
							$existe=mysqli_num_rows($res);
							$infos=mysqli_fetch_array($res);
							if ((($existe==0) or (($existe==1) and ($email1==$infos['email']))) and ($pwd1==$pwd2))
							{
								if ($pwd1=="")
								{
									$req="UPDATE users SET firstname='$firstname', lastname='$lastname', email='$email1' WHERE idu=$idu";
								}
								else 
								{
									$pwd=password_hash($pwd1,PASSWORD_DEFAULT);
									$req="UPDATE users SET firstname='$firstname', lastname='$lastname', email='$email1', pwd='$pwd' WHERE idu=$idu";
								}
								$res=mysqli_query($lien,$req);
								if(!$res)
								{
									echo "Erreur SQL: $req<br>".mysqli_error($lien);
								}
								else
								{
									echo "Profil modifié<br>";
									$_SESSION['idu']=$infos['idu'];
									$_SESSION['lastname']=$infos['lastname'];
									$_SESSION['firstname']=$infos['firstname'];
									$_SESSION['email']=$infos['email'];
									$_SESSION['admin']=$infos['admin'];
								}
							}
							else 
							{
								echo "Courriel déjà utilisé<br>";
								}
							}	
						}
						else
						{
							echo "Les mots de passe ou les courriels sont différents<br>";
						}
						
					}
					$req="SELECT * FROM users WHERE idu=$idu";
					$res=mysqli_query($lien,$req);
					if(!$res)
					{
						echo "Erreur SQL: $req<br>".mysqli_error($lien);
					}
					else
					{
						$infos=mysqli_fetch_array($res);
						
					?>
					<form method="post" enctype="multipart/form-data">
						<label>Nom : </label><input type="text" name="lastname" value="<?php echo $infos['lastname'];?>"><br>
						<label>Prénom : </label><input type="text" name="firstname" value="<?php echo $infos['firstname'];?>"><br>
						<label>Courriel : </label><input type="text" name="email1" id="email1" value="<?php echo $infos['email'];?>" onkeyup="verif('email1','email2')"><br>
						<label>Confirmation courriel : </label><input type="text" name="email2" id="email2" value="<?php echo $infos['email'];?>" onkeyup="verif('email1','email2')"><br>
						<label>Mot de passe : </label><input type="password" name="pwd1" id="pwd1" onkeyup="verif('pwd1','pwd2')"><br>
						<label>Confirmation mot de passe : </label><input type="password" name="pwd2" id="pwd2" onkeyup="verif('pwd1','pwd2')"><br>
						<input type="submit" name="modifier" value="Modifier mes informations"><br>
					</form>
					<?php
					}
					mysqli_close($lien);
				?>
				<a href="../">Accueil</a>
			</div>
		</body>
	</html>		