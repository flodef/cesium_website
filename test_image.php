<?php
$p = "i18n/fr_FR/contents/tuto/modifier-temps-avant-deconnexion.png";

// header("Content-type: image/png");
header('Content-Length: '. filesize("./" . $p));

// $img = imagecreatefrompng($p);
// $img = imagecreatefrompng($tutoContentsPath . $subpage) OR DIE("ERREUR");

// imagepng($img);
// fopen("i18n/fr_FR/contents/tuto/parametres.png") or die("erreur");
readfile("./" . $p);