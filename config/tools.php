<?php
function nettoyage($lien, $texte)
{
	return trim(htmlentities(mysqli_real_escape_string($lien, $texte)));
}
function pagination($parpage, $page, $pagephp, $table, $lien)
{
	$req = "SELECT COUNT(*) as nb FROM $table";
	$res = mysqli_query($lien, $req);
	if (!$res) {
		echo "Erreur SQL:$req<br>" . mysqli_error($lien);
	} else {
		$nb = mysqli_fetch_array($res)['nb'];
		$nbpages = ceil($nb / $parpage);
		echo "<br> Pages : ";
		echo "<a href='$pagephp.php?page=1'> Début </a>";
		if (($page - 1) >= 1) {
			echo "<a href='$pagephp.php?page=" . ($page - 1) . "'> Précédente </a>";
		}
		for ($i = ($page - 3); $i <= ($page + 3); $i++) {
			if (($i > 0) and ($i <= $nbpages)) {
				if ($i != $page) {
					echo "<a href='$pagephp.php?page=$i'> $i </a>";
				} else {
					echo $i;
				}
			}
		}
		if (($page + 1) <= ($nbpages - 1)) {
			echo "<a href='$pagephp.php?page=" . ($page + 1) . "'> Suivante </a>";
		}
		echo "<a href='$pagephp.php?page=$nbpages'> Fin </a>";
	}
}
