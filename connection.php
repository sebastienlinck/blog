<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>TP2_users</title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div id="page">
			<h1>Page de connexion</h1>
			<form method="post">
				<label>Email : </label><input type="email" name="email"><br>
				<label>Mot de passe : </label><input type="password" name="pwd"><br>
				<input type="submit" name="connexion" value="Connexion"><br>
			</form>
			<?php
				if(isset($_REQUEST['connexion']))
				{
					include('./config/bdd.php');
					include('./config/tools.php');
					$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);
					$email=nettoyage($lien,$_REQUEST['email']);
					$pwd=$_REQUEST['pwd'];
					$req="SELECT * FROM users WHERE email='$email'";
					$res=mysqli_query($lien,$req);
					if(!$res)
					{
						echo "Erreur SQL: $req<br>".mysqli_error($lien);
					}
					else
					{
						$existe=mysqli_num_rows($res);
						if($existe== 0){
							echo "Informations incorrectes";
						}
						else {
							$infos=mysqli_fetch_array($res);
							if(password_verify($pwd,$infos['pwd']) and ($infos['active']== 1)) 
							{
								session_start();
								$_SESSION['idu']=$infos['idu'];
								$_SESSION['lastname']=$infos['lastname'];
								$_SESSION['firstname']=$infos['firstname'];
								$_SESSION['email']=$infos['email'];
								$_SESSION['admin']=$infos['admin'];
								mysqli_close($lien);
								header("Location: ./index.php");
							}
							else 
							{ 
								echo "Informations incorrectes";
							}
						} 
					}
					mysqli_close($lien);
				}
			?>	
		</div>
	</body>
</html>	