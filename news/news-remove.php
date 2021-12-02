<?php
	session_start();
	if(!isset($_SESSION['idu']) or !isset($_SESSION['lastname']) or !isset($_SESSION['firstname']) or !isset($_SESSION['email']))
	{
		header("Location: ../index.php");
		exit;
	}
	else
	{
		include('../config/bdd.php');
		include('../config/tools.php');
		$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);
		$num=nettoyage($lien,$_REQUEST['num']);
		
		$req="SELECT * FROM actus WHERE idn=$num";
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
			if($infos['image']!="")
			{
				unlink($infos['image']);
			}
		}
		
		$req="DELETE FROM actus WHERE idn=$num";
		$res=mysqli_query($lien,$req);	
		if(!$res)
		{
			echo "Erreur SQL: $req<br>".mysqli_error($lien);
		}
		else
		{
			mysqli_close($lien);
			header("Location: ../index.php");
		}
	}
?>